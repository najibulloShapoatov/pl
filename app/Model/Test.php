<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Test extends Model
{
    protected $fillable = [
        'id',
        'facult_id',
        'course_id',
        'subject_id',
        'user_id',
        'test_timer',
        'check_point',
        'is_active',
    ];



    public function faculty(){
        return $this->belongsTo('App\Model\Faculty', 'facult_id');
    }
    public function course(){
        return $this->belongsTo('App\Model\Cafedra');
    }
    public function subject(){
        return $this->belongsTo('App\Model\Subject');
    }

    public function user(){
        return $this->belongsTo('App\Model\User');
    }

    public function questions(){
        return $this->hasMany('App\Model\TestQuestion');
    }
    public function results(){
        return $this->hasMany('App\Model\TestResult');
    }


    public function getByID($id)
    {
        return $this->where(['id' => $id])->orderBy('created_at', 'desc')->get()->first();
    }

    public function getList(){
        return $this->where(['is_active' => 1])->orderBy('created_at', 'desc')->get();
    }
    public function getListByUserID($UserID){
        return $this->where(['user_id' => $UserID])->orderBy('created_at', 'desc')->get();
    }

    public function resultTest($input)
    {
        $testID = trim(htmlspecialchars($input['test_id']));
        $questions = trim(htmlspecialchars($input['questions']));
        $userAnswers = trim(htmlspecialchars($input['answers']));

        $quesArr = explode(',', $questions);
        $answArr = explode(',', $userAnswers);

        $testData = $this->getByID($testID);

        $checkpoint = 100/count($quesArr);
        $point = 0;
        foreach($answArr as $answer) {
            if($answer != ''){
                $testAnswer = TestAnswer::where('id', $answer)->get()->first();
                if($testAnswer->is_true == 1) {
                    $point+= $checkpoint;
                }
            }
        }

        if(Auth::check()) {
            // save user test result
            $sts = $point > $testData->check_point;
            $testRes = new TestResult();
            $testRes->saveUserTestResult(Auth::user()->id, $testID, $sts);
        }

        return [
            'point' => $point,
            'checkpoint' => $testData->check_point
        ];



    }


    public function addTestQuestions(Request $request )
    {
        $input = $request->all();
        $facultID = trim(htmlspecialchars($input['fID']));
        $cafedraID = trim(htmlspecialchars($input['cID']));
        $lang = trim(htmlspecialchars($input['lang']));
        $subject = trim(htmlspecialchars($input['subj']));
        $hasExample = trim(htmlspecialchars($input['hasExample']));
        if($hasExample == 1) {
            $checkpoint = trim(htmlspecialchars($input['checkpoint']));
            $test_timer = trim(htmlspecialchars($input['test_timer']));
            //$questions = trim(htmlspecialchars($input['questions']));
            $questions = $input['questions'];
            $questArray = json_decode($questions);
        }
        $test = new Test();
        $test->user_id = Auth::user()->id;
        $test->facult_id = $facultID;
        $test->cafedra_id = $cafedraID;
        $test->lang = $lang;
        $test->subject = $subject;
        $test->has_example = $hasExample;
        $test->is_active = 1;
        $test->save();



        $path = public_path('uploads/tests/' . $test->id . '/' );
        if ($file = $request->file('file')) {
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }

            $myfile = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '_' . uniqid() . '.' . $extension;
            $myfile->move($path, $fileName);

            $test->file = $fileName;
            $result = $test->save();

        }


        if($hasExample == 1) {
            $test->test_timer = $test_timer;
            $test->check_point = $checkpoint;
            $test->save();
            foreach ($questArray as $question) {
                $testQ = new TestQuestion();
                $testQ->test_id = $test->id;
                $testQ->title = $question->title;
                $testQ->save();
                if ($question->image) {
                    $path = public_path('/uploads/test/' . $test->id);
                    if (!is_dir($path)) {
                        mkdir($path, 0777, true);
                    }
                    if (File::exists(public_path('/temp/' . $question->image))) {
                        File::move(public_path('/temp/' . $question->image), $path . '/' . $question->image);
                        File::delete(public_path('/temp/' . $question->image));
                        $testQ->image = $question->image;
                        $testQ->save();

                    }
                }
                foreach ($question->answers as $ans) {
                    $testA = new TestAnswer();
                    $testA->test_question_id = $testQ->id;
                    $testA->title = $ans;
                    if ($question->is_true == $ans) {
                        $testA->is_true = 1;
                    }
                    $testA->save();
                }
            }
        }

        return true;

    }


    //remove test
    public static function deleteTest($id)
    {
        $test = Test::where(['id' => $id, 'user_id' => Auth::user()->id])->get()->first();

        //$test->questions()->answers()->delete();
        foreach ($test->questions as $q){
            $q->answers()->delete();
        }
        $test->questions()->delete();
        $test->results()->delete();
        if (is_dir('public/uploads/tests/' . $test->id)) {
            File::deleteDirectory(public_path('uploads/tests/' . $test->id));
        }
        $test->delete();

    }

    //get By Filter
    public function getByFilter( $facult_id, $cafedra_id)
    {/*
        return $this->where('facult_id', 'like', '%'.$facID.'%')
            ->orWhere('course_id', 'like', '%'.$couID.'%')
            ->orWhere('subject_id', 'like', '%'.$subID.'%')
            ->orderBy('tests.created_at', 'desc')
            ->get();*/
        if(empty($cafedra_id)) {
            return $this->where('facult_id', $facult_id)->orderBy('subject', 'asc')->get();
        }else{
            return $this->where('cafedra_id', $cafedra_id)->orderBy('subject', 'asc')->get();
        }
    }


    //save edited testData
    public function saveEditingTest( $request)
    {
        $input = $request->all();
        $testID = trim(htmlspecialchars($input['test_id']));
        /*$facultID = trim(htmlspecialchars($input['facult_id']));
        $courseID = trim(htmlspecialchars($input['course_id']));*/
        //$subjectID = trim(htmlspecialchars($input['subject_id']));
        $checkpoint = trim(htmlspecialchars($input['checkpoint']));
        $test_timer = trim(htmlspecialchars($input['test_timer']));

        if($testID &&  $checkpoint && $test_timer) {
            $test = Test::where(['id' => $testID, 'user_id' => Auth::user()->id])->get()->first();
            /*$test->facult_id = $facultID;
            $test->course_id = $courseID;*/
            //$test->subject_id = $subjectID;
            $test->user_id = Auth::user()->id;
            $test->test_timer = $test_timer;
            ($checkpoint > 100)? $checkpoint = 100 : $checkpoint;
            $test->check_point = $checkpoint;
            $test->is_active = 1;
            $test->has_example = 1;
             return $test->save();
        }
    }
}

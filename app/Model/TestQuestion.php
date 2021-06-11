<?php

namespace App\Model;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class TestQuestion extends Model
{
    protected $fillable = [
        'test_id',
        'title',
        'image',

    ];

    public function answers(){
        return $this->hasMany('App\Model\TestAnswer');
    }

    public function addTestQuestions(Request $request)
    {
        $input = $request->all();
        $testID = trim(htmlspecialchars($input['test_id']));
        $qID = trim(htmlspecialchars($input['question_id']));
        $title = trim(htmlspecialchars($input['title']));
        $is_true = trim(htmlspecialchars($input['is_true_text']));

        $answer = $input['answers'];
        $ansArray = json_decode( $answer);

        $test_question = TestQuestion::where(['id' => $qID, 'test_id' => $testID])->get()->first();

        $test_question->title = $title;
        $test_question->save();
        if($file = $request->file('file')) {
            $path = public_path('/uploads/test/' . $testID);
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
            if(File::exists($path . '/' . $test_question->image)) {
                File::delete($path . '/' . $test_question->image);
            }
            $image = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $imageName = time() . '_' . uniqid() . '.' . $extension;
            $img = Image::make($image);
            $img->save($path . '/' . $imageName);
            $img->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            $test_question->image = $imageName;

            $result = $test_question->save();
        }
        foreach ($ansArray as $ans){
            if($ans->id == 0){
                $testA = new TestAnswer();
                $testA->test_question_id =$qID;
            }else{
                $testA = TestAnswer::where(['id' => $ans->id])->get()->first();
            }
            $testA->title = $ans->title;
            if($testA->title == $is_true){
                $testA->is_true = 1;
            }
            else{
                $testA->is_true = 0;
            }
            $testA->save();

        }
        return true;




    }

    public function removeAns( $questID,  $testID)
    {
        $testQues = TestQuestion::where(['id' => $questID, 'test_id' => $testID])->get()->first();
        $path = public_path('/uploads/test/' . $testID);
        if(File::exists($path . '/' . $testQues->image)) {
            File::delete($path . '/' . $testQues->image);
        }
        $testQues->answers()->delete();
         return $testQues->delete();
    }

    public function saveQuestionNewEditingTest(Request $request)
    {

        $input = $request->all();
        $testID = trim(htmlspecialchars($input['test_id']));
        $title = trim(htmlspecialchars($input['title']));
        $is_true = trim(htmlspecialchars($input['is_true_text']));

        $answer = $input['answers'];
        $ansArray = json_decode( $answer);

        $test_question = new TestQuestion();
        $test_question->test_id = $testID;
        $test_question->title = $title;
        $test_question->save();

        if($file = $request->file('file')) {
            $path = public_path('/uploads/test/' . $testID);
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
            if(File::exists($path . '/' . $test_question->image)) {
                File::delete($path . '/' . $test_question->image);
            }
            $image = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $imageName = time() . '_' . uniqid() . '.' . $extension;
            $img = Image::make($image);
            $img->save($path . '/' . $imageName);
            $img->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            $test_question->image = $imageName;

            $result = $test_question->save();
        }

        foreach ($ansArray as $item){

            $testA = new TestAnswer();
            $testA->test_question_id = $test_question->id;
            $testA->title = $item;
            if($testA->title == $is_true){
                $testA->is_true = 1;
            }
            else{
                $testA->is_true = 0;
            }
            $testA->save();
        }

        return true;

    }


}

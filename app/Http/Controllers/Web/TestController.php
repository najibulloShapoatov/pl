<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Cafedra;
use App\Model\Course;
use App\Model\Faculty;
use App\Model\Subject;
use App\Model\Test;
use App\Model\TestAnswer;
use App\Model\TestQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Intervention\Image\Facades\Image;

class TestController extends Controller
{
    //Home test
    public function  index(){

        $faculty = Faculty::get();
        $course = Course::get();
        $subject = Subject::get();

        $tests = new Test();
         $test = $tests->getList();


        return view('web.testing.index', compact([
            'faculty',
            'course',
            'subject',
            'test',
        ]));

    }

    //my Test
    public function  myTests(){

        if (Auth::check() &&( Auth::user()->role->id == 2 || Auth::user()->role->id == 1)) {
            $tests = new Test();
            $test = $tests->getListByUserID(Auth::user()->id);
            return view('web.testing.my-tests', compact([
                'test',
            ]));
        }
        return redirect('/testing');
    }

    //single test
    public function  test($id){

        $testing = new Test();
        $testData = $testing->getByID($id);

        return view('web.testing.test', compact([
            'testData',

        ]));
    }

    //add test page
    public function addTest(){

        $faculty = (new Faculty())->getList();
        //$cafedra = Cafedra::get();
        //$subject = Subject::get();


        return view('web.testing.add-test', compact([
            'faculty',
        ]));
    }

    public function getCafs($id){
        $data = (new Cafedra())->getByFacultID($id);
        $html = View::make('web.testing._cafedras', compact('data'))->render();
        return Response::json( $html,200);
    }

    //result
    public function resultTest(Request $request)
    {
        if( $request->ajax() )
        {
            $input = $request->all();
            $test = new Test();
            $result = $test->resultTest($input);
            return response()->json($result, 200);
        }
    }

    //upload test image in temp folder
    public function uploadImageTemp(Request $request)
    {
        if( $request->ajax() )
        {
            $input = $request->all();

            $result = false;
            if($file = $request->file('file')) {
                $path = public_path('/temp' ) ;

                $imageTemp = $request->file('file');
                $extension = $file->getClientOriginalExtension();
                $imageName = time() . '_' . uniqid() . '.' . $extension;

                $img = Image::make($imageTemp);
                $result = $img->save($path . '/' . $imageName);
                $img->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $result = $imageName;
            }



            return response()->json($result, 200);
        }
    }


    //add test in db
    public function addTestQuestions(Request $request)
    {
        if( $request->ajax() )
        {
            $result = (new Test())->addTestQuestions($request);

            return response()->json($result, 200);
        }
    }

    //remove test
    public function deleteTest($id){
        if (Auth::check() &&( Auth::user()->role->id == 2 || Auth::user()->role->id == 1)) {
            Test::deleteTest($id);
            return redirect('/my-tests');
        }
    }


    //Home Filter test
    public function  filterTest(Request $request){



        $input = $request->all();
        $tests = new Test();

        $facID = trim(htmlspecialchars($input['f_id']));
        $cafID = trim(htmlspecialchars($input['c_id']));

        $test = $tests->getByFilter($facID, $cafID);

        $html = View::make('web.testing._filter', compact('test'))->render();
        return Response::json(['html' => $html, 'info' => $test], 200);
    }


    //edit test page
    public function editTest($id){
        if (Auth::check() &&( Auth::user()->role->id == 2 || Auth::user()->role->id == 1)) {



            $faculty = Faculty::get();
            $course = Course::get();
            $subject = Subject::get();

            $testing = new Test();
            $testData = $testing->getByID($id);

            return view('web.testing.edit-test', compact([
                'testData',
                'faculty',
                'course',
                'subject',
            ]));
        }
        return redirect('/');
    }

    //save edited question
    public function saveQuestTest(Request $request){
        if (Auth::check() &&( Auth::user()->role->id == 2 || Auth::user()->role->id == 1)) {

            $testQuestion = new TestQuestion();
            $result = $testQuestion->addTestQuestions($request);

            return response()->json($result, 200);

        }
        return redirect('/');
    }

 //save edited question
    public function removeVariantTest(Request $request){
        if (Auth::check() &&( Auth::user()->role->id == 2 || Auth::user()->role->id == 1)) {

            $input = $request->all();
            $answerID =  trim(htmlspecialchars($input['ans_id']));
            $testQuestion = new TestAnswer();
            $result = $testQuestion->removeAns($answerID);
            return response()->json($result, 200);

        }
        return redirect('/');
    }

    //remove question in edited page
    public function removeQuestionTest(Request $request){

        if (Auth::check() &&( Auth::user()->role->id == 2 || Auth::user()->role->id == 1)) {

            $input = $request->all();
            $questID =  trim(htmlspecialchars($input['que_id']));
            $tID =  trim(htmlspecialchars($input['test_id']));
            $testQuestion = new TestQuestion();
            $result = $testQuestion->removeAns($questID, $tID);
            return response()->json($result, 200);

        }
        return redirect('/');
    }

    //save new question in editing page
    public function saveQuestionNewEditingTest(Request $request){

        if (Auth::check() &&( Auth::user()->role->id == 2 || Auth::user()->role->id == 1)) {

            $testQuestion = new TestQuestion();
            $result = $testQuestion->saveQuestionNewEditingTest($request);

            return response()->json($result, 200);

        }
        return redirect('/');
    }

    //save Edited Test
     public function saveEditingTest(Request $request){

            if (Auth::check() &&( Auth::user()->role->id == 2 || Auth::user()->role->id == 1)) {

                $test = new Test();
                $result = $test->saveEditingTest($request);

                return response()->json($result, 200);

            }
            return redirect('/');
    }


}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class TodoController extends Controller
{
    public function index(){
        if(Auth::check()){
            $todo = new Todo();
            $tasks = $todo->getUserTasks(Auth::user()->id);
            //print_r($tasks);
            return view('web.todo.index', compact([
                'tasks'
            ]));
        }
        return redirect('/');
    }

    public function changeStatus(Request $request)
    {
        if ($request->ajax())
        {
            $input = $request->all();
            $taskID = trim(htmlspecialchars($input['task_id']));
            $status = trim(htmlspecialchars($input['status']));

            $todo = new Todo();
            $sts = $todo->changeTaskStatus(Auth::user()->id, $taskID, $status);
            return Response::json(['sts' => $sts], 200);
        }
    }

    public function changeContent(Request $request)
    {
        if ($request->ajax())
        {
            $input = $request->all();
            $taskID = trim(htmlspecialchars($input['task_id']));
            $content = trim(htmlspecialchars($input['content']));

            $todo = new Todo();
            $result = $todo->changeTaskContent(Auth::user()->id, $taskID, $content);
            return Response::json( $result);
        }
    }

    public function removeTask(Request $request)
    {
        if ($request->ajax())
        {
            $input = $request->all();
            $taskID = trim(htmlspecialchars($input['task_id']));

            $todo = new Todo();
            $sts = $todo->removeTask(Auth::user()->id, $taskID);
            return Response::json(['sts' => $sts], 200);
        }
    }

    public function addTask(Request $request)
    {
        if ($request->ajax())
        {
            $input = $request->all();
            $content = trim(htmlspecialchars($input['content']));

            $todo = new Todo();
            $taskID = $todo->addTask(Auth::user()->id, $content);
            return Response::json(['id' => $taskID], 200);
        }
    }
}

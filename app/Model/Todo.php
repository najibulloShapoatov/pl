<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [
        'user_id',
        'content',
        'status',
    ];

    // get user task list
    public function getUserTasks($userID)
    {
        return $this->where('user_id', $userID)->orderBy('created_at', 'desc')->get();
    }

    // change task status
    public function changeTaskStatus($userID, $taskID, $status)
    {
        $task = $this->where(['user_id' => $userID, 'id' => $taskID])->get()->first();
        $task->status = $status;
        $result = $task->save();
        if($result){
            return true;
        }
    }

    // change task status
    public function changeTaskContent($userID, $taskID, $content)
    {
        $task = $this->where(['user_id' => $userID, 'id' => $taskID])->get()->first();
        $task->content = $content;
        $result = $task->save();
        if($result){
            $new_task = ['id' => $task->id, 'content' => $task->content];

            return $new_task;
        }
    }

    //Remove Task
    public function removeTask($userID,  $taskID)
    {
        $task = $this->where(['user_id' => $userID, 'id' => $taskID])->get()->first();
        $result = $task->delete();
        if($result){
            return true;
        }
    }

    public function addTask($userID,  $content)
    {
        $task = new Todo();
        $task->user_id = $userID;
        $task->content = $content;
        $result = $task->save();
        if($result){
            return $task->id;
        }
    }
}

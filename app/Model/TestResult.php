<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    // fillible


    public function saveUserTestResult($userID, $testID, $status)
    {
        $res = $this->where(['user_id' => $userID, 'test_id' => $testID])->exists();

        if($res){
           $testResult = $this->where(['user_id' => $userID, 'test_id' => $testID])->get()->first();
           if($status) {
               $testResult->status = 1;
            }
           else{
               $testResult->status = 2;
           }
            $testResult->save();
        }
        else{

            $testResult = new TestResult();
            $testResult->user_id =$userID;
            $testResult->test_id =$testID;
            if($status) {
                $testResult->status = 1;
            }
            else{
                $testResult->status = 2;
            }
            $testResult->save();
        }
    }
}

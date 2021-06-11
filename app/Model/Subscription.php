<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'email'
    ];

    public function subscribe($email)
    {
        if(!empty($email) || $email != ''){
            if(filter_var($email, FILTER_VALIDATE_EMAIL) !== false){
                // valid email
                $res = $this->where('email', $email)->get()->first();
                if(!empty($res)){
                    // exists
                    return __('lang.you_have_subscription');
                }
                else{
                    // add email
                    $subs = new Subscription();
                    $subs->email = $email;
                    $subs->save();
                    return __('lang.you_subscribe_succesfully');
                }
            }
            else{
                // error email
                return __('lang.enter_correct_email');
            }
        }
        else{
            // empty email
            return __('lang.enter_email');
        }
    }
}

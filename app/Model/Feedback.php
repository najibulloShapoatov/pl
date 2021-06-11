<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;


class Feedback extends Model
{
    protected $fillable = [
        'email_phone',
        'topic',
        'to_whom',
        'text',
    ];



    public function createFeedback( $input)
    {
        $fio = htmlspecialchars($input['fio']);
        $em_phone = htmlspecialchars($input['email_phone']);
        $topic = htmlspecialchars($input['topic']);
        //$fac = htmlspecialchars($input['faculty-feed']);
        $fed_to = htmlspecialchars($input['fed-to']);
        $text = htmlspecialchars($input['text']);



        $data = array(
            'name' => $fio,
            'email'=> $em_phone,
            'topic' => $topic,
            'message' => $text
        );
        if($fed_to == 'admin' || $fed_to == 'booker'){
            if ($fed_to == 'admin'){
                $to_name = 'Админстратор';
                $to_email = ((new SiteProperty())->getByPropName('ADMIN_EMAIL'))->prop_value;
            }
            elseif ($fed_to == 'booker'){
                $to_name = 'Библиотекар';
                $to_email = ((new SiteProperty())->getByPropName('BOOKER_EMAIL'))->prop_value;
            }
        }
        else {
            $fedTo = (new FedbackTo())->getByID($fed_to);
            $to_name = $fedTo->name;
            $to_email = $fedTo->email;
        }
       $subject = $topic;
       Mail::send('mail.mail-template', compact(['data']), function($message) use ($subject, $to_name, $to_email) {
           $message->to($to_email, $to_name)->subject($subject);
           $message->from('tspuportal@gmail.com','TSPU PORTAL');
       });





        $feed = new Feedback();

        $feed->fio = $fio;
        $feed->email_phone = $em_phone;
        $feed->topic = $topic;
        $feed->to_whom = $fed_to;
        $feed->text = $text;

        $feed->save();

        return $feed;



    }

    public function getListAdm()
    {
        return $this->orderBy('updated_at', 'desc')->paginate(20);
    }

    public function getById($id)
    {
        return $this->where('id', $id)->get()->first();
    }

    public function removeFeedback($ID)
    {
        $feed = $this->getById($ID);
       return $feed->delete();
    }
}

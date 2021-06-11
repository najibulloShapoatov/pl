<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Model\Subscription;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{

    // subscribtion
    public function subscribe(Request $request)
    {
        if ($request->ajax()) {
            $input = $request->all();
            $email = trim(htmlspecialchars($input['email']));

            $subs = new Subscription();
            $result = $subs->subscribe($email);

            return response()->json(array('msg' => $result), 200);
        }
    }

}

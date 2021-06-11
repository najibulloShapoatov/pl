<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SiteCustomization extends Model
{
    //


    public function getListAdm()
    {
        return $this->orderBy('created_at', 'desc')->get()->first();
    }

    public static function saveEdit(Request $request)
    {
        $input = $request->all();

        $id = htmlspecialchars($input['id']);
        $name = htmlspecialchars($input['name']);
        $adres = htmlspecialchars($input['adres']);
        $phone = htmlspecialchars($input['phone']);
        $email = htmlspecialchars($input['email']);
        $fl = htmlspecialchars($input['fl']);
        $il = htmlspecialchars($input['il']);
        $yl = htmlspecialchars($input['yl']);

        $s_c = SiteCustomization::where('id', $id)->get()->first();
        $s_c->name =$name;
        $s_c->adress = $adres;
        $s_c->phone_no = $phone;
        $s_c->email = $email;
        $s_c->facebook_link = $fl;
        $s_c->instagram_link = $il;
        $s_c->youtube_link = $yl;

        return $s_c->save();

    }

}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VebinarController extends Controller
{
    public function index(){

        return view('web.vebinar.index');
    }
}

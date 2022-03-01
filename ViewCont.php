<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewCont extends Controller
{
    function index(){
        return view('home');
    }

    function CommingSoon(){
        return view('CommingSoon');
    }

    function contactUs(){
        return view('ContactUs');
    }
}

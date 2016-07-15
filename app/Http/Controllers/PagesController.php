<?php

namespace App\Http\Controllers;



use App\Http\Requests;


class PagesController extends Controller
{
    public function aboutme ()
    {
        return view ('aboutme');
    }

    public function welcome ()
    {
        return view ('welcome');
    }
    //
}

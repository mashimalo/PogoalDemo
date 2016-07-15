<?php

namespace App\Http\Controllers\Photo;


use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\PhotoAlbum;
use App\Http\Requests\PhotoRequest;
use App\Http\Requests\DeleteRequest;
use App\Http\Requests\ReorderRequest;
//use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PhotoController extends Controller
{

    public function __construct()
    {
        view()->share('type', 'photo');
    }

}

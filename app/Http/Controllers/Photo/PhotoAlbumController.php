<?php

namespace App\Http\Controllers\Photo;

use App\Models\Profile;
//use Auth;
use App\Http\Requests;
use App\Models\user;
use App\Http\Controllers\Controller;
use App\Models\PhotoAlbum;
use App\Models\Photo;
use App\Http\Controllers;
use App\Http\Requests\PhotoAlbumRequest;
use App\Http\Requests\AlbumUploadPhotoRequest;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepository;
use App\Repositories\ProfileRepository;
use App\Repositories\AlbumRepository;

class PhotoAlbumController extends Controller
{

    /**
     * constructor
     */
    public function __construct(
        UserRepository $user_repository,
        ProfileRepository $profile_repository,
        AlbumRepository $album_repository
    )
    {
        $this->user_repository = $user_repository;
        $this->profile_repository = $profile_repository;
        $this->album_repository = $album_repository;
        view()->share('type', 'photoalbum');
    }

    /**
     * @param $string
     * @return mixed
     */
    public function getUserIdBaseOnNickname($target_nickname){

        $target_user_id = Profile::wherenickname($target_nickname) ->firstOrFail() ->user_id;

        return $target_user_id;
    }

    /**
     * @param $target_user_role_id
     * @return mixed
     */
    public function getUserRoleIdBaseOnUserId($target_user_id){

        $target_user_role_id = User::whereid($target_user_id)->firstOrFail() -> role_id;

        return $target_user_role_id;
    }

    /**
     * @param $target_user_id
     * @return mixed
     */

    public function getUserByUserId($target_user_id)
    {
        return User::with('profile')->whereid($target_user_id)->firstOrFail();
    }

    /**
     * @param $target_user_id
     * @return mixed
     */

    public function getAlbumByUserid($target_user_id)
    {
        return User::with('photo_albums')->whereid($target_user_id)->firstOrFail();
    }

    /**
     * @param $photoalbum_folder_id
     * @return mixed
     */

    public function getAlbumNameByAlbumFolderId($photoalbum_folder_id)
    {
        return PhotoAlbum::wherefolder_id($photoalbum_folder_id)->firstOrFail()->name;
    }


    /**
     * show all the album in list
     *
     * @param $target_nickname
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showall($target_nickname)
    {
        try
        {
            //get the target user id base on the nickname
            $target_user_id = $this -> getUserIdBaseOnNickname($target_nickname);

            //get the user role id base on the User id
            $target_user_role_id = $this -> getUserRoleIdBaseOnUserId($target_user_id);

            // if current user is not admin or just guest can'y see admin's profile, throw user not found exception
            if (Auth::guest() && $target_user_role_id == 1)
            {
                return redirect('/')->with('error', trans('front/profile.userNotFound'));
            }
            if ($this->user_repository->getrole() != 'admin' && $target_user_role_id == 1)
            {
                return redirect('/')->with('error', trans('front/profile.userNotFound'));
            }

            $user = $this ->getUserByUserId($target_user_id);
            //$albums = $this ->getAlbumByUserid($target_user_id);

        }
        catch(ModelNotFoundException $e)
        {
            return redirect('/')->with('error', trans('front/profile.userNotFound'));
        }
        return view('pages.photos.albumPage', compact('user', 'target_user_id', 'target_nickname'));
    }

    /**
     * show photos in each album
     * @param $target_nickname
     * @param $photoalbum_id
     * @return string
     */
    public function show($target_nickname, $photoalbum_folder_id)
    {
        try {
            //get the target user id base on the nickname
            $target_user_id = $this->getUserIdBaseOnNickname($target_nickname);

            //get the user role id base on the User id
            $target_user_role_id = $this->getUserRoleIdBaseOnUserId($target_user_id);

            // if current user is not admin or just guest can'y see admin's profile, throw user not found exception
            if (Auth::guest() && $target_user_role_id == 1) {
                return redirect('/')->with('error', trans('front/profile.userNotFound'));
            }
            if ($this->user_repository->getrole() != 'admin' && $target_user_role_id == 1) {
                return redirect('/')->with('error', trans('front/profile.userNotFound'));
            }

            $user = $this->getUserByUserId($target_user_id);
            $photoalbum_name = $this->getAlbumNameByAlbumFolderId($photoalbum_folder_id);
            //$album = $this->getAlbumByUserid($target_user_id);
        } catch (ModelNotFoundException $e) {
            return redirect('/')->with('error', trans('front/profile.userNotFound'));
        }
        return view('pages.photos.photoPage', compact('user', 'target_user_id', 'target_nickname', 'photoalbum_name', 'photoalbum_folder_id'));
    }

    /**
     * create album
     *
     * @param $target_nickname
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function create($target_nickname)
    {
        try
        {
            //get the target user id base on the nickname
            $target_user_id = $this -> getUserIdBaseOnNickname($target_nickname);
            $current_user_id = Auth::user()->id;

            if ($target_user_id != $current_user_id)
            {
                return redirect('/')->with('error', trans('front/profile.notHavePermissionToEditUser'));
            }
            $user = $this ->getUserByUserId($target_user_id);

        }
        catch(ModelNotFoundException $e)
        {
            return redirect('/')->with('error', trans('front/profile.userNotFound'));
        }

        return view('pages.photos.albumCreatePage', compact('user'));
    }


    /**
     * post create album
     *
     * @param $target_nickname
     * @param PhotoAlbumRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function postCreate($target_nickname, PhotoAlbumRequest $request)
    {
        try
        {
            $target_user_id = $this -> getUserIdBaseOnNickname($target_nickname);
            $current_user_id = Auth::user()->id;

            if ($target_user_id != $current_user_id)
            {
                return redirect('/')->with('error', trans('front/profile.notHavePermissionToEditUser'));
            }
            $user = $this ->getUserByUserId($target_user_id);

            $folder_id = $this->album_repository->createAlbum($user->photo_albums, $request->all());
            $photoalbum_folder_id = $folder_id;

        }
        catch(ModelNotFoundException $e)
        {
            return redirect('/')->with('error', trans('front/profile.userNotFound'));
        }

        return redirect()->action('Photo\PhotoAlbumController@show', [$target_nickname, $photoalbum_folder_id])->with('ok', trans('front/album.createSuccessful'));
    }

    /**
     * upload photos in album
     *
     * @param $target_nickname
     * @param $photoalbum_folder_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function uploadPhoto($target_nickname, $photoalbum_folder_id, AlbumUploadPhotoRequest $request)
    {
        try {
            //get the target user id base on the nickname
            $target_user_id = $this->getUserIdBaseOnNickname($target_nickname);

            //get the user role id base on the User id
            $target_user_role_id = $this->getUserRoleIdBaseOnUserId($target_user_id);

            // if current user is not admin or just guest can'y see admin's profile, throw user not found exception
            if (Auth::guest() && $target_user_role_id == 1) {
                return redirect('/')->with('error', trans('front/profile.userNotFound'));
            }
            if ($this->user_repository->getrole() != 'admin' && $target_user_role_id == 1) {
                return redirect('/')->with('error', trans('front/profile.userNotFound'));
            }

            $current_user_id = Auth::user()->id;
            if ($target_user_id != $current_user_id)
            {
                return redirect('/')->with('error', trans('front/album.notHavePermissionToEditUser'));
            }

            $user = $this->getUserByUserId($target_user_id);

            $photoalbum_name = $this->getAlbumNameByAlbumFolderId($photoalbum_folder_id);
            //$album = $this->getAlbumByUserid($target_user_id);
        } catch (ModelNotFoundException $e) {
            return redirect('/')->with('error', trans('front/profile.userNotFound'));
        }
        dd($request->file('file'));
        return ('working on it');
        //return view('pages.photos.photoPage', compact('user', 'target_user_id', 'target_nickname', 'photoalbum_name'));

    }

}
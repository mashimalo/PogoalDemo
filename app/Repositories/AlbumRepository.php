<?php
/**
 * Created by PhpStorm.
 * User: Mashimalo
 * Date: 2016/1/10
 * Time: 20:37
 */

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\User, App\Models\Profile, App\Models\PhotoAlbum;
use Illuminate\Support\Facades\Auth;


class AlbumRepository extends BaseRepository
{
    public function __construct(
        PhotoAlbum $photoAlbum
        )
    {
        $this->photoAlbum = $photoAlbum;
    }


    /**
     * create album
     * @param $photoAlbum
     * @param $inputs
     * @return string
     * @throws \Exception
     */
    public function createAlbum($photoAlbum, $inputs)
    {
    	DB::beginTransaction();
        $photoAlbum = new PhotoAlbum();
        $photoAlbum->user_id = Auth::id();
        $photoAlbum->name = $inputs['name'];
        $photoAlbum->description = $inputs['description'];
        $photoAlbum->folder_id = sha1($inputs['name'] . time());

        try{
            $photoAlbum ->save();
        }
        catch(\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
        DB::commit();
        return $photoAlbum->folder_id;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Mashimalo
 * Date: 2016/1/7
 * Time: 22:42
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;



class PhotoAlbum extends Model
{


    protected $table = 'photo_albums';

    protected $fillable = ['name', 'description'];

    protected $dates = ['deleted_at'];

    protected $guarded = array('id');

    /**
     * Get the post's author.
     *
     * @return User
     */
    public function author()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * Get the post's comments.
     *
     * @return array
     */
    public function photos()
    {
        return $this->hasMany('App\Models\Photo');
    }
}
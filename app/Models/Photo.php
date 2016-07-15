<?php
/**
 * Created by PhpStorm.
 * User: Mashimalo
 * Date: 2016/1/7
 * Time: 22:42
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;



class Photo extends Model
{

    protected $table = 'photos';

    protected $fillable = ['name', 'description'];

    protected $dates = ['deleted_at'];

    protected $guarded  = array('id');

    /**
     * Get the post's author.
     *
     * @return User
     */
    public function author()
    {
        return $this->belongsTo('App\Models\User');
    }
    /**
     * Get the gallery for pictures.
     *
     * @return array
     */
    public function album()
    {
        return $this->belongsTo('App\Models\PhotoAlbum');
    }
}
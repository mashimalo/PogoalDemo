<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'genders';

    /**
     * One to Many relation
     *
     * @return Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function profiles()
    {
        return $this->hasMany('App\Models\Profile');
    }

    /**
     * get all the users per genders (Maybe used later)
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     *
     */

    public function users()
    {
        return $this->hasManyThrough('App\Models\Profile', 'App\Models\user');
    }

}

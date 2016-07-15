<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivacyRule extends Model  {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'privacy_rules';


    /**
     * one to many group relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groups()
    {
        return $this->hasMany('App\Models\Group');
    }

    /**
     * one to many docking Group relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     */
    public function dockingGroups()
    {
        return $this->hasMany('App\Models\DockingGroup');
    }


}

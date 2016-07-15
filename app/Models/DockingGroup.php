<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DockingGroup extends Model
{
    //
    protected $table = 'docking_groups';

    /**
     * one to many Feed
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function feeds()
    {
        return $this->hasMany('App\Models\Feed');
    }

    /**
     * one to many privacy rule
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function privacyRule()
    {
        return $this->belongsTo('App\Models\PrivacyRule');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    //
    protected $table = 'group_user';

    /**
     * one to many groupUserRole
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function groupUserRole()
    {
        return $this->belongsTo('App\Models\GroupUserRole');
    }

}

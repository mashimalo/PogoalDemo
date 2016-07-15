<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupUserRole extends Model
{
    protected $table = 'group_user_roles';

    /**
     * one to many groupUsers
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groupUsers()
    {
        return $this->hasMany('App\Models\GroupUser');
    }

}

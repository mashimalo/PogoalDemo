<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Support\Facades\Auth;

class Group extends Model
{
    protected $table = 'groups';

    protected $fillable = ['name', 'description', 'privacy_rule_id'];

    /**
     * one to many groupTypes
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function groupType()
    {
        return $this->belongsTo('App\Models\GroupType');
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

    /**
     * many to many users
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User')->withPivot('id', 'user_id', 'group_user_role_id', 'accepted')
            ->withTimestamps();
    }

    /**
     * get accepted users
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function acceptUsers()
    {
        return $this->users()->wherePivot('accepted', true)->get();
    }

    /**
     * verify if the user already in the group
     * @param User $user
     * @return bool
     */
    public function hasAcceptedUser(User $user)
    {
        return (bool)$this->acceptUsers()->where('id', $user->id)->count();
    }

    /**
     * get all pending request users
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function groupRequestsPendingUsers()
    {
        return $this->users()->wherePivot('accepted', false)->get();
    }

    /**
     * verify if the user has pending group join request
     * @param User $user
     * @return bool
     */
    public function hasGroupRequestsPending(User $user)
    {
        return (bool)$this->groupRequestsPendingUsers()->where('id', $user->id)->count();
    }
    /**
     * validate if current login user belongs to the target group
     * @param $group_id
     * @return mixed
     */
    public function validate_currentUser_in_group($group_id)
    {
        $current_user_id = Auth::User()->id;
        $validate_currentUser_in_group =
            GroupUser::wheregroup_id($group_id)->whereuser_id($current_user_id)->whereaccepted(true)->first();
        return $validate_currentUser_in_group;
    }

    /**
     * verify if the current user is founder of group
     * @param $group_id
     * @return mixed
     */
    public function validate_currentUser_founder_of_group($group_id)
    {
        $current_user_id = Auth::User()->id;
        $validate_currentUser_admin_of_group = GroupUser::wheregroup_id($group_id)
            ->whereuser_id($current_user_id)
            ->whereaccepted(true)
            ->wheregroup_user_role_id(1)
            ->first();
        return $validate_currentUser_admin_of_group;
    }

    /**
     * verify if the current user is coordinator of group
     * @param $group_id
     * @return mixed
     */
    public function validate_currentUser_coordinator_of_group($group_id)
    {
        $current_user_id = Auth::User()->id;
        $validate_currentUser_coordinator_of_group = GroupUser::wheregroup_id($group_id)
            ->whereuser_id($current_user_id)
            ->whereaccepted(true)
            ->wheregroup_user_role_id(2)
            ->first();
        return $validate_currentUser_coordinator_of_group;
    }

    /**
     * verify if the target user is founder of group
     * @param $group_id
     * @param $targetUser_id
     * @return mixed
     */
    public function validate_targetUser_founder_of_group($group_id, $targetUser_id)
    {
        $validate_targetUser_founder_of_group = GroupUser::wheregroup_id($group_id)
            ->whereuser_id($targetUser_id)
            ->whereaccepted(true)
            ->wheregroup_user_role_id(1)
            ->first();
        return $validate_targetUser_founder_of_group;
    }

    /**
     * verify if the target user is coordinator of group
     * @param $group_id
     * @param $targetUser_id
     * @return mixed
     */
    public function validate_targetUser_coordinator_of_group($group_id, $targetUser_id)
    {
        $validate_targetUser_coordinator_of_group = GroupUser::wheregroup_id($group_id)
            ->whereuser_id($targetUser_id)
            ->whereaccepted(true)
            ->wheregroup_user_role_id(2)
            ->first();
        return $validate_targetUser_coordinator_of_group;
    }

    /**
     * verify if the current user is coordinator of group
     * @param $group_id
     * @return mixed
     */
    public function validate_currentUser_has_permission($group_id)
    {
        $validate_currentUser_in_group = $this->validate_currentUser_in_group($group_id);
        if (!$validate_currentUser_in_group)
        {
            return false;
        }
        $current_user_id = Auth::User()->id;
        $userRoleId = GroupUser::wheregroup_id($group_id)
            ->whereuser_id($current_user_id)
            ->whereaccepted(true)->first()
            ->group_user_role_id;
        if ($userRoleId < 3)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * verify if current user role has permission to execute the operation for the target user
     * @param $group_id
     * @param $targetUser_id
     * @return bool
     */
    public function validate_currentUser_has_higher_permission_than_targetUser($group_id, $targetUser_id)
    {
        $validate_currentUser_in_group = $this->validate_currentUser_in_group($group_id);
        if (!$validate_currentUser_in_group)
        {
            return false;
        }

        $current_user_id = Auth::User()->id;

        $currentUserRoleId = GroupUser::wheregroup_id($group_id)
            ->whereuser_id($current_user_id)
            ->whereaccepted(true)->first()
            ->group_user_role_id;

        $targetUserRoleId = GroupUser::wheregroup_id($group_id)
            ->whereuser_id($targetUser_id)
            ->whereaccepted(true)->first()
            ->group_user_role_id;

        if ($currentUserRoleId < $targetUserRoleId)
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    /**
     *
     * one to many feeds,
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feeds()
    {
        return $this->hasMany('App\Models\Feed');
    }

    //--------------------------------------------------------
    //---------------------- Docking -------------------------
    //--------------------------------------------------------

    /**
     * group docking with other groups
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function dockingGroupsOfGroup()
    {
        return $this->belongsToMany('App\Models\Group', 'docking_groups', 'group_1_id', 'group_2_id')
            ->withPivot('id', 'group_1_id', 'group_2_id', 'docking_group_name', 'privacy_rule_id', 'accepted')->withTimestamps();
    }

    /**
     * other groups docking with the group
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function dockingGroupOf()
    {
        return $this->belongsToMany('App\Models\Group', 'docking_groups', 'group_2_id', 'group_1_id')
            ->withPivot('id', 'group_1_id', 'group_2_id', 'docking_group_name', 'privacy_rule_id', 'accepted')->withTimestamps();
    }

    /**
     * get group's current(group1) docking groups
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function dockingGroups()
    {
        return $this->dockingGroupsOfGroup()->wherePivot('accepted', true)->get()->merge($this->dockingGroupOf()
            ->wherePivot('accepted', true)->get());
    }

    /**
     * get all docking requests of group, where group sends to other group requests
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function dockingGroupRequests()
    {
        return $this->dockingGroupsOfGroup()->wherePivot('accepted', false)->get();
    }

    /**
     * get all the docking pending requests of the group, where other group send you the requests
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function dockingGroupRequestPending()
    {
        return $this->dockingGroupOf()->wherePivot('accepted', false)->get();
    }

    /**
     * check if current group have group docking pending request from other group
     *
     * @param Group $group
     * @return bool
     */
    public function hasDockingGroupRequestPending(Group $group)
    {
        return (bool)$this->dockingGroupRequestPending()->where('id', $group->id)->count();
    }

    /**
     * check if current group have received the docking request from other group
     *
     * @param Group $group
     * @return bool
     */
    public function hasDockingGroupRequestReceived(Group $group)
    {
        return (bool)$this->dockingGroupRequests()->where('id', $group->id)->count();
    }

    /**
     * check if current group has already docking with the target group
     * @param Group $group
     * @return bool
     */
    public function isDockingGroupWith (Group $group)
    {
        return (bool)$this->dockingGroups()->where('id', $group->id)->count();
    }
}
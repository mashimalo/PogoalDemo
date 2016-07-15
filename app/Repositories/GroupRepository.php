<?php

namespace App\Repositories;

use App\Models\DockingGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Group;
use App\Models\User;
use App\Models\GroupUser;

class GroupRepository extends BaseRepository
{


    /**
     * Constructor instance
     * @param Group $group
     * @param User $user
     */
    public function __construct(
        Group $group
    ) {

        $this->group = $group;
    }

    /**
     * create group
     * @param $inputs
     * @return mixed
     * @throws \Exception
     */

    public function createGroup($inputs)
    {
        DB::beginTransaction();
        try
        {
            $group = new Group();
            $group->name = $inputs['name'];
            $group->description = $inputs['description'];
            $group->group_type_id = $inputs['group_type_id'];
            $group->privacy_rule_id = $inputs['privacy_rule_id'];
            $group->save();

            Auth::user()->groups()->attach($group->id, ['group_user_role_id' => 1, 'accepted' => true]);

        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
        DB::commit();
        return $group->id;
    }

    /**
     * update group profile
     * @param $group_id
     * @param $inputs
     * @throws \Exception
     */
    public function modifyGroup($inputs, $group_id)
    {
        DB::beginTransaction();
        try
        {
            $group = Group::whereid($group_id)->first();
            $group->name = $inputs['name'];
            $group->description = $inputs['description'];
            $group->group_type_id = $inputs['group_type_id'];
            $group->privacy_rule_id = $inputs['privacy_rule_id'];
            $group->save();
        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
        DB::commit();
    }

    /**
     * user send group join requests
     * @param $group_id
     * @throws \Exception
     */
    public function sendJoinGroupRequest($group_id)
    {
        DB::beginTransaction();
        try
        {
            Auth::user()->groups()->attach($group_id, ['group_user_role_id' => 3]);
        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
        DB::commit();
    }


    /**
     * admins accepting user join group requests
     * @param $group_id
     * @param $pendingUser_id
     * @throws \Exception
     */
    public function acceptGroupRequest($group, $pendingUser_id)
    {
        DB::beginTransaction();
        try
        {
            $pendingUsers = $group->groupRequestsPendingUsers();
            foreach ($pendingUsers as $pendingUser)
            {
                if ($pendingUser->id == $pendingUser_id)
                {
                    $pendingUser->pivot->update(['accepted' => true]);
                }
            }
        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
        DB::commit();
    }

    /**
     * admin deny user join group requests
     * @param $group
     * @param $pendingUser_id
     * @throws \Exception
     */
    public function deniedGroupRequest($group, $pendingUser_id)
    {
        DB::beginTransaction();
        try
        {
            $pendingUsers = $group->groupRequestsPendingUsers();
            foreach ($pendingUsers as $pendingUser)
            {
                if ($pendingUser->id == $pendingUser_id)
                {
                    $pendingUser->pivot->delete();
                }
            }
        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
        DB::commit();
    }

    /**
     * remove user from group by group admins
     *
     * @param $group
     * @param $user_id
     * @throws \Exception
     */
    public function removeUser($group, $user_id)
    {
        DB::beginTransaction();
        try
        {
            $group->users()->where('user_id', $user_id)->first()->pivot->delete();
            //TODO
            //delte feed, comments and likes unlike related to the this user,

//            //delete feed
//            $group_id = $group->id;
//            $feeds = $group->users()->where('user_id', $user_id)->first()->feeds()->wheregroup_id($group_id);
//            dd($feeds);
//            foreach ($feeds as $feed)
//            {
//                $feed->likes()->delete();
//                $feed->unlikes()->delete();
//                foreach($feed->comments as $comment)
//                {
//                    $comment->likes()->delete();
//                    $comment->unlikes()->delete();
//                    foreach ($comment->childComments as $childComment)
//                    {
//                        $childComment->likes()->delete();
//                        $childComment->unlikes()->delete();
//                    }
//                }
//            }

            //delete comments
//            $comments = $group->users()->where('user_id', $user_id)->first()->comemnts();

//            foreach($feed->comments as $comment)
//            {
//                $comment->likes()->delete();
//                $comment->unlikes()->delete();
//                foreach ($comment->childComments as $childComment)
//                {
//                    $childComment->likes()->delete();
//                    $childComment->unlikes()->delete();
//                }
//            }
        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
        DB::commit();
    }

    /**
     * promote user from group by group admins
     *
     * @param $group
     * @param $user_id
     * @throws \Exception
     */
    public function promoteUser($group, $user_id)
    {
        DB::beginTransaction();
        try
        {
            $groupUser = $group->users()->where('user_id', $user_id)->first()->pivot;
            $groupUserRoleId = $groupUser->group_user_role_id;
            $groupUser->group_user_role_id = $groupUserRoleId - 1;
            $groupUser->save();
        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
        DB::commit();
    }

    /**
     * demote user from group by group admins
     *
     * @param $group
     * @param $user_id
     * @throws \Exception
     */
    public function demoteUser($group, $user_id)
    {
        DB::beginTransaction();
        try
        {
            $groupUser = $group->users()->where('user_id', $user_id)->first()->pivot;
            $groupUserRoleId = $groupUser->group_user_role_id;
            $groupUser->group_user_role_id = $groupUserRoleId + 1;
            $groupUser->save();
        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
        DB::commit();
    }

    /**
     * send docking group request
     *
     * @param $input
     * @param $sourceGroup
     * @param $targetGroup_id
     * @throws \Exception
     */
    public function sendDockingGroupRequest($input, $sourceGroup, $targetGroup_id)
    {
        DB::beginTransaction();
        try
        {
            $privacy_rule_id = $input['privacy_rule_id'];
            $docking_group_name = $input['docking_group_name'];

            $sourceGroup->dockingGroupsOfGroup()
                ->attach($targetGroup_id, ['privacy_rule_id' => $privacy_rule_id, 'docking_group_name' => $docking_group_name, 'accepted' => false]);
        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
        DB::commit();
    }

    /**
     * admins accepting docking group requests
     * @param $sourceGroup
     * @param $pendingDockingRequestGroup_id
     * @throws \Exception
     */
    public function acceptGroupDockingRequest($sourceGroup, $pendingDockingRequestGroup_id)
    {
        DB::beginTransaction();
        try
        {
            $pendingDockingGroups = $sourceGroup->dockingGroupRequestPending();
            foreach ($pendingDockingGroups as $pendingDockingGroup)
            {
                if ($pendingDockingGroup->id == $pendingDockingRequestGroup_id)
                {
                    $dockingGroup_id = $pendingDockingGroup->pivot->id;
                    $pendingDockingGroup->pivot->update(['accepted' => true]);
                }
            }
        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
        DB::commit();

        return $dockingGroup_id;
    }



    /**
     * admin deny docking group requests
     * @param $sourceGroup
     * @param $pendingDockingRequestGroup_id
     * @throws \Exception
     */
    public function denyGroupDockingRequest($sourceGroup, $pendingDockingRequestGroup_id)
    {
        DB::beginTransaction();
        try
        {
            $pendingDockingGroups = $sourceGroup->dockingGroupRequestPending();
            foreach ($pendingDockingGroups as $pendingDockingGroup)
            {
                if ($pendingDockingGroup->id == $pendingDockingRequestGroup_id)
                {
                    $pendingDockingGroup->pivot->delete();
                }
            }
        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
        DB::commit();
    }


}
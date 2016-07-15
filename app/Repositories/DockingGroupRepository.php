<?php

namespace App\Repositories;

use App\Models\DockingGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Group;


class DockingGroupRepository extends BaseRepository {

    /**
     * @param DockingGroup $dockingGroup
     */
    public function __construct(
        DockingGroup $dockingGroup
    ) {
        $this->dockingGroup = $dockingGroup;
    }

    /**
     * disband docking group
     *
     * @param $dockingGroup_id
     * @throws \Exception
     */
    public function disbandDockingGroup($dockingGroup_id)
    {
        DB::beginTransaction();
        try
        {
            $dockingGroup = DockingGroup::where('id', $dockingGroup_id);
            $dockingGroup -> delete();

        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
        DB::commit();
    }

    /**
     * edit docking group information
     *
     * @param $inputs
     * @param $dockingGroup_id
     * @throws \Exception
     */
    public function editDockingGroup($inputs, $dockingGroup_id)
    {
        DB::beginTransaction();
        try
        {
            $dockingGroup = DockingGroup::where('id', $dockingGroup_id)->first();
            $dockingGroup->docking_group_name = $inputs['docking_group_name'];
            $dockingGroup->privacy_rule_id = $inputs['privacy_rule_id'];
            $dockingGroup -> save();
        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
        DB::commit();
    }
}
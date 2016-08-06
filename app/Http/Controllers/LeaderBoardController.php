<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;

use \Illuminate\Support\Facades\Request;


class LeaderBoardController extends Controller
{
    public function leaderBoardPage()
    {

        $top_Group_By_Group_Type_Of_group_type_id = 1;


        // top user, decided by total like in feed, exclude its own likes
        $topUsers = DB::select('SELECT U.id AS user_id, count(*) AS amount from users AS U
                                  INNER JOIN feeds as F ON U.id = F.user_id
                                  INNER JOIN likeable as L ON L.likeable_id = F.id
                                  where L.user_id != U.id and L.likeable_type = :likeableType
                                  Group By U.id
                                    order by amount DESC
                                    LIMIT 15',
            ['likeableType' => 'App\Models\Feed']);


        // top group, decided by total users
        $topGroups =
            DB::select('SELECT G.id AS group_id, count(*) AS amount from groups AS G
                          INNER JOIN group_user as GU ON G.id = GU.group_id where GU.accepted =1
                          Group By G.id
                            order by amount DESC
                            LIMIT 15');


        //top bridge group
        $topBridgeGroups =
            DB::Select('SELECT D.id AS bridge_Group_id, count(*) AS amount FROM docking_groups AS D
                        INNER JOIN feeds as F ON D.id = F.docking_group_id
                          Group By D.id
                            Order by amount DESC LIMIT 15');


        return view('pages.leaderboard.leaderBoardPage',
            compact('topUsers', 'topGroups', 'topBridgeGroups'));
    }

    /**
     * get top users for ajax,  decided by total like in feed include bridge group, exclude its own likes
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function getTopUsers()
    {
        try
        {
            $topUsers = DB::select('SELECT U.id AS user_id, P.nickname AS nickName, P.first_name AS firstName, P.last_name AS lastName, P.user_avatar_small AS userAvatarSmall, count(*) AS amount from users AS U
                                  INNER JOIN profiles as P ON U.id = P.user_id
                                  INNER JOIN feeds as F ON U.id = F.user_id
                                  INNER JOIN likeable as L ON L.likeable_id = F.id
                                  where L.user_id != U.id and L.likeable_type = :likeableType
                                  Group By U.id
                                    order by amount DESC
                                    LIMIT 15',
                ['likeableType' => 'App\Models\Feed']);


//            $topUsers = json_encode(array_combine(range(0, count($topUsers) - 1), $topUsers), JSON_FORCE_OBJECT);

            $topUsers = json_encode($topUsers);
        }
        catch (\Exception $e)
        {
//            throw $e;
            return back()->with('error', trans('front/general.somethingWrong'));
        }

        if(Request::ajax())
        {
            return response(['status' => 'success', 'json' => $topUsers]);
        }
        else
        {
//            return response(['status' => 'success', 'json' => $topUsers]);
            return redirect('404');
        }
    }

    /**
     * get top users by group type, decided by total likes in group feeds exclude its own likes, exclude bridge group feeds
     *
     * @param $groupTypeId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function getTopUsersByGroupType($groupTypeId)
    {
        try
        {
            $topUsersByGroupType =
                DB::select('SELECT U.id AS user_id, P.nickname AS nickName, P.first_name AS firstName, P.last_name AS lastName, P.user_avatar_small AS userAvatarSmall, count(*) AS amount from users AS U
                          INNER JOIN profiles as P ON U.id = P.user_id
                          INNER JOIN feeds as F ON U.id = F.user_id
                          INNER JOIN groups as G ON G.id = F.group_id
                          INNER JOIN likeable as L ON L.likeable_id = F.id
                          where L.user_id != U.id and L.likeable_type = :likeableType and G.group_type_id = :groupTypeId
                            Group By U.id
                              order by amount DESC
                              LIMIT 15',
                    ['groupTypeId' => $groupTypeId, 'likeableType' => 'App\Models\Feed']);

//            $topUsersByGroupType = json_encode(array_combine(range(0, count($topUsersByGroupType) - 1), $topUsersByGroupType), JSON_FORCE_OBJECT);

            $topUsersByGroupType = json_encode($topUsersByGroupType);
        }
        catch (\Exception $e)
        {
//            throw $e;
            return back()->with('error', trans('front/general.somethingWrong'));
        }
        if(Request::ajax())
        {
            return response(['status' => 'success', 'json' => $topUsersByGroupType]);
        }
        else{
//            return response(['status' => 'success', 'json' => $topUsersByGroupType]);
            return redirect('404');
        }
    }

    /**
     * get top Groups, decided by total users.
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function getTopGroups()
    {
        try
        {
            $topGroups =
                DB::select('SELECT G.id AS group_id, G.name AS groupName, G.group_avatar_small AS groupAvatarSmall, count(*) AS amount from groups AS G
                          INNER JOIN group_user as GU ON G.id = GU.group_id where GU.accepted =1
                          Group By G.id
                            order by amount DESC LIMIT 15');

            $topGroups = json_encode($topGroups);
//            $topGroups = json_encode(array_combine(range(0, count($topGroups) - 1), $topGroups), JSON_FORCE_OBJECT);

        }
        catch (\Exception $e)
        {
//            throw $e;
            return back()->with('error', trans('front/general.somethingWrong'));
        }
        if(Request::ajax())
        {
            return response(['status' => 'success', 'json' => $topGroups]);
        }
        else{
//            return response(['status' => 'success', 'json' => $topGroups]);
            return redirect('404');
        }
    }

    public function getTopGroupsByGroupType($groupTypeId)
    {
        try
        {
            // top group by group type, decided by total users
            $topGroupsByGroupType =
                DB::select('SELECT G.id AS group_id, G.name AS groupName, G.group_avatar_small AS groupAvatarSmall, count(*) AS amount from groups AS G
                          INNER JOIN group_user as GU ON G.id = GU.group_id where GU.accepted =1 and G.group_type_id = :groupTypeId
                          Group By G.id
                            order by amount DESC LIMIT 15',
                    ['groupTypeId' => $groupTypeId]);

//            $topGroupsByGroupType = json_encode(array_combine(range(0, count($topGroupsByGroupType) - 1), $topGroupsByGroupType), JSON_FORCE_OBJECT);
            $topGroupsByGroupType = json_encode($topGroupsByGroupType);
        }
        catch (\Exception $e)
        {
//            throw $e;
            return back()->with('error', trans('front/general.somethingWrong'));
        }

        if(Request::ajax())
        {
            return response(['status' => 'success', 'json' => $topGroupsByGroupType]);
        }
        else
        {
//            return response(['status' => 'success', 'json' => $topGroupsByGroupType]);
            return redirect('404');
        }
    }


}

<?php namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Models\Profile;
use \Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Models\user;
use App\Models\Group;


class GlanceController extends Controller
{
    /**
     * @param $string
     * @return mixed
     */
    public function getUserIdBaseOnNickname($target_nickname)
    {

        $target_user_id = Profile::wherenickname($target_nickname)->firstOrFail()->user_id;

        return $target_user_id;
    }

    /**
     * @param $target_user_id
     * @return mixed
     */

    public function getUserByUserId($target_user_id)
    {
        return User::with('profile')->whereid($target_user_id)->firstOrFail();
    }

    /**
     * get user glance view
     * @param $target_nickname
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function getGlance($target_nickname)
    {
        try
        {

            if (Auth::guest())
            {
                return redirect()->action('ProfileController@show', [$target_nickname]);
            }
            //get the target user id base on the nickname
            $target_user_id = $this->getUserIdBaseOnNickname($target_nickname);
            $current_user_id = Auth::user()->id;

            if ($target_user_id != $current_user_id)
            {
                return redirect()->action('ProfileController@show', [$target_nickname]);
            }
            $user = $this->getUserByUserId($target_user_id);

            $acceptedGroups = $user->groups()->wherePivot('accepted', true)->paginate(20);

            $groups = Group::get()->sortBy('created_at')->reverse()->take(15);

            $myBridgeGroups1 = DB::table('docking_groups')
                ->join('group_user', 'group_user.group_id', '=', 'docking_groups.group_1_id')->where('group_user.user_id', '=', Auth::user()->id)
                ->where('group_user.accepted', '=', 1)->where('docking_groups.accepted', '=', 1)
                ->select('docking_groups.*');

            $myBridgeGroups = DB::table('docking_groups')
                ->join('group_user', 'group_user.group_id', '=', 'docking_groups.group_2_id')->where('group_user.user_id', '=', Auth::user()->id)
                ->where('group_user.accepted', '=', 1)->where('docking_groups.accepted', '=', 1)
                ->select('docking_groups.*')->union($myBridgeGroups1)->get();

            //call pagination function
            $myBridgeGroups = $this->paginate($myBridgeGroups, 20);

        }
        catch (\Exception $e)
        {
//            throw $e;
            return redirect('404');
        }

        return view('pages.glancePage', compact('user', 'target_user_id', 'acceptedGroups', 'groups', 'myBridgeGroups'));

    }


    /**
     * @param $items
     * @param $perPage
     * @return LengthAwarePaginator
     */
    public function paginate($items, $perPage)
    {
        $page = Input::get('page', 1);

        // Start displaying items from this number;
        $offSet = ($page * $perPage) - $perPage;

        // Get only the items you need using array_slice
        $itemsForCurrentPage = array_slice($items, $offSet, $perPage, true);
        return new LengthAwarePaginator($itemsForCurrentPage, count($items),
            $perPage, Paginator::resolveCurrentPage(), array('path' => Paginator::resolveCurrentPath()));
    }

}
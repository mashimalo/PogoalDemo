<?php

namespace App\Http\Controllers;


use App\Models\DockingGroup;
use App\Models\Group;
use App\Models\User;
use App\Models\GroupUser;
use App\Models\Notification;

use \Illuminate\Support\Facades\Auth;

use App\Models\Feed;
use App\Http\Requests;
use App\Http\Requests\DockingGroupEditRequest;
use App\Repositories\DockingGroupRepository;
use App\Repositories\NotificationRepository;

use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

class DockingController extends Controller
{
    private $dockingGroup;

    /**
     * constructor
     *
     * @param DockingGroup $dockingGroup
     * @param DockingGroupRepository $dockingGroup_repository
     * @param Notification $notification
     * @param NotificationRepository $notification_repository
     */
    public function __construct(
        DockingGroup $dockingGroup,
        DockingGroupRepository $dockingGroup_repository,
        Notification $notification,
        NotificationRepository $notification_repository
    ) {
        $this->dockingGroup = $dockingGroup;
        $this->dockingGroup_repository = $dockingGroup_repository;
        $this->notifiaction = $notification;
        $this->notifiaction_repository = $notification_repository;
    }

    /**
     * validate if current login user belongs to the target group
     * @param $group_id
     * @return mixed
     */
    public function validate_currentUser_in_group($group_id)
    {
        $current_user_id = Auth::User()->id;

        return (bool)GroupUser::wheregroup_id($group_id)->whereuser_id($current_user_id)->whereaccepted(true)->first();
    }

    /**
     * validate if current login user belongs to the target group
     * @param $group_id
     * @return mixed
     */
    public function validate_currentUser_in_dockingGroup($dockingGroup_id)
    {
        $group1_id = DockingGroup::whereid($dockingGroup_id)->first()->group_1_id;
        $group2_id = DockingGroup::whereid($dockingGroup_id)->first()->group_2_id;

        $validate_currentUser_in_Group1 = $this->validate_currentUser_in_group($group1_id);
        $validate_currentUser_in_Group2 = $this->validate_currentUser_in_group($group2_id);

        if ($validate_currentUser_in_Group1 || $validate_currentUser_in_Group2)
        {
            return true;
        }
        else
        {
            return false;
        }
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
     * validate if current login user belongs to the target group
     * @param $group_id
     * @return mixed
     */
    public function validate_currentUser_has_permission_in_dockingGroup($dockingGroup_id)
    {
        $group1_id = DockingGroup::whereid($dockingGroup_id)->first()->group_1_id;
        $group2_id = DockingGroup::whereid($dockingGroup_id)->first()->group_2_id;

        $validate_currentUser_has_permission_in_Group1 = $this->validate_currentUser_has_permission($group1_id);
        $validate_currentUser_has_permission_in_Group2 = $this->validate_currentUser_has_permission($group2_id);

        if ($validate_currentUser_has_permission_in_Group1 || $validate_currentUser_has_permission_in_Group2)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * show docking group setup page
     *
     * @param $target_group_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function dockingGroupSetup($target_group_id)
    {

        try
        {
            $target_group = Group::whereid($target_group_id)->first();
        }
        catch (\Exception $e)
        {
//            throw $e;
            return back()->with('error', trans('front/general.somethingWrong'));
        }


        return view('pages.docking.dockingGroupSetupPage', compact('target_group'));
    }

    /**
     * show docking group page
     *
     * @param $dockingGroup_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showDockingGroup($dockingGroup_id)
    {
        try
        {
            $group1_id = DockingGroup::whereid($dockingGroup_id)->first()->group_1_id;
            $group2_id = DockingGroup::whereid($dockingGroup_id)->first()->group_2_id;

            $group1 = Group::whereid($group1_id)->first();
            $group2 = Group::whereid($group2_id)->first();

            $dockingGroup = DockingGroup::whereid($dockingGroup_id)->first();

            if ($dockingGroup->accepted == false)
            {
                return back()->with('error', trans('front/dockingGroup.dockingGroupNotExist'));
            }

            $validate_currentUser_in_dockingGroup = $this->validate_currentUser_in_dockingGroup($dockingGroup_id);
            $validate_currentUser_has_permission_in_dockingGroup = $this->validate_currentUser_has_permission_in_dockingGroup($dockingGroup_id);
            $unpinned_feeds =
                Feed::where('docking_group_id', $dockingGroup_id)->where('pinned', false)->orderBy('created_at', 'desc')->paginate(5);
            $pinned_feeds =
                Feed::where('docking_group_id', $dockingGroup_id)->where('pinned', true)->orderBy('pin_last_updated', 'desc')->get();
        }
        catch (\Exception $e)
        {
//            throw $e;
            return back()->with('error', trans('front/general.somethingWrong'));
        }
        return view('pages.docking.dockingGroupPage',
            compact(
                'group1',
                'group2',
                'dockingGroup',
                'dockingGroup_id',
                'validate_currentUser_in_dockingGroup',
                'validate_currentUser_has_permission_in_dockingGroup',
                'unpinned_feeds',
                'pinned_feeds'));
    }

    /**
     * @param $dockingGroup_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showDockingGroupPinnedPage($dockingGroup_id)
    {
        try
        {
            $group1_id = DockingGroup::whereid($dockingGroup_id)->first()->group_1_id;
            $group2_id = DockingGroup::whereid($dockingGroup_id)->first()->group_2_id;

            $group1 = Group::whereid($group1_id)->first();
            $group2 = Group::whereid($group2_id)->first();

            $dockingGroup = DockingGroup::whereid($dockingGroup_id)->first();
//            $group_id = $dockingGroup_id;

            // validate if the request have been accepted
            if ($dockingGroup->accepted == false)
            {
                return back()->with('error', trans('front/dockingGroup.dockingGroupNotExist'));
            }

            $validate_currentUser_in_dockingGroup = $this->validate_currentUser_in_dockingGroup($dockingGroup_id);
            $validate_currentUser_has_permission_in_dockingGroup = $this->validate_currentUser_has_permission_in_dockingGroup($dockingGroup_id);
            $pinned_feeds =
                Feed::where('docking_group_id', $dockingGroup_id)->where('pinned', true)->orderBy('pin_last_updated', 'desc')
                    ->paginate(5);
        }
        catch (\Exception $e)
        {
//            throw $e;
            return back()->with('error', trans('front/general.somethingWrong'));
        }
        return view('pages.docking.dockingGroupPinnedPage',
            compact(
                'group1',
                'group2',
                'dockingGroup',
                'dockingGroup_id',
                'validate_currentUser_in_dockingGroup',
                'validate_currentUser_has_permission_in_dockingGroup',
                'pinned_feeds'));
    }

    /**
     * @param $dockingGroup_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEditDockingGroup($dockingGroup_id)
    {
        try
        {
            $validate_currentUser_has_permission_in_dockingGroup = $this->validate_currentUser_has_permission_in_dockingGroup($dockingGroup_id);

            if (!$validate_currentUser_has_permission_in_dockingGroup)
            {
                return back()->with('error', trans('front/feed.permissionDenied'));
            }

            $group1_id = DockingGroup::whereid($dockingGroup_id)->first()->group_1_id;
            $group2_id = DockingGroup::whereid($dockingGroup_id)->first()->group_2_id;

            $group1 = Group::whereid($group1_id)->first();
            $group2 = Group::whereid($group2_id)->first();

            $dockingGroup = DockingGroup::whereid($dockingGroup_id)->first();
//            $group_id = $dockingGroup_id;

            // validate if the request have been accepted
            if ($dockingGroup->accepted == false)
            {
                return back()->with('error', trans('front/dockingGroup.dockingGroupNotExist'));
            }

            $validate_currentUser_in_dockingGroup = $this->validate_currentUser_in_dockingGroup($dockingGroup_id);

        }
        catch (\Exception $e)
        {
//            throw $e;
            return back()->with('error', trans('front/general.somethingWrong'));
        }
        return view('pages.docking.dockingGroupEditPage',
            compact(
                'group1',
                'group2',
                'dockingGroup',
                'dockingGroup_id',
                'validate_currentUser_in_dockingGroup',
                'validate_currentUser_has_permission_in_dockingGroup'
            ));
    }

    /**
     * @param $dockingGroup_id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function disbandDockingGroup($dockingGroup_id)
    {
        try
        {
            $validate_currentUser_has_permission_in_dockingGroup = $this->validate_currentUser_has_permission_in_dockingGroup($dockingGroup_id);

            if (!$validate_currentUser_has_permission_in_dockingGroup)
            {
                return back()->with('error', trans('front/feed.permissionDenied'));
            }

            $group1_id = DockingGroup::whereid($dockingGroup_id)->first()->group_1_id;
            $group2_id = DockingGroup::whereid($dockingGroup_id)->first()->group_2_id;

            $group1Name = Group::whereid($group1_id)->first()->name;

            $group1Admins = GroupUser::wheregroup_id($group1_id)->where('group_user_role_id', '<', 3)->get();

            $group2Name = Group::whereid($group2_id)->first()->name;

            $group2Admins = GroupUser::wheregroup_id($group2_id)->where('group_user_role_id', '<', 3)->get();

            $group1UrlLink = url_link_to_group($group1_id);
            $group2UrlLink = url_link_to_group($group2_id);

            foreach ($group1Admins as $group1Admin)
            {
                $recipientUser_id = $group1Admin->user_id;
                $recipientUserName = empty_eitherName_displayNickname(User::whereid($recipientUser_id)->first());

                $notificationMessage = "Your bridging session between <b>Group - $group1Name</b> and <b>Group - $group2Name</b> has ended.";

                $this->notifiaction_repository->sendNotification($recipientUser_id, $notificationMessage, $group2UrlLink);

                Mail::queue('emails.group.DockingGroupDisband',
                    [
                        'group1Name'        => $group1Name,
                        'group1UrlLink'     => $group1UrlLink,
                        'group2Name'        => $group2Name,
                        'group2UrlLink'     => $group2UrlLink,
                        'recipientUserName' => $recipientUserName
                    ],
                    function (Message $message) use ($recipientUser_id, $recipientUserName)
                    {
                        $message->to(User::whereid($recipientUser_id)->first()->email, $recipientUserName)
                            ->subject(trans('front/email.dockingGroupDisbandSubject'));
                    });
            }

            foreach ($group2Admins as $group2Admin)
            {
                $recipientUser_id = $group2Admin->user_id;
                $recipientUserName = empty_eitherName_displayNickname(User::whereid($recipientUser_id)->first());

                $notificationMessage = "Your bridging session between <b>Group - $group1Name</b> and <b>Group - $group2Name</b> has ended.";

                $this->notifiaction_repository->sendNotification($recipientUser_id, $notificationMessage, $group1UrlLink);

                Mail::queue('emails.group.DockingGroupDisband',
                    [
                        'group1Name'        => $group1Name,
                        'group1UrlLink'     => url_link_to_group($group1_id),
                        'group2Name'        => $group2Name,
                        'group2UrlLink'     => url_link_to_group($group2_id),
                        'recipientUserName' => $recipientUserName
                    ],
                    function (Message $message) use ($recipientUser_id, $recipientUserName)
                    {
                        $message->to(User::whereid($recipientUser_id)->first()->email, $recipientUserName)
                            ->subject(trans('front/email.dockingGroupDisbandSubject'));
                    });
            }

            $this->dockingGroup_repository->disbandDockingGroup($dockingGroup_id);
        }
        catch (\Exception $e)
        {
//            throw $e;
            return back()->with('error', trans('front/dockingGroup.disbandDockingGroupFail'));
        }
        return redirect()->action('GlanceController@getGlance', [Auth::user()->profile->nickname])
            ->with('ok', trans('front/dockingGroup.disbandDockingGroupSuccess'));

    }


    /**
     * edit docking group information
     *
     * @param $dockingGroup_id
     * @param DockingGroupEditRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function editDockingGroup($dockingGroup_id, DockingGroupEditRequest $request)
    {
        try
        {
            $validate_currentUser_has_permission_in_dockingGroup = $this->validate_currentUser_has_permission_in_dockingGroup($dockingGroup_id);

            if (!$validate_currentUser_has_permission_in_dockingGroup)
            {
                return back()->with('error', trans('front/feed.permissionDenied'));
            }

            $this->dockingGroup_repository->editDockingGroup($request->all(), $dockingGroup_id);
        }
        catch (\Exception $e)
        {
//            throw $e;
            return back()->with('error', trans('front/dockingGroup.editDockingGroupFail'));
        }
        return redirect()->action('DockingController@showDockingGroup', $dockingGroup_id)
            ->with('ok', trans('front/dockingGroup.editDockingGroupSuccess'));
    }

    /**
     * show docking group feed page
     *
     * @param $dockingGroup_id
     * @param $feed_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Exception
     */
    public function showDockingGroupSingleFeedPage($dockingGroup_id, $feed_id)
    {
        try
        {
            $group1_id = DockingGroup::whereid($dockingGroup_id)->first()->group_1_id;
            $group2_id = DockingGroup::whereid($dockingGroup_id)->first()->group_2_id;

            $group1 = Group::whereid($group1_id)->first();
            $group2 = Group::whereid($group2_id)->first();

            $feed = Feed::whereid($feed_id)->first();
            $feedDockingGroupId = $feed->docking_group_id;

            $dockingGroup = DockingGroup::whereid($dockingGroup_id)->first();

            if (!$feed)
            {
                return redirect('/')->with('error', trans('front/group.feedNotFound'));
            }

            if (!$dockingGroup)
            {
                return redirect('/')->with('error', trans('front/dockingGroup.dockingGroupNotExist'));
            }

            if ($dockingGroup_id != $feedDockingGroupId)
            {
                return redirect(404);
            }

            if ($dockingGroup->accepted == false)
            {
                return back()->with('error', trans('front/dockingGroup.dockingGroupNotExist'));
            }

            $validate_currentUser_in_dockingGroup = $this->validate_currentUser_in_dockingGroup($dockingGroup_id);
            $validate_currentUser_has_permission_in_dockingGroup = $this->validate_currentUser_has_permission_in_dockingGroup($dockingGroup_id);

            $validate_if_target_dockingGroup_is_private = validate_if_target_dockingGroup_is_private($dockingGroup_id);

            if ($validate_if_target_dockingGroup_is_private && !$validate_currentUser_in_dockingGroup)
            {
                return redirect()->route('dockingGroupPage', [$dockingGroup_id])->with('error', trans('front/group.feedInPrivateDockingGroup'));;
            }

        }
        catch (\Exception $e)
        {
//            throw $e;
            return back()->with('error', trans('front/general.somethingWrong'));
        }
        return view('pages.docking.dockingGroupSingleFeedPage',
            compact(
                'group1',
                'group2',
                'feed',
                'feed_id',
                'dockingGroup',
                'dockingGroup_id',
                'validate_currentUser_in_dockingGroup',
                'validate_currentUser_has_permission_in_dockingGroup'
            ));
    }
}


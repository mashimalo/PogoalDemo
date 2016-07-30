<?php

namespace App\Http\Controllers;

use App\Models\GroupUser;
use Illuminate\Mail\Message;
use \Illuminate\Support\Facades\Auth;

use App\Models\Group;
use App\Models\Notification;
use App\Models\User;
use App\Models\Feed;

use App\Http\Requests\GroupCreateRequest;
use App\Http\Requests\GroupModifyRequest;
use App\Http\Requests\SearchGroupsRequest;
use App\Http\Requests\DockingGroupSetupRequest;
use DB;
use Illuminate\Support\Facades\Mail;

use App\Repositories\GroupRepository;
use App\Repositories\NotificationRepository;
use App\Http\Requests\UploadAvatarRequest;


class GroupsController extends Controller
{
    private $group;

    /**
     * constructor
     *
     * @param Group $group
     * @param GroupRepository $group_repository
     * @param Notification $notification
     * @param NotificationRepository $notification_repository
     */
    public function __construct(
        Group $group,
        GroupRepository $group_repository,
        Notification $notification,
        NotificationRepository $notification_repository
    ) {
        $this->group = $group;
        $this->group_repository = $group_repository;
        $this->notifiaction = $notification;
        $this->notifiaction_repository = $notification_repository;
    }

    /**
     * show the create group page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showCreateGroup()
    {
        return view('pages.groups.singleGroupCreatePage');
    }

    /**
     * show all groups
     *
     * @return $this
     * @throws \Exception
     */
    public function showAllGroups()
    {
        try
        {

            $groups = Group::paginate(16);

        }
        catch (\Exception $e)
        {
//			throw $e;
            return back()->with('error', trans('front/general.somethingWrong'));
        }

        return view('pages.groups.SearchGroupsResultPage')->with('groups', $groups);
    }


    /**
     * create group post
     * @param GroupCreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function createGroup(GroupCreateRequest $request)
    {
        try
        {
            $group_id = $this->group_repository->createGroup($request->all());
        }
        catch (\Exception $e)
        {
//            throw $e;
            return back()->with('error', trans('front/group.createGroupFail'));
        }
        return redirect()
            ->action('GroupsController@showGroup', $group_id)
            ->with('ok', trans('front/group.createGroupSuccess'));
    }

    /**
     * modify Group profile
     * @param GroupModifyRequest $request
     * @param $group_id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function modifyGroup(GroupModifyRequest $request, $group_id)
    {

        try
        {
            $group = Group::whereid($group_id)->first();
            $validate_currentUser_has_permission = $group->validate_currentUser_has_permission($group_id);
            if (!$validate_currentUser_has_permission)
            {
                return back()->with('error', trans('front/group.permissionDenied'));
            }
            $this->group_repository->modifyGroup($request->all(), $group_id);
        }
        catch (\Exception $e)
        {
//			throw $e;
            return back()->with('error', trans('front/group.modifyGroupFail'));
        }
        return back()->with('ok', trans('front/group.groupProfileModifySuccess'));
    }

    /**
     * show group - feed page
     * @param $group_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showGroup($group_id)
    {
        try
        {
            $group = Group::whereid($group_id)->first();
            if (!$group)
            {
                return redirect('/')->with('error', trans('front/group.groupNotFound'));
            }
            $validate_currentUser_in_group = $group->validate_currentUser_in_group($group_id);
            $validate_currentUser_founder_of_group = $group->validate_currentUser_founder_of_group($group_id);
            $validate_currentUser_coordinator_of_group = $group->validate_currentUser_coordinator_of_group($group_id);
            $validate_currentUser_has_permission = $group->validate_currentUser_has_permission($group_id);

            $unpinned_feeds =
                Feed::where('group_id', $group_id)->where('pinned', false)->orderBy('created_at', 'desc')->paginate(5);
            $pinned_feeds =
                Feed::where('group_id', $group_id)->where('pinned', true)->orderBy('pin_last_updated', 'desc')->get();
        }
        catch (\Exception $e)
        {
//            throw $e;
            return back()->with('error', trans('front/group.groupNotFound'));
        }

        return view(
            'pages.groups.singleGroupPage',
            compact(
                'group',
                'group_id',
                'validate_currentUser_in_group',
                'validate_currentUser_founder_of_group',
                'validate_currentUser_coordinator_of_group',
                'validate_currentUser_has_permission',
                'unpinned_feeds',
                'pinned_feeds'
            )
        );
    }

    /**
     * single group - show pinned feed page
     * @param $group_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function singleGroupPinnedPage($group_id)
    {
        try
        {
            $group = Group::whereid($group_id)->first();
            if (!$group)
            {
                return redirect('/')->with('error', trans('front/group.groupNotFound'));
            }
            $validate_currentUser_in_group = $group->validate_currentUser_in_group($group_id);
            $validate_currentUser_founder_of_group = $group->validate_currentUser_founder_of_group($group_id);
            $validate_currentUser_coordinator_of_group = $group->validate_currentUser_coordinator_of_group($group_id);
            $validate_currentUser_has_permission = $group->validate_currentUser_has_permission($group_id);

            $pinned_feeds =
                Feed::where('group_id', $group_id)->where('pinned', true)->orderBy('pin_last_updated', 'desc')
                    ->paginate(5);
        }
        catch (\Exception $e)
        {
            return back()->with('error', trans('front/group.groupNotFound'));
        }

        return view(
            'pages.groups.singleGroupPinnedPage',
            compact(
                'group',
                'group_id',
                'validate_currentUser_in_group',
                'validate_currentUser_founder_of_group',
                'validate_currentUser_coordinator_of_group',
                'validate_currentUser_has_permission',
                'pinned_feeds',
                'unpinned_feeds'
            )
        );
    }

    /**
     * single group - show group profile page
     *
     * @param $group_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function singleGroupProfilePage($group_id)
    {
        try
        {
            $group = Group::whereid($group_id)->first();
            if (!$group)
            {
                return route('singleGroupPage')->with('error', trans('front/group.groupNotFound'));
            }
            $validate_currentUser_in_group = $group->validate_currentUser_in_group($group_id);
            $validate_currentUser_founder_of_group = $group->validate_currentUser_founder_of_group($group_id);
            $validate_currentUser_coordinator_of_group = $group->validate_currentUser_coordinator_of_group($group_id);
            $validate_currentUser_has_permission = $group->validate_currentUser_has_permission($group_id);
            if (!$validate_currentUser_has_permission)
            {
                return back()->with('error', trans('front/group.permissionDenied'));
            }
            $pendingUsers = $group->groupRequestsPendingUsers();
            $pendingDockingGroupRequests = $group->dockingGroupRequestPending();
        }
        catch (\Exception $e)
        {
//            throw $e;
            return back()->with('error', trans('front/group.groupNotFound'));
        }

        return view(
            'pages.groups.singleGroupProfilePage',
            compact(
                'group',
                'group_id',
                'pendingUsers',
                'pendingDockingGroupRequests',
                'validate_currentUser_in_group',
                'validate_currentUser_founder_of_group',
                'validate_currentUser_coordinator_of_group',
                'validate_currentUser_has_permission'
            )
        );
    }

    /**
     * single group - show members page
     *
     * @param $group_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function singleGroupMembersPage($group_id)
    {
        try
        {
            $group = Group::whereid($group_id)->first();
            if (!$group)
            {
                return redirect('/')->with('error', trans('front/group.groupNotFound'));
            }
            $validate_currentUser_in_group = $group->validate_currentUser_in_group($group_id);
            $validate_currentUser_founder_of_group = $group->validate_currentUser_founder_of_group($group_id);
            $validate_currentUser_coordinator_of_group = $group->validate_currentUser_coordinator_of_group($group_id);
            $validate_currentUser_has_permission = $group->validate_currentUser_has_permission($group_id);

            $acceptedUsers = DB::table('group_user')
                ->where('group_id', $group_id)
                ->where('accepted', true)
                ->join('users', 'group_user.user_id', '=', 'users.id')
                ->paginate(10);

//            $adminUsers = DB::table('group_user')
//                ->where('group_id', $group_id)
//                ->where('group_user_role_id', '<', 3)
//                ->join('users', 'group_user.user_id', '=', 'users.id')
//                ->paginate(1);
            $adminUsers = $group->users()->wherePivot('group_user_role_id', '<', 3)->where('accepted', true)->get();


        }
        catch (\Exception $e)
        {
//            throw $e;
            return back()->with('error', trans('front/group.groupNotFound'));
        }

        return view('pages.groups.singleGroupMembersPage',
            compact('group',
                'group_id',
                'validate_currentUser_in_group',
                'validate_currentUser_founder_of_group',
                'validate_currentUser_coordinator_of_group',
                'validate_currentUser_has_permission',
                'acceptedUsers',
                'adminUsers'

            )
        );
    }

    /**
     * single group page - show docked groups page
     *
     * @param $group_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws \Exception
     */
    public function singleGroupDockingPage($group_id)
    {
        try
        {
            $group = Group::whereid($group_id)->first();

            if (!$group)
            {
                return redirect('/')->with('error', trans('front/group.groupNotFound'));
            }
            $validate_currentUser_in_group = $group->validate_currentUser_in_group($group_id);
            $validate_currentUser_founder_of_group = $group->validate_currentUser_founder_of_group($group_id);
            $validate_currentUser_has_permission = $group->validate_currentUser_has_permission($group_id);
        }
        catch (\Exception $e)
        {
//            throw $e;
            return back()->with('error', trans('front/group.groupNotFound'));
        }

        return view('pages.groups.singleGroupDockingPage',
            compact('group',
                'group_id',
                'validate_currentUser_in_group',
                'validate_currentUser_founder_of_group',
                'validate_currentUser_coordinator_of_group',
                'validate_currentUser_has_permission'
            )
        );
    }

    /**
     * search group by group name
     * @param SearchGroupsRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function searchGroupsResult(SearchGroupsRequest $request)
    {
        try
        {
            $query = $request->input('searchGroups');

            #empty query may never happen since its control my SearchGroupRequest class

            if (!$query)
            {
                return redirect()->route('home');
            }

            $groups = Group::where('name', 'LIKE', '%' . $query . '%')
                ->orWhere('description', 'LIKE', '%' . $query . '%')->orderBy('name', 'asc')
                ->paginate(16);
        }
        catch (\Exception $e)
        {
//            throw $e;
            return back()->with('error', trans('front/general.somethingWrong'));
        }
        return view('pages.groups.SearchGroupsResultPage')->with('groups', $groups);
    }


    /**
     * search group by group type
     * @param $group_type_id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function searchByGroupTypeResult($group_type_id)
    {
        try
        {
            #empty query may never happen since its control my SearchGroupRequest class

            if (!$group_type_id)
            {
                return redirect()->route('home');
            }

            $groups = Group::where('group_type_id', $group_type_id)->orderBy('name', 'asc')
                ->paginate(16);


        }
        catch (\Exception $e)
        {
//            throw $e;
            return back()->with('error', trans('front/general.somethingWrong'));
        }

        return view('pages.groups.SearchGroupsResultPage', compact('group_type_id'))->with('groups', $groups);
    }

    /**
     * send the request to join group
     * @param $group_id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function joinGroup($group_id)
    {
        try
        {
            $group = Group::whereid($group_id)->first();

            //if group not exist redirect back or 404?
            if (!$group)
            {
                return back()->with('error', trans('front/group.groupNotFound'));
            }

            //test see if the user already send the group requests.
            if ($group->hasGroupRequestsPending(Auth::user()))
            {
                return back()->with('error', trans('front/group.userAlreadySendTheRequest'));
            }

            //verify if the user already in the group, unlikely gonna happen.
            if ($group->hasAcceptedUser(Auth::user()))
            {
                return back()->with('error', trans('front/group.userAlreadyInTheGroup'));
            }

            $pendingUserFullName = empty_eitherName_displayNickname(Auth::user());

            $this->group_repository->sendJoinGroupRequest($group_id);

            $groupProfileUrlLink = url_link_to_groupProfilePage($group->id);

            $notificationMessage = "<b>$pendingUserFullName</b> is looking for join your Group - <b>$group->name</b>";

            $groupAdmins = GroupUser::wheregroup_id($group_id)
                ->where('group_user_role_id', '<', 3)->get();

            /*
             * send email and message notification
             */
            foreach ($groupAdmins as $groupAdmin)
            {
                $groupAdmin_id = $groupAdmin->user_id;

                //send message notification
                $this->notifiaction_repository->sendNotification($groupAdmin_id, $notificationMessage, $groupProfileUrlLink);

                $adminUserFullName = empty_eitherName_displayNickname(User::whereid($groupAdmin_id)->first());

                //send email notification
                Mail::queue('emails.group.GroupRequestSend',
                    [
                        'pendingUserFullName' => $pendingUserFullName,
                        'groupName'           => $group->name,
                        'groupProfileUrlLink' => $groupProfileUrlLink,
                        'adminUserFullName'   => $adminUserFullName
                    ],
                    function (Message $message) use ($groupAdmin_id, $adminUserFullName)
                    {
                        $message->to(User::whereid($groupAdmin_id)->first()->email, $adminUserFullName)
                            ->subject(trans('front/email.groupRequestSubject'));
                    });
            }
        }
        catch (\Exception $e)
        {
//			throw $e;
            return back()->with('error', trans('front/group.joinGroupFail'));
        }
        return back()->with('ok', trans('front/group.groupRequestSend'));

    }

    /**
     * accept user join group requests
     * @param $group_id
     * @param $pendingUser_id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function acceptGroupRequest($group_id, $pendingUser_id)
    {
        try
        {
            $pendingUser = User::whereid($pendingUser_id)->first();
            $group = Group::whereid($group_id)->first();

            //if group not exist redirect back or 404?
            if (!$pendingUser)
            {
                return back()->with('error', trans('front/profile.userNotFound'));
            }

            //verify if the user already in the group, unlikely gonna happen.
            if ($group->hasAcceptedUser($pendingUser))
            {
                return back()->with('error', trans('front/group.userAlreadyInTheGroup'));
            }

            //test see if the user already send the group requests. if the user has not been send the request. redirect back.
            if (!$group->hasGroupRequestsPending($pendingUser))
            {
                return back()->with('error', trans('front/group.userRequestHasNotBeenSend'));
            }

            $validate_currentUser_has_permission = $group->validate_currentUser_has_permission($group_id);

            //verify if the current logged in user has permission
            if (!$validate_currentUser_has_permission)
            {
                return back()->with('error', trans('front/group.permissionDenied'));
            }

            $this->group_repository->acceptGroupRequest($group, $pendingUser_id);

            $userFullName = empty_eitherName_displayNickname($pendingUser);

            /*
             * send email and message notification
             */

            $groupUrlLink = url_link_to_group($group->id);

            $notificationMessage = "Your request to join Group - <b>$group->name</b> has been <b>accepted</b>.";

            $this->notifiaction_repository->sendNotification($pendingUser_id, $notificationMessage, $groupUrlLink);

            /**
             * send notification email
             */
            Mail::queue('emails.group.GroupRequestAccepted',
                [
                    'userFullName'    => $userFullName,
                    'groupName'       => $group->name,
                    'groupUrlLink'    => url_link_to_group($group->id),
                    '$pendingUser_id' => $userFullName
                ],
                function (Message $message) use ($pendingUser_id, $userFullName)
                {
                    $message->to(User::whereid($pendingUser_id)->first()->email, $userFullName)
                        ->subject(trans('front/email.groupRequestAcceptedSubject'));
                });
        }
        catch (\Exception $e)
        {
            throw $e;
//			return back()->with('error', trans('front/group.acceptUserFail'));
        }

        return back()->with('ok', trans('front/group.userRequestHasBeenAccepted'));

    }

    /**
     * deny user join group requests
     * @param $group_id
     * @param $pendingUser_id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function deniedGroupRequest($group_id, $pendingUser_id)
    {
        try
        {
            $pendingUser = User::whereid($pendingUser_id)->first();
            $group = Group::whereid($group_id)->first();

            //if group not exist redirect back or 404?
            if (!$pendingUser)
            {
                return back()->with('error', trans('front/profile.userNotFound'));
            }

            //verify if the user already in the group, unlikely gonna happen.
            if ($group->hasAcceptedUser($pendingUser))
            {
                return back()->with('error', trans('front/group.userAlreadyInTheGroup'));
            }

            //test see if the user already send the group requests. if the user has not been send the request. redirect back.
            if (!$group->hasGroupRequestsPending($pendingUser))
            {
                return back()->with('error', trans('front/group.userRequestHasNotBeenSend'));
            }

            $validate_currentUser_has_permission = $group->validate_currentUser_has_permission($group_id);

            //verify if the current logged in user has permission
            if (!$validate_currentUser_has_permission)
            {
                return back()->with('error', trans('front/group.permissionDenied'));
            }


            $this->group_repository->deniedGroupRequest($group, $pendingUser_id);

            $userFullName = empty_eitherName_displayNickname($pendingUser);

            $groupUrlLink = url_link_to_group($group->id);

            $notificationMessage = "Your request to join Group - <b>$group->name</b> has been <b>denied</b>.";

            $this->notifiaction_repository->sendNotification($pendingUser_id, $notificationMessage, $groupUrlLink);

            Mail::queue('emails.group.GroupRequestDeny',
                [
                    'userFullName'    => $userFullName,
                    'groupName'       => $group->name,
                    'groupUrlLink'    => url_link_to_group($group->id),
                    '$pendingUser_id' => $userFullName
                ],
                function (Message $message) use ($pendingUser_id, $userFullName)
                {
                    $message->to(User::whereid($pendingUser_id)->first()->email, $userFullName)
                        ->subject(trans('front/email.groupRequestDeniedSubject'));
                });
        }
        catch (\Exception $e)
        {
            return back()->with('error', trans('front/group.denyUserFail'));
        }
        return back()->with('error', trans('front/group.userRequestHasBeenDenied'));

    }

    /**
     * remove user from group by admins
     * rules:
     * 1. founder can not be removed by anyone event himself.
     * 2. admins can only remove user that has lower power than him (not even equal).
     * 3. in view, user will not able to see the buttons.
     *
     * @param $group_id
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */

    public function removeUser($group_id, $user_id)
    {
        try
        {
            $user =
                User::whereid($user_id)
                    ->first();
            $group =
                Group::whereid($group_id)
                    ->first();

            //verify if the target user in the group, unlikely gonna happen.
            if (!$group->hasAcceptedUser($user))
            {
                return back()->with('error', trans('front/group.userNotInTheGroup'));
            }

            $validate_currentUser_has_higher_permission_than_targetUser =
                $group->validate_currentUser_has_higher_permission_than_targetUser($group_id, $user_id);

            if ($validate_currentUser_has_higher_permission_than_targetUser)
            {
                $this->group_repository->removeUser($group, $user_id);

                $userFullName = empty_eitherName_displayNickname($user);

                $groupUrlLink = url_link_to_group($group->id);

                $notificationMessage = "Your have been <b>removed</b> from Group - <b>$group->name</b>.";

                $this->notifiaction_repository->sendNotification($user_id, $notificationMessage, $groupUrlLink);


                Mail::queue('emails.group.RemoveFromGroup',
                    [
                        'userFullName'    => $userFullName,
                        'groupName'       => $group->name,
                        'groupUrlLink'    => url_link_to_group($group->id),
                        '$pendingUser_id' => $userFullName
                    ],
                    function (Message $message) use ($user_id, $userFullName)
                    {
                        $message->to(User::whereid($user_id)->first()->email, $userFullName)
                            ->subject(trans('front/email.removeUserFromGroupSubject'));
                    });
                return back()->with('error', trans('front/group.userRemoved'));
            }
            else
            {
                return back()->with('error', trans('front/group.permissionDenied'));
            }
        }
        catch (\Exception $e)
        {
            return back()->with('error', trans('front/group.removeUserFailed'));
        }
    }

    /**
     * user leave group
     * @param $group_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function leaveGroup($group_id)
    {
        try
        {
            $user = Auth::user();
            $user_id = $user->id;
            $group =
                Group::whereid($group_id)
                    ->first();

            $validate_currentUser_founder_of_group = $group->validate_currentUser_founder_of_group($group_id);

            if ($validate_currentUser_founder_of_group)
            {
                return back()->with('error', trans('front/group.founderCannotLeaveGroup'));
            }

            //check if user in the group
            if (!$group->hasAcceptedUser($user))
            {
                return back()->with('error', trans('front/group.userNotInTheGroup'));
            }
            $this->group_repository->removeUser($group, $user_id);
        }
        catch (\Exception $e)
        {
            return back()->with('error', trans('front/group.leaveGroupFailed'));
        }
        return back()->with('ok', trans('front/group.leaveGroupSuccessful'));

    }


    /**
     * promote user
     * @param $group_id
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */

    public function promoteUser($group_id, $user_id)
    {
        try
        {
            $user = User::whereid($user_id)->first();
            $group = Group::whereid($group_id)->first();


            //verify if the target user in the group, unlikely gonna happen.
            if (!$group->hasAcceptedUser($user))
            {
                return back()->with('error', trans('front/group.userNotInTheGroup'));
            }

            if ($group->validate_targetUser_coordinator_of_group($group_id, $user_id))
            {
                return back()->with('error', trans('front/group.permissionDenied'));
            }

            $validate_currentUser_has_higher_permission_than_targetUser =
                $group->validate_currentUser_has_higher_permission_than_targetUser($group_id, $user_id);

            if ($validate_currentUser_has_higher_permission_than_targetUser)
            {
                $this->group_repository->promoteUser($group, $user_id);
                return back()->with('ok', trans('front/group.promoteUserSuccessful'));
            }
            else
            {
                return back()->with('error', trans('front/group.permissionDenied'));
            }
        }
        catch (\Exception $e)
        {
            return back()->with('error', trans('front/group.promoteUserFail'));
        }
    }

    /**
     * demote user
     * @param $group_id
     * @param $user_id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function demoteUser($group_id, $user_id)
    {
        try
        {
            $user = User::whereid($user_id)->first();
            $group = Group::whereid($group_id)->first();

            //verify if the target user in the group, unlikely gonna happen.
            if (!$group->hasAcceptedUser($user))
            {
                return back()->with('error', trans('front/group.userNotInTheGroup'));
            }

            $validate_currentUser_has_higher_permission_than_targetUser =
                $group->validate_currentUser_has_higher_permission_than_targetUser($group_id, $user_id);

            if ($validate_currentUser_has_higher_permission_than_targetUser)
            {
                $this->group_repository->demoteUser($group, $user_id);
                return back()->with('ok', trans('front/group.demoteUserSuccessful'));
            }
            else
            {
                return back()->with('error', trans('front/group.permissionDenied'));
            }
        }
        catch (\Exception $e)
        {
            return back()->with('error', trans('front/group.demoteUserFail'));
        }
    }

    /************************* Docking Requests Group ****************************/

    /**
     * send docking group request
     *
     * @param DockingGroupSetupRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function sendDockingGroupRequest(DockingGroupSetupRequest $request)
    {
        try
        {

            $source_group_id = $request['source_group_id'];
            $target_group_id = $request['target_group_id'];
            $sourceGroup = Group::whereid($source_group_id)->first();
            $targetGroup = Group::whereid($target_group_id)->first();

            $validate_currentUser_has_permission = $sourceGroup->validate_currentUser_has_permission($source_group_id);

            if (!$validate_currentUser_has_permission)
            {
                return back()->with('error', trans('front/group.permissionDenied'));
            }

            //check if the group has received your request, prevent send more than one request
            if ($targetGroup->hasDockingGroupRequestPending($sourceGroup))
            {
                return back()->with('error', trans('front/group.dockingRequestHasAlreadySend'));
            }

            //check if the group has already send you the request
            if ($sourceGroup->hasDockingGroupRequestPending($targetGroup))
            {
                return redirect()
                    ->action('GroupsController@singleGroupProfilePage', [$source_group_id])
                    ->with('ok', trans('front/group.groupHaveAlreadySendDockingRequest'));
            }

            if ($sourceGroup->isDockingGroupWith($targetGroup))
            {
                return back()->with('error', trans('front/group.targetGroupAlreadyDocking'));
            }
            $this->group_repository->sendDockingGroupRequest($request->all(), $sourceGroup, $target_group_id);

            $sourceGroupName = Group::whereid($source_group_id)->first()->name;

            $targetGroupName = Group::whereid($target_group_id)->first()->name;

            $targetGroupAdmins = GroupUser::wheregroup_id($target_group_id)
                ->where('group_user_role_id', '<', 3)->get();

            foreach ($targetGroupAdmins as $targetGroupAdmin)
            {
                $targetGroupAdmin_id = $targetGroupAdmin->user_id;
                $targetGroupAdminUserFullName = empty_eitherName_displayNickname(User::whereid($targetGroupAdmin_id)->first());
                $targetGroupProfileUrlLink = url_link_to_groupProfilePage($target_group_id);

                $notificationMessage = "<b>$sourceGroupName</b> is requesting to start a bridging session with your Group - <b>$targetGroupName </b>.";

                $this->notifiaction_repository->sendNotification($targetGroupAdmin_id, $notificationMessage, $targetGroupProfileUrlLink);

                Mail::queue('emails.group.DockingGroupRequestSend',
                    [
                        'sourceGroupName'              => $sourceGroupName,
                        'targetGroupName'              => $targetGroupName,
                        'targetGroupProfileUrlLink'    => $targetGroupProfileUrlLink,
                        'sourceGroupUrlLink'           => url_link_to_group($source_group_id),
                        'targetGroupAdminUserFullName' => $targetGroupAdminUserFullName
                    ],
                    function (Message $message) use ($targetGroupAdmin_id, $targetGroupAdminUserFullName)
                    {
                        $message->to(User::whereid($targetGroupAdmin_id)->first()->email, $targetGroupAdminUserFullName)
                            ->subject(trans('front/email.dockingGroupRequestSubject'));
                    });
            }
            return back()->with('ok', trans('front/group.dockingRequestSend'));
        }
        catch (\Exception $e)
        {
//            throw $e;
            return back()->with('error', trans('front/general.somethingWrong'));
        }

    }

    /**
     * accept docking group request
     * @param $sourceGroup_id
     * @param $pendingDockingRequestGroup_id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function acceptDockingGroupRequest($sourceGroup_id, $pendingDockingRequestGroup_id)
    {
        try
        {
            $sourceGroup = Group::whereid($sourceGroup_id)->first();

            $validate_currentUser_has_permission = $sourceGroup->validate_currentUser_has_permission($sourceGroup_id);

            if (!$validate_currentUser_has_permission)
            {
                return back()->with('error', trans('front/group.permissionDenied'));
            }
            $dockingGroup_id = $this->group_repository->acceptGroupDockingRequest($sourceGroup, $pendingDockingRequestGroup_id);

            $dockingGroupUrl = url_link_to_dockingGroup($dockingGroup_id);

            $sourceGroupName = Group::whereid($sourceGroup_id)->first()->name;

            $sourceGroupUsers = GroupUser::wheregroup_id($sourceGroup_id)->get();

            $pendingDockingRequestGroupName = Group::whereid($pendingDockingRequestGroup_id)->first()->name;

            $pendingDockingRequestGroupUsers = GroupUser::wheregroup_id($pendingDockingRequestGroup_id)
                ->get();

            foreach ($pendingDockingRequestGroupUsers as $pendingDockingRequestGroupUser)
            {
                $recipientUser_id = $pendingDockingRequestGroupUser->user_id;
                $recipientUserName = empty_eitherName_displayNickname(User::whereid($recipientUser_id)->first());

                $pendingDockingRequestGroupUrlLink = url_link_to_group($pendingDockingRequestGroup_id);

                $notificationMessage = "<b>Your Group - $pendingDockingRequestGroupName</b>. is now bridging with Group - <b>$sourceGroupName</b>.";

                $this->notifiaction_repository->sendNotification($recipientUser_id, $notificationMessage, $dockingGroupUrl);

                Mail::queue('emails.group.DockingGroupRequestAccept',
                    [
                        'dockingGroupUrl'                   => $dockingGroupUrl,
                        'sourceGroupName'                   => $sourceGroupName,
                        'sourceGroupUrlLink'                => url_link_to_group($sourceGroup_id),
                        'pendingDockingRequestGroupName'    => $pendingDockingRequestGroupName,
                        'pendingDockingRequestGroupUrlLink' => $pendingDockingRequestGroupUrlLink,
                        'recipientUserName'                 => $recipientUserName
                    ],
                    function (Message $message) use ($recipientUser_id, $recipientUserName)
                    {
                        $message->to(User::whereid($recipientUser_id)->first()->email, $recipientUserName)
                            ->subject(trans('front/email.dockingGroupAcceptSubject'));
                    });
            }

            foreach ($sourceGroupUsers as $sourceGroupUser)
            {
                $recipientUser_id = $sourceGroupUser->user_id;
                $recipientUserName = empty_eitherName_displayNickname(User::whereid($recipientUser_id)->first());

                $notificationMessage = "Your Group - <b>$sourceGroupName</b>. is now bridging with Group - <b>$pendingDockingRequestGroupName</b>.";

                $this->notifiaction_repository->sendNotification($recipientUser_id, $notificationMessage, $dockingGroupUrl);

                Mail::queue('emails.group.DockingGroupRequestAccept',
                    [
                        'dockingGroupUrl'                   => $dockingGroupUrl,
                        'sourceGroupName'                   => $sourceGroupName,
                        'sourceGroupUrlLink'                => url_link_to_group($sourceGroup_id),
                        'pendingDockingRequestGroupName'    => $pendingDockingRequestGroupName,
                        'pendingDockingRequestGroupUrlLink' => url_link_to_group($pendingDockingRequestGroup_id),
                        'recipientUserName'                 => $recipientUserName
                    ],
                    function (Message $message) use ($recipientUser_id, $recipientUserName)
                    {
                        $message->to(User::whereid($recipientUser_id)->first()->email, $recipientUserName)
                            ->subject(trans('front/email.dockingGroupAcceptSubject'));
                    });
            }

            return redirect()
                ->action('DockingController@showDockingGroup', [$dockingGroup_id])
                ->with('ok', trans('front/group.dockingAccepted'));
        }
        catch (\Exception $e)
        {
//            throw $e;
            return back()->with('error', trans('front/general.somethingWrong'));
        }


    }

    /**
     * accept docking group request
     * @param $sourceGroup_id
     * @param $pendingDockingRequestGroup_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function denyDockingGroupRequest($sourceGroup_id, $pendingDockingRequestGroup_id)
    {
        try
        {
            $sourceGroup = Group::whereid($sourceGroup_id)->first();

            $validate_currentUser_has_permission = $sourceGroup->validate_currentUser_has_permission($sourceGroup_id);

            if (!$validate_currentUser_has_permission)
            {
                return back()->with('error', trans('front/group.permissionDenied'));
            }
            $this->group_repository->denyGroupDockingRequest($sourceGroup, $pendingDockingRequestGroup_id);

            $pendingDockingRequestGroupAdmins = GroupUser::wheregroup_id($pendingDockingRequestGroup_id)->where('group_user_role_id', '<', 3)->get();

            $sourceGroupName = Group::whereid($sourceGroup_id)->first()->name;

            $pendingDockingRequestGroupName = Group::whereid($pendingDockingRequestGroup_id)->first()->name;

            foreach ($pendingDockingRequestGroupAdmins as $pendingDockingRequestGroupAdmin)
            {
                $recipientUser_id = $pendingDockingRequestGroupAdmin->user_id;
                $recipientUserName = empty_eitherName_displayNickname(User::whereid($recipientUser_id)->first());
                $sourceGroupUrlLink = url_link_to_group($sourceGroup_id);

                $notificationMessage =
                    " Your Group - <b>$pendingDockingRequestGroupName</b> bridging request with <b>Group - $sourceGroupName </b>has been denied.";

                $this->notifiaction_repository->sendNotification($recipientUser_id, $notificationMessage, $sourceGroupUrlLink);

                Mail::queue('emails.group.DockingGroupRequestDeny',
                    [
                        'sourceGroupName'                   => $sourceGroupName,
                        'sourceGroupUrlLink'                => $sourceGroupUrlLink,
                        'pendingDockingRequestGroupName'    => $pendingDockingRequestGroupName,
                        'pendingDockingRequestGroupUrlLink' => url_link_to_group($pendingDockingRequestGroup_id),
                        'recipientUserName'                 => $recipientUserName
                    ],
                    function (Message $message) use ($recipientUser_id, $recipientUserName)
                    {
                        $message->to(User::whereid($recipientUser_id)->first()->email, $recipientUserName)
                            ->subject(trans('front/email.dockingGroupDenySubject'));
                    });
            }
            return back()->with('ok', trans('front/group.dockingDeny'));
        }
        catch (\Exception $e)
        {
//            throw $e;
            return back()->with('error', trans('front/general.somethingWrong'));
        }
    }

    /**
     * upload group avatar
     *
     * @param UploadAvatarRequest $request
     * @param $group_id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function uploadGroupAvatar(UploadAvatarRequest $request, $group_id)
    {
        try
        {
            $group = Group::whereid($group_id)->first();

            if (!$group)
            {
                return redirect('/')->with('error', trans('front/group.groupNotFound'));
            }

            $validate_currentUser_has_permission = $group->validate_currentUser_has_permission($group_id);

            if (!$validate_currentUser_has_permission)
            {
                return back()->with('error', trans('front/group.permissionDenied'));
            }

            $this->group_repository->uploadGroupAvatar($group, $request);

        }
        catch (\Exception $e)
        {
            throw $e;
//			return back()->with('error', trans('front/profile.modifyUserProfileFail'));
        }
        return back()->with('ok', trans('front/group.groupProfileModifySuccess'));
    }

    /**
     * show group single feed page
     *
     * @param $group_id
     * @param $feed_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     * @throws \Exception
     */
    public function showGroupSingleFeedPage($group_id, $feed_id)
    {
        try
        {
            $group = Group::whereid($group_id)->first();
            $feed = Feed::whereid($feed_id)->first();
            $feedGroupId = $feed->group_id;

            if (!$group)
            {
                return redirect('/')->with('error', trans('front/group.groupNotFound'));
            }
            if (!$feed)
            {
                return redirect('/')->with('error', trans('front/group.feedNotFound'));
            }
            if ($group_id != $feedGroupId)
            {
                return redirect (404);
            }

            $validate_currentUser_in_group = $group->validate_currentUser_in_group($group_id);

            $validate_if_targetGroup_is_private = validate_if_targetGroup_is_private ($group_id);

            if ($validate_if_targetGroup_is_private && !$validate_currentUser_in_group)
            {
                return redirect()->route('singleGroupPage', [$group_id])->with('error', trans('front/group.feedInPrivateGroup'));;
            }


            $validate_currentUser_in_group = $group->validate_currentUser_in_group($group_id);
            $validate_currentUser_has_permission = $group->validate_currentUser_has_permission($group_id);

        }
        catch (\Exception $e)
        {
            throw $e;
//            return back()->with('error', trans('front/group.groupNotFound'));
        }

        return view(
            'pages.groups.groupSingleFeedPage',
            compact(
                'feed',
                'feed_id',
                'group',
                'group_id',
                'validate_currentUser_in_group',
                'validate_currentUser_has_permission'
            )
        );
    }
}

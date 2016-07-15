<?php

namespace App\Http\Controllers;

/**
 * Created by PhpStorm.
 * User: Mashimalo
 * Date: 2016/7/3
 * Time: 16:27
 */

use App\Models\User;
use App\Models\Notification;
use App\Models\Profile;

use \Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Request;

use App\Repositories\NotificationRepository;

class NotificationController extends Controller
{

    private $notification;

    /**
     * constructor
     *
     * @param Notification $notification
     * @param NotificationRepository $notification_repository
     */
    public function __construct(
        Notification $notification,
        NotificationRepository $notification_repository
    ) {
        $this->notifiaction = $notification;
        $this->notifiaction_repository = $notification_repository;
    }

    /**
     * get notifications
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function getNotifications ()
    {
        try
        {
            //get the target user id base on the nickname
            $current_user_id = Auth::user()->id;

            $notifications = Notification::where('user_id', $current_user_id)->orderBy('created_at', 'desc')->get()->take(15);
	        $newNotificationsCount = Notification::where('user_id', $current_user_id)->where('read', false)->count();
            $seeAllNotifications = Notification::where('user_id', $current_user_id)->orderBy('created_at', 'desc')->paginate(15);

        }
        catch(\Exception $e)
        {
//            throw $e;
            return back()->with( 'error', trans( 'front/general.somethingWrong' ) );
        }
        if(Request::ajax())
        {
            return response( [ 'status' => 'success', 'json' => $notifications, 'newNotifications' => $newNotificationsCount ] );
        }
        else {
//            return response( [ 'status' => 'success', 'json' => $notifications, 'newNotifications' => $newNotificationsCount ] );
            return view('pages.glancePage', compact('seeAllNotifications', 'newNotificationsCount'));
        }
    }

    /**
     * read notifications
     *
     * @param $notification_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function readNotification ($notification_id)
    {
        try
        {
            $current_user_id = Auth::user()->id;
            $notification_userId = Notification::whereid($notification_id)->firstOrFail()->user_id;

            if ($current_user_id != $notification_userId)
            {
                return back()->with( 'error', trans( 'front/general.permissionDenied' ) );
            }

            $this->notifiaction_repository->readNotification( $notification_id );

        }
        catch(\Exception $e)
        {
//            throw $e;
            return back()->with( 'error', trans( 'front/general.somethingWrong' ) );
        }

        if(Request::ajax())
        {
            return response( [ 'status' => 'success'] );
        }
        else{
            return back()->with('ok', trans('front/notification.messageRead'));
        }

    }

    /**
     * read all notifications
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function readAllNotifications ()
    {
        try
        {

            $current_user_id = Auth::user()->id;

            $unreadNotifications= Notification::where('user_id', $current_user_id)->where('read', false)->get();

            if (sizeof($unreadNotifications) > 0)

            {
                foreach ($unreadNotifications as $unreadNotification)
                {
                    $notification_id = $unreadNotification->id;
                    $this->notifiaction_repository->readNotification( $notification_id );
                }
            }

        }
        catch(\Exception $e)
        {
//            throw $e;
            return back()->with( 'error', trans( 'front/general.somethingWrong' ) );
        }

        if(Request::ajax())
        {
            return response( [ 'status' => 'success'] );
        }
        else{
            return back()->with('ok', trans('front/notification.allMessageRead'));
        }
    }

    /**
     * set unread notifications
     *
     * @param $notification_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function unreadNotification ($notification_id)
    {
        try
        {

            $current_user_id = Auth::user()->id;
            $notification_userId = Notification::whereid($notification_id)->firstOrFail()->user_id;

            if ($current_user_id != $notification_userId)
            {
                return back()->with( 'error', trans( 'front/general.permissionDenied' ) );
            }

            $this->notifiaction_repository->unreadNotification( $notification_id );

        }
        catch(\Exception $e)
        {
//            throw $e;
            return back()->with( 'error', trans( 'front/general.somethingWrong' ) );
        }

        if(Request::ajax())
        {
            return response( [ 'status' => 'success'] );
        }
        else{
            return back()->with('ok', trans('front/notification.messageUnread'));
        }
    }

    /**
     * delete notifications
     *
     * @param $notification_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function deleteNotification ($notification_id)
    {
        try
        {
            $current_user_id = Auth::user()->id;

            $notification_userId = Notification::whereid($notification_id)->firstOrFail()->user_id;

            if ($current_user_id != $notification_userId)
            {
                return back()->with( 'error', trans( 'front/general.permissionDenied' ) );
            }

            $this->notifiaction_repository->deleteNotification($notification_id);
        }
        catch(\Exception $e)
        {
//            throw $e;
            return back()->with( 'error', trans( 'front/general.somethingWrong' ) );
        }

        if(Request::ajax())
        {
            return response( [ 'status' => 'success'] );
        }
        else{
            return back()->with('ok', trans('front/notification.messageDelete'));
        }
    }


}

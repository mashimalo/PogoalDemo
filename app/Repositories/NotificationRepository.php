<?php namespace App\Repositories;

use App\Models\Notification;
use Illuminate\Support\Facades\DB;

class NotificationRepository extends BaseRepository
{

    /**
     * constructor
     *
     * @param Notification $notification
     */
    public function __construct(
        Notification $notification
    ) {

        $this->notification = $notification;
    }

    /**
     * send notifications
     *
     * @param $userId
     * @param $messageData
     * @param $notificationLink
     * @throws \Exception
     */
    public function sendNotification($userId, $messageData, $notificationLink)
    {
        DB::beginTransaction();
        try
        {
            $notification = new Notification();
            $notification->user_id = $userId;
            $notification->message_data = $messageData;
            $notification->notification_link = $notificationLink;
            $notification->save();

        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
        DB::commit();
    }

    /**
     * set notification read status to true
     * @param $notificationId
     * @throws \Exception
     */
    public function readNotification($notificationId)
    {
        DB::beginTransaction();
        try
        {
            $notification = Notification::whereid($notificationId)->firstOrFail();
            $notification->read = true;
            $notification->save();
        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
        DB::commit();
    }

    /**
     * set notification read status to false
     * @param $notificationId
     * @throws \Exception
     */
    public function unreadNotification($notificationId)
    {
        DB::beginTransaction();
        try
        {
            $notification = Notification::whereid($notificationId)->firstOrFail();
            $notification->read = false;
            $notification->save();
        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
        DB::commit();
    }

    /**
     * delete notification
     * @param $notificationId
     * @throws \Exception
     */
    public function deleteNotification($notificationId)
    {
        DB::beginTransaction();
        try
        {
            $notification = Notification::whereid($notificationId)->firstOrFail();
            $notification->delete();
        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
        DB::commit();
    }
}


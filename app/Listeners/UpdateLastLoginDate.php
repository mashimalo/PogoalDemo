<?php namespace App\Listeners;

use Carbon\Carbon;

class UpdateLastLoginDate
{

    public function __construct()
{
    //
}
    public function handle($user) {
        $user->last_visit = Carbon::now();
        $user->save();
    }
}
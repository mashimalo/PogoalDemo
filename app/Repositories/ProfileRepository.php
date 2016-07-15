<?php namespace App\Repositories;

use App\Models\Profile;
use Illuminate\Support\Facades\DB;

class ProfileRepository extends BaseRepository
{
    /**
     * for updating profiles
     * @param Profile $profile
     */
    public function __construct(
        Profile $profile)
    {

        $this->profile = $profile;
    }

    public function updateProfile($profile, $inputs)
    {
        DB::beginTransaction();
        try{
        $profile->first_name = ucfirst($inputs['first_name']);
        $profile->last_name = ucfirst($inputs['last_name']);
        $profile->nickname = $inputs['nickname'];
        $profile->date_of_birth = $inputs['date_of_birth'];
        $profile->gender_id = $inputs['gender_id'];
        $profile->bio = $inputs['bio'];
        $profile -> save();

        }
        catch(\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
        DB::commit();
    }
}
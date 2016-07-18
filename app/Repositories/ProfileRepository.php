<?php namespace App\Repositories;

use App\Models\Profile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use \Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;


class ProfileRepository extends BaseRepository
{
    /**
     * for updating profiles
     * @param Profile $profile
     */
    public function __construct(
        Profile $profile
    ) {

        $this->profile = $profile;
    }

    public function updateProfile($profile, $inputs)
    {
        DB::beginTransaction();
        try
        {
            $profile->first_name = ucfirst($inputs['first_name']);
            $profile->last_name = ucfirst($inputs['last_name']);
            $profile->nickname = $inputs['nickname'];
            $profile->date_of_birth = $inputs['date_of_birth'];
            $profile->gender_id = $inputs['gender_id'];
            $profile->bio = $inputs['bio'];
            $profile->save();

        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
        DB::commit();
    }

    /**
     * upload profile avatar
     *
     * @param $profile
     * @param $request
     * @throws \Exception
     */
    public function uploadProfileAvatar($profile, $request)
    {
        DB::beginTransaction();
        try
        {
            if ($request->hasFile('uploadImage'))
            {
                $file = Input::file('uploadImage');
                //getting timestamp
                $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $largeAvatarFileName = sha1($filename . $timestamp.'large') . '.' . $extension;
                $smallAvatarFileName = sha1($filename . $timestamp.'small') . '.' . $extension;
                $filePath = public_path() . '/images/userAvatar/';
                $file=$file->getRealPath();
                $largeAvatarFile= Image::make($file);
                // save large file
                $largeAvatarFile->resize(400, 400);
                $largeAvatarFile->save($filePath.$largeAvatarFileName);
                // save small file
                $smallAvatarFile= Image::make($file);
                $smallAvatarFile->resize(64, 64);
                $smallAvatarFile->save($filePath.$smallAvatarFileName);
            }
            // delete the old large avatar  file in the file system
            if ($profile->user_avatar_large != null || strlen($profile->user_avatar_large) > 0)
            {
                $oldAvatarLarge = $filePath.$profile->user_avatar_large;
                File::delete($oldAvatarLarge);
            }

            // delete the old avatar file in the file system
            if ($profile->user_avatar_small != null || strlen($profile->user_avatar_small) > 0)
            {
                $oldAvatarSmall = $filePath.$profile->user_avatar_small;
                File::delete($oldAvatarSmall);
            }

            $profile->user_avatar_large = $largeAvatarFileName;
            $profile->user_avatar_small = $smallAvatarFileName;

            $profile->save();

        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
        DB::commit();
    }

}
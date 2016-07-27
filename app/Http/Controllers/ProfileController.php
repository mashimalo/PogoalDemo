<?php namespace App\Http\Controllers;

use App\Models\Profile;
use \Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Models\user;

use App\Repositories\UserRepository;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\UploadAvatarRequest;
use App\Repositories\ProfileRepository;


class ProfileController extends Controller
{
    /**
     * @var UserRepository
     */
	protected $user_repository;

    /**
     * @param UserRepository $user_repository
     * @param ProfileRepository $profile_repository
     */


	public function __construct(
        UserRepository $user_repository,
        ProfileRepository $profile_repository
    )
	{
		$this->user_repository = $user_repository;
        $this->profile_repository = $profile_repository;
	}

	/**
	 * @param $string
	 * @return mixed
	 */
	public function getUserIdBaseOnNickname($target_nickname){

		$target_user_id = Profile::wherenickname($target_nickname) ->firstOrFail() ->user_id;

		return $target_user_id;
	}

	/**
	 * @param $target_user_role_id
	 * @return mixed
	 */
	public function getUserRoleIdBaseOnUserId($target_user_id){

		$target_user_role_id = User::whereid($target_user_id)->firstOrFail() -> role_id;

		return $target_user_role_id;
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
	 * @param $target_user_id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 * show target user's profile
	 * url profile/{target nickname}
	 * role check and see if current user is not admin, then it will not have permission to check admin's profile
	 */

	public function show($target_nickname)
	{
		try
		{
			//get the target user id base on the nickname
			$target_user_id = $this -> getUserIdBaseOnNickname($target_nickname);


			//get the user role id base on the User id
			$target_user_role_id = $this -> getUserRoleIdBaseOnUserId($target_user_id);


			// if current user is not admin or just guest can'y see admin's profile, throw user not found exception
			if (Auth::guest() && $target_user_role_id == 1)
			{
				return redirect('/')->with('error', trans('front/profile.userNotFound'));
			}
			if ($this->user_repository->getrole() != 'admin' && $target_user_role_id == 1)
			{
				return redirect('/')->with('error', trans('front/profile.userNotFound'));
			}

			$user = $this ->getUserByUserId($target_user_id);

			$acceptedGroups = $user->groups()->wherePivot('accepted', true)->paginate(20);
		}
		catch(\Exception $e)
		{
			return redirect('/')->with('error', trans('front/profile.userNotFound'));
		}
		return view('pages.profile.profilePage', compact('user', 'target_user_id', 'target_nickname', 'acceptedGroups'));
	}


	/**
	 * get user profile page
	 * @param $target_nickname
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
    public function edit($target_nickname)
    {
        try
        {
			//get the target user id base on the nickname
			$target_user_id = $this -> getUserIdBaseOnNickname($target_nickname);
            $current_user_id = Auth::user()->id;

			if ($target_user_id != $current_user_id)
			{
				return redirect('/')->with('error', trans('front/profile.notHavePermissionToEditUser'));
			}
			$user = $this ->getUserByUserId($target_user_id);

        }
        catch(\Exception $e)
        {
			return redirect('404');
        }
        return view('pages.profile.profileEditPage', compact('user', 'target_user_id'));
    }

	/**
	 * modify user's profile
	 * @param $target_nickname
	 * @param ProfileUpdateRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
    public function update($target_nickname, ProfileUpdateRequest $request)
    {
        try
        {
			$userNickName = $request['nickname'];
			$target_user_id = $this -> getUserIdBaseOnNickname($target_nickname);
			$current_user_id = Auth::user()->id;

			if ($target_user_id != $current_user_id)
			{
				return redirect('/')->with('error', trans('front/profile.notHavePermissionToEditUser'));
			}
			$user = $this->getUserByUserId($target_user_id);

            $this->profile_repository->updateProfile($user->profile, $request->all());

		}
		catch(\Exception $e)
		{
			return back()->with('error', trans('front/profile.modifyUserProfileFail'));
		}
		return redirect()->route('profile.edit', [$userNickName])->with('ok', trans('front/profile.updateSuccessful'));

//		return back()->withInput()->with('ok', trans('front/profile.updateSuccessful'));
    }

//	/**
//	 * get glance page
//	 * @param $target_nickname
//	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
//	 */
//
//	public function glance($target_nickname)
//	{
//		try
//		{
//			if (Auth::guest())
//			{
//				return redirect()->action('ProfileController@show', [$target_nickname]);
//			}
//			//get the target user id base on the nickname
//			$target_user_id = $this -> getUserIdBaseOnNickname($target_nickname);
//			$current_user_id = Auth::user()->id;
//
//			if ($target_user_id != $current_user_id)
//			{
//				return redirect()->action('ProfileController@show', [$target_nickname]);
//			}
//			$user = $this ->getUserByUserId($target_user_id);
//
//		}
//		catch(\Exception $e)
//		{
//			return redirect('404');
//		}
//		return view('pages.glancePage', compact('user', 'target_user_id'));
//	}

	// Todo: Created by Hui Lin
	/**
	 * upload profile avatar page
	 *
	 * @param $target_nickname
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
	 */
	public function profileAvatarPage($target_nickname)
	{
		try
		{
			//get the target user id base on the nickname
			$target_user_id = $this -> getUserIdBaseOnNickname($target_nickname);
			$current_user_id = Auth::user()->id;

			if ($target_user_id != $current_user_id)
			{
				return redirect('/')->with('error', trans('front/profile.notHavePermissionToEditUser'));
			}
			$user = $this ->getUserByUserId($target_user_id);

		}
		catch(\Exception $e)
		{
			return redirect('404');
		}
		return view('pages.profile.profileEditPage', compact('user', 'target_user_id'));
	}


	/**
	 * update profile avatar
	 * @param $target_nickname
	 * @param UploadAvatarRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function uploadProfileAvatar ($target_nickname, UploadAvatarRequest $request)
	{
		try
		{
			$userNickName = $target_nickname;
			$target_user_id = $this -> getUserIdBaseOnNickname($target_nickname);
			$current_user_id = Auth::user()->id;

			if ($target_user_id != $current_user_id)
			{
				return redirect('/')->with('error', trans('front/profile.notHavePermissionToEditUser'));
			}
			$user = $this->getUserByUserId($target_user_id);

			$this->profile_repository->uploadProfileAvatar($user->profile, $request);

		}
		catch(\Exception $e)
		{
//			throw $e;
			return back()->with('error', trans('front/profile.modifyUserProfileFail'));
		}
		return redirect()->route('profileAvatarPage', [$userNickName])->with('ok', trans('front/profile.updateSuccessful'));
	}
	
}
<?php namespace App\Http\Controllers;

use App\Models\Profile;
use \Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Models\user;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Repositories\UserRepository;
use App\Http\Requests\ProfileUpdateRequest;
use App\Repositories\ProfileRepository;

class GlanceController extends Controller
{
	/**
	 * @param $string
	 * @return mixed
	 */
	public function getUserIdBaseOnNickname($target_nickname){

		$target_user_id = Profile::wherenickname($target_nickname) ->firstOrFail() ->user_id;

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
			$target_user_id = $this -> getUserIdBaseOnNickname($target_nickname);
			$current_user_id = Auth::user()->id;

			if ($target_user_id != $current_user_id)
			{
				return redirect()->action('ProfileController@show', [$target_nickname]);
			}
			$user = $this ->getUserByUserId($target_user_id);

			$acceptedGroups = $user->groups()->wherePivot('accepted', true)->paginate(20);
		}
		catch(\Exception $e)
		{
			return redirect('404');
		}
		return view('pages.glancePage', compact('user', 'target_user_id', 'acceptedGroups'));
//		return response()->json();
	}
	
}
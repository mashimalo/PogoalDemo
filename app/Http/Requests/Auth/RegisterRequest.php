<?php namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class RegisterRequest extends Request {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|min:6|confirmed',
			'nickname'=>'required|not_in:auth,docking,group,home,leaderboard,notifications,password,profile,fuck|max:30|unique:profiles',
			'agreement' =>'accepted',
		];
	}
}

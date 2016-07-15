<?php namespace App\Services;

class role  {

	/**
	 * Set the login user role
	 * 
	 * @param  App\Models\User $user
	 * @return void
	 */
	public function setLoginRole($user)
	{
		session()->put('role', $user->role->slug);
	}

	/**
	 * Set the visitor user role
	 * 
	 * @return void
	 */
	public function setVisitorRole()
	{
		session()->put('role', 'visitor');
	}

	/**
	 * Set the role
	 * 
	 * @return void
	 */
	public function setRole()
	{
		if(!session()->has('role'))
		{
			session()->put('role', auth()->check() ?  auth()->user()->role->slug : 'visitor');
		}
	}

}
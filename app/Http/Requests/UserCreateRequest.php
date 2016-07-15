<?php namespace App\Http\Requests;

class UserCreateRequest extends Request {

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
			'first_name' =>'required|max:30',
			'last_name' =>'required|max:30',
			'gender_id' =>'required|integer|max:3|min:1',
			'date_of_birth' =>'required|date_format:Y-m-d',
		];
	}
}
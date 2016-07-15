<?php namespace App\Http\Requests\Admin;

class UserUpdateRequest extends Request {

	/**
	 * use for admin app
	 *
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$id = $this->user->id;
		return $rules = [
			'email' => 'required|email|unique:users,email,' . $id
		];
	}

}

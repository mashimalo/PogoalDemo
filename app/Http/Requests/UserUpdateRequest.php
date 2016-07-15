<?php namespace App\Http\Requests;

class UserUpdateRequest extends Request {

	/**
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

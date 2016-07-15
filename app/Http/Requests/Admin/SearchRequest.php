<?php namespace App\Http\Requests\Admin;

class SearchRequest extends Request {

	/**
	 * use for admin app
	 *
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'first_name' =>'required|max:30',
		];
	}

}

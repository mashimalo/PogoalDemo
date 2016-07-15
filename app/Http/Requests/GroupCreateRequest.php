<?php namespace App\Http\Requests;

class GroupCreateRequest extends Request {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'name' => 'required|max:30',
			'group_type_id' =>'required|integer|min:1',
			'description' => 'required|max:150',
			'privacy_rule_id' =>'required|integer|min:1',
			'agreement' =>'accepted',
		];
	}

}

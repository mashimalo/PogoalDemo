<?php namespace App\Http\Requests;

class DockingGroupEditRequest extends Request {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'docking_group_name' => 'required|max:30',
			'privacy_rule_id' =>'required|integer|min:1',
		];
	}

}
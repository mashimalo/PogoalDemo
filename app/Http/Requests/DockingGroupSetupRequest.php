<?php namespace App\Http\Requests;

class DockingGroupSetupRequest extends Request {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'source_group_id' => 'required|integer',
			'target_group_id' => 'required|integer',
			'docking_group_name' => 'required|max:30',
			'privacy_rule_id' =>'required|integer|min:1',
			'agreement' =>'accepted',
		];
	}

}
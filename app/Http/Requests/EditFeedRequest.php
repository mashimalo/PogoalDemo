<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditFeedRequest extends Request {

	public function rules()
	{
		return [
			'feed' => 'required|max:5000',
		];
	}

}
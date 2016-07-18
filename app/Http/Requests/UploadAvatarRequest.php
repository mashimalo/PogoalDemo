<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadAvatarRequest extends FormRequest {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
            'uploadImage' => 'required|image|max:1000'
		];
	}

	public function authorize()
	{
		return true;
	}

}

<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditCommentRequest extends Request {

	public function rules() {
		return [
			'editComment' => 'required|max:1000',
		];
	}

}
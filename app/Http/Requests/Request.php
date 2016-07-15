<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest {

    protected  $dontFlash = ['password', 'password_confirmation', '_token'];

    public function authorize()
    {
        // Honeypot
        return  $this->input('address') == '';
    }

}
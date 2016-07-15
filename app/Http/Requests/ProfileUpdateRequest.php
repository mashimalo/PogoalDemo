<?php namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class ProfileUpdateRequest extends Request {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //get current profile id.
        $id = Auth::user()->profile->id;

        return [
            'first_name' =>'required|alpha|max:30',
            'last_name' =>'required|alpha|max:30',
            'nickname'=>'required|max:30|unique:profiles,nickname,'. $id,  //ignore the current row.
            'gender_id' =>'required|integer|max:3|min:1',
            'date_of_birth' =>'required|date_format:Y-m-d',
            'bio'=>'required|max:255',
        ];
    }
}

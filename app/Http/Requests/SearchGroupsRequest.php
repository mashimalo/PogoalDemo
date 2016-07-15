<?php namespace App\Http\Requests;
/**
 * Created by PhpStorm.
 * User: Mashimalo
 * Date: 2016/3/16
 * Time: 23:21
 */

use Illuminate\Foundation\Http\FormRequest;

class SearchGroupsRequest extends Request {

    public function rules()
    {
        return [
            'searchGroups' => 'max:30|required',
        ];
    }

}

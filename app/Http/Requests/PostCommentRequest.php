<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostCommentRequest extends Request {

    public function rules()
    {
        $feed_id = $this->route('feed_id');
        return [
            "reply-{$feed_id}" => 'required|max:1000,'
        ];
    }

}

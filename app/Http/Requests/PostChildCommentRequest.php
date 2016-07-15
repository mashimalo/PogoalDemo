<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostChildCommentRequest extends Request {

    public function rules()
    {
        $comment_id = $this->route('comment_id');
        return [
            "2ndReply-{$comment_id}" => 'required|max:1000',
        ];
    }

}

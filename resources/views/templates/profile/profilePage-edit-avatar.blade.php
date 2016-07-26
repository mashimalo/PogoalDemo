{!! Form::model($user->profile,['name'=>'profileAvatarUpload-form','id'=>'profileAvatarUpload-form','route'=> ['uploadProfileAvatar',$user->profile->nickname],'method'=>'POST', 'files' => true])!!}

<div class="uiCard__header">
    <div class="h4">Avatar</div>
</div>

<div class="uiCard__content">

    <div class="container">

        <div class="wrap mB--xxlg">
            <label class="c-f-3">Preview:</label>
            <div class="c-f-9">
                @if ($user->profile->user_avatar_large != null || strlen($user->profile->user_avatar_large) > 0)
                    <img src="{!! '/images/userAvatar/'.$user->profile->user_avatar_large !!}" class="avatar avatar--lg arc-sm">
                @else
                    <img data-name="{{ empty_eitherName_displayNickname($user) }}" class="initialAvatar avatar avatar--lg arc-sm">
                @endif
            </div>
        </div>

        <div class="wrap">
            <label for="#uploadImage" class="c-f-3">Upload a new avatar:</label>
            <div class="c-f-9">
                <div class="form-group form-control">
                    {!! Form::file('uploadImage') !!}
                </div>
            </div>
        </div>

    </div>
</div>

<div class="uiCard__footer text-right">
    {!! Form::submit('Submit',['class'=>'btn btn-primary']) !!}
</div>

{!! Form::close() !!}
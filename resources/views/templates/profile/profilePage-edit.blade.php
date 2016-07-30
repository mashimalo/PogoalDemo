{!! Form::model($user->profile,['name'=>'profileEdit-form','id'=>'profileEdit-form','route'=> ['profile.update',$user->profile->nickname],'method'=>'PATCH','data-toggle'=>'validator'])!!}
<div class="uiCard__header">
    <div class="h4">Personal Information</div>
</div>
<div class="uiCard__content">
    {{----------------------------
    | First Name & Last Name
    ----------------------------}}
    <div class="wrap">
        <div class="c-f-3">
            {!! Form::label('first_name','First name:') !!}
        </div>
        <div class="c-f-9">
            <div class="form-group form-prepend {{ $errors->has('first_name')?'has-error':null }}">
                {!! Form::text('first_name',null,['class'=>'form-control','required']) !!}
                <span class="form-prepend-item icon icon-identity"></span>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
    <div class="wrap">
        <div class="c-f-3">
            {!! Form::label('last_name','Last name:') !!}
        </div>
        <div class="c-f-9">
            <div class="form-group form-prepend {{ $errors->has('last_name')?'has-error':null }}">
                {!! Form::text('last_name',null,['class'=>'form-control','required']) !!}
                <span class="form-prepend-item icon icon-identity"></span>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>


    {{----------------------------
    | Nickname
    ----------------------------}}
    <div class="wrap">
        <div class="c-f-3">
            {!! Form::label('nickname','Nickname:') !!}
        </div>
        <div class="c-f-9">
            <div class="form-group form-prepend {{ $errors->has('nickname')?'has-error':null }}">
                {!! Form::text('nickname',null,['class'=>'form-control','pattern'=>'[A-Za-z]+','data-minlength'=>'3','data-minlength-error'=>'Minimum of 3 characters','data-error'=>'Alphabets only.','required']) !!}
                <span class="form-prepend-item icon icon-identity"></span>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>

    {{----------------------------
    | Date of Birth
    ----------------------------}}
    <div class="wrap">
        <div class="c-f-3">
            {!! Form::label('date_of_birth','Birthday (example: 1980-01-30)') !!}
        </div>
        <div class="c-f-9">
            <div class="form-group form-prepend {{ $errors->has('date_of_birth')?'has-error':null }}">
                {!! Form::text('date_of_birth',null,['class'=>'form-control','required']) !!}
                <span class="form-prepend-item icon icon-cake"></span>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>


    {{----------------------------
    | Gender
    ----------------------------}}
    <div class="wrap">
        <div class="c-f-3">
            <label for="">Gender:</label>
        </div>
        <div class="c-f-9">
            <div class="form-group {{ $errors->has('gender_id')?'has-error':null }}">
                <label class="label-md-light radio-inline">
                    {!! Form::radio('gender_id','1',['required','false']) !!}
                    Male
                </label>
                <label class="label-md-light radio-inline">
                    {!! Form::radio('gender_id','2',['required','false']) !!}
                    Female
                </label>
                <label class="label-md-light radio-inline">
                    {!! Form::radio('gender_id','3',['required','false']) !!}
                    Neutral
                </label>
            </div>
        </div>
    </div>

    {{----------------------------
    | Bio
    ----------------------------}}
    <div class="wrap">
        <div class="c-f-3">
            {!! Form::label('bio','About me:') !!}
        </div>
        <div class="c-f-9">
            <div class="form-group {{ $errors->has('bio')?'has-error':null }}">
                {!! Form::textarea('bio',null,['class'=>'form-control h--auto']) !!}
            </div>
        </div>
    </div>

    <div class="wrap">
        <div class="c-f-3"></div>
        <div class="c-f-9">
            <p class="mB mB--md">If you need to change email please contact us.</p>
        </div>
    </div>

</div>

{{----------------------------
| Submit button
----------------------------}}
<div class="uiCard__footer text-right">
    {!! Form::submit('Update',['class'=>'btn btn-primary']) !!}
</div>
{!!  Form::close() !!}
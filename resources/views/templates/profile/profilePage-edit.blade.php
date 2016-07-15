{{----------------------------
| Edit Profile List
----------------------------}}
<div class="uiCards c-f-3">
    <div class="uiCard">
        <div class="uiCard__body">
            <div class="uiCard__header">
                <div class="h4">
                    Details
                </div>
            </div>
            <ul class="uiTabs__nav uiTabs__nav--list">
                <li class="active">
                    <a href="#tabs-1" data-toggle="tab" class="lk-d lk-block">Personal Information</a>
                </li>
                <li>
                    <a href="#tabs-2" data-toggle="tab" class="lk-d lk-block">Profile</a>
                </li>
            </ul>
        </div>
    </div>
</div>

{{----------------------------
| Edit Profile
----------------------------}}
<div class="uiCards c-f-9">
    <div class="uiCard">
        {{----------------------------
        | Personal Infomation Tab
        ----------------------------}}
        <div id="tabs-1" class="uiCard__body uiTabs__content active">
            <div class="uiCard__header">
                <div class="h4">Personal Information</div>
            </div>
            <div class="uiCard__content">
                {!! Form::model($user->profile,['name'=>'profileEdit-form','id'=>'profileEdit-form','route'=> ['profile.update',$user->profile->nickname],'method'=>'PATCH','data-toggle'=>'validator'])!!}

                {{----------------------------
                | Check Session
                ----------------------------}}
                @if(session()->has('ok'))
                    @include('partials.error',['type'=>'success','message'=>session('ok')])
                @endif

                @include('templates.session.checkSession-errorList')

                {{----------------------------
                | First Name & Last Name
                ----------------------------}}
                <div class="wrap">
                    <div class="c-f-6">
                        {!! Form::label('first_name','First name:') !!}
                        <div class="form-group form-prepend {{ $errors->has('first_name')?'has-error':null }}">
                            {!! Form::text('first_name',null,['class'=>'form-control','required']) !!}
                            <span class="form-prepend-item icon icon-identity"></span>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="c-f-6">
                        {!! Form::label('last_name','Last name:') !!}
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
                {!! Form::label('nickname','Nickname:') !!}
                <div class="form-group form-prepend {{ $errors->has('nickname')?'has-error':null }}">
                    {!! Form::text('nickname',null,['class'=>'form-control','pattern'=>'[A-Za-z]+','data-minlength'=>'3','data-minlength-error'=>'Minimum of 3 characters','data-error'=>'Alphabets only.','required']) !!}
                    <span class="form-prepend-item icon icon-identity"></span>
                    <div class="help-block with-errors"></div>
                </div>

                {{----------------------------
                | Date of Birth
                ----------------------------}}
                {!! Form::label('date_of_birth','Birthday (example: 1980-01-30)') !!}
                <div class="form-group form-prepend {{ $errors->has('date_of_birth')?'has-error':null }}">
                    {!! Form::text('date_of_birth',null,['class'=>'form-control','required']) !!}
                    <span class="form-prepend-item icon icon-cake"></span>
                    <div class="help-block with-errors"></div>
                </div>

                {{----------------------------
                | Gender
                ----------------------------}}
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

                {{----------------------------
                | Bio
                ----------------------------}}
                {!! Form::label('bio','About me:') !!}
                <div class="form-group {{ $errors->has('bio')?'has-error':null }}">
                    {!! Form::textarea('bio',null,['class'=>'form-control h--auto']) !!}
                </div>

                <p class="mB mB--md">If you need to change email please contact us.</p>

                {{----------------------------
                | Submit button
                ----------------------------}}
                {!! Form::submit('Update',['class'=>'btn btn-primary btn-block']) !!}

                {!!  Form::close() !!}
            </div>
        </div>
        {{----------------------------
        | Profile Tab
        ----------------------------}}
        <div id="tabs-2" class="uiCard__body uiTabs__content">
            <div class="uiCard__header">
                <div class="h4">Profile</div>
            </div>
            <div class="uiCard__content">
                Upload Avatar Here.
            </div>
        </div>
    </div>
</div>

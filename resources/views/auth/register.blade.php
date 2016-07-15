@extends('layouts.default')

@section('pageTitle')
    {{ trans("front/page-title.sign-up") }}
@stop

@section('content')

    {{----------------------------
    | Page Title
    ----------------------------}}
    <h2 class="page-title text-center">Join the Family</h2>

    {{----------------------------
    | Log In Form
    ----------------------------}}
    {!! Form::open(['name'=>'register-form','id'=>'register-form','url'=>'auth/register','method'=>'post','data-toggle'=>'validator']) !!}
    <div class="uiBox uiBox--sm">

        <div class="uiBox__body">
            <h4 class="text-center">Sign Up</h4>

            {{----------------------------
            | Check Session
            ----------------------------}}
            @include('templates.session.checkSession-errorList')

            {{----------------------------
            | E-mail Input
            ----------------------------}}
            <div class="form-group form-prepend {{ $errors->has('email')?'has-error':null }}">
                {!! Form::email('email', null, ['class'=>'form-control','placeholder'=>'E-mail','data-error'=>'This email address is invalid.','required']) !!}
                <span class="form-prepend-item icon icon-envelope"></span>
                <div class="help-block with-errors"></div>
            </div>

            {{----------------------------
            | NickName Input
            ----------------------------}}
            <div class="form-group form-prepend {{ $errors->has('nickname')?'has-error':null }}">
                {!! Form::text('nickname',null,['class'=>'form-control','placeholder'=>'Nickname','pattern'=>'[A-Za-z]+','data-minlength'=>'3','data-minlength-error'=>'Minimum of 3 characters','data-error'=>'Alphabets only.','required']) !!}
                <span class="form-prepend-item icon icon-identity"></span>
                <div class="help-block with-errors"></div>
            </div>

            {{----------------------------
            | Password input
            ----------------------------}}
            <div class="form-group form-prepend {{ $errors->has('password')?'has-error':null }}">
                {!! Form::password('password',['id'=>'register-password','class'=>'form-control','placeholder'=>'Password','data-minlength'=>'6','data-error'=>'Minimum of 6 characters','required']) !!}
                <span class="form-prepend-item icon icon-lock"></span>
                <div class="help-block with-errors"></div>
            </div>

            {{----------------------------
            | Password confirmation input
            ----------------------------}}
            <div class="form-group form-prepend {{ $errors->has('password_confirmation')?'has-error':null }}">
                {!! Form::password('password_confirmation',['class'=>'form-control','placeholder'=>'Confirm Password','data-match'=>'#register-password','data-match-error'=>'Your passwords do not match.','required']) !!}
                <span class="form-prepend-item icon icon-lock"></span>
                <div class="help-block with-errors"></div>
            </div>

            {{----------------------------
            | Accept Agreement
            | TODO: insert agreement
            ----------------------------}}
            <div class="form-group {{ $errors->has('agreement')?'has-error':null }}">
                <label class="label-md-light checkbox-uncheck">
                    {!! Form::checkbox('agreement','yes',['required','false']) !!}
                    I have read and accepted <a href="#">Agreement</a>
                </label>
            </div>

        </div>

        <div class="uiBox__footer text-center uiBox__footer__btn">
            {{----------------------------
            | Submit button
            ----------------------------}}
            {!! Form::submit('Sign Up',['class'=>'btn-primary btn-block']) !!}
        </div>

    </div>
    {!! Form::close() !!}

    <div class="text-center">
        <p class="text-light">Already a member?</p>
        <a href="{{ url('auth/login') }}">Log In</a>
    </div>

@stop
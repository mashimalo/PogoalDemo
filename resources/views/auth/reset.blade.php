@extends('layouts.default')

@section('pageTitle')
    {{ trans("front/page-title.reset-password") }}
@stop

@section('content')

    {{----------------------------
    | Page Title
    ----------------------------}}
    <h2 class="page-title text-center">Reset your password</h2>

    {{----------------------------
    | Log In Form
    ----------------------------}}
    {!! Form::open(['name'=>'form','id'=>'reset-form','url'=>'password/reset','method'=>'post','data-toggle'=>'validator']) !!}
    <div class="uiBox uiBox--sm">

        <div class="uiBox__body">
            <h4 class="text-center">Enter the require information</h4>

            {{----------------------------
            | Check Session
            ----------------------------}}
            @include('templates.session.checkSession-errorList')

            {!! Form::hidden('token',$token) !!}
            {{----------------------------
            | E-mail input
            ----------------------------}}
            <div class="form-group form-prepend">
                {!! Form::email('email',null,['class'=>'form-control','placeholder'=>'E-mail','data-error'=>'This email address is invalid.','required']) !!}
                <span class="form-prepend-item icon icon-envelope"></span>
                <div class="help-block with-errors"></div>
            </div>

            {{----------------------------
            | Password input
            ----------------------------}}
            <div class="form-group form-prepend">
                {!! Form::password('password',['id'=>'reset-password','class'=>'form-control','placeholder'=>'Password','data-minlength'=>'6','data-error'=>'Minimum of 6 characters','required']) !!}
                <span class="form-prepend-item icon icon-lock"></span>
                <div class="help-block with-errors"></div>
            </div>

            {{----------------------------
            | Password confirmation input
            ----------------------------}}
            <div class="form-group form-prepend">
                {!! Form::password('password_confirmation',['class'=>'form-control','placeholder'=>'Confirm Password','data-match'=>'#reset-password','data-match-error'=>'Your passwords do not match.','required']) !!}
                <span class="form-prepend-item icon icon-lock"></span>
                <div class="help-block with-errors"></div>
            </div>

        </div>

        <div class="uiBox__footer text-center uiBox__footer__btn">
            {{----------------------------
            | Submit button
            ----------------------------}}
            {!! Form::submit('Submit',['class'=>'btn-primary btn-block']) !!}
        </div>

    </div>
    {!! Form::close() !!}

@stop
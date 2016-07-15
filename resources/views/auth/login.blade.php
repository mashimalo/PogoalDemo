@extends('layouts.default')

@section('pageTitle')
    {{ trans("front/page-title.log-in") }}
@stop

@section('content')

    {{----------------------------
    | Page Title
    ----------------------------}}
    <h2 class="page-title text-center">Welcome back</h2>

    {{----------------------------
    | Log In Form
    ----------------------------}}
    {!! Form::open(['name'=>'login-form','id'=>'login-form','url'=>'auth/login','method' => 'post','data-toggle'=>'validator',]) !!}
    <div class="uiBox uiBox--sm">

        <div class="uiBox__body">
            <h4 class="text-center">Log In</h4>

            {{----------------------------O
            | Check Session
            ----------------------------}}
            @include('templates.session.checkSession')

            {{----------------------------
            | E-mail input
            ----------------------------}}
            <div class="form-group form-prepend {{ session()->has('error')?'has-error':null }}">
                {!! Form::email('email',null,['class'=>'form-control','placeholder'=>'E-mail','data-error'=>'This email address is invalid.','required']) !!}
                <span class="form-prepend-item icon icon-envelope"></span>
                <div class="help-block with-errors"></div>
            </div>

            {{----------------------------
            | Password input
            ----------------------------}}
            <div class="form-group form-prepend {{ session()->has('error')?'has-error':null }}">
                {!! Form::password('password',['class'=>'form-control','placeholder'=>'Password','required']) !!}
                <span class="form-prepend-item icon icon-lock"></span>
                <div class="help-block with-errors"></div>
            </div>

            {{----------------------------
            | Stay logged in checkbox
            ----------------------------}}
            <div class="form-group">
                <label class="label-md-light">
                    {!! Form::checkbox('remember','remember',['checked']) !!}
                    Stay logged in
                </label>
                {{----------------------------
                | Forgot Password Link
                ----------------------------}}
                <a href="{{ url('password/email') }}" class="small pull-right">Forgot password?</a>
            </div>

        </div>

        <div class="uiBox__footer text-center uiBox__footer__btn">
            {{----------------------------
            | Submit button
            ----------------------------}}
            {!! Form::submit('Log In',['class'=>'btn-primary btn-block']) !!}
        </div>

    </div>
    {!! Form::close() !!}

    <div class="text-center">
        <p class="text-light">Not a member yet?</p>
        <a href="{{ url('auth/register') }}">Sign Up</a>
    </div>

@stop
@extends('layouts.default')

@section('pageTitle')
    {{ trans("front/page-title.forgot-password") }}
@stop

@section('content')

    {{----------------------------
    | Page Title
    ----------------------------}}
    <h2 class="page-title text-center">Find Your Account</h2>

    {{----------------------------
    | Forgot Password Form
    ----------------------------}}
    {!! Form::open(['name'=>'forgotPassword-form','id' => 'forgotPassword-form','data-toggle'=>'validator',]) !!}
    <div class="uiBox uiBox--sm">

        <div class="uiBox__body">
            <h4 class="text-center">Enter your email bellow.</h4>

            {{----------------------------
            | Check Session
            ----------------------------}}
            @include('templates.session.checkSession')

            <div class="form-group form-prepend ">
                {!! Form::email('email',null,['class'=>'form-control','placeholder'=>'E-mail','data-error'=>'This email address is invalid.','required']) !!}
                <span class="form-prepend-item icon icon-envelope"></span>
                <div class="help-block with-errors"></div>
            </div>
        </div>

        <div class="uiBox__footer text-center uiBox__footer__btn">
            {!! Form::submit('Submit',['id'=>'forgotPassword-submit','class'=>'btn-primary btn-block']) !!}
        </div>

    </div>
    {!! Form::close() !!}

    <div class="text-center">
        <p class="text-light">Not a member yet?</p>
        <a href="{{ url('auth/register') }}" id="switch-to-signup">Sign Up</a>
    </div>

@stop
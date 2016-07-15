@extends('layouts.default')

@section('pageTitle')
    {{ empty_eitherName_displayNickname(Auth::user()) }}
@stop

{{----------------------------
    | Sub Bar
    ----------------------------}}
@section('navBar')
    @include('templates.navBar.navBar')
@stop

{{----------------------------
| Content
----------------------------}}
@section('content')

    {{----------------------------
    | Check Session
    ----------------------------}}
    @include('templates.session.checkSession')

    {{----------------------------
    | Content
    ----------------------------}}
    @if(currentRoute('notifications'))
        @include('templates.glance.glancePage-notifications')
    @endif
    @if(currentRoute('glance'))
        @include('templates.glance.glancePage-groups')
    @endif

@stop
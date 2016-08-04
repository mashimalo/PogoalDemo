@extends('layouts.full')

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
    <div class="site-container">
        @include('templates.session.checkSession')
    </div>

    {{----------------------------
    | Content
    ----------------------------}}
    @if(currentRoute('glance'))
        @include('templates.glance.glancePage-discover')
    @endif

    @if(currentRoute('glanceMyGroups'))
        @include('templates.glance.glancePage-groups')
    @endif

    @if(currentRoute('notifications'))
        @include('templates.glance.glancePage-notifications')
    @endif

@stop
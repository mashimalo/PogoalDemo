@extends('layouts.default-top')

@section('pageTitle')
    {{$group->name}} | Profile
@stop

{{----------------------------
| Add Page Class to <body>
----------------------------}}
@section('pageClass')
    {{ $validate_currentUser_in_group ? 'currentUserInGroup':'' }}
@stop

{{----------------------------
| Page Top
----------------------------}}
@section('top')
    @include('templates.group.singleGroupPage-cover')
@stop

{{----------------------------
| Page Content
----------------------------}}
@section('content')

    <div class="wrap">
        {{----------------------------
        | Single Page Group Left
        ----------------------------}}
        <div class="sgp-left c-f-3">
            @include('templates.group.singleGroupPage-left')
        </div>

        {{----------------------------
        | Single Page Group Middle
        ----------------------------}}
        <div class="sgp-main c-f-9">

            @include('templates.group.singleGroupPage-top')

            {{----------------------------
            | Single Page Profile
            ----------------------------}}
            @include('templates.group.singleGroupPage-profile')

        </div>
    </div>

@stop
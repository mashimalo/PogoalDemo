@extends('layouts.default-top')

@section('pageTitle')
    {{$group->name}} | Members
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
            | Single Page Group Members
            ----------------------------}}
            @include('templates.group.singleGroupPage-members')

        </div>
    </div>

@stop
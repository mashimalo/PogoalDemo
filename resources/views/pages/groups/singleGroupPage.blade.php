@extends('layouts.default-top')

@section('pageTitle')
    {{$group->name}}
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
        | Single Page Group Top
        ----------------------------}}
        <div class="sgp-main c-f-9">
            @include('templates.group.singleGroupPage-top')
            {{----------------------------
            | Single Page Group Feed
            ----------------------------}}
            @if ( !validate_if_targetGroup_is_private ($group->id) || $validate_currentUser_in_group)
                @include('templates.group.singleGroupPage-main')
            @else
                    Join us to view the Feed & Comment!
            @endif
        </div>
    </div>

@stop
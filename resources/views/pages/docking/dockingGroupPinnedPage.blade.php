@extends('layouts.default')

@section('pageTitle')
    {{$dockingGroup->docking_group_name}} | Pinned Feeds
@stop

{{----------------------------
| Add Page Class to <body>
----------------------------}}
@section('pageClass')
    {{ $validate_currentUser_in_dockingGroup ? 'currentUserInGroup':'' }}
@stop

{{----------------------------
| Content
----------------------------}}
@section('content')

    <div class="wrap">
        {{----------------------------
        | Bridging Group Page Left
        ----------------------------}}
        <div class="docking-side c-f-2">
            @include('templates.docking.dockingGroupPage-left')
        </div>

        {{----------------------------
        | Bridging Group Page Top
        ----------------------------}}
        <div class="docking-main c-f-8">
            @include('templates.docking.dockingGroupPage-top')

            {{----------------------------
            | Bridging Group Page Feed
            ----------------------------}}
            @if ( !validate_if_target_dockingGroup_is_private ($dockingGroup_id) || $validate_currentUser_in_dockingGroup)
                @include('templates.docking.dockingGroupPage-pinned')
            @else
                This bridging group is private, please join one of the group to join the fun!
            @endif
        </div>

        {{----------------------------
        | Bridging Group Page Right
        ----------------------------}}
        <div class="docking-side c-f-2">
            @include('templates.docking.dockingGroupPage-right')
        </div>
    </div>

@stop
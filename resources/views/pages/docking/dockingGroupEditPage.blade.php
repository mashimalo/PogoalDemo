@extends('layouts.default')

@section('pageTitle')
    {{$dockingGroup->docking_group_name}} | Edit Bridging Group
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
            | Bridging Group Page Edit
            ----------------------------}}
            @include('templates.docking.dockingGroupPage-edit')
        </div>

        {{----------------------------
        | Bridging Group Page Right
        ----------------------------}}
        <div class="docking-side c-f-2">
            @include('templates.docking.dockingGroupPage-right')
        </div>
    </div>

@stop
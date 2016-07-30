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

    {{--------------------------
    | Bridging Group Name
    --------------------------}}
    <h2 class="text-xlg mB--lg text-center">
        {{ $dockingGroup->docking_group_name }}
    </h2>

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
                <div class="uiCard mB--xlg">
                    <div class="uiCard__body">
                        <div class="uiCard__content">
                            <div class="text-center pA--lg text-lighter">
                                <span class="icon icon-info-line text-xxxlg"></span>
                                <p class="text-lg">
                                    This is a private bridging group, you must join one of the group to view content.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
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
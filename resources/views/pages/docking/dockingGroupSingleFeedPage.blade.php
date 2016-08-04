@extends('layouts.default')

@section('pageTitle')
    {{--TODO: make the page title--}}
    Bridge Group Feed Page
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
        | Bridging Group Page Sidebars
        ----------------------------}}
        <div class="docking-side c-f-3">
            <div class="sgp-left__info uiCard mB--md">
                <div class="uiCard__body">
                    <div class="bold text-uppercase pA--md lh-avatar--md bordered--b">
                        Posted in
                    </div>
                    <div class="clearfix pA--md">
                        <div class="bolder mB--md">
                            {{ $dockingGroup->docking_group_name }}
                        </div>
                        <a href="{{ url_link_to_dockingGroup ($dockingGroup->id) }}" class="btn btn-primary btn-block">
                            <span class="icon icon-double-arrow-left mR"></span>
                            View More Feeds
                        </a>
                    </div>
                </div>
            </div>
            @include('templates.docking.dockingGroupPage-left')
            @include('templates.docking.dockingGroupPage-right')
        </div>

        {{----------------------------
        | Bridging Group Page Top
        ----------------------------}}
        <div class="docking-main c-f-9">

            {{----------------------------
            | Bridging Group Page Feed
            ----------------------------}}
            @if ( !validate_if_target_dockingGroup_is_private ($dockingGroup_id) || $validate_currentUser_in_dockingGroup)
                @include('templates.docking.single-feed.dockingGroupSingleFeed-feed')
            @else
                <div class="uiCard mB--xlg">
                    <div class="uiCard__body">
                        <div class="uiCard__content">
                            <div class="text-center pA--lg text-lighter">
                                <span class="icon icon-info-line text-xxxlg"></span>

                                <p class="text-lg">
                                    This is a private bridging group feed, you must join one of the group to view content.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

@stop
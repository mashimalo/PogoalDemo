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
        | Bridging Group Page Left
        ----------------------------}}
        <div class="docking-side c-f-2">
            @include('templates.docking.dockingGroupPage-left')
        </div>

        {{----------------------------
        | Bridging Group Page Top
        ----------------------------}}
        <div class="docking-main c-f-8">

            {{----------------------------
            | Bridging Group Page Feed
            ----------------------------}}

            {{--TODO: this is how to use the URL you can use this in group feed page:--}}
            <a href="{{ url_link_to_dockingGroupSingleFeedPage ($dockingGroup->id, $feed->id) }}">URL of this feed</a>
            <br/>
            <a href="{{ url_link_to_dockingGroup ($dockingGroup->id) }}">URL to go back to the bridge group</a>

            @if ( !validate_if_target_dockingGroup_is_private ($dockingGroup_id) || $validate_currentUser_in_dockingGroup)
                @include('templates.docking.feed.dockingGroupPage-feed')
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

        {{----------------------------
        | Bridging Group Page Right
        ----------------------------}}
        <div class="docking-side c-f-2">
            @include('templates.docking.dockingGroupPage-right')
        </div>
    </div>

@stop
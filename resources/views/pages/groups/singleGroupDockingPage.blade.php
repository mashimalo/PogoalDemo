@extends('layouts.default-top')

@section('pageTitle')
    {{$group->name}} | Bridging
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
            | Single Page Bridging
            ----------------------------}}
            @if ( !validate_if_targetGroup_is_private ($group->id) || $validate_currentUser_in_group)
                @include('templates.group.singleGroupPage-docking')
            @else
                <div class="uiCard mB--xlg">
                    <div class="uiCard__body">
                        <div class="uiCard__content">
                            <div class="text-center pA--lg text-lighter">
                                <span class="icon icon-info-line text-xxxlg"></span>
                                <p class="text-lg">
                                    This is a private group, you must join to view content.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

@stop
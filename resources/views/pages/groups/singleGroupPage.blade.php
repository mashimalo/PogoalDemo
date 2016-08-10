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

            @if (!$validate_currentUser_in_group)
                <div class="uiCard mB--xlg">
                    {!! Form::model($group, ['route'=> ['joinGroup', 'group_id' => $group->id], 'method'=>'POST','id'=>'join-group', 'role'=>'form'])!!}
                    <div class="uiCard--body bg--stretch" style="background-image: url('/assets/images/hero-slide-1.jpg');">
                        <div class="uiCard__content bg--darker text-center pV--lg">
                            <div class="h4 mB--md">Your are not our member yet.</div>
                            {!! Form::submit('Join Now',['id'=>'join-group-submit','class'=>'btn btn-outline-white']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            @endif

            @include('templates.group.singleGroupPage-top')

            {{----------------------------
            | Single Page Group Feed
            ----------------------------}}
            @if ( !validate_if_targetGroup_is_private ($group->id) || $validate_currentUser_in_group)
                @include('templates.group.singleGroupPage-main')
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
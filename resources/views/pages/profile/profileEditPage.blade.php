@extends('layouts.default-top')

@section('pageTitle')
    {{ empty_eitherName_displayNickname($user) }}
@stop

{{----------------------------
| Page Top
----------------------------}}
@section('top')
    @include('templates.profile.profilePage-top')
@stop

{{----------------------------
| Page Content
----------------------------}}
@section('content')
    <div class="wrap">
        <div class="uiCards c-f-3">
            <div class="uiCard">
                <div class="uiCard__body">
                    <div class="uiCard__header">
                        <div class="h4">
                            Details
                        </div>
                    </div>
                    <ul class="uiTabs__nav uiTabs__nav--list">
                        <li class="{{ set_active('profile.edit', 'active') }}">
                            <a href="{{ url_link_to_editProfile() }}" class="lk-d lk-block">Personal Information</a>
                        </li>
                        <li class="{{ set_active('profileAvatarPage', 'active') }}">
                            <a href="{{ url_link_to_profileAvatarPage() }}" class="lk-d lk-block">Avatar</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="uiCards c-f-9">

            {{----------------------------
            | Check Session
            ----------------------------}}
            @if(session()->has('ok'))
                @include('partials.error',['type'=>'success','message'=>session('ok')])
            @endif

            @include('templates.session.checkSession-errorList')


            <div class="uiCard">
                <div class="uiCard__body uiTabs__content active">

                    @if(currentRoute("profile.edit"))
                        @include("templates.profile.profilePage-edit")
                    @endif

                    @if(currentRoute("profileAvatarPage"))
                        @include("templates.profile.profilePage-edit-avatar")
                    @endif

                </div>
            </div>
        </div>
    </div>
@stop
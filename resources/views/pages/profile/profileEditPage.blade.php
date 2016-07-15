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
        @include('templates.profile.profilePage-edit')
    </div>
@stop
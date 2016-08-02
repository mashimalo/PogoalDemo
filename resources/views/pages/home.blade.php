@extends('layouts.full')

{{----------------------------
| Content
----------------------------}}
@section('content')

    <div class="site-container mB--xxxlg">
        {{----------------------------
        | Check Session
        ----------------------------}}
        @include('templates.session.checkSession')

        {{----------------------------
        | Page Title
        ----------------------------}}
        <h2 class="page-title text-center">{{ trans("front/page-title.find-your-group") }}</h2>

        {{----------------------------
        | Content
        ----------------------------}}
        @include('templates.home.groupCategories')
    </div>

@stop
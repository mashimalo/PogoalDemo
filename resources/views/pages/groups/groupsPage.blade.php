@extends('layouts.default')

@section('pageTitle')
    {{ trans("front/page-title.groups") }}
@stop

@section('content')

    {{----------------------------
    | Page Title
    ----------------------------}}
    <h2 class="page-title text-center">{{ trans("front/page-title.find-your-group") }}</h2>

@stop
@extends('layouts.default')

@section('pageTitle')
    Something Went Wrong
@stop

{{----------------------------
| Add Page Class to <body>
----------------------------}}
@section('pageClass')
    somethingWentWrong
@stop

{{----------------------------
| Content
----------------------------}}
@section('content')

    {{----------------------------
    | Page Title
    ----------------------------}}
    <h2 class="page-title text-center">Oops! Something Went Wrong</h2>

    <div class="site-container">
        <a href="{{ URL::route("home") }}" class="btn btn-primary center-table" role="button">
            Return to homepage
        </a>
    </div>

@stop
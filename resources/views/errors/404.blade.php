@extends('layouts.default')

@section('pageTitle')
    Page Not Found
@stop

{{----------------------------
| Add Page Class to <body>
----------------------------}}
@section('pageClass')
    pageNotFound
@stop

{{----------------------------
| Content
----------------------------}}
@section('content')

    {{----------------------------
    | Page Title
    ----------------------------}}
    <h2 class="page-title text-center">Oops! Page Not Found</h2>

    <div class="site-container">
        <a href="{{ URL::route("home") }}" class="btn btn-primary center-table" role="button">
            Return to homepage
        </a>
    </div>

@stop
<!DOCTYPE html>
<html lang="en-US">
<head>

    <!--

         .//////////.  .//////////.  .///////////  .//////////.  ./////////.   ////
        ////    ////  ////`  `////  ////////////  ////`  `////  ////`  `////  ////
       ///////////'  ////    ////  ////          ////    ////  ////////////  ////
      ////          ////    ////  ////    ////  ////    ////  ////    ////  ////
     ////          ////.  .////  ////////////  ////.  .////  ////    ////  ///////////.
    `//'          `//////////'   `/////////'  `//////////'  ////    ////  `///////////

    -->

    <meta charset="UTF-8">
    <meta name="viewport" content="width=1170, user-scalable=yes" />
    <meta name="_token" content="{!! csrf_token() !!}" />
    @if(Auth::check())
        <meta name="user_firstName" content="{!! getUserFirstName() !!}" />
        <meta name="user_lastName" content="{!! getUserLastName() !!}" />
    @endif
    <title>
        @if (!empty($__env->yieldContent('pageTitle')))
            @yield('pageTitle') |
        @endif
        {{ trans('front/brand.pogoal') }}
    </title>

    {{----------------------------
    | CSS in Head
    ----------------------------}}
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
    {!! Html::style("assets/css/main.min.css") !!}
    {!! Html::style("assets/css/temporary.css") !!}
    {!! Html::script("assets/js/libs/outdatedbrowser.min.js") !!}
    {!! Html::script("assets/js/libs/jquery-1.11.3.min.js") !!}

</head>

<body class="site {{Route::getCurrentRoute()->getName()}} {{Auth::guest()?'visitor':null}} {{yield_has_content($__env,'navBar','has-navBar')}} @yield('pageClass')">

    {{----------------------------
    | Pre-Loader
    ----------------------------}}
    <div id="preloader"></div>

    {{----------------------------
    | Header
    ----------------------------}}
    <header id="header" class="site__header">
        @include('templates.toolbar')
        @yield('navBar')
    </header>

    {{----------------------------
    | Page
    ----------------------------}}
    <div id="page" class="site__page">

        {{-----------------------------------------------------------------------------
        | Slider
        ------------------------------------------------------------------------------}}
        @if(Auth::guest() && currentRoute('home'))
            @include('templates.slider.slider')
        @endif
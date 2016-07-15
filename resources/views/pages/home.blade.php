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

    {{----------------------------
    | Call Out Section
    ----------------------------}}
    @if(Auth::check())
        <div class="w--full mB--xxxlg">
            <div class="bg--stretch" style="background-image: url('/assets/images/cover-abstract.jpg');">
                <div class="bg--dark">
                    <div class="site-container text-center">
                        <div class="vA-block--middle w--full h--lg">
                            <div class="vA__item">
                                <div class="uiCallout center-table mB">
                                    <div class="uiCallout__article">
                                        Share, validate and get feedback for your ideas
                                    </div>
                                    <button class="uiCallout__button btn btn-primary" data-scroll="scroll" data-target="#content">
                                        Join A Group
                                    </button>
                                </div>
                                <div class="uiCallout center-table mB">
                                    <div class="uiCallout__article">
                                        Create your own startup groups
                                    </div>
                                    <a href="{{ URL::route ('singleGroupCreatePage-show') }}" class="uiCallout__button btn btn-primary">
                                        Create a Group
                                    </a>
                                </div>
                                <div class="uiCallout center-table">
                                    <div class="uiCallout__article">
                                        Start a joint conversation with other groups
                                    </div>
                                    <a href="#" class="uiCallout__button btn btn-primary">
                                        Bridge a Group
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@stop
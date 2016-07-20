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
                            <div class="vA__item wrap">
                                <div class="c-f-4">
                                    <div class="shadow--hover">
                                        <div class="arc-sm-top pH--md pA--lg bg--lighter text-dark bold">
                                            Share, validate and get feedback for your ideas
                                        </div>
                                        <button class="btn btn-primary btn-block arc-sm-bottom" data-scroll="scroll" data-target="#content">
                                            Join A Group
                                        </button>
                                    </div>
                                </div>
                                <div class="c-f-4">
                                    <div class="shadow--hover">
                                        <div class="arc-sm-top pH--md pA--lg bg--lighter text-dark bold">
                                            Create your own startup groups
                                        </div>
                                        <a href="{{ URL::route ('singleGroupCreatePage-show') }}" class="btn btn-primary btn-block arc-sm-bottom">
                                            Create a Group
                                        </a>
                                    </div>
                                </div>
                                <div class="c-f-4">
                                    <div class="shadow--hover">
                                        <div class="arc-sm-top pH--md pA--lg bg--lighter text-dark bold">
                                            Start a joint conversation with other groups
                                        </div>
                                        <a href="#" class="btn btn-primary btn-block arc-sm-bottom">
                                            Bridge a Group
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@stop
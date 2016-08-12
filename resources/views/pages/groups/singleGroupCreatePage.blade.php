{{--@inject ('countries', 'App\Http\Utilities\Country')--}}
{{--@inject ('GroupCategories', 'App\Http\Utilities\GroupCategory')--}}

@extends('layouts.default')

@section('pageTitle')
    {{ trans("front/page-title.create-new-group") }}
@stop

@section('content')

    {{----------------------------
    | Page Title
    ----------------------------}}
    <h2 class="page-title text-center">{{ trans("front/page-title.build-your-family") }}</h2>

    {{----------------------------
    | Single Group Create Form
    ----------------------------}}
    {!! Form::open(['name'=>'createGroup-form','id'=>'createGroup-form','route'=>'singleGroupCreatePage-post','method'=>'post','data-toggle'=>'validator']) !!}

    <div class="uiBox uiBox--md">

        <div class="uiBox__body">
            <h4 class="text-center">{{ trans("front/page-title.create-new-group") }}</h4>

            {{----------------------------
            | Check Session
            ----------------------------}}
            @include('templates.session.checkSession')
            @include('templates.session.checkSession-errorList')

            {{----------------------------
            | Group Name Input
            ----------------------------}}
            <div class="form-group form-prepend form-prepend-label">
                {!! Form::label('group_name','Group Name') !!}
                {!! Form::text('name', null, ['id'=>'group_name','class'=>'form-control','placeholder'=>'Group Name','required']) !!}
                <span class="form-prepend-item icon icon-group"></span>

                <div class="help-block with-errors"></div>
            </div>

            {{----------------------------
            | Group Category Option
            ----------------------------}}
            <div class="mB--lg">
                <div id="singleGroup-group-category" class="inline-block mR--md">
                    <span class="bolder mR">Group Category:</span>
                    <span id="singleGroup-group-category-selected" class="text-green text-uppercase bolder">Choose a Group Category</span>
                </div>
                <div id="singleGroup-group-category-button" class="btn btn-primary btn-square rounded link-fake text-xlg"
                     data-toggle="modal"
                     data-target="#singleGroup-group-category-modal" role="button">
                    +
                </div>
                <div id="singleGroup-group-category-change-button" class="btn btn-blue btn-sm small"
                     style="display: none;"
                     data-toggle="modal"
                     data-target="#singleGroup-group-category-modal" role="button">
                    Change
                </div>
            </div>


            {{----------------------------
            | Group Category Modal
            | Todo: Injected $GroupTypes, see line 1
            ----------------------------}}
            <div class="uiModal fade" id="singleGroup-group-category-modal">
                <div class="uiModal__dialog uiModal--md">
                    <div class="uiModal__content">
                        <div class="uiModal__header">
                            <button class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                            <div class="h3 text-center">
                                Choose a Group Type
                            </div>
                        </div>
                        <div class="uiModal__body pL--xxlg pR--xxlg mB--none">
                            <div class="form-group">
                                <div class="wrap">
                                    @foreach(App\Models\GroupType::all() as $groupType)
                                        <div class="c-f-4 mB--md">
                                            <label class="label-md-light radio-inline">
                                                <input type="radio" name="group_type_id" value="{{ $groupType->id }}" required>
                                                {{ $groupType->group_type_name }}
                                            </label>
                                        </div>
                                    @endforeach
                                    {{--@foreach($GroupCategories::all() as $GroupCategory => $code)--}}
                                    {{--<div class="c-f-4 mB--md">--}}
                                    {{--<label class="label-md-light radio-inline">--}}
                                    {{--<input type="radio" name="group_type_id" value="{{ $code }}" required>--}}
                                    {{--{{ $GroupCategory }}--}}
                                    {{--</label>--}}
                                    {{--</div>--}}
                                    {{--@endforeach--}}
                                </div>
                            </div>
                        </div>
                        <div class="uiModal__footer text-right">
                            <button class="btn btn-primary" data-dismiss="modal">
                                Ok
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{----------------------------
            | Category Option
            ----------------------------}}
            {{--<div class="form-group form-prepend">--}}
            {{--{!! Form::select('group_category', array(--}}
            {{--'creative' => 'Creative',--}}
            {{--'music' => 'Music',--}}
            {{--'pet' => 'Pet',--}}
            {{--'sport' => 'Sport',--}}
            {{--'gourmet' => 'Gourmet',--}}
            {{--'education' => 'Education',--}}
            {{--'other' => 'Other'--}}
            {{--), null, ['class'=>'form-control','placeholder'=>'Category','required']) !!}--}}
            {{--<span class="form-prepend-item icon icon-star"></span>--}}
            {{--<div class="help-block with-errors"></div>--}}
            {{--</div>--}}


            {{--<div class="wrap">--}}
            {{--------------------------
            | Country Option
            --------------------------}}
            {{--<div class="c-f-4">--}}
            {{--<div class="form-group form-prepend">--}}
            {{--<select name="group_country" id="singleGroup-country" class="form-control" required="required">--}}
            {{------------------------------------
            | Todo: Injected $counties, see line 1
            ------------------------------------}}
            {{--@foreach($countries::all() as $country => $code)--}}
            {{--<option value="{{ $code }}">{{ $country }}</option>--}}
            {{--@endforeach--}}
            {{--</select>--}}
            {{--<span class="form-prepend-item icon icon-flag"></span>--}}
            {{--<div class="help-block with-errors"></div>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{------------------------------}}
            {{--| State/Province Option--}}
            {{------------------------------}}
            {{--<div class="c-f-4">--}}
            {{--<div class="form-group form-prepend">--}}
            {{--{!! Form::text('group_province', null, ['class'=>'form-control','placeholder'=>'State/Province','required']) !!}--}}
            {{--<span class="form-prepend-item icon icon-map-marker"></span>--}}
            {{--<div class="help-block with-errors"></div>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{------------------------------}}
            {{--| Group City Input--}}
            {{------------------------------}}
            {{--<div class="c-f-4">--}}
            {{--<div class="form-group form-prepend">--}}
            {{--{!! Form::text('group_city', null, ['class'=>'form-control','placeholder'=>'City','required']) !!}--}}
            {{--<span class="form-prepend-item icon icon-map-marker"></span>--}}
            {{--<div class="help-block with-errors"></div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{----------------------------
            | Invite Group Member
            ----------------------------}}
            {{--<div class="form-group form-prepend form-prepend-label mB--xxlg">--}}
                {{--{!! Form::label('group_email','Invite members:') !!}--}}
                {{--{!! Form::email('email', null, ['class'=>'form-control','placeholder'=>'Emails','id'=>'group_email', 'title'=>'Use ( , ) to add an email.']) !!}--}}
                {{--<div class="help-block with-errors"></div>--}}
                {{--<div class="text-light small mT"><span class="icon icon-warn mR"></span>Invite member is currently unavailable</div>--}}
                {{--<div class="text-light small mT">Use ( , ) to add an email.</div>--}}
            {{--</div>--}}

            {{----------------------------
            | Bio
            ----------------------------}}
            <div class="form-group form-prepend form-prepend-label">
                {!! Form::label('group_description','Group Description:') !!}
                {!! Form::textarea('description',null,['class'=>'form-control h--auto','placeholder'=>'Group description...']) !!}
                <span class="form-prepend-item icon icon-summary"></span>
            </div>

            {{----------------------------
            | Make Group Private
            ----------------------------}}
            <div class="form-group form-prepend">
                <label for="privacy_rule_id">Group Privacy Setting: </label>
                <br>
                @foreach(App\Models\PrivacyRule::all() as $privacyRule)
                    <div class="mR inline-block">
                        <label class="label-md radio-inline">
                            <input type="radio" name="privacy_rule_id" value="{{ $privacyRule->id }}" required>
                            {{ $privacyRule->rule_description }}
                        </label>
                    </div>
                @endforeach
            </div>

            {{----------------------------
            | Accept Agreement
            | TODO: insert agreement
            ----------------------------}}
            <div class="form-group">
                <label class="label-md-light checkbox-uncheck">
                    {!! Form::checkbox('agreement','yes',['required','false']) !!}
                    I have read and accepted <a href="#">Agreement</a>
                </label>
            </div>

        </div>

        <div class="uiBox__footer text-center uiBox__footer__btn">
            {{----------------------------
            | Submit button
            ----------------------------}}
            {!! Form::submit('Create',['class'=>'btn-primary btn-block']) !!}
        </div>

    </div>
    {!! Form::close() !!}
@stop
{{--<div class="uiAlert uiAlert--info uiAlert--dismissible" role="alert">--}}
{{--<button type="button" class="close" data-dismiss="alert">--}}
{{--<span aria-hidden="true">&times;</span>--}}
{{--<span class="hidden-text">{{ trans('front/uiAlert.close') }}</span>--}}
{{--</button>--}}
{{--<span class="uiAlert__icon icon icon-info"></span>--}}
{{--<div class="uiAlert__content text-left small">--}}
{{--<p>You have 3 Notifications.</p>--}}
{{--</div>--}}
{{--</div>--}}

@include('templates.session.checkSession')

<div class="sgp-main__items">

    {{----------------------------
    | Rich Form post feed
    ----------------------------}}
    @if ($validate_currentUser_in_group)
        @if(currentRoute('singleGroupPage'))
            <div class="rich-form sgp-main__item">

                <div class="rich-form-body">
                    {!! Form::textarea('feed',null,['class'=>'form-control bg-white h--sm','placeholder'=>'Spit it out...','data-elastic'=>'rich-form']) !!}
                    @if (Auth::user()->profile->user_avatar_small != null || strlen(Auth::user()->profile->user_avatar_small) > 0)
                        <img src="{!! '/images/userAvatar/'.Auth::user()->profile->user_avatar_small !!}"
                             class="rich-form-avatar avatar avatar--md arc-sm">
                    @else
                        <img data-name="{{ empty_firstName_displayNickname(Auth::user()) }}"
                             class="initialAvatar rich-form-avatar avatar avatar--md arc-sm"/>
                    @endif
                </div>

                <div class="rich-form-footer">
                    <div class="pull-left">
                        <span class="icon icon-camera lk-block"></span>
                    </div>

                    <div class="pull-right">
                        <button class="btn btn-primary" data-action="post-feed" data-action-for="group" data-group-id="{{ $group->id }}">
                            Post
                        </button>
                    </div>
                </div>

                {{--{!! Form::model($group, ['route'=> ['feed-post', $group->id], 'method'=>'POST','id'=>'post-feed', 'data-toggle'=>'validator', 'role'=>'form'])!!}--}}
                {{--<div class="rich-form-body">--}}
                {{--{!! Form::textarea('feed',null,['class'=>'form-control bg-white h--sm','placeholder'=>'Spit it out...','data-elastic'=>'rich-form']) !!}--}}
                {{--<img data-name="{{ getUserFirstName() }}"--}}
                {{--class="initialAvatar rich-form-avatar avatar avatar--md arc-sm"/>--}}
                {{--<img class="rich-form-avatar avatar avatar--md arc-sm" src="{{ url('/assets/images/avatar.jpg') }}">--}}
                {{--</div>--}}

                {{--<div class="rich-form-footer">--}}
                {{--<div class="pull-left">--}}
                {{--<span class="icon icon-camera lk-block"></span>--}}
                {{--</div>--}}

                {{--<div class="pull-right">--}}
                {{--{!! Form::submit('Post',['class'=>'btn btn-primary']) !!}--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--{!! Form::close() !!}--}}

            </div>
        @endif
    @endif
</div>
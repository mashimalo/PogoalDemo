{{----------------------------
| Group Infomation
----------------------------}}
<div class="sgp-left__info uiCard mB--md">
    <div class="uiCard__body">

        @if(currentRoute('show-groupSingleFeedPage'))
            <div class="bold text-uppercase pA--md lh-avatar--md bordered--b">
                Posted in
            </div>
        @endif

        <div class="clearfix pA--md">
            <a href="{{ url_link_to_group($group->id) }}" class="pull-left mR--sm">
                @if ($group->group_avatar_large != null || strlen($group->group_avatar_large) > 0)
                    <img src="{!! '/images/groupAvatar/'.$group->group_avatar_large !!}"
                         class="avatar avatar--lg arc-sm">
                @else
                    <img class="avatar avatar--lg arc-sm" src="{{ url('/assets/images/avatar.jpg') }}">
                @endif
            </a>
            <div class="overflow-h">
                <a href="{{ url_link_to_group($group->id) }}" class="lk-darker bolder break-word">
                    {{$group->name}}
                </a>
                <div class="small text-light text-overflow mT">
                    <div>
                        <span class="icon icon-category mR"></span>
                        {{ getGroupTypeName($group) }}
                    </div>
                    @if(currentRoute('show-groupSingleFeedPage'))
                        <div>
                            <span class="icon icon-send-line mR"></span>
                            {{ $group->feeds->count() }}
                        </div>
                        <div>
                            <span class="icon icon-user-solid mR"></span>
                            {{ $group->acceptUsers()->count() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if(currentRoute('show-groupSingleFeedPage'))
            <div class="pH--md mB--md">
                <a href="{{ url_link_to_group($group->id) }}" class="btn btn-primary btn-block">
                    <span class="icon icon-double-arrow-left mR"></span>
                    View More Feeds
                </a>
            </div>
        @endif

        <div class="small pA--md break-word bg-body-above bordered--t">
            <div class="mB text-uppercase bolder">
                About
            </div>
            {{$group->description}}
        </div>

    </div>
</div>

{{----------------------------
| Group Votes
----------------------------}}
{{--<div class="sgp-left__vote uiCard">--}}
{{--<div class="uiCard__body">--}}
{{--<div class="h4 uiCard__header">--}}
{{--<span class="icon icon-check-square mR"></span>--}}
{{--Votes--}}
{{--</div>--}}
{{--<div class="uiCard__content break-word">--}}
{{--<div class="mB--md small">--}}
{{--<div class="mB--md small text-light">--}}
{{--Lorem ipsum dolor sit amet, consectetur adipisicing elit. Neque, nobis.--}}
{{--</div>--}}
{{--<div class="form-group">--}}
{{--<label class="label-md-light radio-inline">--}}
{{--{!! Form::radio('vote_id_01','1',['required','false']) !!}--}}
{{--Lorem ipsum dolor sit.--}}
{{--</label>--}}
{{--</div>--}}
{{--<div class="form-group">--}}
{{--<label class="label-md-light radio-inline">--}}
{{--{!! Form::radio('vote_id_01','1',['required','false']) !!}--}}
{{--Lorem ipsum dolor sit.--}}
{{--</label>--}}
{{--</div>--}}
{{--<div class="form-group">--}}
{{--<label class="label-md-light radio-inline">--}}
{{--{!! Form::radio('vote_id_01','1',['required','false']) !!}--}}
{{--Lorem ipsum dolor sit.--}}
{{--</label>--}}
{{--</div>--}}
{{--<div class="form-group">--}}
{{--<label class="label-md-light radio-inline">--}}
{{--{!! Form::radio('vote_id_01','1',['required','false']) !!}--}}
{{--Lorem ipsum dolor sit.--}}
{{--</label>--}}
{{--</div>--}}
{{--<div class="form-group">--}}
{{--<label class="label-md-light radio-inline">--}}
{{--{!! Form::radio('vote_id_01','1',['required','false']) !!}--}}
{{--Lorem ipsum dolor sit.--}}
{{--</label>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="btn btn-outline-gray btn-block">Submit</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}

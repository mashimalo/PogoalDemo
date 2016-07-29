@if (!$validate_currentUser_in_group)
    <div class="uiCard mB--md">
        {!! Form::model($group, ['route'=> ['joinGroup', 'group_id' => $group->id], 'method'=>'POST','id'=>'join-group', 'role'=>'form'])!!}
        <div class="uiCard--body bg--stretch" style="background-image: url('/assets/images/hero-slide-1.jpg');">
            <div class="uiCard__content bg--darker text-center pV--lg">
                <div class="h4 mB--md">Your are not our member yet.</div>
                {!! Form::submit('Join Now',['id'=>'join-group-submit','class'=>'btn btn-outline-white']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endif

{{----------------------------
| Group Infomation
----------------------------}}
<div class="sgp-left__info uiCard mB--md">
    {{--<div class="uiTile">--}}
    {{--<a href="{{ url_link_to_group($group->id) }}">--}}
    {{--<img class="uiTile__avatar avatar avatar--xlg arc-sm" src="{{ url('/assets/images/avatar.jpg') }}">--}}
    {{--</a>--}}
    {{--<div class="uiTile__body arc-sm">--}}
    {{--<div class="uiTile__content bg-white">--}}
    {{--<div class="uiTile__title h3 bold mB">--}}
    {{--<a href="{{ url_link_to_group($group->id) }}" class="lk-darker break-word">--}}
    {{--{{ $group->name }}--}}
    {{--</a>--}}
    {{--</div>--}}
    {{--<div class="uiTile__description small text-light mB">--}}
    {{--{{ $group->description }}--}}
    {{--</div>--}}
    {{--<div class="uiTile__date text-light small">--}}
    {{--<span class="icon icon-calendar mR"></span>--}}
    {{--{{$group->created_at->format('M d, Y')}}--}}
    {{--</div>--}}
    {{--<div class="uiTile__members text-light small">--}}
    {{--<span class="icon icon-group mR"></span>--}}
    {{--{{ singularOrPlural($group->acceptUsers()->count(), "member", "members", "0") }}--}}
    {{--</div>--}}
    {{--<div class="uiTile__category text-light small">--}}
    {{--<span class="icon icon-category mR"></span>--}}
    {{--{{ getGroupTypeName($group) }}--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}

    <div class="uiCard__body">
        <div class="cover cover--xsm arc-sm-top">
            {{--<div class="cover__photo">--}}
            {{--<img src="{{ url('/assets/images/profile__cover__photo__placeholder.png') }}" class="arc-sm-top" alt="Profile Cover Photo"/>--}}
            {{--</div>--}}
        </div>
        <div class="uiCard__content">
            <div class="sgp-left__group__avatar">
                <a href="{{ url_link_to_group($group->id) }}">
                    @if ($group->group_avatar_large != null || strlen($group->group_avatar_large) > 0)
                        <img src="{!! '/images/groupAvatar/'.$group->group_avatar_large !!}"
                             class="avatar avatar--lg arc-sm">
                    @else
                        <img class="avatar avatar--lg arc-sm" src="{{ url('/assets/images/avatar.jpg') }}">
                    @endif
                </a>
            </div>
            <div class="sgp-left__group__name">
                <a href="{{ url_link_to_group($group->id) }}" class="lk-darker">
                    {{$group->name}}
                </a>
            </div>
            <div class="sgp-left__group__description small mB--md break-word">
                {{$group->description}}
            </div>
            <div class="small text-light text-overflow">
                <span class="icon icon-category mR"></span>
                {{ getGroupTypeName($group) }}
                <br>
                <span class="icon icon-calendar mR"></span>
                {{$group->created_at->format('M d, Y')}}
            </div>
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
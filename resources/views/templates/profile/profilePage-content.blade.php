<div class="text-lg c-f-12 text-light bold mB--lg">
    <span class="icon icon-group mR"></span>
    @if(is_profile_owner($target_user_id))
        My Groups
    @else
        {{ empty_eitherName_displayNickname($user) }}'s Groups
    @endif
</div>

@foreach($acceptedGroups as $group)
    <div class="uiTile c-f-o-3 mB--md">
        <div class="uiTile__body arc-md">
            <div class="uiTile__cover">
                <a href="{{ url_link_to_group($group->id) }}">
                    <img class="uiTile__avatar avatar avatar--fluid" src="{{ url('/assets/images/avatar.jpg') }}">
                </a>
            </div>
            <div class="uiTile__content bg-white">
                <div class="uiTile__title bold mB">
                    <a href="{{ url_link_to_group($group->id) }}" class="lk-darker">
                        {{ $group->name }}
                    </a>
                </div>
                <div class="uiTile__description small text-light mB text-overflow">
                    {{ str_limit($group->description,25) }}
                </div>
                <div class="uiTile__members text-light small">
                    <span class="icon icon-group mR"></span>
                    {{ singularOrPlural($group->acceptUsers()->count(), "member", "members", "0 member") }}
                </div>
                <div class="uiTile__category text-light small">
                    <span class="icon icon-category mR"></span>
                    {{ getGroupTypeName($group) }}
                </div>
            </div>
        </div>
    </div>
@endforeach

{{----------------------------
| Left Column
----------------------------}}
{{--<div class="uiCards c-f-4">--}}
{{--<div class="uiCard">--}}
{{--<div class="uiCard__body">--}}
{{--<div class="uiCard__header">--}}
{{--<div class="h4">--}}
{{--<span class="icon icon-info-line mR"></span>--}}
{{--About--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="uiCard__content">--}}
{{--<ul class="inlinePs">--}}
{{--<li class="inlineP">--}}
{{--<label class="inlineP__label">First name:</label>--}}
{{--<div class="inlineP__content">{{$user->profile->first_name}}</div>--}}
{{--</li>--}}
{{--<li class="inlineP">--}}
{{--<label class="inlineP__label">Last name:</label>--}}
{{--<div class="inlineP__content">{{$user->profile->last_name}}</div>--}}
{{--</li>--}}
{{--<li class="inlineP">--}}
{{--<label class="inlineP__label">Nickname:</label>--}}
{{--<div class="inlineP__content">{{$user->profile->nickname}}</div>--}}
{{--</li>--}}
{{--<li class="inlineP">--}}
{{--<label class="inlineP__label">Birthday:</label>--}}
{{--<div class="inlineP__content">{{$user->profile->date_of_birth}}</div>--}}
{{--</li>--}}
{{--<li class="inlineP">--}}
{{--<label class="inlineP__label">Gender:</label>--}}
{{--<div class="inlineP__content">--}}
{{--@if($user->profile->gender_id == 1)--}}
{{--Male--}}
{{--@elseif($user->profile->gender_id == 2)--}}
{{--Female--}}
{{--@else--}}
{{--Neutral--}}
{{--@endif--}}
{{--</div>--}}
{{--</li>--}}
{{--</ul>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}

{{--<div class="uiCard">--}}
{{--<div class="uiCard__body">--}}
{{--<div class="uiCard__header">--}}
{{--<div class="h4">--}}
{{--<span class="icon icon-contact-info mR"></span>--}}
{{--Contact--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="uiCard__content">--}}
{{--<ul class="inlinePs inlinePs--short">--}}
{{--<li class="inlineP">--}}
{{--<label class="inlineP__label">E-mail:</label>--}}
{{--<div class="inlineP__content">--}}
{{--@if(Auth::check() && Auth::user()->id == $target_user_id)--}}
{{--{{$user->email}}--}}
{{--@else--}}
{{--******--}}
{{--@endif--}}
{{--</div>--}}
{{--</li>--}}
{{--<li class="inlineP">--}}
{{--<label class="inlineP__label">Phone:</label>--}}
{{--<div class="inlineP__content">--}}
{{--N/A--}}
{{--</div>--}}
{{--</li>--}}
{{--<li class="inlineP">--}}
{{--<label class="inlineP__label">Website:</label>--}}
{{--<div class="inlineP__content">--}}
{{--N/A--}}
{{--</div>--}}
{{--</li>--}}
{{--</ul>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}

{{----------------------------
| Right Column
----------------------------}}
{{--<div class="uiCards c-f-8">--}}

{{--<div class="uiCard">--}}
{{--<div class="uiCard__body">--}}
{{--<div class="uiCard__header">--}}
{{--<div class="h4">--}}
{{--<span class="icon icon-summary mR"></span>--}}
{{--Summary--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="uiCard__content">--}}
{{--{{$user->profile->bio}}--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}

{{--<div class="uiCard">--}}
{{--<div class="uiCard__body">--}}
{{--<div class="uiCard__header">--}}
{{--<div class="h4">--}}
{{--<span class="icon icon-activity-line mR"></span>--}}
{{--Activities--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="uiCard__content">--}}
{{--No activity at this moment.--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}

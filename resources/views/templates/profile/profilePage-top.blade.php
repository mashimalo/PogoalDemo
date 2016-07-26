<div class="cover cover__bg cover--darker cover--md" style="background-image: url('{{ url('/assets/images/cover-abstract.jpg') }}');">
    <div class="cover__static">
        <div class="site-container">
            <div class="pull-left">
                {{------------------------------
                | Avatar
                ------------------------------}}
                @if(is_profile_owner($target_user_id))
                    <a href="{{ url_link_to_profile() }}" class="cover__static__avatar rounded">
                        @if ($user->profile->user_avatar_large != null || strlen($user->profile->user_avatar_large) > 0)
                            <img src="{!! '/images/userAvatar/'.$user->profile->user_avatar_large !!}" class="avatar avatar--lg rounded mR">
                        @else
                            <img data-name="{{ empty_eitherName_displayNickname($user) }}" class="initialAvatar avatar avatar--lg rounded mR">
                        @endif
                    </a>
                @else
                    <a href="{{ url_link_to_target_profile($target_nickname) }}" class="cover__static__avatar rounded">
                        @if ($user->profile->user_avatar_large != null || strlen($user->profile->user_avatar_large) > 0)
                        <img src="{!! '/images/userAvatar/'.$user->profile->user_avatar_large !!}" class="avatar avatar--lg rounded mR">
                        @else
                            <img data-name="{{ empty_eitherName_displayNickname($user) }}" class="initialAvatar avatar avatar--lg rounded mR">
                        @endif
                    </a>
                @endif

                {{------------------------------
                | Info
                ------------------------------}}
                <div class="cover__static__info">

                    {{------------------------------
                    | User name
                    ------------------------------}}
                    @if(empty($user->profile->first_name) || empty($user->profile->last_name))
                        @if(is_profile_owner($target_user_id))
                            <a href="{{ url_link_to_editProfile() }}" class="cover__static__info__name h2 mR--md cover__color--primary">
                                Enter your name
                            </a>
                        @else
                            <a href="{{ url_link_to_target_profile($target_nickname) }}"
                               class="cover__static__info__name h2 mR--md cover__color--primary">
                                {{$user->profile->nickname}}
                            </a>
                        @endif
                    @else
                        @if(is_profile_owner($target_user_id))
                            <a href="{{ url_link_to_profile() }}" class="cover__static__info__name h2 mR--md cover__color--primary">
                                {{$user->profile->first_name}} {{$user->profile->last_name}}
                            </a>
                        @else
                            <a href="{{ url_link_to_target_profile($target_nickname) }}"
                               class="cover__static__info__name h2 mR--md cover__color--primary">
                                {{$user->profile->first_name}} {{$user->profile->last_name}}
                            </a>
                        @endif
                    @endif

                    {{------------------------------
                    | User nickname
                    ------------------------------}}
                    @if(is_profile_owner($target_user_id))
                        <a href="{{ url_link_to_profile() }}" class="text-green h3">
                            <span class="icon icon-user-solid"></span>
                            {{ $user->profile->nickname }}
                        </a>
                    @else
                        <a href="{{ url_link_to_target_profile($target_nickname) }}" class="text-green h3">
                            <span class="icon icon-user-solid"></span>
                            {{ $user->profile->nickname }}
                        </a>
                    @endif

                    {{------------------------------
                    | Member since
                    ------------------------------}}
                    <p class="cover__static__info__time cover__color--primary">
                        Member since: {{$user->created_at->format("F Y")}}
                    </p>
                </div>
            </div>
            <div class="pull-right">
                <ul class="list-inline">
                    <li class="mR--md">
                        <div class="thin text-xxxlg cover__color--primary">
                            {{ $user->groups()->wherePivot('accepted', true)->get()->count() }}
                        </div>
                        <div class="bolder small cover__color--secondary text-uppercase">
                            Groups
                        </div>
                    </li>
                    <li class="mR--md">
                        <div class="thin text-xxxlg cover__color--primary">
                            0
                        </div>
                        <div class="bolder small cover__color--secondary text-uppercase">
                            Followers
                        </div>
                    </li>
                    <li>
                        <div class="thin text-xxxlg cover__color--primary">
                            0
                        </div>
                        <div class="bolder small cover__color--secondary text-uppercase">
                            Following
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="cover__mask"></div>
</div>

<div class="cover__child cover--darker">
    <div class="cover__child__nav has-sticky__bar">
        <div class="sticky__bar">
            <div class="site-container">
                {{------------------------------
                | Menu
                ------------------------------}}
                <ul class="list-inline pull-left">
                    <li>
                        @if(is_profile_owner($target_user_id))
                            <a href="{{ url_link_to_profile() }}" class="{{ set_active('profile', 'cP bolder') }}">
                                {{ trans("front/general.profile") }}
                            </a>
                        @else
                            <a href="{{ url_link_to_target_profile($target_nickname) }}" class="{{ set_active('profile', 'cP bolder') }}">
                                {{ trans("front/general.profile") }}
                            </a>
                        @endif
                    </li>
                    @if(is_profile_owner($target_user_id))
                        <li>
                            <a href="{{ url_link_to_editProfile() }}" class="{{ set_active('profile.edit', 'cP bolder') }}">
                                {{ trans("front/general.editProfile") }}
                            </a>
                        </li>
                    @endif
                </ul>


                <div class="pull-right">
                    {{------------------------------
                    | Invite to Group
                    ------------------------------}}
                    <button class="btn btn-primary arc-md bar-btn-mT mR" data-action="not-available" title="Invite to my Group">
                        + Invite
                    </button>

                    {{------------------------------
                    | Follow
                    ------------------------------}}
                    <button class="btn btn-blue arc-md bar-btn-mT" data-action="not-available" title="Follow this user">
                        + Follow
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{------------------------------
    | Profile Content
    ------------------------------}}
    <div class="cover__child__content">
        <div class="site-container">
            <div class="wrap pT--lg pB--lg">
                @if(currentRoute("profile.edit"))
                    <div class="c-f-12">
                        <span class="bolder cover__color--secondary">Edit your personal information or upload an avatar here.</span>
                    </div>
                @else
                    <div class="c-f-4 pR--xxxlg">
                        <div class="wrap mB--md">
                            <div class="c-f-12">
                                <div class="bold text-uppercase cover__color--secondary mB small">Profile Completeness</div>
                                <div class="lvlBar mB--sm">
                                    <div class="lvlBar__count">{{ user_profile_completeness($user) }}%</div>
                                    <div class="lvlBar__inner" style="width:{{ user_profile_completeness($user) }}%;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="wrap mB--md">
                            <div class="c-f-12">
                                <div class="bold text-uppercase cover__color--secondary mB small">Activities</div>
                                <p>No activity at this moment.</p>
                            </div>
                        </div>
                    </div>
                    <div class="c-f-8">
                        <div class="wrap mB--md">
                            <div class="c-f-12">
                                <div class="bold text-uppercase cover__color--secondary mB small">About</div>
                                <p>{!! nl2br(e($user->profile->bio)) !!}</p>
                            </div>
                        </div>
                        <div class="wrap mB--md">
                            <div class="c-f-4">
                                <div class="bold text-uppercase cover__color--secondary mB small">From</div>
                                <p>Currently unavailable</p>
                            </div>
                            <div class="c-f-4">
                                <div class="bold text-uppercase cover__color--secondary mB small">Birth</div>
                                <p>{{ $user->profile->date_of_birth }}</p>
                            </div>
                            <div class="c-f-4">
                                <div class="bold text-uppercase cover__color--secondary mB small">Gender</div>
                                <p>
                                    @if($user->profile->gender_id == 1)
                                        Male
                                    @elseif($user->profile->gender_id == 2)
                                        Female
                                    @else
                                        Neutral
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="wrap mb--md">
                            <div class="c-f-4">
                                <div class="bold text-uppercase cover__color--secondary mB small">Joined</div>
                                <p>{{$user->created_at->format("F d, Y")}}</p>
                            </div>
                            <div class="c-f-4">
                                <div class="bold text-uppercase cover__color--secondary mB small">Contact</div>
                                <p>
                                    @if(is_profile_owner($target_user_id))
                                        {{$user->email}}
                                    @else
                                        ******
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{----------------------------
| Profile Bar
----------------------------}}
{{--<div class="profile__bar has-sticky__bar">--}}
{{--<div class="sticky__bar">--}}
{{--<div class="site-container">--}}

{{------------------------------}}
{{--| Avatar--}}
{{------------------------------}}
{{--@if(is_profile_owner($target_user_id))--}}
{{--<a href="#" class="profile__bar__avatar imgCovers arc-md">--}}
{{--<img data-name="{{ empty_firstName_displayNickname($user) }}" class="initialAvatar avatar avatar--xxlg arc-md"/>--}}
{{--<img class="avatar avatar--xxlg arc-md" src="{{ url('/assets/images/avatar.jpg') }}">--}}
{{--<div class="imgCover imgCover--dark arc-md">--}}
{{--<div class="imgCover__info text-center">--}}
{{--<span class="icon icon-camera"></span>--}}
{{--{{ trans("front/profile.change-avatar") }}--}}
{{--</div>--}}
{{--</div>--}}
{{--</a>--}}
{{--@else--}}
{{--<div class="profile__bar__avatar arc-md arc-md">--}}
{{--<img data-name="{{ empty_firstName_displayNickname($user) }}" class="initialAvatar avatar avatar--xxlg arc-md"/>--}}
{{--</div>--}}
{{--@endif--}}

{{------------------------------}}
{{--| Animated Name--}}
{{------------------------------}}
{{--<div class="profile__bar__name">--}}
{{--<span class="transit--linear">--}}
{{--@if(empty($user->profile->first_name) || empty($user->profile->last_name))--}}
{{--@if(is_profile_owner($target_user_id))--}}
{{--<a href="{{ url_link_to_editProfile() }}">Enter your name</a>--}}
{{--@else--}}
{{--{{$user->profile->nickname}}--}}
{{--@endif--}}
{{--@else--}}
{{--{{$user->profile->first_name}} {{$user->profile->last_name}}--}}
{{--@endif--}}
{{--</span>--}}
{{--</div>--}}

{{------------------------------}}
{{--| Info--}}
{{------------------------------}}
{{--<div class="profile__bar__info cover__color--primary">--}}
{{--<div class="h2 text-uppercase">--}}
{{--@if(empty($user->profile->first_name) || empty($user->profile->last_name))--}}
{{--@if(is_profile_owner($target_user_id))--}}
{{--<a href="{{ url_link_to_editProfile() }}" class="cover__color--primary">Enter your name</a>--}}
{{--@else--}}
{{--{{$user->profile->nickname}}--}}
{{--@endif--}}
{{--@else--}}
{{--{{$user->profile->first_name}} {{$user->profile->last_name}}--}}
{{--@endif--}}
{{--</div>--}}
{{--</div>--}}

{{------------------------------}}
{{--| Badges--}}
{{------------------------------}}
{{--<ul class="badges uiTooltip--hide badges--sm">--}}
{{--<li class="badge badge--c" data-show="tooltip" data-trigger="hover" data-placement="bottom"--}}
{{--title="Verified!">--}}
{{--<span class="icon icon-verify"></span>--}}
{{--</li>--}}
{{--<li class="badge badge--ic" data-show="tooltip" data-trigger="hover" data-placement="bottom">--}}
{{--<span class="icon icon-achievement"></span>--}}
{{--</li>--}}
{{--</ul>--}}

{{------------------------------}}
{{--| Menus--}}
{{------------------------------}}
{{--<div class="profile__bar__list">--}}
{{--@if(is_profile_owner($target_user_id))--}}
{{--<a href="{{ url_link_to_profile() }}"--}}
{{--class="lk-bl lk-d {{ set_active('profile', 'bolder cPbl') }}">{{ trans("front/general.profile") }}</a>--}}
{{--@else--}}
{{--<a href="{{ url_link_to_target_profile($target_nickname) }}"--}}
{{--class="lk-bl lk-d {{ set_active('profile', 'bolder cPbl') }}">{{ trans("front/general.profile") }}</a>--}}
{{--@endif--}}
{{--<div class="divider-v"></div>--}}
{{--<a href="#" class="btn-stack lk-bl lk-d">--}}
{{--<span class="btn-stack__t">{{ trans("front/general.groups") }}</span>--}}
{{--<span class="btn-stack__b">{{ $user->groups()->wherePivot('accepted', true)->get()->count() }}</span>--}}
{{--</a>--}}
{{--<a href="#" class="btn-stack lk-bl lk-d">--}}
{{--<span class="btn-stack__t">{{ trans("front/general.follows") }}</span>--}}
{{--<span class="btn-stack__b">0</span>--}}
{{--</a>--}}
{{--<a href="#" class="btn-stack lk-bl lk-d">--}}
{{--<span class="btn-stack__t">{{ trans("front/general.events") }}</span>--}}
{{--<span class="btn-stack__b">0</span>--}}
{{--</a>--}}
{{--<a href="#" class="btn-stack lk-bl lk-d">--}}
{{--<span class="btn-stack__t">{{ trans("front/general.photos") }}</span>--}}
{{--<span class="btn-stack__b">0</span>--}}
{{--</a>--}}
{{--</div>--}}

{{------------------------------}}
{{--| Edit Buttons--}}
{{------------------------------}}
{{--<div class="profile__edit__btn">--}}
{{--@if(is_profile_owner($target_user_id))--}}
{{--<a href="{{ url_link_to_editProfile() }}" class="btn btn-white-t"><span--}}
{{--class="icon icon-edit mR"></span> {{ trans("front/general.editProfile") }}</a>--}}
{{--<a class="btn btn-white-t">Change Cover Photo</a>--}}
{{--@endif--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
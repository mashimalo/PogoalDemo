@extends('layouts.default')

@section('pageTitle')
    Leader Board
@stop

{{----------------------------
| Content
----------------------------}}
@section('content')

    {{----------------------------
    | Page Title
    ----------------------------}}
    <h2 class="text-center text-shadow-title text-uppercase p-relative thin">
        Leader Board
        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
             viewBox="0 0 150.8 83.2" style="enable-background:new 0 0 150.8 83.2;" xml:space="preserve">
            <g>
                <path d="M0,26.3l41.4,56.9L109.7,0L0,26.3z M3.4,27.5l101-24.2L41.5,79.9L3.4,27.5z"/>
                <path d="M94.9,22.9L72.3,67.6l78.5,10.2L94.9,22.9z M95.5,26.3l49.7,48.8L75.4,66L95.5,26.3z"/>
            </g>
        </svg>
    </h2>

    <div class="wrap leaderboards">

        {{----------------------------
        | Top Users
        ----------------------------}}
        <div class="c-f-4">
            <div id="leaderboard-topUsers" class="leaderboard__column shadow h--dummy">
                <div class="leaderboard__column__title text-center text-white text-shadow text-lg thin shadow--dark pV--sm pH--md">
                    Top Users
                </div>

                <div class="leaderboard__filter__container text-center pH--md transit--linear--fast link-fake"
                     data-action="toggle"
                     data-target="#leaderboard-filter-topUsers">
                    <div class="leaderboard__filter pV--sm transit--linear--fast">
                        <span class="leaderboard__filter__current">All Categories</span>
                        <span class="icon icon-arrow-down mL"></span>
                    </div>
                </div>

                <div id="leaderboard-filter-topUsers" class="leaderboard__filter__list pV bg--dark hide">
                    <ul class="bg--white text-center slimScroll">
                        <li class="lk-darker pH--md pV--sm display-block lk-block link-fake"
                            data-action="leaderboard-filter-topUsers"
                            data-group-type-id="all">
                            All Categories
                        </li>
                        @foreach(App\Models\GroupType::all() as $groupType)
                            <li class="lk-darker pH--md pV--sm display-block lk-block link-fake"
                                data-action="leaderboard-filter-topUsers"
                                data-group-type-id="{{ $groupType->id }}">
                                {{ $groupType->group_type_name }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <ul id="leaderboard-result-topUsers" class="leaderboard__result__list">
                    @foreach($topUsers as $user)
                        <li class="pH--md lk-block">
                            <div class="pV--sm bordered--b bordered--b--light">

                                <a href="{{ url_link_to_target_profile(\App\Models\Profile::where('user_id',$user->user_id )->firstOrFail()->nickname) }}"
                                   class="pull-left mR--md">
                                    @if (\App\Models\Profile::where('user_id',$user->user_id )->firstOrFail()->user_avatar_small != null || strlen(\App\Models\Profile::where('user_id',$user->user_id )->firstOrFail()->user_avatar_small) > 0)
                                        <img src="/images/userAvatar/{{ \App\Models\Profile::where('user_id',$user->user_id )->firstOrFail()->user_avatar_small }}"
                                             class="avatar avatar--md rounded">
                                    @else
                                        <img data-name="{{ empty_eitherName_displayNickname_by_userId($user->user_id) }}"
                                             class="initialAvatar avatar avatar--md rounded"/>
                                    @endif
                                </a>

                                <a href="{{ url_link_to_target_profile(\App\Models\Profile::where('user_id',$user->user_id )->firstOrFail()->nickname) }}"
                                   class="pull-right mL--md btn btn-sns btn-mT-mainAlt">
                                    View
                                </a>

                                <div class="overflow-h">
                                    <a href="{{ url_link_to_target_profile(\App\Models\Profile::where('user_id',$user->user_id )->firstOrFail()->nickname) }}"
                                       class="lk-darker bold text-overflow">
                                        {{ empty_eitherName_displayNickname_by_userId($user->user_id) }}
                                    </a>
                                    <div class="small text-light">
                                        Total likes: {{ $user->amount }}
                                    </div>
                                </div>

                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{----------------------------
        | Top Groups
        ----------------------------}}
        <div class="c-f-4">
            <div id="leaderboard-topGroups" class="leaderboard__column shadow h--dummy">
                <div class="leaderboard__column__title text-center text-white text-shadow text-lg thin shadow--dark pV--sm pH--md">
                    Top Groups
                </div>

                <div class="leaderboard__filter__container text-center pH--md transit--linear--fast link-fake"
                     data-action="toggle"
                     data-target="#leaderboard-filter-topGroups">
                    <div class="leaderboard__filter pV--sm transit--linear--fast">
                        <span class="leaderboard__filter__current">All Categories</span>
                        <span class="icon icon-arrow-down mL"></span>
                    </div>
                </div>

                <div id="leaderboard-filter-topGroups" class="leaderboard__filter__list pV bg--dark hide">
                    <ul class="bg--white text-center slimScroll">
                        <li class="lk-darker pH--md pV--sm display-block lk-block link-fake"
                            data-action="leaderboard-filter-topGroups"
                            data-group-type-id="all">
                            All Category
                        </li>
                        @foreach(App\Models\GroupType::all() as $groupType)
                            <li class="lk-darker pH--md pV--sm display-block lk-block link-fake"
                                data-action="leaderboard-filter-topGroups"
                                data-group-type-id="{{ $groupType->id }}">
                                {{ $groupType->group_type_name }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <ul id="leaderboard-result-topGroups" class="leaderboard__result__list">
                    @foreach($topGroups as $group)
                        <li class="pH--md lk-block">
                            <div class="pV--sm bordered--b bordered--b--light">
                                <a href="{{ url_link_to_group($group->group_id ) }}" class="pull-left mR--md">


                                    @if (\App\Models\Group::where('id', $group->group_id)->firstOrFail()->group_avatar_small != null || strlen(\App\Models\Group::where('id', $group->group_id)->firstOrFail()->group_avatar_small) > 0)
                                        <img src="{!! '/images/groupAvatar/'.\App\Models\Group::where('id', $group->group_id)->firstOrFail()->group_avatar_small !!}"
                                             class="avatar avatar--md rounded">
                                    @else
                                        <img src="{{ url('/assets/images/avatar.jpg') }}" class="avatar avatar--md rounded"/>
                                    @endif


                                </a>
                                <a href="{{ url_link_to_group($group->group_id ) }}" class="pull-right mL--md btn btn-sns btn-mT-mainAlt">
                                    Join
                                </a>
                                <div class="overflow-h">
                                    <a href="{{ url_link_to_group($group->group_id ) }}" class="lk-darker bold text-overflow">
                                        {{ \App\Models\Group::where('id', $group->group_id)->firstOrFail()->name }}
                                    </a>
                                    <div class="small text-light">
                                        <span class="mR--md">
                                            <span class="icon icon-category mR"></span>
                                            {{ getGroupTypeName( \App\Models\Group::where('id', $group->group_id)->firstOrFail() ) }}
                                        </span>
                                        <span>
                                            <span class="icon icon-user-solid mR"></span>
                                            {{ $group->amount }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{----------------------------
        | Top Bridging Groups
        ----------------------------}}
        <div class="c-f-4">
            <div id="leaderboard-topBridgingGroups" class="leaderboard__column shadow h--dummy">
                <div class="leaderboard__column__title text-center text-white text-shadow text-lg thin shadow--dark pV--sm pH--md">
                    Top Bridging Groups
                </div>

                <div id="leaderboard-filter-topBridgingGroups" class="leaderboard__filter__container text-center pH--md transit--linear--fast">
                    <div class="leaderboard__filter pV--sm transit--linear--fast">
                        All Categories
                    </div>
                </div>
                <ul id="leaderboard-result-topBridingGroups" class="leaderboard__result__list">
                    @foreach($topBridgeGroups as $bridgeGroup)
                        <li class="pH--md lk-block">
                            <div class="pV--sm bordered--b bordered--b--light">
                                <a href="{{ url_link_to_dockingGroup( $bridgeGroup->bridge_Group_id ) }}" class="pull-left mR--md avatar--overlap">

                                    @if (leaderboard_topBridging_avatar($bridgeGroup->bridge_Group_id, "group_1_id") != null || strlen(leaderboard_topBridging_avatar($bridgeGroup->bridge_Group_id, "group_1_id")) > 0)
                                        <img src="{!! '/images/groupAvatar/'.leaderboard_topBridging_avatar($bridgeGroup->bridge_Group_id, "group_1_id") !!}"
                                             class="avatar avatar--md rounded shadow">
                                    @else
                                        <img src="{{ url('/assets/images/avatar.jpg') }}" class="avatar avatar--md rounded shadow"/>
                                    @endif

                                    @if (leaderboard_topBridging_avatar($bridgeGroup->bridge_Group_id, "group_2_id") != null || strlen(leaderboard_topBridging_avatar($bridgeGroup->bridge_Group_id, "group_2_id")) > 0)
                                        <img src="{!! '/images/groupAvatar/'.leaderboard_topBridging_avatar($bridgeGroup->bridge_Group_id, "group_2_id") !!}"
                                             class="avatar avatar--md rounded shadow">
                                    @else
                                        <img src="{{ url('/assets/images/avatar.jpg') }}" class="avatar avatar--md rounded shadow"/>
                                    @endif

                                </a>
                                <a href="{{ url_link_to_dockingGroup($bridgeGroup->bridge_Group_id ) }}"
                                   class="pull-right mL--md btn btn-sns btn-mT-mainAlt">
                                    View
                                </a>
                                <div class="overflow-h">
                                    <a href="{{ url_link_to_dockingGroup($bridgeGroup->bridge_Group_id ) }}" class="lk-darker bold text-overflow">
                                        {{ \App\Models\DockingGroup::where('id', $bridgeGroup->bridge_Group_id)->firstOrFail()->docking_group_name }}
                                    </a>
                                    <div class="small text-light">
                                        Total posts: {{ $bridgeGroup->amount }}
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

@stop
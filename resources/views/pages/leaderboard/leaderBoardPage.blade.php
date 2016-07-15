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

    <div class="wrap leaderBoards">
        <div class="c-f-4">
            <div class="leaderBoard__column shadow h--dummy">
                <div class="leaderBoard__column__title text-center text-white text-shadow text-lg thin shadow--dark pV--sm pH--md">
                    Top Users
                </div>

                <div class="leaderBoard__column__filter__container text-center pH--md transit--linear--fast link-fake"
                     data-action="toggle"
                     data-target="#leaderBoard__column__filter__topUsersList">
                    <div class="leaderBoard__column__filter pV--sm transit--linear--fast">
                        All Categories
                        <span class="icon icon-arrow-down mL"></span>
                    </div>
                </div>

                <div id="leaderBoard__column__filter__topUsersList" class="leaderBoard__column__filter__list pV bg--dark hide">
                    <ul class="bg--white text-center slimScroll">
                        @foreach(App\Models\GroupType::all() as $groupType)
                            <li>
                                <a href="#" class="lk-darker pH--md pV--sm display-block lk-block">
                                    {{ $groupType->group_type_name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    @foreach($topUsers as $user)
                        <li>
                            <a href="{{ url_link_to_target_profile(\App\Models\Profile::where('user_id',$user->user_id )->firstOrFail()->nickname) }}" class="lk-darker pH--md pV--sm display-block lk-block">
                                {{ empty_eitherName_displayNickname_by_userId($user->user_id) }}
                                <br>
                                Total like by other user: {{ $user->amount }}
                            </a>
                        </li>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="c-f-4">
            <div class="leaderBoard__column shadow h--dummy">
                <div class="leaderBoard__column__title text-center text-white text-shadow text-lg thin shadow--dark pV--sm pH--md">
                    Top Groups
                </div>

                <div class="leaderBoard__column__filter__container text-center pH--md transit--linear--fast link-fake"
                     data-action="toggle"
                     data-target="#leaderBoard__column__filter__topGroupsList">
                    <div class="leaderBoard__column__filter pV--sm transit--linear--fast">
                        All Categories
                        <span class="icon icon-arrow-down mL"></span>
                    </div>
                </div>

                <div id="leaderBoard__column__filter__topGroupsList" class="leaderBoard__column__filter__list pV bg--dark hide">
                    <ul class="bg--white text-center slimScroll">
                        @foreach(App\Models\GroupType::all() as $groupType)
                            <li>
                                <a href="#" class="lk-darker pH--md pV--sm display-block lk-block">
                                    {{ $groupType->group_type_name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    @foreach($topGroups as $group)
                        <li>
                            <a href="{{ url_link_to_group($group->group_id ) }}" class="lk-darker pH--md pV--sm display-block lk-block">
                                {{ \App\Models\Group::where('id', $group->group_id)->firstOrFail()->name }}
                                <br>
                                Total memebers: {{ $group->amount }}
                                {{--Total feed: {{ \App\Models\Group::where('id', $group->group_id)->firstOrFail()->feeds->count() }}--}}
                            </a>
                        </li>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="c-f-4">
            <div class="leaderBoard__column shadow h--dummy">
                <div class="leaderBoard__column__title text-center text-white text-shadow text-lg thin shadow--dark pV--sm pH--md">
                    Top Bridging Groups
                </div>

                <div class="leaderBoard__column__filter__container text-center pH--md transit--linear--fast link-fake">
                    <div class="leaderBoard__column__filter pV--sm transit--linear--fast">
                        All Categories
                        <span class="icon icon-arrow-down mL"></span>
                    </div>
                </div>
                <div>
                    @foreach($topBridgeGroups as $bridgeGroup)
                        <li>
                            <a href="{{ url_link_to_dockingGroup($bridgeGroup->bridge_Group_id ) }}" class="lk-darker pH--md pV--sm display-block lk-block">
                                {{ \App\Models\DockingGroup::where('id', $bridgeGroup->bridge_Group_id)->firstOrFail()->docking_group_name }}
                                <br>
                                Total Post: {{ $bridgeGroup->amount }}
                            </a>
                        </li>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@stop
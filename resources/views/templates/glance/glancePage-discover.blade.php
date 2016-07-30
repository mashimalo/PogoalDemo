<div class="site-container">
    {{----------------------------
    | Page Title
    ----------------------------}}
    <h3 class="mB--lg">
        <span class="icon icon-category mR"></span>
        Discover Groups
    </h3>

    <div class="wrap-one">
        <div class="home__cat">
            @foreach(App\Models\GroupType::all()->take(6) as $groupType)
                <div class="home__cat__item c-f-3 letter-space--hover">
                    <div class="bg--stretch full" style="background-image: url('/assets/images/category/home-cat-{{ $groupType->id }}.jpg');">
                        <a href="{{ url_link_to_show_search_by_groups_type_result($groupType->id) }}">
                            <div class="vA-block--middle full h3 bg--darker transit--linear">
                                <div class="vA__item">
                                    <span class="transit--linear thin">{{ $groupType->group_type_name }}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
            <div class="home__cat__item c-f-6">
                <div class="bg--stretch full" style="background-image: url('/assets/images/home-cat-more.jpg');">
                    <div class="vA-block--middle full h4 bg--darker transit--linear">
                        <div class="vA__item">
                            <a href="{{ URL::route("showAllGroups") }}" class="bold btn btn-outline-white mR">
                                See all groups
                            </a>
                            <button class="bold btn btn-outline-white mR"
                                    data-action="toggle"
                                    data-scroll="scroll"
                                    data-scroll-offset="65"
                                    data-target="#home__cat__more"
                                    data-scroll-to-target="true">Find more
                            </button>
                            <a href="{{ URL::route("leaderBoardPage") }}" class="bold btn btn-outline-white">
                                Leader Board
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="home__cat__more" class="wrap hide mB--md mT--md">
        <div class="home__cat">
            @foreach(App\Models\GroupType::all()->except([1,2,3,4,5,6]) as $groupType)
                <div class="c-f-3 mB--md">
                    <a href="{{ url_link_to_show_search_by_groups_type_result($groupType->id) }}"
                       class="pV--lg text-center bold text-uppercase arc-sm display-block bg-white lk-d shadow shadow--hover">
                        {{ $groupType->group_type_name }}
                    </a>
                </div>
            @endforeach
            <div class="c-f-3">
                <a href="{{ URL::route("showAllGroups") }}"
                   class="pV--lg text-center bold text-uppercase arc-sm display-block bg-white lk-d shadow shadow--hover">
                    See all groups
                </a>
            </div>
        </div>
    </div>
</div>

<hr class="mT--xxxlg mB--xxxlg">

<div class="site-container">
    {{----------------------------
    | Groups
    ----------------------------}}
    <h3 class="mB--lg">
        <span class="icon icon-group mR"></span>
        Latest Created Groups
    </h3>

    <div class="wrap">
        @foreach($groups as $group)
            <div class="uiTile c-f-o-3 mB--md">
                <div class="uiTile__body arc-sm">
                    <div class="uiTile__cover">
                        <a href="{{ url_link_to_group($group->id) }}">

                            {{----------------------------
                            | Group avatar
                            ----------------------------}}
                            @if ($group->group_avatar_large != null || strlen($group->group_avatar_large) > 0)
                                <img src="{!! '/images/groupAvatar/'.$group->group_avatar_large !!}"
                                     class="uiTile__avatar avatar avatar--fluid">
                            @else
                                <img class="uiTile__avatar avatar avatar--fluid" src="{{ url('/assets/images/avatar.jpg') }}">
                            @endif

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
    </div>
</div>
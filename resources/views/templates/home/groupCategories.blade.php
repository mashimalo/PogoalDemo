<div class="wrap-one mB--md">
    <div class="home__cat">
        @foreach(App\Models\GroupType::all()->take(6) as $groupType)
            <div class="home__cat__item c-f-3 letter-space--hover">
                <div class="bg--stretch full" style="background-image: url('/assets/images/category/home-cat-{{ $groupType->id }}.jpg');">
                    <a href="{{ url_link_to_show_search_by_groups_type_result($groupType->id) }}">
                        <div class="vA-block--middle full text-lg text-white transit--linear bg--darker">
                            <div class="vA__item">
                                <span class="transit--linear">{{ $groupType->group_type_name }}</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
        <div class="home__cat__item c-f-6">
            <div class="bg--stretch full" style="background-image: url('/assets/images/home-cat-more.jpg');">
                <div class="vA-block--middle full bg--darker transit--linear">
                    <div class="vA__item">
                        <a href="{{ URL::route("showAllGroups") }}" class="bold btn btn-outline-white mR">
                            See all groups
                        </a>
                        <button class="bold btn btn-outline-white mR--sm text-md"
                                data-action="toggle"
                                data-scroll="scroll"
                                data-scroll-offset="15"
                                data-target="#home__cat__more"
                                data-scroll-to-target="true">Find more
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="home__cat__item c-f-12 letter-space--hover">
            <div class="bg--stretch full" style="background-image: url('/assets/images/block-2.jpg');">
                <a href="{{ URL::route("leaderBoardPage") }}">
                    <div class="vA-block--middle full text-lg text-white bold transit--linear bg--darker">
                        <div class="vA__item">
                            <span class="transit--linear text-xxlg text-uppercase text-shadow-title">Leader Board</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<div id="home__cat__more" class="wrap hide">
    <div class="home__cat">
        @foreach(App\Models\GroupType::all()->except([1,2,3,4,5,6]) as $groupType)
            <div class="c-f-3 mB--md">
                <a href="{{ url_link_to_show_search_by_groups_type_result($groupType->id) }}"
                   class="pV--lg text-center bold text-uppercase arc-sm display-block bg-white lk-d shadow shadow--hover">
                    {{ $groupType->group_type_name }}
                </a>
            </div>
        @endforeach
        <div class="c-f-3 mB--md">
            <a href="{{ URL::route("showAllGroups") }}"
               class="pV--lg text-center bold text-uppercase arc-sm display-block bg-white lk-d shadow shadow--hover">
                See all groups
            </a>
        </div>
    </div>
</div>
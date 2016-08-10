<div class="navBar">
    <div class="navBar__container text-center fixed--t-r">

        {{----------------------------
        | Glance Page
        ----------------------------}}
        @if(currentRoute('glance') || currentRoute('glanceMyGroups') || currentRoute('glanceMyBridgingGroups') || currentRoute('notifications'))
            <div class="navBar__main">
                <a href="{{ url_link_to_glance() }}" class="lk-light lk-bl {{ set_active('glance', 'text-dark cPbl') }}">Discover</a>
                <a href="{{ url_link_to_glanceMyGroups() }}" class="lk-light lk-bl {{ set_active('glanceMyGroups', 'text-dark cPbl') }}">{{ trans("front/general.myGroups") }}</a>
                <a href="{{ url_link_to_glanceMyBridgingGroups() }}" class="lk-light lk-bl {{ set_active('glanceMyBridgingGroups', 'text-dark cPbl') }}">My Bridging Groups</a>
                <a href="{{ URL::route('notifications') }}" class="lk-light lk-bl {{ set_active('notifications', 'text-dark cPbl') }}">My Notifications</a>
            </div>
        @endif

        {{----------------------------
        | Search Pages
        ----------------------------}}
        @if(currentRoute('searchGroup-get') || currentRoute('SearchByGroupsTypeResult-get') || currentRoute('showAllGroups'))
            <div class="navBar__main">
                <ul class="list-inline">
                    <li class="uiDropdown">
                        <button class="text-light" data-toggle="dropdown">
                            @if(currentRoute('SearchByGroupsTypeResult-get'))
                                @foreach(App\Models\GroupType::all() as $groupType)
                                    @if($groupType->id == $group_type_id)
                                        {{ $groupType->group_type_name }}
                                    @endif
                                @endforeach
                            @elseif(currentRoute('showAllGroups'))
                                All Groups
                            @else
                                Category
                            @endif
                            <span class="icon icon-arrow-down mL"></span>
                        </button>
                        <div class="uiDropdown__menu uiDropdown__menu--md uiDropdown__menu--center">
                            <ul id="searchPageCategory" class="slimScroll">
                                <li>
                                    <a href="{{ URL::route('showAllGroups') }}" class="{{ set_active('showAllGroups','active') }}">
                                        All Groups
                                    </a>
                                </li>
                                @foreach(App\Models\GroupType::all() as $groupType)
                                    <li>
                                        <a href="{{ url_link_to_show_search_by_groups_type_result($groupType->id) }}"
                                           class="{{ currentRoute('SearchByGroupsTypeResult-get') && $groupType->id == $group_type_id ? "active":null }}">
                                            {{ $groupType->group_type_name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        @endif
    </div>
</div>
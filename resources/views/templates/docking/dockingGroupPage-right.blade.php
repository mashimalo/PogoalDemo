{{----------------------------
| Group Infomation
----------------------------}}
@if(currentRoute('show-dockingGroupSingleFeedPage'))
    <div class="sgp-left__info uiCard mB--md">
        <div class="uiCard__body">

            @if(currentRoute('show-groupSingleFeedPage'))
                <div class="bold text-uppercase pA--md lh-avatar--md bordered--b">
                    Posted in
                </div>
            @endif

            <div class="clearfix pA--md">
                <a href="{{ url_link_to_group($group2->id) }}" class="pull-left mR--sm">
                    @if ($group2->group_avatar_large != null || strlen($group2->group_avatar_large) > 0)
                        <img src="{!! '/images/groupAvatar/'.$group2->group_avatar_large !!}"
                             class="avatar avatar--lg arc-sm">
                    @else
                        <img class="avatar avatar--lg arc-sm" src="{{ url('/assets/images/avatar.jpg') }}">
                    @endif
                </a>
                <div class="overflow-h">
                    <a href="{{ url_link_to_group($group2->id) }}" class="lk-darker bolder break-word">
                        {{$group2->name}}
                    </a>
                    <div class="small text-light text-overflow mT">
                        <div>
                            <span class="icon icon-category mR"></span>
                            {{ getGroupTypeName($group2) }}
                        </div>
                        <div>
                            <span class="icon icon-send-line mR"></span>
                            {{ $group2->feeds->count() }}
                        </div>
                        <div>
                            <span class="icon icon-user-solid mR"></span>
                            {{ $group2->acceptUsers()->count() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="small pA--md break-word bg-body-above bordered--t">
                <div class="mB text-uppercase bolder">
                    About
                </div>
                {{$group2->description}}
            </div>

        </div>
    </div>
@else
    <div class="docking-side__info docking-side--right uiCard mB--md">
        <div class="uiCard__body">
            <div class="docking-side__group__avatar">
                <a href="{{ url_link_to_group($group2->id) }}">
                    @if (get_group_by_id($group2->id)->group_avatar_large != null || strlen(get_group_by_id($group2->id)->group_avatar_large) > 0)
                        <img src="{!! '/images/groupAvatar/'.get_group_by_id($group2->id)->group_avatar_large !!}"
                             class="avatar avatar--fluid arc-sm-top">
                    @else
                        <img class="avatar avatar--fluid arc-sm-top" src="{{ url('/assets/images/avatar.jpg') }}">
                    @endif
                </a>
            </div>
            <div class="uiCard__content">
                <div class="docking-side__group__name">
                    <a href="{{ url_link_to_group($group2->id) }}">
                        {{$group2->name}}
                    </a>
                </div>
                <div class="docking-side__group__description small mB--md break-word">
                    {{$group2->description}}
                </div>
                <div class="small text-light text-overflow">
                    <span class="icon icon-calendar mR"></span>
                    {{$group2->created_at->format('M d, Y')}}
                    <br>
                    <span class="icon icon-category mR"></span>
                    {{ getGroupTypeName($group2) }}
                    <br>
                    <span class="icon icon-user-solid"></span>
                    {{$group1->users->count()}}
                </div>
            </div>
        </div>
    </div>
@endif
{{----------------------------
| Group Infomation
----------------------------}}
@if(currentRoute('show-dockingGroupSingleFeedPage'))
    <div class="sgp-left__info uiCard mB--md">
        <div class="uiCard__body">
            <div class="clearfix pA--md">
                <a href="{{ url_link_to_group($group1->id) }}" class="pull-left mR--sm">
                    @if ($group1->group_avatar_large != null || strlen($group1->group_avatar_large) > 0)
                        <img src="{!! '/images/groupAvatar/'.$group1->group_avatar_large !!}"
                             class="avatar avatar--lg arc-sm">
                    @else
                        <img class="avatar avatar--lg arc-sm" src="{{ url('/assets/images/avatar.jpg') }}">
                    @endif
                </a>
                <div class="overflow-h">
                    <a href="{{ url_link_to_group($group1->id) }}" class="lk-darker bolder break-word">
                        {{$group1->name}}
                    </a>
                    <div class="small text-light text-overflow mT">
                        <div>
                            <span class="icon icon-category mR"></span>
                            {{ getGroupTypeName($group1) }}
                        </div>
                        <div>
                            <span class="icon icon-send-line mR"></span>
                            {{ $group1->feeds->count() }}
                        </div>
                        <div>
                            <span class="icon icon-user-solid mR"></span>
                            {{ $group1->acceptUsers()->count() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="small pA--md break-word bg-body-above bordered--t">
                <div class="mB text-uppercase bolder">
                    About
                </div>
                {{$group1->description}}
            </div>

        </div>
    </div>
@else
    <div class="docking-side__info dockingside--left uiCard mB--md">
        <div class="uiCard__body">
            <div class="docking-side__group__avatar">
                <a href="{{ url_link_to_group($group1->id) }}">
                    @if (get_group_by_id($group1->id)->group_avatar_large != null || strlen(get_group_by_id($group1->id)->group_avatar_large) > 0)
                        <img src="{!! '/images/groupAvatar/'.get_group_by_id($group1->id)->group_avatar_large !!}"
                             class="avatar avatar--fluid arc-sm-top">
                    @else
                        <img class="avatar avatar--fluid arc-sm-top" src="{{ url('/assets/images/avatar.jpg') }}">
                    @endif
                </a>
            </div>
            <div class="uiCard__content">
                <div class="docking-side__group__name">
                    <a href="{{ url_link_to_group($group1->id) }}">
                        {{$group1->name}}
                    </a>
                </div>
                <div class="docking-side__group__description small mB--md break-word">
                    {{$group1->description}}
                </div>
                <div class="small text-light text-overflow">
                    <span class="icon icon-calendar mR"></span>
                    {{$group1->created_at->format('M d, Y')}}
                    <br>
                    <span class="icon icon-category mR"></span>
                    {{ getGroupTypeName($group1) }}
                    <br>
                    <span class="icon icon-user-solid"></span>
                    {{$group1->users->count()}}
                </div>
            </div>
        </div>
    </div>
@endif


{{----------------------------
| Group Infomation
----------------------------}}
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

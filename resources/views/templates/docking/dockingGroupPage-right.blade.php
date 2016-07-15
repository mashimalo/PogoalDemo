{{----------------------------
| Group Infomation
----------------------------}}
<div class="docking-side__info docking-side--right uiCard mB--md">
    <div class="uiCard__body">
        <div class="docking-side__group__avatar">
            <a href="{{ url_link_to_group($group2->id) }}">
                <img class="avatar avatar--fluid arc-sm-top" src="{{ url('/assets/images/avatar.jpg') }}">
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

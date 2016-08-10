<div class="site-container mB--xxxlg">

    {{----------------------------
    | Page Title
    ----------------------------}}
    <h3 class="mB--lg">
        <span class="icon icon-category mR"></span>
        Discover Groups
    </h3>

    @include('templates.home.groupCategories')

</div>

<hr class="mT--xxxlg mB--xxxlg bordered--light">

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
                            <span class="icon icon-user-solid mR"></span>
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
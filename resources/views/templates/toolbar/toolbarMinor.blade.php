<ul>
    {{----------------------------
    | Create Button
    ----------------------------}}
    {{--<li class="toolbar__create">--}}
        {{--<button class="icon icon-plus createBtn btn-primary" role="button"></button>--}}
        {{--<ul class="createBtn__list">--}}
            {{--<li class="createBtn__item createBtn__group">--}}
                {{--<a href="{{ URL::route ('singleGroupCreatePage-show') }}" class="btn btn-md btn-blue" role="button">--}}
                    {{--<span class="icon icon-group mR"></span>--}}
                    {{--Create a Group--}}
                {{--</a>--}}
            {{--</li>--}}
        {{--</ul>--}}
    {{--</li>--}}

    {{----------------------------
    | User Info & Avatar
    ----------------------------}}
    <li class="toolbar__userInfo uiDropdown--hover">
        <a href="{{ url_link_to_glance() }}" class="lk-block text-dark bold" type="button" id="toolbar-user-avatar">
            {{----------------------------
            | User avatar
            ----------------------------}}
            @if (Auth::user()->profile->user_avatar_small != null || strlen(Auth::user()->profile->user_avatar_small) > 0)
                <img src="{!! '/images/userAvatar/'.Auth::user()->profile->user_avatar_small !!}" class="avatar avatar--md rounded mR">
            @else
                <img data-name="{{ empty_eitherName_displayNickname(Auth::user()) }}" class="initialAvatar avatar avatar--md rounded mR">
            @endif
            <span class="toolbar__userInfo__name mL mR">{{ empty_firstName_displayNickname(Auth::user()) }}</span>
        </a>
        {{--- User Info Menu ---}}
        <ul class="toolbar__user uiDropdown__menu uiDropdown__menu--right arc-sm-bottom"
            aria-labelledby="toolbar__userAvatar">
            <li class="uiDropdown__menu__header"><span>Profile</span></li>
            <li>
                <a href="{{ url_link_to_profile() }}"> <span class="icon icon-user-solid"></span> My Profile</a>
            </li>
            <li>
                <a href="{{ url_link_to_editProfile() }}"><span class="icon icon-gear"></span> {{ trans("front/general.editProfile") }}</a>
            </li>
            <li class="uiDropdown__menu__header"><span>Misc.</span></li>
            {{----------------------------
            | Admin Link
            ----------------------------}}
            @if(session('role') == 'admin')
                <li><a href="#">Admin Portal</a></li>
            @endif
            <li>
                <a href={{ url('auth/logout') }}><span class="icon icon-logout"></span> Log Out</a>
            </li>
        </ul>
    </li>

    {{----------------------------
    | Toolbar Search
    ----------------------------}}
    <li class="toolbar__icons">
        <button data-action="toggle" data-target="#toolbar-search" class="lk-block">
            <span class="icon icon-search text-lg"></span>
        </button>
    </li>
</ul>
{{----------------------------
| LOGO
----------------------------}}
{{--<h1>--}}
    {{--<a href="{{ url('/') }}">--}}
        {{--<img id="brand" src="{{ url('/assets/images/logo.png') }}" alt="Pogoal"/>--}}
        {{--<span class="hidden-text">{{ trans('front/brand.pogoal') }}</span>--}}
    {{--</a>--}}
{{--</h1>--}}

@if(Auth::check())
    <ul>
        {{----------------------------
        | Group
        ----------------------------}}
        <li class="toolbar__group toolbar__icons uiDropdown">
            <button class="uiDropdown--toggle lk-block" type="button" id="toolbar-group" title="Groups" data-toggle="dropdown">
                <span class="icon icon-group text-lg mR"></span>
                Groups
            </button>
            {{--- Group Menu ---}}
            <ul class="uiDropdown__menu arrow--none arc-sm-bottom">
                <li><a href="{{ URL::route('singleGroupCreatePage-show') }}" class="{{ set_active('singleGroupCreatePage-show','active') }}">Create a Group</a></li>
                <li><a href="{{ URL::route('showAllGroups') }}" class="{{ set_active('showAllGroups','active') }}">Find Groups</a></li>
                <li><a href="{{ url_link_to_glanceMyGroups() }}" class="{{ set_active('glanceMyGroups','active') }}">My Groups</a></li>
                <li class="divider"></li>
                <li><a href="{{ url_link_to_glanceMyBridgingGroups() }}" class="{{ set_active('glanceMyBridgingGroups','active') }}">My Bridging Groups</a></li>
                {{--<li><a href="#">Setting</a></li>--}}
            </ul>
        </li>

        {{----------------------------
        | Notification
        ----------------------------}}
        @include('templates.toolbar.toolbarMinor-notification')
    </ul>
@endif
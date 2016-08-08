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
                <li><a href="{{ URL::route('singleGroupCreatePage-show') }}">Create a Group</a></li>
                <li><a href="{{ URL::route('showAllGroups') }}">Find Groups</a></li>
                <li><a href="{{ url_link_to_glance() }}">My Groups</a></li>
                {{--<li><a href="#">Setting</a></li>--}}
            </ul>
        </li>

        {{----------------------------
        | Notification
        ----------------------------}}
        @include('templates.toolbar.toolbarMinor-notification')
    </ul>
@endif
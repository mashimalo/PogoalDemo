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
    | Toolbar Portal
    ----------------------------}}
    <li class="toolbar__portal">
        <ul>
            {{--- Log in button ---}}
            <li id="toolbar-login">
                <a class="lk-block" href="{{ url('auth/login') }}">
                    <span class="icon icon-log-in text-lg mR"></span> Log In
                </a>
            </li>
            {{--- Sign up Button ---}}
            <li id="toolbar-signup">
                <a class="lk-block" href="{{ url('auth/register') }}">
                    <span class="icon icon-sign-up text-lg mR"></span> Sign Up
                </a>
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
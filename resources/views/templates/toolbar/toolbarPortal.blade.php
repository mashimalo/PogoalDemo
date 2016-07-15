<ul>
    {{----------------------------
    | Create Button
    ----------------------------}}
    <li class="toolbar__create">
        <button class="icon icon-plus createBtn btn-primary" role="button"></button>
        <ul class="createBtn__list">
            <li class="createBtn__item createBtn__group">
                <a href="{{ URL::route ('singleGroupCreatePage-show') }}" class="btn btn-md btn-blue" role="button">
                    <span class="icon icon-group mR"></span>
                    Create a Group
                </a>
            </li>

            {{--<li class="createBtn__item createBtn__event">--}}
            {{--<a class="btn btn-md btn-primary" role="button">--}}
            {{--<span class="icon icon-calendar mR"></span>--}}
            {{--Create an Event--}}
            {{--</a>--}}
            {{--</li>--}}
        </ul>
    </li>

    {{----------------------------
    | Toolbar Portal
    ----------------------------}}
    <li class="toolbar__portal">
        <ul>
            {{--- Log in button ---}}
            <li id="toolbar-login">
                {{--
                <button type="button" data-toggle="modal" data-target="#portal-modal">
                    <span class="icon icon-log-in"></span> Log In
                </button>
                --}}
                <a class="lk-d lk-block" href="{{ url('auth/login') }}">
                    <span class="icon icon-log-in"></span> Log In
                </a>
            </li>
            {{--- Sign up Button ---}}
            <li id="toolbar-signup">
                {{--
                <button type="button" data-toggle="modal" data-target="#portal-modal">
                    <span class="icon icon-sign-up"></span> Sign Up
                </button>
                --}}
                <a class="lk-d lk-block" href="{{ url('auth/register') }}">
                    <span class="icon icon-sign-up"></span> Sign Up
                </a>
            </li>
        </ul>
    </li>
</ul>
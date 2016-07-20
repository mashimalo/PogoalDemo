<li class="notification toolbar__notification toolbar__icons uiDropdown bordered--r">

    <button id="toolbar-notification-button" class="uiDropdown--toggle lk-block text-dark"
            title="Messages&nbsp;&&nbsp;Notifications" data-toggle="dropdown">
        <span class="icon icon-bell text-lg text-lighter mR"></span>
        Notification
    </button>

    {{--- New Notification Count ---}}
    @if(App\Models\Notification::where('user_id', Auth::user()->id)->where('read', false)->count() > 0)
        <span id="toolbar-notification-counter" class="notification__counter">
            {{ App\Models\Notification::where('user_id', Auth::user()->id)->where('read', false)->count() }}
        </span>
    @else
        <span id="toolbar-notification-counter" class="notification__counter hidden">
            {{ App\Models\Notification::where('user_id', Auth::user()->id)->where('read', false)->count() }}
        </span>
    @endif

    {{--- Notification Menu ---}}
    <div class="uiDropdown__menu uiDropdown__menu--right">
        <div class="notification__panel">
            <div class="notification__header">
                <span class="bold">
                    Notifications
                </span>
                <button id="toolbar-notification-mark-read-all-button" class="small btn btn-blue-dark pull-right" title="Mark all read"
                        data-action="notification-mark-all-read-button">
                    Mark all read
                </button>
            </div>

            {{--- Notification List ---}}
            <ul id="toolbar-notification-list" class="notification__list slimScroll"></ul>
            <div class="notification__footer text-center small">
                <a href="{{ URL::route('notifications') }}">
                    See All
                </a>
            </div>
        </div> {{-- .notification__panel --}}
    </div>

</li>
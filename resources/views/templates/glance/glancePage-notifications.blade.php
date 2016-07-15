<div class="uiBox uiBox--md shadow overflow-h seeAllNotifications">

    <div class="notification__header">
        <span class="bold"> Notifications </span>
        <button id="toolbar-notification-mark-read-all-button" class="small btn btn-blue-dark pull-right" title="Mark all read"
                data-action="notification-mark-all-read-button">
            Mark all read
        </button>
    </div>

    <ul id="see-all-notification-list" class="notification__list">

        @foreach($seeAllNotifications as $notification)

            <li class="transit--linear--fast {{$notification->read == false?'notification--new':null}}"
                data-notification-id="{{ $notification->id }}" {{$notification->read == false?'data-notification-status=new':null}} {{$notification->read == true?'data-notification-status=read':null}}>
                <a href="{{ $notification->notification_link }}" class="notification__list__content small break-word"
                   data-action="notification-mark-read">
                    <div>{!! $notification->message_data !!}</div>
                    <div class="small text-light">
                        <span class="icon icon-calendar mR"></span>
                        {{ $notification->created_at->diffForHumans() }}
                    </div>
                </a>

                <button class="notification__list__markReadBtn" data-action="notification-mark-read"
                        data-show="tooltip" data-trigger="hover" data-placement="left"
                        title="{{$notification->read == false?'Mark Read':null}} {{$notification->read == true?'Read':null}}">
                    <span class="mA--none icon {{$notification->read == false?'icon-circle':null}} {{$notification->read == true?'icon-dot-fill':null}}"></span>
                </button>
            </li>

        @endforeach

    </ul>

</div>

@include('templates.pagination.limitLink', ['paginator' => $seeAllNotifications])
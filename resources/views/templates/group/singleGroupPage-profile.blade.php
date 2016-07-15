@inject ('countries', 'App\Http\Utilities\Country')

{{----------------------------
| Edit Profile Form
----------------------------}}
<div class="uiCards">
    <div class="uiCard">

        <div class="uiCard__body">
            {{----------------------------
            | Nav
            ----------------------------}}
            <div class="uiCard__nav clearfix">
                <ul class="list-inline pull-left uiTabs__nav">
                    <li class="active">
                        <a href="#tabs-1" data-toggle="tab" class="lk-d lk-block">
                            Notification
                            {{--@if( $pendingUsers->count() >=1 || $pendingDockingGroupRequests->count() >=1 )--}}
                            {{--<span class="notification__counter--fluid mL">{{ $pendingUsers->count() + $pendingDockingGroupRequests->count() }}</span>--}}
                            {{--@endif--}}
                        </a>
                    </li>
                    <li>
                        <a href="#tabs-2" data-toggle="tab" class="lk-d lk-block">Edit Infomation</a>
                    </li>
                    <li>
                        <a href="#tabs-3" data-toggle="tab" class="lk-d lk-block">HAZARD</a>
                    </li>
                </ul>
                <ul class="list-inline pull-right uiCard__nav--btn">
                    <li>
                        <a href="{{ url_link_to_group_members($group->id)  }}" class="btn btn-white-t">Manage members</a>
                    </li>
                </ul>
            </div>

            <div id="tabs-1" class="uiCard__content uiTabs__content active">
                @include('templates.group.singleGroupPage-notifications')
            </div>

            <div id="tabs-2" class="uiCard__content uiTabs__content">
                @include('templates.group.singleGroupPage-edit')
            </div>
            <div id="tabs-3" class="uiCard__content uiTabs__content">
                <button class="btn btn-danger" data-action="not-available">Self-destruct</button>
            </div>
        </div>
    </div>
</div>
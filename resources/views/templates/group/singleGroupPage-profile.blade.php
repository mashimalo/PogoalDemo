{{--@inject ('countries', 'App\Http\Utilities\Country')--}}

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
                    <li class="{{ set_active( 'singleGroupNotificationPage', 'active' ) }}">
                        <a href="{{ url_link_to_group_notification($group->id) }}" class="lk-d lk-block">
                            Notification
                        </a>
                    </li>
                    <li class="{{ set_active( 'singleGroupProfilePage', 'active' ) }}">
                        <a href="{{ url_link_to_group_profile($group->id) }}" class="lk-d lk-block">Edit Infomation</a>
                    </li>
                </ul>
                <ul class="list-inline pull-right uiCard__nav--btn">
                    <li>
                        <a href="{{ url_link_to_group_members($group->id)  }}" class="btn btn-white-t">Manage members</a>
                    </li>
                </ul>
            </div>

            <div class="uiCard__content uiTabs__content active">
                @if(currentRoute('singleGroupNotificationPage'))
                    @include('templates.group.singleGroupPage-notifications')
                @endif

                @if(currentRoute('singleGroupProfilePage'))
                    @include('templates.group.singleGroupPage-edit')
                @endif
            </div>

        </div>
    </div>
</div>
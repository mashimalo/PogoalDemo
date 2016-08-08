<div id="sgp-cover-section" class="cover cover__bg cover--darker cover--md"
     style="background-image: url('{{ url('/assets/images/cover-abstract.jpg') }}');">
    <div class="cover__static">
        <div class="site-container">
            <div class="pull-left">
                {{------------------------------
                | Avatar
                ------------------------------}}
                <a href="{{ url_link_to_group($group->id) }}" class="cover__static__avatar rounded">
                    @if ($group->group_avatar_large != null || strlen($group->group_avatar_large) > 0)
                        <img src="{!! '/images/groupAvatar/'.$group->group_avatar_large !!}"
                             class="avatar avatar--lg rounded">
                    @else
                        <img class="avatar avatar--lg rounded" src="{{ url('/assets/images/avatar.jpg') }}">
                    @endif
                </a>

                {{------------------------------
                | Info
                ------------------------------}}
                <div class="cover__static__info">

                    {{------------------------------
                    | Group name
                    ------------------------------}}
                    <a href="{{ url_link_to_group($group->id) }}" class="cover__static__info__name h2 mR--md cover__color--primary">
                        {{$group->name}}
                    </a>

                    {{------------------------------
                    | Founded since
                    ------------------------------}}
                    <div class="cover__static__info__time cover__color--primary mB">
                        Founded since: {{$group->created_at->format('F Y')}}
                    </div>

                    {{------------------------------
                    | Group type
                    ------------------------------}}
                    <label class="label label-success">
                        {{getGroupTypeName($group)}}
                    </label>
                </div>
            </div>
            <div class="pull-right">
                <ul class="list-inline text-right">
                    <li class="mR--lg">
                        <div id="feed-total-count" class="thin text-xxxlg cover__color--primary">
                            {{ $group->feeds->count() }}
                        </div>
                        <div class="bolder small cover__color--secondary text-uppercase">
                            Total Feeds
                        </div>
                    </li>
                    <li class="mR--lg">
                        <div class="thin text-xxxlg cover__color--primary">
                            {{ $group->acceptUsers()->count() }}
                        </div>
                        <div class="bolder small cover__color--secondary text-uppercase">
                            Members
                        </div>
                    </li>
                    <li class="mR--lg">
                        <div class="thin text-xxxlg cover__color--primary">
                            {{ $group->dockingGroups()->count() }}
                        </div>
                        <div class="bolder small cover__color--secondary text-uppercase">
                            Bridging
                        </div>
                    </li>
                    <li>
                        <div class="thin text-xxxlg cover__color--primary">
                            0
                        </div>
                        <div class="bolder small text-light text-uppercase">
                            Events
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="cover__mask"></div>
</div>

<div class="cover__child cover__child cover--darker">
    <div id="sgp-cover-child-nav" class="cover__child__nav has-sticky__bar">
        <div class="sticky__bar">
            <div class="site-container">

                {{----------------------------
                | Menu
                ----------------------------}}
                <ul class="list-inline pull-left">
                    <li>
                        <a href="{{ url_link_to_group($group->id) }}" class="{{ set_active('singleGroupPage', 'cP bolder') }}">
                            Feeds
                            <label id="feed-unpinned-count" class="label label-outline-light label--sm mL">
                                {{ getUnpinnedFeedsCount($group_id) }}
                            </label>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url_link_to_group_pinned($group->id) }}" class="{{ set_active('singleGroupPinnedPage', 'cP bolder') }}">
                            Pinned
                            <label id="feed-pinned-count" class="label label-outline-light label--sm mL">
                                {{ getPinnedFeedsCount($group_id) }}
                            </label>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url_link_to_group_members($group->id) }}" class="{{ set_active('singleGroupMembersPage', 'cP bolder') }}">
                            Members
                            <label class="label label-outline-light label--sm mL">
                                {{ $group->acceptUsers()->count() }}
                            </label>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url_link_to_group_docked_group($group->id) }}" class="{{ set_active('singleGroupDockingPage', 'cP bolder') }}">
                            Bridging
                            <label class="label label-outline-light label--sm mL">
                                {{ $group->dockingGroups()->count() }}
                            </label>
                        </a>
                    </li>
                    @if($validate_currentUser_has_permission)
                        <li>
                            <a href="{{ url_link_to_group_notification($group->id) }}" class="{{ set_active('singleGroupNotificationPage', 'cP bolder') }}">
                                Notification
                                @if($group->groupRequestsPendingUsers()->count() >= 1 || $group->dockingGroupRequestPending()->count() >= 1)
                                    <label class="label label-danger label--sm mL">
                                        {{ $group->groupRequestsPendingUsers()->count() + $group->dockingGroupRequestPending()->count() }}
                                    </label>
                                @else
                                    <label class="label label-outline-light label--sm mL">
                                        0
                                    </label>
                                @endif
                            </a>
                        </li>
                        {{--<li>--}}
                            {{--<a href="{{ url_link_to_group_profile($group->id) }}" class="{{ set_active('singleGroupProfilePage', 'cP bolder') }}">--}}
                                {{--Manage Group--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    @endif
                </ul>

                <ul class="list-inline pull-right">
                    {{----------------------------
                    | Request Bridging
                    ----------------------------}}
                    <li>
                        <a href="{{ URL::route( 'dockingGroupSetupPage', $target_group_id = $group_id) }}" class="btn-retained btn btn-white-tt bar-btn-mT" target="_blank" role="button">
                            <span class="icon icon-bridging"></span>
                            Request Bridging
                        </a>
                    </li>


                    {{----------------------------
                    | Gear Button
                    ----------------------------}}
                    <li class="uiDropdown">
                        <a href="" data-toggle="dropdown">
                            <span class="icon icon-gear"></span>
                        </a>
                        <ul class="uiDropdown__menu uiDropdown__menu--right">
                            @if($validate_currentUser_has_permission)
                                <li>
                                    <a href="{{ url_link_to_group_profile($group->id) }}">
                                        Manage Group
                                    </a>
                                </li>
                            @endif

                            @if (!$validate_currentUser_in_group)
                                <li>

                                    {!! Form::model($group, ['route'=> ['joinGroup', 'group_id' => $group->id], 'method'=>'POST','id'=>'join-group', 'role'=>'form'])!!}
                                    {!! Form::submit('Join Group',['id'=>'join-group-submit']) !!}
                                    {!! Form::close() !!}
                                </li>
                            @elseif ($validate_currentUser_in_group && !$validate_currentUser_founder_of_group)
                                <li>
                                    <button data-toggle="modal" data-target="#singleGroupPage-leave">
                                        Leave Group
                                    </button>
                                </li>
                            @elseif ($validate_currentUser_in_group && $validate_currentUser_founder_of_group)
                                <li>
                                    <button data-show="tooltip"
                                            data-trigger="hover"
                                            data-placement="left"
                                            title="Founder cannot leave the group."
                                            disabled>
                                        Leave Group
                                    </button>
                                </li>
                            @endif
                        </ul>

                        {{----------------------------
                        | Leave Group
                        ----------------------------}}
                        <div class="uiModal fade" id="singleGroupPage-leave">
                            <div class="uiModal__dialog uiModal--sm">
                                <div class="uiModal__content">
                                    {!! Form::model($group, ['route'=> ['leave-group', 'group_id' => $group->id], 'method'=>'POST','id'=>'leave-group', 'role'=>'form'])!!}
                                    <div class="uiModal__header">
                                        <button class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                        <div class="h3 text-center">Leave Group</div>
                                    </div>

                                    <div class="uiModal__body">
                                        All of your feed, reply and activity will be permanent deleted, are you sure you want to leave this group?
                                    </div>

                                    <div class="uiModal__footer text-right">
                                        <button class="btn btn-outline-gray" data-dismiss="modal">Cancel</button>
                                        {!! Form::submit('Leave group',['id'=>'leave-group-submit', 'class'=>'btn btn-primary']) !!}
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </li>

                    {{----------------------------
                    | Switch
                    ----------------------------}}
                    <li class="singleGroup__cover__switch">
                        <div class="uiSwitch uiSwitch--v bar-btn-mT"
                             title="Toggle header"
                             data-show="tooltip"
                             data-trigger="hover"
                             data-placement="bottom">
                            @if(!$validate_currentUser_in_group)
                                <input type="checkbox" name="uiSwitch" class="uiSwitch__checkbox checked toggled" data-toggle="toggle-cover"
                                       id="sgp-cover-switch" checked>
                            @else
                                <input type="checkbox" name="uiSwitch" class="uiSwitch__checkbox uncheck" id="sgp-cover-switch"
                                       data-toggle="toggle-cover">
                            @endif
                            <label class="uiSwitch__label" for="sgp-cover-switch"></label>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{----------------------------
    | Profile Content
    ----------------------------}}
    <div id="sgp-cover-child-content" class="cover__child__content pT--md pB--md">
        <div class="site-container">
            <div id="sgp-last-activity-section">
                <div class="small cover__color--secondary">
                    <span class="bold text-uppercase">Last activity:</span>
                    currently unavailable.
                </div>
            </div>

            <div id="sgp-info-section" class="wrap">
                <div class="c-f-4 pR--xxxlg">
                    <div class="wrap">
                        <div class="c-f-12">
                            <div class="bold text-uppercase cover__color--secondary mB small">Activities</div>
                            <p>Currently unavailable</p>
                        </div>
                    </div>
                </div>
                <div class="c-f-8">
                    <div class="wrap mB--md">
                        <div class="c-f-12">
                            <div class="bold text-uppercase cover__color--secondary mB small">About</div>
                            <p>{!! nl2br(e($group->description)) !!}</p>
                        </div>
                    </div>
                    <div class="wrap">
                        <div class="c-f-4">
                            <div class="bold text-uppercase cover__color--secondary mB small">Location</div>
                            <p>Currently unavailable</p>
                        </div>
                        <div class="c-f-4">
                            <div class="bold text-uppercase cover__color--secondary mB small">Founded</div>
                            <p>{{$group->created_at->format('F d, Y')}}</p>
                        </div>
                        <div class="c-f-4">
                            <div class="bold text-uppercase cover__color--secondary mB small">Type</div>
                            <p>{{getGroupTypeName($group)}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
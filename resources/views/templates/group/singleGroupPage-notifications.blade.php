@if($validate_currentUser_has_permission)

    @if( $pendingUsers->count() >=1 || $pendingDockingGroupRequests->count() >=1 )

        @if($pendingUsers->count() >= 1)
            <div class="uiCard__header">
                <div class="h4">
                    <span class="icon icon-info"></span>
                    Pending User Request
                </div>
            </div>
            <ul class="list-style--light small {{ $pendingDockingGroupRequests->count() >=1 ? 'mB--xxlg':'' }}">
                @foreach($pendingUsers as $user)
                    <li>
                        <div class="pull-right mL--md forms--inline">
                            {!! Form::model($group, ['route'=> ['acceptJoinGroupRequest', 'group_id' => $group->id, 'requestUser_id' => $user->id], 'method'=>'POST','id'=>'join-group-accept', 'role'=>'form'])!!}
                            {!! Form::submit('Accept',['id'=>'join-group-submit','class'=>'btn btn-sns']) !!}
                            {!! Form::close() !!}

                            {!! Form::model($group, ['route'=> ['denyJoinGroupRequest', 'group_id' => $group->id, 'requestUser_id' => $user->id], 'method'=>'POST','id'=>'join-group-deny', 'role'=>'form'])!!}
                            {!! Form::submit('Decline',['id'=>'join-group-submit','class'=>'btn btn-sns']) !!}
                            {!! Form::close() !!}
                        </div>
                        <div class="list-style--light__text">
                            <a href="{{ url_link_to_target_profile($user->profile->nickname) }}">
                                {{ empty_eitherName_displayNickname($user) }}
                            </a>
                            is looking to join your group.
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif

        @if($pendingDockingGroupRequests->count() >=1)
            <div class="uiCard__header">
                <div class="h4">
                    <span class="icon icon-info"></span>
                    Pending Bridging Request
                </div>
            </div>
            <ul class="list-style--light small">
                @foreach($pendingDockingGroupRequests as $pendingDockingGroup)
                    <li>
                        <div class="pull-right mL--md forms--inline">
                            {!! Form::model($group, ['route'=> ['acceptDockingGroupRequest', 'sourceGroup_id' => $group->id, 'pendingDockingRequestGroup_id' => $pendingDockingGroup->id], 'method'=>'POST','id'=>'docking-group-accept', 'role'=>'form'])!!}
                            {!! Form::submit('Accept',['id'=>'docking-group-accept-submit','class'=>'btn btn-sns']) !!}
                            {!! Form::close() !!}

                            {!! Form::model($group, ['route'=> ['denyDockingGroupRequest', 'sourceGroup_id' => $group->id, 'pendingDockingRequestGroup_id' => $pendingDockingGroup->id], 'method'=>'POST','id'=>'docking-group-deny', 'role'=>'form'])!!}
                            {!! Form::submit('Decline',['id'=>'docking-group-deny-submit','class'=>'btn btn-sns']) !!}
                            {!! Form::close() !!}
                        </div>
                        <div class="list-style--light__text">
                            Group
                            <a href="{{ url_link_to_group($pendingDockingGroup->id) }}">
                                {{$pendingDockingGroup->name}}
                            </a>
                            is looking for bridging with your group.
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif

    @else

        You do not have any notification.

    @endif

@endif

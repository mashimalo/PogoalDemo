<div class="uiCards">
    <div class="uiCard">
        <div class="uiCard__body">

            {{----------------------------
            | Nav
            ----------------------------}}
            <div class="uiCard__nav clearfix">
                <ul class="list-inline pull-left uiTabs__nav">
                    <li class="active">
                        <a href="#tabs-1" data-toggle="tab" class="lk-d lk-block">Members</a>
                    </li>
                    <li>
                        <a href="#tabs-2" data-toggle="tab" class="lk-d lk-block">Admins</a>
                    </li>
                </ul>
                <ul class="list-inline pull-right uiCard__nav--btn">
                    <li>
                        <button class="btn btn-white-t" data-toggle="modal" data-target="#singleGroupMembersPage-add">
                            Add members
                        </button>
                    </li>
                </ul>
            </div>

            {{----------------------------
            | Add Member Modal
            ----------------------------}}
            <div class="uiModal fade" id="singleGroupMembersPage-add">
                <div class="uiModal__dialog uiModal--sm">
                    <div class="uiModal__content">
                        {!! Form::open(['name'=>'addMember-form','url'=>'','method'=>'post','data-toggle'=>'validator']) !!}
                        <div class="uiModal__header">
                            <button class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                            <div class="h3 text-center">Add Members</div>
                        </div>

                        <div class="uiModal__body">
                            {{----------------------------
                            | Invite Group Member
                            ----------------------------}}
                            <div class="form-group form-prepend form-prepend-label">
                                {!! Form::label('group_email','Invite members:') !!}
                                {!! Form::email('group_email', null, ['class'=>'form-control','placeholder'=>'Emails','id'=>'group_email', 'title'=>'Use ( , ) to add an email.']) !!}
                                <div class="help-block with-errors"></div>
                                <div class="text-light small mT"><span class="icon icon-warn mR"></span>Invite member is currently unavailable</div>
                                <div class="text-light small mT">Use ( , ) to add an email.</div>
                            </div>
                        </div>

                        <div class="uiModal__footer text-right">
                            <button class="btn btn-outline-gray" data-dismiss="modal">Cancel</button>
                            {!! Form::submit('Add',['class'=>'btn btn-primary']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            {{----------------------------
            | Member Tab
            ----------------------------}}
            <div id="tabs-1" class="uiCard__content active uiTabs__content">

                {{----------------------------
                | Member List
                ----------------------------}}
                <ul class="uiMemberList break-word">

                    {{----------------------------
                    | Member
                    ----------------------------}}
                    @foreach($acceptedUsers as $user)
                        <li class="uiMemberList__item bg--list arc-sm">
                            <a href="{{ url_link_to_target_profile(\App\Models\Profile::where('user_id', $user->id)->first()->nickname) }}"
                               class="uiMemberList__avatar">
                                <img data-name="{{ empty_firstName_displayNickname($user) }}" class="initialAvatar avatar avatar--block arc-sm-left"/>
                                {{--<img class="avatar avatar--block arc-sm-left" src="{{ url('/assets/images/avatar.jpg') }}">--}}
                            </a>

                            <div class="uiMemberList__misc forms--inline">
                                @if(!(validate_targetUser_founder_of_group($group->id, $user->id)))
                                    @if ((validate_currentUser_has_higher_permission_than_targetUser($group->id, $user->id)) )
                                        @if( !validate_targetUser_coordinator_of_group($group->id, $user->id))
                                            {!! Form::model($group, ['route'=> ['promoteUser-group', 'group_id' => $group->id, 'targetUser_id' => $user->id], 'method'=>'POST','id'=>'promoteUser-group', 'role'=>'form'])!!}
                                            {!! Form::submit('Promote',['id'=>'promote-group-submit','class'=>'btn btn-sns']) !!}
                                            {!! Form::close() !!}
                                        @endif

                                        @if( !validate_targetUser_member_of_group($group->id, $user->id))
                                            {!! Form::model($group, ['route'=> ['demoteUser-group', 'group_id' => $group->id, 'targetUser_id' => $user->id], 'method'=>'POST','id'=>'demoteUser-group', 'role'=>'form'])!!}
                                            {!! Form::submit('Demote',['id'=>'demote-group-submit','class'=>'btn btn-sns']) !!}
                                            {!! Form::close() !!}
                                        @endif

                                        {!! Form::model($group, ['route'=> ['removeUser-group', 'group_id' => $group->id, 'targetUser_id' => $user->id], 'method'=>'POST','id'=>'removeUser-group', 'role'=>'form'])!!}
                                        {!! Form::submit('Remove',['id'=>'remove-group-submit','class'=>'btn btn-sns']) !!}
                                        {!! Form::close() !!}
                                    @endif
                                @endif
                            </div>

                            <div class="uiMemberList__details">
                                <a href="{{ url_link_to_target_profile(\App\Models\Profile::where('user_id', $user->id)->first()->nickname) }}"
                                   class="h5 mR">
                                    {{ empty_eitherName_displayNickname($user) }}
                                </a>

                                <span class="xsmall text-light">
                                    {{getUserRoleInGroup($group, $user)}}
                                </span>

                                <div class="xsmall text-light">
                                    <span class="icon icon-calendar mR"></span>
                                    Joined since {{ get_user_join_group_date($user, $group)->format('M d, Y') }}
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>

            </div>

            {{----------------------------
            | Admins Tab
            ----------------------------}}
            <div id="tabs-2" class="uiCard__content uiTabs__content">

                {{----------------------------
                | Admin List
                ----------------------------}}
                <ul class="uiMemberList break-word">

                    {{----------------------------
                    | Admin
                    ----------------------------}}
                    @foreach($adminUsers as $user)
                        <li class="uiMemberList__item bg--list arc-sm">
                            <a href="{{ url_link_to_target_profile(\App\Models\Profile::where('user_id', $user->id)->first()->nickname) }}"
                               class="uiMemberList__avatar">
                                <img data-name="{{ empty_firstName_displayNickname($user) }}" class="initialAvatar avatar avatar--block arc-sm-left"/>
                                {{--<img class="avatar avatar--block arc-sm-left" src="{{ url('/assets/images/avatar.jpg') }}">--}}
                            </a>

                            <div class="uiMemberList__misc forms--inline">
                                @if(!(validate_targetUser_founder_of_group($group->id, $user->id)))
                                    @if ((validate_currentUser_has_higher_permission_than_targetUser($group->id, $user->id)) )
                                        @if( !validate_targetUser_coordinator_of_group($group->id, $user->id))
                                            {!! Form::model($group, ['route'=> ['promoteUser-group', 'group_id' => $group->id, 'targetUser_id' => $user->id], 'method'=>'POST','id'=>'promoteUser-group', 'role'=>'form'])!!}
                                            {!! Form::submit('Promote',['id'=>'promote-group-submit','class'=>'btn btn-sns']) !!}
                                            {!! Form::close() !!}
                                        @endif

                                        @if( !validate_targetUser_member_of_group($group->id, $user->id))
                                            {!! Form::model($group, ['route'=> ['demoteUser-group', 'group_id' => $group->id, 'targetUser_id' => $user->id], 'method'=>'POST','id'=>'demoteUser-group', 'role'=>'form'])!!}
                                            {!! Form::submit('Demote',['id'=>'demote-group-submit','class'=>'btn btn-sns']) !!}
                                            {!! Form::close() !!}
                                        @endif

                                        {!! Form::model($group, ['route'=> ['removeUser-group', 'group_id' => $group->id, 'targetUser_id' => $user->id], 'method'=>'POST','id'=>'removeUser-group', 'role'=>'form'])!!}
                                        {!! Form::submit('Remove',['id'=>'remove-group-submit','class'=>'btn btn-sns']) !!}
                                        {!! Form::close() !!}
                                    @endif
                                @endif
                            </div>

                            <div class="uiMemberList__details">
                                <a href="{{ url_link_to_target_profile(\App\Models\Profile::where('user_id', $user->id)->first()->nickname) }}"
                                   class="h5 mR">
                                    {{ empty_eitherName_displayNickname($user) }}
                                </a>

                                <span class="xsmall text-light">
                                    {{getUserRoleInGroup($group, $user)}}
                                </span>

                                <div class="xsmall text-light">
                                    <span class="icon icon-calendar mR"></span>
                                    Joined since {{ get_user_join_group_date($user, $group)->format('M d, Y') }}
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                {{--@include('templates.pagination.limitLink', ['paginator' => $adminUsers])--}}
            </div>
        </div>
    </div>
</div>

@include('templates.pagination.limitLink', ['paginator' => $acceptedUsers])
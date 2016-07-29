<div class="uiCards">
    <div class="uiCard">
        <div class="uiCard__body">

            {{----------------------------
            | Member Tab
            ----------------------------}}
            <div class="uiCard__content">

                <div class="uiCard__header">
                    <div class="h4">
                        Bridging Groups
                    </div>
                </div>

                {{----------------------------
                | Bridging Group List
                ----------------------------}}
                @if( $group->dockingGroups()->count() >=1 )
                    <ul class="list-style--light small">
                        @foreach($group->dockingGroups() as $dockedGroup)
                            <li>
                                <div class="mL--md pull-right">
                                    <span class="mR vA--middle">Bridging with:</span>
                                    <a href="{{ url_link_to_group($dockedGroup->id) }}" class="h5">
                                        @if (get_group_by_id($dockedGroup->id)->group_avatar_small != null || strlen(get_group_by_id($dockedGroup->id)->group_avatar_small) > 0)
                                            <img src="{!! '/images/groupAvatar/'.get_group_by_id($dockedGroup->id)->group_avatar_small !!}"
                                                 class="avatar avatar--sm rounded">
                                        @else
                                            <img class="avatar avatar--sm rounded" src="{{ url('/assets/images/avatar.jpg') }}">
                                        @endif
                                        <span class="vA--middle maxW--sm text-overflow inline-block">{{ $dockedGroup->name }}</span>
                                    </a>
                                </div>
                                <div class="overflow-h lh-avatar--sm h3 text-overflow">
                                    <a href="{{ url_link_to_dockingGroup_source_target_group($group->id, $dockedGroup->id) }}">
                                        {{ dockingGroup_name_source_target_group($group->id, $dockedGroup->id) }}
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="mB--md">
                        <div class="uiAlert uiAlert--info uiAlert--dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert">
                                <span aria-hidden="true">&times;</span>
                                <span class="hidden-text">{{ trans('front/uiAlert.close') }}</span>
                            </button>
                            <span class="uiAlert__icon icon icon-warn"></span>
                            <div class="uiAlert__content text-left small">
                                <p>You don't have any bridging group yet.</p>
                            </div>
                        </div>

                        <span>Find your favorite groups and start your first bridging: </span>
                    </div>
                    <div class="wrap">
                        <div class="c-f-3">
                            <a href="{{ URL::route ('showAllGroups') }}" class="btn btn-create-block btn-block arc-md text-white"
                               title="Find a group">
                                <span class="icon icon-bridging"></span>
                            </a>
                        </div>
                    </div>
                @endif


                {{--<ul class="uiMemberList break-word">--}}
                {{------------------------------}}
                {{--| Member--}}
                {{------------------------------}}
                {{--@foreach($group->dockingGroups() as $dockedGroup)--}}
                {{--<li class="uiMemberList__item bg--list arc-sm">--}}
                {{--<a href="{{ url_link_to_group($dockedGroup->id) }}" class="uiMemberList__avatar">--}}
                {{--<img data-name="{{ $dockedGroup->name }}" class="initialAvatar avatar avatar--block arc-sm-left"/>--}}
                {{--<img class="avatar avatar--block arc-sm-left" src="{{ url('/assets/images/avatar.jpg') }}">--}}
                {{--</a>--}}
                {{--<div class="uiMemberList__misc forms--inline">--}}
                {{--@if(!(validate_targetUser_founder_of_group($group->id, $user->id)))--}}
                {{--@if ((validate_currentUser_has_higher_permission_than_targetUser($group->id, $user->id)) )--}}
                {{--@if( !validate_targetUser_coordinator_of_group($group->id, $user->id))--}}
                {{--{!! Form::model($group, ['route'=> ['promoteUser-group', 'group_id' => $group->id, 'targetUser_id' => $user->id], 'method'=>'POST','id'=>'promoteUser-group', 'role'=>'form'])!!}--}}
                {{--{!! Form::submit('Promote',['id'=>'promote-group-submit','class'=>'btn btn-sns']) !!}--}}
                {{--{!! Form::close() !!}--}}
                {{--@endif--}}
                {{--@if( !validate_targetUser_member_of_group($group->id, $user->id))--}}
                {{--{!! Form::model($group, ['route'=> ['demoteUser-group', 'group_id' => $group->id, 'targetUser_id' => $user->id], 'method'=>'POST','id'=>'demoteUser-group', 'role'=>'form'])!!}--}}
                {{--{!! Form::submit('Demote',['id'=>'demote-group-submit','class'=>'btn btn-sns']) !!}--}}
                {{--{!! Form::close() !!}--}}
                {{--@endif--}}
                {{--{!! Form::model($group, ['route'=> ['removeUser-group', 'group_id' => $group->id, 'targetUser_id' => $user->id], 'method'=>'POST','id'=>'removeUser-group', 'role'=>'form'])!!}--}}
                {{--{!! Form::submit('Remove',['id'=>'remove-group-submit','class'=>'btn btn-sns']) !!}--}}
                {{--{!! Form::close() !!}--}}
                {{--@endif--}}
                {{--@endif--}}
                {{--</div>--}}
                {{--<div class="uiMemberList__details">--}}
                {{--<a href="{{ url_link_to_group($dockedGroup->id) }}" class="h5 mR">--}}
                {{--{{ $dockedGroup->name }}--}}
                {{--</a>--}}
                {{--<span class="xsmall text-light">--}}
                {{--{{ $group->description }}--}}
                {{--</span>--}}
                {{--<div class="xsmall text-light">--}}
                {{--{{  $dockedGroup->groupType->group_type_name }}--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--<a href="{{  url_link_to_dockingGroup_source_target_group($group->id, $dockedGroup->id) }}">--}}
                {{--Go to the Bridging Group Page--}}
                {{--</a>--}}
                {{--{{ Auth::user()->groups()->wherePivot('group_user_role_id', '<', 3)->get() }}--}}
                {{--</li>--}}
                {{--@endforeach--}}
                {{--</ul>--}}
            </div>
        </div>
    </div>
</div>

{{--@include('templates.pagination.limitLink', ['paginator' => $acceptedUsers])--}}

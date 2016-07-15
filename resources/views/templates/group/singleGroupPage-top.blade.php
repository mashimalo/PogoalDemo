{{--<div class="uiAlert uiAlert--info uiAlert--dismissible" role="alert">--}}
{{--<button type="button" class="close" data-dismiss="alert">--}}
{{--<span aria-hidden="true">&times;</span>--}}
{{--<span class="hidden-text">{{ trans('front/uiAlert.close') }}</span>--}}
{{--</button>--}}
{{--<span class="uiAlert__icon icon icon-info"></span>--}}
{{--<div class="uiAlert__content text-left small">--}}
{{--<p>You have 3 Notifications.</p>--}}
{{--</div>--}}
{{--</div>--}}

@include('templates.session.checkSession')

<div class="sgp-main__items">
    {{----------------------------
    | Navigation
    ----------------------------}}
    {{--<div class="sgp-main__item has-sticky__bar">--}}
    {{------------------------------}}
    {{--| Navigation--}}
    {{------------------------------}}
    {{--<div class="sgp-nav sticky__bar">--}}
    {{--<div class="sticky__bar__container">--}}
    {{--<div class="pull-left">--}}
    {{--<a href="{{ url_link_to_group($group->id) }}"--}}
    {{--class="btn-stack lk-bd lk-d {{ set_active('singleGroupPage', 'bolder cPbd') }}">--}}
    {{--<span class="btn-stack__t">Feeds</span>--}}
    {{--<span id="feed-unpinned-count"--}}
    {{--class="btn-stack__b">{{ getUnpinnedFeedsCount($group_id) }}</span>--}}
    {{--</a>--}}
    {{--<a href="{{ url_link_to_group_pinned($group->id) }}"--}}
    {{--class="btn-stack lk-bd lk-d {{ set_active('singleGroupPinnedPage', 'bolder cPbd') }}">--}}
    {{--<span class="btn-stack__t">Pinned</span>--}}
    {{--<span id="feed-pinned-count" class="btn-stack__b">{{ getPinnedFeedsCount($group_id) }}</span>--}}
    {{--</a>--}}
    {{--<a href="#" class="btn-stack lk-bd lk-d">--}}
    {{--<span class="btn-stack__t">Events</span>--}}
    {{--<span class="btn-stack__b">0</span>--}}
    {{--</a>--}}
    {{--<a href="{{ url_link_to_group_members($group->id) }}"--}}
    {{--class="btn-stack lk-bd lk-d {{ set_active('singleGroupMembersPage', 'bolder cPbd') }}">--}}
    {{--<span class="btn-stack__t">Members</span>--}}
    {{--<span id="group-member-count" class="btn-stack__b">{{ $group->acceptUsers()->count() }}</span>--}}
    {{--</a>--}}
    {{--<a href="#" class="btn-stack lk-bd lk-d">--}}
    {{--<span class="btn-stack__t">Followers</span>--}}
    {{--<span class="btn-stack__b">0</span>--}}
    {{--</a>--}}
    {{--</div>--}}

    {{--<div class="pull-right">--}}
    {{------------------------------}}
    {{--| Buttons--}}
    {{------------------------------}}
    {{--<div class="uiDropdown inline-block mL">--}}
    {{--<button class="btn btn-outline-gray" data-toggle="dropdown">--}}
    {{--<span class="icon icon-gear"></span>--}}
    {{--</button>--}}
    {{--<ul class="uiDropdown__menu uiDropdown__menu--right arrow--none">--}}
    {{--<li>--}}
    {{--<a href="{{ URL::route( 'dockingGroupSetupPage', $target_group_id = $group_id) }}" target="_blank">--}}
    {{--Request Bridging--}}
    {{--</a>--}}
    {{--</li>--}}
    {{--<li class="divider"></li>--}}
    {{--@if($validate_currentUser_has_permission)--}}
    {{--<li>--}}
    {{--<a href="{{ url_link_to_group_profile($group->id)}}">--}}
    {{--Manage Group--}}
    {{--</a>--}}
    {{--</li>--}}
    {{--@endif--}}

    {{--@if (!$validate_currentUser_in_group)--}}
    {{--<li>--}}
    {{--{!! Form::model($group, ['route'=> ['joinGroup', 'group_id' => $group->id], 'method'=>'POST','id'=>'join-group', 'role'=>'form'])!!}--}}
    {{--{!! Form::submit('Join Group',['id'=>'join-group-submit']) !!}--}}
    {{--{!! Form::close() !!}--}}
    {{--</li>--}}
    {{--@elseif ($validate_currentUser_in_group && !$validate_currentUser_founder_of_group)--}}
    {{--<li>--}}
    {{--{!! Form::model($group, ['route'=> ['leave-group', 'group_id' => $group->id], 'method'=>'POST','id'=>'leave-group', 'role'=>'form'])!!}--}}
    {{--{!! Form::submit('Leave group',['id'=>'leave-group-submit']) !!}--}}
    {{--{!! Form::close() !!}--}}
    {{--</li>--}}
    {{--@elseif ($validate_currentUser_in_group && $validate_currentUser_founder_of_group)--}}
    {{--<li>--}}
    {{--<button data-show="tooltip" data-trigger="hover" data-placement="left"--}}
    {{--title="Founder cannot leave the group." disabled>--}}
    {{--Leave Group--}}
    {{--</button>--}}
    {{--</li>--}}
    {{--@endif--}}
    {{--</ul>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div><!-- .sgp-nav -->--}}
    {{--</div>--}}

    {{----------------------------
    | Rich Form post feed
    ----------------------------}}
    @if ($validate_currentUser_in_group)
        @if(currentRoute('singleGroupPage'))
            <div class="rich-form sgp-main__item">

                <div class="rich-form-body">
                    {!! Form::textarea('feed',null,['class'=>'form-control bg-white h--sm','placeholder'=>'Spit it out...','data-elastic'=>'rich-form']) !!}
                    <img data-name="{{ empty_firstName_displayNickname(Auth::user()) }}"
                         class="initialAvatar rich-form-avatar avatar avatar--md arc-sm"/>
                </div>

                <div class="rich-form-footer">
                    <div class="pull-left">
                        <span class="icon icon-camera lk-block"></span>
                    </div>

                    <div class="pull-right">
                        <button class="btn btn-primary" data-action="post-feed" data-action-for="group" data-group-id="{{ $group->id }}">
                            Post
                        </button>
                    </div>
                </div>

                {{--{!! Form::model($group, ['route'=> ['feed-post', $group->id], 'method'=>'POST','id'=>'post-feed', 'data-toggle'=>'validator', 'role'=>'form'])!!}--}}
                {{--<div class="rich-form-body">--}}
                {{--{!! Form::textarea('feed',null,['class'=>'form-control bg-white h--sm','placeholder'=>'Spit it out...','data-elastic'=>'rich-form']) !!}--}}
                {{--<img data-name="{{ getUserFirstName() }}"--}}
                {{--class="initialAvatar rich-form-avatar avatar avatar--md arc-sm"/>--}}
                {{--<img class="rich-form-avatar avatar avatar--md arc-sm" src="{{ url('/assets/images/avatar.jpg') }}">--}}
                {{--</div>--}}

                {{--<div class="rich-form-footer">--}}
                {{--<div class="pull-left">--}}
                {{--<span class="icon icon-camera lk-block"></span>--}}
                {{--</div>--}}

                {{--<div class="pull-right">--}}
                {{--{!! Form::submit('Post',['class'=>'btn btn-primary']) !!}--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--{!! Form::close() !!}--}}

            </div>
        @endif
    @endif
</div>
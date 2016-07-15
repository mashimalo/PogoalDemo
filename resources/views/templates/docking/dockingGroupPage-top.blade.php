@include('templates.session.checkSession')

{{--------------------------
| Bridging Group Name
--------------------------}}
<h2 class="text-xlg mB--md text-center">
    {{ $dockingGroup->docking_group_name }}
</h2>

<div class="docking-main__items">
    {{--------------------------
    | Navigation
    --------------------------}}
    <div class="docking-main__item has-sticky__bar">
        {{--------------------------
        | Navigation
        --------------------------}}
        <div class="docking-nav sticky__bar">
            <div class="sticky__bar__container">
                <div class="pull-left">
                    <a href="{{ url_link_to_dockingGroup($dockingGroup->id) }}"
                       class="btn-stack lk-bd lk-d {{ set_active('dockingGroupPage', 'bolder cPbd') }}">
                        <span class="btn-stack__t">Feeds</span>
                        <span id="feed-unpinned-count" class="btn-stack__b">{{ getUnpinnedDockingGroupFeedsCount($dockingGroup->id) }}</span>
                    </a>
                    <a href="{{ url_link_to_dockingGroup_pinned($dockingGroup->id) }}"
                       class="btn-stack lk-bd lk-d {{ set_active('dockingGroupPinnedPage', 'bolder cPbd') }}">
                        <span class="btn-stack__t">Pinned</span>
                        <span id="feed-pinned-count" class="btn-stack__b">{{ getPinnedDockingGroupFeedsCount($dockingGroup->id) }}</span>
                    </a>
                </div>

                <ul class="list-inline pull-right">
                    <li class="uiDropdown">
                        <button data-toggle="dropdown" class="btn btn-outline-gray">
                            <span class="icon icon-gear"></span>
                        </button>
                        <ul class="uiDropdown__menu uiDropdown__menu--right arrow--none">
                            @if($validate_currentUser_has_permission_in_dockingGroup)
                                <li>
                                    {{--<a href="{{ url_link_to_group_profile($dockingGroup_id)}}">--}}
                                    <a href="{{ URL::route( 'dockingGroupEditPage-show', $dockingGroup->id) }}">
                                        Manage Bridging Group
                                    </a>
                                </li>
                                <li>
                                    <button data-toggle="modal" data-target="#dockingGroupPage-disband">
                                        Disband Bridging
                                    </button>
                                </li>
                            @endif
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    {{----------------------------
    | Rich Form post feed
    ----------------------------}}
    @if ($validate_currentUser_in_dockingGroup)
        @if(currentRoute('dockingGroupPage'))
            <div class="rich-form docking-main__item">

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
                        <button class="btn btn-primary"
                                data-action="post-feed"
                                data-action-for="docking"
                                data-group-id="{{ $dockingGroup->id }}">
                            Post
                        </button>
                    </div>
                </div>

                {{--{!! Form::model($dockingGroup, ['route'=> ['feed-post-dockingGroup', $dockingGroup->id], 'method'=>'POST','id'=>'post-feed', 'data-toggle'=>'validator', 'role'=>'form'])!!}--}}
                {{--<div class="rich-form-body">--}}
                {{--{!! Form::textarea('feed',null,['class'=>'form-control bg-white h--sm','placeholder'=>'Spit it out...','data-elastic'=>'rich-form']) !!}--}}
                {{--<img data-name="{{ getUserFirstName() }}" class="initialAvatar rich-form-avatar avatar avatar--md arc-sm"/>--}}
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

{{----------------------------
| Disband Group Modal
----------------------------}}
<div class="uiModal fade" id="dockingGroupPage-disband">
    <div class="uiModal__dialog uiModal--sm">
        <div class="uiModal__content">
            {!! Form::model($dockingGroup, ['route'=> ['dockingGroup-disband', 'dockingGroup_id' => $dockingGroup->id], 'method'=>'POST','id'=>'dockingGroup-disband', 'role'=>'form'])!!}
            <div class="uiModal__header">
                <button class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
                <div class="h3 text-center">Disband Bridging</div>
            </div>

            <div class="uiModal__body">
                This bridging group will be permanent deleted, are you sure you want to delete it?
            </div>

            <div class="uiModal__footer text-right">
                <button class="btn btn-outline-gray" data-dismiss="modal">Cancel</button>
                {!! Form::submit('Disband Bridging',['id'=>'leave-group-submit', 'class'=>'btn btn-primary']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
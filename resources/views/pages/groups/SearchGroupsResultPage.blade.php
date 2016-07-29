@extends('layouts.default')

@section('pageTitle')
    {{ trans("front/page-title.groups") }}
@stop

{{----------------------------
| Sub Bar
----------------------------}}
@section('navBar')
    @include('templates.navBar.navBar')
@stop

{{----------------------------
| Content
----------------------------}}
@section('content')
    <div class="wrap">
        <div class="c-f-9 pR--lg">
            <div class="wrap">
                @if($groups->count() >= 1)
                    @foreach($groups as $group)
                        <div class="uiTile c-f-3 mB--md">
                            <div class="uiTile__body arc-sm">
                                <div class="uiTile__cover">
                                    <a href="{{ url_link_to_group($group->id) }}">

                                        {{----------------------------
                                        | Group avatar
                                        ----------------------------}}
                                        @if ($group->group_avatar_large != null || strlen($group->group_avatar_large) > 0)
                                            <img src="{!! '/images/groupAvatar/'.$group->group_avatar_large !!}"
                                                 class="uiTile__avatar avatar avatar--fluid">
                                        @else
                                            <img class="uiTile__avatar avatar avatar--fluid" src="{{ url('/assets/images/avatar.jpg') }}">
                                        @endif

                                    </a>
                                </div>
                                <div class="uiTile__content bg-white">
                                    <div class="uiTile__title bold mB">
                                        <a href="{{ url_link_to_group($group->id) }}" class="lk-darker">
                                            {{ $group->name }}
                                        </a>
                                    </div>
                                    <div class="uiTile__description small text-light mB text-overflow">
                                        {{ str_limit($group->description,25) }}
                                    </div>
                                    <div class="uiTile__members text-light small">
                                        <span class="icon icon-group mR"></span>
                                        {{ singularOrPlural($group->acceptUsers()->count(), "member", "members", "0 member") }}
                                    </div>
                                    <div class="uiTile__category text-light small">
                                        <span class="icon icon-category mR"></span>
                                        {{ getGroupTypeName($group) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="c-f-12 mB--md">
                        @if(currentRoute('searchGroup-get'))
                            <div class="uiAlert uiAlert--danger uiAlert--dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="hidden-text">{{ trans('front/uiAlert.close') }}</span>
                                </button>
                                <span class="uiAlert__icon icon icon-warn"></span>
                                <div class="uiAlert__content text-left small">
                                    <p>Oops! There is no group related to "{{ Request::input('searchGroups') }}".</p>
                                </div>
                            </div>

                            <span>Be first to create your "{{ Request::input('searchGroups') }}" group :</span>
                        @endif
                        @if(currentRoute('SearchByGroupsTypeResult-get'))
                            <div class="uiAlert uiAlert--danger uiAlert--dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="hidden-text">{{ trans('front/uiAlert.close') }}</span>
                                </button>
                                <span class="uiAlert__icon icon icon-warn"></span>
                                <div class="uiAlert__content text-left small">
                                    <p>Oops! There is no group related to "{{ getGroupTypeByGroupTypeID($group_type_id) }}".</p>
                                </div>
                            </div>

                            <span>Be the first to create your "{{ getGroupTypeByGroupTypeID($group_type_id) }}" group :</span>
                        @endif
                    </div>
                    <div class="c-f-3">
                        <a href="{{ URL::route ('singleGroupCreatePage-show') }}" class="btn btn-create-block btn-block arc-md lk-darker"
                           title="Create a group">
                            <span class="icon icon-plus"></span>
                        </a>
                    </div>
                @endif
            </div>
            @include('templates.pagination.limitLink', ['paginator' => $groups->appends(Input::except('page'))])
        </div>
        <div class="c-f-3 pL--lg bordered--l bordered--l--light">

            {{----------------------------
            | Search Result Text
            ----------------------------}}
            <div class="bordered--b bordered--b--light text-light bold pB--md mB--md">
                @if(currentRoute('searchGroup-get'))
                    <div class="mB">Search Results for:</div>
                    <label class="pT pB pL--sm pR--sm bg--darker small arc-sm mB">{{ Request::input('searchGroups') }}</label>
                    <div>Total: {{ singularOrPlural($groups->count(), "result", "results", "No result") }}</div>
                @endif
                @if(currentRoute('SearchByGroupsTypeResult-get'))
                    <div class="mB">Search Results for category:</div>
                    <label class="pT pB pL--sm pR--sm bg--darker small arc-sm mB">{{ getGroupTypeByGroupTypeID($group_type_id) }}</label>
                    <div>Total: {{ singularOrPlural($groups->count(), "result", "results", "No result") }}</div>
                @endif
                @if(currentRoute('showAllGroups'))
                    <div class="mB">Search Results for:</div>
                    <label class="pT pB pL--sm pR--sm bg--darker small arc-sm mB">All Groups</label>
                    <div>Total: {{ singularOrPlural($groups->count(), "result", "results", "No result") }}</div>
                @endif
            </div>

            {{----------------------------
            | Popular Bridging Groups
            ----------------------------}}
            <div class="bold mB--md">
                Popular Bridging Groups
            </div>
            <ul class="uiList uiList--docking">
                @foreach(App\Models\DockingGroup::all() as $dockingGroup)
                    <li class="uiList__item pB--sm mB--sm">
                        <a href="{{ url_link_to_dockingGroup( $dockingGroup->id ) }}">
                            <div class="uiList__img">
                                {{----------------------------
                                | Group 1 avatar
                                ----------------------------}}
                                @if (get_group_by_id( $dockingGroup->group_1_id )->group_avatar_small != null || strlen(get_group_by_id( $dockingGroup->group_1_id )->group_avatar_small) > 0)
                                    <img src="{!! '/images/groupAvatar/'.get_group_by_id( $dockingGroup->group_1_id )->group_avatar_small !!}"
                                         class="avatar__primary avatar avatar--sm rounded pull-left">
                                @else
                                    <img class="avatar__primary avatar avatar--sm rounded pull-left" src="{{ url('/assets/images/avatar.jpg') }}">
                                @endif

                                {{----------------------------
                                | Group 2 avatar
                                ----------------------------}}
                                @if (get_group_by_id( $dockingGroup->group_2_id )->group_avatar_small != null || strlen(get_group_by_id( $dockingGroup->group_2_id )->group_avatar_small) > 0)
                                    <img src="{!! '/images/groupAvatar/'.get_group_by_id( $dockingGroup->group_2_id )->group_avatar_small !!}"
                                         class="avatar__secondary avatar avatar--sm rounded pull-left">
                                @else
                                    <img class="avatar__secondary avatar avatar--sm rounded pull-left" src="{{ url('/assets/images/avatar.jpg') }}">
                                @endif
                            </div>
                            <div class="uiList__body">

                                <div class="uiList__name small">
                                    {{ get_group_name_by_id( $dockingGroup->group_1_id ) }}
                                </div>
                                <div class="uiList__name small">
                                    {{ get_group_name_by_id( $dockingGroup->group_2_id ) }}
                                </div>

                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@stop
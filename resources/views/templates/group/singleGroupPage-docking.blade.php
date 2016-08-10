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
                    <ul class="list-style--light">
                        @foreach($group->dockingGroups() as $dockedGroup)
                            <li>
                                <div class="mL--md pull-right small">
                                    <span class="mR vA--middle">Bridging with:</span>
                                    <a href="{{ url_link_to_group($dockedGroup->id) }}" class="bold lk-darker">
                                        @if (get_group_by_id($dockedGroup->id)->group_avatar_small != null || strlen(get_group_by_id($dockedGroup->id)->group_avatar_small) > 0)
                                            <img src="{!! '/images/groupAvatar/'.get_group_by_id($dockedGroup->id)->group_avatar_small !!}"
                                                 class="avatar avatar--sm rounded">
                                        @else
                                            <img class="avatar avatar--sm rounded" src="{{ url('/assets/images/avatar.jpg') }}">
                                        @endif
                                        <span class="vA--middle maxW--sm text-overflow inline-block">{{ $dockedGroup->name }}</span>
                                    </a>
                                </div>
                                <div class="overflow-h lh-avatar--sm text-overflow">
                                    <a href="{{ url_link_to_dockingGroup_source_target_group($group->id, $dockedGroup->id) }}" class="lk-darker bolder">
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
            </div>
        </div>
    </div>
</div>

{{--@include('templates.pagination.limitLink', ['paginator' => $acceptedUsers])--}}

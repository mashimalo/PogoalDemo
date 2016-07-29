<div class="wrap">
    @if($acceptedGroups->count() >= 1)
        @foreach($acceptedGroups as $group)
            <div class="c-f-4 mB--md">
                <div class="shadow shadow--hover overflow-h arc-sm">

                    {{------------------------------
                    | Top
                    ------------------------------}}
                    <div class="bg-white inline-block w--full p-relative arrow--down arrow--down--white arrow--down--center">
                        <a href="{{ url_link_to_group($group->id) }}" class="pull-left">
                            {{----------------------------
                            | Group avatar
                            ----------------------------}}
                            @if ($group->group_avatar_large != null || strlen($group->group_avatar_large) > 0)
                                <img src="{!! '/images/groupAvatar/'.$group->group_avatar_large !!}"
                                     class="avatar avatar--lg">
                            @else
                                <img class="avatar avatar--lg" src="{{ url('/assets/images/avatar.jpg') }}">
                            @endif
                        </a>
                        <div class="pA--md overflow-h">
                            <a href="{{ url_link_to_group($group->id) }}" class="bold lk-darker text-overflow mB">
                                {{ $group->name }}
                            </a>
                            <div class="small text-light">
                                <div class="inline-block mR--md">
                                    <span class="icon icon-category mR"></span>
                                    {{getGroupTypeName($group)}}
                                </div>
                                <div class="inline-block">
                                    <span class="icon icon-group mR"></span>
                                    @if($group->acceptUsers()->count() >= 1000)
                                        {{ numberForHumans($group->acceptUsers()->count()) }}
                                    @else
                                        {{ $group->acceptUsers()->count() }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{------------------------------
                    | Bottom
                    ------------------------------}}
                    <div class="bg--darker pA--md">
                        <div class="mB bold">
                            <span class="icon icon-rocket mR"></span>
                            Latest Feed
                        </div>
                        <div class="h--article--single">
                            @if($group->feeds->count() == 0)
                                <span class="overflow-h">
                                    This group currently has no feed.
                                </span>
                                <a href="{{ url_link_to_group($group->id) }}" class="btn btn-xs btn-primary mL--md pull-right">
                                    Post one now
                                </a>
                            @endif

                            @if($group->feeds->count() >= 1)
                                @foreach($group->feeds->sortBy('created_at')->reverse()->take(1) as $feed)
                                    <a href="{{ url_link_to_group($group->id) }}" class="text-white text-overflow">
                                        {!! $feed->content  !!}
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="c-f-12 mB--md">
            <div class="uiAlert uiAlert--info uiAlert--dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">&times;</span>
                    <span class="hidden-text">{{ trans('front/uiAlert.close') }}</span>
                </button>
                <span class="uiAlert__icon icon icon-warn"></span>
                <div class="uiAlert__content text-left small">
                    <p>You don't have any group yet.</p>
                </div>
            </div>

            <span>Create your first group or join a group: </span>
        </div>
        <div class="c-f-o-3">
            <a href="{{ URL::route ('singleGroupCreatePage-show') }}" class="btn btn-create-block btn-block arc-md lk-darker"
               title="Create a group">
                <span class="icon icon-plus"></span>
            </a>
        </div>
        <div class="c-f-o-3">
            <a href="{{ URL::route ('showAllGroups') }}" class="btn btn-create-block btn-block arc-md lk-darker"
               title="Find a group">
                <span class="icon icon-search"></span>
            </a>
        </div>
    @endif
</div>

@include('templates.pagination.limitLink', ['paginator' => $acceptedGroups])
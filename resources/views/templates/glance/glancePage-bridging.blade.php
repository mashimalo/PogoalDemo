<div class="site-container">
    <div class="wrap">

        @foreach($myBridgeGroups as $bridgeGroup)

            <div class="c-f-4 mB--md">
                <div class="shadow shadow--hover overflow-h arc-sm">

                    {{------------------------------
                    | Top
                    ------------------------------}}
                    <div class="bg-white inline-block w--full p-relative arrow--down arrow--down--white arrow--down--center">
                        <a href="{{ url_link_to_dockingGroup( $bridgeGroup->id ) }}" class="pull-left">
                            @if (bridging_avatar($bridgeGroup->id, "group_1_id") != null || strlen(bridging_avatar($bridgeGroup->id, "group_1_id")) > 0)
                                <img src="{!! '/images/groupAvatar/'.bridging_avatar($bridgeGroup->id, "group_1_id") !!}"
                                     class="avatar avatar--lg pull-left">
                            @else
                                <img src="{{ url('/assets/images/avatar.jpg') }}" class="avatar avatar--lg pull-left"/>
                            @endif

                            @if (bridging_avatar($bridgeGroup->id, "group_2_id") != null || strlen(bridging_avatar($bridgeGroup->id, "group_2_id")) > 0)
                                <img src="{!! '/images/groupAvatar/'.bridging_avatar($bridgeGroup->id, "group_2_id") !!}"
                                     class="avatar avatar--lg pull-left">
                            @else
                                <img src="{{ url('/assets/images/avatar.jpg') }}" class="avatar avatar--lg pull-left"/>
                            @endif
                        </a>
                        <div class="pH--md pV--sm overflow-h">
                            <a href="{{ url_link_to_dockingGroup( $bridgeGroup->id ) }}" class="bold lk-darker text-overflow">
                                {{ \App\Models\DockingGroup::where('id', $bridgeGroup->id)->firstOrFail()->docking_group_name }}
                            </a>
                            <div class="small text-light">
                                {{ bridging_group_name($bridgeGroup->id, "group_1_id") }}
                            </div>
                            <div class="small text-light">
                                {{ bridging_group_name($bridgeGroup->id, "group_2_id") }}
                            </div>
                        </div>
                    </div>

                    {{------------------------------
                    | Bottom
                    ------------------------------}}
                    <div class="bg--gray--lighter pA--md">
                        <div class="mB bold">
                            <span class="icon icon-rocket mR"></span>
                            Latest Feed
                        </div>
                        <div class="h--article--single">
                            @if(\App\Models\Feed::where('docking_group_id', $bridgeGroup->id)->count() == 0)
                                <span class="text-light overflow-h">No feed now.</span>
                                <a href="{{ url_link_to_dockingGroup( $bridgeGroup->id ) }}" class="btn btn-xs btn-primary mL--md pull-right">
                                    Post one now
                                </a>
                            @endif

                            @if(\App\Models\Feed::where('docking_group_id', $bridgeGroup->id)->count() >= 1)
                                @foreach(\App\Models\Feed::where('docking_group_id', $bridgeGroup->id)->orderBy('created_at', 'desc')->get()->take(1) as $feed)
                                    <a href="{{ url_link_to_dockingGroup( $bridgeGroup->id ) }}" class="text-light text-overflow">
                                        {{ str_limit(strip_tags($feed->content),50) }}
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        @endforeach

    </div>

    {{--{!! $myBridgeGroups -> render() !!}--}}
    @include('templates.pagination.limitLink', ['paginator' => $myBridgeGroups])
</div>
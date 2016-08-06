<div class="site-container">
    <div class="wrap">
        <ul id="leaderboard-result-topBridingGroups" class="leaderboard__result__list">
            @foreach($myBridgeGroups as $bridgeGroup)
                <li class="pH--md lk-block">
                    <div class="pV--sm bordered--b bordered--b--light">
                        <a href="{{ url_link_to_dockingGroup( $bridgeGroup->id ) }}" class="pull-left mR--md avatar--overlap">

                            @if (leaderboard_topBridging_avatar($bridgeGroup->id, "group_1_id") != null || strlen(leaderboard_topBridging_avatar($bridgeGroup->id, "group_1_id")) > 0)
                                <img src="{!! '/images/groupAvatar/'.leaderboard_topBridging_avatar($bridgeGroup->id, "group_1_id") !!}"
                                     class="avatar avatar--md rounded shadow">
                            @else
                                <img src="{{ url('/assets/images/avatar.jpg') }}" class="avatar avatar--md rounded shadow"/>
                            @endif

                            @if (leaderboard_topBridging_avatar($bridgeGroup->id, "group_2_id") != null || strlen(leaderboard_topBridging_avatar($bridgeGroup->id, "group_2_id")) > 0)
                                <img src="{!! '/images/groupAvatar/'.leaderboard_topBridging_avatar($bridgeGroup->id, "group_2_id") !!}"
                                     class="avatar avatar--md rounded shadow">
                            @else
                                <img src="{{ url('/assets/images/avatar.jpg') }}" class="avatar avatar--md rounded shadow"/>
                            @endif

                        </a>
                        <a href="{{ url_link_to_dockingGroup($bridgeGroup->id ) }}"
                           class="pull-right mL--md btn btn-sns btn-mT-mainAlt">
                            View
                        </a>

                        <div class="overflow-h">
                            <a href="{{ url_link_to_dockingGroup($bridgeGroup->id ) }}" class="lk-darker bold text-overflow">
                                {{ \App\Models\DockingGroup::where('id', $bridgeGroup->id)->firstOrFail()->docking_group_name }}
                            </a>

                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    {{--{!! $myBridgeGroups -> render() !!}--}}
    @include('templates.pagination.limitLink', ['paginator' => $myBridgeGroups])
</div>
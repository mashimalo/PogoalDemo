<div class="wrap">
    @foreach(App\Models\DockingGroup::all()->take(15) as $dockingGroup)
        <div class="uiTile c-f-o-3 mB--md">
            <div class="uiTile__body arc-md">
                <div class="uiTile__cover">
                    <a href="{{ url_link_to_dockingGroup( $dockingGroup->id ) }}">
                        <div class="c-f-6 pA--none">
                            <img class="uiTile__avatar uiTile__avatar__left avatar avatar--fluid mA--none" src="{{ url('/assets/images/avatar.jpg') }}">
                        </div>
                        <div class="c-f-6 pA--none">
                            <img class="uiTile__avatar uiTile__avatar__right avatar avatar--fluid mA--none" src="{{ url('/assets/images/avatar.jpg') }}">
                        </div>
                    </a>
                    <span class="icon text-error"></span>
                </div>
                <div class="uiTile__content bg-white">
                    <div class="uiTile__title bold mB">
                        <a href="{{ url_link_to_dockingGroup( $dockingGroup->id ) }}" class="lk-darker">
                            {{ $dockingGroup->docking_group_name }}
                        </a>
                    </div>
                    <div class="text-light small text-overflow">
                        <span class="icon icon-double-arrow-right mR"></span>
                        {{ get_group_name_by_id( $dockingGroup->group_1_id ) }}
                    </div>
                    <div class="text-light small text-overflow">
                        <span class="icon icon-double-arrow-right mR"></span>
                        {{ get_group_name_by_id( $dockingGroup->group_2_id ) }}
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
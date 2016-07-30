{{----------------------------
| One Pinned Feed
----------------------------}}
<div id="feeds-pinned" class="uiFeeds">
    @foreach($pinned_feeds->take(1) as $feed)
        @include('templates.docking.feed.dockingGroupPage-feed')
    @endforeach
</div>

{{----------------------------
| Unpinned Feeds
----------------------------}}
<div id="feeds-unpinned" class="uiFeeds">
    @foreach($unpinned_feeds as $feed)
        @include('templates.docking.feed.dockingGroupPage-feed')
    @endforeach
</div>

@if ($validate_currentUser_in_dockingGroup)
    @if( $unpinned_feeds->count() < 1 && $pinned_feeds->count() < 1)
        <div id="pageEmptyMsg">
            <div class="uiCard mB--xlg">
                <div class="uiCard__body">
                    <div class="uiCard__content">
                        <div class="text-center pA--lg text-lighter">
                            <span class="icon icon-info-line text-xxxlg"></span>
                            <p class="text-lg">
                                This page is empty, post something now.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif

@if (!$validate_currentUser_in_dockingGroup)
    @if( $unpinned_feeds->count() < 1 && $pinned_feeds->count() < 1)
        <div class="uiCard mB--xlg">
            <div class="uiCard__body">
                <div class="uiCard__content">
                    <div class="text-center pA--lg text-lighter">
                        <span class="icon icon-info-line text-xxxlg"></span>
                        <p class="text-lg">
                            This page is currently empty.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif

@include('templates.pagination.limitLink', ['paginator' => $unpinned_feeds])
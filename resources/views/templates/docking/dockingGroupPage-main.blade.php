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

@include('templates.pagination.limitLink', ['paginator' => $unpinned_feeds])
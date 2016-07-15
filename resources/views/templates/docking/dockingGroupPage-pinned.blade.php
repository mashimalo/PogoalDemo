{{----------------------------
| Pinnded Feeds
----------------------------}}
<div id="feeds-pinned" class="uiFeeds">
    @foreach($pinned_feeds as $feed)
        @include('templates.docking.feed.dockingGroupPage-feed')
    @endforeach
</div><!-- .uiFeeds -->

@include('templates.pagination.limitLink', ['paginator' => $pinned_feeds])
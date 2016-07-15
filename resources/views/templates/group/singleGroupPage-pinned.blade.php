{{----------------------------
| Pinnded Feeds
----------------------------}}
<div id="feeds-pinned" class="uiFeeds">
    @foreach($pinned_feeds as $feed)
        @include('templates.group.feed.singleGroupPage-feed')
    @endforeach
</div><!-- .uiFeeds -->

@include('templates.pagination.limitLink', ['paginator' => $pinned_feeds])
<div class="uiFeed shadow--hover">

    {{----------------------------
    | Pinned Mark
    ----------------------------}}
    @if($feed->pinned == true)
        <div class="pinned-badge">
            <div class="pinned-badge__inner" data-show="tooltip" data-trigger="hover" data-placement="bottom" title="Pinned!">
                <span class="icon icon-thunder"></span>
            </div>
        </div>
    @endif

    @if($feed->pinned == false)
        @if($feed->likes->count() >= 5)
            <div class="pinned-badge">
                <div class="pinned-badge__inner" data-show="tooltip" data-trigger="hover" data-placement="bottom" title="We Love it!">
                    <span class="icon icon-thumb-up"></span>
                </div>
            </div>
        @endif
    @endif


    <div class="uiFeed__main">

        {{----------------------------
        | Feed Details
        ----------------------------}}
        <div class="uiFeed__main__top">
            {{----------------------------
            | Feed Avatar
            ----------------------------}}
            <a href="{{ url_link_to_target_profile($feed->user->profile->nickname) }}" class="uiFeed__avatar">
                @if ($feed->user->profile->user_avatar_small != null || strlen($feed->user->profile->user_avatar_small) > 0)
                    <img src="{!! '/images/userAvatar/'.$feed->user->profile->user_avatar_small !!}" class="avatar avatar--md arc-sm">
                @else
                    <img data-name="{{ empty_firstName_displayNickname($feed->user) }}" class="initialAvatar avatar avatar--md arc-sm"/>
                @endif
            </a>

            <div class="uiFeed__details">
                <div class="uiFeed__details__author">
                    <a href="{{ url_link_to_target_profile($feed->user->profile->nickname) }}">
                        {{ empty_eitherName_displayNickname($feed->user) }}
                    </a>
                </div>

                <div class="uiFeed__details__misc">
                    <span>From {{ getGroupNameFromDockingGroupIdAndUserId($dockingGroup_id, $feed->user->id) }}</span>
                    <span class="mL mR">/</span>
                    <span class="uiFeed__details__misc__time">{{ $feed->created_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>

        {{----------------------------
        | Feed Article
        ----------------------------}}
        <a href="{{ url_link_to_dockingGroupSingleFeedPage($dockingGroup->id, $feed->id) }}" class="uiFeed__article">
            <div class="uiFeed__article__text excerpt break-word">{{ strip_tags($feed->content) }}</div>
            {{--<div class="uiFeed__article__img preview">--}}
            {{--<img src="{{ url('/assets/images/home-cat-more.jpg') }}">--}}
            {{--</div>--}}
        </a>

        {{----------------------------
        | Feed Misc.
        ----------------------------}}
        <div class="uiFeed__misc">
            <div class="pull-left forms--inline">
                <button class="btn btn-sns like-submit"
                        data-action="feed-like"
                        data-action-for="docking"
                        data-group-id="{{ $dockingGroup->id }}"
                        data-feed-id="{{ $feed->id }}">
                    <span class="icon icon-thumb-up"></span>
                    <span class="btn-sns__count">{{ $feed->likes->count() }}</span>
                </button>
                <button class="btn btn-sns unlike-submit"
                        data-action="feed-unlike"
                        data-action-for="docking"
                        data-group-id="{{ $dockingGroup->id }}"
                        data-feed-id="{{ $feed->id }}">
                    <span class="icon icon-thumb-down"></span>
                    <span class="btn-sns__count">{{ $feed->unlikes->count() }}</span>
                </button>

                <button class="btn btn-sns">
                    <span class="icon icon-share"></span>
                </button>
            </div>

            <div class="pull-right uiDropdown">
                <button class="btn btn-sns" data-toggle="dropdown">
                    <span class="icon icon-dots text-light link-fake"></span>
                </button>

                <ul class="uiDropdown__menu">
                    @if ($validate_currentUser_has_permission_in_dockingGroup )
                        @if ($feed->pinned == false)
                            <li>
                                {!! Form::model($feed, ['route'=> ['feed-pin-dockingGroup', 'group_id' => $dockingGroup->id, 'feed_id' => $feed->id], 'method'=>'post','id'=>'pin-feed', 'role'=>'form'])!!}
                                {!! Form::submit('Pin',['id'=>'feed-pin-submit']) !!}
                                {!! Form::close() !!}
                            </li>
                        @endif
                        @if ($feed->pinned == true)
                            <li>
                                {!! Form::model($feed, ['route'=> ['feed-unpin-dockingGroup', 'group_id' => $dockingGroup->id, 'feed_id' => $feed->id], 'method'=>'post','id'=>'unpin-feed', 'role'=>'form'])!!}
                                {!! Form::submit('Unpin',['id'=>'feed-unpin-submit']) !!}
                                {!! Form::close() !!}
                            </li>
                        @endif
                        <li class="divider"></li>
                    @endif

                    @if ($feed->user->id == Auth::user()->id && $validate_currentUser_in_dockingGroup || $validate_currentUser_has_permission_in_dockingGroup )
                        <li>
                            <button data-action="edit-feed"
                                    data-action-for="docking"
                                    data-group-id="{{ $dockingGroup->id }}"
                                    data-feed-id="{{ $feed->id }}">
                                Edit
                            </button>
                        </li>
                        <li>
                            <button data-action="delete-feed"
                                    data-action-for="docking"
                                    data-group-id="{{ $dockingGroup->id }}"
                                    data-feed-id="{{ $feed->id }}">
                                Delete
                            </button>
                        </li>
                    @endif

                    @if ($feed->user->id != Auth::user()->id && !$validate_currentUser_has_permission_in_dockingGroup)
                        <li>
                            This is not your feed.
                        </li>
                    @endif
                </ul>
            </div>

        </div><!-- .uiFeed__misc -->
    </div><!-- .uiFeed__main -->

    {{----------------------------
    | Feed Footer
    ----------------------------}}
    <a href="{{ url_link_to_dockingGroupSingleFeedPage ($dockingGroup->id, $feed->id) }}" class="uiFeed__footer">
        <div class="wrap">
            <div class="c-f-9 small">
                @if($feed->comments->count() > 0)
                    @foreach ($feed->comments->sortBy('created_at')->reverse()->take(1)  as $comment)
                        @if ($comment->user->profile->user_avatar_small != null || strlen($comment->user->profile->user_avatar_small) > 0)
                            <img src="{!! '/images/userAvatar/'.$comment->user->profile->user_avatar_small !!}" class="avatar avatar--xs arc-sm">
                        @else
                            <img data-name="{{ empty_firstName_displayNickname($comment->user) }}" class="initialAvatar avatar avatar--xs arc-sm"/>
                        @endif
                        <span class="bold">{{ empty_eitherName_displayNickname($comment->user) }}</span>
                        <span class="mL mR text-light">-</span>
                        <span class="text-light">{{ str_limit($comment->content,75) }}</span>
                    @endforeach
                @else
                    <span class="text-light text-uppercase">No activity</span>
                @endif
            </div>

            <div class="c-f-3 text-right small text-light">
                @if($feed->comments->count() > 0)
                    @foreach ($feed->comments->sortBy('created_at')->reverse()->take(1)  as $comment)
                        {{ $comment->created_at->diffForHumans() }}
                    @endforeach
                    <span class="mL mR">/</span>
                @endif
                {{ getAllReplyCount($feed) }}
                <span class="icon icon-comments"></span>
            </div>
        </div>
    </a><!-- .uiFeed__footer -->

</div>
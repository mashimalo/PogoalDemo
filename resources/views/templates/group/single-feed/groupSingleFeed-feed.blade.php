<div class="uiFeed">

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
                    <span class="uiFeed__details__misc__time">{{ $feed->created_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>

        {{----------------------------
        | Feed Article
        ----------------------------}}
        <div class="uiFeed__article">
            <div class="uiFeed__article__text break-word">{!! nl2br($feed->content) !!}</div>
            {{--<div class="uiFeed__article__img">--}}
            {{--<img src="{{ url('/assets/images/home-cat-more.jpg') }}">--}}
            {{--</div>--}}
        </div>

        {{----------------------------
        | Feed Misc.
        ----------------------------}}
        <div class="uiFeed__misc">
            <div class="pull-left forms--inline">
                <button class="btn btn-sns like-submit"
                        data-action="feed-like"
                        data-action-for="group"
                        data-group-id="{{ $group->id }}"
                        data-feed-id="{{ $feed->id }}">
                    <span class="icon icon-thumb-up"></span>
                    <span class="btn-sns__count">{{ $feed->likes->count() }}</span>
                </button>
                <button class="btn btn-sns unlike-submit"
                        data-action="feed-unlike"
                        data-action-for="group"
                        data-group-id="{{ $group->id }}"
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
                    @if ($validate_currentUser_has_permission )
                        @if ($feed->pinned == false)
                            <li>
                                {!! Form::model($feed, ['route'=> ['feed-pin', 'group_id' => $group->id, 'feed_id' => $feed->id], 'method'=>'post','id'=>'pin-feed', 'role'=>'form'])!!}
                                {!! Form::submit('Pin',['id'=>'feed-pin-submit']) !!}
                                {!! Form::close() !!}
                            </li>
                        @endif
                        @if ($feed->pinned == true)
                            <li>
                                {!! Form::model($feed, ['route'=> ['feed-unpin', 'group_id' => $group->id, 'feed_id' => $feed->id], 'method'=>'post','id'=>'unpin-feed', 'role'=>'form'])!!}
                                {!! Form::submit('Unpin',['id'=>'feed-unpin-submit']) !!}
                                {!! Form::close() !!}
                            </li>
                        @endif
                        <li class="divider"></li>
                    @endif

                    @if ($feed->user->id == Auth::user()->id && $validate_currentUser_in_group || $validate_currentUser_has_permission )
                        <li>
                            <button data-action="edit-feed"
                                    data-action-for="group"
                                    data-feed-type="groupSingleFeed"
                                    data-group-id="{{ $group->id }}"
                                    data-feed-id="{{ $feed->id }}">
                                Edit
                            </button>
                        </li>
                        <li>
                            <button data-action="delete-feed"
                                    data-action-for="group"
                                    data-group-id="{{ $group->id }}"
                                    data-feed-id="{{ $feed->id }}">
                                Delete
                            </button>
                        </li>
                    @endif

                    @if ($feed->user->id != Auth::user()->id && !$validate_currentUser_has_permission)
                        <li class="pH--md">
                            This is not your feed.
                        </li>
                    @endif
                </ul>
            </div>

        </div><!-- .uiFeed__misc -->
    </div><!-- .uiFeed__main -->

    {{----------------------------
    | Reply Form for First Level
    ----------------------------}}
    @if ($validate_currentUser_in_group)
        <div id="uiFeed-reply-form" class="uiFeed__reply__form">
            <div class="mR--md pull-left">
                @if (Auth::user()->profile->user_avatar_small != null || strlen(Auth::user()->profile->user_avatar_small) > 0)
                    <img src="{!! '/images/userAvatar/'.Auth::user()->profile->user_avatar_small !!}"
                         class="avatar avatar--md arc-sm">
                @else
                    <img data-name="{{ empty_firstName_displayNickname(Auth::user()) }}"
                         class="initialAvatar avatar avatar--md arc-sm"/>
                @endif
            </div>
            <button class="btn btn-primary btn-md mL--md pull-right"
                    data-action="post-feed-reply"
                    data-action-for="group"
                    data-group-id="{{ $group->id }}"
                    data-feed-id="{{ $feed->id }}">
                Reply
            </button>
            <div class="uiFeed__reply__form__input overflow-h">
                <div class="elastic-textarea elastic-textarea--hasBtn">
                    <textarea placeholder="Reply......" name="reply-{{ $feed->id }}" class="form-control elastic-textarea__input"
                              data-elastic="textarea"></textarea>
                    {{--<div class="elastic-textarea__btn">--}}
                        {{--<button class="btn btn-md icon icon-camera text-light"></button>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
    @endif

    <h3 class="mB--md">
        <span class="icon icon-comments mR"></span>
        <span id="group-single-feed-comment-count">{{ singularOrPlural(getAllReplyCount($feed), "comment", "comments", "0 comment") }}</span>
    </h3>

    {{----------------------------
    | Reply List
    ----------------------------}}
    @include('templates.group.single-feed.groupSingleFeed-feed-reply')
</div>

@include('templates.pagination.limitLink', ['paginator' => $comments])
<ul id="uiFeed-reply-list" class="uiFeed__reply">
    {{----------------------------
    | First Level Reply
    ----------------------------}}
    @foreach ($comments as $comment)
        <li class="uiFeed__reply__item">
            <div class="uiFeed__reply__main">
                <div class="uiFeed__reply__top">
                    <a href="{{ url_link_to_target_profile($comment->user->profile->nickname) }}"
                       class="uiFeed__avatar">
                        @if ($comment->user->profile->user_avatar_small != null || strlen($comment->user->profile->user_avatar_small) > 0)
                            <img src="{!! '/images/userAvatar/'.$comment->user->profile->user_avatar_small !!}" class="avatar avatar--md arc-sm">
                        @else
                            <img data-name="{{ empty_firstName_displayNickname($comment->user) }}" class="initialAvatar avatar avatar--md arc-sm"/>
                        @endif
                    </a>

                    {{----------------------------
                    | First Level Reply Details
                    ----------------------------}}
                    <div class="uiFeed__details">
                        <div class="uiFeed__details__author">
                            <a href="{{ url_link_to_target_profile($comment->user->profile->nickname) }}" class="small break-word">
                                {{ empty_eitherName_displayNickname($comment->user) }}
                            </a>
                        </div>
                        <div class="uiFeed__details__misc">
                            <span class="uiFeed__details__misc__time">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                {{----------------------------
                | First Level Reply Article
                ----------------------------}}
                <div class="uiFeed__article">
                    <div class="uiFeed__article__text break-word">{!! nl2br($comment->content) !!}</div>
                </div>

                {{----------------------------
                | First Level Reply Misc.
                ----------------------------}}
                <div class="uiFeed__misc">
                    <div class="pull-left forms--inline">
                        <button class="btn btn-sns like-submit"
                                data-action="feed-reply-like"
                                data-action-for="docking"
                                data-group-id="{{ $dockingGroup->id }}"
                                data-reply-id="{{ $comment->id }}">
                            <span class="icon icon-thumb-up"></span>
                            <span class="btn-sns__count">{{ $comment->likes->count() }}</span>
                        </button>
                        <button class="btn btn-sns unlike-submit"
                                data-action="feed-reply-unlike"
                                data-action-for="docking"
                                data-group-id="{{ $dockingGroup->id }}"
                                data-reply-id="{{ $comment->id }}">
                            <span class="icon icon-thumb-down"></span>
                            <span class="btn-sns__count">{{ $comment->unlikes->count() }}</span>
                        </button>

                        @if ( $validate_currentUser_in_dockingGroup )
                            <button class="btn btn-link btn-xs"
                                    data-action="insert-feed-reply-form"
                                    data-action-for="docking"
                                    data-group-id="{{ $dockingGroup->id }}"
                                    data-feed-id="{{ $feed->id }}"
                                    data-reply-id="{{ $comment->id }}">
                                <span class="icon icon-reply"></span>
                                Reply
                            </button>
                        @endif
                    </div>

                    <div class="pull-right uiDropdown">
                        <button class="btn btn-sns" data-toggle="dropdown">
                            <span class="icon icon-dots text-light"></span>
                        </button>
                        <ul class="uiDropdown__menu">
                            @if ($comment->user->id == Auth::user()->id && $validate_currentUser_in_dockingGroup || $validate_currentUser_has_permission_in_dockingGroup )
                                <li>
                                    <button data-action="edit-feed-reply"
                                            data-action-for="docking"
                                            data-group-id="{{ $dockingGroup->id }}"
                                            data-feed-id="{{ $feed->id }}"
                                            data-reply-id="{{ $comment->id }}">
                                        Edit
                                    </button>
                                </li>
                                <li>
                                    <button data-action="delete-feed-reply"
                                            data-action-for="docking"
                                            data-group-id="{{ $dockingGroup->id }}"
                                            data-feed-id="{{ $feed->id }}"
                                            data-reply-id="{{ $comment->id }}">
                                        Delete
                                    </button>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div><!-- .uiFeed__misc -->
            </div>

            {{----------------------------
            | Second Level Reply List
            ----------------------------}}
            @include('templates.docking.single-feed.dockingGroupSingleFeed-feed-childReply')

        </li>
    @endforeach
</ul><!-- .uiFeed__reply -->
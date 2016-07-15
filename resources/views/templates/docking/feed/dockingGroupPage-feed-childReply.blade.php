<ul class="uiFeed__reply__secondLevel">
    {{----------------------------
    | Second Level Reply
    ----------------------------}}
    @foreach ($comment->childComments->sortBy('created_at')->reverse()  as $comment_2nd)
        <li class="uiFeed__reply__item">
            <a href="{{ url_link_to_target_profile($comment_2nd->user->profile->nickname) }}" class="uiFeed__avatar">
                <img data-name="{{ empty_firstName_displayNickname($comment_2nd->user) }}" class="initialAvatar avatar avatar--md arc-sm"/>
            </a>

            {{----------------------------
            | Second Level Reply Details
            ----------------------------}}
            <div class="uiFeed__details">
                <div class="uiFeed__details__author">
                    <a href="{{ url_link_to_target_profile($comment_2nd->user->profile->nickname) }}"
                       class="small break-word">
                        {{ empty_eitherName_displayNickname($comment_2nd->user) }}
                    </a>
                </div>
                <div class="uiFeed__details__misc">
                    <span class="uiFeed__details__misc__time">{{ $comment_2nd->created_at->diffForHumans() }}</span>
                </div>
            </div>

            {{----------------------------
            | Second Level Reply Article
            ----------------------------}}
            <div class="uiFeed__article">
                {{--<a href="#" class="uiFeed__article__img">--}}
                {{--<img src="{{ url('/assets/images/home-cat-more.jpg') }}">--}}
                {{--</a>--}}
                <div class="uiFeed__article__text break-word">{!! nl2br($comment_2nd->content) !!}</div>
            </div>

            {{----------------------------
            | Second Level Reply Misc.
            ----------------------------}}
            <div class="uiFeed__misc">
                <div class="pull-left forms--inline">
                    <button class="btn btn-sns like-submit"
                            data-action="feed-reply-like"
                            data-action-for="docking"
                            data-group-id="{{ $dockingGroup->id }}"
                            data-reply-id="{{ $comment_2nd->id }}">
                        <span class="icon icon-thumb-up"></span>
                        <span class="btn-sns__count">{{ $comment_2nd->likes->count() }}</span>
                    </button>
                    <button class="btn btn-sns unlike-submit"
                            data-action="feed-reply-unlike"
                            data-action-for="docking"
                            data-group-id="{{ $dockingGroup->id }}"
                            data-reply-id="{{ $comment_2nd->id }}">
                        <span class="icon icon-thumb-down"></span>
                        <span class="btn-sns__count">{{ $comment_2nd->unlikes->count() }}</span>
                    </button>

                    {{--{!! Form::model($comment_2nd, ['route'=> ['comment-like', 'dockingGroup_id' => $dockingGroup->id, 'comment_id' => $comment_2nd->id], 'method'=>'POST','id'=>'like-comment', 'role'=>'form'])!!}--}}
                    {{--<button class="btn btn-sns">--}}
                    {{--<span class="icon icon-thumb-up mR"></span>--}}
                    {{--<span class="btn-sns__count">{{ $comment_2nd->likes->count() }}</span>--}}
                    {{--</button>--}}
                    {{--{!! Form::close() !!}--}}

                    {{--{!! Form::model($comment_2nd, ['route'=> ['comment-unlike', 'dockingGroup_id' => $dockingGroup->id, 'comment_id' => $comment_2nd->id], 'method'=>'POST','id'=>'unlike-comment', 'role'=>'form'])!!}--}}
                    {{--<button class="btn btn-sns">--}}
                    {{--<span class="icon icon-thumb-down mR"></span>--}}
                    {{--<span class="btn-sns__count">{{ $comment_2nd->unlikes->count() }}</span>--}}
                    {{--</button>--}}
                    {{--{!! Form::close() !!}--}}
                </div>

                <div class="pull-right uiDropdown">
                    <button class="btn btn-sns" data-toggle="dropdown">
                        <span class="icon icon-gear text-light link-fake"></span>
                    </button>
                    <ul class="uiDropdown__menu arrow--none">
                        @if ($comment_2nd->user->id == Auth::user()->id && $validate_currentUser_in_dockingGroup || $validate_currentUser_has_permission_in_dockingGroup )
                            <li>
                                <button data-action="edit-feed-childReply"
                                        data-action-for="docking"
                                        data-group-id="{{ $dockingGroup->id }}"
                                        data-feed-id="{{ $feed->id }}"
                                        data-reply-id="{{ $comment->id }}"
                                        data-childReply-id="{{ $comment_2nd->id }}">
                                    Edit
                                </button>
                            </li>
                            <li>
                                <button data-action="delete-feed-childReply"
                                        data-action-for="docking"
                                        data-group-id="{{ $dockingGroup->id }}"
                                        data-feed-id="{{ $feed->id }}"
                                        data-reply-id="{{ $comment->id }}"
                                        data-childReply-id="{{ $comment_2nd->id }}">
                                    Delete
                                </button>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </li>
    @endforeach
</ul>
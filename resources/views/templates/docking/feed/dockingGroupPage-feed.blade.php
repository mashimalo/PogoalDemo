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
        | Feed Avatar
        ----------------------------}}
        <a href="{{ url_link_to_target_profile($feed->user->profile->nickname) }}" class="uiFeed__avatar">
            <img data-name="{{ empty_firstName_displayNickname($feed->user) }}"
                 class="initialAvatar avatar avatar--md arc-sm"/>
        </a>

        {{----------------------------
        | Feed Details
        ----------------------------}}
        <div class="uiFeed__details">
            <div class="uiFeed__details__author">
                <a href="{{ url_link_to_target_profile($feed->user->profile->nickname) }}" class="break-word">
                    {{ empty_eitherName_displayNickname($feed->user) }}
                </a>
            </div>
            <div class="uiFeed__details__misc">
                <span class="uiFeed__details__misc__time">{{ $feed->created_at->diffForHumans() }}</span>
            </div>
        </div>

        {{----------------------------
        | Feed Article
        ----------------------------}}
        <div class="uiFeed__article">
            {{--<a href="#" class="uiFeed__article__img">--}}
            {{--<img src="{{ url('/assets/images/home-cat-more.jpg') }}">--}}
            {{--</a>--}}
            <div class="uiFeed__article__text break-word">{!! nl2br($feed->content) !!}</div>
        </div>

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

                {{--{!! Form::model($dockingGroup, ['route'=> ['feed-like-dockingGroup', 'dockingGroup_id' => $dockingGroup->id, 'feed_id' => $feed->id], 'method'=>'POST','id'=>'like-feed-dockingGroup', 'role'=>'form'])!!}--}}
                {{--<button class="btn btn-sns" id="post-like-submit">--}}
                {{--<span class="icon icon-thumb-up"></span>--}}
                {{--<span class="btn-sns__count">{{ $feed->likes->count() }}</span>--}}
                {{--</button>--}}
                {{--{!! Form::close() !!}--}}

                {{--{!! Form::model($dockingGroup, ['route'=> ['feed-unlike-dockingGroup', 'dockingGroup_id' => $dockingGroup->id, 'feed_id' => $feed->id], 'method'=>'POST','id'=>'unlike-feed', 'role'=>'form'])!!}--}}
                {{--<button class="btn btn-sns" id="post-unlike-submit">--}}
                {{--<span class="icon icon-thumb-down"></span>--}}
                {{--<span class="btn-sns__count">{{ $feed->unlikes->count() }}</span>--}}
                {{--</button>--}}
                {{--{!! Form::close() !!}--}}
                <button class="btn btn-sns">
                    <span class="icon icon-share"></span>
                </button>
            </div>

            <div class="pull-right uiDropdown">
                <button class="btn btn-sns" data-toggle="dropdown">
                    <span class="icon icon-gear text-light link-fake"></span>
                </button>

                <ul class="uiDropdown__menu arrow--none">
                    @if ($validate_currentUser_has_permission_in_dockingGroup )
                        @if ($feed->pinned == false)
                            <li>
                                {!! Form::model($feed, ['route'=> ['feed-pin-dockingGroup', 'dockingGroup_id' => $dockingGroup->id, 'feed_id' => $feed->id], 'method'=>'post','id'=>'pin-feed', 'role'=>'form'])!!}
                                {!! Form::submit('Pin',['id'=>'feed-pin-submit']) !!}
                                {!! Form::close() !!}
                            </li>
                        @endif
                        @if ($feed->pinned == true)
                            <li>
                                {!! Form::model($feed, ['route'=> ['feed-unpin-dockingGroup', 'dockingGroup_id' => $dockingGroup->id, 'feed_id' => $feed->id], 'method'=>'post','id'=>'unpin-feed', 'role'=>'form'])!!}
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
                </ul>
            </div>

        </div>
    </div>

    {{----------------------------
    | Feed Footer
    ----------------------------}}
    <div class="uiFeed__footer inactive">
        <div class="uiFeed__footer__mask">

            <button class="close" style="display:@if(getAllReplyCount($feed)>0) block @else none @endif;">
                <span>&times;</span>
            </button>

            {{----------------------------
            | Reply List
            ----------------------------}}
            @include('templates.docking.feed.dockingGroupPage-feed-reply')

            {{----------------------------
            | Reply Form for First Level
            ----------------------------}}
            @if ($validate_currentUser_in_dockingGroup)
                <div class="uiFeed__reply__form">
                    <img data-name="{{ empty_firstName_displayNickname(Auth::user()) }}" class="initialAvatar avatar avatar--md arc-sm mR--md pull-left"/>
                    <button class="btn btn-primary btn-md mL--md pull-right"
                            data-action="post-feed-reply"
                            data-action-for="docking"
                            data-group-id="{{ $dockingGroup->id }}"
                            data-feed-id="{{ $feed->id }}">
                        Reply
                    </button>
                    <div class="uiFeed__reply__form__input">
                        <div class="elastic-textarea elastic-textarea--hasBtn">
                                <textarea placeholder="Reply......" name="reply-{{ $feed->id }}"
                                          class="form-control elastic-textarea__input"
                                          data-elastic="textarea"></textarea>

                            <div class="elastic-textarea__btn">
                                <button class="btn btn-md icon icon-camera text-light"></button>
                            </div>
                        </div>
                    </div>
                </div>

                {{--<div class="uiFeed__reply__form">--}}
                {{--{!! Form::model($feed, ['route'=> ['comment-post-dockingGroup', $dockingGroup->id, $feed->id,], 'method'=>'POST','id'=>'post-comment', 'data-toggle'=>'validator', 'role'=>'form'])!!}--}}
                {{--<img data-name="{{ getUserFirstName() }}" class="initialAvatar avatar avatar--md arc-sm mR--md pull-left"/>--}}
                {{--{!! Form::submit('Reply',['class'=>'btn btn-primary btn-md mL--md pull-right']) !!}--}}
                {{--<div class="uiFeed__reply__form__input">--}}
                {{--<div class="elastic-textarea elastic-textarea--hasBtn">--}}
                {{--<textarea placeholder="Reply......" name="reply-{{ $feed->id }}" class="form-control elastic-textarea__input"--}}
                {{--data-elastic="textarea"></textarea>--}}
                {{--<div class="elastic-textarea__btn">--}}
                {{--<button class="btn btn-md icon icon-camera text-light"></button>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--{!! Form::close() !!}--}}
                {{--</div>--}}
            @endif
        </div>

        {{----------------------------
        | Feed Footer Toggle
        ----------------------------}}
        <div class="uiFeed__footer__toggle text-center">
            <span class="icon icon-comments mR"></span>
            <span class="btn-sns__count">{{ getAllReplyCount($feed) }}</span>
        </div>
    </div>

</div>
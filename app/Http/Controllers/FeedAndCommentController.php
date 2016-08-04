<?php

namespace App\Http\Controllers;


use \Illuminate\Support\Facades\Auth;

use App\Models\Comment;
use App\Models\Feed;
use App\Models\GroupUser;
use App\Models\Like;

use App\Http\Requests\PostFeedRequest;
use App\Http\Requests\EditFeedRequest;
use App\Http\Requests\EditCommentRequest;
use App\Http\Requests\PostCommentRequest;
use App\Http\Requests\PostChildCommentRequest;


use App\Repositories\FeedRepository;
use App\Repositories\CommentRepository;
use App\Repositories\LikeRepository;
use App\Repositories\UnlikeRepository;


class FeedAndCommentController extends Controller {
	public function __construct(
		FeedRepository $feed_repository,
		CommentRepository $comment_repository,
		LikeRepository $like_repository,
		UnlikeRepository $unlike_repository

	) {
		$this->feed_repository    = $feed_repository;
		$this->comment_repository = $comment_repository;
		$this->like_repository    = $like_repository;
		$this->unlike_repository  = $unlike_repository;
	}


	/**
	 * validate if current login user belongs to the target group
	 *
	 * @param $group_id
	 *
	 * @return mixed
	 */
	function validate_currentUser_in_group( $group_id ) {
		$current_user_id               = Auth::User()->id;
		$validate_currentUser_in_group = GroupUser::wheregroup_id( $group_id )->whereuser_id( $current_user_id )->whereaccepted( true )->first();

		return $validate_currentUser_in_group;
	}

	/**
	 * verify if current user own the feed
	 *
	 * @param $feed_id
	 *
	 * @return mixed
	 */
	function validate_currentUser_owns_feed( $feed_id ) {
		$current_user_id                = Auth::User()->id;
		$validate_currentUser_owns_feed = Feed::whereid( $feed_id )->whereuser_id( $current_user_id )->first();

		return $validate_currentUser_owns_feed;
	}

	/**
	 * verify if current user owns the comment
	 *
	 * @param $comment_id
	 *
	 * @return mixed
	 */
	function validate_currentUser_owns_comment( $comment_id ) {
		$current_user_id                   = Auth::User()->id;
		$validate_currentUser_owns_comment = Comment::whereid( $comment_id )->whereuser_id( $current_user_id )->first();

		return $validate_currentUser_owns_comment;
	}

	/**
	 * verify if the current user is coordinator of group
	 *
	 * @param $group_id
	 *
	 * @return mixed
	 */
	function validate_currentUser_has_permission( $group_id ) {
		$validate_currentUser_in_group = $this->validate_currentUser_in_group( $group_id );
		if ( ! $validate_currentUser_in_group ) {
			return false;
		}
		$current_user_id = Auth::User()->id;
		$userRoleId      = GroupUser::wheregroup_id( $group_id )
		                            ->whereuser_id( $current_user_id )
		                            ->whereaccepted( true )->first()
			->group_user_role_id;
		if ( $userRoleId < 3 ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * post feed
	 *
	 * @param $group_id
	 * @param PostFeedRequest $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
	public function postFeed( $group_id, PostFeedRequest $request ) {
		try {
			$validate_currentUser_in_group = $this->validate_currentUser_in_group( $group_id );

			if ( ! $validate_currentUser_in_group ) {
				return back()->with( 'error', trans( 'front/feed.postFail' ) );
			}

			$feed                      = $this->feed_repository->postFeed( $request->all(), $group_id );
			
			$feed->user_profile_link   = url_link_to_target_profile( $feed->user->profile->nickname );
			$feed->user_name           = empty_eitherName_displayNickname( $feed->user );
			$feed->post_time           = $feed->created_at->diffForHumans();
			$feed->feed_unpinned_count = getUnpinnedFeedsCount( $group_id );
			$feed->feed_pinned_count   = getPinnedFeedsCount( $group_id );
			$feed->user_avatar_small   = $feed->user->profile->user_avatar_small;
			$feed->user_avatar_large   = $feed->user->profile->user_avatar_large;

		} catch ( \Exception $e ) {
			return back()->with( 'error', trans( 'front/feed.postFeedFail' ) );
		}

//        return back()->with('ok', trans('front/feed.postSuccessful'));
		//		return response()->json($feed);
		return response( [ 'status' => 'success', 'json' => $feed ] );
	}

	/**
	 * delete feed
	 *
	 * @param $group_id
	 * @param $feed_id
	 *
	 * @return bool|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
	public function deleteFeed( $group_id, $feed_id ) {
		try {
			$validate_currentUser_has_permission = $this->validate_currentUser_has_permission( $group_id );
			$validate_currentUser_owns_feed      = $this->validate_currentUser_owns_feed( $feed_id );

			if ( ! ( $validate_currentUser_owns_feed || $validate_currentUser_has_permission ) ) {
				return back()->with( 'error', trans( 'front/feed.permissionDenied' ) );
			}
			$this->feed_repository->deleteFeed( $feed_id );

			$feed_unpinned_count = getUnpinnedFeedsCount( $group_id );
			$feed_pinned_count   = getPinnedFeedsCount( $group_id );

		} catch ( \Exception $e ) {
			return back()->with( 'error', trans( 'front/feed.deleteFeedFail' ) );
		}

		return response( [
			'status' => 'success',
			'json'   => [ 'feed_unpinned_count' => $feed_unpinned_count, 'feed_pinned_count' => $feed_pinned_count, ]
		] );
		// return back()->with('ok', trans('front/feed.feedDeleteSuccessful'));
		// return response()->json();
	}

	public function editFeed( $group_id, $feed_id, EditFeedRequest $request ) {
		try {
			$validate_currentUser_has_permission = $this->validate_currentUser_has_permission( $group_id );
			$validate_currentUser_owns_feed      = $this->validate_currentUser_owns_feed( $feed_id );

			if ( ! ( $validate_currentUser_owns_feed || $validate_currentUser_has_permission ) ) {
				return back()->with( 'error', trans( 'front/feed.permissionDenied' ) );
			}
			$feed = $this->feed_repository->editFeed( $request->all(), $feed_id );
			$feed->strip_tags_content = strip_tags($feed->content);

		} catch ( \Exception $e ) {
			return back()->with( 'error', trans( 'front/feed.deleteFeedFail' ) );
		}

//	    return response()->json($feed->content);
		// return back()->with('ok', trans('front/feed.feedDeleteSuccessful'));
		return response( [ 'status' => 'success', 'json' => $feed ] );

	}

	/**
	 * post comments
	 *
	 * @param $group_id
	 * @param $feed_id
	 * @param PostCommentRequest $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
	public function postComment( $group_id, $feed_id, PostCommentRequest $request ) {
		try {
			$validate_currentUser_in_group = $this->validate_currentUser_in_group( $group_id );

			if ( ! $validate_currentUser_in_group ) {
				return back()->with( 'error', trans( 'front/feed.postFail' ) );
			}

			$comment                    = $this->comment_repository->postComment( $request->all(), $feed_id );
			$comment->group_id          = $group_id;
			$comment->user_profile_link = url_link_to_target_profile( $comment->user->profile->nickname );
			$comment->user_name         = empty_eitherName_displayNickname( $comment->user );
			$comment->post_time         = $comment->created_at->diffForHumans();
			$comment->all_reply_count   = getAllReplyCount( Feed::whereid( $feed_id )->first() );
			$comment->user_avatar_small = $comment->user->profile->user_avatar_small;
			$comment->user_avatar_large = $comment->user->profile->user_avatar_large;

		} catch ( \Exception $e ) {
			return back()->with( 'error', trans( 'front/feed.postCommentFail' ) );
		}

//		return back()->with( 'ok', trans( 'front/feed.commentSuccessful' ) );
		// return response()->json(Feed::whereid($feed_id)->FirstOrFail()->comments->last());
		return response( [ 'status' => 'success', 'json' => $comment ] );
	}

	/**
	 * post 2nd(child) comments
	 *
	 * @param $group_id
	 * @param $comment_id
	 * @param PostChildCommentRequest $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
	public function postChildComment( $group_id, $feed_id, $comment_id, PostChildCommentRequest $request ) {
		try {
			$validate_currentUser_in_group = $this->validate_currentUser_in_group( $group_id );

			if ( ! $validate_currentUser_in_group ) {
				return back()->with( 'error', trans( 'front/feed.postFail' ) );
			}

			$comment                    = $this->comment_repository->postChildComment( $request->all(), $comment_id );
			$comment->group_id          = $group_id;
			$comment->feed_id           = $feed_id;
			$comment->user_profile_link = url_link_to_target_profile( $comment->user->profile->nickname );
			$comment->user_name         = empty_eitherName_displayNickname( $comment->user );
			$comment->post_time         = $comment->created_at->diffForHumans();
			$comment->all_reply_count   = getAllReplyCount( Feed::whereid( $feed_id )->first() );
			$comment->user_avatar_small = $comment->user->profile->user_avatar_small;
			$comment->user_avatar_large = $comment->user->profile->user_avatar_large;

		} catch ( \Exception $e ) {
			return back()->with( 'error', trans( 'front/feed.postCommentFail' ) );
		}

//		return back()->with( 'ok', trans( 'front/feed.commentSuccessful' ) );
		return response( [ 'status' => 'success', 'json' => $comment ] );
	}

	/**
	 * delete first lvl comment
	 *
	 * @param $group_id
	 * @param $feed_id
	 * @param $comment_id
	 *
	 * @return bool|\Illuminate\Http\RedirectResponse
	 */
	public function deleteComment( $group_id, $feed_id, $comment_id ) {
		try {
			$validate_currentUser_has_permission = $this->validate_currentUser_has_permission( $group_id );
			$validate_currentUser_owns_comment   = $this->validate_currentUser_owns_comment( $comment_id );

			if ( ! ( $validate_currentUser_owns_comment || $validate_currentUser_has_permission ) ) {
				return back()->with( 'error', trans( 'front/feed.permissionDenied' ) );
			}
			$this->comment_repository->deleteComment( $comment_id );

			$feed = Feed::whereid( $feed_id )->first();
			$json = getAllReplyCount( $feed );

		} catch ( \Exception $e ) {
			return back()->with( 'error', trans( 'front/feed.deleteCommentFail' ) );
		}

		return response( [ 'status' => 'success', 'json' => $json ] );
//        return back()->with('ok', trans('front/feed.commentDeleteSuccessful'));
	}

	/**
	 * delete child comment
	 *
	 * @param $group_id
	 * @param $feed_id
	 * @param $comment_id
	 * @param $childComment_id
	 *
	 * @return bool|\Illuminate\Http\RedirectResponse
	 */
	public function deleteChildComment( $group_id, $feed_id, $comment_id, $childComment_id ) {
		try {
			$validate_currentUser_has_permission = $this->validate_currentUser_has_permission( $group_id );
			$validate_currentUser_owns_comment   = $this->validate_currentUser_owns_comment( $childComment_id );

			if ( ! ( $validate_currentUser_owns_comment || $validate_currentUser_has_permission ) ) {
				return back()->with( 'error', trans( 'front/feed.permissionDenied' ) );
			}
			$this->comment_repository->deleteChildComment( $childComment_id );

			$feed = Feed::whereid( $feed_id )->first();
			$json = getAllReplyCount( $feed );

		} catch ( \Exception $e ) {
			return back()->with( 'error', trans( 'front/feed.deleteCommentFail' ) );
		}

		return response( [ 'status' => 'success', 'json' => $json ] );
//        return back()->with('ok', trans('front/feed.commentDeleteSuccessful'));
	}

	/**
	 * edit first lvl comment
	 *
	 * @param $group_id
	 * @param $feed_id
	 * @param $comment_id
	 *
	 * @return bool|\Illuminate\Http\RedirectResponse
	 */
	public function editComment( $group_id, $feed_id, $comment_id, EditCommentRequest $request ) {
		try {
			$validate_currentUser_has_permission = $this->validate_currentUser_has_permission( $group_id );
			$validate_currentUser_owns_comment   = $this->validate_currentUser_owns_comment( $comment_id );

			if ( ! ( $validate_currentUser_owns_comment || $validate_currentUser_has_permission ) ) {
				return back()->with( 'error', trans( 'front/feed.permissionDenied' ) );
			}
			$comment = $this->comment_repository->editComment( $request->all(), $comment_id );

		} catch ( \Exception $e ) {
			return back()->with( 'error', trans( 'front/feed.editCommentFail' ) );
		}

		return response( [ 'status' => 'success', 'json' => $comment ] );
//        return back()->with('ok', trans('front/feed.commentDeleteSuccessful'));
	}

	/**
	 * edit first lvl comment
	 *
	 * @param $group_id
	 * @param $feed_id
	 * @param $comment_id
	 *
	 * @return bool|\Illuminate\Http\RedirectResponse
	 */
	public function editChildComment( $group_id, $feed_id, $comment_id, $childComment_id, EditCommentRequest $request ) {
		try {
			$validate_currentUser_has_permission = $this->validate_currentUser_has_permission( $group_id );
			$validate_currentUser_owns_comment   = $this->validate_currentUser_owns_comment( $childComment_id );

			if ( ! ( $validate_currentUser_owns_comment || $validate_currentUser_has_permission ) ) {
				return back()->with( 'error', trans( 'front/feed.permissionDenied' ) );
			}
			$childComment = $this->comment_repository->editComment( $request->all(), $childComment_id );

		} catch ( \Exception $e ) {
			return back()->with( 'error', trans( 'front/feed.editCommentFail' ) );
		}

		return response( [ 'status' => 'success', 'json' => $childComment ] );
//        return back()->with('ok', trans('front/feed.commentDeleteSuccessful'));
	}

	/**
	 * like the feed
	 *
	 * @param $group_id
	 * @param $feed_id
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
	public function likeFeed( $group_id, $feed_id ) {
		try {
			$feed = Feed::find( $feed_id );
			if ( ! $feed ) {
				return back()->with( 'error', trans( 'front/feed.postFail' ) );
			}
			// may want to give ability to un-like in the future
			if ( Auth::user()->hasLikedFeed( $feed ) ) {
				$this->like_repository->deleteLikeFeed( $feed );
			} else {
				$this->like_repository->likeFeed( $feed );
			}

			$feed_like_count   = Feed::whereid( $feed_id )->first()->likes->count();
			$feed_unlike_count = Feed::whereid( $feed_id )->first()->unlikes->count();

		} catch ( \Exception $e ) {
			return back()->with( 'error', trans( 'front/feed.likeFeedFail' ) );
		}

//		return redirect()->back();
		return response( [
			'status' => 'success',
			'json'   => [ 'feed_like_count' => $feed_like_count, 'feed_unlike_count' => $feed_unlike_count, ]
		] );

	}

	/**
	 * like the comments
	 *
	 * @param $group_id
	 * @param $comment_id
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
	public function likeComment( $group_id, $comment_id ) {
		try {
			$comment = Comment::find( $comment_id );
			if ( ! $comment ) {
				return back()->with( 'error', trans( 'front/feed.postFail' ) );
			}

			// may want to give ability to un-like in the future
			if ( Auth::user()->hasLikedComment( $comment ) ) {
				$this->like_repository->deleteLikeComment( $comment );
			} else {
				$this->like_repository->likeComment( $comment );
			}

			$feed_reply_like_count   = Comment::whereid( $comment_id )->first()->likes->count();
			$feed_reply_unlike_count = Comment::whereid( $comment_id )->first()->unlikes->count();

		} catch ( \Exception $e ) {
			return redirect( '/' )->with( 'error', trans( 'front/feed.likeCommentFail' ) );
		}

//		return redirect()->back();
		return response( [
			'status' => 'success',
			'json'   => [ 'feed_reply_like_count' => $feed_reply_like_count, 'feed_reply_unlike_count' => $feed_reply_unlike_count, ]
		] );
	}


	/**
	 * unlike the feed
	 *
	 * @param $group_id
	 * @param $feed_id
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
	public function unlikeFeed( $group_id, $feed_id ) {
		try {
			$feed = Feed::find( $feed_id );
			if ( ! $feed ) {
				return back()->with( 'error', trans( 'front/feed.postFail' ) );
			}

			// may want to give ability to un-like in the future
			if ( Auth::user()->hasUnlikedFeed( $feed ) ) {
				$this->unlike_repository->deleteUnlikeFeed( $feed );
			} else {
				$this->unlike_repository->unlikeFeed( $feed );
			}

			$feed_like_count   = Feed::whereid( $feed_id )->first()->likes->count();
			$feed_unlike_count = Feed::whereid( $feed_id )->first()->unlikes->count();

		} catch ( \Exception $e ) {
			return redirect( '/' )->with( 'error', trans( 'front/feed.unlikeFeedFail' ) );
		}

//		return redirect()->back();
		return response( [
			'status' => 'success',
			'json'   => [ 'feed_like_count' => $feed_like_count, 'feed_unlike_count' => $feed_unlike_count, ]
		] );

	}

	/**
	 * unlike the comments
	 *
	 * @param $group_id
	 * @param $comment_id
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
	public function unlikeComment( $group_id, $comment_id ) {
		try {
			$comment = Comment::find( $comment_id );
			if ( ! $comment ) {
				return back()->with( 'error', trans( 'front/feed.postFail' ) );
			}

			// may want to give ability to un-like in the future
			if ( Auth::user()->hasUnlikedComment( $comment ) ) {
				$this->unlike_repository->deleteUnlikeComment( $comment );
			} else {
				$this->unlike_repository->unlikeComment( $comment );
			}

			$feed_reply_like_count   = Comment::whereid( $comment_id )->first()->likes->count();
			$feed_reply_unlike_count = Comment::whereid( $comment_id )->first()->unlikes->count();

		} catch ( \Exception $e ) {
			return redirect( '/' )->with( 'error', trans( 'front/feed.unlikeCommentFail' ) );
		}

//		return redirect()->back();
		return response( [
			'status' => 'success',
			'json'   => [ 'feed_reply_like_count' => $feed_reply_like_count, 'feed_reply_unlike_count' => $feed_reply_unlike_count, ]
		] );
	}

	/**
	 * pin a feed
	 *
	 * @param $group_id
	 * @param $feed_id
	 *
	 * @return bool|\Illuminate\Http\RedirectResponse
	 */
	public function pinFeed( $group_id, $feed_id ) {
		try {
			$feed = Feed::find( $feed_id );
			if ( ! $feed ) {
				return back()->with( 'error', trans( 'front/general.somethingWrong' ) );
			}

			$validate_currentUser_has_permission = $this->validate_currentUser_has_permission( $group_id );
			if ( ! ( $validate_currentUser_has_permission ) ) {
				return back()->with( 'error', trans( 'front/feed.permissionDenied' ) );
			}
			$this->feed_repository->pinFeed( $feed );
		} catch ( \Exception $e ) {
			return back()->with( 'error', trans( 'front/feed.pinFeedFail' ) );
		}

		return redirect()->back()->with( 'ok', trans( 'front/feed.pinFeedSuccessful' ) );
	}

	/**
	 * unpin a feed
	 *
	 * @param $group_id
	 * @param $feed_id
	 *
	 * @return bool|\Illuminate\Http\RedirectResponse
	 */
	public function unpinFeed( $group_id, $feed_id ) {
		try {
			$feed = Feed::find( $feed_id );
			if ( ! $feed ) {
				return back()->with( 'error', trans( 'front/general.somethingWrong' ) );
			}

			$validate_currentUser_has_permission = $this->validate_currentUser_has_permission( $group_id );
			if ( ! ( $validate_currentUser_has_permission ) ) {
				return back()->with( 'error', trans( 'front/feed.permissionDenied' ) );
			}
			$this->feed_repository->unpinFeed( $feed );
		} catch ( \Exception $e ) {
			return back()->with( 'error', trans( 'front/feed.unpinFeedFail' ) );
		}

		return redirect()->back()->with( 'ok', trans( 'front/feed.unpinFeedSuccessful' ) );
	}

}

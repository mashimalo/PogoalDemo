<?php namespace App\Repositories;

use App\Models\Unlike;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class LikeRepository extends BaseRepository {
	/**
	 * @param Like $feed
	 */
	public function __construct(
		Unlike $like
	) {
		$this->$like = $like;
	}


	/**
	 * like feeds
	 *
	 * @param $feed
	 *
	 * @throws \Exception
	 */
	public function likeFeed( $feed ) {
		DB::beginTransaction();
		try {
			if ( Auth::user()->hasUnlikedFeed( $feed ) ) {
				$feed->unlikes()->where( 'user_id', Auth::user()->id )->delete();
			}
			$like = $feed->likes()->create( [ ] );
			Auth::user()->likes()->save( $like );
		} catch ( \Exception $e ) {
			DB::rollback();
			throw $e;
		}
		DB::commit();
	}

	/**
	 * delete like feeds
	 *
	 * @param $feed
	 *
	 * @throws \Exception
	 */
	public function deleteLikeFeed( $feed ) {
		DB::beginTransaction();
		try {
			if ( Auth::user()->hasUnlikedFeed( $feed ) ) {
				$feed->unlikes()->where( 'user_id', Auth::user()->id )->delete();
			}
			$feed->likes()->where( 'user_id', Auth::user()->id )->delete();
		} catch ( \Exception $e ) {
			DB::rollback();
			throw $e;
		}
		DB::commit();
	}

	/**
	 * like comments
	 *
	 * @param $comment
	 *
	 * @throws \Exception
	 */
	public function likeComment( $comment ) {

		DB::beginTransaction();
		try {
			if ( Auth::user()->hasUnlikedComment( $comment ) ) {
				$comment->unlikes()->where( 'user_id', Auth::user()->id )->delete();
			}
			$like = $comment->likes()->create( [ ] );
			Auth::user()->likes()->save( $like );
		} catch ( \Exception $e ) {
			DB::rollback();
			throw $e;
		}
		DB::commit();
	}

	/**
	 * like comments
	 *
	 * @param $comment
	 *
	 * @throws \Exception
	 */
	public function deleteLikeComment( $comment ) {

		DB::beginTransaction();
		try {
			if ( Auth::user()->hasUnlikedComment( $comment ) ) {
				$comment->unlikes()->where( 'user_id', Auth::user()->id )->delete();
			}
			$comment->likes()->where( 'user_id', Auth::user()->id )->delete();
		} catch ( \Exception $e ) {
			DB::rollback();
			throw $e;
		}
		DB::commit();
	}
}
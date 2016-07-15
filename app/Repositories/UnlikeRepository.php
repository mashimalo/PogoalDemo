<?php namespace App\Repositories;

use App\Models\Like;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class UnlikeRepository extends BaseRepository {
	/**
	 * @param Like $feed
	 */
	public function __construct(
		Like $like
	) {
		$this->$like = $like;
	}


	/**
	 * unlike feeds
	 *
	 * @param $feed
	 * @param $inputs
	 *
	 * @throws \Exception
	 */
	public function unlikeFeed( $feed ) {
		DB::beginTransaction();
		try {
			if ( Auth::user()->hasLikedFeed( $feed ) ) {
				$feed->likes()->where( 'user_id', Auth::user()->id )->delete();
			}
			$unlike = $feed->unlikes()->create( [ ] );
			Auth::user()->unlikes()->save( $unlike );
		} catch ( \Exception $e ) {
			DB::rollback();
			throw $e;
		}
		DB::commit();
	}

	/**
	 * delete unlike feed
	 *
	 * @param $feed
	 *
	 * @throws \Exception
	 */
	public function deleteUnlikeFeed( $feed ) {
		DB::beginTransaction();
		try {
			if ( Auth::user()->hasLikedFeed( $feed ) ) {
				$feed->likes()->where( 'user_id', Auth::user()->id )->delete();
			}
			$feed->unlikes()->where( 'user_id', Auth::user()->id )->delete();
		} catch ( \Exception $e ) {
			DB::rollback();
			throw $e;
		}
		DB::commit();
	}


	/**
	 * unlike comment
	 *
	 * @param $comment
	 *
	 * @throws \Exception
	 */
	public function unlikeComment( $comment ) {
		DB::beginTransaction();
		try {
			if ( Auth::user()->hasLikedComment( $comment ) ) {
				$comment->likes()->where( 'user_id', Auth::user()->id )->delete();
			}
			$unlike = $comment->unlikes()->create( [ ] );
			Auth::user()->unlikes()->save( $unlike );
		} catch ( \Exception $e ) {
			DB::rollback();
			throw $e;
		}
		DB::commit();
	}


	/**
	 * delete unlike comment
	 *
	 * @param $comment
	 *
	 * @throws \Exception
	 */
	public function deleteUnlikeComment( $comment ) {
		DB::beginTransaction();
		try {
			if ( Auth::user()->hasLikedComment( $comment ) ) {
				$comment->likes()->where( 'user_id', Auth::user()->id )->delete();
			}
			$comment->unlikes()->where( 'user_id', Auth::user()->id )->delete();

		} catch ( \Exception $e ) {
			DB::rollback();
			throw $e;
		}
		DB::commit();
	}
}
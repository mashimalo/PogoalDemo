<?php namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\Comment, App\Models\Feed;
use Illuminate\Support\Facades\Auth;
use s9e\TextFormatter\Configurator;

class CommentRepository extends BaseRepository {
	/**
	 * @param Feed $feed
	 * @param Comment $comment
	 */
	public function __construct(
		Comment $comment
	) {
		$this->comment = $comment;
	}


	/**
	 * @param $feed
	 * @param $inputs
	 *
	 * @throws \Exception
	 */
	public function postComment( $inputs, $feed_id ) {
		DB::beginTransaction();
		$comment          = new Comment();
		$comment->user_id = Auth::id();
		$comment->feed_id = $feed_id;
		$content = $this->convertInputToAutoLink($inputs["reply-{$feed_id}"]);

		$comment->content = $content;


		if ( strlen( $content ) > 100 ) {
			$comment->summary = substr( $content, 0, 100 );
		}
		try {
			$comment->save();
		} catch ( \Exception $e ) {
			DB::rollback();
			throw $e;
		}
		DB::commit();
		return $comment;
	}

	/**
	 * post child comment
	 *
	 * @param $inputs
	 * @param $parent_id
	 *
	 * @throws \Exception
	 */
	public function postChildComment( $inputs, $parent_id ) {
		DB::beginTransaction();
		$comment            = new Comment();
		$comment->user_id   = Auth::id();
		$comment->parent_id = $parent_id;
		$content = $this->convertInputToAutoLink($inputs["2ndReply-{$parent_id}"]);
		$comment->content = $content;

		if ( strlen( $content ) > 100 ) {
			$comment->summary = substr( $content, 0, 100 );
		}
		try {
			$comment->save();
		} catch ( \Exception $e ) {
			DB::rollback();
			throw $e;
		}
		DB::commit();
		return $comment;
	}

	/**
	 * @param $comment_id
	 * @param $inputs
	 *
	 * @return Comment
	 * @throws \Exception
	 */
	public function editComment( $inputs, $comment_id ) {
		DB::beginTransaction();
		$comment          = Comment::whereid( $comment_id )->firstOrFail();
		$content = $this->convertInputToAutoLink($inputs["editComment"]);
		$comment->content = $content;

		if ( strlen( $content ) > 100 ) {
			$comment->summary = substr( $content, 0, 100 );
		}
		try {
			$comment->save();
		} catch ( \Exception $e ) {
			DB::rollback();
			throw $e;
		}
		DB::commit();

		return $comment;
	}

	/**
	 * delete comment
	 *
	 * @param $comment_id
	 *
	 * @throws \Exception
	 */
	public function deleteComment( $comment_id ) {
		DB::beginTransaction();
		try {
			$comment = Comment::whereid( $comment_id )->firstOrFail();

			$comment->likes()->delete();
			$comment->unlikes()->delete();
			foreach ( $comment->childComments as $childComment ) {
				$childComment->likes()->delete();
				$childComment->unlikes()->delete();
			}

			$comment->delete();
		} catch ( \Exception $e ) {
			DB::rollback();
			throw $e;
		}
		DB::commit();
	}

	/**
	 * delete child comment
	 *
	 * @param $comment_id
	 *
	 * @throws \Exception
	 */
	public function deleteChildComment( $comment_id ) {
		DB::beginTransaction();
		try {
			$comment = Comment::whereid( $comment_id )->firstOrFail();

			$comment->likes()->delete();
			$comment->unlikes()->delete();

			$comment->delete();
		} catch ( \Exception $e ) {
			DB::rollback();
			throw $e;
		}
		DB::commit();
	}

	/**
	 * convertInputToAutoLink
	 *
	 * @param $input
	 * @return mixed
	 * @throws \Exception
	 */
	public function convertInputToAutoLink($input)
	{
		try
		{
			$configurator = new Configurator;
			$configurator->Autolink->matchWww = true;

			// Get the default URL template as a DOMDocument
			$dom = $configurator->tags['URL']->template->asDOM();

			// Set a target="_blank" attribute to any <a> element
			foreach ($dom->getElementsByTagName('a') as $a)
			{
				$a->setAttribute('target', '_blank');
			}

			// Save the changes
			$dom->saveChanges();
			extract($configurator->finalize());

			$xml = $parser->parse($input);
			$html = $renderer->render($xml);
		}

		catch (\Exception $e)
		{
			throw $e;
		}
		return $html;
	}
}
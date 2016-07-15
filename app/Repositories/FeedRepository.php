<?php namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Feed;
use Illuminate\Support\Facades\Auth;
use s9e\TextFormatter\Configurator;

class FeedRepository extends BaseRepository
{
//    /**
//     * @param Feed $feed
//     */
//    public function __construct(
//        Feed $feed
//        )
//    {
//        $this->feed = $feed;
//    }

    /**
     * post feed
     * @param $inputs
     * @param $group_id
     * @return Feed
     * @throws \Exception
     */
    public function postFeed($inputs, $group_id)
    {
        DB::beginTransaction();
        try
        {
            $feed = new Feed();
            $feed->user_id = Auth::id();
            $feed->group_id = $group_id;
            $content = $this->convertInputToAutoLink($inputs['feed']);

            $feed->content = $content;


            if (strlen($content) > 100)
            {
                $feed->summary = substr($content, 0, 100);
            }

            $feed->save();
        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
        DB::commit();

        return $feed;
    }


    /**
     * post feed
     * @param $inputs
     * @param $feed_id
     * @return Feed
     * @throws \Exception
     */
    public function editFeed($inputs, $feed_id)
    {
        DB::beginTransaction();
        try
        {

            $feed = Feed::whereid($feed_id)->firstOrFail();

            $content = $this->convertInputToAutoLink($inputs['feed']);
            $feed->content = $content;


            if (strlen($content) > 100)
            {
                $feed->summary = substr($content, 0, 100);
            }

            $feed->save();
        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
        DB::commit();

        return $feed;
    }


    /**
     * delete feed
     * @param $feed_id
     * @throws \Exception
     */
    public function deleteFeed($feed_id)
    {
        DB::beginTransaction();
        try
        {
            $feed = Feed::whereid($feed_id)->firstOrFail();

            $feed->likes()->delete();
            $feed->unlikes()->delete();
            foreach ($feed->comments as $comment)
            {
                $comment->likes()->delete();
                $comment->unlikes()->delete();
                foreach ($comment->childComments as $childComment)
                {
                    $childComment->likes()->delete();
                    $childComment->unlikes()->delete();
                }
            }
            $feed->delete();
        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
        DB::commit();
    }

    /**
     * pin Feed
     * @param $feed
     * @throws \Exception
     */
    public function pinFeed($feed)
    {
        DB::beginTransaction();
        try
        {
            $feed->pinned = true;
            $feed->pin_last_updated = Carbon::now();
            $feed->save();
        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
        DB::commit();
    }

    /**
     * unpin Feed
     * @param $feed
     * @throws \Exception
     */
    public function unpinFeed($feed)
    {
        DB::beginTransaction();
        try
        {
            $feed->pinned = false;
            $feed->pin_last_updated = Carbon::now();
            $feed->save();
        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
        DB::commit();
    }

    /**
     * post feed
     * @param $inputs
     * @param $group_id
     * @return Feed
     * @throws \Exception
     */
    public function postDockingGroupFeed($inputs, $dockingGroup_id)
    {
        DB::beginTransaction();
        try
        {
            $feed = new Feed();
            $feed->user_id = Auth::id();
            $feed->docking_group_id = $dockingGroup_id;
            $content = $this->convertInputToAutoLink($inputs['feed']);

            $feed->content = $content;


            if (strlen($content) > 100)
            {
                $feed->summary = substr($content, 0, 100);
            }
            $feed->save();
        }
        catch (\Exception $e)
        {
            DB::rollback();
            throw $e;
        }
        DB::commit();

        return $feed;
    }

    /**
     * convert input to autolink
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
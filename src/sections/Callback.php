<?php

namespace rsspipes\sections;

use rsspipes\rss\Feed;
use rsspipes\rss\Item;

/**
 * Proces feed or items using callbacks.
 */
class Callback extends Section
{
    /**
     * @var callable
     */
    public $feed;
    /**
     * @var callable
     */
    public $item;
    
    /**
     * @param Feed $feed
     */
    public function processFeed($feed)
    {
        if ($this->feed) {
            call_user_func($this->feed, $feed);
            
        } else {
            parent::processFeed($feed);
        }
    }
    
    /**
     * @param Item $item
     */
    public function processItem($item)
    {
        if ($this->item) {
            call_user_func($this->item, $item);
            
        } else {
            parent::processFeed($feed);
        }
    }
}

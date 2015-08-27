<?php

namespace rsspipes\sections;

use rsspipes\rss\Feed;
use rsspipes\Pipe as RssPipe;

class Pipe extends Section
{
    public $config;
    public $pipe;
    
    public function init()
    {
        parent::init();
        
        $this->pipe = new RssPipe($this->config);
    }
    
    /**
     * @param Feed $feed
     */
    public function processFeed($feed)
    {
        $feed->items = array_merge($feed->items, $this->pipe->run()->items);
    }
}

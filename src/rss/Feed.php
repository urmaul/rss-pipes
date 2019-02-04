<?php

namespace rsspipes\rss;

class Feed
{
    public $attributes = ['version' => '2.0'];
    public $namespaces = [];
    public $metadata = [];
    /**
     * @var Item[]
     */
    public $items = [];
    
    public function addItem($item)
    {
        if (is_array($item))
            $item = new Item($item);
        
        $this->items[] = $item;
    }
}

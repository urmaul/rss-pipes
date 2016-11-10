<?php

namespace rsspipes\sections;

use rsspipes\rss\Feed;
use rsspipes\rss\Item;

/**
 * Keep only items that fulfill the condition.
 */
class Filter extends Block
{
    /**
     * @param Feed $feed
     */
    public function processFeed($feed)
    {
        foreach ($this->rules as $field => $rules) {
            if (is_string($rules))
                $rules = [$rules];
            
            $feed->items = array_filter($feed->items, function (Item $item) use ($field, $rules) {
                return $this->matchRules($item->$field, $rules);
            });
            $feed->items = array_values($feed->items);
        }
    }
}

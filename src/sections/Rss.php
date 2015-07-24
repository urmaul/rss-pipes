<?php

namespace rsspipes\sections;

use rsspipes\rss\Feed;
use rsspipes\rss\Item;

class Rss extends Section
{
    public $url;
    
    /**
     * @param Feed $feed
     */
    public function processFeed($feed)
    {
        $rss = \HttpClient::from()->get($this->url);
        $xml = new \SimpleXMLElement($rss);
        
        foreach ($xml->attributes() as $key => $val) {
            $feed->attributes += [$key => $val];
        }
        $feed->namespaces += $xml->getDocNamespaces();
        
        foreach ($xml->channel->children() as $key => $element) {
            if ($key === 'item') {
                $item = new Item;
                
                $children = (array) $element->children();
                foreach ($children as $key => $value) {
                    $item->$key = $value;
                }
                
                foreach ($element->children() as $childKey => $child) {
                    $attributes = [];
                    foreach ($child->attributes() as $key => $value) {
                        $attributes[$key] = (string) $value;
                    }
                    if ($attributes) {
                        $item->attributes[$childKey] = $attributes;
                    }
                }
                
                $feed->items[] = $item;
                
            } else {
                $value = $element->children() ? (array) $element->children() : (string) $element;
                $feed->metadata += [$key => $value];
            }
        }
    }
}

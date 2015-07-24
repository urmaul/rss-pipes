<?php

namespace rsspipes\sections;

use rsspipes\rss\Feed;
use rsspipes\rss\Item;

class Atom extends Section
{
    public $url;
    
    /**
     * @param Feed $feed
     */
    public function processFeed($feed)
    {
        $body = \HttpClient::from()->get($this->url);
        $this->parseBody($body, $feed);
    }
    
    public function parseBody($body, $feed)
    {
        $xml = new \SimpleXMLElement($body);
        
        foreach ($xml->attributes() as $key => $val) {
            $feed->attributes += [$key => $val];
        }
        $feed->namespaces += $xml->getDocNamespaces();
        
        foreach ($xml->children() as $key => $element) {
            if ($key === 'entry') {
                $item = new Item;
                
                $children = (array) $element->children();
                foreach ($children as $key => $value) {
                    $item->$key = is_array($value) ? array_map('strval', $value) : (string) $value;
                }
                $item->description = (string) $element->content;
                
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

<?php

namespace rsspipes\sections;

use rsspipes\rss\Feed;
use rsspipes\rss\Item;

/**
 * Parses rss feed.
 */
class Rss extends Section
{
    public $url;
    public $showErrors = 1;
    
    /**
     * @param Feed $feed
     */
    public function processFeed($feed)
    {
        $http = new \HttpClient(); 
        $body = $http->get($this->url);
        if ($body !== false) {
            $this->parseBody($body, $feed);
            
        } elseif ($this->showErrors) {
            $feed->addItem(['title' => $http->lastError, 'link' => $this->url]);
        }
    }
    
    public function parseBody($body, $feed)
    {
        $xml = new \SimpleXMLElement($body);
        
        foreach ($xml->attributes() as $key => $val) {
            $feed->attributes += [$key => $val];
        }
        $feed->namespaces += $xml->getDocNamespaces();
        
        $metadata = $this->parseChildrenValues($xml->channel);
        unset($metadata['item']);
        
        $feed->metadata += $metadata;
        
        foreach ($xml->channel->item as $key => $element) {
            $item = new Item;
            $item->setData($this->parseChildrenValues($element));
            $item->attributes += $this->parseAllAttributes($element);

            $feed->items[] = $item;
        }
    }
    
    protected function parseChildrenValues($element)
    {
        $children = (array) $element->children();
        $values = [];
        foreach ($children as $key => $value) {
            if (is_object($value) && $value->count()) {
                $value = $this->parseChildrenValues($value);
                
            } elseif (is_array($value)) {
                $value = array_map('strval', $value);
                
            } else {
                $value = (string) $value;
            }
            
            $values[$key] = $value;
        }
        
        return $values;
    }
    
    public function parseAllAttributes($element)
    {
        $attributes = [];
        foreach ($element->children() as $childKey => $child) {
            $attributes = [];
            foreach ($child->attributes() as $key => $value) {
                $attributes[$key] = (string) $value;
            }
            if ($attributes) {
                $attributes[$childKey] = $attributes;
            }
        }
        return $attributes;
    }
}

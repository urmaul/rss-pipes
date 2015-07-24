<?php

namespace rsspipes\sections;

use rsspipes\rss\Feed;
use rsspipes\rss\Item;

class Atom extends Rss
{
    public function parseBody($body, $feed)
    {
        $xml = new \SimpleXMLElement($body);
        
        foreach ($xml->attributes() as $key => $val) {
            $feed->attributes += [$key => $val];
        }
        $feed->namespaces += $xml->getDocNamespaces();
        
        $metadata = $this->parseChildrenValues($xml);
        unset($metadata['entry']);
        
        $feed->metadata += $metadata;
        
        foreach ($xml->entry as $key => $element) {
            $item = new Item;
            $item->setData($this->parseChildrenValues($element));
            $item->description = (string) $element->content;
            $item->attributes += $this->parseAllAttributes($element);

            $feed->items[] = $item;
        }
    }
    
    public function parseChildrenValues($element)
    {
        $values = parent::parseChildrenValues($element);
        
        if ($element->link) {
            $values['link'] = (string) $element->link['href'];
        }
        
        return $values;
    }
}

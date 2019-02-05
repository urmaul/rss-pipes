<?php

namespace rsspipes\sections;

use rsspipes\rss\Item;

/**
 * Parses atom feed.
 */
class Atom extends Rss
{
    public function parseBody($body, $feed)
    {
        $xml = new \SimpleXMLElement($body);
        
        foreach ($xml->attributes() as $key => $val) {
            $feed->attributes += [$key => $val];
        }
        $feed->namespaces += $xml->getDocNamespaces();
        
        $metadata = $this->parseChannelMetadata($this->parseChildrenValues($xml));
        unset($metadata['entry']);
        
        $feed->metadata += $metadata;
        
        foreach ($xml->entry as $key => $element) {
            $item = new Item;
            $item->guid = (string) $element->id;
            $item->description = (string) $element->content;
            $item->setData($this->parseChildrenValues($element));
            $item->attributes += $this->parseAllAttributes($element);

            if ($element->updated) {
                $pubDate = new \DateTimeImmutable((string) $element->updated);
                $item->pubDate = $pubDate->format(DATE_RFC822);
                unset($item->attributes['updated']);
            }

            $feed->items[] = $item;
        }
    }
    
    protected function parseChildrenValues($element)
    {
        $values = parent::parseChildrenValues($element);
        
        if ($element->link) {
            $values['link'] = (string) $element->link['href'];
        }
        
        return $values;
    }

    private function parseChannelMetadata(array $metadata): array
    {
        unset($metadata['id'], $metadata['updated'], $metadata['author']);
        return $metadata;
    }
}

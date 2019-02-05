<?php

declare(strict_types=1);

namespace rsspipes\builder;

use rsspipes\rss\Feed;
use SimpleXMLElement;

class RssBuilder implements Builder
{

    public function getContentType(): string
    {
        return 'application/rss+xml';
    }

    public function buildFeed(Feed $feed): string
    {
        $rss = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><rss/>');
        foreach ($feed->attributes as $name => $value) {
            $rss->addAttribute($name, $value);
        }

        $channel = $rss->addChild('channel');

        foreach ($feed->metadata as $name => $value) {
            if (is_array($value)) {
                foreach ($value as $valueItem) {
                    $channel->addChild($name, $valueItem);
                }
            } else {
                $channel->addChild($name, $value);
            }
        }

        foreach ($feed->items as $item) {
            $rssItem = $channel->addChild('item');
            foreach ($item->getData() as $name => $value) {
                $rssItem->addChild($name, $value);
            }
        }

        return $rss->asXml();
    }
}

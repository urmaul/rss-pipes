<?php

declare(strict_types=1);

namespace rsspipes\builder;

use rsspipes\rss\Feed;

class JsonBuilder implements Builder
{

    public function getContentType(): string
    {
        return 'application/json';
    }

    public function buildFeed(Feed $feed): string
    {
        $data = $feed->metadata;

        $items = [];
        foreach ($feed->items as $item) {
            $items[] = $item->getData();
        }
        $data['items'] = $items;

        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}

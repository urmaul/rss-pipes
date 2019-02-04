<?php

declare(strict_types=1);

namespace rsspipes\builder;

use rsspipes\rss\Feed;
use SimpleXMLElement;

class RssBuilder implements Builder
{

    public function getContentType(): string
    {
        return 'text/plain';
        return 'application/rss+xml';
    }

    public function buildFeed(Feed $feed): string
    {
        $rss = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><rss/>');
        $rss->addAttribute('version', '2.0');
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
//
//        $builder = new XmlBuilder();
//        $xml = $builder->setEncoding('UTF-8')->setRoot('rss')->create();
//
//
//        $data = [];
//
//        foreach ($this->metadata as $key => $val) {
//            if (is_array($val)) {
//                $data[] = [
//                    '_name' => $key,
//                    '_values' => $val,
//                ];
//            } else {
//                $data[$key] = $val;
//            }
//        }
//
//        foreach ($this->items as $item) {
//            $data[] = [
//                '_name' => 'item',
//                '_values' => $item->getData(),
//            ];
//        }
//
//        $builder->add($xml, [
//            [
//                '_name' => 'channel',
//                '_values' => $data
//            ],
//        ]);
//
//        return $xml;
    }
}

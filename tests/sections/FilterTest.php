<?php

namespace rsspipestests\sections;

use rsspipes\rss\Feed;
use rsspipes\rss\Item;
use rsspipes\sections\Filter;

class FilterTest extends \PHPUnit_Framework_TestCase
{
    public function testWorks()
    {
        $feed = new Feed();
        $feed->items = [
            new Item(['title' => 'foo']),
            new Item(['title' => 'bar']),
        ];
        
        $this->assertCount(2, $feed->items);
        
        $section = new Filter();
        $section->rules = ['title' => ['bar']];
        
        $section->processFeed($feed);
        
        $this->assertCount(1, $feed->items);
        $this->assertSame('bar', $feed->items[0]->title);
    }
}

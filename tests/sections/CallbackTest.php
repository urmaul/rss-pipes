<?php

namespace rsspipestests\sections;

use rsspipes\rss\Feed;
use rsspipes\rss\Item;
use rsspipes\sections\Callback;

class CallbackTest extends \PHPUnit_Framework_TestCase
{
    public function testItemCallback()
    {
        $feed = new Feed();
        $feed->items = [
            new Item(['title' => 'foo']),
            new Item(['title' => 'bar']),
        ];
        
        $section = new Callback();
        $section->item = function (Item $item) {
            $item->title = strtoupper($item->title);
        };
        
        $section->processFeed($feed);
        
        $this->assertCount(2, $feed->items);
        $this->assertSame('FOO', $feed->items[0]->title);
        $this->assertSame('BAR', $feed->items[1]->title);
    }
    
    public function testFeedCallback()
    {
        $feed = new Feed();
        $feed->items = [
            new Item(['title' => 'foo']),
            new Item(['title' => 'bar']),
        ];
        
        $section = new Callback();
        $section->feed = function (Feed $feed) {
            $feed->items = array_reverse($feed->items);
        };
        
        $section->processFeed($feed);
        
        $this->assertCount(2, $feed->items);
        $this->assertSame('bar', $feed->items[0]->title);
        $this->assertSame('foo', $feed->items[1]->title);
    }
}

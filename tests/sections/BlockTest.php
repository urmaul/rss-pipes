<?php

namespace rsspipestests\sections;

use rsspipes\rss\Feed;
use rsspipes\rss\Item;
use rsspipes\sections\Block;

class BlockTest extends \PHPUnit_Framework_TestCase
{
    public function testWorks()
    {
        $feed = new Feed();
        $feed->items = [
            new Item(['title' => 'foo']),
            new Item(['title' => 'bar']),
        ];
        
        $this->assertCount(2, $feed->items);
        
        $section = new Block();
        $section->rules = ['title' => ['bar']];
        
        $section->processFeed($feed);
        
        $this->assertCount(1, $feed->items);
        $this->assertSame('foo', $feed->items[0]->title);
    }
    
    public function testCondition()
    {
        $feed = new Feed();
        $feed->items = [
            new Item(['title' => 'foo bar']),
            new Item(['title' => 'bar baz']),
            new Item(['title' => 'foo baz']),
        ];
        
        $this->assertCount(3, $feed->items);
        
        $section = new Block();
        $section->rules = ['title' => [['bar', 'baz']]];
        
        $section->processFeed($feed);
        
        $this->assertCount(2, $feed->items);
        $this->assertSame('foo bar', $feed->items[0]->title);
        $this->assertSame('foo baz', $feed->items[1]->title);
    }
    
    public function testRegexp()
    {
        $feed = new Feed();
        $feed->items = [
            new Item(['title' => 'foo bar']),
            new Item(['title' => 'bar baz']),
            new Item(['title' => 'foo baz']),
        ];
        
        $this->assertCount(3, $feed->items);
        
        $section = new Block();
        $section->rules = ['title' => ['/^bar/']];
        
        $section->processFeed($feed);
        
        $this->assertCount(2, $feed->items);
        $this->assertSame('foo bar', $feed->items[0]->title);
        $this->assertSame('foo baz', $feed->items[1]->title);
    }
}

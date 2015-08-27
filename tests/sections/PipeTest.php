<?php

namespace rsspipestests\sections;

use rsspipes\rss\Feed;
use rsspipes\rss\Item;
use rsspipes\sections\Pipe;

class PipeTest extends \PHPUnit_Framework_TestCase
{
    public function testWorks()
    {
        $feed = new Feed();
        $feed->items = [
            new Item(['title' => 'foo']),
            new Item(['title' => 'bar']),
        ];
        
        $feed2 = new Feed();
        $feed2->items = [
            new Item(['title' => 'spam']),
            new Item(['title' => 'ham']),
        ];
        
        $section = new Pipe();
        
        $stub = $this->getMockBuilder('rsspipes\Pipe')->getMock();
        $stub->method('run')->willReturn($feed2);
        $section->pipe = $stub;
        
        $section->processFeed($feed);
        
        $this->assertCount(4, $feed->items);
        $this->assertSame('foo', $feed->items[0]->title);
        $this->assertSame('bar', $feed->items[1]->title);
        $this->assertSame('spam', $feed->items[2]->title);
        $this->assertSame('ham', $feed->items[3]->title);
    }
}

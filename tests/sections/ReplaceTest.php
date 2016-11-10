<?php

namespace rsspipestests\sections;

use rsspipes\rss\Feed;
use rsspipes\rss\Item;
use rsspipes\sections\Section;
use rsspipes\sections\Replace;

class ReplaceTest extends \PHPUnit_Framework_TestCase
{
    public function testReplace()
    {
        $feed = new Feed();
        $feed->items = [
            new Item(['title' => 'foobar']),
            new Item(['title' => 'spamham']),
        ];
        
        $section = Section::create([
            'type' => 'replace',
            'attribute' => 'title',
            'search' => 'a',
            'replace' => 'u',
        ]);
        
        $section->processFeed($feed);
        
        $this->assertCount(2, $feed->items);
        $this->assertSame('foobur', $feed->items[0]->title);
        $this->assertSame('spumhum', $feed->items[1]->title);
    }
    
    
    public function invalidConfigsProvider()
    {
        return [
            [['type' => 'replace']],
            [['type' => 'replace', 'attribute' => 'title', 'search' => 'a']],
            [['type' => 'replace', 'attribute' => 'title', 'replace' => 'u']],
            [['type' => 'replace', 'search' => 'a', 'replace' => 'u']],
            [['type' => 'replace', 'attribute' => 'asdas', 'search' => 'a', 'replace' => 'u']],
            [['type' => 'replace', 'attribute' => [], 'search' => 'a', 'replace' => 'u']],
            [['type' => 'replace', 'attribute' => 'title', 'search' => [], 'replace' => 'u']],
            [['type' => 'replace', 'attribute' => 'title', 'search' => 'a', 'replace' => []]],
        ];
    }
    
    /**
     * @dataProvider invalidConfigsProvider
     * @param type $config
     * @expectedException Assert\InvalidArgumentException
     */
    public function testInvalidConfig($config)
    {
        Section::create($config);
    }
}

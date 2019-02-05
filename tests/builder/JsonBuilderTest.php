<?php

declare(strict_types=1);

namespace tests\builder;

use PHPUnit\Framework\TestCase;
use rsspipes\builder\JsonBuilder;
use rsspipes\rss\Feed;
use rsspipes\rss\Item;

/**
 * @see JsonBuilder
 */
class JsonBuilderTest extends TestCase
{
    public function testSomething()
    {
        $feed = new Feed();
        $feed->items = [
            new Item([
                'title' => 'foobar',
                'link' => 'https://rss.test/1',
                'description' => "Foo<br/>\nBar",
            ]),
            new Item([
                'title' => 'spamham',
                'link' => 'https://rss.test/2',
                'description' => "Spam<br/>\nHam",
            ]),
        ];

        $result = (new JsonBuilder())->buildFeed($feed);

        $expected = <<<TXT
{
    "items": [
        {
            "guid": null,
            "pubDate": null,
            "title": "foobar",
            "link": "https:\/\/rss.test\/1",
            "description": "Foo<br\/>\\nBar",
            "comments": null
        },
        {
            "guid": null,
            "pubDate": null,
            "title": "spamham",
            "link": "https:\/\/rss.test\/2",
            "description": "Spam<br\/>\\nHam",
            "comments": null
        }
    ]
}
TXT;
        $this->assertEquals($expected, $result);
    }
}

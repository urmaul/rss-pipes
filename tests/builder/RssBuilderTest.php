<?php

declare(strict_types=1);

namespace tests\builder;

use PHPUnit\Framework\TestCase;
use rsspipes\builder\RssBuilder;
use rsspipes\rss\Feed;
use rsspipes\rss\Item;

/**
 * @see RssBuilder
 */
class RssBuilderTest extends TestCase
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

        $result = (new RssBuilder())->buildFeed($feed);

        $expected = <<<TXT
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0"><channel><item><guid/><pubDate/><title>foobar</title><link>https://rss.test/1</link><description>Foo&lt;br/&gt;
Bar</description><comments/></item><item><guid/><pubDate/><title>spamham</title><link>https://rss.test/2</link><description>Spam&lt;br/&gt;
Ham</description><comments/></item></channel></rss>

TXT;
        $this->assertEquals($expected, $result);
    }
}
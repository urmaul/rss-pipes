<?php

namespace rsspipestests\sections;

use rsspipes\Controller;
use rsspipes\rss\Feed;
use rsspipes\sections\Rss;

class RssTest extends \PHPUnit_Framework_TestCase
{
    public function testRead()
    {
        $rss = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	>

<channel>
	<title>Qwasd.ru - flash игры бесплатно</title>
	<atom:link href="http://www.qwasd.ru/feed/" rel="self" type="application/rss+xml" />
	<link>http://www.qwasd.ru</link>
	<description>Онлайн flash игры играть бесплатно и без регистрации</description>
	<lastBuildDate>Fri, 24 Jul 2015 06:15:54 +0000</lastBuildDate>
	<language></language>
	<sy:updatePeriod>daily</sy:updatePeriod>
	<sy:updateFrequency>1</sy:updateFrequency>
		<item>
		<title>Денежные создатели</title>
		<link>http://www.qwasd.ru/business/money-makers/</link>
				<pubDate>Fri, 24 Jul 2015 03:13:36 +0000</pubDate>
		<dc:creator>Qwasd.ru</dc:creator>
				<category><![CDATA[Бизнес]]></category>
		<category><![CDATA[бизнес]]></category>
		<category><![CDATA[головоломки]]></category>
		<category><![CDATA[деньги]]></category>
		<category><![CDATA[задания]]></category>
		<category><![CDATA[игры с достижениями]]></category>
		<category><![CDATA[логика]]></category>
		<category><![CDATA[развитие персонажа]]></category>

		<guid isPermaLink="false">http://www.qwasd.ru/?p=9252</guid>
<description><![CDATA[<div style="min-height: 90px;">
<a href="http://www.qwasd.ru/business/money-makers/"><img src="http://cf.qwasd.ru/t/money-makers.jpeg" style="float:left;" width="120" height="90" alt="Денежные создатели" /></a>
<div style="margin-left: 128px">
Вы очутились в большом городе, где люди делают деньги. Начните зарабатывать на простых заданиях. Затем после накопление опыта и различных знаний, вы сможете выполнять более серьезные поручения за хорошие деньги. <br />
<a href="http://www.qwasd.ru/business/money-makers/">Играть в "Денежные создатели" &raquo;</a>
</div>
</div>]]></description>		</item>
		<item>
		<title>Микрики</title>
		<link>http://www.qwasd.ru/puzzles/micrics/</link>
				<pubDate>Fri, 24 Jul 2015 03:12:39 +0000</pubDate>
		<dc:creator>Qwasd.ru</dc:creator>
				<category><![CDATA[Головоломки]]></category>
		<category><![CDATA[головоломки]]></category>
		<category><![CDATA[игры с достижениями]]></category>
		<category><![CDATA[логика]]></category>
		<category><![CDATA[монстры]]></category>
		<category><![CDATA[фигуры]]></category>
		<category><![CDATA[цвета]]></category>

		<guid isPermaLink="false">http://www.qwasd.ru/?p=9250</guid>
<description><![CDATA[<div style="min-height: 90px;">
<a href="http://www.qwasd.ru/puzzles/micrics/"><img src="http://cf.qwasd.ru/t/micrics.png" style="float:left;" width="120" height="90" alt="Микрики" /></a>
<div style="margin-left: 128px">
В этой головоломке вам придется спасать организм от вирусов. С помощью различных блоков создавайте платформы, под которыми раздавливайте различные микробы. <br />
<a href="http://www.qwasd.ru/puzzles/micrics/">Играть в "Микрики" &raquo;</a>
</div>
</div>]]></description>		</item>
	</channel>
</rss>
XML;
        
        $section = new Rss();
        $feed = new Feed();
        
        $section->parseBody($rss, $feed);
        
        $this->assertSame('Qwasd.ru - flash игры бесплатно', $feed->metadata['title']);
        $this->assertSame('Онлайн flash игры играть бесплатно и без регистрации', $feed->metadata['description']);
        $this->assertCount(2, $feed->items);
        $this->assertSame('Денежные создатели', $feed->items[0]->title);
        $this->assertSame('http://www.qwasd.ru/business/money-makers/', $feed->items[0]->link);
        $this->assertSame('Микрики', $feed->items[1]->title);
        $this->assertSame('http://www.qwasd.ru/puzzles/micrics/', $feed->items[1]->link);
        $this->assertSame('<div style="min-height: 90px;">
<a href="http://www.qwasd.ru/puzzles/micrics/"><img src="http://cf.qwasd.ru/t/micrics.png" style="float:left;" width="120" height="90" alt="Микрики" /></a>
<div style="margin-left: 128px">
В этой головоломке вам придется спасать организм от вирусов. С помощью различных блоков создавайте платформы, под которыми раздавливайте различные микробы. <br />
<a href="http://www.qwasd.ru/puzzles/micrics/">Играть в "Микрики" &raquo;</a>
</div>
</div>', $feed->items[1]->description);
    }
    
    public function testDownloadFailed()
    {
        $section = new Rss();
        $section->url = 'invalid';
        $feed = new Feed();
        
        $section->processFeed($feed);
        
        $this->assertCount(1, $feed->items);
        $this->assertStringMatchesFormat('Could%A resolve host: invalid', $feed->items[0]->title);
        $this->assertEquals('invalid', $feed->items[0]->link);
    }
    
    public function testDownloadFailedQuitet()
    {
        $section = new Rss();
        $section->url = 'invalid';
        $section->showErrors = 0;
        $feed = new Feed();
        
        $section->processFeed($feed);
        
        $this->assertEmpty($feed->items);
    }
}

<?php

namespace rsspipestests\sections;

use rsspipes\Controller;
use rsspipes\rss\Feed;
use rsspipes\sections\Atom;

class AtomTest extends \PHPUnit_Framework_TestCase
{
    public function testRead()
    {
        $atom = <<<XML
<?xml version="1.0" encoding="utf-8"?>
<feed xmlns="http://www.w3.org/2005/Atom">

  <title><![CDATA[Радио-Т Подкаст]]></title>
  <link href="http://www.radio-t.com/atom.xml" rel="self"/>
  <link href="http://www.radio-t.com/"/>
  <updated>2015-07-21T20:47:05+00:00</updated>
  <id>http://www.radio-t.com/</id>
  <author>
    <name><![CDATA[podcast@radio-t.com]]></name>
    
  </author>
  <generator uri="http://octopress.org/">Octopress</generator>
  <language>ru</language>
  <description>IT подкаст выходного дня</description>

  <entry>
    <title type="html"><![CDATA[Темы для 453]]></title>
    <link href="http://www.radio-t.com/p/2015/07/14/prep-453/"/>
    <updated>2015-07-14T15:45:00+00:00</updated>
    <id>http://www.radio-t.com/p/2015/07/14/prep-453</id>
    <content type="html"><![CDATA[
]]></content>
  </entry>
  
  <entry>
    <title type="html"><![CDATA[Радио-Т 452]]></title>
    <link href="http://www.radio-t.com/p/2015/07/11/podcast-452/"/>
    <updated>2015-07-11T18:27:00+00:00</updated>
    <id>http://www.radio-t.com/p/2015/07/11/podcast-452</id>
    <content type="html"><![CDATA[<p><img src="http://www.radio-t.com/images/radio-t/rt452.jpg" alt="" /></p>

<ul>
<li><a href="http://gizmodo.com/linux-creator-linus-torvalds-laughs-at-the-ai-apocalyps-1716383135">Линус о наступление AI</a>.</li>
<li><a href="http://arstechnica.com/security/2015/07/simultaneous-downing-of-ny-stock-exchange-united-and-wsj-com-rattle-nerves/">Все упало и сразу</a>.</li>
<li><a href="https://aws.amazon.com/blogs/aws/amazon-api-gateway-build-and-run-scalable-application-backends/">Amazon API Gateway</a></li>
<li><a href="http://www.wired.com/2015/07/microsoft-phone-job-cuts/">MS проиграла еще одну войну</a>.</li>
<li><a href="http://prsm.tc/zuB9PL">Azure в 4 раза дороже?</a></li>
<li><a href="https://www.kickstarter.com/projects/dickhardt/dc2-desktop-container-computer-for-docker-containe">DC2 - на вид как контейнер</a>.</li>
<li>Темы наших слушателей.</li>
</ul>


<p><em>Спонсор этого выпуска <a href="https://www.digitalocean.com">DigitalOcean</a></em></p>

<p><a href="http://cdn.radio-t.com/rt_podcast452.mp3">аудио</a> ● <a href="http://chat.radio-t.com/logs/radio-t-452.html">лог чата</a>
<audio src="http://cdn.radio-t.com/rt_podcast452.mp3" preload="none"></audio></p>
]]></content>
  </entry>
  
</feed>
XML;
        
        $section = new Atom();
        $feed = new Feed();
        
        $section->parseBody($atom, $feed);
        
        $this->assertSame('Радио-Т Подкаст', $feed->metadata['title']);
        $this->assertSame('IT подкаст выходного дня', $feed->metadata['description']);
        $this->assertCount(2, $feed->items);
        $this->assertSame('Темы для 453', $feed->items[0]->title);
        $this->assertSame('http://www.radio-t.com/p/2015/07/14/prep-453/', $feed->items[0]->link);
        $this->assertSame('http://www.radio-t.com/p/2015/07/14/prep-453', $feed->items[0]->guid);
        $this->assertSame('Tue, 14 Jul 15 15:45:00 +0000', $feed->items[0]->pubDate);
        $this->assertArrayNotHasKey('updated', $feed->items[0]->attributes);
        $this->assertSame('Радио-Т 452', $feed->items[1]->title);
        $this->assertSame('http://www.radio-t.com/p/2015/07/11/podcast-452/', $feed->items[1]->link);
        $this->assertSame('http://www.radio-t.com/p/2015/07/11/podcast-452', $feed->items[1]->guid);
        $this->assertSame('<p><img src="http://www.radio-t.com/images/radio-t/rt452.jpg" alt="" /></p>

<ul>
<li><a href="http://gizmodo.com/linux-creator-linus-torvalds-laughs-at-the-ai-apocalyps-1716383135">Линус о наступление AI</a>.</li>
<li><a href="http://arstechnica.com/security/2015/07/simultaneous-downing-of-ny-stock-exchange-united-and-wsj-com-rattle-nerves/">Все упало и сразу</a>.</li>
<li><a href="https://aws.amazon.com/blogs/aws/amazon-api-gateway-build-and-run-scalable-application-backends/">Amazon API Gateway</a></li>
<li><a href="http://www.wired.com/2015/07/microsoft-phone-job-cuts/">MS проиграла еще одну войну</a>.</li>
<li><a href="http://prsm.tc/zuB9PL">Azure в 4 раза дороже?</a></li>
<li><a href="https://www.kickstarter.com/projects/dickhardt/dc2-desktop-container-computer-for-docker-containe">DC2 - на вид как контейнер</a>.</li>
<li>Темы наших слушателей.</li>
</ul>


<p><em>Спонсор этого выпуска <a href="https://www.digitalocean.com">DigitalOcean</a></em></p>

<p><a href="http://cdn.radio-t.com/rt_podcast452.mp3">аудио</a> ● <a href="http://chat.radio-t.com/logs/radio-t-452.html">лог чата</a>
<audio src="http://cdn.radio-t.com/rt_podcast452.mp3" preload="none"></audio></p>
', $feed->items[1]->description);
        $this->assertSame('Tue, 14 Jul 15 15:45:00 +0000', $feed->items[0]->pubDate);
        $this->assertArrayNotHasKey('updated', $feed->items[0]->attributes);

    }
}

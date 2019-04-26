<?php

use Crawler\Crawler;
use Crawler\UrlsMemoryQueue;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophet;

/**
 * @property Prophet $prophet
 */

class CrawlerProcessFilterTest extends TestCase
{
    private $prophet;

    const url = 'http://url.com';

    public function testProcessInvokedIfPageNotFiltered()
    {
        $queue = new UrlsMemoryQueue([self::url]);
        $processor = $this->prophet->prophesize('Crawler\Processor');
        $fetcher = $this->prophet->prophesize('Crawler\Fetcher');

        $fetcher->fetch(self::url)->willReturn('content');
        $processor->filter(self::url)->willReturn(true);
        $processor->process('content', self::url)->shouldBeCalled();

        $crawler = new Crawler();
        $crawler->setProcessor($processor->reveal());
        $crawler->setFetcher($fetcher->reveal());
        $crawler->setQueue($queue);
        $crawler->crawl(0);
    }

    public function testProcessNotInvokedIfPageFiltered()
    {
        $queue = new UrlsMemoryQueue([self::url]);
        $processor = $this->prophet->prophesize('Crawler\Processor');
        $fetcher = $this->prophet->prophesize('Crawler\Fetcher');

        $fetcher->fetch(self::url)->willReturn('content');
        $processor->filter(self::url)->willReturn(false);
        $processor->process('content', self::url)->shouldNotBeCalled();

        $crawler = new Crawler();
        $crawler->setProcessor($processor->reveal());
        $crawler->setFetcher($fetcher->reveal());
        $crawler->setQueue($queue);
        $crawler->crawl(0);
    }

    protected function setUp(): void
    {
        $this->prophet = new Prophet;
    }

    protected function tearDown(): void
    {
        $this->prophet->checkPredictions();
        $this->assertTrue(true);
    }
}

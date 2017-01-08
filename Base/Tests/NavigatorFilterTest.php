<?php

use Crawler\Crawler;

class NavigatorFilterTest extends PHPUnit_Framework_TestCase
{
    private $prophet;

    const url = 'http://url.com';
    const urlPass = 'http://url.com/pass';
    const urlFail = 'http://url.com/fail';

    public function testProcessInvokedIfPageNotFiltered()
    {
        $queue = $this->prophet->prophesize('Crawler\UrlsMemoryQueue');
        $fetcher = $this->prophet->prophesize('Crawler\Fetcher');

        $fetcher->fetch(self::url)->willReturn('<a href="pass">link</a>');
        $queue->processedUrl(self::url)->shouldBeCalled();
        $queue->addUrl(self::urlPass)->shouldBeCalled();
        $queue->getUrl()->willReturn(self::url, null);

        $crawler = new Crawler();
        $crawler->setFetcher($fetcher->reveal());
        $crawler->setQueue($queue->reveal());
        $crawler->crawl(0);
    }

    protected function setup()
    {
        $this->prophet = new \Prophecy\Prophet;
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}

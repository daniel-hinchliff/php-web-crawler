<?php

include 'Logger.php';
include 'UrlsQueue.php';
include 'UrlsMemoryQueue.php';
include 'UrlsDatabaseQueue.php';
include 'Fetcher.php';
include 'SeleniumFetcher.php';
include 'Processor.php';
include 'Navigator.php';
include 'UrlExtractor.php';

class Crawler
{
    protected $queue;
    protected $logger;
    protected $fetcher;
    protected $processor;
    protected $navigator;
    protected $url_extractor;

    public function crawl($pace)
    {
        // Hook up components
        $this->fetcher->queue = $this->queue;
        $this->fetcher->processor = $this->processor;
        $this->processor->url_extractor = $this->url_extractor;
        $this->url_extractor->navigator = $this->navigator;
        $this->navigator->queue = $this->queue;

        // Start crawl
        $this->fetcher->fetch($pace);
    }

    public function setQueue($queue)
    {
        $this->queue = $queue;
    }

    public function setFetcher($fetcher)
    {
        $this->fetcher = $fetcher;
    }

    public function setProcessor($processor)
    {
        $this->processor = $processor;
    }

    public function setUrlExtractor($url_extractor)
    {
        $this->url_extractor = $url_extractor;
    }

    public function setNavigator($navigator)
    {
        $this->navigator = $navigator;
    }

    public function setLogger($logger)
    {
        $this->logger = $logger;
    }
}

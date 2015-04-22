<?php

include 'UrlsQueue.php';
include 'UrlsMemoryQueue.php';
include 'UrlsDatabaseQueue.php';
include 'Fetcher.php';
include 'Processor.php';
include 'Navigator.php';
include 'UrlExtractor.php';

class Crawler
{
    public $queue;
    public $fetcher;
    public $processor;
    public $url_extractor;
    public $navigator;

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
}

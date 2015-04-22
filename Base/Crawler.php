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
        $this->initialize();
        
        while ($url = $this->queue->getUrl())
        {
            $this->processUrl($url);
            $this->sleep($pace);
        }
    }

    protected function sleep($seconds)
    {
        for($i = 0; $i < $seconds; $i++)
        {
            echo '. '; sleep(1);
        }

        echo "\n";
    }
    
    protected function initialize()
    {
        $this->fetcher = $this->fetcher ?: new Fetcher();
        $this->queue = $this->queue ?: new UrlsMemoryQueue();
        $this->navigator = $this->navigator ?: new Navigator();
        $this->processor = $this->processor ?: new Processor();
        $this->url_extractor = $this->url_extractor ?: new UrlExtractor;
    }

    protected function processUrl($url)
    {
        $content = $this->fetcher->fetch($url);
        $this->logger && $this->logger->log($url, $content);
        $this->processContent($url, $content);
        $this->queue->processedUrl($url);
    }

    protected function processContent($url, $content)
    {
        $this->processor->filter($url) &&
        $this->processor->process($content, $url);
        $urls = $this->url_extractor->extract($content, $url);

        foreach ($this->navigator->filter($urls, $url) as $passed_url)
        {
            $this->queue->addUrl($passed_url);
        }
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

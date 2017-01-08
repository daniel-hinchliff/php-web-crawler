<?php

namespace Crawler;

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
        if ($this->processor->filter($url))
        {
            $this->processor->process($content, $url);
        }

        foreach ($this->url_extractor->extract($content, $url) as $link)
        {
            if($this->navigator->filter($link, $url))
            {
                $this->queue->addUrl($link);
            }
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

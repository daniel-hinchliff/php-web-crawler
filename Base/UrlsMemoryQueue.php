<?php

namespace Crawler;

class UrlsMemoryQueue implements UrlsQueue
{
    protected $queue;
    protected $log;

    public function __construct($urls = array())
    {
        $this->queue = $urls;
        $this->log = array();
    }

    public function getUrl()
    {
        return array_pop($this->queue);
    }
    
    public function addUrl($url)
    {
        if(in_array($url, $this->log) == false)
        {
            $this->queue[] = $url;
        }

        $this->log[] = $url;
    }

    public function processedUrl($url)
    {

    }
}

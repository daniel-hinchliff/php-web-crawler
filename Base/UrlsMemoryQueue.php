<?php

class UrlsMemoryQueue implements UrlsQueue
{
    private $queue;
    private $log;

    public function  __construct($urls = array())
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
        if(in_array($url, $this->log) == FALSE)
        {
            $this->queue[] = $url;
        }

        $this->log[] = $url;
    }

    public function processedUrl($url)
    {

    }
}

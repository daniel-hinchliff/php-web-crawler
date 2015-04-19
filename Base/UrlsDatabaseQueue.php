<?php

class UrlsDatabaseQueue implements UrlsQueue
{
    private $crawl_id;

    public function  __construct($crawl_id, $urls = array())
    {
        $this->crawl_id = $crawl_id;

        foreach ($urls as $url)
        {
            Url::saveUrl($url, $crawl_id);
        }
    }

    public function getUrl()
    {
        return Url::getPendingUrl($this->crawl_id);
    }

    public function addUrl($url)
    {
        Url::saveUrl($url, $this->crawl_id);
    }

    public function processedUrl($url)
    {
        Url::updateUrlState($this->crawl_id, $url, 'C');
    }
}

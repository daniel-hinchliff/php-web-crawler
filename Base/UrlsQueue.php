<?php

interface UrlsQueue
{
    public function getUrl();
    
    public function addUrl($url);

    public function processedUrl($url);
}
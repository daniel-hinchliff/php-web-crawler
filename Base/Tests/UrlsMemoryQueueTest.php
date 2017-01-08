<?php

use Crawler\UrlsMemoryQueue;

class UrlsMemoryQueueTest extends PHPUnit_Framework_TestCase
{
    public function testEmptyQueue()
    {
        $queue = new UrlsMemoryQueue();

        $this->assertNull($queue->getUrl());
    }
}

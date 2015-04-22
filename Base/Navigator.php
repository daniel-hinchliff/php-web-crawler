<?php

class Navigator
{
    public $queue;

    public function filter($urls, $current_url)
    {
        foreach($urls as $url)
        {
            if ($this->test($url, $current_url))
            {
                $this->queue->addUrl($url);
            }
        }
    }

    public function test(&$url, $current_url)
    {
        // Choose urls to follow ... override this method.
        // You may alter $url to take shortcuts for example.
        return TRUE;
    }
}

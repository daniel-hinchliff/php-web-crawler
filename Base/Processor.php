<?php

namespace Crawler;

class Processor
{
    public function filter($url)
    {
        // Decide whether to extract data from this page or not
        // Override this method.
        return TRUE;
    }

    public function process($content, $current_url)
    {
        // Here is where you extract useful data.
        // Override this method.
    }
}

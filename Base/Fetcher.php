<?php

namespace Crawler;

class Fetcher
{
    public function fetch($url)
    {
        echo "Fetching ", $url, "\n";

        return @file_get_contents($url);
    }
}


<?php

namespace Crawler;

class Fetcher
{
    public function fetch($url)
    {
        echo "Fetching ", $url, "\n";

        $content = @file_get_contents($url);

        $content !== false or $this->error($url);

        return $content;
    }

    protected function error($url)
    {
        throw new \Exception("Could not fetch [$url]");
    }
}


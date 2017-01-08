<?php

namespace Crawler;

class Navigator
{
    public function filter(&$url, $current_url)
    {
        // Choose urls to follow ... override this method.
        // You may alter $url to take shortcuts for example.
        return TRUE;
    }
}

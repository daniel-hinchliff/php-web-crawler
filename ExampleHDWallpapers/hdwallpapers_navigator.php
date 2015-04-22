<?php

class HDWallpapersNavigator extends Navigator
{
    public function isListingPage($url)
    {
        return preg_match(ListingPagePattern, $url);
    }

    public function isWallpaperPage($url)
    {
        return preg_match(WallpaperPagePattern, $url);
    }

    public function test(&$url, $current_url)
    {
        return $this->isListingPage($current_url) && $this->isWallpaperPage($url);
    }
}

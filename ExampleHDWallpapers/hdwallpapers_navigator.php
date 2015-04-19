<?php

class HDWallpapersNavigator extends Navigator
{
    public function test(&$url, $current_url)
    {
        // Only follow links on listing pages
        if (preg_match("/^http:\/\/(www\.)?hdwallpapers\.in\/(top|latest).*\/page\//", $current_url) == 1)
        {
            // Only follow links to wallpapers
            if (preg_match("/^http:\/\/(www\.)?hdwallpapers\.in\/[^-]*-wallpapers.html/", $url) == 1)
                return TRUE;
        }

        return FALSE;
    }
}

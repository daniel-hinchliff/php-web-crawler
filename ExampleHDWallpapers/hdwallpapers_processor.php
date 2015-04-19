<?php

class HDWallpapersProcessor extends Processor
{
    public function doProcess($content, $current_url)
    {
        if (preg_match("/^http:\/\/(www\.)?hdwallpapers\.in\/.*-wallpapers.html/", $current_url) != 1)
            return;
        
        // Extract wallpaper info

        $wp = new Wallpaper();
        $wp->page= $current_url;

        if (preg_match("/<h1.*>(.*)<\/h1>/", $content, $matches) == 1)
            $wp->title = $matches[1];

        if (preg_match("/href=\"([^\"]*)\" [^>]*>Original<\/a>/", $content, $matches) == 1)
            $wp->url = "http://hdwallpapers.in" . $matches[1];

        if (preg_match_all("/href=\"\/tag\/[^\"]*\" [^>]*>([^<]*)<\/a>/", $content, $matches) > 0)
            $wp->tags = implode (", ", $matches[1]);

        if (preg_match("/<span class=\"author-tag\"><a [^>]*href=\"([^\"]*)\"[^>]*>([^<]*)<\/a><\/span>/", $content, $matches) == 1)
            $wp->source = $matches[2] . " - " . $matches[1];

        if (preg_match("/^http:\/\/(www\.)?hdwallpapers\.in\/(.*)-wallpapers.html/", $current_url, $matches) == 1)
        {
            $wp->filename = "hdwallpapers_" . $matches[2] . ".jpg";
        }

        // Retrieve and store wallpaper

        if ($wp->filename != null and $wp->url != null)
        {
            $wp->download();
        }
    }
}


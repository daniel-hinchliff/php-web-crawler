<?php

namespace HDWallpapers;

class Processor extends \Crawler\Processor
{
    public function filter($url)
    {
        return preg_match(WallpaperPagePattern, $url);
    }

    public function process($content, $current_url)
    {
        $wp = new Wallpaper();
        
        $wp->page = $current_url;

        if (preg_match("/<h1.*>(.*)<\/h1>/", $content, $matches) == 1)
            $wp->title = $matches[1];

        if (preg_match("/href=\"([^\"]*)\" [^>]*><b>Original<\/b><\/a>/", $content, $matches) == 1)
            $wp->url = "http://hdwallpapers.in" . $matches[1];

        if (preg_match_all("/href=\"\/tag\/[^\"]*\" [^>]*>([^<]*)<\/a>/", $content, $matches) > 0)
            $wp->tags = implode (", ", $matches[1]);

        if (preg_match("/<span class=\"author-tag\"><a [^>]*href=\"([^\"]*)\"[^>]*>([^<]*)<\/a><\/span>/", $content, $matches) == 1)
            $wp->source = $matches[2] . " - " . $matches[1];

        if (preg_match("/^http:\/\/(www\.)?hdwallpapers\.in\/(.*)-wallpapers.html/", $current_url, $matches) == 1)
            $wp->filename = "hdwallpapers_" . $matches[2] . ".jpg";

        if ($wp->filename != null and $wp->url != null)
            $wp->download();
    }
}


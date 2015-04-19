<?php

class UrlExtractor
{
    public $navigator;

    public function extract($content, $current_url)
    {
        $parse = parse_url($current_url);

        $site = $parse['scheme'] . "://" . $parse['host'];
        
        $path = $site . $parse['path'];

        preg_match_all ("/a[\s]+[^>]*?href[\s]?=[\s\"\']+(.*?)[\"\']+.*?>/",
                        $content, $links);

        $links = $links[1];

        $urls = array();

        foreach ($links as $link)
        {
            if (preg_match("/^http.*/", $link) == 1)
            {
                $urls[] = $link;
            }
            else if (preg_match("/^\/.*/", $link) == 1)
            {
                $urls[] = $site . $link;
            }
            else
            {
                $urls[] = $path . $link;
            }
        }

        $this->navigator->filter($urls, $current_url);
    }
}

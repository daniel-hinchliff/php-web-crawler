<?php

namespace HDWallpapers;

class Wallpaper
{
    public $title;
    public $tags;
    public $url;
    public $source;
    public $page;
    public $filename;
    public $date;

    public function printInfo()
    {
        echo "Title:    ", $this->title,    "\n";
        echo "Page:     ", $this->page,     "\n";
        echo "Url:      ", $this->url,      "\n";
        echo "Tags:     ", $this->tags,     "\n";
        echo "Source:   ", $this->source,   "\n";
        echo "Filename: ", $this->filename, "\n";
    }
 
    public function download()
    {
        $this->printInfo();
        
        $content = file_get_contents($this->url);

        if ($content == FALSE)
        {
            echo "Error downloading wallpaper at $this->url \n";
        }
        
        file_put_contents(__DIR__ . '/Downloads/' . $this->filename, $content);
    }
}

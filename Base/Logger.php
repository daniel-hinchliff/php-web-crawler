<?php

namespace Crawler;

class Logger
{
    protected $directory;

    public function __construct($log_directory)
    {
        $this->directory = $log_directory;
    }

    public function log($url, $content)
    {
        $filename = date('Y-m-d-H-i-s-') . $this->sanitizeFilename($url);

        file_put_contents("$this->directory/$filename.html", $content);
    }

    protected function sanitizeFilename($filename)
    {
        return preg_replace('/[^a-zA-Z0-9-_\.]/','', $filename);
    }
}

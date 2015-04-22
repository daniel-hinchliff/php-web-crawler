<?php

define ('CRAWLER_LOG_DIR', 'D:/logs/scrapers');

class Fetcher
{
    public $queue;
    public $processor;

    public function fetch($pace)
    {
        $url = $this->queue->getUrl();

        while ($url != null)
        {
            echo "Fetching ", $url, "\n";

            $content = @file_get_contents($url);

            if ($content != FALSE)
            {
                $this->logContent($url, $content);
                
                $this->processor->process($content, $url);
            }
            
            $this->queue->processedUrl($url);

            for($i = 0; $i < $pace; $i++)
            {
                echo '. '; sleep(1);
            }
            
            echo "\n";

            $url = $this->queue->getUrl();
        }
    }
    
    private function logContent($url, $content)
    {
        $filename = date('Y-m-d-H-i-s-') . $this->sanitizeFilename($url);

        file_put_contents(CRAWLER_LOG_DIR . "/$filename.html", $content);
    }
    
    private function sanitizeFilename($filename)
    {
        return preg_replace('/[^a-zA-Z0-9-_\.]/','', $filename);
    }
}


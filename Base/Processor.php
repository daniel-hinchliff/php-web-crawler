<?php

class Processor
{
    public $url_extractor;

    public function process($content, $current_url)
    {
        $this->url_extractor->extract($content, $current_url);

        $this->doProcess($content, $current_url);
    }

    protected function doProcess($content, $current_url)
    {
        // Here is where you extract useful data.
        // Override this method.
    }
}

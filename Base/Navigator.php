<?php

class Navigator
{
    public $feeder;

    public function filter($urls, $current_url)
    {
        foreach($urls as $url)
        {
            if ($this->test($url, $current_url))
            {
                $this->feeder->addUrl($url);
            }
        }
    }

    public function test(&$url, $current_url)
    {
        // Choose urls to follow ... override this method
        return TRUE;
    }
}

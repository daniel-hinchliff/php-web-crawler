<?php

class Navigator
{
    public function filter($urls, $current_url)
    {
        $passed = array();

        foreach($urls as $url)
        {
            if ($this->test($url, $current_url))
            {
                $passed[]= $url;
            }
        }

        return $passed;
    }

    public function test(&$url, $current_url)
    {
        // Choose urls to follow ... override this method.
        // You may alter $url to take shortcuts for example.
        return TRUE;
    }
}

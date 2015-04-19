<?php

class Url
{
    static function saveUrl($url, $crawl_id)
    {
        $url = mysql_real_escape_string($url);
        
        $query = " insert into urls 
                   (Url, CrawlId, Date, State) values
                   ('$url', '$crawl_id', now(), 'P' )";

        mysql_query($query);
    }

    static function updateUrlState($crawl_id, $url, $state)
    {
        $url = mysql_real_escape_string($url);
        
        $query = " update urls set State='$state' 
                   where CrawlId='$crawl_id' and url= '$url'";

        mysql_query($query);
    }

    static function getPendingUrl($crawl_id)
    {
        $query= " select url from urls 
                  where State='P' and CrawlId='$crawl_id' 
                  limit 1 ";

        $result = mysql_query($query);

        if (mysql_num_rows($result) == 0) return null;

        $row = mysql_fetch_assoc($result);

        return $row['url'];
    }
}

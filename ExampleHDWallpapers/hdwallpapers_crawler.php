<?php

include '../Base/Crawler.php';
include 'hdwallpapers_navigator.php';
include 'hdwallpapers_processor.php';
include 'wallpaper.php';

$urls = array();

for ($i=1; $i <= 20; $i++)
{
    $urls[] = "http://www.hdwallpapers.in/top_view_wallpapers/page/$i";
    $urls[] = "http://www.hdwallpapers.in/latest_wallpapers/page/$i";
}

$crawler = new Crawler();
$crawler->setQueue(new UrlsMemoryQueue($urls));
$crawler->setProcessor(new HDWallpapersProcessor());
$crawler->setNavigator(new HDWallpapersNavigator());
$crawler->crawl(5);



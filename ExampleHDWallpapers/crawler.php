<?php

include '../vendor/autoload.php';

use Crawler\Crawler;
use Crawler\UrlsMemoryQueue;
use HDWallpapers\Processor;
use HDWallpapers\Navigator;

define('ListingPagePattern', "/^http:\/\/(www\.)?hdwallpapers\.in\/(top|latest).*\/page\//");
define('WallpaperPagePattern', "/^http:\/\/(www\.)?hdwallpapers\.in\/[^-]*-wallpapers.html/");

$urls = array();

for ($i=1; $i <= 20; $i++)
{
    $urls[] = "http://www.hdwallpapers.in/top_view_wallpapers/page/$i";
    $urls[] = "http://www.hdwallpapers.in/latest_wallpapers/page/$i";
}

$crawler = new Crawler();
$crawler->setQueue(new UrlsMemoryQueue($urls));
$crawler->setProcessor(new Processor());
$crawler->setNavigator(new Navigator());
$crawler->crawl(5);



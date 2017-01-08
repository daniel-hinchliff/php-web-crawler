<?php

use Crawler\UrlExtractor;

class UrlExtractorTest extends PHPUnit_Framework_TestCase
{
    const urlRoot = 'http://url.com';
    const urlNotRoot = 'http://url.com/path';
    const noLinksContent = 'This is some text';

    public function testNoLinks()
    {
        $extractor = new UrlExtractor();
        $urls = $extractor->extract(self::noLinksContent, self::urlRoot);
        $this->assertEmpty($urls);
    }
}

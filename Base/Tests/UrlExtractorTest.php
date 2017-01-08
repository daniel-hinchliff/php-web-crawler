<?php

use Crawler\UrlExtractor;

class UrlExtractorTest extends PHPUnit_Framework_TestCase
{
    const urlRoot = 'http://url.com';
    const urlNotRoot = 'http://url.com/path';
    const noLinksContent = 'This is some text';
    const multipleLinksContent = '<a href="a">a</a> <a href="b">b</a>';

    public function testNoLinks()
    {
        $extractor = new UrlExtractor();
        $urls = $extractor->extract(self::noLinksContent, self::urlRoot);
        $this->assertEmpty($urls);
    }

    public function testMultipleLinks()
    {
        $extractor = new UrlExtractor();
        $urls = $extractor->extract(self::multipleLinksContent, self::urlRoot);
        $this->assertEquals(2, count($urls));
    }
}

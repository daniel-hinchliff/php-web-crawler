<?php

use Crawler\UrlExtractor;

class UrlExtractorTest extends PHPUnit_Framework_TestCase
{
    const urlRoot = 'http://url.com';
    const urlNotRoot = 'http://url.com/path';
    const noLinksContent = 'This is some text';
    const multipleLinksContent = '<a href="a">a</a> <a href="b">b</a>';
    const repeatedLinksContent = '<a href="a">a</a> <a href="a">b</a>';
    const absoluteLinksContent = '<a href="http://web/page">a</a>';

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

    public function testLinksAreUnique()
    {
        $extractor = new UrlExtractor();
        $urls = $extractor->extract(self::repeatedLinksContent, self::urlRoot);
        $this->assertEquals(1, count($urls));
    }

    public function testAbsoluteLinks()
    {
        $extractor = new UrlExtractor();
        $urls = $extractor->extract(self::absoluteLinksContent, self::urlRoot);
        $this->assertEquals(['http://web/page'], $urls);
    }
}

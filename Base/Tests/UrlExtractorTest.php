<?php

use Crawler\UrlExtractor;

class UrlExtractorTest extends PHPUnit_Framework_TestCase
{
    const urlRoot = 'http://url.com';
    const urlNotRoot = 'http://url.com/some/path';
    const noLinksContent = 'This is some text';
    const multipleLinksContent = '<a href="a">a</a> <a href="b">b</a>';
    const repeatedLinksContent = '<a href="a">a</a> <a href="a">b</a>';
    const relativeLinksContent = '<a href="web/page">a</a>';
    const rootRelativeLinksContent = '<a href="/web/page">a</a>';

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

    public function testRootRelativeLinksAtRoot()
    {
        $extractor = new UrlExtractor();
        $urls = $extractor->extract(self::rootRelativeLinksContent, self::urlRoot);
        $this->assertEquals(['http://url.com/web/page'], $urls);
    }

    public function testRootRelativeLinksNotAtRoot()
    {
        $extractor = new UrlExtractor();
        $urls = $extractor->extract(self::rootRelativeLinksContent, self::urlNotRoot);
        $this->assertEquals(['http://url.com/web/page'], $urls);
    }

    public function testRelativeLinksAtRoot()
    {
        $extractor = new UrlExtractor();
        $urls = $extractor->extract(self::relativeLinksContent, self::urlRoot);
        $this->assertEquals(['http://url.com/web/page'], $urls);
    }

    public function testRelativeLinksNotAtRoot()
    {
        $extractor = new UrlExtractor();
        $urls = $extractor->extract(self::relativeLinksContent, self::urlNotRoot);
        $this->assertEquals(['http://url.com/some/web/page'], $urls);
    }
}

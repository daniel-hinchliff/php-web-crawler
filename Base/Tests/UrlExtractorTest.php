<?php

use Crawler\UrlExtractor;

class UrlExtractorTest extends PHPUnit_Framework_TestCase
{
    public function testNoLinks()
    {
        $links = [];
        $urls = $this->getUrlsFromPage('http://url.com', $links);
        $this->assertEmpty($urls);
    }

    public function testMultipleLinks()
    {
        $links = ['link_1', 'link_2'];
        $urls = $this->getUrlsFromPage('http://url.com', $links);
        $this->assertEquals(2, count($urls));
    }

    public function testLinksAreUnique()
    {
        $links = ['link', 'link'];
        $urls = $this->getUrlsFromPage('http://url.com', $links);
        $this->assertEquals(1, count($urls));
    }

    public function testStartWithSlashRelativeLinksAtRoot()
    {
        $links = ['/web/page'];
        $urls = $this->getUrlsFromPage('http://url.com', $links);
        $this->assertEquals(['http://url.com/web/page'], $urls);
    }

    public function testStartWithSlashRelativeLinksNotAtRoot()
    {
        $links = ['/web/page'];
        $urls = $this->getUrlsFromPage('http://url.com/some/path', $links);
        $this->assertEquals(['http://url.com/web/page'], $urls);
    }

    public function testRelativeLinksAtRoot()
    {
        $links = ['web/page'];
        $urls = $this->getUrlsFromPage('http://url.com', $links);
        $this->assertEquals(['http://url.com/web/page'], $urls);
    }

    public function testRelativeLinksNotAtRoot()
    {
        $links = ['web/page'];
        $urls = $this->getUrlsFromPage('http://url.com/some/path', $links);
        $this->assertEquals(['http://url.com/some/web/page'], $urls);
    }

    public function testRelativeLinksNotAtRootUrlEndsWithSlash()
    {
        $links = ['web/page'];
        $urls = $this->getUrlsFromPage('http://url.com/some/path/', $links);
        $this->assertEquals(['http://url.com/some/path/web/page'], $urls);
    }

    public function testAbsoluteLinks()
    {
        $links = ['http://web.com'];
        $urls = $this->getUrlsFromPage('http://url.com/some/path', $links);
        $this->assertEquals(['http://web.com'], $urls);
    }

    protected function getUrlsFromPage($url, $links)
    {
        return (new UrlExtractor())->extract($this->getContent($links), $url);
    }

    protected function getContent($links)
    {
        $html_links = '';

        foreach ($links as $link)
        {
            $html_links .= "<a href='$link'>text</a>";
        }

        return $html_links;
    }
}

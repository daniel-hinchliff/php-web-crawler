<?php

class UrlsDatabaseQueue implements UrlsQueue
{
    protected $pdo;
    protected $crawl_id;

    const stateQueued = 'Q';
    const stateProcessed = 'P';

    public function  __construct(PDO $pdo, $crawl_id, $urls = array())
    {
        $this->pdo = $pdo;
        $this->crawl_id = $crawl_id;

        $this->createQueue();
        
        foreach ($urls as $url)
        {
            $this->addUrl($url);
        }
    }

    public function getUrl()
    {
        $sql = "SELECT url FROM urls WHERE state = ? AND crawl_id = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array(self::stateQueued, $this->crawl_id));

        return $stmt->fetchColumn() ?: null;
    }

    public function addUrl($url)
    {
        $sql = "INSERT IGNORE INTO urls (url, crawl_id, state, date) VALUES (?, ?, ?, now())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array($url, $this->crawl_id, self::stateQueued));
    }

    public function processedUrl($url)
    {
        $sql = "UPDATE urls SET state = ? WHERE crawl_id = ? AND url = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array(self::stateProcessed, $this->crawl_id, $url));
    }

    protected function createQueue()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `urls` (
                `crawl_id` varchar(20) NOT NULL,
                `url` varchar(500) NOT NULL,
                `state` char(1) NOT NULL,
                `date` datetime NOT NULL,
                KEY (`crawl_id`,`state`),
                PRIMARY KEY (`url`)
              )";

        $this->pdo->prepare($sql)->execute();
    }
}

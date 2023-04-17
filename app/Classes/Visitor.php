<?php
require_once 'Database.php';
require_once 'Visit.php';

class Visitor
{
    private $ipAddress;
    private $userAgent;
    private $pageUrl;
    private $viewsCount;

    public function __construct()
    {
        $this->ipAddress = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);
        $this->userAgent = filter_var($_SERVER['HTTP_USER_AGENT'], FILTER_SANITIZE_STRING);
        $this->pageUrl = filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL);
        $this->viewsCount = 1;
    }

    public function logVisit()
    {
        $visit = VisitFactory::createVisit($this->ipAddress, $this->userAgent, $this->pageUrl);
        $visit->log($this->viewsCount);
        $this->viewsCount++;
    }
}

class VisitFactory
{
    public static function createVisit($ipAddress, $userAgent, $pageUrl): Visit
    {
        return new Visit($ipAddress, $userAgent, $pageUrl, Database::getInstance());
    }
}
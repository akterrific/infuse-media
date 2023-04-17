<?php
class Visit {
    private $ipAddress;
    private $userAgent;
    private $pageUrl;
    private $db;

    public function __construct(string $ipAddress, string $userAgent, string $pageUrl, PDO $db)
    {
        // Проверяем входные данные на корректность
        if (!filter_var($ipAddress, FILTER_VALIDATE_IP)) {
            throw new InvalidArgumentException('Invalid IP address');
        }
        if (strlen($userAgent) < 1) {
            throw new InvalidArgumentException('User agent cannot be empty');
        }
        if (strlen($pageUrl) < 1) {
            throw new InvalidArgumentException('Page URL cannot be empty');
        }

        $this->ipAddress = $ipAddress;
        $this->userAgent = $userAgent;
        $this->pageUrl = $pageUrl;
        $this->db = $db;
    }

    public function log(int $viewsCount): void
    {
        // Проверяем входные данные на корректность
        if ($viewsCount < 1) {
            throw new InvalidArgumentException('Invalid views count');
        }

        $query = 'SELECT * FROM visits WHERE ip_address = ? AND user_agent = ? AND page_url = ?';
        $stmt = $this->db->prepare($query);
        $stmt->execute([$this->ipAddress, $this->userAgent, $this->pageUrl]);
        $result = $stmt->fetch();

        if (!$result) {
            $query = 'INSERT INTO visits (ip_address, user_agent, view_date, page_url, views_count) VALUES (?, ?, NOW(), ?, ?)';
            $stmt = $this->db->prepare($query);
            $stmt->execute([$this->ipAddress, $this->userAgent, $this->pageUrl, $viewsCount]);
        } else {
            $query = 'UPDATE visits SET view_date = NOW(), views_count = ? WHERE id = ?';
            $stmt = $this->db->prepare($query);
            $stmt->execute([$viewsCount, $result['id']]);
        }
    }
}

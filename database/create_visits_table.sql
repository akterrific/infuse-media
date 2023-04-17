CREATE TABLE visits (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(255) NOT NULL,
    user_agent TEXT NOT NULL,
    view_date DATETIME NOT NULL,
    page_url TEXT NOT NULL,
    views_count INT(11) NOT NULL
);
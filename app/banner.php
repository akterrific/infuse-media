<?php
require_once 'Classes\Visitor.php';

$visitor = new Visitor();
$visitor->logVisit();

header('Content-Type: image/png');
readfile('./public/images/banner.png');

<?php
use service\SessionService;
require_once 'service/SessionService.php';
$session = SessionService::getInstance();
$session->logout();
$session->clear();
header('Location: index.php');
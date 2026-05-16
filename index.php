<?php

session_start();

require_once __DIR__ . '/classes/Routes.php';

$page = $_GET['page'] ?? 'login';

$routes = new Routes();
$routes->handle($page);
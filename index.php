<?php

session_start();

require_once 'classes/Routes.php';

$page = $_GET['page'] ?? 'login';

$routes = new Routes();
$routes->handle($page);
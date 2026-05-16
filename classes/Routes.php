<?php

class Routes
{
    public function handle($page)
    {
        if ($page == 'register') {
            require_once __DIR__ . '/../views/register.php';
        } elseif ($page == 'logout') {
            session_destroy();
            header('Location: index.php?page=login');
            exit;
        } else {
            require_once __DIR__ . '/../views/login.php';
        }
    }
}
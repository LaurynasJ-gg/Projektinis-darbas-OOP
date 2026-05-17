<?php

class Routes
{
    public function handle($page)
    {
        if ($page == 'register') {
            require_once 'views/register.php';
        } elseif ($page  == 'dashboard') {
            require_once 'views/dashboard.php';
        } elseif ($page  == 'add_password') {
            require_once 'views/add_password.php';
        } elseif ($page == 'logout') {
            session_destroy();
            header('Location: index.php?page=login');
            exit;
        } else {
            require_once 'views/login.php';
        }
    }
}
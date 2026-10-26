<?php
class HomeController
{
    public function index()
    {
        header('Location: ' . DOMAIN . '?controller=student&action=index');
        exit;
    }
}

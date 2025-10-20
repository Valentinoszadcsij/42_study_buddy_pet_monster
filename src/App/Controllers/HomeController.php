<?php
namespace App\Controllers;
use App\Models\User;
use App\Utility\Session;

class HomeController
{
    public function index()
    {
        Session::session_init();
        include __DIR__ . "/../Views/home.php";
    }
}
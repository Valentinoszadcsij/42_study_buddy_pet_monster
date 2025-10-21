<?php
namespace App\Controllers;
use App\Models\User;
use App\Utility\Session;

class HomeController
{
    public function index()
    {
        include __DIR__ . "/../Views/game.php";
    }
}

// <?php
// namespace App\Controllers;
// use App\Models\User;
// use App\Utility\Session;

// class HomeController
// {
//     public function index()
//     {
//         Session::session_init();
//         if (!isset($_SESSION['user_password']) || $_SESSION['user_password'] !== "verified") {
//             header('Location: /Auth');
//             exit();
//         }
//         include __DIR__ . "/../Views/game.php";
//     }
// }

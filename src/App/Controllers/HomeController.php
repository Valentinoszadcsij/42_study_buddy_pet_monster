<?php
namespace App\Controllers;
use App\Models\User;
use App\Utility\Session;

class HomeController
{
    public function index()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Get user info and coalition data
        $displayname = 'Guest';
        $coalition = 'None';
        $coalition_color = '#6abc3a'; // Default green color

        if (isset($_SESSION['user_info'])) {
            $user = $_SESSION['user_info'];
            $displayname = $user['usual_full_name'] ?? $user['displayname'] ?? 'Guest';
        }

        if (isset($_SESSION['coalition_info'])) {
            $coalition = $_SESSION['coalition_info']['coalition'];
            $coalition_color = $_SESSION['coalition_info']['color'];
        }

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

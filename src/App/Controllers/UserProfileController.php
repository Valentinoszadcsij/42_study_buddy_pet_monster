<?php
namespace App\Controllers;

use App\Models\User;
use App\Utility\Auth;
use App\Utility\Session;
class UserProfileController
{
    // shows your own profile page
    public function index()
    {   
        Session::session_init();
        Auth::protected();

        $user = User::findByID($_SESSION['user_id']);
        $userName = $user['name'];
        require_once __DIR__ . "/../Views/userProfile.php";
        exit;
    }

    // shows any user's page
    public function user($userId)
    {
        Session::session_init();
        Auth::protected();
        if ((isset($_SESSION['user_id']) && $_SESSION['user_id'] != ''))
        {
            $user = User::findByID($userId);
            $userName = $user['name'];
            require_once __DIR__ . "/../Views/userProfile.php";
            exit;
        }
    }
}
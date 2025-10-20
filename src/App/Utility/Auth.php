<?php
namespace App\Utility;

use App\Models\User;

class Auth 
{
    // used for any page that requires authentication. If user is authenticated, proceeds with script, otherwise redirect to /Auth
    public static function protected()
    {
        // still wanna check if there are any ways to temper session data
        
        if ($_SESSION['user_password'] !== "verified")
        {
            $_SESSION['error'] = "Login required to access this page!";
            header('Location: /Auth');
            exit;
        }
    }

    public static function verify(array $user, string $password): bool
    {
        if ($user && password_verify($password, $user['password']))
        {
            $_SESSION['user_password'] = "verified";
            return true;
        }
        $_SESSION['error'] = "Invalid password.";
        $_SESSION['user_password'] = "wrong";
        return false;
    }
}
?>
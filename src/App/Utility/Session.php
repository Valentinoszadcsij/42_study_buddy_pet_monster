<?php
namespace App\Utility;

class Session 
{
    public static function session_init()
    {
        session_start();
        if (!(isset($_SESSION['user_email'])))
        {
            $_SESSION['user_email'] = "";
            $_SESSION['user_name'] = "";
            $_SESSION['user_id'] = "";
            $_SESSION['user_password'] = "";
            $_SESSION['error'] = "";
        }
    }

    public static function reset_key(string $key)
    {
        if (isset($_SESSION[$key]))
        {
            $_SESSION[$key] = "";
        }
    }
    
}

?>
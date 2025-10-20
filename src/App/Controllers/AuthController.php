<?php
namespace App\Controllers;

require_once __DIR__ . '/../Models/User.php';
use App\Models\User;
use App\Utility\Auth;
use App\Utility\Session;
use App\Utility\Mailer;

class AuthController
{
    public function index()
    {
        Session::session_init();
        if ($_SESSION['user_password'] === "verified")
        {
            header('Location: /UserProfile');
            exit;
        }
        if ($_SERVER["REQUEST_METHOD"] === "GET")
        {
            include __DIR__ . '/../Views/auth.php';
            exit;
        }
        $email = $_POST['email'] ?? '';
        $user = User::findByEmail($email);
        $_SESSION['user_email'] = $email;
        if ($user)
        {
            $_SESSION['user_id'] = $user['id'];
            header('Location: /Auth/login');
            exit;
        }
        $_SESSION['error'] = "no_user";
        header('Location: /Auth');
        exit;
    }

    public function login()
    {
        Session::session_init();
        if ($_SESSION['user_password'] === "verified")
        {
            header('Location: /UserProfile');
            exit;
        }
        elseif (empty($_SESSION['user_id']))
        {
            header('Location: /Auth');
            exit;
        }
    
        if ($_SERVER["REQUEST_METHOD"] === "GET")
        {
            include __DIR__ . '/../Views/login.php';
            exit;
        }
        
        $password = $_POST['password'] ?? '';
        $user = User::findByEmail($_SESSION['user_email']);
        if (Auth::verify($user, $password))
        {
            header('Location: /UserProfile');
            exit;
        }
        else
        {
            header('Location: /Auth/login');
            exit;
        }

 
    }



    public function register()
    {
        Session::session_init();
        if ($_SESSION['user_password'] === "verified")
        {
            header('Location: /UserProfile');
            exit;
        }
        if ($_SERVER["REQUEST_METHOD"] === "GET")
        {
            include __DIR__ . ("/../Views/register.php");
            exit;
        }

        $_SESSION['user_name'] = $_POST['name'] ?? '';
        $_SESSION['user_email'] = $_POST['email'] ?? '';
        $_SESSION['user_password'] = $_POST['password'] ?? '';

        if (User::findByEmail($_SESSION['user_email'])) {
            $_SESSION['error'] = "Email already in use.";
            header('Location: /Auth/register');
            exit;
        }
        $confirmation = Mailer::send_email_verification($_SESSION['user_email']);
        if ($confirmation != -1)
        {
            $_SESSION['confirmation_code'] = $confirmation;
            error_log("Reached after sending mail, redirecting to confirm");
            header('Location: /Auth/confirm');
            exit;
        }
        else
        {
            unset($_SESSION);
            header('Location: /Auth/register');
            exit;
        }
    }

    public function confirm()
    {
        Session::session_init();
        error_log("In confirmation(), expected code: " . $_SESSION['confirmation_code']);
        if ($_SESSION['confirmation_code'])
        {
            if ($_SERVER['REQUEST_METHOD'] === "GET")
            {
                include __DIR__ . ("/../Views/confirm.php");
                exit;
            }
            $code = $_POST['code'];
            if ($_SESSION['confirmation_code'] === (int)$code)
            {
                unset($_SESSION['confirmation_code']);
                Session::reset_key("error");
                $hashedPassword = password_hash($_SESSION['user_password'], PASSWORD_DEFAULT);
                User::create($_SESSION['user_name'], $_SESSION['user_email'], $hashedPassword);
                $user = User::findByEmail($email);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['success'] = "Registration successful. Please log in.";
                header('Location: /Auth/login');
                exit;
            }
            else
            {
                $_SESSION['error'] = "Wrong confirmation code. Try again";
                include __DIR__ . ("/../Views/confirm.php");
                exit;               
            }
        }
        header('Location: /Auth');
        exit;
    }
    public function logout()
    {
        
        // Expire the session cookie on the client
        if (ini_get("session.use_cookies")) {
            session_start();
    
            // Clear session variables
            $_SESSION = [];
    
            // Destroy session on the server
            session_destroy();
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000, // Expire in the past
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Redirect after logout
        header('Location: /');
        exit;
    }
}
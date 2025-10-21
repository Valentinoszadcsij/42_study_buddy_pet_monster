<?php
namespace App\Controllers;

require_once __DIR__ . '/../Models/User.php';

use App\Models\User;
use App\Utility\Auth;
use App\Utility\Session;


class AuthController
{
    public function index()
    {
        $config = require dirname(__DIR__) . '/Utility/config.php';

        // var_dump($config);
        // exit;
        $state = bin2hex(random_bytes(8));
        $_SESSION['state'] = $state;

        $params = http_build_query([
            'client_id' => $config['client_id'],
            'redirect_uri' => $config['redirect_uri'],
            'response_type' => 'code',
            'scope' => 'public',
            'state' => $state
        ]);
        $url = $config['authorize_url'] . '?' . $params;
        header('Location: ' . $url);
        exit;
    }



    public function callback()
    {
        // var_dump($_SESSION['end_url']);
        // exit;

        // --- 1️⃣ Verify we have code + state ---
        if (!isset($_GET['code']) || !isset($_GET['state']) || $_GET['state'] !== ($_SESSION['state'] ?? '')) {
            die("Invalid or missing state.");
        }
        $config = require dirname(__DIR__) . '/Utility/config.php';
        // --- 2️⃣ Exchange code for token ---
        $fields = [
            'grant_type'    => 'authorization_code',
            'client_id'     => $config['client_id'],
            'client_secret' => $config['client_secret'],
            'code'          => $_GET['code'],
            'redirect_uri'  => $config['redirect_uri']
        ];

        $ch = curl_init($config['token_url']);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $fields
        ]);
        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);
        if (!isset($data['access_token'])) {
            die("<pre>Failed to get token:\n$response</pre>");
        }

        // --- 3️⃣ Store everything in session ---
        $_SESSION['access_token']      = $data['access_token'];
        $_SESSION['refresh_token']     = $data['refresh_token'] ?? null;
        $_SESSION['token_expires_in']  = $data['expires_in'] ?? 7200;
        $_SESSION['token_created_at']  = time();

        // set the first login date only once
        if (!isset($_SESSION['first_login_date'])) {
            $_SESSION['first_login_date'] = date('Y-m-d');
        }

        // --- 3.5️⃣ Fetch user info and coalition immediately ---
        $access_token = $data['access_token'];

        // Fetch user info
        $ch = curl_init("https://api.intra.42.fr/v2/me");
        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER => ["Authorization: Bearer $access_token"],
            CURLOPT_RETURNTRANSFER => true
        ]);
        $user_json = curl_exec($ch);
        curl_close($ch);
        $user = json_decode($user_json, true);

        if (is_array($user)) {
            $_SESSION['user_info'] = $user;

            // Fetch coalition info
            $coalition = 'None';
            $color = '#6abc3a';
            $user_id = $user['id'] ?? null;

            if ($user_id) {
                $coal_url = "https://api.intra.42.fr/v2/users/{$user_id}/coalitions";
                $ch = curl_init($coal_url);
                curl_setopt_array($ch, [
                    CURLOPT_HTTPHEADER => ["Authorization: Bearer $access_token"],
                    CURLOPT_RETURNTRANSFER => true
                ]);
                $coal_json = curl_exec($ch);
                curl_close($ch);
                $coal_data = json_decode($coal_json, true);

                if (is_array($coal_data) && count($coal_data) > 0) {
                    $coalition = $coal_data[0]['name'] ?? 'None';
                    $color = $coal_data[0]['color'] ?? '#6abc3a';
                }
            }

            $_SESSION['coalition_info'] = ['coalition' => $coalition, 'color' => $color];
        }

        // --- 4️⃣ Redirect to dashboard ---
        header('Location: ' . $_SESSION['end_url']);
        exit;
    }

    public function logout()
    {

        // Expire the session cookie on the client
        if (ini_get("session.use_cookies")) {

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

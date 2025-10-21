<?php
namespace App\Controllers;
use App\Utility\Session;

class FriendsController
{
    public function index()
    {
        // Ensure session is active
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Default values
        $displayname = 'Guest';
        $coalition = 'None';
        $coalition_color = '#6abc3a'; // Default green fallback

        // Retrieve user data if logged in
        if (isset($_SESSION['user_info'])) {
            $user = $_SESSION['user_info'];
            $displayname = $user['usual_full_name'] ?? $user['displayname'] ?? 'Guest';
        }

        // Retrieve coalition data if available
        if (isset($_SESSION['coalition_info'])) {
            $coalition = $_SESSION['coalition_info']['coalition'] ?? 'None';
            $coalition_color = $_SESSION['coalition_info']['color'] ?? '#6abc3a';
        }

        // Determine sprite or theme type (optional)
        $sprite_type = 'green';
        $color_lower = strtolower($coalition_color);
        if (preg_match('/#([0-9a-f]{6})/i', $color_lower, $matches)) {
            $hex = $matches[1];
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));

            if ($r > $g && $r > $b && $r > 150) {
                $sprite_type = 'red';
            } elseif ($b > $r && $b > $g && $b > 150) {
                $sprite_type = 'purple';
            } else {
                $sprite_type = 'green';
            }
        }

        include __DIR__ . '/../Views/friends.php';
    }
}

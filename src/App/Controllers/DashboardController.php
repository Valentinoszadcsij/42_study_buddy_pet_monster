<?php
namespace  App\Controllers;

class DashboardController
{

    public function index()
    {
        // ============================================================
        // 🔄 Ensure authentication
        // ============================================================
        if (!isset($_SESSION['access_token'])) {
            echo "<p>You need to <a href='index.php'>Login with 42</a> first.</p>";
            exit;
        }
        $access_token = $_SESSION['access_token'];
    
        $first_login_date = $_SESSION['first_login_date'];
    
        // ============================================================
        // 1️⃣ FETCH USER INFO (cached)
        // ============================================================
        if (!isset($_SESSION['user_info'])) {
            $ch = curl_init("https://api.intra.42.fr/v2/me");
            curl_setopt_array($ch, [
                CURLOPT_HTTPHEADER => ["Authorization: Bearer $access_token"],
                CURLOPT_RETURNTRANSFER => true
            ]);
            $user_json = curl_exec($ch);
            curl_close($ch);
            $user = json_decode($user_json, true);
            if (!is_array($user)) {
                echo "<pre>Could not decode /v2/me JSON:\n$user_json</pre>";
                exit;
            }
            $_SESSION['user_info'] = $user;
        } else {
            $user = $_SESSION['user_info'];
        }
    
        $login = $user['login'] ?? 'Unknown';
        $displayname = $user['usual_full_name'] ?? $user['displayname'] ?? 'Unknown';
        $first_name = $user['first_name'] ?? strtok($displayname, ' ');
        $last_name = $user['last_name'] ?? trim(str_replace($first_name, '', $displayname));
        $campus = $user['campus'][0]['name'] ?? 'Unknown';
        $level = 0;
        foreach ($user['cursus_users'] ?? [] as $cursus) {
            if ($cursus['cursus_id'] === 21) {
                $level = $cursus['level'];
                break;
            }
        }
    
        // ============================================================
        // 2️⃣ FETCH COALITION (cached)
        // ============================================================
        if (!isset($_SESSION['coalition_info'])) {
            $coalition = 'None';
            $color = '#ccc';
            $coal_url = "https://api.intra.42.fr/v2/users/{$user['id']}/coalitions";
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
                $color = $coal_data[0]['color'] ?? '#ccc';
            }
            $_SESSION['coalition_info'] = ['coalition' => $coalition, 'color' => $color];
        } else {
            $coalition = $_SESSION['coalition_info']['coalition'];
            $color = $_SESSION['coalition_info']['color'];
        }
    
        // ============================================================
        // 3️⃣ GAME VARIABLES INITIALIZATION
        // ============================================================
        if (!isset($_SESSION['hp'])) $_SESSION['hp'] = 100;
        if (!isset($_SESSION['days'])) $_SESSION['days'] = 0;
        if (!isset($_SESSION['int_food'])) $_SESSION['int_food'] = 0;
        if (!isset($_SESSION['char_food'])) $_SESSION['char_food'] = 0;
        if (!isset($_SESSION['coins'])) $_SESSION['coins'] = 10;
        if (!isset($_SESSION['logs'])) $_SESSION['logs'] = [];
    
        function log_action($desc, $delta = 0) {
            $_SESSION['logs'][] = [
                'time' => date('Y-m-d H:i:s'),
                'desc' => $desc,
                'delta' => $delta
            ];
            if (count($_SESSION['logs']) > 20)
                $_SESSION['logs'] = array_slice($_SESSION['logs'], -20);
        }
    
        // ============================================================
        // 4️⃣ BUTTON ACTIONS
        // ============================================================
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
            // Simulate time tick
            if (isset($_POST['tick'])) {
                $_SESSION['mochi_hp'] = max(0, $_SESSION['mochi_hp'] - 5);
                if ($_SESSION['mochi_hp'] == 0) {
                    $_SESSION['monster_hp'] = max(0, $_SESSION['monster_hp'] - 5);
                }
                log_action("Tick passed", 0);
            }
    
            // 🕓 Simulate full day
            if (isset($_POST['simulate_day'])) {
                $_SESSION['hp'] = max(0, $_SESSION['hp'] - 12);
                if ($_SESSION['hp'] == 0) $_SESSION['alive'] = "false";
                $_SESSION['days'] += 1;

                log_action("A new day passed (-12 HP, +1 day from birth)", +10);
            }
    
            // Feed
            if (isset($_POST['feed'])) {
                if ($_SESSION['food'] > 0) {
                    $_SESSION['food']--;
                    $_SESSION['hunger'] = min(100, $_SESSION['hunger'] + 20);
                    $_SESSION['monster_hp'] = min(100, $_SESSION['monster_hp'] + 10);
                    log_action("Fed monster", 0);
                }
            }
    
            // Snack
            if (isset($_POST['snack'])) {
                $_SESSION['hunger'] = min(100, $_SESSION['hunger'] + 10);
                log_action("Gave snack", 0);
            }
    
            // Work (+50 coins)
            if (isset($_POST['work'])) {
                $_SESSION['coins'] += 50;
                log_action("Worked hard", +50);
            }
    
            // Buy food (–30 coins)
            if (isset($_POST['buy_food']) && $_SESSION['coins'] >= 30) {
                $_SESSION['food']++;
                $_SESSION['coins'] -= 30;
                log_action("Bought food", -30);
            }
    
            // Level Up
            if (isset($_POST['level_up']) && $_SESSION['monster_hp'] === 100 && $_SESSION['hunger'] > 50) {
                $_SESSION['monster_level']++;
                $_SESSION['monster_hp'] = 50;
                $_SESSION['hunger'] = 70;
                log_action("Monster leveled up!", 0);
            }
    
            // Complete Project (+50 coins)
            if (isset($_POST['earn_project'])) {
                $_SESSION['coins'] += 50;
                log_action("Completed project", +50);
            }
    
            // Do Evaluation (+20 coins)
            if (isset($_POST['earn_evaluation'])) {
                $_SESSION['coins'] += 20;
                log_action("Did evaluation", +20);
            }
    
            // Daily Streak Bonus (+50 coins)
            if (isset($_POST['earn_streak'])) {
                $_SESSION['coins'] += 50;
                log_action("Daily streak bonus", +50);
            }
    
            // Milestone Bonus (+200 coins)
            if (isset($_POST['earn_milestone'])) {
                $_SESSION['coins'] += 200;
                log_action("Milestone reward", +200);
            }
    
            // Refresh 42 Data
            if (isset($_POST['refresh_data'])) {
                unset($_SESSION['user_info']);
                unset($_SESSION['coalition_info']);
                header("Location: dashboard.php");
                exit;
            }
        }
    
        // ============================================================
        // 5️⃣ LOAD CURRENT STATE
        // ============================================================
        $monster_hp = $_SESSION['monster_hp'];
        $food = $_SESSION['food'];
        $monster_level = $_SESSION['monster_level'];
        $total_coins = $_SESSION['coins'];
        $hunger = $_SESSION['hunger'];
        $logs = array_reverse($_SESSION['logs']); // newest first

        include __DIR__ . "/../Views/dashboard.php";
    }
}
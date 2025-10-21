<?php
namespace App\Controllers;

class ApiController
{
    public function index()
    {
        echo "Mochi-mo";
    }
    //all stats are in $_SESSION cookie for now, at some point would be persisted to DB
    public function getMochiStats()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['hp'])) $_SESSION['hp'] = 100;
        if (!isset($_SESSION['days'])) $_SESSION['days'] = 0;
        if (!isset($_SESSION['coins'])) $_SESSION['coins'] = 10;
        if (!isset($_SESSION['int_food'])) $_SESSION['int_food'] = 0;
        if (!isset($_SESSION['char_food'])) $_SESSION['char_food'] = 0;

        header('Content-Type: application/json');
        echo json_encode([
            'hp' => $_SESSION['hp'],
            'days' => $_SESSION['days'],
            'coins' => $_SESSION['coins'],
            'int_food' => $_SESSION['int_food'],
            'char_food' => $_SESSION['char_food']
        ]);
    }

    public function buyFood()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Only accept POST requests
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['error' => 'Only POST requests are allowed.']);
            return;
        }

        // Get raw POST data and decode it
        $data = json_decode(file_get_contents('php://input'), true);

        $foodType = $data['food_type'] ?? null;
        $price = $data['price'] ?? 0;

        // Validate food type and price
        $validFoodTypes = ['int_food', 'char_food'];
        if (!in_array($foodType, $validFoodTypes) || !is_numeric($price) || $price <= 0) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid data provided']);
            return;
        }

        // Initialize session values if not set
        if (!isset($_SESSION['coins'])) $_SESSION['coins'] = 0;
        if (!isset($_SESSION[$foodType])) $_SESSION[$foodType] = 0;

        // Check for sufficient coins
        if ($_SESSION['coins'] < $price) {
            http_response_code(400);
            echo json_encode(['error' => 'Not enough coins']);
            return;
        }

        // Process the transaction
        $_SESSION['coins'] -= $price;
        $_SESSION[$foodType] += 1;

        header('Content-Type: application/json');
        echo json_encode([
            'message' => 'Food purchased successfully',
            'coins' => $_SESSION['coins'],
            'food_type' => $foodType,
            'new_amount' => $_SESSION[$foodType]
        ]);
    }

    public function eatFood()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Only accept POST requests
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['error' => 'Only POST requests are allowed.']);
            return;
        }

        // Get raw POST data
        $data = json_decode(file_get_contents('php://input'), true);

        $foodType = $data['food_type'] ?? null;
        $hp_amount = $data['hp_amount'] ?? 10; // Default HP gain is 10

        // Validate food type
        $validFoodTypes = ['int_food', 'char_food'];
        if (!in_array($foodType, $validFoodTypes)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid food type']);
            return;
        }

        // Ensure food is set in session and is sufficient
        if (empty($_SESSION[$foodType]) || $_SESSION[$foodType] < 1) {
            http_response_code(400);
            echo json_encode(['error' => 'Not enough food to eat']);
            return;
        }

        // Decrease food count and increase HP
        $_SESSION[$foodType] -= 1;
        $_SESSION['hp'] = min(100, ($_SESSION['hp'] ?? 0) + $hp_amount);

        header('Content-Type: application/json');
        echo json_encode([
            'message' => 'Food eaten successfully',
            'hp' => $_SESSION['hp'],
            'food_type' => $foodType,
            'new_amount' => $_SESSION[$foodType]
        ]);
    }

    public function getLogs()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_SESSION['logs']))
        {
            header('Content-Type: application/json');
            echo json_encode([
                'logs' => $_SESSION['logs']
            ]);
        }
    }
}

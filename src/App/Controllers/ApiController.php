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

        $foodType = $data['food_type'];
        $amount = 1;

        // Validate food type
        $validFoodTypes = ['int_food', 'char_food'];
        if (!in_array($foodType, $validFoodTypes)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid food type']);
            return;
        }

        // Validate amount
        if ($amount <= 0) {
            http_response_code(400);
            echo json_encode(['error' => 'Amount must be greater than 0']);
            return;
        }

        // Initialize session values if not set
        if (!isset($_SESSION[$foodType])) {
            $_SESSION[$foodType] = 0;
        }

        // Update session with new amount
        $_SESSION[$foodType] += $amount;

        header('Content-Type: application/json');
        echo json_encode([
            'message' => 'Food purchased successfully',
            'food_type' => $foodType,
            'new_amount' => $_SESSION[$foodType]
        ]);
    }

}
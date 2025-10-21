<?php
namespace App\Controllers;

class ApiController
{
    public function index()
    {
        echo "Mochi-mo";
    }

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
}
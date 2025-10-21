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
        return json_encode([
            'hp' => $_SESSION['user_info']['first_name'],

        ]);
    }
}
<?php
namespace App\Models;
require_once __DIR__ . "/db/db.php";

use PDO;

class User
{
    // public function registerNewUser($name, $email, $pass)
    // {
    //     // In a real application, this would fetch data from the database.
    //     // For example: `return db->query('SELECT message FROM welcome_messages')->fetch();`
    //     try {
    //         $pdo = getPDO();
    //         $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    //         $stmt->execute([$name, $email, $pass]);
    //         return "User $name registered successfully!";
    //     } catch (PDOException $e) {
    //         return "Error: " . $e->getMessage();
    //     }
    // }
    public static function findByEmail($email)
    {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function findByID($id)
    {
        $pdo = getPDO();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public static function create($name, $email, $password)
    {
        $pdo = getPDO();
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $password]);
    }

    public static function is_logged_in(): bool
    {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true)
        {
            return true;
        }
        return false;
    }
}
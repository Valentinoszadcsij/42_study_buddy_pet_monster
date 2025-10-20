<?php


function getPDO(){
	static $pdo = null;
	if ($pdo === null) {
		$dsn =
		'mysql:host=' . getenv('MARIADB_HOST') . 
		';dbname=' . getenv('MARIADB_DATABASE') . 
		';charset=utf8mb4';

		$user = getenv('MARIADB_USER');
		$pass = getenv('MARIADB_PASSWORD');
		try {
			$pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
		} catch (PDOException $e) {
			die("Database connection failed:" . $e->getMessage());
		}
	}
	return $pdo;
}
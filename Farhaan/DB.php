<?php
/**
 * Database connection.
 * Uses PDO with prepared statements everywhere else in the app to protect against SQL injection.
 */

$DB_HOST = 'localhost';
$DB_NAME = 'xmen_roster';
$DB_USER = 'root';      // change to your MySQL username
$DB_PASS = '';          // change to your MySQL password

try {
    $pdo = new PDO(
        "mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4",
        $DB_USER,
        $DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
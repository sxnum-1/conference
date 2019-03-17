<?php
$host = 'localhost';
$db = 'Conference';
$user = 'root';
$pwd = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pwd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo '<p>connection failed: ' . $e->getMessage() . '</p>';
} 
 
<?php
$host = 'db.zqwvkqwlhagdqcbvhuze.supabase.co';
$port = '5432';
$dbname = 'postgres';
$user = 'postgres';
$pass = 'ImamsFate007';

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $pass);
    echo "Connection successful!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

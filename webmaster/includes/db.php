<?php
$host = 'sql212.infinityfree.com';
$db   = 'if0_38147269_mhteamsweb';
$user = 'if0_38147269';
$pass = 'Qmj1impTzafs';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Gagal koneksi database: " . $e->getMessage());
}
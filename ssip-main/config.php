<?php
$host = 'localhost';
$db   = 'foodorder';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

try {
    // Koneksi tanpa memilih database
    $pdo = new PDO("mysql:host=$host;charset=$charset", $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);

    // Buat database jika belum ada
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db`");
    $pdo->exec("USE `$db`");

    // Buat tabel users jika belum ada
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // Buat tabel menu jika belum ada
    $pdo->exec("CREATE TABLE IF NOT EXISTS menu (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        description TEXT,
        price DECIMAL(10, 2) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // Tambahkan beberapa data contoh ke tabel menu
    $pdo->exec("INSERT INTO menu (name, description, price) VALUES
        ('Nasi Goreng', 'Nasi goreng spesial dengan telur dan ayam', 25000),
        ('Mie Goreng', 'Mie goreng dengan sayuran dan bakso', 22000),
        ('Sate Ayam', 'Sate ayam dengan bumbu kacang', 30000)
    ON DUPLICATE KEY UPDATE name = VALUES(name)");

} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
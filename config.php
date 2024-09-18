<?php
$host = 'localhost';
$db   = 'foodorder';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;charset=$charset", $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);

    // create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db`");
    $pdo->exec("USE `$db`");

    // create users table
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // create menu table
    $pdo->exec("CREATE TABLE IF NOT EXISTS menu (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        description TEXT,
        price DECIMAL(10, 2) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // column category if not exist
    $pdo->exec("ALTER TABLE menu ADD COLUMN IF NOT EXISTS category VARCHAR(50) DEFAULT 'Uncategorized'");

    $pdo->exec("ALTER TABLE menu ADD COLUMN IF NOT EXISTS stock INT DEFAULT 0");

    // cart table
    $pdo->exec("CREATE TABLE IF NOT EXISTS cart (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        item_id INT NOT NULL,
        name VARCHAR(100) NOT NULL,
        price DECIMAL(10, 2) NOT NULL,
        quantity INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (item_id) REFERENCES menu(id)
    )");

    // check if menu exist
    $stmt = $pdo->query("SELECT COUNT(*) FROM menu");
    $menuCount = $stmt->fetchColumn();

    // if menu empty, create menu list
    if ($menuCount == 0) {
        $pdo->exec("INSERT INTO menu (name, description, price, category, stock) VALUES
            ('Nasi Goreng', 'Nasi goreng spesial dengan telur dan ayam', 25000, 'Makanan', 50),
            ('Mie Goreng', 'Mie goreng dengan sayuran dan bakso', 22000, 'Makanan', 50),
            ('Sate Ayam', 'Sate ayam dengan bumbu kacang', 30000, 'Makanan', 50),
            ('Es Teh', 'Es teh manis dingin', 5000, 'Minuman', 100),
            ('Es Jeruk', 'Es jeruk manis dingin', 7000, 'Minuman', 100)
        ");
    }

    // bookings table
    $pdo->exec("CREATE TABLE IF NOT EXISTS bookings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        booking_date DATE NOT NULL,
        booking_time TIME NOT NULL,
        booking_name VARCHAR(255) NOT NULL,
        num_persons INT NOT NULL DEFAULT 1
    )");

    $pdo->exec("ALTER TABLE bookings ADD COLUMN IF NOT EXISTS num_persons INT NOT NULL DEFAULT 1");

    // admin table
    $pdo->exec("CREATE TABLE IF NOT EXISTS admin (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Insert default admin user if not exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM admin");
    $stmt->execute();
    $adminCount = $stmt->fetchColumn();

    if ($adminCount == 0) {
        $defaultUsername = 'admin';
        $defaultPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $defaultEmail = 'admin@example.com';
        
        $stmt = $pdo->prepare("INSERT INTO admin (username, password, email) VALUES (?, ?, ?)");
        $stmt->execute([$defaultUsername, $defaultPassword, $defaultEmail]);
    }

} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}


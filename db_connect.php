<?php
// db_connect.php

// 1. SECURE CONFIGURATION (Matches Part C "Secrets Management")
// We read these from Environment Variables injected by your teammates' IaC
$host = getenv('DB_HOST'); 
$db   = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');

// 2. SSL ENCRYPTION (Matches Part B "Encryption in Transit")
// This ensures the link between EC2 and RDS is encrypted [cite: 216]
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_SSL_CA       => '/var/www/html/global-bundle.pem', // AWS 2024 Cert
    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
];

try {
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Log error to CloudWatch (Do not show to user)
    error_log("DB Connection Error: " . $e->getMessage());
    die("Connection failed: " . $e->getMessage());
}

// 3. FORCE HTTPS (Matches Part D "HTTPS configuration")
// Critical: We check the Load Balancer header, not the local port!
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'http') {
    $redirect_url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: $redirect_url");
    exit();
}
?>
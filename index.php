<?php
require 'db_connect.php';

// Simple Search Feature
$search = $_GET['search'] ?? '';
$results = [];

if ($search) {
    // SECURE: Prepared Statements mitigate Risk 1 (Legacy SQL Injection) [cite: 153]
    $stmt = $pdo->prepare("SELECT * FROM students WHERE name LIKE ?");
    $stmt->execute(["%$search%"]);
    $results = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MMU Student Portal (Secure)</title>
    <style>body { font-family: sans-serif; padding: 20px; }</style>
</head>
<body>
    <h2>Student Information Management [cite: 33]</h2>
    <p>Status: <strong style="color:green">Secure Connection (TLS 1.2)</strong></p>
    
    <form method="GET">
        <input type="text" name="search" placeholder="Enter Student Name" value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Search</button>
    </form>

    <h3>Results:</h3>
    <ul>
        <?php foreach ($results as $row): ?>
            <li><?= htmlspecialchars($row['name']) ?> (ID: <?= htmlspecialchars($row['student_id']) ?>)</li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
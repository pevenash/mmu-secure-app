<?php
include 'db_connect.php';

try {
    // Create the Students Table
    $sql = "CREATE TABLE IF NOT EXISTS students (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        student_id VARCHAR(20) NOT NULL
    )";
    $pdo->exec($sql);
    echo "Table 'students' created successfully.<br>";

    // Insert Dummy Data
    $sql = "INSERT INTO students (name, student_id) VALUES 
            ('John Doe', '112233'),
            ('Jane Smith', '445566')";
    $pdo->exec($sql);
    echo "Dummy students inserted successfully.";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
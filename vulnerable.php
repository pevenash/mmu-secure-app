<?php
// vulnerable.php - DELIBERATELY INSECURE FOR DEMO
require 'db_connect.php';

$name = $_GET['name'];
// INSECURE: This allows SQL Injection
$sql = "SELECT * FROM students WHERE name = '$name'";
$pdo->query($sql);
echo "Executed Query: " . $sql;
?>
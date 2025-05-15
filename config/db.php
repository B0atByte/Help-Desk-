<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'bbs_db';

$conn = new mysqli($host, $user, $pass, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตั้งค่าภาษาให้รองรับ UTF-8
$conn->set_charset("utf8mb4");
?>

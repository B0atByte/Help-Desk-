<?php
session_start();
include 'config/db.php';

// จำลอง role จาก URL เช่น ?role=admin
$role = $_GET['role'] ?? 'user';

// ดึง user ที่มี role ตรงจากฐานข้อมูล (เอาแค่คนแรก)
$sql = "SELECT * FROM users WHERE role = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $role);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    $_SESSION['user'] = $user;
    header("Location: dashboard.php"); // ไปหน้าแรกหลังล็อกอิน
    exit;
} else {
    echo "ไม่พบผู้ใช้ที่มี role: $role";
}
?>

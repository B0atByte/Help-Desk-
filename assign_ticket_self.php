<?php
include 'auth.php';
include 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ticket_id'])) {
  $ticket_id = intval($_POST['ticket_id']);
  $technician_id = $_SESSION['user']['id'];

  // อัปเดต assigned_to ให้ช่างที่รับงาน
  $stmt = $conn->prepare("UPDATE tickets SET assigned_to = ? WHERE id = ?");
  $stmt->bind_param("ii", $technician_id, $ticket_id);
  $stmt->execute();

  // กลับไปหน้าเดิม
  header("Location: view_ticket.php");
  exit;
} else {
  echo "ไม่สามารถรับงานได้ กรุณาลองใหม่";
}
?>

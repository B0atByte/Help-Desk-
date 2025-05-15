<?php
include 'auth.php';
include 'config/db.php';

$user_id = $_SESSION['user']['id'];
$role = $_SESSION['user']['role'];

if ($role === 'user') {
  $sql = "SELECT COUNT(*) AS new FROM comments c
          JOIN tickets t ON c.ticket_id = t.id
          WHERE t.user_id = $user_id AND TIMESTAMPDIFF(SECOND, c.created_at, NOW()) < 30";
} else {
  $sql = "SELECT COUNT(*) AS new FROM comments
          WHERE TIMESTAMPDIFF(SECOND, created_at, NOW()) < 30";
}

$result = $conn->query($sql);
$row = $result->fetch_assoc();

echo json_encode(['new' => $row['new']]);
?>

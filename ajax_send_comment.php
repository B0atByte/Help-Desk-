<?php
include 'auth.php';
include 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $ticket_id = intval($_POST['ticket_id']);
  $comment = trim($_POST['comment']);
  $user_id = $_SESSION['user']['id'];

  if ($comment !== '') {
    $stmt = $conn->prepare("INSERT INTO comments (ticket_id, user_id, comment, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iis", $ticket_id, $user_id, $comment);
    $stmt->execute();
  }
}
?>
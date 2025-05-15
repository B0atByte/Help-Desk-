<?php
include 'auth.php';
include 'config/db.php';

if (isset($_GET['ticket_id'])) {
  $ticket_id = intval($_GET['ticket_id']);
  
  $stmt = $conn->prepare("SELECT c.comment, c.created_at, u.name FROM comments c JOIN users u ON c.user_id = u.id WHERE c.ticket_id = ? ORDER BY c.created_at ASC");
  $stmt->bind_param("i", $ticket_id);
  $stmt->execute();
  $result = $stmt->get_result();

  while ($row = $result->fetch_assoc()) {
    echo '<div class="mb-1">';
    echo '<strong>' . htmlspecialchars($row['name']) . '</strong>: ' . nl2br(htmlspecialchars($row['comment'])) . '<br>'; 
    echo '<small class="text-gray-500">' . date('d/m/Y H:i', strtotime($row['created_at'])) . '</small>';
    echo '</div>';
  }
}
?>

<?php
include 'auth.php';
include 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ticket_id = $_POST['ticket_id'];
    $user_id = $_SESSION['user']['id'];
    $comment = $_POST['comment'];

    $stmt = $conn->prepare("INSERT INTO comments (ticket_id, user_id, comment) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $ticket_id, $user_id, $comment);

    if ($stmt->execute()) {
        header("Location: view_ticket.php?id=$ticket_id");
    } else {
        echo "เกิดข้อผิดพลาด: " . $stmt->error;
    }
}
?>

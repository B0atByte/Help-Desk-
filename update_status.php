<?php
include 'auth.php';
include 'config/db.php';

function sendTelegramNotify($message) {
    $token = '7525358528:AAEOP45BHCEmzbtjGnfK_OrXbL0OLnqdc_w';
    $chat_id = '-1002553341337';
    $url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=" . urlencode($message);
    file_get_contents($url);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ticket_id = $_POST['ticket_id'];
    $new_status = $_POST['status'];

    // ดึงข้อมูล Ticket และชื่อผู้แจ้ง
    $sql = "SELECT t.title, t.priority, u.name AS username, c.name AS category 
            FROM tickets t 
            JOIN users u ON t.user_id = u.id 
            JOIN categories c ON t.category_id = c.id 
            WHERE t.id = $ticket_id";
    $result = $conn->query($sql);
    $ticket = $result->fetch_assoc();

    // อัปเดตสถานะในฐานข้อมูล
    $stmt = $conn->prepare("UPDATE tickets SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $ticket_id);

    if ($stmt->execute()) {
        // ✅ ส่งข้อความ Telegram แจ้งสถานะใหม่
        $msg = "🔄 อัปเดตสถานะคำร้องในระบบ Bargainpoint\n\n"
             . "👤 ผู้แจ้ง: " . $ticket['username'] . "\n"
             . "📝 หัวข้อ: " . $ticket['title'] . "\n"
             . "🔎 หมวดหมู่: " . $ticket['category'] . "\n"
             . "🎯 ความสำคัญ: " . $ticket['priority'] . "\n"
             . "📌 สถานะใหม่: $new_status";

        sendTelegramNotify($msg);

        header("Location: view_ticket.php?id=$ticket_id");
        exit;
    } else {
        echo "เกิดข้อผิดพลาด: " . $stmt->error;
    }
}
?>

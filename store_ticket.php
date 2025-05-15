<?php
include 'auth.php';
include 'config/db.php';

function sendTelegramNotify($message) {
    $token = '7525358528:AAEOP45BHCEmzbtjGnfK_OrXbL0OLnqdc_w';  // Token จริง
    $chat_id = '-1002553341337';
    $url = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=" . urlencode($message);
    file_get_contents($url);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user']['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];
    $priority = $_POST['priority'];

    $user_name = $_SESSION['user']['name'];
    $category_name = $conn->query("SELECT name FROM categories WHERE id = $category_id")->fetch_assoc()['name'];

    // แนบไฟล์
    $attachment = null;
    if (!empty($_FILES['attachment']['name'])) {
        $filename = basename($_FILES['attachment']['name']);
        $filename = preg_replace('/[^a-zA-Z0-9\._-]/', '_', $filename); // ป้องกันชื่อไฟล์อันตราย
        $targetDir = "uploads/";
        $uniqueName = time() . "_" . $filename;
        $targetFile = $targetDir . $uniqueName;

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        if (move_uploaded_file($_FILES['attachment']['tmp_name'], $targetFile)) {
            $attachment = $targetFile;
        }
    }

    // เพิ่ม Ticket ลงฐานข้อมูล
    $stmt = $conn->prepare("INSERT INTO tickets (user_id, category_id, title, description, priority, attachment) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissss", $user_id, $category_id, $title, $description, $priority, $attachment);

    if ($stmt->execute()) {
        // แจ้งเตือน Telegram
        $msg = "📌 แจ้งปัญหาใหม่เข้าระบบ Bargainpoint\n\n"
             . "👤 ผู้แจ้ง: $user_name\n"
             . "📝 หัวข้อ: $title\n"
             . "🔎 หมวดหมู่: $category_name\n"
             . "🎯 ความสำคัญ: $priority\n\n"
             . "📄 รายละเอียด:\n$description";
        sendTelegramNotify($msg);

        header("Location: dashboard.php");
        exit;
    } else {
        echo "เกิดข้อผิดพลาด: " . $stmt->error;
    }
}
?>
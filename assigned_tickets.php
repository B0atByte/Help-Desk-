<?php
include 'auth.php';
include 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ticket_id = $_POST['ticket_id'];
    $assigned_to = $_POST['assigned_to'];

    if (!empty($ticket_id) && !empty($assigned_to)) {
        $stmt = $conn->prepare("UPDATE tickets SET assigned_to = ? WHERE id = ?");
        $stmt->bind_param("ii", $assigned_to, $ticket_id);
        if ($stmt->execute()) {
            header("Location: view_ticket.php?id=$ticket_id");
            exit;
        } else {
            echo "เกิดข้อผิดพลาดในการมอบหมายงาน";
        }
    } else {
        echo "กรุณาเลือกเจ้าหน้าที่ให้ถูกต้อง";
    }
    exit;
}

$user_id = $_SESSION['user']['id'];
$role = $_SESSION['user']['role'];

$sql = "SELECT t.*, c.name AS category, u.name AS user_name
        FROM tickets t
        JOIN categories c ON t.category_id = c.id
        JOIN users u ON t.user_id = u.id
        WHERE t.assigned_to = $user_id
        ORDER BY t.created_at DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>Ticket ที่รับผิดชอบ - Bargainpoint</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex bg-[#F2CAA7] min-h-screen">

<!-- Sidebar -->
<aside class="w-64 bg-[#A61103] text-white min-h-screen p-6 space-y-6">
  <h1 class="text-2xl font-bold mb-8">🛠 Bargainpoint</h1>
  <nav class="flex flex-col gap-4">
    <a href="dashboard.php" class="hover:underline font-semibold">📊 แดชบอร์ด</a>
    <a href="create_ticket.php" class="hover:underline">➕ แจ้งปัญหา</a>
    <a href="view_ticket.php" class="hover:underline">📄 ตั๋วของฉัน</a>
    <a href="assigned_tickets.php" class="hover:underline">🧰 ตั๋วที่รับผิดชอบ</a>
    <?php if ($role == 'technician' || $role == 'admin'): ?>
      <a href="view_ticket.php?status=closed" class="hover:underline">📁 งานที่ปิดแล้ว</a>
    <?php endif; ?>
    <a href="logout.php" class="hover:underline text-yellow-300 mt-12">🚪 ออกจากระบบ</a>
  </nav>
</aside>

<!-- Main Content -->
<main class="flex-1 p-8">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-[#A61103]">ตั๋วที่ได้รับมอบหมาย</h2>
    <a href="dashboard.php" class="text-sm text-[#7092AB] hover:underline">← กลับแดชบอร์ด</a>
  </div>

  <div class="overflow-x-auto">
    <table class="min-w-full bg-white rounded-xl shadow">
      <thead class="bg-[#7092AB] text-white text-left">
        <tr>
          <th class="py-3 px-4">หัวข้อ</th>
          <th class="py-3 px-4">หมวดหมู่</th>
          <th class="py-3 px-4">ผู้แจ้ง</th>
          <th class="py-3 px-4">สถานะ</th>
          <th class="py-3 px-4">วันที่</th>
          <th class="py-3 px-4">ดู</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr class="border-b hover:bg-gray-100">
          <td class="py-2 px-4 text-sm font-medium text-gray-800"><?= htmlspecialchars($row['title']) ?></td>
          <td class="py-2 px-4 text-sm text-gray-700"><?= htmlspecialchars($row['category']) ?></td>
          <td class="py-2 px-4 text-sm text-gray-700"><?= htmlspecialchars($row['user_name']) ?></td>
          <td class="py-2 px-4 text-sm text-gray-600">
            <?php
              $statusMap = [
                'new' => '🆕 ใหม่',
                'in_progress' => '🔧 กำลังดำเนินการ',
                'resolved' => '✅ แก้ไขแล้ว',
                'closed' => '📁 ปิดงาน'
              ];
              echo $statusMap[$row['status']] ?? $row['status'];
            ?>
          </td>
          <td class="py-2 px-4 text-sm text-gray-600"><?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></td>
          <td class="py-2 px-4">
            <a href="view_ticket.php?id=<?= $row['id'] ?>" class="text-[#F2845C] hover:underline text-sm font-medium">รายละเอียด</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</main>

</body>
</html>

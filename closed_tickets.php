<?php
include 'auth.php';
include 'config/db.php';

$user = $_SESSION['user'];
$user_id = $user['id'];
$role = $user['role'];

function thStatus($status) {
  return [
    'new' => 'ใหม่',
    'in_progress' => 'กำลังดำเนินการ',
    'resolved' => 'แก้ไขแล้ว',
    'closed' => 'ปิดงาน'
  ][$status] ?? $status;
}

function thPriority($priority) {
  return [
    'low' => 'ต่ำ',
    'medium' => 'ปานกลาง',
    'high' => 'สูง'
  ][$priority] ?? $priority;
}

$sql = "SELECT t.*, c.name AS category, u.name AS reporter, tech.name AS technician_name
        FROM tickets t
        JOIN categories c ON t.category_id = c.id
        JOIN users u ON t.user_id = u.id
        LEFT JOIN users tech ON t.assigned_to = tech.id
        WHERE t.status = 'closed' ";

if ($role === 'user') {
  $sql .= " AND t.user_id = $user_id";
}

$sql .= " ORDER BY t.created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>งานที่ปิดแล้ว - Bargainpoint</title>
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
    <?php if ($role == 'technician' || $role == 'admin'): ?>
      <a href="assigned_tickets.php" class="hover:underline">🧰 ตั๋วที่รับผิดชอบ</a>
      <a href="closed_tickets.php" class="hover:underline text-yellow-300">📁 งานที่ปิดแล้ว</a>
    <?php endif; ?>
    <a href="logout.php" class="hover:underline text-yellow-300 mt-12">🚪 ออกจากระบบ</a>
  </nav>
</aside>

<!-- Main Content -->
<main class="flex-1 p-8">
  <h2 class="text-2xl font-bold text-[#A61103] mb-6">📁 งานที่ปิดแล้ว</h2>

  <div class="overflow-x-auto">
    <table class="min-w-full bg-white rounded-xl shadow">
      <thead class="bg-[#7092AB] text-white text-left">
        <tr>
          <th class="py-3 px-4">หัวข้อ</th>
          <th class="py-3 px-4">หมวดหมู่</th>
          <th class="py-3 px-4">ผู้แจ้ง</th>
          <th class="py-3 px-4">ผู้รับผิดชอบ</th>
          <th class="py-3 px-4">ความสำคัญ</th>
          <th class="py-3 px-4">วันที่</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr class="border-b hover:bg-gray-100 text-sm">
          <td class="py-2 px-4 font-medium text-gray-800"><?= htmlspecialchars($row['title']) ?></td>
          <td class="py-2 px-4 text-gray-700"><?= htmlspecialchars($row['category']) ?></td>
          <td class="py-2 px-4 text-gray-700"><?= htmlspecialchars($row['reporter']) ?></td>
          <td class="py-2 px-4 text-gray-700"><?= $row['technician_name'] ?? '<span class="text-red-600">ยังไม่มี</span>' ?></td>
          <td class="py-2 px-4 text-gray-700"><?= thPriority($row['priority']) ?></td>
          <td class="py-2 px-4 text-gray-600"><?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</main>
</body>
</html>

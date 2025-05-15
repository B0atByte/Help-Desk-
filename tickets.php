<?php include 'auth.php'; include 'config/db.php'; ?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>รายการแจ้งปัญหา - Bargainpoint</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F2CAA7] min-h-screen">

<div class="bg-[#A61103] text-white p-4 flex justify-between">
  <h1 class="text-xl font-semibold">รายการแจ้งปัญหา</h1>
  <a href="dashboard.php" class="underline">กลับแดชบอร์ด</a>
</div>

<div class="p-6">
  <div class="overflow-x-auto">
    <table class="min-w-full bg-white shadow-md rounded">
      <thead class="bg-[#7092AB] text-white">
        <tr>
          <th class="py-2 px-4">หัวข้อ</th>
          <th class="py-2 px-4">หมวดหมู่</th>
          <th class="py-2 px-4">สถานะ</th>
          <th class="py-2 px-4">ความสำคัญ</th>
          <th class="py-2 px-4">วันที่</th>
          <th class="py-2 px-4">จัดการ</th>
        </tr>
      </thead>
      <tbody>
        <?php
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

        $user = $_SESSION['user'];
        $role = $user['role'];
        $userId = $user['id'];

        if ($role == 'user') {
          $sql = "SELECT t.*, c.name AS category FROM tickets t JOIN categories c ON t.category_id = c.id WHERE t.user_id = $userId";
        } else {
          $sql = "SELECT t.*, c.name AS category FROM tickets t JOIN categories c ON t.category_id = c.id";
        }

        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()):
        ?>
        <tr class="text-center border-b hover:bg-gray-100">
          <td class="py-2 px-4 font-medium text-left"><?= htmlspecialchars($row['title']) ?></td>
          <td class="py-2 px-4"><?= htmlspecialchars($row['category']) ?></td>
          <td class="py-2 px-4"><?= thStatus($row['status']) ?></td>
          <td class="py-2 px-4"><?= thPriority($row['priority']) ?></td>
          <td class="py-2 px-4"><?= htmlspecialchars($row['created_at']) ?></td>
          <td class="py-2 px-4">
            <a href="view_ticket.php?id=<?= $row['id'] ?>" class="text-[#F2845C] hover:underline">รายละเอียด</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>

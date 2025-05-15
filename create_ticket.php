<?php include 'auth.php'; include 'config/db.php'; ?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>แจ้งปัญหา - Bargainpoint</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex bg-[#F2CAA7] min-h-screen">

<!-- Sidebar -->
<aside class="w-64 bg-[#A61103] text-white min-h-screen p-6 space-y-6">
  <h1 class="text-2xl font-bold mb-8">🛠 Bargainpoint</h1>
  <nav class="flex flex-col gap-4">
    <a href="dashboard.php" class="hover:underline font-semibold">📊 แดชบอร์ด</a>
    <a href="create_ticket.php" class="hover:underline text-yellow-300">➕ แจ้งปัญหา</a>
    <a href="view_ticket.php" class="hover:underline">📄 ตั๋วของฉัน</a>
    <?php if ($_SESSION['user']['role'] === 'technician' || $_SESSION['user']['role'] === 'admin'): ?>
      <a href="assigned_tickets.php" class="hover:underline">🧰 ตั๋วที่รับผิดชอบ</a>
    <?php endif; ?>
    <a href="logout.php" class="hover:underline text-yellow-300 mt-12">🚪 ออกจากระบบ</a>
  </nav>
</aside>

<!-- Main Content -->
<main class="flex-1 p-8">
  <h2 class="text-2xl font-bold text-[#A61103] mb-6">📩 แจ้งปัญหาใหม่</h2>
  <div class="bg-white shadow-md rounded-xl p-6 w-full max-w-2xl">
    <form method="POST" action="store_ticket.php" enctype="multipart/form-data">
      <label class="block mb-2 font-semibold">หัวข้อปัญหา</label>
      <input type="text" name="title" required class="w-full p-2 border rounded mb-4">

      <label class="block mb-2 font-semibold">รายละเอียด</label>
      <textarea name="description" rows="4" required class="w-full p-2 border rounded mb-4"></textarea>

      <label class="block mb-2 font-semibold">แนบไฟล์ (PDF, รูปภาพ):</label>
      <input type="file" name="attachment" class="w-full border p-2 rounded mb-4" accept=".pdf,.jpg,.jpeg,.png">

      <label class="block mb-2 font-semibold">หมวดหมู่</label>
      <select name="category_id" required class="w-full p-2 border rounded mb-4">
        <option value="">-- เลือกหมวดหมู่ --</option>
        <?php
        $result = $conn->query("SELECT * FROM categories");
        while ($row = $result->fetch_assoc()):
        ?>
          <option value="<?= $row['id']; ?>"><?= $row['name']; ?></option>
        <?php endwhile; ?>
      </select>

      <label class="block mb-2 font-semibold">ความสำคัญ</label>
      <select name="priority" required class="w-full p-2 border rounded mb-6">
        <option value="low">ต่ำ</option>
        <option value="medium" selected>ปานกลาง</option>
        <option value="high">สูง</option>
      </select>

      <button type="submit" class="w-full bg-[#F2845C] hover:bg-[#D91604] text-white py-2 rounded text-lg font-semibold">
        🚀 ส่งคำร้อง
      </button>
    </form>
  </div>
</main>
</body>
</html>

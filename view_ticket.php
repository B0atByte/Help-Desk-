<?php include 'auth.php'; include 'config/db.php';

$user = $_SESSION['user'];
$user_id = $user['id'];
$role = $user['role'];

function thPriority($priority) {
  return [
    'low' => 'ต่ำ',
    'medium' => 'ปานกลาง',
    'high' => 'สูง'
  ][$priority] ?? $priority;
}

function thStatus($status) {
  return [
    'new' => 'ใหม่',
    'in_progress' => 'กำลังดำเนินการ',
    'resolved' => 'แก้ไขแล้ว',
    'closed' => 'ปิดงาน'
  ][$status] ?? $status;
}

$status_filter = isset($_GET['status']) ? $_GET['status'] : null;
$sql = "SELECT DISTINCT t.*, c.name AS category, u.name AS reporter, tech.name AS technician_name FROM tickets t 
        JOIN categories c ON t.category_id = c.id 
        JOIN users u ON t.user_id = u.id 
        LEFT JOIN users tech ON t.assigned_to = tech.id 
        WHERE 1";

if ($role === 'user') {
  $sql .= " AND t.user_id = $user_id";
}

if ($status_filter !== null) {
  $sql .= " AND t.status = '" . $conn->real_escape_string($status_filter) . "'";
} else {
  $sql .= " AND t.status != 'closed'";
}

$sql .= " ORDER BY t.created_at DESC";
$tickets = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>รายการแจ้งปัญหา</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
      <a href="view_ticket.php?status=closed" class="hover:underline">📁 งานที่ปิดแล้ว</a>
    <?php endif; ?>
    <a href="logout.php" class="hover:underline text-yellow-300 mt-12">🚪 ออกจากระบบ</a>
  </nav>
</aside>

<!-- Main Content -->
<main class="flex-1 p-8">
  <h2 class="text-2xl font-bold text-[#A61103] mb-6">รายการแจ้งปัญหา</h2>

  <?php if ($tickets && $tickets->num_rows > 0): ?>
    <?php while ($row = $tickets->fetch_assoc()): ?>
    <div class="bg-white rounded-xl shadow p-6 mb-6">
      <h3 class="text-xl font-bold text-[#7092AB]"><?= htmlspecialchars($row['title']) ?></h3>
      <p class="text-sm text-gray-700">
        หมวดหมู่: <?= htmlspecialchars($row['category']) ?> |
        ผู้แจ้ง: <?= htmlspecialchars($row['reporter']) ?> |
        ผู้รับผิดชอบ: <?= $row['technician_name'] ? htmlspecialchars($row['technician_name']) : '<span class="text-red-600">ยังไม่มี</span>' ?>
      </p>
      <p class="text-sm">
        ความสำคัญ: <?= thPriority($row['priority']) ?> |
        สถานะ: <?= thStatus($row['status']) ?> |
        แจ้งเมื่อ: <?= date('d/m/Y H:i', strtotime($row['created_at'])) ?>
      </p>
      <p class="mt-2 bg-gray-100 p-3 rounded">รายละเอียด: <?= nl2br(htmlspecialchars($row['description'])) ?></p>

      <?php if ($row['status'] !== 'closed'): ?>
        <?php if ($role != 'user' && !empty($row['assigned_to']) && ($row['assigned_to'] == $user_id || $role == 'admin')): ?>
          <form method="POST" action="update_status.php" class="mt-3">
            <input type="hidden" name="ticket_id" value="<?= $row['id'] ?>">
            <label class="block font-semibold mb-1">อัปเดตสถานะ:</label>
            <select name="status" class="w-full border p-2 rounded">
              <option value="new" <?= $row['status'] == 'new' ? 'selected' : '' ?>>ใหม่</option>
              <option value="in_progress" <?= $row['status'] == 'in_progress' ? 'selected' : '' ?>>กำลังดำเนินการ</option>
              <option value="resolved" <?= $row['status'] == 'resolved' ? 'selected' : '' ?>>แก้ไขแล้ว</option>
              <option value="closed" <?= $row['status'] == 'closed' ? 'selected' : '' ?>>ปิดงาน</option>
            </select>
            <button type="submit" class="mt-2 bg-yellow-600 text-white py-2 px-4 rounded hover:bg-yellow-700">อัปเดต</button>
          </form>
        <?php endif; ?>

        <?php if ($role == 'technician' && empty($row['assigned_to'])): ?>
          <form method="POST" action="assign_ticket_self.php" class="mt-3">
            <input type="hidden" name="ticket_id" value="<?= $row['id'] ?>">
            <button type="submit" class="bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700">✅ รับงานนี้</button>
          </form>
        <?php endif; ?>

        <?php if ($role == 'admin'): ?>
          <form method="POST" action="assigned_tickets.php" class="mt-3">
            <input type="hidden" name="ticket_id" value="<?= $row['id'] ?>">
            <label class="block font-semibold mb-1">มอบหมายให้ช่าง:</label>
            <select name="assigned_to" class="w-full border p-2 rounded">
              <option value="">-- เลือก --</option>
              <?php
              $techs = $conn->query("SELECT id, name FROM users WHERE role='technician'");
              while ($tech = $techs->fetch_assoc()): ?>
                <option value="<?= $tech['id'] ?>"><?= htmlspecialchars($tech['name']) ?></option>
              <?php endwhile; ?>
            </select>
            <button type="submit" class="mt-2 bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">มอบหมาย</button>
          </form>
        <?php endif; ?>
      <?php endif; ?>

      <?php if ($row['status'] !== 'closed'): ?>
        <div class="mt-6 border-t pt-4">
          <h4 class="font-semibold text-[#A61103] mb-2">💬 พูดคุยกับผู้แจ้ง</h4>
          <div class="bg-gray-100 h-40 overflow-y-auto p-2 mb-2 text-sm chat-box" data-ticket-id="<?= $row['id'] ?>" id="chat-box-<?= $row['id'] ?>">
            กำลังโหลดข้อความ...
          </div>
          <form class="send-comment-form" data-ticket-id="<?= $row['id'] ?>">
            <input type="hidden" name="ticket_id" value="<?= $row['id'] ?>">
            <textarea name="comment" class="w-full border p-2 rounded text-sm" rows="2" placeholder="พิมพ์ข้อความ..."></textarea>
            <button type="submit" class="mt-1 bg-[#7092AB] text-white px-4 py-1 rounded hover:bg-[#A61103]">ส่ง</button>
          </form>
        </div>
      <?php endif; ?>

    </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p class="text-gray-600 text-center text-lg">ไม่พบรายการแจ้งปัญหา</p>
  <?php endif; ?>
</main>

<script>
function loadComments(ticketId) {
  $.get('ajax_load_comments.php', { ticket_id: ticketId }, function(data) {
    const chatBox = $('#chat-box-' + ticketId);
    const isAtBottom = chatBox.scrollTop() + chatBox.innerHeight() >= chatBox[0].scrollHeight - 50;
    const previousContent = chatBox.html();
    chatBox.html(data);
    if (!isAtBottom && previousContent !== data) {
      chatBox.addClass('ring ring-pink-400');
      setTimeout(() => chatBox.removeClass('ring ring-pink-400'), 1500);
    }
  });
}

setInterval(function() {
  $('.chat-box').each(function() {
    const ticketId = $(this).data('ticket-id');
    loadComments(ticketId);
  });
}, 3000);

$(document).on('submit', '.send-comment-form', function(e) {
  e.preventDefault();
  const form = $(this);
  const ticketId = form.data('ticket-id');
  $.post('ajax_send_comment.php', form.serialize(), function() {
    form.find('textarea').val('');
    loadComments(ticketId);
  });
});
</script>

</body>
</html>

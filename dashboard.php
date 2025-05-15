<?php include 'auth.php'; include 'config/db.php'; ?>
<?php
$user_id = $_SESSION['user']['id'];
$role = $_SESSION['user']['role'];

function countTickets($status) {
  global $conn, $user_id, $role;
  $where = ($role === 'user') ? "user_id = $user_id" : "1";
  $sql = "SELECT COUNT(*) AS total FROM tickets WHERE $where AND status = '$status'";
  $result = $conn->query($sql);
  return $result->fetch_assoc()['total'];
}

$totalNew = countTickets('new');
$totalProgress = countTickets('in_progress');
$totalResolved = countTickets('resolved');
$totalClosed = countTickets('closed');
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>แดชบอร์ด - Bargainpoint</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    let hasPlayed = false;
    function checkNewMessages() {
      fetch('check_new_messages.php')
        .then(res => res.json())
        .then(data => {
          const alertBox = document.getElementById('new-message-alert');
          if (data.new > 0) {
            alertBox.classList.remove('hidden');
            if (!hasPlayed) {
              const audio = new Audio('notify.mp3');
              audio.play();
              hasPlayed = true;
            }
          } else {
            alertBox.classList.add('hidden');
            hasPlayed = false;
          }
        });
    }
    setInterval(checkNewMessages, 10000);
  </script>
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

  <!-- Dashboard Content -->
  <main class="flex-1 p-8">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold text-[#A61103]">สรุปสถานะการแจ้งปัญหา</h2>
      <span class="text-sm text-gray-700">👋 สวัสดี, <?php echo $_SESSION['user']['name']; ?></span>
    </div>

    <div id="new-message-alert" class="mb-4 hidden bg-yellow-100 border border-yellow-300 text-yellow-800 px-4 py-2 rounded">
      📩 คุณมีข้อความใหม่จากระบบแจ้งปัญหา
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
      <a href="view_ticket.php?status=new" class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition block">
        <h3 class="text-md font-semibold text-gray-700">🆕 ใหม่</h3>
        <p class="text-3xl text-[#D91604] font-bold mt-2"><?php echo $totalNew; ?></p>
      </a>
      <a href="view_ticket.php?status=in_progress" class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition block">
        <h3 class="text-md font-semibold text-gray-700">🔧 กำลังดำเนินการ</h3>
        <p class="text-3xl text-[#F59E0B] font-bold mt-2"><?php echo $totalProgress; ?></p>
      </a>
      <a href="view_ticket.php?status=resolved" class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition block">
        <h3 class="text-md font-semibold text-gray-700">✅ แก้ไขแล้ว</h3>
        <p class="text-3xl text-[#10B981] font-bold mt-2"><?php echo $totalResolved; ?></p>
      </a>
      <a href="view_ticket.php?status=closed" class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition block">
        <h3 class="text-md font-semibold text-gray-700">📁 ปิดงาน</h3>
        <p class="text-3xl text-[#6B7280] font-bold mt-2"><?php echo $totalClosed; ?></p>
      </a>
    </div>
  </main>
</body>
</html>

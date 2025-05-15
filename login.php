<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>เข้าสู่ระบบ - Bargainpoint</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex">

  <!-- ฝั่งซ้าย: พื้นหลังพร้อมเบลอ + ข้อความ -->
  <div class="w-1/2 relative overflow-hidden">
    <img src="image/bpl2.jpg" alt="Background" class="absolute w-full h-full object-cover blur-sm scale-110">
    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
      <h1 class="text-white text-4xl font-bold text-center drop-shadow-lg">
        Bargainpoint Service System
      </h1>
    </div>
  </div>

  <!-- ฝั่งขวา: ฟอร์ม -->
  <div class="w-1/2 bg-gray-100 flex items-center justify-center">
    <div class="w-3/4 max-w-md bg-white p-8 rounded shadow-md">
      
      <!-- โลโก้ -->
      <div class="flex justify-center mb-4">
        <img src="image/BPL.png" alt="Logo" class="h-16">
      </div>

      <h2 class="text-2xl font-semibold text-center text-[#A61103] mb-6">เข้าสู่ระบบ</h2>

      <form method="POST" action="login_process.php">
        <label class="block mb-2">อีเมล</label>
        <input type="email" name="email" required class="w-full p-2 border border-gray-300 rounded mb-4">

        <label class="block mb-2">รหัสผ่าน</label>
        <input type="password" name="password" required class="w-full p-2 border border-gray-300 rounded mb-4">

        <div class="flex justify-between items-center text-sm text-gray-600 mb-4">
          <label><input type="checkbox"> จดจำฉัน</label>
          <a href="#" class="text-[#F2845C] hover:underline">ลืมรหัสผ่าน?</a>
        </div>

        <button class="w-full bg-[#F2845C] hover:bg-[#D91604] text-white p-2 rounded mb-4">เข้าสู่ระบบ</button>
      </form>

      <p class="text-center text-sm mb-4">ยังไม่มีบัญชี? 
        <a href="register.php" class="text-[#7092AB] hover:underline">สมัครสมาชิก</a>
      </p>

      <!-- ปุ่ม Dev Login -->
      <div class="border-t border-gray-200 pt-4">
        <p class="font-semibold mb-2 text-gray-600 text-center">Dev เข้าระบบด่วน:</p>
        <div class="flex flex-wrap justify-center gap-2">
          <a href="quick_login.php?role=admin" class="bg-red-600 text-white px-4 py-1 rounded hover:bg-red-700 text-sm">เข้าเป็น หัวหน้า</a>
          <a href="quick_login.php?role=technician" class="bg-blue-600 text-white px-4 py-1 rounded hover:bg-blue-700 text-sm">ITsupport</a>
          <a href="quick_login.php?role=user" class="bg-gray-600 text-white px-4 py-1 rounded hover:bg-gray-700 text-sm">พนักงาน</a>
        </div>
      </div>
    </div>
  </div>

</body>
</html>

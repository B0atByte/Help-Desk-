<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>สมัครสมาชิก - Bargainpoint</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex">

  <!-- ฝั่งซ้าย: รูปเบลอ + ข้อความ -->
  <div class="w-1/2 relative overflow-hidden">
    <img src="image/bpl2.jpg" alt="Background" class="absolute w-full h-full object-cover blur-sm scale-110">
    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center">
      <h1 class="text-white text-4xl font-bold text-center drop-shadow-lg">
        Bargainpoint Service System
      </h1>
    </div>
  </div>

  <!-- ฝั่งขวา: ฟอร์มสมัคร -->
  <div class="w-1/2 bg-gray-100 flex items-center justify-center">
    <div class="w-3/4 max-w-md bg-white p-8 rounded shadow-md">
      
      <!-- โลโก้ -->
      <div class="flex justify-center mb-4">
        <img src="image/BPL.png" alt="Logo" class="h-16">
      </div>

      <h2 class="text-2xl font-semibold text-center text-[#A61103] mb-6">สร้างบัญชีผู้ใช้งาน</h2>

      <form method="POST" action="register_process.php">
        <label class="block mb-2">ชื่อ - นามสกุล</label>
        <input type="text" name="name" required class="w-full p-2 border border-gray-300 rounded mb-4">

        <label class="block mb-2">อีเมล</label>
        <input type="email" name="email" required class="w-full p-2 border border-gray-300 rounded mb-4">

        <label class="block mb-2">รหัสผ่าน</label>
        <input type="password" name="password" required class="w-full p-2 border border-gray-300 rounded mb-4">

        <label class="block mb-2">บทบาท</label>
        <select name="role" class="w-full p-2 border border-gray-300 rounded mb-4">
          <option value="user">ผู้ใช้งานทั่วไป</option>
          <option value="technician">เจ้าหน้าที่ IT</option>
          <option value="admin">ผู้ดูแลระบบ</option>
        </select>

        <button class="w-full bg-[#7092AB] hover:bg-[#A61103] text-white p-2 rounded">สมัครสมาชิก</button>
      </form>

      <p class="text-center mt-4 text-sm">
        มีบัญชีแล้ว? 
        <a href="login.php" class="text-[#F2845C] hover:underline">เข้าสู่ระบบ</a>
      </p>
    </div>
  </div>
</body>
</html>

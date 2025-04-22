<?php
include 'db.php';

// ตรวจสอบว่าเป็นผู้ดูแลระบบ
// เพิ่มการตรวจสอบการเข้าสู่ระบบสำหรับผู้ดูแลระบบที่นี่
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการระบบ</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            display: flex;
            justify-content: center; /* จัดให้อยู่ตรงกลางแนวนอน */
            align-items: center; /* จัดให้อยู่ตรงกลางแนวตั้ง */
            height: 100vh; /* ใช้ความสูงเต็มหน้าจอ */
            margin: 0;
            background-color: #1a1a1a; /* สีพื้นหลัง */
        }

        .container {
            text-align: center; /* จัดข้อความให้อยู่ตรงกลาง */
            background-color: white; /* สีพื้นหลังของกรอบ */
            padding: 20px; /* เพิ่มระยะห่างภายในกรอบ */
            border: 2px solid #007BFF; /* กรอบสีน้ำเงิน */
            border-radius: 10px; /* มุมโค้งมน */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* เพิ่มเงา */
        }

        h1, h2 {
            color: #333; /* เปลี่ยนสีข้อความ */
        }

        .btn {
            display: inline-block;
            width: auto;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-back {
            background-color: #28a745; /* สีเขียว */
        }

        .btn-back:hover {
            background-color: #218838; /* สีเขียวเข้มเมื่อ hover */
        }

        .link-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <h1>จัดการระบบ</h1>
        
        <a href="add_movie.php" class="btn">เพิ่มหนังใหม่</a>
        <a href="manage_movie.php" class="btn">จัดการหนังทั้งหมด</a>
        <h2>รายการลูกค้า</h2>
        <div class="link-container">
            <a href="customer_list.php" class="btn">ดูรายการลูกค้า</a>
            <a href="index_admin.php" class="btn btn-back">กลับไปหน้า Admin</a>
        </div>
    </div>
</body>
</html>


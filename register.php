<?php
session_start();
include 'db.php'; // เชื่อมต่อฐานข้อมูล

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_ID = trim($_POST["customer_ID"]);
    $customer_fname = trim($_POST["customer_fname"]);
    $customer_lname = trim($_POST["customer_lname"]);
    $customer_email = trim($_POST["customer_email"]);
    $customer_password = $_POST["customer_password"];
    $confirm_password = $_POST["confirm_password"];
    $phone_num = trim($_POST["phone_num"]);

    // ตรวจสอบว่ารหัสผ่านตรงกันไหม
    if ($customer_password !== $confirm_password) {
        $_SESSION["error"] = "รหัสผ่านไม่ตรงกัน";
        header("Location: register.php");
        exit();
    }

    // ✅ Hash เฉพาะ password
    $hashed_customer_password = password_hash($customer_password, PASSWORD_DEFAULT);
    

    // ตรวจสอบว่า customer_ID หรือ Email ซ้ำกันหรือไม่
    $check_sql = "SELECT * FROM customers WHERE customer_ID = ? OR customer_email = ?";
    $check_stmt = $conn->prepare($check_sql);
    if (!$check_stmt) {
        die("เกิดข้อผิดพลาดใน SQL: " . $conn->error);
    }
    
    $check_stmt->bind_param("ss", $customer_ID, $customer_email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION["error"] = "รหัสบัตรประชาชนหรืออีเมลนี้ถูกใช้งานแล้ว";
        header("Location: register.php");
        exit();
    }

    $check_stmt->close();

    // ✅ ใช้ชื่อคอลัมน์ให้ตรงกับฐานข้อมูล
    $sql = "INSERT INTO customers (customer_ID, customer_fname, customer_lname, customer_password, phone_num, customer_email) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        die("เกิดข้อผิดพลาดใน SQL: " . $conn->error);
    }

    // ✅ แก้ให้ Hash เฉพาะ password
    $stmt->bind_param("ssssss", $customer_ID, $customer_fname, $customer_lname, $hashed_customer_password, $phone_num, $customer_email);

    // บันทึกข้อมูล
    if ($stmt->execute()) {
        $_SESSION["success"] = "สมัครสมาชิกสำเร็จ! กรุณาเข้าสู่ระบบ";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION["error"] = "เกิดข้อผิดพลาด: " . $stmt->error;
        header("Location: register.php");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ลงทะเบียน</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="register-container">
    <h2>สมัครสมาชิก</h2>

    <form action="register.php" method="POST">
        <div class="input-group">
            <label>รหัสบัตรประชาชน</label>
            <input type="text" name="customer_ID" required>
        </div>

        <div class="input-group">
            <label>ชื่อ</label>
            <input type="text" name="customer_fname" required>
        </div>

        <div class="input-group">
            <label>นามสกุล</label>
            <input type="text" name="customer_lname" required>
        </div>

        <div class="input-group">
            <label>อีเมล</label>
            <input type="email" name="customer_email" required>
        </div>

        <div class="input-group">
            <label>รหัสผ่าน</label>
            <input type="password" name="customer_password" required minlength="8">
        </div>

        <div class="input-group">
            <label>ยืนยันรหัสผ่าน</label>
            <input type="password" name="confirm_password" required minlength="8">
        </div>

        <div class="input-group">
            <label>เบอร์โทร</label>
            <input type="text" name="phone_num" required>
        </div>

        <button type="submit" class="btn">สมัครสมาชิก</button>
    </form>

    <p><a href="login.php">เข้าสู่ระบบ</a></p>
    <a href="index.php" class="back-btn">กลับไปหน้าแรก</a>
</div>

</body>
</html>
<?php
session_start(); // เริ่มต้นเซสชัน
include 'db.php'; // เชื่อมต่อกับฐานข้อมูล

// ตรวจสอบว่ามีข้อมูลถูกส่งมาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // ป้องกัน SQL Injection โดยใช้ Prepared Statements
    $sql = "SELECT * FROM customers WHERE customer_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email); // ใช้ s สำหรับ string (email)
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // พบข้อมูลลูกค้า
        $row = $result->fetch_assoc();
        
        // ตรวจสอบรหัสผ่านที่แฮชแล้ว
        if (password_verify($password, $row['customer_password'])) {
            // เก็บข้อมูลลูกค้าในเซสชัน
            $_SESSION['customer_ID'] = $row['customer_ID'];
            
            // ถ้าเป็น admin (ตัวอย่างการตรวจสอบ admin)
            if ($row['customer_email'] === 'admin@gmail.com') {
                header("Location: index_Admin.php");
                exit();
            } else {
                // เปลี่ยนเส้นทางไปยังหน้าโปรไฟล์
                header("Location: index.php");
                exit();
            }
        } else {
            echo "รหัสผ่านไม่ถูกต้อง";
        }
    } else {
        echo "ไม่พบผู้ใช้ด้วยอีเมลนี้";
    }
} else {
    // ถ้าทำการเข้าถึงไฟล์นี้โดยตรง
    header("Location: login.php"); // เปลี่ยนเส้นทางไปยังหน้าเข้าสู่ระบบ
    exit();
}
?>

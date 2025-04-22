<?php
session_start();
include 'db.php';

// ตรวจสอบว่ามี ID ที่ถูกส่งมาหรือไม่
if (isset($_GET['id'])) {
    $movie_ID = intval($_GET['id']); // แปลงให้เป็นตัวเลขเพื่อความปลอดภัย

    // ดึงข้อมูลหนังจากฐานข้อมูล
    $sql = "SELECT * FROM movie WHERE movie_ID = $movie_ID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $movie = $result->fetch_assoc();

        // ถ้ายังไม่มีตะกร้า ให้สร้าง
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // เพิ่มหนังลงตะกร้า (ใช้ movie_ID เป็น key)
        $_SESSION['cart'][$movie_ID] = [
            "movie_name" => $movie['movie_name'],
            "movie_price" => $movie['movie_price']
        ];

        // กลับไปที่ตะกร้า
        header("Location: cart.php");
        exit();

        
    }
}

// ถ้าไม่มีหนังที่ต้องการ ส่งกลับไปหน้าหลัก
header("Location: index.php");
exit();
?>

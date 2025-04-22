<?php
session_start();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ตะกร้าหนัง</title>
    <link rel="stylesheet" href="style.css">
    <style>
    .checkout-btn {
        display: inline-block; /* ทำให้ปุ่มไม่ยืดเต็มความกว้าง */
        width: auto; /* ให้ขนาดปุ่มพอดีกับข้อความ */
        padding: 10px 20px; /* เพิ่ม padding เพื่อความสวยงาม */
        font-size: 16px; /* ขนาดฟอนต์ */
        font-weight: bold;
        text-align: center; /* จัดข้อความให้อยู่ตรงกลาง */
        background-color: #007bff; /* สีพื้นหลัง */
        color: white; /* สีข้อความ */
        border: none;
        border-radius: 8px; /* มุมโค้งมน */
        cursor: pointer;
        text-decoration: none; /* ลบขีดเส้นใต้ */
    }

    .checkout-btn:hover {
        background-color: #0056b3; /* สีเมื่อ hover */
    }
</style>
</head>
<body>

<div class="cart-container">
    <h2>ตะกร้าหนัง</h2>

    <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
        <ul class="cart-list">
            <?php foreach ($_SESSION['cart'] as $movie_ID => $movie): ?>
                <li class="cart-item">
                    <span class="movie-name"><?php echo htmlspecialchars($movie['movie_name']); ?></span>
                    <span class="movie-price"><?php echo htmlspecialchars($movie['movie_price']); ?> บาท</span>
                    <a href="remove_from_cart.php?id=<?php echo urlencode($movie_ID); ?>" class="remove-btn">[ลบออก]</a>
                </li>
            <?php endforeach; ?>
        </ul>
        <p class="rental-duration">⏳ ระยะเวลาเช่า 7 วัน</p>
        <a href="checkout.php" class="btn checkout-btn">✅ ยืนยันการเช่า</a>
    <?php else: ?>
        <p class="empty-cart">🛒 ยังไม่มีหนังในตะกร้า</p>
    <?php endif; ?>

    <div class="cart-links">
        <a href="movies.php" class="back-btn">⬅ กลับไปเลือกหนัง</a>
        <a href="index.php" class="back-btn">⬅ กลับไปหน้าหลัก</a>
    </div>
</div>

</body>
</html>

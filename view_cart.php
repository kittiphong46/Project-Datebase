<?php
session_start();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ตะกร้าหนัง</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>ตะกร้าหนัง</h1>

    <?php if (!empty($_SESSION['cart'])): ?>
        <ul>
            <?php foreach ($_SESSION['cart'] as $movie_ID => $movie): ?>
                <li>
                    <strong><?php echo htmlspecialchars($movie['movie_name']); ?></strong> - 
                    <?php echo htmlspecialchars($movie['movie_price']); ?> บาท 
                    <a href="remove_from_cart.php?id=<?php echo $movie_ID; ?>">[ลบออก]</a>
                </li>
            <?php endforeach; ?>
        </ul>
        <a href="checkout.php">ยืนยันการเช่า</a>
    <?php else: ?>
        <p>ไม่มีหนังในตะกร้า</p>
    <?php endif; ?>

    <a href="movies.php">⬅ กลับไปเลือกหนัง</a>
    <a href="index.php">⬅ กลับไปหน้าหลัก</a>
</body>
</html>

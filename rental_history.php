<?php
session_start();
include 'db.php';

// ตรวจสอบว่าผู้ใช้ล็อกอินหรือยัง
if (!isset($_SESSION['customer_ID'])) {
    header("Location: login.php?error=กรุณาเข้าสู่ระบบก่อนดูประวัติการเช่า");
    exit();
}

$customer_ID = $_SESSION['customer_ID'];

// ใช้ prepared statement ป้องกัน SQL Injection
$sql = "SELECT rent.*, movie.movie_name, movie.movie_Path 
        FROM rent 
        JOIN movie ON rent.movie_ID = movie.movie_ID 
        WHERE rent.customer_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customer_ID);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ประวัติการเช่า</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1a1a1a;
            color: white;
            text-align: center;
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }
        .info {
            font-size: 17px;
            line-height: 2;
            width: 100%;
            max-width: 600px;
            padding: 18px;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            background-color: #2a2a2a;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        img {
            width: 150px;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
        }
        .info {
            text-align: left;
        }
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #ff4757;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-btn:hover {
            background-color: #e84118;
        }
        h1 {
            font-size: 28px;
            color: white; /* เพิ่มบรรทัดนี้ */
            margin-bottom: 15px;
    </style>
</head>
<body>

<div class="container">
    <h1>ประวัติการเช่า</h1>
    
    <?php if ($result->num_rows > 0): ?>
        <ul>
            <?php while ($row = $result->fetch_assoc()): ?>
                <li>
                    <img src="<?php echo htmlspecialchars($row['movie_Path']); ?>" alt="รูปภาพหนัง">
                    <div class="info">
                        <strong><?php echo htmlspecialchars($row['movie_name']); ?></strong><br>
                        วันที่เริ่ม: <?php echo htmlspecialchars($row['date_start']); ?> <br>
                        คืนภายในวันที่: <?php echo htmlspecialchars($row['date_return']); ?> <br>
                        สถานะ: <?php echo htmlspecialchars($row['rent_status']); ?>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>ไม่มีประวัติการเช่า</p>
    <?php endif; ?>

    <a href="index.php" class="back-btn">⬅ กลับไปหน้าแรก</a>
</div>

</body>
</html>

<?php
session_start();
include 'db.php';

if (!isset($_SESSION['customer_ID'])) {
    // ถ้ายังไม่เข้าสู่ระบบ ให้ redirect ไปที่หน้าเข้าสู่ระบบ
    header("Location: login.php");
    exit();
}

$customer_ID = $_SESSION['customer_ID'];
$sql = "SELECT * FROM Fine WHERE customer_ID = $customer_ID";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ค่าปรับ</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1a1a1a;
            color: white;
            text-align: center;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background-color: #2a2a2a;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.2);
        }

        h1 {
            color: #ffcc00;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            background-color: #333;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
            font-size: 18px;
        }

        .fine-type {
            font-weight: bold;
            font-size: 20px;
            color: #ff4757;
        }

        .fine-status {
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }

        .pending {
            background-color: orange;
            color: black;
        }

        .paid {
            background-color: green;
            color: white;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #ff4757;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease-in-out;
        }

        .back-btn:hover {
            background-color: #e84118;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>ค่าปรับ</h1>
    <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
            <li>
                <span class="fine-type">ประเภท: <?php echo htmlspecialchars($row['fine_type']); ?></span>
                จำนวนเงิน: <?php echo number_format($row['damage_price'], 2); ?> บาท  
                <span class="fine-status 
                    <?php echo ($row['fine_status'] == 'ยังไม่จ่าย') ? 'pending' : 'paid'; ?>">
                    สถานะ: <?php echo htmlspecialchars($row['fine_status']); ?>
                </span>
            </li>
        <?php endwhile; ?>
    </ul>
    <a href="index.php" class="back-btn">⬅ กลับไปหน้าแรก</a>
</div>

</body>
</html>

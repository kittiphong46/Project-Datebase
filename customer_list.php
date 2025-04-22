<?php
session_start();
include 'db.php';

// ดึงข้อมูลลูกค้าจากฐานข้อมูล
$sql = "SELECT * FROM customers";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายการลูกค้า</title>

    <!-- เขียน CSS ในหน้านี้เลย -->
    <style>
        body {
            background-color: #121212;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            text-align: center; /* จัดให้องค์ประกอบใน body อยู่ตรงกลาง */
        }

        h1 {
            color: white; /* สีขาว */
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: #ffffff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        table th, table td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            color: #333; /* สีตัวหนังสือในตาราง */
        }

        table thead {
            background-color: #4CAF50;
            color: white;
        }

        a {
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .back-link {
            display: inline-block;
            text-align: center;
            margin: 30px auto; /* จัดให้อยู่ตรงกลาง */
            padding: 12px 24px;
            background-color: #4CAF50; /* สีเขียวสวย */
            color: white;
            font-size: 18px;
            border-radius: 25px; /* มนๆ กลมๆ */
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .back-link:hover {
            background-color: #45a049; /* เขียวเข้มขึ้นตอน hover */
            transform: translateY(-2px); /* เด้งขึ้นนิดๆ ตอน hover */
        }
    </style>
</head>
<body>

    <h1>รายการลูกค้า</h1>

    <table border="0"> <!-- เปลี่ยน border="1" เป็น 0 เพราะเราใช้ CSS ทำขอบ -->
        <thead>
            <tr>
                <th>ID ลูกค้า</th>
                <th>ชื่อ</th>
                <th>นามสกุล</th>
                <th>อีเมล</th>
                <th>เบอร์โทร</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['customer_ID']; ?></td>
                    <td>
                        <a href="customer_detail.php?customer_id=<?= $row['customer_ID']; ?>">
                            <?= $row['customer_fname']; ?>
                        </a>
                    </td>
                    <td>
                        <a href="customer_detail.php?customer_id=<?= $row['customer_ID']; ?>">
                            <?= $row['customer_lname']; ?>
                        </a>
                    </td>
                    <td><?php echo $row['customer_email']; ?></td>
                    <td><?php echo $row['phone_num']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="index_admin.php" class="back-link">⬅️ กลับไปหน้าแรก</a>

</body>
</html>

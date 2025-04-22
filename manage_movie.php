<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการหนังทั้งหมด</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1a1a1a;
            color: #333;
            text-align: center;
            padding: 10px;
        }

        h2 {
            color: #007BFF;
            margin-bottom: 15px;
            font-size: 20px;
        }

        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            font-size: 14px;
        }

        table th, table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: center;
        }

        table th {
            background-color: #007BFF;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:nth-child(odd) {
            background-color: #ffffff;
        }

        .btn {
            display: inline-block; /* ป้องกันปุ่มยืด */
            width: auto; /* ให้ปุ่มมีขนาดตามเนื้อหา */
            padding: 5px 10px;
            font-size: 12px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
            margin: 3px;
        }

        .btn-warning {
            background-color: #ffc107;
            color: black;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
        .back-btn {
    background-color: transparent !important; /* ลบพื้นหลังเทา */
    box-shadow: none !important; /* ลบเงา (ถ้ามี) */
    padding: 0; /* ลด padding ถ้าไม่ต้องการเว้นระยะ */
    margin-top: 20px; /* อันนี้คงไว้ได้ */
}

    </style>
</head>
<body>
    <?php
    include('db.php');

    // ดึงข้อมูลหนังพร้อมตรวจสอบสถานะการเช่า
    $result = mysqli_query($conn, "
        SELECT m.*, t.type_name, 
               (SELECT COUNT(*) FROM rent WHERE movie_ID = m.movie_ID AND (date_return IS NULL OR date_return = '0000-00-00')) AS pending_rentals
        FROM movie m
        INNER JOIN type_movie t ON m.type_ID = t.type_ID
    ");
    ?>

    <h2>จัดการหนังทั้งหมด</h2>
    <table>
        <tr>
            <th>ชื่อหนัง</th>
            <th>ประเภท</th>
            <th>ราคา</th>
            <th>สถานะ</th>
            <th>จัดการ</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?= htmlspecialchars($row['movie_name']); ?></td>
            <td><?= htmlspecialchars($row['type_name']); ?></td>
            <td><?= htmlspecialchars($row['movie_price']); ?> บาท</td>
            <td><?= $row['movie_Status'] ? '🟢 ขายอยู่' : '🔴 หยุดขาย'; ?></td>
            <td>
                <a href="<?= $row['movie_Status'] ? "stop_movie.php?movie_ID={$row['movie_ID']}" : "start_movie.php?movie_ID={$row['movie_ID']}" ?>" 
                   class="btn <?= $row['movie_Status'] ? 'btn-warning' : 'btn-success'; ?>">
                   <?= $row['movie_Status'] ? '🚫 หยุดขาย' : '✅ ขายใหม่'; ?>
                </a>

                <?php if ($row['movie_Status'] == 0 && $row['pending_rentals'] == 0): ?>
                    <a href="delete_movie.php?movie_ID=<?= $row['movie_ID']; ?>" 
                       onclick="return confirm('ยืนยันการลบหนังนี้ออกจากระบบหรือไม่?');" 
                       class="btn btn-danger">🗑️ ลบ</a>
                <?php else: ?>
                    <span style="color: gray; font-size: 12px;">ไม่สามารถลบได้</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <div class="back-btn">
        <a href="index_admin.php" class="btn btn-secondary">🔙 กลับไปหน้า Admin</a>
    </div>
</body>
</html>

<?php
include('db.php'); // ไฟล์เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่ามีการส่ง customer_id มาหรือไม่
if (!isset($_GET['customer_id']) || !is_numeric($_GET['customer_id'])) {
    die("Invalid customer ID");
}

$customer_id = intval($_GET['customer_id']); // แปลงเป็นตัวเลขเพื่อความปลอดภัย

// ดึงข้อมูลลูกค้า
$customer_query = $conn->prepare("SELECT * FROM customers WHERE customer_ID = ?");
$customer_query->bind_param("i", $customer_id);
$customer_query->execute();
$customer_result = $customer_query->get_result();
$customer = $customer_result->fetch_assoc();

if (!$customer) {
    die("Customer not found");
}

// ดึงข้อมูลการเช่าจากตาราง rent
$rent_query = $conn->prepare("
    SELECT r.*, m.movie_name
    FROM rent r
    INNER JOIN movie m ON r.movie_ID = m.movie_ID
    WHERE r.customer_ID = ?
");
$rent_query->bind_param("i", $customer_id);
$rent_query->execute();
$rent_result = $rent_query->get_result();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายละเอียดลูกค้า</title>
    <link rel="stylesheet" href="style.css"> <!-- เพิ่มไฟล์ CSS -->
    <style>
        h1 {
            color: white; /* กำหนดสีข้อความเป็นสีขาว */
            text-align: center; /* จัดข้อความให้อยู่ตรงกลาง */
        }

        h2 {
            color: white; /* กำหนดสีข้อความเป็นสีขาว */
            text-align: center; /* จัดข้อความให้อยู่ตรงกลาง */
        }

        .btn {
            display: inline-block; /* ทำให้ปุ่มมีขนาดพอดีกับข้อความ */
            width: auto; /* ขนาดปุ่มพอดีกับข้อความ */
            padding: 8px 16px; /* เพิ่ม padding เพื่อความสวยงาม */
            font-size: 14px; /* ขนาดฟอนต์ */
            font-weight: bold;
            text-align: center; /* จัดข้อความให้อยู่ตรงกลาง */
            background-color: #28a745; /* สีพื้นหลัง */
            color: white; /* สีข้อความ */
            border: none;
            border-radius: 5px; /* มุมโค้งมน */
            text-decoration: none; /* ลบขีดเส้นใต้ */
            cursor: pointer;
        }

        .btn:hover {
            background-color: #218838; /* สีเมื่อ hover */
        }

        <style>
/* อันเก่า ๆ ยังอยู่เหมือนเดิม เพิ่มเติมคือ... */

.button-container {
    position: fixed; /* ตรึงตำแหน่ง */
    bottom: 20px; /* ระยะห่างจากขอบล่าง */
    left: 50%; /* ด้านซ้าย 50% */
    transform: translateX(-50%); /* ขยับกลับไปครึ่งนึง เพื่อให้อยู่ตรงกลางพอดี */
    text-align: center;
    z-index: 1000; /* ลอยอยู่บนสุด */
}

.back-link {
    display: inline-block;
    padding: 12px 24px;
    background-color: #4CAF50;
    color: white;
    font-size: 18px;
    border-radius: 25px;
    text-decoration: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.back-link:hover {
    background-color: #45a049;
    transform: translateY(-2px);
}
</style>

    </style>
</head>
<body>
    <h1>รายละเอียดลูกค้า</h1>
    <h2>ข้อมูลลูกค้า: <?= htmlspecialchars($customer['customer_fname'] . ' ' . $customer['customer_lname']); ?></h2>
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ชื่อหนัง</th>
                <th>เวลาเริ่มเช่า</th>
                <th>สถานะ</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($rent = $rent_result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($rent['movie_name']); ?></td>
                    <td><?= htmlspecialchars($rent['date_start']); ?></td>
                    <td><?= $rent['rent_status']; ?></td>
                    <td>
                    <?php if ($rent['rent_status'] == 'ยังไม่คืน'): ?>
                    <a href="return_movie.php?rent_ID=<?= htmlspecialchars($rent['rent_ID']); ?>&customer_id=<?= $customer_id; ?>" class="btn btn-success">คืน</a>
                    <?php else: ?>
                        <?php
                        // เช็คว่ามีค่าปรับคืนหนังช้าหรือไม่
                        $rentID = $rent['rent_ID'];
                        $fine_query = $conn->prepare("SELECT * FROM fine WHERE customer_ID = ? AND fine_type = 'คืนหนังช้า' AND fine_date = (SELECT date_return FROM rent WHERE rent_ID = ?)");
                        $fine_query->bind_param("ii", $customer_id, $rentID);
                        $fine_query->execute();
                        $fine_result = $fine_query->get_result();
                        $is_late = $fine_result->num_rows > 0;
                        ?>
                        <span style="color: green;">คืนแล้ว<?= $is_late ? ' (เลยกำหนด)' : ''; ?></span>
                    <?php endif; ?>

                        <!-- ปุ่มค่าปรับ/ชำรุด -->
                        <a href="damage_fee.php?rent_ID=<?= htmlspecialchars($rent['rent_ID']); ?>&customer_id=<?= $customer_id; ?>" 
                        class="btn btn-warning" style="margin-left: 8px;">
                        ค่าปรับ/ชำรุด
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <div class="button-container">
    <a href="fine_receipt.php?customer_id=<?= $customer_id ?>" class="back-link" style="background-color: #ffc107; color: black;">🧾 ดูใบเสร็จค่าปรับ</a>
    <a href="index_admin.php" class="back-link">⬅️ กลับไปหน้าแรก</a>
</div>
</body>
</html>
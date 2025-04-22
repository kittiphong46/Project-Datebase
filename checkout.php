<?php
session_start();
include 'db.php'; // ดึงไฟล์เชื่อมฐานข้อมูลมาด้วย

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

if (!isset($_SESSION['customer_ID'])) {
    header("Location: login.php");
    exit();
}

$customer_ID = $_SESSION['customer_ID'];
$total_price = 0;
foreach ($_SESSION['cart'] as $movie) {
    $total_price += $movie['movie_price'];
}

$discount = $total_price * 0.05;
$net_total = $total_price - $discount;

// วันปัจจุบัน
$current_date = date('Y-m-d'); // เก็บแบบ format ฐานข้อมูล
// วันรับหนัง = วันถัดไป
$return_date = date('Y-m-d', strtotime('+7 day'));

// ----- บันทึกข้อมูลการเช่าในฐานข้อมูล -----
foreach ($_SESSION['cart'] as $movie_ID => $movie) {
    $movie_id = $movie_ID;
    $date_start = $current_date;
    $date_return = $return_date;
    $rent_status = "ยังไม่คืน"; // หรือกำหนดสถานะเอง

    $stmt = $conn->prepare("INSERT INTO rent (customer_ID, movie_ID, date_start, date_return, rent_status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisss", $customer_ID, $movie_id, $date_start, $date_return, $rent_status);
    $stmt->execute();
}
// ---------------------------------------------

// สำหรับแสดงบนใบเสร็จ
$current_date_display = date('d/m/Y');
$return_date_display = date('d/m/Y', strtotime('+1 day'));
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ใบเสร็จรับเงิน</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* (style เดิมๆ ที่พี่เขียนมาไว้แล้ว) */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
        }
        .receipt-container {
            max-width: 700px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .receipt-details p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        .total, .discount, .net-total {
            text-align: right;
            font-size: 18px;
            margin-top: 10px;
        }
        .net-total strong {
            font-size: 22px;
            color: #2e7d32;
        }
        .btn-area {
            text-align: center;
            margin-top: 30px;
        }
        .btn {
            display: inline-block;
            width: auto; /* ให้ขนาดปุ่มพอดีกับข้อความ */
            margin: 5px;
            padding: 10px 20px;
            background: #4CAF50;
            color: white;
            border-radius: 8px;
            text-decoration: none;
        }

        @media print {
            .btn-area {
                display: none;
            }
            body {
                background: none;
                padding: 0;
            }
            .receipt-container {
                box-shadow: none;
                border: none;
                width: 100%;
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>
<body>

<div class="receipt-container">
    <h2>🎟️ ใบเสร็จรับเงิน</h2>

    <div class="receipt-details">
        <p><strong>หมายเลขใบเสร็จ:</strong> <?php echo rand(100000,999999); ?></p>
        <p><strong>วันที่เช่า:</strong> <?php echo $current_date_display; ?></p>
        <p><strong>วันที่มารับหนัง:</strong> <?php echo $return_date_display; ?> (ภายใน 1 วัน)</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ชื่อหนัง</th>
                <th>ราคา (บาท)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['cart'] as $movie): ?>
                <tr>
                    <td><?php echo htmlspecialchars($movie['movie_name']); ?></td>
                    <td><?php echo htmlspecialchars(number_format($movie['movie_price'], 2)); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="total">
        <strong>ยอดรวม: <?php echo number_format($total_price, 2); ?> บาท</strong>
    </div>
    <div class="discount">
        <strong>ส่วนลด 5%: -<?php echo number_format($discount, 2); ?> บาท</strong>
    </div>
    <div class="net-total">
        <strong>ยอดสุทธิที่ต้องชำระ: <?php echo number_format($net_total, 2); ?> บาท</strong>
    </div>

    <div class="btn-area">
        <button onclick="window.print()" class="btn">🖨️ พิมพ์ใบเสร็จ</button>
        <a href="index.php" class="btn">🏠 กลับไปหน้าหลัก</a>
    </div>
</div>

</body>
</html>

<?php
// เคลียร์ตะกร้า หลังจากบันทึกเสร็จ
unset($_SESSION['cart']);
?>

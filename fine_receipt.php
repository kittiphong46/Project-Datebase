<?php
include('db.php');

if (!isset($_GET['customer_id']) || !is_numeric($_GET['customer_id'])) {
    die("ไม่พบลูกค้า");
}
$customer_id = intval($_GET['customer_id']);

// ดึงข้อมูลค่าปรับของลูกค้า
$stmt = $conn->prepare("SELECT fine_type, damage_price, fine_date FROM fine WHERE customer_ID = ?");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();

$fines = [];
$total_price = 0;

while ($row = $result->fetch_assoc()) {
    $fines[] = $row;
    $total_price += $row['damage_price'];
}

$net_total = $total_price;

$current_date_display = date("d/m/Y");
$return_date_display = date("d/m/Y", strtotime("+1 day"));
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ใบเสร็จค่าปรับ</title>
    <style>
        body {
            font-family: 'Sarabun', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 30px;
        }
        .receipt-container {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 5px 10px rgba(0,0,0,0.2);
        }
        h2 {
            text-align: center;
            color: #444;
        }
        .receipt-details p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        .total, .discount, .net-total {
            margin-top: 15px;
            font-size: 18px;
        }
        .btn-area {
            margin-top: 25px;
            text-align: center;
        }
        .btn {
            background-color: #28a745;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 6px;
            margin: 5px;
            font-weight: bold;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #218838;
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
    </style>
</head>
<body>

<div class="receipt-container">
    <h2>🎟️ ใบเสร็จรับเงินค่าปรับ</h2>

    <div class="receipt-details">
        <p><strong>หมายเลขใบเสร็จ:</strong> <?= rand(100000,999999); ?></p>
        <p><strong>วันที่พิมพ์:</strong> <?= $current_date_display; ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>รายการค่าปรับ</th>
                <th>วันที่</th>
                <th>จำนวนเงิน (บาท)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($fines as $fine): ?>
                <tr>
                    <td><?= htmlspecialchars($fine['fine_type']); ?></td>
                    <td><?= htmlspecialchars(date("d/m/Y", strtotime($fine['fine_date']))); ?></td>
                    <td><?= number_format($fine['damage_price'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="total"><strong>ยอดรวม: <?= number_format($total_price, 2); ?> บาท</strong></div>
    <div class="net-total"><strong>ยอดสุทธิที่ต้องชำระ: <?= number_format($net_total, 2); ?> บาท</strong></div>

    <div class="btn-area">
        <button onclick="window.print()" class="btn">🖨️ พิมพ์ใบเสร็จ</button>
        <a href="customer_detail.php?customer_id=<?= $customer_id ?>" class="btn">⬅️ ย้อนกลับ</a>
    </div>
</div>

</body>
</html>

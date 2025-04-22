<?php
include('db.php');

if (!isset($_GET['rent_ID']) || !is_numeric($_GET['rent_ID'])) {
    die("ไม่พบข้อมูลการเช่า");
}

$rent_ID = intval($_GET['rent_ID']);
$customer_id = isset($_GET['customer_id']) ? intval($_GET['customer_id']) : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fine_type = $_POST['fine_type'];
    $damage_price = floatval($_POST['damage_price']);
    $fine_date = date("Y-m-d");
    $fine_status = "ยังไม่ได้ชำระ";

    $stmt = $conn->prepare("INSERT INTO fine (fine_type, damage_price, fine_date, fine_status, customer_ID) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sdssi", $fine_type, $damage_price, $fine_date, $fine_status, $customer_id);

    if ($stmt->execute()) {
        echo "<script>alert('บันทึกข้อมูลค่าปรับเรียบร้อยแล้ว'); window.location.href = 'customer_detail.php?customer_id=$customer_id';</script>";
        exit;
    } else {
        echo "เกิดข้อผิดพลาด: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>กรอกรายละเอียดค่าปรับ</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #282c34;
            color: white;
            padding: 40px;
        }

        form {
            background-color: #3b3f46;
            padding: 30px;
            border-radius: 10px;
            width: 400px;
            margin: auto;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        textarea, input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: none;
        }

        .btn-submit {
            padding: 10px 20px;
            background-color: #28a745;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn-submit:hover {
            background-color: #218838;
        }

        .back-link {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        .back-link:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

<h2 style="text-align: center;">กรอกข้อมูลค่าปรับ/ความเสียหาย</h2>

<form method="post">
    <label for="fine_type">รายละเอียดความเสียหายหรือค่าปรับ</label>
    <textarea name="fine_type" id="fine_type" rows="4" required></textarea>

    <label for="damage_price">จำนวนเงิน (บาท)</label>
    <input type="number" name="damage_price" id="damage_price" step="0.01" min="0" required>

    <button type="submit" class="btn-submit">✅ บันทึกข้อมูล</button>
</form>

<div style="text-align: center; margin-top: 20px;">
    <a href="customer_detail.php?customer_id=<?= $customer_id ?>" class="back-link">⬅️ ย้อนกลับ</a>
</div>

</body>
</html>

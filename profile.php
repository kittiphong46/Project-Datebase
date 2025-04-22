<?php
session_start(); 

if (!isset($_SESSION['customer_ID'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

$customer_ID = $_SESSION['customer_ID'];
$sql = "SELECT * FROM customers WHERE customer_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $customer_ID);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Query failed: " . $conn->error);
}

$customer = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ข้อมูลส่วนตัว</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="profile-container">
    <h2>ข้อมูลส่วนตัว</h2>

    <div class="profile-card">
        <p><strong>ชื่อ:</strong> <?php echo $customer['customer_fname'] . ' ' . $customer['customer_lname']; ?></p>
        <p><strong>อีเมล:</strong> <?php echo $customer['customer_email']; ?></p>
        <p><strong>เบอร์โทร:</strong> <?php echo $customer['phone_num']; ?></p>
    </div>

    <a href="index.php" class="back-btn">⬅ กลับไปหน้าแรก</a>
    <a href="logout.php" class="back-btn"> logout</a>
</div>

</body>
</html>

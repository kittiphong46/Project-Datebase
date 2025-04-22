<?php
include 'db.php';

$sql = "SELECT * FROM movie";
$result = $conn->query($sql);
session_start();
if (isset($_SESSION['cart_message'])) {
    echo "<p style='color: green; font-weight: bold;'>{$_SESSION['cart_message']}</p>";
    unset($_SESSION['cart_message']); // ลบข้อความหลังจากแสดงแล้ว
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <!-- เพิ่ม Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <meta charset="UTF-8">
    <title>รายการภาพยนตร์</title>
    <link rel="stylesheet" href="style.css">
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #1a1a1a;
        color: white;
        margin: 0;
        padding: 20px;
    }
    .container {
        max-width: 1200px;
        margin: auto;
    }
    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }
    .card {
        background-color: #2a2a2a;
        border-radius: 10px;
        overflow: hidden;
        position: relative;
        text-align: center;
        transition: transform 0.3s ease-in-out;
    }
    .card:hover {
        transform: scale(1.05);
    }
    .card img {
        width: 100%;
        height: 280px;
        object-fit: cover;
        border-bottom: 3px solid #ff4757;
    }
    .card h3 {
        font-size: 16px;
        margin: 10px 0;
    }
    .badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: red;
        color: white;
        padding: 5px 10px;
        font-size: 12px;
        border-radius: 5px;
    }
    .finished {
        background-color: green;
    }
    .details-btn {
        display: inline-block;
        margin: 10px;
        padding: 5px 10px;
        background-color: #ff4757;
        color: white;
        text-decoration: none;
        border-radius: 5px;
    }
    .details-btn:hover {
        background-color: #e84118;
    }
    .disabled-btn {
        background-color: grey;
        cursor: not-allowed;
        pointer-events: none;
    }
    h1 {
        font-size: 28px;
        color: white;
        margin-bottom: 15px;
    }
    .back-btn {
        display: block;
        text-align: center;
        margin-top: 30px;
        color: #ccc;
        text-decoration: none;
    }
    .back-btn:hover {
        color: white;
    }
</style>

</head>
<body>

<div class="container">
    <h1>รายการหนัง</h1>

    <div class="grid">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="card" style="<?php echo $row['movie_Status'] == 0 ? 'opacity: 0.5;' : ''; ?>">
                <img src="<?php echo htmlspecialchars($row['movie_Path']); ?>" alt="รูปภาพหนัง">
                <h3><?php echo htmlspecialchars($row['movie_name']); ?></h3>

                <?php if ($row['movie_Status'] == 1): ?>
                    <a class="details-btn" href="movie_details.php?id=<?php echo $row['movie_ID']; ?>">ดูรายละเอียด</a>
                <?php else: ?>
                    <span class="details-btn disabled-btn">ไม่ได้ให้เช่า</span>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<a href="index.php" class="back-btn">⬅ กลับไปหน้าแรก</a>

<?php $conn->close(); ?>
</body>
</html>

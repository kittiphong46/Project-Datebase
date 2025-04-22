<?php
session_start();
include 'db.php';

// ตั้งค่าภาษาให้ MySQL รองรับ UTF-8
mysqli_set_charset($conn, "utf8mb4");
header("Content-Type: text/html; charset=UTF-8");

// รับค่า id และป้องกัน SQL Injection
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sql = "SELECT movie.*, type_movie.type_name 
        FROM movie 
        JOIN type_movie ON movie.type_ID = type_movie.type_ID 
        WHERE movie.movie_ID = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$movie = $result->fetch_assoc();

// ตรวจสอบว่าพบข้อมูลหรือไม่
if (!$movie) {
    echo "<p class='error-msg'>❌ ไม่พบข้อมูลภาพยนตร์</p>";
    exit();
}

// เตรียมแปลง movievideo_Path
$videoPath = '';
if (!empty($movie['movievideo_Path'])) {
    // แปลงลิงก์จาก watch?v= เป็น embed/
    $videoPath = str_replace("watch?v=", "embed/", $movie['movievideo_Path']);
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($movie['movie_name']); ?></title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Prompt', sans-serif;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .movie-container {
            width: 100%;
            max-width: 600px; /* จำกัดขนาดไม่ให้ใหญ่เกิน */
        }

        .movie-card {
            background: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px; /* ระยะห่างแต่ละบรรทัด */
        }

        iframe {
            width: 100%;
            height: 340px; /* ความสูง fix */
            border-radius: 10px;
        }

        h1 {
            font-size: 26px;
            margin: 10px 0;
            text-align: center;
        }

        p {
            font-size: 18px;
            margin: 5px 0;
            text-align: center;
        }

        .btn {
            width: 100%;
            max-width: 300px;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 8px;
            transition: 0.3s;
            cursor: pointer;
            text-align: center;
        }

        .add-to-cart {
            background-color: #007bff;
            color: white;
            border: none;
        }

        .add-to-cart:hover {
            background-color: #0056b3;
        }

        .back-btn {
            background-color: #6c757d;
            color: white;
        }

        .back-btn:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
<div class="movie-container">
    <div class="movie-card">

        <?php if (!empty($videoPath)) : ?>
            <iframe width="560" height="315" src="<?php echo htmlspecialchars($videoPath); ?>"
            frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen></iframe>
        <?php else: ?>
            <p>🎬 ไม่มีวิดีโอตัวอย่าง</p>
        <?php endif; ?>

        <h1><?php echo htmlspecialchars($movie['movie_name']); ?></h1>
        <p><strong>💰 ราคา:</strong> <?php echo htmlspecialchars($movie['movie_price']); ?> บาท</p>
        <p><strong>📅 วันนำเข้า:</strong> <?php echo htmlspecialchars($movie['movie_import']); ?></p>
        <p><strong>🎭 ประเภท:</strong> <?php echo htmlspecialchars($movie['type_name']); ?></p>

        <!-- ปุ่มเพิ่มลงตะกร้า -->
        <form action="cart.php" method="post">
            <input type="hidden" name="movie_ID" value="<?php echo $movie['movie_ID']; ?>">
            <input type="hidden" name="movie_name" value="<?php echo $movie['movie_name']; ?>">
            <input type="hidden" name="movie_price" value="<?php echo $movie['movie_price']; ?>">
            
            <a href="add_to_cart.php?id=<?php echo $movie['movie_ID']; ?>" class="btn add-to-cart">🛒 เพิ่มลงตะกร้า</a>
        </form>

        <a href="movies.php" class="btn back-btn">⬅️ กลับไปหน้ารายการหนัง</a>
    </div>
</div>

</body>
</html>

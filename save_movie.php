<?php
include('db.php');

$movie_name = isset($_POST['movie_name']) ? trim($_POST['movie_name']) : '';
$movie_price = isset($_POST['movie_price']) ? floatval($_POST['movie_price']) : 0;
$type_ID = isset($_POST['type_ID']) ? intval($_POST['type_ID']) : 0;
$movie_path = isset($_POST['movie_path']) ? trim($_POST['movie_path']) : '';
$movievideo_path = isset($_POST['movievideo_path']) ? trim($_POST['movievideo_path']) : '';

if (empty($movie_name) || empty($movie_price) || empty($type_ID) || empty($movie_path) || empty($movievideo_path)) {
    die("<div class='error'>❌ ข้อมูลไม่ครบ กรุณากรอกข้อมูลให้ครบถ้วน</div>");
}

$movie_Path = "photo/" . $movie_path;

$movie_import = date("Y-m-d");
$movie_Status = 1;

$stmt = $conn->prepare("INSERT INTO movie (
    movie_name, 
    movie_price, 
    movie_import, 
    movie_Status, 
    type_ID, 
    movie_Path, 
    movievideo_Path
) VALUES (?, ?, ?, ?, ?, ?, ?)");

?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ผลการเพิ่มหนัง</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #1e1e1e;
            color: white;
            text-align: center;
            padding: 20px;
        }

        .container {
            background-color: #2e2e2e;
            padding: 20px;
            border-radius: 12px;
            max-width: 500px;
            margin: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        h3 {
            color: #4CAF50;
        }

        .error {
            color: #dc3545;
            font-weight: bold;
        }

        a {
            display: inline-block;
            margin: 10px 5px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            color: white;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        a.add-more {
            background-color: #007BFF;
        }

        a.add-more:hover {
            background-color: #0056b3;
        }

        a.back-home {
            background-color: #28a745;
        }

        a.back-home:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if ($stmt) {
            $stmt->bind_param(
                "sdsiiss", 
                $movie_name, 
                $movie_price, 
                $movie_import, 
                $movie_Status, 
                $type_ID, 
                $movie_Path, 
                $movievideo_path
            );

            if ($stmt->execute()) {
                echo "<h3>✅ เพิ่มหนังสำเร็จแล้ว!</h3>";
                echo "<a href='add_movie.php' class='add-more'>เพิ่มหนังอีก</a>";
                echo "<a href='index_admin.php' class='back-home'>ไปหน้าหลัก Admin</a>";
            } else {
                echo "<div class='error'>❌ เกิดข้อผิดพลาด: " . $stmt->error . "</div>";
            }

            $stmt->close();
        } else {
            echo "<div class='error'>❌ เกิดข้อผิดพลาดในการเตรียมคำสั่ง: " . $conn->error . "</div>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>

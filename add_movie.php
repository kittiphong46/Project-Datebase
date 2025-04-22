<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เพิ่มหนังใหม่</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #1e1e1e;
            color: white;
            text-align: center;
            padding: 20px;
        }

        h2 {
            color: #4CAF50;
            margin-bottom: 20px;
        }

        form {
            background-color: #2e2e2e;
            padding: 20px;
            border-radius: 12px;
            max-width: 400px;
            margin: auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center; /* ชิดซ้าย */
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #ccc;
        }

        input[type="text"], select {
            width: 100%; /* ใช้ความกว้างเต็ม */
            max-width: 350px; /* จำกัดความกว้างสูงสุด */
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #fff;
            color: #000;
        }

        input[type="submit"], .back-btn {
            display: inline-block;
            width: auto; /* ขนาดพอดีกับข้อความ */
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none; /* ลบขีดเส้นใต้สำหรับลิงก์ */
        }

        input[type="submit"]:hover, .back-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>เพิ่มหนังใหม่</h2>
    <form method="POST" action="save_movie.php">
        <label>ชื่อหนัง:</label>
        <input type="text" name="movie_name" required>

        <label>ราคา:</label>
        <input type="text" name="movie_price" required>

        <label>ประเภท:</label>
        <select name="type_ID" required>
            <option value="">-- เลือกประเภท --</option>
            <?php
                include('db.php');
                $query = mysqli_query($conn, "SELECT * FROM type_movie");
                while ($row = mysqli_fetch_assoc($query)) {
                    echo "<option value='{$row['type_ID']}'>{$row['type_name']}</option>";
                }
            ?>
        </select>

        <label>ชื่อโปสเตอร์:</label>
        <input type="text" name="movie_path" placeholder="ตัวอย่าง: movie.jpg หรือ movie.png" required>

        <label>ลิ้งวิดีโอ:</label>
        <input type="text" name="movievideo_path" placeholder="ตัวอย่าง: https://www.youtube.com" required>

        <input type="submit" value="เพิ่มหนัง">
    </form>
    <br>
    <a href="index_admin.php" class="back-btn">ย้อนกลับ</a>
</body>
</html>

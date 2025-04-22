<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เข้าสู่ระบบ</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-container">
    <h2>เข้าสู่ระบบ</h2>

    <form action="login_action.php" method="post">
        <div class="input-group">
            <label for="email">อีเมล:</label>
            <input type="email" name="email" required>
        </div>

        <div class="input-group">
            <label for="password">รหัสผ่าน:</label>
            <input type="password" name="password" required>
        </div>

        <button type="submit" class="btn">เข้าสู่ระบบ</button>
    </form>

    <p><a href="register.php">สมัครสมาชิก</a></p>
    <a href="index.php" class="back-btn">กลับไปหน้าแรก</a>
</div>

</body>
</html>

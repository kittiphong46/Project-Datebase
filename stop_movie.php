<?php
include('db.php');

if (isset($_GET['movie_ID']) && is_numeric($_GET['movie_ID'])) {
    $movie_ID = intval($_GET['movie_ID']);

    $stmt = $conn->prepare("UPDATE movie SET movie_Status = 0 WHERE movie_ID = ?");
    $stmt->bind_param("i", $movie_ID);

    if ($stmt->execute()) {
        echo "<script>alert('✅ หยุดขายหนังเรียบร้อยแล้ว'); window.location.href='manage_movie.php';</script>";
    } else {
        echo "<script>alert('❌ เกิดข้อผิดพลาดในการหยุดขาย'); window.history.back();</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('❌ ไม่มีข้อมูลหนังที่ต้องการหยุดขาย'); window.history.back();</script>";
}

$conn->close();
?>

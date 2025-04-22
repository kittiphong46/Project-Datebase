<?php
include('db.php');

if (isset($_GET['movie_ID']) && is_numeric($_GET['movie_ID'])) {
    $movie_ID = intval($_GET['movie_ID']);

    // ตรวจสอบสถานะหนังและการเช่าค้าง
    $check_status = $conn->prepare("
        SELECT movie_Status, 
               (SELECT COUNT(*) FROM rent WHERE movie_ID = ? AND (date_return IS NULL OR date_return = '0000-00-00')) AS pending_rentals
        FROM movie 
        WHERE movie_ID = ?
    ");
    $check_status->bind_param("ii", $movie_ID, $movie_ID);
    $check_status->execute();
    $result = $check_status->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        echo "<script>alert('❌ ไม่พบข้อมูลหนังที่ต้องการลบ'); window.history.back();</script>";
        exit;
    }

    // ตรวจสอบว่าหนังยังขายอยู่หรือมีการเช่าค้างอยู่หรือไม่
    if ($row['movie_Status'] == 1) {
        echo "<script>alert('❌ ไม่สามารถลบหนังได้ เนื่องจากหนังยังอยู่ในสถานะขายอยู่'); window.history.back();</script>";
        exit;
    }

    if ($row['pending_rentals'] > 0) {
        echo "<script>alert('❌ ไม่สามารถลบหนังได้ เนื่องจากยังมีการเช่าค้างอยู่'); window.history.back();</script>";
        exit;
    }

    // ลบหนังออกจากระบบ
    $delete_stmt = $conn->prepare("DELETE FROM movie WHERE movie_ID = ?");
    $delete_stmt->bind_param("i", $movie_ID);

    if ($delete_stmt->execute()) {
        echo "<script>alert('✅ ลบหนังเรียบร้อยแล้ว'); window.location.href='manage_movie.php';</script>";
    } else {
        echo "<script>alert('❌ เกิดข้อผิดพลาดในการลบหนัง'); window.history.back();</script>";
    }

    $delete_stmt->close();
} else {
    echo "<script>alert('❌ ไม่มีข้อมูลหนังที่ต้องการลบ'); window.history.back();</script>";
}

$conn->close();
?>

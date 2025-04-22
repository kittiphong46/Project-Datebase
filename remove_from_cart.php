<?php
session_start();

if (isset($_GET['id'])) {
    $movie_ID = $_GET['id'];
    unset($_SESSION['cart'][$movie_ID]);
}

// กลับไปที่ตะกร้า
header("Location: cart.php");
exit();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>หน้าแรก</title>
    <link rel="stylesheet" href="style.css?v=2">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- เพิ่ม Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
    body {
      background-color: #1e1e1e;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 20px;
      color: white;
      text-align: center;
    }

    h2 {
      color: #4CAF50;
      margin-bottom: 30px;
    }

    table {
      width: 90%;
      max-width: 1000px;
      margin: auto;
      border-collapse: collapse;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 0 20px rgba(0,0,0,0.3);
    }

    th {
      background-color: #4CAF50;
      color: white;
      padding: 15px;
      font-size: 18px;
    }

    td {
      background-color: #fff;
      color: #000;
      padding: 15px;
      font-size: 16px;
      vertical-align: middle;
    }

    tr:hover td {
      background-color: #f1f1f1;
    }

    img {
      width: 90px;
      height: 130px;
      object-fit: cover;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.3);
    }
    .logo {
    height: 75px; /* ความสูงโลโก้ */
    object-fit: contain; /* ปรับไม่ให้รูปบี้ */
    }

    .cart-link, .profile-link {
    position: relative;
    color: white;
    text-decoration: none;
    font-size: 24px; /* ขนาดไอคอน */
    margin-left: 15px; /* เพิ่มระยะห่างระหว่างไอคอน */
    }

    .profile-link i {
    color:rgb(255, 255, 255); /* เปลี่ยนสีไอคอนโปรไฟล์ */
    transition: color 0.3s ease; /* เพิ่มเอฟเฟกต์เมื่อ hover */
    }

   
    .cart-count {
    position: absolute;
    top: -10px;
    right: -10px;
    background-color:rgb(0, 0, 0); /* สีแดง */
    color: white;
    font-size: 12px;
    font-weight: bold;
    padding: 5px 8px;
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
  </style>
</head>

<body>

<div class="navbar">
    <a href="index.php">
        <img src="icon/your-logo.png" alt="เช่าภาพยนตร์" class="logo">
    </a>

    <div class="top-right-buttons">
        <a href="cart.php" class="cart-link">
            <i class="fas fa-shopping-cart"></i>
            <?php
            session_start();
            $cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
            if ($cart_count > 0) {
                echo "<span class='cart-count'>$cart_count</span>";
            }
            ?>
        </a>
        <a href="profile.php" class="profile-link">
            <i class="fas fa-user-circle"></i>
        </a>
    </div>
</div>


    <nav>
        <a href="movies.php"><button>รายการภาพยนตร์</button></a>
        <a href="login.php"><button>เข้าสู่ระบบ/สมัครสมาชิก</button></a>
        <!-- <a href="profile.php"><button>ข้อมูลส่วนตัว</button></a> -->
        <a href="rental_history.php"><button>ประวัติการเช่า</button></a>
        <a href="fines.php"><button>ค่าปรับ</button></a>
        
</a>
    </nav>

    <!-- filepath: c:\xampp\htdocs\movie\index.php -->
    <div class="swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide"><img src="photo/IT_2.jpg" alt="Slide 1"></div>
            <div class="swiper-slide"><img src="photo/dune.jpg" alt="Slide 2"></div>
            <div class="swiper-slide"><img src="photo/Endgame.jpg" alt="Slide 3"></div>
            <div class="swiper-slide"><img src="photo/the_dark_night.jpg" alt="Slide 4"></div>
            <div class="swiper-slide"><img src="photo/hangover.jpg" alt="Slide 5"></div>
            <div class="swiper-slide"><img src="photo/joker.jpg" alt="Slide 5"></div>
            <!-- เพิ่มภาพได้ตามต้องการ -->
        </div>

        <!-- ปุ่มเลื่อนซ้ายขวา -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>

        <!-- จุดบอกตำแหน่งสไลด์ -->
        <div class="swiper-pagination"></div>
    </div>

<script>
    var swiper = new Swiper('.swiper', {
    slidesPerView: 4,       // แสดง 4 รูปพร้อมกัน
    slidesPerGroup: 1,      // เลื่อนไปทีละ 1 รูป
    spaceBetween: 15,       // ระยะห่างระหว่างรูป
    loop: true,
    loopFillGroupWithBlank: true,
    autoplay: {
        delay: 3000,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    });
</script> 
<h2>ภาพยนตร์ยอดนิยม</h2>
    
    <table>
        <thead>
            <tr>
                <th>ภาพยนตร์</th>
                <th>ความนิยม</th>
                <th>ชื่อภาพยนตร์</th>
                <th>ราคาเช่า (บาท)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><img src="photo/Blackpanther.jpg" alt="Black Panther"></td>
                <td>Top 1</td>
                <td>Black Panther</td>
                <td>89</td>
            </tr>
            <tr>
                <td><img src="photo/dune.jpg" alt="Dune"></td>
                <td>Top 2</td>
                <td>Dune</td>
                <td>89</td>
            </tr>
            <tr>
                <td><img src="photo/Endgame.jpg" alt="Avengers: Endgame"></td>
                <td>Top 3</td>
                <td>Avengers: Endgame</td>
                <td>99</td>
            </tr>
        </tbody>
    </table>
    <!-- filepath: c:\xampp\htdocs\movie\index.php -->
<h2>ตัวอย่างภาพยนตร์</h2>
<div class="movie-trailers">
    <iframe width="560" height="315" src="https://www.youtube.com/embed/8ugaeA-nMTc" title="Black Panther Trailer" frameborder="0" allowfullscreen></iframe>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/n9xhJrPXop4" title="Dune Trailer" frameborder="0" allowfullscreen></iframe>
    <iframe width="560" height="315" src="https://www.youtube.com/embed/TcMBFSGVi1c" title="Avengers: Endgame Trailer" frameborder="0" allowfullscreen></iframe>
</div>
</body>
</html>

<!-- สิ่งที่ต้องเพิ่ม
    1.ทำปุ่มเปลี่ยนสถานะการยืม//

    3.ปุ่ม Log out+
    4.ตกตแต่งทั้งหมด
    5.ตัวอย่างหนังจากยูทูป+
    6.ระบบการจอง
        -รวมเงิน รวมส่วนลด(จองจากเว็บลด 5%) 
        -ขึ้นหน้าจ่ายมัดจำ
    7.ขึ้นระยะเวลาการมาเอาหนัง++
    8.เริ่มเช่า มีรายละเอียดลูกค้ากับหนัง ใส่ปุ่มเริ่มเวลาเช่า(เจ้าของร้าน)
    9.คืน มีรายละเอียดลูกค้ากับหนัง ใส่ปุ่มคืนเวลาเช่า(เจ้าของร้าน)
        -เลือกประเภทความเสีย แต่ละแผ่นหนัง
        -รวมค่าความเสียหาย
-->
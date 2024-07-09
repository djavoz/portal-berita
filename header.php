<?php
include("inc/koneksi.php");
include("inc/fungsi.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= getprofilweb('site_title') ?></title>
    <meta name="description" content="<?= getprofilweb('meta_desc') ?>">
    <meta name="keywords" content="<?= getprofilweb('meta_key') ?>">
    <link rel="stylesheet" type="text/css" href="assets/style.css">
</head>
<body>
    <div class="wrap">
        <div class="pd10">
            <header>
                <nav>
                    <div class="logo-home">
                        <img src="<?= URL_SITUS . PATH_LOGO_NAME . '/' . FILE_LOGO_NAME; ?>" alt="">
                    </div>
                    <div class="clear"></div>
                    <hr>
                    <a href="./">Home</a>
                    <?php
                    // Ensure $conn is available and global
                    global $conn;
                    if ($conn) {
                        $menu = mysqli_query($conn, "SELECT * FROM kategori WHERE terbit='1' ORDER BY id ASC LIMIT 0, 10");
                        if ($menu) {
                            while ($r = mysqli_fetch_array($menu)) {
                                extract($r);
                                echo '<a href="./?open=cat&id=' . $id . '">' . $kategori . '</a>';
                            }
                        } else {
                            echo "Error: " . mysqli_error($conn);
                        }
                    } else {
                        echo "Database connection failed.";
                    }
                    ?>
                    
                    <a href="./admin/" class="btn fr" style="margin-top: -50px; margin-right: 7px;">Login</a>
                    <form action="" method="GET" class="btn fr" style="margin-top: -50px; margin-right: 80px;">
                        <input type="text" name="key" placeholder="Cari...">
                        <button type="submit" class="cari" name="open" value="cari">Cari</button>

                    </form>
                </nav>
            </header>
            <div class="clear"></div>
        

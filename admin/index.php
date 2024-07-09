<?php
include("cek_login.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator - <?=getprofilweb('site_title')?></title>
    <link rel="stylesheet" href="../assets/style.css">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    
    <!-- Summernote CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-lite.css" rel="stylesheet">
    
    <!-- Summernote JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-lite.js"></script>
</head>
<body>
    <div class="wrap shadow mt10 mb10 border">
        <div class="bg_grey">
            <h1 class="pd10">Selamat datang dihalaman administrator</h1>
            <hr>
            <div class="menu pd10">
                <a href="/">Home</a>
                <a href="?mod=kategori">Kategori</a>
                <a href="?mod=berita">Berita</a>
                <a href="?mod=konfigurasi">Konfigurasi</a>
                <a href="?mod=useradmin">User Admin</a>
                <a href="./logout.php" class="fr">Logout</a>
            </div>
            <div class="clear"></div>
        </div>
        <div class="pd10">
            <?php 
            $mod = (isset($_GET['mod'])) ? $_GET['mod'] : '';
			
            switch ($mod) {
                case 'useradmin':
                    include("useradmin.php");
                    break;
                case 'konfigurasi':
                    include("konfigurasi.php");
                    break;
                case 'kategori':
                    include("kategori.php");
                    break;
                case 'berita':
                    include("berita.php");
                    break;
                default:
                    echo "Selamat Datang ".$_SESSION['loginadminnama'];
                    break;
            }
            ?>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 200 // set editor height
            });
        });
    </script>
</body>
</html>

<div class="mainpage">

    <div class="content">
        <?php
        global $conn;
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_GET['id'])) {
                $catid =  $_GET['id'];
                $get_alias = mysqli_query($conn, "SELECT * FROM kategori WHERE id=$catid ORDER BY id DESC LIMIT 0,10");
                while ($a = mysqli_fetch_array($get_alias)) :
                    $get_berita = mysqli_query($conn, "SELECT * FROM berita WHERE terbit=1 AND kategori= '".$a['alias']."' ORDER BY id DESC LIMIT 0,10");
                    while ($b = mysqli_fetch_array($get_berita)) :
                        extract($b);
                    ?>
                    <div class="boxnews">
                        <div class="img">
                            <img src="<?= URL_SITUS. $gambar?>">
                        </div>
                        <h1><a href="./?open=detail&id=<?=$id?>"><?= $judul ?></a></h1>
                        <p><?= substr(strip_tags($isi), 0 , 200)?>...</p>
                        <div class="clear"></div>

                    </div>
                    <?php
                    endwhile;
                endwhile;
            }
        }
        ?>
    </div>
    <div class="sidebar">
        <?php include'sidebar.php'?>
    </div>
    <div class="clear"></div>
</div>
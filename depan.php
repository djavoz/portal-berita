<div class="mainpage">

    <div class="content">
        <?php
            global $conn;
            $sql = mysqli_query($conn, "SELECT * FROM berita WHERE terbit='1' ORDER BY id DESC LIMIT 0,10");
            while ($b = mysqli_fetch_array($sql)) :
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
        <?php endwhile;?>
    </div>

    <div class="sidebar">
        <?php include'sidebar.php'?>
    </div>
    <div class="clear"></div>
</div>
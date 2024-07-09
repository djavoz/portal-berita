<div class="mainpage">
    <div class="content">
        <?php
            $id = (isset($_GET['id']) ? $_GET['id'] : '');
            global $conn;
            $sql = mysqli_query($conn, "SELECT * FROM berita WHERE terbit='1' AND id=$id");
            while ($b = mysqli_fetch_array($sql)) :
                extract($b);
            $name_sql = mysqli_query($conn, "SELECT nama FROM administrator WHERE id=$author");
            $username = mysqli_fetch_array($name_sql);
            $update_view = mysqli_query($conn, "UPDATE berita SET view=view+1 WHERE id=$id");
        ?>
        <div class="detail">
            <h1><?= $judul ?></h1>

            <div class="info">
                <span>Tanggal: <?= $tanggal ?></span> | <span>Update by: <?= $username['nama'] ?></span>
            </div>
            <p><?= nl2br($isi)?></p>
        </div>
        <?php endwhile;?>
            <div class="clear"></div>
    </div>
    <div class="sidebar">
        <?php include 'sidebar.php'?>
    </div>
    <div class="clear"></div>
</div>
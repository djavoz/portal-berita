<div class="mainpage">

    <div class="content">
        <?php
        global $conn;
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_GET['key'])) {
                $key =  $_GET['key'];

                $key = explode(" ", $key);
                
                sort($key);

                $stradd = '';
                foreach ($key as $value) {
                    if ($stradd != '') {
                        $stradd .= "OR isi LIKE '%{$value}%' OR judul LIKE '%{$value}%'";
                    }else{
                        $stradd .= "isi LIKE '%{$value}%' OR judul LIKE '%{$value}%'";
                    }
                }
                $get_berita = mysqli_query($conn, "SELECT * FROM berita WHERE $stradd AND terbit='1' ORDER BY id DESC LIMIT 0,10");
                while ($a = mysqli_fetch_array($get_berita)) :
                    extract($a);
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
            }
        }
        ?>
    </div>
    <div class="sidebar">
        <?php include'sidebar.php'?>
    </div>
    <div class="clear"></div>
</div>
<?php
function getprofilweb($tax)
{
    global $conn;
    $hasil = mysqli_query($conn, "SELECT * FROM konfigurasi WHERE tax='$tax' ORDER BY id DESC LIMIT 1"); 
    while($r = mysqli_fetch_array($hasil)){
        return $r['isi'];
    }
}

function populer() { ?>
    <div class="bar-menu">
        Berita Populer
    </div>

    <div>
        <?php
        global $conn;

        $date = date("Y-m-d H:i:s", strtotime('-7 days'));

        // Prepare the SQL query
        $sql = "SELECT * FROM berita WHERE terbit=1 AND tanggal >= '$date' ORDER BY view DESC LIMIT 0, 10";
        $populer = mysqli_query($conn, $sql);
        while ($r = mysqli_fetch_array($populer)) :
            extract($r);
        ?>
        <div class="side-box">
            <div class="img">
                <img src="<?=  URL_SITUS. $gambar?>">
            </div>
            <span><?= substr($tanggal, 0, 10)?> | view: <b><?= $view ?></b></span>

            <h1>
                <a href="./?open=detail&id=<?= $id?>"><?= $judul ?></a>
            </h1>
            <div class="clear"></div>
        </div>
        <?php endwhile;?>
    </div>
<?php
}
function berita_terbaru() { ?>
    <div class="bar-menu">
        Berita Terbaru
    </div>

    <div>
        <?php
        global $conn;

        // Prepare the SQL query
        $sql = "SELECT * FROM berita WHERE terbit=1 ORDER BY id DESC LIMIT 0, 10";
        $terkini = mysqli_query($conn, $sql);
        while ($r = mysqli_fetch_array($terkini)) :
            extract($r);
        ?>
        <div class="side-box">
            <div class="img">
                <img src="<?=  URL_SITUS. $gambar?>">
            </div>
            <span><?= substr($tanggal, 0, 10)?></span>

            <h1>
                <a href="./?open=detail&id=<?= $id?>"><?= $judul ?></a>
            </h1>
            <div class="clear"></div>
        </div>
        <?php endwhile;?>
    </div>
<?php }?>
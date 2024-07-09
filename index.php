<?php include('header.php');?>
<div class="pd10 pb10">
    <?php 
    $mod = (isset($_GET['open'])) ? $_GET['open'] : '';
    
    switch ($mod) {
        case 'detail':
            include("detail.php");
            break;
        case 'cat':
            include("kategori.php");
            break;
        case 'cari':
            include("cari.php");
            break;
        default:
            include("depan.php");
            break;
    }
    ?>
</div>
<?php include('footer.php');?>
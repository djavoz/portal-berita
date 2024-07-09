
<?php
if (isset($_POST)) {
    
    if (isset($_FILES['logositus']) && $_FILES['logositus']['error'] !== 4) { // Check if file is uploaded
        $filetype = $_FILES['logositus']['type'];

        $allowtype = array('image/jpeg', 'image/jpg', 'image/png');

        if (!in_array($filetype, $allowtype)) {
            echo "<p>Invalid file type</p>";
        } else {
            $dest = '../'.PATH_LOGO.'/'.FILE_LOGO;

            if (move_uploaded_file($_FILES['logositus']['tmp_name'], $dest)) {
                echo "<p>File uploaded successfully</p>";
            } else {
                echo "<p>Failed to upload file</p>";
            }
        }
    }

    if (isset($_FILES['iconsitus']) && $_FILES['iconsitus']['error'] !== 4) { // Check if file is uploaded
        $filetype = $_FILES['iconsitus']['type'];

        $allowtype = array('image/png', 'image/gif');

        if (!in_array($filetype, $allowtype)) {
            echo "<p>Invalid file type</p>";
        } else {
            $dest = '../'.FILE_ICON;

            if (move_uploaded_file($_FILES['iconsitus']['tmp_name'], $dest)) {
                echo "<p>File uploaded successfully</p>";
            } else {
                echo "<p>Failed to upload file</p>";
            }
        }
    }
    
    if (isset($_POST['tambahkonfigurasi'])) {
        global $conn;
        // Prepare the statement
        $stmt = mysqli_prepare($conn, "INSERT INTO konfigurasi (nama, tax, isi, link, tipe) VALUES (?, ?, ?, ?, ?)");

        // Bind parameters
        mysqli_stmt_bind_param($stmt, 'sssss', $_POST['nama'], $_POST['tax'], $_POST['isi'], $_POST['link'], $_POST['tipe']);

        // Execute the statement
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo '<p class="mb5">Data inserted successfully.<p>';
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    if (isset($_POST['editkonfigurasi'])) {
        $count = 0;

        foreach ($_POST['nama'] as $value) {
            // Prepared statement to prevent SQL injection
            $stmt = $conn->prepare("UPDATE konfigurasi SET nama=?, tax=?, isi=?, link=?, tipe=? WHERE id=?");
            $stmt->bind_param('sssssi', $_POST['nama'][$count], $_POST['tax'][$count], $_POST['isi'][$count], $_POST['link'][$count], $_POST['tipe'][$count], $_POST['id'][$count]);

            if ($stmt->execute()) {
                echo "<p>Configuration updated successfully</p>";
            } else {
                echo "<p>Failed to update configuration</p>";
            }

            $stmt->close();
            $count++;
        }
    }

    if (isset($_GET['act']) && $_GET['act'] == 'hapus' && isset($_GET['id'])) {
        $id = intval($_GET['id']); // Ensure ID is an integer
        
        $stmt = mysqli_prepare($conn, "DELETE FROM konfigurasi WHERE id = ?");

        // Bind parameters
        mysqli_stmt_bind_param($stmt, 's', $id);

        // Execute the statement
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo '<p class="mb5">Data deleted successfully.<p>';
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
}
?>
<div class="w50 fl">
    <form action="./?mod=konfigurasi" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="userid" value="<?=$b['ID']?>">

        <fieldset>
            <legend>Logo Situs</legend>
            <img src="<?= URL_SITUS.PATH_LOGO.'/'.FILE_LOGO;?>" alt="" width="250">
            <br>
            <input type="file" name="logositus">
            <input type="submit" name="uploadlogo" value="Upload Logo">
        </fieldset>
    </form>
</div>

<div class="w50 fl">
    <form action="./?mod=konfigurasi" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="userid" value="<?=$b['ID']?>">

        <fieldset>
            <legend>Icon Situs</legend>
            <img src="<?= URL_SITUS.'/'.FILE_ICON;?>" alt="" width="250">
            <br>
            <input type="file" name="iconsitus">
            <input type="submit" name="uploadicon" value="Upload Icon">
        </fieldset>
    </form>
</div>

<div class="clear"></div>

<div class="w100 fl">
    <form action="./?mod=konfigurasi" method="POST">
        <fieldset>
            <legend>Tambah Konfigurasi</legend>
            
            <div class="w20 fl pd5 bg_dark bold">Nama</div>
            <div class="w15 fl pd5 bg_dark bold">Tax</div>
            <div class="w30 fl pd5 bg_dark bold">Isi</div>
            <div class="w30 fl pd5 bg_dark bold">Link</div>
            
            <div class="w20 fl pd5 bg_grey">
                <input type="text" name="nama" placeholder="Nama" class="form100">
            </div>
            <div class="w15 fl pd5 bg_grey">
                <input type="text" name="tax" placeholder="Tax" class="form100">
            </div>
            <div class="w30 fl pd5 bg_grey">
                <input type="text" name="isi" placeholder="Isi" class="form100">
            </div>
            <div class="w30 fl pd5 bg_grey">
                <input type="text" name="link" placeholder="Link" class="form100">
                <input type="hidden" name="tipe" value="konfigurasi">
            </div>
            <div class="clear pd5"></div>
            <input type="submit" name="tambahkonfigurasi" class="btn-primary" value="Tambah">
            <div class="clear"></div>
        </fieldset>
    </form>
    <div class="clear"></div>
</div>

<div class="clear"></div>

<div class="w100 f1">
    <form action="./?mod=konfigurasi" method="POST">
        <fieldset>
            <legend>List Konfigurasi</legend>
            
            <?php 
            
            global $conn;

            $hasil = mysqli_query($conn, "SELECT * FROM konfigurasi WHERE tipe='konfigurasi'");
            while ($a = mysqli_fetch_array($hasil)):
                extract($a);
            ?>
            <input type="hidden" name="id[]" value="<?= $id?>">
            <input type="hidden" name="tipe[]" value="konfigurasi">
            <div class="w20 fl pd5 bg_grey">
                <input type="text" name="nama[]" placeholder="Nama" value="<?=$nama?>" class="form100">
            </div>
            <div class="w15 fl pd5 bg_grey">
                <input type="text" name="tax[]" placeholder="Tax" value="<?=$tax?>" class="form100">
            </div>
            <div class="w30 fl pd5 bg_grey">
                <input type="text" name="isi[]" placeholder="Isi" value="<?=$isi?>" class="form100">
            </div>
            <div class="w30 fl pd5 bg_grey">
                <input type="text" name="link[]" placeholder="Link" value="<?=$link?>" class="w90">
                <a href="./?mod=konfigurasi&act=hapus&id=<?= $id?>"><span class="pl5 ml5 pr5 bg_dark center">x</span></a>
            </div>
            <?php endwhile;?>
            <div class="clear pd5"></div>
            <input type="submit" name="editkonfigurasi" class="btn-primary" value="Edit">
            <div class="clear"></div>
        </fieldset>
    </form>
    <div class="clear"></div>
</div>
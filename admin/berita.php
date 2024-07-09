<?php
$id = '';
$judul = '';
$kategori = '';
$isi = '';
$teks = '';
$gambar = '';
$terbit = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] !== 4) { // Check if file is uploaded
            $gambarfile = $_FILES['gambar']['tmp_name'];
            $gambarfile_name = $_FILES['gambar']['name'];
            
            $filetype = $_FILES['gambar']['type'];
            $allowtype = array('image/jpeg', 'image/jpg', 'image/png');
    
            if (!in_array($filetype, $allowtype)) {
                echo "<p>Invalid file type</p>";
            } else {
                $path = PATH_GAMBAR.'/';
                if ($gambarfile && $gambarfile_name) {
                    $gambarbaru = preg_replace("/[^a-zA-Z0-9]/", "_", $_POST['judul']);

                    $dest1 = '../' . $path . $gambarbaru . '.jpg';
                    $dest2 = $path . $gambarbaru . '.jpg';
                    copy($_FILES['gambar']['tmp_name'], $dest1);

                    $gambar = $dest2;
                }
            }
        } else {
            // Use existing image if not changed
            $gambar = $_POST['gambar'];
        }

        global $conn;

        $stmt = mysqli_prepare($conn, "INSERT INTO berita (judul, isi, kategori, gambar, teks, tanggal, view, author, post_type, terbit) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Assign values to variables
        $judul = $_POST['judul'];
        $isi = $_POST['isi'];
        $kategori = $_POST['kategori'];
        $teks = $_POST['teks'];
        $tanggal = date('Y-m-d H:i:s');
        $view = 0;
        $author = $_SESSION['loginadmin'];
        $post_type = 'berita';
        $terbit = $_POST['terbit'];

        // Bind parameters
        mysqli_stmt_bind_param($stmt, 'ssssssssss', $judul, $isi, $kategori, $gambar, $teks, $tanggal, $view, $author, $post_type, $terbit);

        // Execute the statement
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo '<p class="mb5">Data inserted successfully.</p>';
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } elseif (isset($_POST['edit'])) {
        // Handle Edit Operation
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] !== 4) { // Check if file is uploaded
            $gambarfile = $_FILES['gambar']['tmp_name'];
            $gambarfile_name = $_FILES['gambar']['name'];
            
            $filetype = $_FILES['gambar']['type'];
            $allowtype = array('image/jpeg', 'image/jpg', 'image/png');
    
            if (!in_array($filetype, $allowtype)) {
                echo "<p>Invalid file type</p>";
            } else {
                $path = PATH_GAMBAR.'/';
                if ($gambarfile && $gambarfile_name) {
                    $gambarbaru = preg_replace("/[^a-zA-Z0-9]/", "_", $_POST['judul']);

                    $dest1 = '../' . $path . $gambarbaru . '.jpg';
                    $dest2 = $path . $gambarbaru . '.jpg';
                    copy($_FILES['gambar']['tmp_name'], $dest1);

                    $gambar = $dest2;
                }
            }
        } else {
            // Use existing image if not changed
            $gambar = $_POST['gambar'];
        }

        global $conn;

        $stmt = mysqli_prepare($conn, "UPDATE berita SET judul=?, isi=?, kategori=?, gambar=?, teks=?, terbit=? WHERE id=?");

        // Assign values to variables
        $id = $_POST['id'];
        $judul = $_POST['judul'];
        $isi = $_POST['isi'];
        $kategori = $_POST['kategori'];
        $teks = $_POST['teks'];
        $terbit = $_POST['terbit'];

        // Bind parameters
        mysqli_stmt_bind_param($stmt, 'ssssssi', $judul, $isi, $kategori, $gambar, $teks, $terbit, $id);

        // Execute the statement
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo '<p class="mb5">Data updated successfully.</p>';
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
}

if (isset($_GET['act']) && $_GET['act'] == 'edit' && isset($_GET['id'])) {
    $id = intval($_GET['id']); // Ensure ID is an integer
    global $conn;
    $stmt = mysqli_query($conn, "SELECT * FROM berita WHERE id =" . $id);
    while ($b = mysqli_fetch_array($stmt)) {
        extract($b);

        if (isset($_GET['hapusgambar']) && $_GET['hapusgambar'] == 'yes') {
            unlink('../' . $gambar);
            
            $sqlupdate = mysqli_query($conn, "UPDATE berita SET gambar='' WHERE id=" . $id); 
            echo '<meta http-equiv="REFRESH" content="0;url=./?mod=berita&act=edit&id=' . $id . '">';
        }
    }
}
?>
<div class="w100">
    <form action="./?mod=berita" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>Tambah Berita</legend>

            <div class="formnama">
                <label>Judul</label>:<br>
                <input type="hidden" name="id" value="<?= $id ?>" size="40">
                <input type="text" name="judul" placeholder="Judul Berita" value="<?= $judul ?>" size="40">
            </div>
            <div class="formnama">
                <label>Kategori</label>:<br>
                <select name="kategori" id="">
                    <option value="">Pilih Kategori</option>
                    <?php
                        global $conn;
                        $hasil = mysqli_query($conn, "SELECT * FROM kategori WHERE terbit=1 ORDER BY id DESC");
                        while ($k = mysqli_fetch_array($hasil)) {
                            $selected = ($kategori == $k['alias']) ? 'selected' : '';
                            echo '<option value="'. $k['alias'] .'"' . $selected . '>' . $k['kategori'] . '</option>';
                        }
                    ?>
                </select>    
            </div>

            <div class="formnama">
                <label>Isi Berita</label>:<br>
                <textarea name="isi" cols="30" rows="8" class="summernote"><?= $isi ?></textarea>
            </div>

            <div class="formnama">
                <label>Gambar</label>:<br>
                <?php
                if ($gambar) {
                    echo '
                    <div class="imgsedang">
                        <input type="hidden" name="gambar" value="' . $gambar . '">
                        <img src="' . URL_SITUS . $gambar . '" width="200">
                        <div class="imghapus">
                            <a href="./?mod=berita&act=edit&hapusgambar=yes&id=' . $id . '">x</a>
                        </div>
                    </div>';
                } else {
                    echo '<input type="file" name="gambar">';
                }
                ?>
            </div>
            <div class="clear pd10"></div>
            <div class="formnama">
                <label>Teks</label>:<br>
                <textarea name="teks" cols="30" rows="5"><?= $teks ?></textarea>
            </div>

            <div class="formnama">
                <label>Terbitkan</label>:<br>
                <select name="terbit">
                    <option value="1" <?= ($terbit == 1) ? 'selected' : '' ?>>Yes</option>
                    <option value="0" <?= ($terbit == 0) ? 'selected' : '' ?>>No</option>
                </select>
            </div>
            <input type="submit" name="<?= ($id) ? 'edit' : 'add' ?>" value="<?= ($id) ? 'Ubah' : 'Tambah' ?>" class="btn-primary">
        </fieldset>
    </form>
</div>

<div class="w100">
    <fieldset>
        <legend>List Berita</legend>

        <div class="w100 list fl bold bg_dark">
            <div class="w10 fl">ID</div>
            <div class="w40 fl">Judul</div>
            <div class="w20 fl">Kategori</div>
            <div class="w10 fl">Tanggal</div>
            <div class="w10 fl">Aksi</div>
        </div>
        
        <?php
            global $conn;
            $hasil = mysqli_query($conn, "SELECT * FROM berita ORDER BY id DESC");
            while ($a = mysqli_fetch_array($hasil)):
                extract($a);
        ?>
            <div class="w100 list fl mt5">
                <div class="w10 fl"><?= $id ?></div>
                <div class="w40 fl"><?= $judul ?></div>
                <div class="w20 fl"><?= $kategori ?></div>
                <div class="w10 fl"><?= $tanggal ?></div>
                <div class="w10 fl">
                    <a href="./?mod=berita&act=edit&id=<?= $id ?>" class="btn btn-primary p5">Edit</a>
                    <a href="./?mod=berita&act=delete&id=<?= $id ?>" class="btn btn-alert p5">Hapus</a>
                </div>
            </div>
        <?php endwhile; ?>
    </fieldset>
</div>


<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tambahkategori'])) {
        global $conn;

        $stmt = mysqli_prepare($conn, "INSERT INTO kategori (kategori, alias, terbit) VALUES (?, ?, ?)");

        // Bind parameters
        mysqli_stmt_bind_param($stmt, 'sss', $_POST['kategori'], $_POST['alias'], $_POST['terbit']);

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

    if (isset($_POST['editkategori'])) {
        // Update existing category
        $stmt = mysqli_prepare($conn, "UPDATE kategori SET kategori=?, alias=?, terbit=? WHERE id=?");
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'sssi', $_POST['kategori'], $_POST['alias'], $_POST['terbit'], $_POST['id']);
            $result = mysqli_stmt_execute($stmt);
            if ($result) {
                echo "<p>Kategori updated successfully.</p>";
            } else {
                echo "<p>Failed to update Kategori: " . mysqli_stmt_error($stmt) . "</p>";
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error preparing statement: " . mysqli_error($conn);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['act']) && $_GET['act'] == 'edit' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $stmt = $conn->prepare("UPDATE kategori SET kategori=?, alias=?, terbit=? WHERE id=?");
        $stmt->bind_param('sssi', $_GET['kategori'], $_GET['alias'], $_GET['terbit'], $_GET['id']);

        if ($stmt->execute()) {
            echo "<p>Kategori updated successfully</p>";
        } else {
            echo "<p>Failed to update Kategori</p>";
        }

        $stmt->close();
        
    }

    if (isset($_GET['act']) && $_GET['act'] == 'delete' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        
        // Delete the user
        $sql = "DELETE FROM kategori WHERE id = $id";
        if (mysqli_query($conn, $sql)) {
            echo '<p class="mb5">Data deleted successfully.<p>';
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>
<div class="w100">
    <form action="./?mod=kategori" method="post">
        <fieldset>
            <legend>Tambah Kategori</legend>

            <div class="formnama w30">Kategori:<br>
                <input type="text" name="kategori" placeholder="Nama Kategori" class="form100">
            </div>

            <div class="formnama w30">Alias:<br>
                <input type="text" name="alias" placeholder="Alias" class="form100">
            </div>

            <div class="formnama w30">Tampilkan:<br>
                <select name="terbit">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>

            <input type="submit" name="tambahkategori" value="Tambah" class="btn-primary">
        </fieldset>
    </form>
</div>
<div class="clear"></div>
<div class="w100">
    <form action="./?mod=kategori" method="post">
        <fieldset>
            <legend>List Kategori</legend>
            <div class="w100 fl list bg_dark">
                <div class="w5 fl bold center">ID</div>
                <div class="w30 fl bold center">Kategori</div>
                <div class="w20 fl bold center">Alias</div>
                <div class="w20 fl bold center">Tampilkan</div>
                <div class="w20 fl bold center">Aksi</div>
                <div class="clear"></div>
            </div>

            <?php
            $hasil = mysqli_query($conn, "SELECT * FROM kategori ORDER BY id DESC");
            while ($a = mysqli_fetch_array($hasil)):
                extract($a);
            ?>
            <div class="w100 fl list">
                <form action="./?mod=kategori" method="post">
                    <input type="hidden" name="id" value="<?=$id?>">
                    <div class="w5 fl center"><?=$id?></div>
                    <div class="w30 fl center">
                        <input type="text" name="kategori" value="<?=$kategori?>">
                    </div>
                    <div class="w20 fl center">
                        <input type="text" name="alias" value="<?=$alias?>">
                    </div>
                    <div class="w20 fl center">
                        <select name="terbit">
                            <option value="1" <?=($terbit == 1) ? 'selected' : ''?>>Yes</option>
                            <option value="0" <?=($terbit == 0) ? 'selected' : ''?>>No</option>
                        </select>
                    </div>
                    <div class="w20 fl center">
                        <input type="submit" name="editkategori" value="EDIT" class="m-2 small btn btn-primary">
                        <a href="./?mod=kategori&act=delete&id=<?=$id?>" class="small btn btn-alert">HAPUS</a>
                    </div>
                </form>
                <div class="clear"></div>
            </div>
            <?php endwhile; ?>
        </fieldset>
    </form>
</div>
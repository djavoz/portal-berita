<?php
global $conn;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tambahuser'])) {
        $nama = mysqli_real_escape_string($conn, $_POST['nama']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        $qry = "SELECT * FROM administrator WHERE username= '$username' OR email='$email'";
        $result = mysqli_query($conn, $qry);
        $numrow = mysqli_num_rows($result);

        if ($numrow > 0) {
            $error = "Username sudah terdaftar";
            echo $error;
        } else {
            // Prepare the statement
            $stmt = mysqli_prepare($conn, "INSERT INTO administrator (nama, username, password, email) VALUES (?, ?, ?, ?)");

            // Bind parameters
            mysqli_stmt_bind_param($stmt, "ssss", $nama, $username, $password, $email);

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
    }
}

$edit_data = null; // Initialize the variable

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['act']) && $_GET['act'] == 'edit' && isset($_GET['id'])) {
        $id = intval($_GET['id']);

        $sql = mysqli_query($conn, "SELECT * FROM administrator WHERE id = $id");
        if ($sql && mysqli_num_rows($sql) > 0) {
            $edit_data = mysqli_fetch_assoc($sql);
        }
    }
    if (isset($_GET['act']) && $_GET['act'] == 'delete' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        
        // Delete the user
        $sql = "DELETE FROM administrator WHERE id = $id";
        if (mysqli_query($conn, $sql)) {
            echo '<p class="mb5">Data deleted successfully.<p>';
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}


?>

<form action="" method="POST">
    <fieldset>
        <legend>Tambah User</legend>
        
        <table border=0 class="mt5">
            <tr>
                <td>
                    <label for="">Nama User</label>
                </td>
                <td>
                    <input type="text" name="nama" placeholder="Nama Lengkap" value="<?= $edit_data['nama'] ?? '' ?>"><br>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="">Username</label>
                </td>
                <td>
                    <input type="text" name="username" value="<?= $edit_data['username'] ?? '' ?>"><br>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="">Email</label>
                </td>
                <td>
                    <input type="email" name="email" placeholder="contoh@gmail.com" value="<?= $edit_data['email'] ?? '' ?>"><br>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="">Password</label>
                </td>
                <td>
                    <input type="text" name="password" value="<?= $edit_data['password'] ?? '' ?>"><br>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="submit" name="tambahuser" value="Tambah">
                </td>
            </tr>
        </table>
    </fieldset>
</form>

<fieldset>
    <legend>List User</legend>
    <table border=0 class="mt5">
        <tr class="center">
            <td class="bold">ID</td>
            <td class="bold">NAMA</td>
            <td class="bold">USERNAME</td>
            <td class="bold">EMAIL</td>
            <td class="bold">AKSI</td>
        </tr>
        <?php
        $i = 0;
        $sql = mysqli_query($conn, "SELECT * FROM administrator ORDER BY id ASC");
        while ($r = mysqli_fetch_array($sql)) {
            extract($r);

            echo '
            <tr class="list">
                <td class="w10">' . ++$i . '</td>
                <td class="w30">' . htmlspecialchars($nama) . '</td>
                <td class="w20">' . htmlspecialchars($username) . '</td>
                <td class="w20">' . htmlspecialchars($email) . '</td>
                <td class="w20 center">
                    <a href="?mod=useradmin&act=edit&id=' . $id . '" class="m-2 small btn btn-primary">EDIT</a>
                    <a href="?mod=useradmin&act=delete&id=' . $id . '" class="small btn btn-alert">HAPUS</a>
                </td>
                <td class="clear"></td>
            </tr>
            ';
        }
        ?>
    </table>
    <div class="w100">
        <hr>
        <div class="w10 bold f1"></div>
        <div class="w30 bold f1"></div>
        <div class="w20 bold f1"></div>
        <div class="w20 bold f1"></div>
        <div class="w20 bold f1"></div>
        <div class="clear"></div>
        <hr>
    </div>
</fieldset>

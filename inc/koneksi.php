<?php
$conn = mysqli_connect('localhost', 'root', '', 'energi-nusantara'); // Attempt to establish a connection
define('URL_SITUS', 'http://localhost/energi-nusantara/');
define('PATH_LOGO', 'image');
define('PATH_LOGO_NAME', 'image');
define('PATH_GAMBAR', 'image/gambar');
define('FILE_LOGO_NAME', 'logo_name.png');
define('FILE_LOGO', 'logo.png');
define('FILE_ICON', 'icon.png');

if (mysqli_connect_errno()) {
    echo "Gagal koneksi ke database " . mysqli_connect_error(); // If connection fails, display error
}
?>

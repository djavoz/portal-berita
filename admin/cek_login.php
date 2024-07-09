<?php
session_start();
// logout manual
// session_destroy();
include("../inc/koneksi.php");
include("../inc/fungsi.php");

if (count($_SESSION) < 1) {
    $_SESSION['loginadmin'] = false;
}
if ($_POST && isset($_POST['submit'])) {
    
    global $conn;
    
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $res = "SELECT * FROM administrator WHERE username='".$username."' AND password='".$password."'"; 
    $result = mysqli_query($conn, $res);
    $numrow = mysqli_num_rows($result);
    
    $r = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if($numrow > 0){
        $_SESSION['loginadmin'] = true;
        $_SESSION['loginadminid'] = $r['id'];
        $_SESSION['loginadminnama'] = $r['nama'];
        $_SESSION['loginadminusername'] = $r['username'];
        $_SESSION['loginadminpassword'] = $r['password'];
        $_SESSION['loginadminemail'] = $r['email'];
    }else{
        $error = "User dan Password salah";
        header('Location:index.php?error='.$error);
        exit;
    }
}
if ($_SESSION['loginadmin'] != TRUE) {
?>
<style>
    <?php 
    if ($_SESSION['loginadmin'] != TRUE) :?>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }
    <?php endif; ?>
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="login-page">
        <div class="logo">
            <img src="<?= URL_SITUS.PATH_LOGO.'/'.FILE_LOGO; ?>" alt="">
        </div>
        <div class="clear pd5"></div>
        <form action="" method="POST">
            <label for="username">Username :</label><br>
            <input type="text" id="username" name="username" class="form100"><br>
            <label for="password">Password :</label><br>
            <input type="password" id="password" name="password" class="form100"><br>
            <button type="submit" name="submit" value="Login">Login</button>
        </form>
    </div>
</body>
</html>

<?php
exit;
}
?>
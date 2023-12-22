<?php
session_start();
require("../sistem/koneksi.php");
$hub = open_connection();
$op = $_GET['op'];

if ($op == "in") {
    $usr = mysqli_real_escape_string($hub, $_POST['usr']);
    $psw = mysqli_real_escape_string($hub, $_POST['psw']);
    $hashed_password = hash("sha256", $psw); 

    $cek = mysqli_query($hub, "SELECT * FROM user WHERE username='$usr' AND password='$hashed_password'");
    if (mysqli_num_rows($cek) == 1) {
        $c = mysqli_fetch_array($cek);
        $_SESSION['username'] = $c['username'];
        $_SESSION['jenisuser'] = $c['jenisuser'];
        header("location:index.php");
    } else {
        echo "<p class='error-message'>Nama Pengguna atau kata sandi salah. <a href='javascript:history.back()'>Kembali</a></p>";
    }
    mysqli_close($hub);
} elseif ($op == "out") {
    unset($_SESSION['username']);
    unset($_SESSION['jenisuser']);
    header("location:index.php");
}
?>
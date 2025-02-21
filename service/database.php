<?php 
$servername = "localhost";
$username = "root";
$password = "cihuy";
$dbname = "db_quicsx_webstore";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn){
    die("Koneksi Gagal".mysqli_connect_error());
}
?>

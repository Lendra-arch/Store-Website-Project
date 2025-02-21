<?php 
$servername = "sql100.infinityfree.com";
$username = "if0_37832045";
$password = "LUutkWibqJZW";
$dbname = "if0_37832045_web";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn){
    die("Koneksi Gagal".mysqli_connect_error());
}
?>
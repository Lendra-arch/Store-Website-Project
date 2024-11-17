<?php
    include "service/database.php";
    session_start();

    $login_msg = "";

    if(isset($_SESSION["is_login"])) {
        header("location:dashboard.php");
    }

    if(isset($_POST['login'])){
        $username= $_POST['username'];
        $password = $_POST['password'];
        $hash_password = hash("sha256",$password);
        
        $sql = "SELECT * from users WHERE username='$username' AND password='$hash_password' ";
        $result = $conn -> query($sql);
        
        if($result ->num_rows > 0){
            $data = $result->fetch_assoc();
            $_SESSION["username"] = $data["username"];
            $_SESSION["is_login"] = true;
             header("location: index.php");
        }
        else{
            $login_msg = "Akun Tidak Ditemukan.";
        }
        $conn ->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'layout/navbar.php'; ?>

    <div class="login-form">
        <h2>Login</h2>
        <i><?= $login_msg ?></i>
        <form action="login.php" method="POST">
        <input type="text" placeholder="username" name="username"/>
        <input type="password" placeholder="password" name="password"/>
        <button type="submit" name="login">Masuk sekarang</button>
    </form>
    </div>
</body>
</html>

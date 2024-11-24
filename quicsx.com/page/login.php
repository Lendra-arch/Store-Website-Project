<?php
    include "../service/database.php";
 session_start();

    $login_msg = "";

    if(isset($_SESSION["is_login"])) {
        header("location:../index.php");
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
            $_SESSION["role"] = $data["role"];
            $_SESSION["user_id"] = $data["id"];
            $_SESSION["is_login"] = true;
             header("location:../index.php");
        }
        else{
            $login_msg = "Akun Tidak Ditemukan.";
            echo '<script>alert("Akun Tidak Ditemukan")</script>';
        $conn ->close();
}
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../layout/footer.css">
</head>
<body>

    <?php include "../layout/navbar.php" ?>
    <div class="container">
        <div class="box form-box">
    <header>Login</header>
    <i style="margin-bottom:10px"><?= $login_msg ?></i>
    <form action="login.php" method="POST">
        <div class="field input">
        <input type="text" placeholder="username" name="username"/>
        </div>
    <div class="field input">
        <input type="password" placeholder="password" name="password"/>
        </div>
        <button style="border:none" type="submit" name="login">Masuk sekarang</button>
    </form>
    <p>Belum ada akun? <a href="register.php">Daftar Disini</a></p>
    </div>
    </div>
    <?php include "../layout/footer.php" ?>

</body>
</html>
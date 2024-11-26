<?php
    include "../service/database.php";
    
    $register_message = "";

    if(isset($_POST['daftar'])){
        $username= $_POST['username'];
        $password = $_POST['password'];
        $hash_password = hash("sha256",$password);

        try {
            $sql = "INSERT INTO users (username, password, role) VALUES ('$username','$hash_password', 'user')";
        
            if($conn->query($sql)){
             $register_message = "Daftar akun berhasil, silahkan login";
            }
            else{
                echo "<script>alert('Username sudah ada!')</script>";
            }

        }catch (mysqli_sql_exception) {
            $register_message = "Username sudah digunakan";

        }
        $conn ->close();

        
    }
   

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="icon" href="/quicsx.com/resources/logo.png">
    <link rel="stylesheet" href="../layout/navbar.css">
    <link rel="stylesheet" href="../layout/footer.css">
    <link rel="icon" href="../resources/logo.png">
</head>
<body>
<?php include "../layout/navbar.php" ?>
    <div class="container">
        <div class="box form-box">
    <header>Daftar</header>
    <i style="margin-bottom:10px"><?= $register_message ?></i>
    <form action="register.php" method="POST">
        <div class="field input">
        <input type="text" placeholder="username" name="username"/>
        </div>
    <div class="field input">
        <input type="password" placeholder="password" name="password"/>
        </div>
        <button style="border:none" type="submit" name="daftar">Daftar</button>
    </form>
    <p>Sudah ada akun? <a href="login.php">Masuk disini</a></p>
    </div>
    </div>
    <?php include "../layout/footer.php" ?>

</body>
</html>
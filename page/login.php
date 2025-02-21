<?php
    include "../service/database.php";
    session_start();
    $pesan = isset($_SESSION['pesan']) ? $_SESSION['pesan'] : '';
    unset($_SESSION['pesan']);

    $login_msg = "";

    // Jika user sudah login, arahkan ke halaman terakhir yang diakses atau ke index
    if (isset($_SESSION["is_login"]) && $_SESSION["is_login"] === true) {
    $redirect_url = isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : '../index.php';
    unset($_SESSION['redirect_url']); // Hapus redirect URL setelah digunakan
    header("Location: $redirect_url");
    exit;
}

    if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hash_password = hash("sha256", $password);
    
    $sql = "SELECT * FROM users WHERE username=? AND password=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $hash_password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $_SESSION["username"] = $data["username"];
        $_SESSION["role"] = $data["role"];
        $_SESSION["user_id"] = $data["id"];
        $_SESSION["is_login"] = true;

        // Redirect ke halaman terakhir atau index
        $redirect_url = isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : '../index.php';
        unset($_SESSION['redirect_url']);
        header("Location: $redirect_url");
        exit;
    } else {
        $login_msg = "Akun atau password salah.";
    }
    
    $stmt->close();
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../layout/navbar.css">
    <link rel="icon" href="/resources/logo.png">
    <link rel="stylesheet" href="../layout/footer.css">
</head>
<body>

    <?php include "../layout/navbar.php" ?>
    <div class="container">
        <div class="box form-box">
    <header>Login</header>
    <i style="margin-bottom:10px"><?= $login_msg ?></i>
    <i style="margin-bottom:10px"><?= $pesan ?></i>
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="left-side">
            <div class="logo">
                <span>•</span> Untitled UI
            </div>
            <h1>Welcome back</h1>
            <p>Welcome back! Please enter your details.</p>
            <form action="#">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" placeholder="••••••••" required>
                </div>
                <div class="remember-me">
                    <input type="checkbox" id="remember">
                    <label for="remember">Remember for 30 days</label>
                    <a href="#">Forgot password</a>
                </div>
                <button type="submit">Sign in</button>
                <button type="button" class="google-btn">
                    <img src="google-logo.svg" alt="Google Logo">
                    Sign in with Google
                </button>
                <p>Don't have an account? <a href="#">Sign up</a></p>
            </form>
        </div>
        <div class="right-side">
            <div class="circle"></div>
        </div>
    </div>
</body>
</html>

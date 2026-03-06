<?php
require_once 'db.php';

if (is_logged_in()) {
    redirect('index.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password.";
    } else {
        $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Login success
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            redirect('index.php');
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | CNN Clone</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <style>
        :root { --cnn-red: #cc0000; --cnn-black: #111; }
        * { margin:0; padding:0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: #f8f9fa; }
        header { background: #000; padding: 0 5%; display: flex; align-items: center; height: 60px; border-bottom: 3px solid var(--cnn-red); }
        .logo a { background: var(--cnn-red); color: #fff; font-size: 2.2rem; font-weight: 900; padding: 0 10px; text-decoration: none; letter-spacing: -2px; }
        .auth-box { max-width: 450px; margin: 6rem auto; padding: 3rem; background: #fff; box-shadow: 0 30px 60px rgba(0,0,0,0.1); border-radius: 20px; border-top: 6px solid var(--cnn-red); }
        .auth-box h2 { font-size: 2rem; font-weight: 900; margin-bottom: 2rem; text-align: center; color: #111; }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.6rem; font-weight: 700; font-size: 0.85rem; text-transform: uppercase; color: #666; }
        .form-group input { width: 100%; padding: 1.1rem; border: 2px solid #eee; border-radius: 12px; font-size: 1rem; outline: none; transition: 0.3s; }
        .form-group input:focus { border-color: var(--cnn-red); }
        .btn-auth { width: 100%; padding: 1.2rem; background: var(--cnn-red); color: #fff; border: none; border-radius: 12px; font-weight: 800; font-size: 1.1rem; cursor: pointer; transition: 0.3s; margin-top: 1rem; }
        .btn-auth:hover { background: #b30000; transform: translateY(-2px); }
    </style>
</head>
<body>
    <header>
        <div class="logo"><a href="index.php">CNN</a></div>
        <div style="font-weight: 800; letter-spacing: 1px; color: #fff; margin-left: 20px; font-size: 0.8rem; text-transform: uppercase;">Worldwide</div>
    </header>

    <div class="container">
        <div class="auth-box">
            <h2>Sign In</h2>
            
            <?php if ($error): ?>
                <div style="background: rgba(204, 0, 0, 0.1); color: #cc0000; padding: 1rem; border-radius: 12px; margin-bottom: 2rem; border: 1px solid rgba(204, 0, 0, 0.2); font-weight: 600; text-align: center;">
                    <?= h($error) ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="form-group">
                    <label>Username or Email</label>
                    <input type="text" name="username" placeholder="Enter your credentials" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn-auth">SIGN IN</button>
            </form>
            <p style="text-align: center; margin-top: 2rem; color: #666;">
                Don't have an account? <a href="signup.php" style="color: var(--cnn-red); font-weight: 800; text-decoration: none;">Join CNN</a>
            </p>
        </div>
    </div>
</body>
</html>

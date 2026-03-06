<?php
require_once 'db.php';

if (is_logged_in()) {
    redirect('index.php');
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        // Check if user exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetch()) {
            $error = "Username or Email already exists.";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert user
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            if ($stmt->execute([$username, $email, $hashed_password])) {
                $success = "Registration successful! You can now <a href='login.php'>Login</a>.";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | CNN Clone</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <style>
        :root { --cnn-red: #cc0000; --cnn-black: #111; }
        * { margin:0; padding:0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: #f8f9fa; }
        header { background: #000; padding: 0 5%; display: flex; align-items: center; height: 60px; border-bottom: 3px solid var(--cnn-red); }
        .logo a { background: var(--cnn-red); color: #fff; font-size: 2.2rem; font-weight: 900; padding: 0 10px; text-decoration: none; letter-spacing: -2px; }
        .auth-box { max-width: 500px; margin: 4rem auto; padding: 3rem; background: #fff; box-shadow: 0 30px 60px rgba(0,0,0,0.1); border-radius: 20px; border-top: 6px solid var(--cnn-red); }
        .auth-box h2 { font-size: 2rem; font-weight: 900; margin-bottom: 2rem; text-align: center; color: #111; }
        .form-group { margin-bottom: 1.2rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 700; font-size: 0.8rem; text-transform: uppercase; color: #666; }
        .form-group input { width: 100%; padding: 1rem; border: 2px solid #eee; border-radius: 12px; font-size: 1rem; outline: none; transition: 0.3s; }
        .form-group input:focus { border-color: var(--cnn-red); }
        .btn-auth { width: 100%; padding: 1.1rem; background: var(--cnn-red); color: #fff; border: none; border-radius: 12px; font-weight: 800; font-size: 1.1rem; cursor: pointer; transition: 0.3s; margin-top: 1rem; }
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
            <h2>Join CNN</h2>
            
            <?php if ($error): ?>
                <div style="background: rgba(204, 0, 0, 0.1); color: #cc0000; padding: 1rem; border-radius: 12px; margin-bottom: 2rem; border: 1px solid rgba(204, 0, 0, 0.2); font-weight: 600; text-align: center;">
                    <?= h($error) ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div style="background: rgba(0, 128, 55, 0.1); color: #008037; padding: 1rem; border-radius: 12px; margin-bottom: 2rem; border: 1px solid rgba(0, 128, 55, 0.2); font-weight: 600; text-align: center;">
                    <?= $success ?>
                </div>
            <?php endif; ?>

            <form action="signup.php" method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Choose a unique username" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="example@cnn.com" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Min. 6 characters" required>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" placeholder="Repeat your password" required>
                </div>
                <button type="submit" class="btn-auth">CREATE ACCOUNT</button>
            </form>
            <p style="text-align: center; margin-top: 2rem; color: #666;">
                Already have an account? <a href="login.php" style="color: var(--cnn-red); font-weight: 800; text-decoration: none;">Sign In</a>
            </p>
        </div>
    </div>
</body>
</html>

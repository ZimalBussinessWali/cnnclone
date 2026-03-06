<?php
require_once 'db.php';

if (!is_logged_in()) {
    redirect('login.php');
}

$user = get_current_user_data($pdo);

// Fetch some dynamic stats or purely show profile info
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | CNN Clone</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background: #f4f4f4;">

    <header>
        <div class="logo"><a href="index.php">CNN</a></div>
        <nav class="nav-links">
            <a href="index.php">Home</a>
        </nav>
        <div class="auth-nav">
            <a href="logout.php" class="btn-login">Logout</a>
        </div>
    </header>

    <div class="container">
        <div class="auth-box" style="max-width: 600px; background: white;">
            <div style="text-align: center; margin-bottom: 2rem;">
                <img src="<?= h($user['profile_image']) ?>" alt="Avatar" style="width: 120px; height: 120px; border-radius: 50%; border: 5px solid var(--cnn-red); object-fit: cover;">
                <h1 style="margin-top: 1rem;"><?= h($user['username']) ?></h1>
                <p style="color: #666;"><?= h($user['email']) ?></p>
            </div>

            <div style="border-top: 1px solid var(--cnn-border); padding-top: 2rem;">
                <h3>Account Details</h3>
                <div style="margin-top: 1rem; display: grid; gap: 1rem;">
                    <div style="display: flex; justify-content: space-between; background: #fafafa; padding: 1rem; border-radius: 4px;">
                        <strong>User ID</strong>
                        <span>#<?= $user['id'] ?></span>
                    </div>
                    <div style="display: flex; justify-content: space-between; background: #fafafa; padding: 1rem; border-radius: 4px;">
                        <strong>Username</strong>
                        <span><?= h($user['username']) ?></span>
                    </div>
                    <div style="display: flex; justify-content: space-between; background: #fafafa; padding: 1rem; border-radius: 4px;">
                        <strong>Email</strong>
                        <span><?= h($user['email']) ?></span>
                    </div>
                </div>
                
                <a href="index.php" class="btn-auth" style="display: block; text-align: center; margin-top: 2rem; background: #222;">BACK TO HOME</a>
            </div>
        </div>
    </div>

</body>
</html>

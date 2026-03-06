<?php
require_once 'db.php';

$category_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$category_id) {
    redirect('index.php');
}

// Fetch Category Details
$cat_stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
$cat_stmt->execute([$category_id]);
$category = $cat_stmt->fetch();

if (!$category) {
    redirect('index.php');
}

// Fetch Articles in this Category
$news_stmt = $pdo->prepare("SELECT a.*, c.name as cat_name FROM news_articles a JOIN categories c ON a.category_id = c.id WHERE a.category_id = ? ORDER BY a.created_at DESC");
$news_stmt->execute([$category_id]);
$articles = $news_stmt->fetchAll();

// Fetch all categories for Navbar
$all_cat_stmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
$categories_nav = $all_cat_stmt->fetchAll();

$user = get_current_user_data($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= h($category['name']) ?> News | CNN Clone</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= h($category['name']) ?> News | CNN Clone</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <style>
        :root { --cnn-red: #cc0000; --cnn-black: #111; }
        * { margin:0; padding:0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        header { background: #000; padding: 0 5%; display: flex; align-items: center; height: 60px; border-bottom: 3px solid var(--cnn-red); justify-content: space-between; }
        .logo a { background: var(--cnn-red); color: #fff; font-size: 2.2rem; font-weight: 900; padding: 0 10px; text-decoration: none; letter-spacing: -2px; }
        .nav-links { display: flex; gap: 20px; text-transform: uppercase; font-weight: 700; font-size: 0.9rem; }
        .nav-links a { color: #fff; text-decoration: none; opacity: 0.8; }
        .container { max-width: 1400px; margin: 3rem auto; padding: 0 4%; }
        .section-title { font-size: 3rem; font-weight: 900; margin-bottom: 3rem; border-bottom: 8px solid var(--cnn-red); display: inline-block; padding-bottom: 0.5rem; }
        .news-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 40px; }
        .card img { width: 100%; height: 220px; object-fit: cover; border-radius: 8px; margin-bottom: 15px; background: #eee; }
        .card h3 { font-size: 1.4rem; font-weight: 800; line-height: 1.25; }
        .card-cat { color: var(--cnn-red); font-weight: 900; text-transform: uppercase; font-size: 0.8rem; margin-bottom: 8px; display: block; }
    </style>
</head>
<body>

    <header>
        <div style="display: flex; align-items: center; gap: 40px;">
            <div class="logo"><a href="index.php">CNN</a></div>
            <nav class="nav-links">
                <a href="index.php">Home</a>
                <?php foreach ($categories_nav as $cat): ?>
                    <a href="category.php?id=<?= $cat['id'] ?>" style="<?= ($cat['id'] == $category_id) ? 'opacity: 1; color: var(--cnn-red);' : '' ?>"><?= h($cat['name']) ?></a>
                <?php endforeach; ?>
            </nav>
        </div>
        <div class="auth-nav">
             <?php if ($user): ?>
                <a href="logout.php" style="color: #fff; text-decoration: none; font-weight: 700; background: var(--cnn-red); padding: 8px 15px; border-radius: 20px; font-size: 0.8rem;">Logout</a>
            <?php else: ?>
                <a href="login.php" style="color: #fff; text-decoration: none; font-weight: 700; background: var(--cnn-red); padding: 8px 20px; border-radius: 25px;">Sign Up</a>
            <?php endif; ?>
        </div>
    </header>

    <main class="container">
        <h1 class="section-title"><?= h($category['name']) ?></h1>
        
        <?php if (empty($articles)): ?>
            <div style="padding: 10rem 0; text-align: center; color: #666;">
                <h2 style="font-size: 2rem; font-weight: 300;">No articles found in this category yet.</h2>
                <a href="index.php" style="display: inline-block; margin-top: 2rem; background: var(--cnn-red); color: #fff; padding: 12px 30px; text-decoration: none; font-weight: 700; border-radius: 30px;">Return Home</a>
            </div>
        <?php else: ?>
            <section class="news-grid">
                <?php foreach ($articles as $news): ?>
                    <div class="card">
                        <a href="article.php?id=<?= $news['id'] ?>" style="text-decoration: none; color: inherit;">
                            <img src="<?= h($news['image_url']) ?>" alt="<?= h($news['title']) ?>" onerror="this.src='https://placehold.co/600x400/000/fff?text=CNN+News'">
                            <span class="card-cat"><?= h($news['cat_name']) ?></span>
                            <h3><?= h($news['title']) ?></h3>
                            <p style="color: #666; font-size: 0.95rem; margin-top: 10px; line-height: 1.4;"><?= h(substr($news['description'], 0, 150)) ?>...</p>
                        </a>
                    </div>
                <?php endforeach; ?>
            </section>
        <?php endif; ?>
    </main>

    <footer style="background: #000; color: #fff; padding: 4rem 5%; margin-top: 5rem; text-align: center;">
        <div class="logo" style="margin-bottom: 1.5rem;"><a href="index.php">CNN</a></div>
        <p style="color: #666; font-size: 0.9rem;">© 2026 Cable News Network. A Warner Bros. Discovery Company. All Rights Reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>

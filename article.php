<?php
require_once 'db.php';

$article_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$article_id) {
    redirect('index.php');
}

// Fetch Article Details
$stmt = $pdo->prepare("SELECT a.*, c.name as cat_name FROM news_articles a JOIN categories c ON a.category_id = c.id WHERE a.id = ?");
$stmt->execute([$article_id]);
$article = $stmt->fetch();

if (!$article) {
    redirect('index.php');
}

// Fetch Related News (same category, different id)
$related_stmt = $pdo->prepare("SELECT id, title, image_url FROM news_articles WHERE category_id = ? AND id != ? LIMIT 3");
$related_stmt->execute([$article['category_id'], $article_id]);
$related = $related_stmt->fetchAll();

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
    <title><?= h($article['title']) ?> | CNN Clone</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <style>
        :root { --cnn-red: #cc0000; --cnn-black: #111; }
        * { margin:0; padding:0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        header { background: #000; padding: 0 5%; display: flex; align-items: center; height: 60px; border-bottom: 3px solid var(--cnn-red); justify-content: space-between; }
        .logo a { background: var(--cnn-red); color: #fff; font-size: 2.2rem; font-weight: 900; padding: 0 10px; text-decoration: none; letter-spacing: -2px; }
        .nav-links { display: flex; gap: 20px; text-transform: uppercase; font-weight: 700; font-size: 0.9rem; }
        .nav-links a { color: #fff; text-decoration: none; opacity: 0.8; }
        .container { max-width: 1000px; margin: 4rem auto; padding: 0 4%; }
        .article-header { border-bottom: 1px solid #eee; margin-bottom: 3rem; padding-bottom: 1rem; }
        .article-header h1 { font-size: 3.5rem; font-weight: 900; line-height: 1.1; margin: 15px 0; }
        .card-cat { color: var(--cnn-red); font-weight: 900; text-transform: uppercase; font-size: 0.9rem; }
        .article-meta { color: #666; font-size: 0.9rem; font-weight: 600; text-transform: uppercase; display: flex; gap: 20px; }
        .article-content { font-size: 1.25rem; line-height: 1.8; color: #222; }
        .article-content p { margin-bottom: 2rem; }
        .article-content p:first-of-type { font-size: 1.6rem; font-weight: 300; line-height: 1.6; color: #444; border-bottom: 1px solid #f0f0f0; padding-bottom: 2rem; }
        .share-btn { width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; text-decoration: none; font-weight: 900; font-size: 1.2rem; }
    </style>
</head>
<body>

    <header>
        <div style="display: flex; align-items: center; gap: 40px;">
            <div class="logo"><a href="index.php">CNN</a></div>
            <nav class="nav-links">
                <a href="index.php">Home</a>
                <?php foreach ($categories_nav as $cat): ?>
                    <a href="category.php?id=<?= $cat['id'] ?>"><?= h($cat['name']) ?></a>
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
        <article class="article-full">
            <div class="article-header">
                <span class="card-cat"><?= h($article['cat_name']) ?></span>
                <h1><?= h($article['title']) ?></h1>
                
                <div class="article-meta">
                    <div>By <strong><?= h($article['author']) ?></strong>, CNN</div>
                    <div>Published <?= date('F j, Y', strtotime($article['created_at'])) ?></div>
                </div>
            </div>

            <img src="<?= h($article['image_url']) ?>" alt="<?= h($article['title']) ?>" style="width: 100%; border-radius: 12px; margin-bottom: 3rem; box-shadow: 0 20px 40px rgba(0,0,0,0.1);" onerror="this.src='https://placehold.co/1200x800/cc0000/fff?text=CNN+News'">

            <div class="article-content">
                <p><strong>(CNN) — </strong> <?= h($article['description']) ?></p>
                
                <?php 
                    $paragraphs = explode("\n", h($article['content']));
                    foreach ($paragraphs as $para) {
                        if (trim($para)) { echo "<p>" . trim($para) . "</p>"; }
                    }
                ?>
            </div>

            <div style="margin-top: 5rem; padding-top: 3rem; border-top: 1px solid #eee;">
                <h3 style="font-weight: 900; margin-bottom: 1.5rem; text-transform: uppercase;">Share this story</h3>
                <div style="display: flex; gap: 1rem;">
                    <a href="#" class="share-btn" style="background: #1877f2;">f</a>
                    <a href="#" class="share-btn" style="background: #1da1f2;">t</a>
                    <a href="#" class="share-btn" style="background: #0077b5;">in</a>
                    <a href="#" class="share-btn" style="background: #25d366;">w</a>
                </div>
            </div>
        </article>

        <?php if (!empty($related)): ?>
        <section style="margin-top: 6rem;">
            <div style="font-size: 2rem; font-weight: 900; margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 2px solid #000;">Related Stories</div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px;">
                <?php foreach ($related as $r): ?>
                    <div class="card">
                        <a href="article.php?id=<?= $r['id'] ?>" style="text-decoration: none; color: inherit;">
                            <img src="<?= h($r['image_url']) ?>" alt="<?= h($r['title']) ?>" style="width: 100%; height: 180px; object-fit: cover; border-radius: 8px; margin-bottom: 10px;" onerror="this.src='https://placehold.co/600x400/000/fff?text=CNN+News'">
                            <h3 style="font-size: 1.1rem; font-weight: 800; line-height: 1.3;"><?= h($r['title']) ?></h3>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>
    </main>

    <footer style="background: #000; color: #fff; padding: 4rem 5%; margin-top: 5rem; text-align: center;">
        <div class="logo" style="margin-bottom: 1.5rem;"><a href="index.php">CNN</a></div>
        <p style="color: #666; font-size: 0.9rem;">© 2026 Cable News Network. A Warner Bros. Discovery Company. All Rights Reserved.</p>
    </footer>

    <script src="script.js"></script>

    <script src="script.js"></script>
</body>
</html>

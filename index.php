<?php
require_once 'db.php';

// Fetch Categories for Navbar
$cat_stmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
$categories = $cat_stmt->fetchAll();

// Fetch Featured Article
$featured_stmt = $pdo->query("SELECT a.*, c.name as cat_name FROM news_articles a JOIN categories c ON a.category_id = c.id WHERE a.is_featured = 1 LIMIT 1");
$featured = $featured_stmt->fetch();

// Fetch Breaking News for Ticker
$breaking_stmt = $pdo->query("SELECT title FROM news_articles WHERE is_breaking = 1 ORDER BY created_at DESC LIMIT 5");
$breaking_news = $breaking_stmt->fetchAll();

// Fetch Latest News
$latest_stmt = $pdo->query("SELECT a.*, c.name as cat_name FROM news_articles a JOIN categories c ON a.category_id = c.id ORDER BY a.created_at DESC LIMIT 10");
$latest_news = $latest_stmt->fetchAll();

$user = get_current_user_data($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CNN Clone | Breaking News, World News and Video</title>
    <!-- External CSS with Cache Buster -->
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <!-- Internal CSS Fallback for Core Layout -->
    <style>
        :root { --cnn-red: #cc0000; --cnn-black: #000000; }
        * { margin:0; padding:0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: #fff; overflow-x: hidden; }
        header { 
            background: var(--cnn-black); 
            color: #fff; 
            padding: 0 5%; 
            display: flex; 
            align-items: center; 
            height: 60px; 
            border-bottom: 3px solid var(--cnn-red);
            justify-content: space-between;
        }
        .logo a { 
            background: var(--cnn-red); 
            color: #fff; 
            font-size: 2.2rem; 
            font-weight: 900; 
            padding: 0 10px; 
            text-decoration: none;
            letter-spacing: -2px;
        }
        .nav-links { display: flex; gap: 20px; text-transform: uppercase; font-weight: 700; font-size: 0.9rem; }
        .nav-links a { color: #fff; text-decoration: none; opacity: 0.8; }
        .nav-links a:hover { opacity: 1; }
        .ticker-wrap { background: #f1f1f1; border-bottom: 1px solid #ddd; overflow: hidden; height: 40px; display: flex; align-items: center; }
        .ticker-title { background: var(--cnn-red); color: #fff; padding: 0 20px; font-weight: 900; height: 100%; display: flex; align-items: center; text-transform: uppercase; font-size: 0.8rem; z-index: 10; }
        .ticker { display: flex; white-space: nowrap; animation: move 40s linear infinite; }
        @keyframes move { 
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .ticker-item { padding: 0 30px; font-weight: 600; font-size: 0.9rem; }
        .container { max-width: 1400px; margin: 2rem auto; padding: 0 4%; }
        .hero-news { display: grid; grid-template-columns: 2fr 1fr; gap: 40px; margin-bottom: 40px; }
        .featured-main { position: relative; height: 500px; border-radius: 8px; overflow: hidden; display: block; }
        .featured-main img { width: 100%; height: 100%; object-fit: cover; }
        .featured-overlay { position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.9)); padding: 40px; color: #fff; }
        .featured-overlay h1 { font-size: 3rem; font-weight: 900; line-height: 1.1; margin-bottom: 15px; }
        .card-cat { color: var(--cnn-red); font-weight: 800; text-transform: uppercase; font-size: 0.8rem; margin-bottom: 10px; display: block; }
        .news-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 40px; }
        .card img { width: 100%; height: 200px; object-fit: cover; border-radius: 8px; margin-bottom: 15px; background: #eee; }
        .card h3 { font-size: 1.3rem; font-weight: 800; line-height: 1.25; }
        .footer-logo { font-size: 3rem; font-weight: 900; color: #fff; background: var(--cnn-red); padding: 0 10px; display: inline-block; margin-bottom: 20px; }
    </style>
</head>
<body>

    <header>
        <div style="display: flex; align-items: center; gap: 40px;">
            <div class="logo"><a href="index.php">CNN</a></div>
            <nav class="nav-links">
                <a href="index.php">Home</a>
                <?php foreach ($categories as $cat): ?>
                    <a href="category.php?id=<?= $cat['id'] ?>"><?= h($cat['name']) ?></a>
                <?php endforeach; ?>
            </nav>
        </div>
        <div class="auth-nav">
            <?php if ($user): ?>
                <span style="font-weight: 600; color: #fff; margin-right: 15px; font-size: 0.9rem;">Hello, <?= h($user['username']) ?></span>
                <a href="logout.php" style="color: #fff; text-decoration: none; font-weight: 700; background: var(--cnn-red); padding: 6px 15px; border-radius: 20px; font-size: 0.8rem;">Logout</a>
            <?php else: ?>
                <a href="login.php" style="color: #fff; text-decoration: none; font-weight: 700; margin-right: 15px;">Log In</a>
                <a href="signup.php" style="color: #fff; text-decoration: none; font-weight: 700; background: var(--cnn-red); padding: 8px 20px; border-radius: 25px;">Sign Up</a>
            <?php endif; ?>
        </div>
    </header>

    <div class="ticker-wrap">
        <div class="ticker-title">Breaking News</div>
        <div class="ticker">
            <?php foreach ($breaking_news as $bn): ?>
                <div class="ticker-item"><?= h($bn['title']) ?></div>
            <?php endforeach; ?>
            <!-- Dup for loop -->
             <?php foreach ($breaking_news as $bn): ?>
                <div class="ticker-item"><?= h($bn['title']) ?></div>
            <?php endforeach; ?>
        </div>
    </div>

    <main class="container">
        <?php if ($featured): ?>
        <section class="hero-news">
            <a href="article.php?id=<?= $featured['id'] ?>" class="featured-main">
                <img src="<?= h($featured['image_url']) ?>" alt="Featured Image" onerror="this.src='https://placehold.co/1200x800/cc0000/fff?text=CNN+News'">
                <div class="featured-overlay">
                    <span class="card-cat"><?= h($featured['cat_name']) ?></span>
                    <h1><?= h($featured['title']) ?></h1>
                    <p style="opacity: 0.9;"><?= h($featured['description']) ?></p>
                </div>
            </a>
            
            <div class="featured-side">
                <h2 style="font-size: 1.5rem; font-weight: 900; margin-bottom: 1.5rem; border-left: 5px solid var(--cnn-red); padding-left: 15px;">Editors' Choice</h2>
                <?php 
                $slice = array_slice($latest_news, 1, 4);
                foreach ($slice as $item): 
                ?>
                <div style="display: flex; gap: 15px; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #eee;">
                    <img src="<?= h($item['image_url']) ?>" style="width: 100px; height: 75px; object-fit: cover; border-radius: 4px;" onerror="this.src='https://placehold.co/200x150/000/fff?text=CNN'">
                    <div style="flex: 1;">
                        <span class="card-cat" style="font-size: 0.65rem; margin-bottom: 4px;"><?= h($item['cat_name']) ?></span>
                        <h4 style="font-size: 0.95rem; font-weight: 800;"><a href="article.php?id=<?= $item['id'] ?>" style="color: #000; text-decoration: none;"><?= h($item['title']) ?></a></h4>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <div style="font-size: 2rem; font-weight: 900; margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 2px solid #000;">Latest News</div>

        <section class="news-grid">
            <?php foreach ($latest_news as $news): ?>
                <div class="card">
                    <a href="article.php?id=<?= $news['id'] ?>" style="text-decoration: none; color: inherit;">
                        <img src="<?= h($news['image_url']) ?>" alt="<?= h($news['title']) ?>" onerror="this.src='https://placehold.co/600x400/000/fff?text=CNN+News'">
                        <span class="card-cat"><?= h($news['cat_name']) ?></span>
                        <h3><?= h($news['title']) ?></h3>
                        <p style="color: #666; font-size: 0.95rem; margin-top: 10px; line-height: 1.4;"><?= h(substr($news['description'], 0, 100)) ?>...</p>
                    </a>
                </div>
            <?php endforeach; ?>
        </section>

    </main>

    <footer style="background: #000; color: #fff; padding: 5rem 5% 3rem; margin-top: 5rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 4rem;">
            <div>
                <div class="footer-logo">CNN</div>
                <p style="color: #888; margin-top: 1rem; font-size: 0.9rem;">© 2026 Cable News Network. A Warner Bros. Discovery Company. All Rights Reserved.</p>
            </div>
            <div>
                <h4 style="font-weight: 900; margin-bottom: 1.5rem; text-transform: uppercase;">Explore</h4>
                <ul style="list-style: none;">
                    <li style="margin-bottom: 0.8rem;"><a href="#" style="color: #888; text-decoration: none;">World</a></li>
                    <li style="margin-bottom: 0.8rem;"><a href="#" style="color: #888; text-decoration: none;">Politics</a></li>
                    <li style="margin-bottom: 0.8rem;"><a href="#" style="color: #888; text-decoration: none;">Business</a></li>
                </ul>
            </div>
            <div>
                <h4 style="font-weight: 900; margin-bottom: 1.5rem; text-transform: uppercase;">Support</h4>
                <ul style="list-style: none;">
                    <li style="margin-bottom: 0.8rem;"><a href="#" style="color: #888; text-decoration: none;">Help Center</a></li>
                    <li style="margin-bottom: 0.8rem;"><a href="#" style="color: #888; text-decoration: none;">Contact Us</a></li>
                    <li style="margin-bottom: 0.8rem;"><a href="#" style="color: #888; text-decoration: none;">Terms of Use</a></li>
                </ul>
            </div>
        </div>
        <div style="margin-top: 4rem; padding-top: 2rem; border-top: 1px solid #333; text-align: center; color: #666; font-size: 0.8rem;">
            CNN International | CNN Arabic | CNN Español | Design by Antigravity AI
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>

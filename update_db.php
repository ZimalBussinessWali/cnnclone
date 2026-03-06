<?php
require_once 'db.php';

echo "<h2>Updating Database with Working Unsplash Images...</h2>";

$updates = [
    'Global Markets Rally as Inflation Cools' => 'https://images.unsplash.com/photo-1611974714658-75d4f1ad338d?auto=format&fit=crop&w=1200&q=80',
    'New Mars Rover Discoveries Suggest Ancient Water' => 'https://images.unsplash.com/photo-1614728894747-a83421e2b9c9?auto=format&fit=crop&w=1200&q=80',
    'The Future of AI in Modern Healthcare' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=1200&q=80',
    'Major Sports Event Postponed Due to Weather' => 'https://images.unsplash.com/photo-1540747913346-19e32dc3e97e?auto=format&fit=crop&w=1200&q=80'
];

try {
    $stmt = $pdo->prepare("UPDATE news_articles SET image_url = ? WHERE title = ?");
    
    foreach ($updates as $title => $url) {
        $stmt->execute([$url, $title]);
        echo "Updated: <strong>$title</strong><br>";
    }
    
    echo "<h3 style='color: green;'>Success! Database updated with Unsplash images.</h3>";
    echo "<p><a href='index.php'>Return Home</a></p>";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

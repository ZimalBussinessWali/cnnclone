<?php
// Simple script to create placeholder images for the news website
// This creates basic colored rectangles as placeholder images

function createPlaceholderImage($width, $height, $color, $text, $filename) {
    // Create image
    $image = imagecreate($width, $height);
    
    // Define colors
    $bg_color = imagecolorallocate($image, hexdec(substr($color, 1, 2)), hexdec(substr($color, 3, 2)), hexdec(substr($color, 5, 2)));
    $text_color = imagecolorallocate($image, 255, 255, 255);
    
    // Fill background
    imagefill($image, 0, 0, $bg_color);
    
    // Add text
    $font_size = 5;
    $text_width = imagefontwidth($font_size) * strlen($text);
    $text_height = imagefontheight($font_size);
    $x = ($width - $text_width) / 2;
    $y = ($height - $text_height) / 2;
    
    imagestring($image, $font_size, $x, $y, $text, $text_color);
    
    // Save image
    imagejpeg($image, $filename, 90);
    imagedestroy($image);
}

// Create images directory if it doesn't exist
if (!file_exists('assets/images')) {
    mkdir('assets/images', 0777, true);
}

// Define image data
$images = [
    ['news1.jpg', 400, 300, '#c41e3a', 'Climate News'],
    ['news2.jpg', 400, 300, '#2c5aa0', 'Tech News'],
    ['news3.jpg', 400, 300, '#28a745', 'Sports News'],
    ['news4.jpg', 400, 300, '#17a2b8', 'Health News'],
    ['news5.jpg', 400, 300, '#6f42c1', 'Space News'],
    ['news6.jpg', 400, 300, '#fd7e14', 'World News'],
    ['news7.jpg', 400, 300, '#20c997', 'Sports News'],
    ['news8.jpg', 400, 300, '#e83e8c', 'Entertainment']
];

// Create placeholder images
foreach ($images as $image) {
    $filename = 'assets/images/' . $image[0];
    createPlaceholderImage($image[1], $image[2], $image[3], $image[4], $filename);
    echo "Created: $filename\n";
}

echo "All placeholder images created successfully!\n";
?>


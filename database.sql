-- Database Schema for CNN Clone
CREATE DATABASE IF NOT EXISTS rsk80_38;
USE rsk80_38;

-- Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    profile_image VARCHAR(255) DEFAULT 'https://ui-avatars.com/api/?name=User&background=cc0000&color=fff',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Categories Table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    slug VARCHAR(50) NOT NULL UNIQUE
);

-- News Articles Table
CREATE TABLE IF NOT EXISTS news_articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    content LONGTEXT NOT NULL,
    image_url VARCHAR(255),
    category_id INT,
    author VARCHAR(100) DEFAULT 'CNN Correspondent',
    is_featured BOOLEAN DEFAULT FALSE,
    is_breaking BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Seed Categories
INSERT IGNORE INTO categories (name, slug) VALUES 
('World', 'world'),
('Politics', 'politics'),
('Business', 'business'),
('Technology', 'technology'),
('Sports', 'sports'),
('Entertainment', 'entertainment');

-- Seed Sample Articles
INSERT INTO news_articles (title, description, content, image_url, category_id, author, is_featured, is_breaking) VALUES
('Global Markets Rally as Inflation Cools', 'Major indices across the globe saw significant gains following the latest economic data showing a slowdown in inflation rates.', 'Stock markets in New York, London, and Tokyo recorded their best single-day performance in months as investors cheered the latest consumer price index data. Analysts suggest that the Federal Reserve might pause its rate hike cycle, providing a much-needed boost to the tech sector and emerging markets alike. Global leaders have welcomed the stability, though some caution that the path to full economic recovery remains complex.', 'assets/images/business.png', 3, 'Sarah Johnson', TRUE, FALSE),
('New Mars Rover Discoveries Suggest Ancient Water', 'NASA scientists have unveiled new evidence from the Perseverance rover that suggests the presence of ancient liquid water in the Jezero Crater.', 'The Red Planet continues to reveal its secrets. The latest data transmitted back to Earth indicates mineral deposits that could only have formed in a standing body of water. "This is a monumental step in our quest to understand if life ever existed on Mars," said the lead scientist at JPL. The rover is now heading towards a river delta where scientists hope to find biosignatures preserved in the rock layers.', 'assets/images/mars.png', 4, 'Dr. Marcus Wright', FALSE, TRUE),
('The Future of AI in Modern Healthcare', 'How artificial intelligence is revolutionizing patient care and diagnostic accuracy in hospitals worldwide.', 'From early cancer detection to personalized treatment plans, AI is becoming an indispensable tool in the medical field. Researchers are developing algorithms that can process MRI scans faster and more accurately than the human eye. Critics raise concerns about privacy and the dehumanization of care, but the consensus remains that the potential for saving lives is unparalleled.', 'assets/images/healthcare.png', 4, 'Tech Desk', FALSE, FALSE),
('Major Sports Event Postponed Due to Weather', 'The international championship finals have been pushed back as extreme rainfall hits the stadium region.', 'Fans who traveled from across the globe were left disappointed as the organizing committee announced a 48-hour delay. Safety concerns regarding the drainage system and lightning risks led to the decision. Tickets will remain valid for the rescheduled date, and local authorities are working to accommodate stranded visitors.', 'assets/images/sports.png', 5, 'Sports Central', FALSE, TRUE);

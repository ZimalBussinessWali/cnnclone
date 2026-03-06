# CNN Clone - News Website

A fully functional news website inspired by CNN, built with PHP, CSS, and JavaScript.

## Features

✅ **Homepage Design**
- Featured news section with latest and breaking news
- News categories (World, Sports, Technology, Entertainment, Politics, Health)
- Thumbnails and descriptions for each news article
- Responsive layout for all devices

✅ **Core Features**
- Dynamic navigation between homepage, categories, and article pages
- Mock data system for displaying news content
- Responsive design for desktop and mobile devices
- Search functionality
- Mobile-friendly hamburger menu

✅ **Article Page**
- Full article display with title, content, and metadata
- Related news suggestions
- Social sharing functionality
- Bookmark system
- Breadcrumb navigation

✅ **Additional Features**
- Breaking news ticker
- Smooth animations and transitions
- Mobile-responsive design
- Search functionality
- Social media integration
- Bookmark system with localStorage

## Setup Instructions

1. **Prerequisites**
   - PHP 7.4 or higher
   - Web server (Apache/Nginx) or PHP built-in server
   - Modern web browser

2. **Installation**
   ```bash
   # Clone or download the project
   # Navigate to the project directory
   cd cnnclone
   
   # Create placeholder images
   php create_placeholder_images.php
   
   # Start PHP built-in server (if not using Apache/Nginx)
   php -S localhost:8000
   ```

3. **Access the Website**
   - Open your browser and go to `http://localhost:8000`
   - Or if using Apache/Nginx, access through your web server

## File Structure

```
cnnclone/
├── index.php              # Homepage
├── category.php           # Category pages
├── article.php            # Individual article pages
├── includes/
│   ├── config.php         # Configuration
│   └── functions.php      # Mock data functions
├── assets/
│   ├── css/
│   │   └── style.css      # Main stylesheet
│   ├── js/
│   │   └── script.js      # JavaScript functionality
│   └── images/            # News images (created by script)
├── create_placeholder_images.php  # Image generation script
└── README.md              # This file
```

## Features Overview

### Homepage
- **Featured News Section**: Large featured article with smaller supporting articles
- **Categories Grid**: Visual category cards with article counts
- **Latest News**: Chronological list of recent articles
- **Breaking News Ticker**: Animated scrolling breaking news banner

### Category Pages
- **Category Header**: Icon, title, description, and article count
- **News Grid**: Responsive grid layout for category articles
- **Navigation**: Easy navigation back to homepage

### Article Pages
- **Full Article Content**: Complete article with images and text
- **Article Metadata**: Author, date, read time, category
- **Related Articles**: Suggestions based on category
- **Social Sharing**: Share to Facebook, Twitter, LinkedIn
- **Bookmark System**: Save articles for later reading

### Responsive Design
- **Mobile-First**: Optimized for mobile devices
- **Tablet Support**: Responsive grid layouts
- **Desktop Enhancement**: Full desktop experience
- **Touch-Friendly**: Mobile navigation and interactions

### JavaScript Features
- **Mobile Menu**: Hamburger menu for mobile devices
- **Search Functionality**: Real-time search with suggestions
- **Smooth Animations**: Fade-in effects and transitions
- **Social Sharing**: Native share API with fallbacks
- **Bookmark System**: Local storage for saved articles
- **Scroll Effects**: Header hide/show on scroll

## Customization

### Adding New Categories
1. Update the `getCategories()` function in `includes/functions.php`
2. Add navigation links in the header
3. Update category page routing

### Adding New Articles
1. Add article data to the appropriate function in `includes/functions.php`
2. Create corresponding placeholder images
3. Update the image paths in the article data

### Styling
- Main styles are in `assets/css/style.css`
- Uses CSS Grid and Flexbox for layouts
- Customizable color scheme via CSS variables
- Responsive breakpoints for different screen sizes

## Browser Support

- Chrome 60+
- Firefox 55+
- Safari 12+
- Edge 79+
- Mobile browsers (iOS Safari, Chrome Mobile)

## Future Enhancements

- Database integration (MySQL/PostgreSQL)
- User authentication and profiles
- Comments system
- Newsletter subscription
- RSS feeds
- Admin panel for content management
- Real news API integration
- Image optimization and lazy loading
- Progressive Web App (PWA) features

## License

This project is for educational purposes. CNN is a trademark of Cable News Network, Inc.


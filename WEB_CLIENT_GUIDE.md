# 🌐 Web Client Guide

## Overview

The Books API includes a modern, responsive web client built with Bootstrap 5 that provides an intuitive interface for searching and browsing books from the Gutendex API.

## Access

**URL**: http://localhost:8000/client.html

## Features

### 🎨 Modern Design
- Gradient purple theme with smooth animations
- Card-based layout for better readability
- Hover effects on book cards
- Clean, professional interface

### 🔍 Search Functionality
- **Free text search**: Search by book title, author, or subject
- **Quick search buttons**: Instant access to popular searches
  - Shakespeare
  - Dickens
  - Tolstoy
  - Python
  - Love

### 📚 Book Display
- **Interactive cards** showing:
  - Book title
  - Author(s) with birth/death years
  - Up to 3 subjects (with "+X more" indicator)
  - Gutendex ID
- **Click any book** to see full details in a modal

### 👁️ Detailed View (Modal)
- Complete list of authors with lifespans
- All subjects/categories
- Full book information
- Quick close button

### 📱 Responsive Design
- Works on desktop, tablet, and mobile
- Adapts to different screen sizes
- Touch-friendly on mobile devices

## Usage

### Basic Search

1. Open http://localhost:8000/client.html
2. Type a search term in the input field
3. Click "Search" or press Enter
4. Results appear instantly

### Quick Search

Click any of the quick search buttons:
- **Shakespeare** - Classic plays and sonnets
- **Dickens** - Victorian literature
- **Tolstoy** - Russian classics
- **Python** - Programming books
- **Love** - Romance themed books

### View Book Details

1. Find a book in the search results
2. Click anywhere on the book card
3. A modal opens with full details:
   - Complete author information
   - All subjects and categories
   - Gutendex ID for API reference

## Technical Details

### API Integration
- **Real-time**: Fetches data directly from `/api/books` endpoint
- **Error handling**: Displays user-friendly error messages
- **Loading states**: Shows spinner while searching

### Technologies
- **Bootstrap 5**: UI framework
- **Bootstrap Icons**: Icon library
- **Vanilla JavaScript**: No dependencies
- **Fetch API**: Modern HTTP requests

### Browser Compatibility
- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Customization

The client can be easily customized by editing `public/client.html`:

### Change Colors
Look for the `<style>` section and modify:
```css
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
```

### Add Quick Search Buttons
Add more buttons in the Quick Search section:
```html
<button class="btn btn-sm btn-outline-secondary m-1 quick-search" 
        data-query="your-search">Your Label</button>
```

### Modify Card Display
Edit the `createBookCard()` function to change:
- Number of subjects shown (currently 3)
- Card styling
- Information displayed

## Screenshots

### Main Interface
The homepage features:
- Large search bar with placeholder text
- Quick search buttons for popular queries
- Clean, gradient background

### Search Results
After searching:
- Grid layout of book cards (3 per row on desktop)
- Each card shows title, author, subjects
- Hover effect highlights cards

### Book Details Modal
Clicking a book opens:
- Large modal with complete information
- Organized sections for authors and subjects
- Close button or click outside to dismiss

## Tips

1. **Use Quick Search** for instant results without typing
2. **Try different terms**: Search by title, author, or subject
3. **Click any book** to see all details and subjects
4. **Mobile friendly**: Works great on phones and tablets
5. **No installation**: Just open in any browser

## Troubleshooting

### "An error occurred: API error"
- Check that the API server is running on port 8000
- Verify Docker container is up: `docker ps`
- Try restarting: `docker-compose restart`

### "No results found"
- Try a different search term
- Use quick search buttons for guaranteed results
- Check spelling of author names

### Page not loading
- Ensure server is running: `docker-compose up -d`
- Check URL is exactly: http://localhost:8000/client.html
- Clear browser cache and reload

## Integration with Docker

The client is automatically available when using Docker:

```bash
# Start
docker-compose up -d

# Access client
open http://localhost:8000/client.html

# Stop
docker-compose down
```

## Future Enhancements

Potential additions:
- Pagination for large result sets
- Advanced filters (by year, language)
- Bookmarking favorite books
- Download links to books
- Reading list management
- Dark mode toggle

---

**Enjoy exploring millions of books from Project Gutenberg!** 📖✨

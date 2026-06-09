# Arc Tour Luxe

A premium tourism website built with:

- HTML5, Bootstrap 5, CSS3, JavaScript, jQuery
- PHP + MySQL
- Secure login/register flow
- Admin CRUD for tour packages
- Image upload support
- Responsive luxury-style UI

## Folder structure

- `index.php` — Home page
- `destinations.php` — Destinations gallery with filters
- `packages.php` — Packages loaded from MySQL
- `booking.php` — Booking form with AJAX submission
- `login.php` / `register.php` — User auth
- `admin/` — Admin dashboard and CRUD
- `includes/` — Shared DB + header/footer
- `assets/css/style.css` — Premium visual design
- `assets/js/script.js` — jQuery interactions
- `sql/database.sql` — Database schema and demo data

## Setup

1. Create a MySQL database named `tourism_db`.
2. Import `sql/database.sql`.
3. Update `includes/db.php` if your DB username/password differs.
4. Upload the project to your PHP server.
5. Open `index.php` in the browser.

## Demo admin login

- Email: `admin@tourism.com`
- Password: `admin123`

## Notes

- Package images use online placeholders from Unsplash.
- For production, replace placeholder URLs with your own optimized images.
- Booking submissions are stored in the `bookings` table.

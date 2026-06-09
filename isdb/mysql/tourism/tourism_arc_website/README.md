# Tourism Arc Website

A premium tourism website starter project built with:
- HTML5
- Bootstrap 5
- CSS3
- JavaScript
- jQuery
- PHP
- MySQL

## Files
- `index.php` – modern landing page
- `destinations.php` – destination grid with search/filter
- `packages.php` – package listing page
- `booking.php` – booking form with database insert
- `login.php` / `register.php` – auth templates
- `admin/dashboard.php` – admin starter dashboard
- `includes/db.php` – database connection + helper functions
- `includes/header.php` / `includes/footer.php` – shared layout
- `assets/css/style.css` – premium arc-style design
- `assets/js/script.js` – jQuery interactions
- `sql/tourism.sql` – database schema + sample data

## Run locally
1. Import `sql/tourism.sql` into MySQL.
2. Update credentials in `includes/db.php`.
3. Put the project inside `htdocs` if using XAMPP.
4. Open `http://localhost/tourism_arc_website/index.php`.

## Notes
- If the database is not available, the site uses fallback demo data so you can still preview the design.
- External CSS/JS are loaded from Bootstrap/CDN for convenience.

# Royal Atlas Tourism Website

Royal Atlas is a premium PHP tourism website with cinematic fullscreen travel panels, real high-resolution destination photography, royal texture overlays, AJAX interactions, JSON storage, and an optional MySQL upgrade path.

## Run Without MySQL

1. Put this folder inside `htdocs` if you use XAMPP, or serve it with any PHP 8+ server.
2. Open `index.php` in the browser through the PHP server.
3. Login with:
   - Admin: `admin@royalatlas.test`
   - Traveler: `traveler@royalatlas.test`
   - Password for both: `password`

The site stores packages, bookings, destinations, and users in `storage/*.json`, so it works now without importing a database.

## Optional MySQL Mode

1. Import `database/schema.sql`.
2. Import `database/seed.sql`.
3. Edit `db.php` and change `USE_MYSQL` to `true`.
4. Update `DB_HOST`, `DB_NAME`, `DB_USER`, and `DB_PASS` if needed.

## Main Files

- `index.php`: cinematic home page.
- `destinations.php`: animated route marketing and destination filters.
- `packages.php`: AJAX-loaded fullscreen package panels.
- `booking.php`: validated booking form with AJAX submission.
- `world.php`: all-country travel atlas with bundled WebP covers.
- `admin/index.php`: package CRUD, image upload, and booking review.
- `style.css`: luxury responsive UI, arc panels, glassmorphism, animations, cursor.
- `script.js`: jQuery interactions, AJAX, reveal animation, parallax, filters.

## Image Notes

The destination heroes use real Wikimedia Commons/Wikivoyage travel photos, locally cropped to 1920x1080 WebP. The site also includes `assets/images/royaltexture.webp` and `assets/images/royaltexture-soft.webp` for the luxury royal texture treatment.

The world atlas contains 250 local country/territory covers. Top travel countries were refreshed with real high-resolution travel photos where Wikimedia/Wikivoyage returned suitable images; remaining countries keep lightweight generated covers so the atlas remains complete and offline-friendly.

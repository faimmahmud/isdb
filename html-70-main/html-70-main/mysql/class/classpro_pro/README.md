# ClassPro Pro

A polished PHP + MySQL mini system with separate visual design for each page.

## Pages
- Dashboard: `index.php`
- Users: `user.php`
- Products: `product.php`

## Setup
1. Import `schema.sql` into MySQL.
2. Update database credentials in `db.php` if needed.
3. Place the project in `htdocs`.
4. Open `index.php` in your browser.

## Notes
- The product table uses the column name `manfacturer_id` to match your current setup.
- The system includes add and delete actions for users and products.
- Styling is separated into base + page-specific CSS files.

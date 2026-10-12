# KAI Aluminum & Glass Supply - Website

Company website of KAI Aluminum & Glass Supply (Dinalupihan, Bataan).
Built with plain **PHP, CSS and JavaScript** based on our Figma design.

## How to run (XAMPP)

Needs **PHP 8.1 or newer** (any recent XAMPP is fine).

1. Copy the `kai-website` folder to `C:\xampp\htdocs\`
2. Open XAMPP and start **Apache** and **MySQL**
3. Go to `http://localhost/phpmyadmin` → Import → choose `database/kai_db.sql` → Go
4. Open `http://localhost/kai-website/`

If your MySQL has a password, change `DB_PASS` in `includes/config.php`.

Business info, hours, nav links and prices are **constants** in `includes/config.php`
(ex. `BUSINESS['phone']`, `PRICE_LIST`). We used constants instead of `$variables`
so VS Code (Intelephense) doesn't show "Undefined variable" in the other files.

## Pages

| Page | File |
|---|---|
| Home (hero slider, services, products, quote estimator, contact form) | `index.php` |
| About Us | `about.php` |
| Services (process + "What We Offer" slider) | `services.php` |
| Products (with filter tabs) | `products.php` |
| Contact Us | `contact.php` |
| Booking (3 steps) | `booking.php` |

## Things to update before the defense

- [ ] Replace `assets/images/icons/logo.svg` with the real KAI logo exported from Figma
- [ ] Put the real prices in `PRICE_LIST` in `includes/config.php` (sample rates lang yung nandun)
- [ ] Add the project video as `assets/videos/kai-video.mp4` (services page)
- [ ] Add photos for the products that are still gray boxes (`products.php`)
- [ ] Change the Facebook link in `includes/config.php`

## Form rules (contact, booking, quote)

- **Names** - letters only (ñ and accents ok), plus space . - ' (ex. "Ma. Cristina", "Dela Cruz")
- **Email** - must have @ and be **@gmail.com**, **@yahoo.com** or **@yahoo.com.ph**
- **Phone** - Philippine mobile only: **+639XXXXXXXXX** (09XXXXXXXXX is also accepted and saved as +639...)

The rules are in both `includes/config.php` (server) and `assets/js/main.js` (browser).
If you change one, change the other too.

## Database tables

- `messages` - from the "Send a Message" form
- `bookings` - from the booking page
- `quote_requests` - from the "Send to KAI" button of the estimator

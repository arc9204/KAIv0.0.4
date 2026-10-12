<?php
/*
 * config.php
 * Common settings + business info used all over the site.
 * If KAI changes their number/email/hours, just edit it here para isang lugar lang.
 *
 * NOTE: these are constants (const) not variables ($) so VS Code / Intelephense
 * can see them in every file. With $variables it shows "Undefined variable"
 * kasi hindi niya sinusundan yung include.
 */

// database (XAMPP default)
const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = '';
const DB_NAME = 'kai_db';

const SITE_NAME = 'KAI Aluminum & Glass Supply';

date_default_timezone_set('Asia/Manila');

// business info
const BUSINESS = [
    'phone'     => '0961-641-5512',
    'email'     => 'kennethdballao@gmail.com',
    'email2'    => 'kdb@kaialumglass.ph',
    'facebook'  => 'KAI Aluminum and Glass Supply',
    'fb_link'   => 'https://www.facebook.com/',
    'address'   => 'National Hi-way, Purok 1 Barangay Luacan, Dinalupihan Bataan, PH',
    // footer shows the address in 3 lines
    'address_lines' => [
        'National Hi-way, Purok 1',
        'Barangay Luacan, Dinalupihan',
        'Bataan, Philippines',
    ],
];

const BUSINESS_HOURS = [
    'Mon - Fri' => '9 AM - 6 PM',
    'Sat'       => '9 AM - 6 PM',
    'Sun'       => '9 AM - 5 PM',
];

// nav links (file => label)
const NAV_LINKS = [
    'index.php'    => 'Home',
    'about.php'    => 'About',
    'services.php' => 'Services',
    'products.php' => 'Products',
    'contact.php'  => 'Contact',
];

/*
 * Price list for the "Instant Preliminary Quote".
 * NOTE: sample rates lang muna 'to (PHP per square meter).
 * TODO: palitan ng actual rates from Engr. Kenneth before the defense.
 */
const PRICE_LIST = [
    'doors' => [
        'label' => 'Aluminum Doors',
        'types' => ['Sliding' => 6500, 'Swing' => 7200, 'Folding' => 8800],
    ],
    'windows' => [
        'label' => 'Windows',
        'types' => ['Framed' => 4800, 'Frameless' => 6200, 'Sliding' => 5200, 'Awning' => 5600, 'Fixed' => 4200],
    ],
    'shutters' => [
        'label' => 'Roll-Up Shutters',
        'types' => ['Manual' => 3800, 'Motorized' => 6900],
    ],
    'blinds' => [
        'label' => 'Interior Window Blinds',
        'types' => ['Roller' => 1600, 'Vertical' => 1400],
    ],
];

// add-ons (multiplier)
const GLASS_OPTIONS = [
    'Clear Annealed (6mm)' => 1.00,
    'Tempered (10mm)'      => 1.25,
    'Tinted'               => 1.10,
    'Frosted'              => 1.15,
];

const FINISH_OPTIONS = [
    'Analok (Bronze)'   => 1.00,
    'Powder Coat Black' => 1.08,
    'Powder Coat White' => 1.08,
    'Mill Finish'       => 0.95,
];

// small helper so we don't keep typing htmlspecialchars
function e(string|int|float|null $text): string
{
    return htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
}

/*
 * ---------- form validation rules ----------
 * NOTE: assets/js/main.js has the same rules (for the instant error messages).
 * kapag binago dito, baguhin din doon.
 */

// only these email providers are accepted
const ALLOWED_EMAIL_DOMAINS = ['gmail.com', 'yahoo.com', 'yahoo.com.ph'];

// names: letters only (with ñ and accents), plus space, dot, hyphen and apostrophe
// for names like "Ma. Cristina", "Dela Cruz", "Santos-Reyes", "O'Neil"
function isValidName(string $name, int $maxLength = 50): bool
{
    if ($name === '' || mb_strlen($name) > $maxLength) {
        return false;
    }
    // must have at least 2 letters and nothing else except space . - '
    return preg_match("/^(?=(?:.*\p{L}){2})[\p{L} .'-]+$/u", $name) === 1;
}

// email must have @ and be gmail or yahoo
function isValidEmail(string $email): bool
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    $domain = strtolower(substr(strrchr($email, '@'), 1));
    return in_array($domain, ALLOWED_EMAIL_DOMAINS, true);
}

/*
 * Philippine mobile number.
 * accepts +639XXXXXXXXX or 09XXXXXXXXX (spaces and dashes are ok)
 * returns it in +639XXXXXXXXX format, or '' if it's not valid
 */
function formatPhPhone(string $phone): string
{
    $phone = str_replace([' ', '-', '(', ')'], '', $phone);

    if (preg_match('/^\+639\d{9}$/', $phone)) {
        return $phone;
    }
    if (preg_match('/^09\d{9}$/', $phone)) {
        return '+63' . substr($phone, 1); // 09171234567 -> +639171234567
    }
    return '';
}

// gets a text value from the submitted form ($_POST), trimmed.
// returns '' if it's missing or not text (ex. someone sent an array)
function post(string $key): string
{
    $value = $_POST[$key] ?? '';
    return is_string($value) ? trim($value) : '';
}

/*
 * asset('css/style.css') -> "assets/css/style.css?v=1760283600"
 * the ?v= number is the time the file was last saved, so every time we edit
 * a css/js file the browser downloads the new one (no more Ctrl + F5 needed)
 */
function asset(string $path): string
{
    $file = __DIR__ . '/../assets/' . $path;
    $version = is_file($file) ? filemtime($file) : time();
    return 'assets/' . $path . '?v=' . $version;
}

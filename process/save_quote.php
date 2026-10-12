<?php
/*
 * save_quote.php
 * Called by home.js (fetch) when the user clicks "Send to KAI" on the estimator.
 * Returns JSON.
 */
require_once '../includes/db.php';
require_once '../includes/estimate.php';

header('Content-Type: application/json');

function sendJson(bool $success, string $message = '', array $extra = []): never
{
    echo json_encode(array_merge(['success' => $success, 'message' => $message], $extra));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendJson(false, 'Invalid request.');
}

// ----- inputs -----
// post() is in config.php - it trims the value and makes sure it's text
$category    = post('category');
$type        = post('product_type');
$width       = (float) post('width');
$height      = (float) post('height');
$qty         = (int) post('quantity');
$glass       = post('glass');
$finish      = post('finish');
$unit        = post('unit') === 'in' ? 'in' : 'cm';
$fullName    = post('full_name');
$email       = post('email');
$phone       = post('phone');

// shutters + blinds have no glass
if ($category === 'shutters' || $category === 'blinds') {
    $glass = '';
}

// sizes are saved + computed in cm, so convert if the user used inches (1 in = 2.54 cm)
if ($unit === 'in') {
    $width = round($width * 2.54, 2);
    $height = round($height * 2.54, 2);
}

// ----- validation -----
// 30 - 1000 cm (12 - 393 in)
if ($width < 30 || $width > 1000 || $height < 30 || $height > 1000 || $qty < 1 || $qty > 100) {
    sendJson(false, 'Please check the size and quantity.');
}
if (!isValidName($fullName, 100)) {
    sendJson(false, 'Name must contain letters only.');
}
if (!isValidEmail($email)) {
    sendJson(false, 'Email must be a valid @gmail.com or @yahoo.com address.');
}

// save the phone as +639XXXXXXXXX
$phone = formatPhPhone($phone);
if ($phone === '') {
    sendJson(false, 'Please enter a valid PH mobile number (+639XXXXXXXXX).');
}
if ($finish !== '' && !isset(FINISH_OPTIONS[$finish])) {
    sendJson(false, 'Invalid frame finish.');
}
if ($glass !== '' && !isset(GLASS_OPTIONS[$glass])) {
    sendJson(false, 'Invalid glass type.');
}

// compute again on the server (don't trust the price from the browser)
$estimate = calculateEstimate($category, $type, $width, $height, $qty, $glass, $finish);
if ($estimate === false) {
    sendJson(false, 'Invalid product selected.');
}

$conn = getConnection();
if ($conn === null) {
    sendJson(false, 'Our system is under maintenance. Please call us instead.');
}

// ----- file upload (optional) -----
$planFile = null;

if (isset($_FILES['plan_file']) && $_FILES['plan_file']['error'] !== UPLOAD_ERR_NO_FILE) {
    $file = $_FILES['plan_file'];

    if ($file['error'] !== UPLOAD_ERR_OK || $file['size'] > 5 * 1024 * 1024) {
        sendJson(false, 'File upload failed. Max size is 5MB.');
    }

    // check the real file type, not just the extension
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);

    $allowed = [
        'image/jpeg'      => 'jpg',
        'image/png'       => 'png',
        'application/pdf' => 'pdf',
    ];

    if (!isset($allowed[$mime])) {
        sendJson(false, 'Only JPG, PNG or PDF files are allowed.');
    }

    $uploadDir = '../uploads/plans/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // random name para walang conflict / overwrite
    $planFile = 'plan_' . date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . '.' . $allowed[$mime];

    if (!move_uploaded_file($file['tmp_name'], $uploadDir . $planFile)) {
        sendJson(false, 'Could not save the uploaded file.');
    }
}

// ----- save -----
$sql = 'INSERT INTO quote_requests
        (category, product_type, width_cm, height_cm, quantity, glass_type, finish, estimated_cost, plan_file, full_name, email, phone)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

$stmt = $conn->prepare($sql);

if (!$stmt) {
    sendJson(false, 'Something went wrong. Please try again.');
}

$total = $estimate['total'];
$stmt->bind_param(
    'ssddissdssss',
    $category, $type, $width, $height, $qty, $glass, $finish,
    $total, $planFile, $fullName, $email, $phone
);

if (!$stmt->execute()) {
    sendJson(false, 'Something went wrong. Please try again.');
}

$reference = 'QT-' . str_pad($stmt->insert_id, 5, '0', STR_PAD_LEFT);
$stmt->close();
$conn->close();

sendJson(true, 'Saved', ['reference' => $reference, 'estimate' => $estimate]);

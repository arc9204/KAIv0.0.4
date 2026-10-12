<?php
/*
 * send_message.php
 * Saves the contact form ("Send a Message") into the messages table.
 */
require_once '../includes/db.php';

// only allow the redirect to go back to our own pages
$allowedRedirects = ['index.php', 'contact.php'];
$redirect = post('redirect');
if (!in_array($redirect, $allowedRedirects)) {
    $redirect = 'contact.php';
}

// where the form is on the page (so the user sees the message after reload)
$anchor = $redirect === 'index.php' ? '#contact' : '#form';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../' . $redirect);
    exit;
}

// get + clean the inputs
$firstName   = post('first_name');
$lastName    = post('last_name');
$email       = post('email');
$inquiryType = post('inquiry_type');
$message     = post('message');

$validTypes = ['Product Inquiry', 'Quotation Request', 'Installation', 'Consultation', 'Others'];

// validation (same rules as the JS, pero dito talaga yung important)
$errors = [];

if (!isValidName($firstName)) {
    $errors[] = 'first_name';
}
if (!isValidName($lastName)) {
    $errors[] = 'last_name';
}
if (!isValidEmail($email)) {
    $errors[] = 'email';
}
if (!in_array($inquiryType, $validTypes)) {
    $errors[] = 'inquiry_type';
}
if ($message === '' || strlen($message) > 1000) {
    $errors[] = 'message';
}

$conn = empty($errors) ? getConnection() : null;

if ($conn === null) {
    header('Location: ../' . $redirect . '?msg=error' . $anchor);
    exit;
}

// prepared statement para iwas SQL injection
$sql = 'INSERT INTO messages (first_name, last_name, email, inquiry_type, message) VALUES (?, ?, ?, ?, ?)';
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param('sssss', $firstName, $lastName, $email, $inquiryType, $message);
    $saved = $stmt->execute();
    $stmt->close();
} else {
    $saved = false;
}

$conn->close();

$result = $saved ? 'sent' : 'error';
header('Location: ../' . $redirect . '?msg=' . $result . $anchor);
exit;

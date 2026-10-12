<?php
/*
 * save_booking.php
 * Saves the booking form into the bookings table, then goes back to booking.php
 */
require_once '../includes/db.php';

function backWithError(string $code): never
{
    header('Location: ../booking.php?error=' . $code);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../booking.php');
    exit;
}

// post() is in config.php - it trims the value and makes sure it's text
$service     = post('service');
$projectType = post('project_type');
$date        = post('booking_date');
$time        = post('booking_time');
$fullName    = post('full_name');
$email       = post('email');
$phone       = post('phone');
$address     = post('address');
$notes       = post('notes');

// same lists as booking.php
$validServices = ['Consultation', 'Site Measurement', 'Fabrication', 'Installation'];
$validTypes    = ['Residential', 'Commercial'];
$validTimes    = ['9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM', '5:00 PM'];

// ----- validation -----
if (!in_array($service, $validServices) || !in_array($projectType, $validTypes) || !in_array($time, $validTimes)) {
    backWithError('invalid');
}

// date must be real, from tomorrow up to 60 days
$dateObj = DateTime::createFromFormat('Y-m-d', $date);
$tomorrow = new DateTime('tomorrow');
$maxDate = (new DateTime('today'))->modify('+60 days');

if (!$dateObj || $dateObj->format('Y-m-d') !== $date || $dateObj < $tomorrow || $dateObj > $maxDate) {
    backWithError('invalid');
}

// sunday closes 5 PM
if ($dateObj->format('w') === '0' && $time === '5:00 PM') {
    backWithError('invalid');
}

if (!isValidName($fullName, 100) || !isValidEmail($email)) {
    backWithError('invalid');
}

// save the phone as +639XXXXXXXXX
$phone = formatPhPhone($phone);
if ($phone === '' || $address === '' || strlen($address) > 255) {
    backWithError('invalid');
}
if (strlen($notes) > 500) {
    $notes = substr($notes, 0, 500);
}

$conn = getConnection();
if ($conn === null) {
    backWithError('server');
}

// ----- max 3 bookings per time slot (kasi 3 teams lang daw sila) -----
$check = $conn->prepare("SELECT COUNT(*) FROM bookings WHERE booking_date = ? AND booking_time = ? AND status != 'Cancelled'");
$check->bind_param('ss', $date, $time);
$check->execute();
$slotCount = (int) $check->get_result()->fetch_row()[0];
$check->close();

if ($slotCount >= 3) {
    backWithError('full');
}

// ----- save -----
// temporary reference first, we update it after we get the id
$tempRef = 'TMP-' . bin2hex(random_bytes(6));

$stmt = $conn->prepare(
    'INSERT INTO bookings (reference_no, service, project_type, booking_date, booking_time, full_name, email, phone, address, notes)
     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
);

if (!$stmt) {
    backWithError('server');
}

$stmt->bind_param('ssssssssss', $tempRef, $service, $projectType, $date, $time, $fullName, $email, $phone, $address, $notes);

if (!$stmt->execute()) {
    backWithError('server');
}

$newId = $stmt->insert_id;
$stmt->close();

// ex. BK-261012-0007
$reference = 'BK-' . date('ymd') . '-' . str_pad($newId, 4, '0', STR_PAD_LEFT);

$update = $conn->prepare('UPDATE bookings SET reference_no = ? WHERE id = ?');
$update->bind_param('si', $reference, $newId);
$update->execute();
$update->close();

$conn->close();

header('Location: ../booking.php?ref=' . urlencode($reference));
exit;

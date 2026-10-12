<?php
$pageTitle = 'Booking';
$pageCss = 'booking.css';
$pageJs = 'booking.js';

include 'includes/header.php';

$bookingServices = [
    'Consultation'     => 'Discuss your plan and get expert advice.',
    'Site Measurement' => 'We visit your site to get the exact sizes.',
    'Fabrication'      => 'Have your doors and windows built.',
    'Installation'     => 'Schedule the installation of your order.',
];

$projectTypes = ['Residential', 'Commercial'];

// time slots (Sunday closes 5 PM so the last slot is 4 PM, see booking.js)
$timeSlots = ['9:00 AM', '10:00 AM', '11:00 AM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM', '5:00 PM'];

// after saving, save_booking.php sends us back with ?ref=BK-xxxxx
$reference = '';
if (isset($_GET['ref']) && preg_match('/^BK-\d{6}-\d{4,}$/', $_GET['ref'])) {
    $reference = $_GET['ref'];
}

$errorMessages = [
    'invalid' => 'Some of the details are missing or invalid. Please check the form again.',
    'full'    => 'Sorry, that time slot is already full. Please choose another time.',
    'server'  => 'Sorry, we could not save your booking right now. Please call us instead.',
];
$error = isset($_GET['error'], $errorMessages[$_GET['error']]) ? $errorMessages[$_GET['error']] : '';
?>

<section class="booking-page">
    <div class="booking-head">
        <h1>Book an Appointment</h1>
        <p>Schedule a consultation, site measurement, or installation with the KAI team in 3 easy steps.</p>
    </div>

    <div class="booking-card">

        <?php if ($reference): ?>
            <!-- success -->
            <div class="booking-success">
                <span class="success-icon"><?= icon('check', 44) ?></span>
                <h2>Booking Received!</h2>
                <p>Your reference number is</p>
                <p class="ref-no"><?= e($reference) ?></p>
                <p class="muted">We'll call or email you within 24 hours to confirm your schedule. Please keep your reference number.</p>
                <div class="success-buttons">
                    <a href="index.php" class="btn btn-light">Back to Home</a>
                    <a href="booking.php" class="btn btn-dark">Book Again</a>
                </div>
            </div>
        <?php else: ?>

            <!-- step indicator -->
            <div class="b-steps">
                <div class="b-step active" data-step="1"><span>1</span> Service</div>
                <div class="b-step-line"></div>
                <div class="b-step" data-step="2"><span>2</span> Schedule</div>
                <div class="b-step-line"></div>
                <div class="b-step" data-step="3"><span>3</span> Your Details</div>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-error"><?= e($error) ?></div>
            <?php endif; ?>

            <form action="process/save_booking.php" method="POST" id="bookingForm" novalidate>

                <!-- STEP 1 -->
                <div class="b-panel active" data-step="1">
                    <h2>What do you need?</h2>
                    <div class="service-options">
                        <?php foreach ($bookingServices as $name => $desc): ?>
                            <label class="option-card">
                                <input type="radio" name="service" value="<?= e($name) ?>">
                                <span class="option-body">
                                    <strong><?= e($name) ?></strong>
                                    <small><?= e($desc) ?></small>
                                </span>
                            </label>
                        <?php endforeach; ?>
                    </div>

                    <h3>Project Type</h3>
                    <div class="type-options">
                        <?php foreach ($projectTypes as $type): ?>
                            <label class="pill-option">
                                <input type="radio" name="project_type" value="<?= $type ?>">
                                <span><?= $type ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <p class="b-error" id="bError1">Please choose a service and a project type.</p>
                </div>

                <!-- STEP 2 -->
                <div class="b-panel" data-step="2">
                    <h2>Pick a date and time</h2>
                    <div class="schedule-row">
                        <div class="b-field date-field">
                            <label for="bookingDate"><?= icon('calendar', 18) ?> Date</label>
                            <input type="date" id="bookingDate" name="booking_date">
                            <small class="muted">Open daily. Sunday until 5 PM only.</small>
                        </div>
                        <div class="b-field">
                            <label><?= icon('clock', 18) ?> Time</label>
                            <div class="time-slots" id="timeSlots">
                                <?php foreach ($timeSlots as $slot): ?>
                                    <label class="slot">
                                        <input type="radio" name="booking_time" value="<?= $slot ?>">
                                        <span><?= $slot ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <p class="b-error" id="bError2">Please choose a date (starting tomorrow) and a time.</p>
                </div>

                <!-- STEP 3 -->
                <div class="b-panel" data-step="3">
                    <h2>Your details</h2>
                    <div class="details-layout">
                        <div class="details-fields">
                            <div class="b-field">
                                <input type="text" name="full_name" placeholder="Full Name" maxlength="100" data-rule="name">
                            </div>
                            <div class="b-row">
                                <div class="b-field">
                                    <input type="email" name="email" placeholder="Email (@gmail.com / @yahoo.com)" maxlength="100" data-rule="email">
                                </div>
                                <div class="b-field">
                                    <input type="tel" name="phone" placeholder="+639XXXXXXXXX" maxlength="13" inputmode="tel" data-rule="phone">
                                </div>
                            </div>
                            <div class="b-field">
                                <input type="text" name="address" placeholder="Project Address" maxlength="255">
                            </div>
                            <div class="b-field">
                                <textarea name="notes" placeholder="Notes (optional) - ex. 3 sliding windows for the 2nd floor" maxlength="500"></textarea>
                            </div>
                        </div>

                        <div class="summary">
                            <h3>Summary</h3>
                            <p><span>Service</span><strong id="sumService">-</strong></p>
                            <p><span>Project</span><strong id="sumType">-</strong></p>
                            <p><span>Date</span><strong id="sumDate">-</strong></p>
                            <p><span>Time</span><strong id="sumTime">-</strong></p>
                        </div>
                    </div>
                    <p class="b-error" id="bError3">Please complete your details.</p>
                </div>

                <div class="b-buttons">
                    <button type="button" class="b-btn b-back" id="bBack">Back</button>
                    <button type="button" class="b-btn b-next" id="bNext">Next</button>
                    <button type="submit" class="b-btn b-submit" id="bSubmit">Confirm Booking</button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

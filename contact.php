<?php
$pageTitle = 'Contact Us';
$pageCss = 'contact.css';
$formRedirect = 'contact.php';

include 'includes/header.php';
?>

<section class="contact-top">
    <h1>CONTACT US</h1>
    <p>Have questions or need more information about our products and services? We're here to assist you with your aluminum and glass inquiries.</p>
</section>

<section class="contact-main">
    <!-- left: form -->
    <div class="contact-col" id="form">
        <h2 class="col-title">GET IN TOUCH</h2>
        <?php include 'includes/contact-form.php'; ?>
    </div>

    <!-- right: info + hours -->
    <div class="contact-col">
        <h2 class="col-title">CONTACT INFORMATION</h2>
        <div class="info-card">
            <div class="contact-item">
                <span class="contact-icon"><?= icon('phone') ?></span>
                <div>
                    <h4>Phone</h4>
                    <a href="tel:<?= e(BUSINESS['phone']) ?>"><?= e(BUSINESS['phone']) ?></a>
                </div>
            </div>
            <div class="contact-item">
                <span class="contact-icon"><?= icon('mail') ?></span>
                <div>
                    <h4>Email</h4>
                    <a href="mailto:<?= e(BUSINESS['email']) ?>"><?= e(BUSINESS['email']) ?></a>
                    <a href="mailto:<?= e(BUSINESS['email2']) ?>"><?= e(BUSINESS['email2']) ?></a>
                </div>
            </div>
            <div class="contact-item">
                <span class="contact-icon"><span class="fb-letter">f</span></span>
                <div>
                    <h4>Social Media</h4>
                    <a href="<?= e(BUSINESS['fb_link']) ?>" target="_blank" rel="noopener"><?= e(BUSINESS['facebook']) ?></a>
                </div>
            </div>
            <div class="contact-item">
                <span class="contact-icon cyan"><?= icon('pin') ?></span>
                <div>
                    <h4>Address</h4>
                    <p><?= e(BUSINESS['address']) ?></p>
                </div>
            </div>
        </div>

        <h2 class="col-title hours-title">BUSINESS HOURS</h2>
        <div class="hours-card">
            <?php foreach (BUSINESS_HOURS as $day => $time): ?>
                <div class="hours-item">
                    <h4><?= e($day) ?></h4>
                    <p><?= e($time) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- map -->
<section class="contact-map">
    <iframe
        src="https://maps.google.com/maps?q=Luacan,%20Dinalupihan,%20Bataan&t=&z=15&ie=UTF8&iwloc=&output=embed"
        loading="lazy"
        title="KAI Aluminum and Glass Supply location"
        referrerpolicy="no-referrer-when-downgrade"></iframe>
</section>

<?php include 'includes/footer.php'; ?>

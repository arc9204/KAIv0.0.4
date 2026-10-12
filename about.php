<?php
$pageTitle = 'About Us';
$pageCss = 'about.css';

include 'includes/header.php';

$coreValues = [
    ['icon' => 'target',    'name' => 'Precision'],
    ['icon' => 'handshake', 'name' => 'Integrity'],
    ['icon' => 'bulb',      'name' => 'Innovation'],
    ['icon' => 'shield',    'name' => 'Durability'],
    ['icon' => 'users',     'name' => 'Customer<br>Focus'],
];
?>

<!-- ===== WHO WE ARE ===== -->
<section class="about-intro">
    <span class="pill">Who we are</span>
    <h1>BEGINS IN 2021</h1>
    <p>KAI Aluminum &amp; Glass Supply was founded by husband and wife Engr. Kenneth and Joan Ballao, beginning with a commitment to provide quality aluminum and glass solutions. Inspired by their family and their son, the name KAI represents something personal that grew into a business built on craftsmanship, reliability, and lasting relationships.</p>
</section>

<div class="about-banner reveal">
    <img src="assets/images/about-bg.png" alt="Modern house with aluminum and glass windows">
</div>

<!-- ===== MISSION / VISION ===== -->
<section class="mission-vision">
    <p class="mission reveal">
        <span class="big-o">O</span>ur mission is to deliver premium aluminum and glass solutions that elevate architectural design and construction-built on innovation, trust, and superior service.
    </p>
    <p class="vision reveal">
        <span class="big-o">O</span>ur Vision is to become a leading and respected name in aluminum and glass solutions in the Philippines, known for precision, service excellence, and customer satisfaction.
    </p>
</section>

<!-- ===== CORE VALUES ===== -->
<section class="core-values">
    <h2 class="spaced-title">CORE VALUES</h2>
    <div class="values-list">
        <?php foreach ($coreValues as $value): ?>
            <div class="value-item reveal">
                <span class="value-icon"><?= icon($value['icon'], 64) ?></span>
                <p><?= $value['name'] ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ===== FOUNDERS ===== -->
<section class="founders">
    <h2>FOUNDERS</h2>
    <div class="founders-cards reveal">
        <div class="card-back"></div>
        <div class="card-front">
            <div class="founder">
                <span class="founder-initials">KB</span>
                <h3>Engr. Kenneth Ballao</h3>
                <p>Co-Founder</p>
            </div>
            <span class="founder-line"></span>
            <div class="founder">
                <span class="founder-initials">JB</span>
                <h3>Joan Ballao</h3>
                <p>Co-Founder</p>
            </div>
        </div>
    </div>
</section>

<!-- ===== PARTNERSHIPS ===== -->
<section class="partnerships">
    <h2 class="spaced-title">OUR PARTNERSHIPS</h2>
    <div class="partner-cols">
        <div class="partner reveal">
            <h3>Quality Material Sourcing</h3>
            <p>Our aluminum profiles are sourced from high-end systems imported from China, while our glass supply comes from partnerships with reputable local manufacturers.</p>
        </div>
        <span class="partner-line"></span>
        <div class="partner reveal">
            <h3>Kawara Philippines Partnership</h3>
            <p>We partner with Kawara Philippines to offer advanced ACP cladding and roofing materials, expanding our capability to deliver comprehensive facade solutions.</p>
        </div>
    </div>
</section>

<?php include 'includes/cta.php'; ?>

<?php include 'includes/footer.php'; ?>

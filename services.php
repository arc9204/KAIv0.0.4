<?php
$pageTitle = 'Services';
$pageCss = 'services.css';
$pageJs = 'services.js';

include 'includes/header.php';

// process steps
$steps = [
    ['icon' => 'chat',  'title' => '01. Consultation',   'desc' => 'Discuss your project requirements, preferences, and specifications with our team.'],
    ['icon' => 'ruler', 'title' => '02. Design & Quote', 'desc' => 'Review the proposed design, measurements, and estimated project cost.'],
    ['icon' => 'tool',  'title' => '03. Fabrication',    'desc' => 'Your approved aluminum and glass components are prepared according to the project specifications.'],
    ['icon' => 'home',  'title' => '04. Installation',   'desc' => 'The finished components are installed with attention to fit, function, and detail.'],
];

// "What We Offer" slider - texts from the figma (Frame 159)
$offers = [
    [
        'name'  => 'Material Supply',
        'image' => 'what_we_offer-card1.png',
        'title' => 'QUALITY MATERIALS. BUILT FOR LASTING PERFORMANCE.',
        'desc'  => 'We supply aluminum profiles in various grades and series, along with glass materials suited to different project requirements.',
        'label' => 'CAPABILITIES',
        'list'  => ['Aluminum Profile Supply', 'Tempered and Annealed Glass Supply', 'Various Aluminum Grades and Series'],
    ],
    [
        'name'  => 'Fabrication',
        'image' => 'what_we_offer-card2.png',
        'title' => 'TURNING PROJECT PLANS INTO PRECISION-BUILT PRODUCTS.',
        'desc'  => 'We fabricate aluminum and glass products according to project plans, dimensions, and material specifications, ensuring precision and quality craftsmanship.',
        'label' => 'CAPABILITIES',
        'list'  => ['Aluminum Profile Cutting', 'Aluminum Frame Assembly', 'Aluminum and Glass Fabrication', 'Fabrication Based on Project Specifications'],
    ],
    [
        'name'  => 'Installation',
        'image' => 'what_we_offer-card3.png',
        'title' => 'BRINGING EVERY PROJECT TO LIFE WITH PRECISION.',
        'desc'  => 'We install aluminum and glass products according to project plans, site conditions, and installation requirements.',
        'label' => 'CAPABILITIES',
        'list'  => ['Aluminum Door and Window Installation', 'Aluminum and Glass Installation', 'On-Site Installation', 'Final Project Inspection'],
    ],
    [
        'name'  => 'Consultation Design',
        'image' => 'what_we_offer-card4.png',
        'title' => 'THE RIGHT SOLUTION STARTS WITH A PLAN.',
        'desc'  => 'We review project plans, door and window schedules, and technical specifications to determine suitable materials and estimate project costs.',
        'label' => 'CAPABILITIES',
        'list'  => ['Project Plan and Schedule Review', 'Aluminum Profile and Glass Specifications', 'Material Selection Based on Project Requirements', 'Project Cost Estimation and Quotation'],
    ],
    [
        'name'  => 'Commercial Projects',
        'image' => 'what_we_offer-card5.png',
        'title' => 'SOLUTIONS BUILT FOR COMMERCIAL DEVELOPMENTS.',
        'desc'  => 'We provide aluminum and glass solutions for commercial, institutional, and industrial projects based on their specifications and requirements.',
        'label' => 'PROJECT TYPES',
        'list'  => ['Mid- to High-Rise Buildings', 'Retail Spaces and Showrooms', 'Government and Institutional Buildings', 'Industrial and Warehousing Facilities'],
    ],
    [
        'name'  => 'Residential Projects',
        'image' => 'what_we_offer-card6.png',
        'title' => 'DESIGNED TO COMPLEMENT EVERY HOME.',
        'desc'  => 'We provide aluminum and glass solutions for residential properties, from doors and windows to customized products based on project plans and specifications.',
        'label' => 'PROJECT SOLUTIONS',
        'list'  => ['Residential Doors and Windows', 'Aluminum Kitchen Cabinets', 'Soundproof and Impact-Resistant Window Solutions', 'Custom Aluminum and Glass Applications'],
    ],
];

$whyUs = [
    ['icon' => 'award', 'title' => 'Quality Guarantee',   'desc' => 'All our work comes with comprehensive warranty coverage'],
    ['icon' => 'truck', 'title' => 'On-Time Delivery',    'desc' => 'We respect your time and complete projects as scheduled'],
    ['icon' => 'users', 'title' => 'Expert Team',         'desc' => 'Certified professionals with years of industry experience'],
    ['icon' => 'tag',   'title' => 'Competitive Pricing', 'desc' => 'Fair and transparent pricing with no hidden cost'],
];
?>

<!-- ===== HERO ===== -->
<section class="page-hero services-hero">
    <h1>OUR SERVICES</h1>
</section>

<!-- ===== WORKING WITH KAI + VIDEO + PROCESS ===== -->
<section class="working">
    <div class="working-text reveal">
        <p class="cyan-label">WORKING WITH KAI</p>
        <h2>From residential interiors to large-scale architectural projects, we create aluminum and glass installations that complement the way people live, work, and experience their spaces.</h2>
    </div>

    <div class="video-box reveal" id="videoBox">
        <!-- TODO: put the project video in assets/videos/kai-video.mp4 -->
        <video id="kaiVideo" preload="none" playsinline>
            <source src="assets/videos/kai-video.mp4" type="video/mp4">
        </video>
        <button class="play-btn" id="playBtn" aria-label="Play video"><?= icon('play', 40) ?></button>
        <p class="video-msg" id="videoMsg">Video coming soon.</p>
    </div>

    <div class="process">
        <p class="process-label">Our Process</p>
        <h2>How We Work</h2>
        <p class="process-desc">A clear and organized process for bringing your aluminum and glass project to life.</p>

        <div class="process-steps">
            <?php foreach ($steps as $step): ?>
                <div class="process-step reveal">
                    <span class="process-circle"><?= icon($step['icon'], 40) ?></span>
                    <h3><?= e($step['title']) ?></h3>
                    <p><?= e($step['desc']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ===== WHAT WE OFFER (slider) ===== -->
<section class="offer" id="offer">
    <div class="offer-head">
        <h2>What We Offer</h2>
        <p>Comprehensive services to ensure your project is completed to the highest standards</p>
    </div>

    <div class="offer-slider" id="offerSlider">
        <?php foreach ($offers as $index => $offer): ?>
            <div class="offer-slide <?= $index === 0 ? 'active' : '' ?>">
                <div class="offer-image">
                    <img src="assets/images/<?= $offer['image'] ?>" alt="<?= e($offer['name']) ?>">
                    <span class="offer-tag"><?= e($offer['name']) ?></span>
                </div>
                <div class="offer-info">
                    <h3><?= e($offer['title']) ?></h3>
                    <p><?= e($offer['desc']) ?></p>
                    <h4><?= e($offer['label']) ?></h4>
                    <ul>
                        <?php foreach ($offer['list'] as $item): ?>
                            <li><?= e($item) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="offer-controls">
            <div class="offer-progress"><span id="offerProgress"></span></div>
            <span class="offer-count" id="offerCount">1 / <?= count($offers) ?></span>
            <button class="offer-btn" id="offerPrev" aria-label="Previous"><?= icon('arrow-left', 20) ?></button>
            <button class="offer-btn" id="offerNext" aria-label="Next"><?= icon('arrow-right', 20) ?></button>
        </div>
    </div>
</section>

<!-- ===== WHY CHOOSE US ===== -->
<section class="why-us">
    <h2>Why Choose Us</h2>
    <p class="why-sub">We are committed to delivering exceptional service and quality</p>

    <div class="why-grid">
        <?php foreach ($whyUs as $item): ?>
            <div class="why-item reveal">
                <span class="why-circle"><?= icon($item['icon'], 56) ?></span>
                <h3><?= e($item['title']) ?></h3>
                <p><?= e($item['desc']) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<?php include 'includes/cta.php'; ?>

<?php include 'includes/footer.php'; ?>

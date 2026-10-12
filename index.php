<?php
$pageTitle = 'Home';
$pageCss = 'home.css';
$pageJs = 'home.js';
$formRedirect = 'index.php';

include 'includes/header.php';

// services cards (home page)
$services = [
    ['num' => '01', 'title' => 'Material Supply', 'desc' => 'Built on quality and reliability.', 'image' => ''],
    ['num' => '02', 'title' => 'Fabrication', 'desc' => 'Crafted with precision and care.', 'image' => 'fabrication-card.png'],
    ['num' => '03', 'title' => 'Installation', 'desc' => 'Perfect fit, lasting performance.', 'image' => ''],
    ['num' => '04', 'title' => 'Consultation', 'desc' => 'Creative ideas, expertly realized.', 'image' => ''],
];

// products cards
$products = [
    ['title' => 'Aluminum Doors', 'desc' => 'Sliding, swing, and folding doors', 'image' => 'aluminumdoors-card.png', 'link' => 'products.php#doors'],
    ['title' => 'Windows', 'desc' => 'Framed and Frameless, Sliding, Awning, Fixed', 'image' => 'windows-card.png', 'link' => 'products.php#windows'],
    ['title' => 'Roll-Up Shutters', 'desc' => 'Manual & Motorized', 'image' => 'roll-up_shutters_card.png', 'link' => 'products.php#shutters'],
];

// photos flying in hero slide 2 (16 tiles, their position/size/speed is in home.css .t1 - .t16)
// small copies from assets/images/thumbs/ para mabilis mag-load (the big PNGs are 2-3MB each)
$storyTiles = [
    'what_we_offer-card1.jpg', 'windows-card.jpg', 'fabrication-card.jpg', 'what_we_offer-card4.jpg',
    'aluminumdoors-card.jpg', 'what_we_offer-card5.jpg', 'roll-up_shutters_card.jpg', 'what_we_offer-card2.jpg',
    'services-bg.jpg', 'what_we_offer-card6.jpg', 'what_we_offer-card3.jpg', 'hero-bg.jpg',
    'windows-card.jpg', 'what_we_offer-card4.jpg', 'about-bg.jpg', 'aluminumdoors-card.jpg',
];

// categories for the quote (step 1). key must match PRICE_LIST in config.php
$quoteCategories = [
    'doors'    => ['label' => "Aluminum<br>Doors", 'image' => 'aluminumdoors-card.png'],
    'windows'  => ['label' => 'Windows', 'image' => 'windows-card.png'],
    'shutters' => ['label' => "Roll-Up<br>Shutters", 'image' => 'roll-up_shutters_card.png'],
    'blinds'   => ['label' => "Interior<br>Window<br>Blinds", 'image' => 'hero-bg.png'],
];
?>

<!-- ===== HERO (slider, 3 slides) ===== -->
<section class="hero" id="hero">

    <!-- slide 1 -->
    <div class="hero-slide slide-main active">
        <div class="hero-overlay"></div>
        <span class="hero-line-v"></span>
        <span class="hero-line-h"></span>
        <div class="hero-bottom">
            <h1>Designed for Excellence.<br>Built to Last.</h1>
            <div class="hero-side">
                <p>Premium aluminum and glass solutions crafted with precision, quality, and modern design to bring your vision to life.</p>
                <a href="#quote" class="btn btn-dark">Get a Quote</a>
            </div>
        </div>
    </div>

    <!-- slide 2 - "every project tells a story" (3D flying photos, animation is in home.css) -->
    <div class="hero-slide slide-story">
        <div class="hero-overlay dark"></div>

        <!-- the photos and the text are in the same 3D "stage"
             so the photos can go behind AND in front of the text -->
        <div class="story-stage">
            <?php foreach ($storyTiles as $i => $tile): ?>
                <img src="assets/images/thumbs/<?= e($tile) ?>" alt="" class="tile t<?= $i + 1 ?>" aria-hidden="true">
            <?php endforeach; ?>

            <div class="slide-center">
                <h2>Every project tells a story.</h2>
                <a href="products.php" class="btn btn-dark">Explore Our Products</a>
            </div>
        </div>
    </div>

    <!-- slide 3 - products -->
    <div class="hero-slide slide-products">
        <div class="slide-products-text">
            <h2>Explore our Product Range</h2>
            <p>From aluminum profiles and glass panels to doors, windows, and architectural systems, discover materials suited to your project's design and functional requirements.</p>
            <a href="products.php" class="btn btn-dark">View Products</a>
        </div>
        <div class="slide-products-images">
            <img src="assets/images/windows-card.png" alt="Aluminum windows">
            <img src="assets/images/aluminumdoors-card.png" alt="Aluminum door">
        </div>
    </div>

    <div class="hero-dots" id="heroDots">
        <button class="dot active" data-slide="0" aria-label="Slide 1"></button>
        <button class="dot" data-slide="1" aria-label="Slide 2"></button>
        <button class="dot" data-slide="2" aria-label="Slide 3"></button>
    </div>
</section>

<!-- ===== ABOUT US ===== -->
<section class="about-home" id="about">
    <h2 class="section-label">ABOUT US</h2>
    <div class="about-home-cols reveal">
        <p>Founded in 2021 by husband-and-wife duo Engr. Kenneth and Joan Ballao, KAI Aluminum &amp; Glass Supply is a Bataan-based provider of premium aluminum and glass solutions for both residential and commercial projects.</p>
        <span class="divider-v"></span>
        <p>Our branding is inspired by the cube — a symbol of structure, strength, and balance. The height represents our ambition for growth, the width reflects our expanding reach across the country, and the depth captures our unwavering dedication to craftsmanship.</p>
    </div>
    <a href="about.php" class="btn btn-dark">Learn more</a>
</section>

<!-- ===== WHY CHOOSE KAI (quote) ===== -->
<section class="why-kai">
    <h2 class="section-label">WHY CHOOSE KAI?</h2>
    <blockquote class="kai-quote reveal">
        <span class="quote-mark open">&ldquo;</span>
        <p>
            <span class="indent"></span>We don’t just build — <strong>we refine every detail.</strong><br>
            From sleek aluminum frames to crystal-clear glasswork, KAI transforms ideas into
            <em>structures that inspire.</em><span class="quote-mark close">&rdquo;</span>
        </p>
        <footer><span class="dash"></span> Engr. Kenneth B.</footer>
    </blockquote>
</section>

<!-- ===== SERVICES ===== -->
<section class="services-home" id="services">
    <div class="services-home-top">
        <h2>Our Highlighted Services<br>For You</h2>
        <p>KAI offers complete aluminum and glass solutions, from material supply and fabrication to professional installation and design consultation for residential and commercial projects.</p>
    </div>

    <div class="service-cards">
        <?php foreach ($services as $service): ?>
            <div class="service-card reveal <?= $service['image'] ? 'has-image' : '' ?>">
                <?php if ($service['image']): ?>
                    <img src="assets/images/<?= e($service['image']) ?>" alt="" class="service-card-bg">
                <?php endif; ?>
                <div class="service-card-body">
                    <span class="service-num"><?= $service['num'] ?></span>
                    <h3><?= e($service['title']) ?></h3>
                    <p><?= e($service['desc']) ?></p>
                    <a href="services.php#offer-<?= (int) $service['num'] ?>" class="read-more">
                        Read More
                        <span class="arrow-circle"><?= icon('arrow-up-right', 22) ?></span>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ===== PRODUCTS ===== -->
<section class="products-home" id="products">
    <h2>Our Products</h2>

    <div class="product-strip" id="productStrip">
        <?php foreach ($products as $product): ?>
            <a href="<?= $product['link'] ?>" class="product-card">
                <img src="assets/images/<?= $product['image'] ?>" alt="<?= e($product['title']) ?>">
                <div class="product-card-text">
                    <h3><?= e($product['title']) ?></h3>
                    <p><?= e($product['desc']) ?></p>
                </div>
            </a>
        <?php endforeach; ?>
    </div>

    <a href="products.php" class="btn btn-dark">See all products</a>
</section>

<!-- ===== CTA ===== -->
<section class="cost-cta">
    <h2>Do You Want to Know the Cost of Your Project?</h2>
    <p>Answer a few quick questions to get an estimated project cost, or leave a request for a personalized consultation.</p>
</section>

<!-- ===== GET A QUOTE (estimator) ===== -->
<section class="quote-section" id="quote">
    <div class="quote-inner">
        <div class="quote-title">
            <h2>Get an Instant Preliminary Quote</h2>
            <p>Calculate an estimated fabrication cost based on your architectural dimensions and material preferences.</p>
        </div>

        <div class="quote-box">
            <!-- step indicator -->
            <div class="steps" id="steps">
                <div class="step active" data-step="1"><span class="step-circle"><span class="step-no">1</span><?= icon('check', 14) ?></span><span class="step-name">Product</span></div>
                <div class="step-bar"></div>
                <div class="step" data-step="2"><span class="step-circle"><span class="step-no">2</span><?= icon('check', 14) ?></span><span class="step-name">Specifications</span></div>
                <div class="step-bar"></div>
                <div class="step" data-step="3"><span class="step-circle"><span class="step-no">3</span><?= icon('check', 14) ?></span><span class="step-name">Upload</span></div>
                <div class="step-bar"></div>
                <div class="step" data-step="4"><span class="step-circle"><span class="step-no">4</span><?= icon('check', 14) ?></span><span class="step-name">Estimate</span></div>
            </div>

            <!-- prices from config.php are passed to home.js using data attributes -->
            <form id="quoteForm" enctype="multipart/form-data" novalidate
                  data-prices="<?= e(json_encode(PRICE_LIST)) ?>"
                  data-glass="<?= e(json_encode(GLASS_OPTIONS)) ?>"
                  data-finish="<?= e(json_encode(FINISH_OPTIONS)) ?>">

                <!-- STEP 1 - category -->
                <div class="quote-step active" data-step="1">
                    <h3>Select Architectural Category</h3>
                    <p class="step-desc">Choose the fabrication system you require for your project.</p>

                    <div class="category-list">
                        <?php $i = 1; foreach ($quoteCategories as $key => $cat): ?>
                            <label class="category-item">
                                <input type="radio" name="category" value="<?= $key ?>">
                                <span class="category-circle">
                                    <img src="assets/images/<?= e($cat['image']) ?>" alt="" class="category-img">
                                    <span class="category-num"><?= sprintf('%02d', $i) ?></span>
                                    <span class="category-name"><?= $cat['label'] ?></span>
                                </span>
                            </label>
                        <?php $i++; endforeach; ?>
                    </div>
                    <p class="quote-error" id="error1">Please choose a category first.</p>
                </div>

                <!-- STEP 2 - specifications -->
                <div class="quote-step" data-step="2">
                    <h3>Enter Specifications</h3>
                    <p class="step-desc">Give us the size and the materials you prefer for <strong id="chosenCategory">your project</strong>.</p>

                    <div class="spec-grid">
                        <div class="spec-field">
                            <label for="productType">Type</label>
                            <select id="productType" name="product_type"></select>
                        </div>
                        <div class="spec-field">
                            <label for="quantity">Quantity</label>
                            <input type="number" id="quantity" name="quantity" min="1" max="100" value="1">
                        </div>
                        <!-- CM or INCH (home.js changes the labels + converts the numbers when switched) -->
                        <div class="spec-field spec-full">
                            <span class="spec-label">Unit of Measurement</span>
                            <div class="unit-toggle" id="unitToggle">
                                <label>
                                    <input type="radio" name="unit" value="cm" checked>
                                    <span>CM</span>
                                </label>
                                <label>
                                    <input type="radio" name="unit" value="in">
                                    <span>INCH</span>
                                </label>
                            </div>
                        </div>
                        <div class="spec-field">
                            <label for="width">Width (<span class="unit-label">cm</span>)</label>
                            <input type="number" id="width" name="width" min="30" max="1000" step="any" placeholder="e.g. 120">
                        </div>
                        <div class="spec-field">
                            <label for="height">Height (<span class="unit-label">cm</span>)</label>
                            <input type="number" id="height" name="height" min="30" max="1000" step="any" placeholder="e.g. 210">
                        </div>
                        <div class="spec-field" id="glassField">
                            <label for="glass">Glass Type</label>
                            <select id="glass" name="glass">
                                <?php foreach (GLASS_OPTIONS as $name => $mult): ?>
                                    <option value="<?= e($name) ?>"><?= e($name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="spec-field">
                            <label for="finish">Frame Finish</label>
                            <select id="finish" name="finish">
                                <?php foreach (FINISH_OPTIONS as $name => $mult): ?>
                                    <option value="<?= e($name) ?>"><?= e($name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <p class="quote-error" id="error2">Please enter a valid width and height (<span id="sizeLimit">30 - 1000 cm</span>).</p>
                </div>

                <!-- STEP 3 - upload -->
                <div class="quote-step" data-step="3">
                    <h3>Upload Your Plan</h3>
                    <p class="step-desc">Optional — attach a floor plan, sketch, or photo of the area (JPG, PNG or PDF, max 5MB).</p>

                    <label class="upload-box" id="uploadBox">
                        <input type="file" id="planFile" name="plan_file" accept=".jpg,.jpeg,.png,.pdf">
                        <?= icon('upload', 40) ?>
                        <span id="uploadText">Click to choose a file or drag it here</span>
                    </label>
                    <p class="quote-error" id="error3">File must be JPG, PNG or PDF and not bigger than 5MB.</p>
                </div>

                <!-- STEP 4 - estimate -->
                <div class="quote-step" data-step="4">
                    <h3>Your Estimated Cost</h3>

                    <div class="estimate-layout">
                        <div class="estimate-result">
                            <p class="estimate-label">Estimated Range</p>
                            <p class="estimate-range" id="estimateRange">₱0 - ₱0</p>
                            <table class="estimate-table">
                                <tr><td>Product</td><td id="sumProduct">-</td></tr>
                                <tr><td>Size</td><td id="sumSize">-</td></tr>
                                <tr><td>Price per Unit</td><td id="sumUnit">-</td></tr>
                                <tr class="total-row"><td>Total (approx.)</td><td id="sumTotal">-</td></tr>
                            </table>
                        </div>

                        <div class="estimate-send">
                            <p>Want an exact quotation? Leave your details and we'll contact you.</p>
                            <input type="text" name="full_name" id="qName" placeholder="Full Name" maxlength="100" data-rule="name">
                            <input type="email" name="email" id="qEmail" placeholder="Email (@gmail.com / @yahoo.com)" maxlength="100" data-rule="email">
                            <input type="tel" name="phone" id="qPhone" placeholder="+639XXXXXXXXX" maxlength="13" inputmode="tel" data-rule="phone">
                            <button type="button" class="btn-send-quote" id="sendQuote">Send to KAI</button>
                            <p class="quote-msg" id="quoteMsg"></p>
                        </div>
                    </div>
                </div>

                <hr class="quote-line">
                <div class="quote-footer">
                    <p class="quote-note">Note: The estimated cost is for guidance only and is not a final quotation.</p>
                    <div class="quote-buttons">
                        <button type="button" class="btn-step btn-back" id="btnBack">Back</button>
                        <button type="button" class="btn-step btn-next" id="btnNext">Next</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- ===== SEND A MESSAGE ===== -->
<section class="message-home" id="contact">
    <div class="message-home-inner">
        <div class="message-left">
            <p class="small-label">SEND A MESSAGE</p>
            <h2>Let’s build something amazing.</h2>

            <div class="message-contacts">
                <div class="contact-item">
                    <span class="contact-icon"><?= icon('phone') ?></span>
                    <div>
                        <h4>Phone</h4>
                        <a href="tel:<?= e(BUSINESS['phone']) ?>" class="underline"><?= e(BUSINESS['phone']) ?></a>
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
            </div>
        </div>

        <div class="message-right">
            <?php include 'includes/contact-form.php'; ?>
        </div>
    </div>
</section>

<!-- ===== VISIT OUR OFFICE ===== -->
<section class="office">
    <div class="office-map">
        <!-- google maps embed of the shop location -->
        <iframe
            src="https://maps.google.com/maps?q=Luacan,%20Dinalupihan,%20Bataan&t=&z=15&ie=UTF8&iwloc=&output=embed"
            loading="lazy"
            title="KAI office location"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

    <div class="office-info">
        <p class="small-label dark">HOURS</p>
        <h2>Visit our office</h2>

        <div class="contact-item office-address">
            <span class="contact-icon cyan"><?= icon('pin') ?></span>
            <div>
                <h4>Address</h4>
                <p><?= e(BUSINESS['address']) ?></p>
            </div>
        </div>

        <hr>

        <table class="hours-table">
            <?php foreach (BUSINESS_HOURS as $day => $time): ?>
                <tr>
                    <th><?= e($day) ?></th>
                    <td><?= e($time) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

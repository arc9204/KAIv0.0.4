<?php
$pageTitle = 'Products';
$pageCss = 'products.css';
$pageJs = 'products.js';

include 'includes/header.php';

/*
 * product list per category.
 * 'image' => '' means wala pang picture (gray box like in the figma).
 * just put the file in assets/images/ and type the name here.
 */
$categories = [
    'doors' => [
        'tab'   => 'ALUMINUM GLASS & DOORS',
        'title' => 'ALUMINUM AND GLASS DOORS',
        'items' => [
            ['name' => 'Sliding', 'image' => 'aluminumdoors-card.png'],
            ['name' => 'Swing',   'image' => 'roll-up_shutters_card.png'],
            ['name' => 'Folding', 'image' => ''],
        ],
    ],
    'windows' => [
        'tab'   => 'WINDOWS',
        'title' => 'WINDOWS',
        'items' => [
            ['name' => 'Framed and Frameless', 'image' => ''],
            ['name' => 'Sliding',              'image' => ''],
            ['name' => 'Awning',               'image' => 'windows-card.png'],
            ['name' => 'Fixed',                'image' => ''],
        ],
    ],
    'shutters' => [
        'tab'   => 'ROLL-UP SHUTTERS',
        'title' => 'ROLL-UP SHUTTERS',
        'items' => [
            ['name' => 'Manual',    'image' => ''],
            ['name' => 'Motorized', 'image' => ''],
        ],
    ],
    'blinds' => [
        'tab'   => 'INTERIOR WINDOW BLINDS',
        'title' => 'INTERIOR WINDOW BLINDS',
        'items' => [
            ['name' => 'Roller',   'image' => ''],
            ['name' => 'Vertical', 'image' => ''],
        ],
    ],
];
?>

<!-- ===== HERO ===== -->
<section class="products-hero">
    <div class="products-hero-text">
        <h1>OUR PRODUCTS</h1>
        <p>Discover our range of aluminum and glass products, from doors and windows to specialized architectural solutions for every project.</p>
    </div>
</section>

<!-- ===== FILTER TABS ===== -->
<div class="filter-bar">
    <div class="filter-tabs" id="filterTabs">
        <button class="tab active" data-filter="all">ALL</button>
        <?php foreach ($categories as $key => $cat): ?>
            <button class="tab" data-filter="<?= $key ?>">
                <?= e($cat['tab']) ?>
                <?= icon('chevron-down', 20) ?>
            </button>
        <?php endforeach; ?>
    </div>
</div>

<!-- ===== PRODUCT LIST ===== -->
<div class="product-sections">
    <?php foreach ($categories as $key => $cat): ?>
        <section class="product-category" id="<?= $key ?>" data-category="<?= $key ?>">
            <h2><?= e($cat['title']) ?></h2>

            <div class="product-grid">
                <?php foreach ($cat['items'] as $item): ?>
                    <div class="product-item reveal">
                        <div class="product-photo <?= $item['image'] ? '' : 'no-photo' ?>">
                            <?php if ($item['image']): ?>
                                <img src="assets/images/<?= e($item['image']) ?>" alt="<?= e($item['name'] . ' ' . $cat['title']) ?>" loading="lazy">
                            <?php else: ?>
                                <span>Photo coming soon</span>
                            <?php endif; ?>
                        </div>
                        <h3><?= e($item['name']) ?></h3>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endforeach; ?>
</div>

<?php include 'includes/cta.php'; ?>

<?php include 'includes/footer.php'; ?>

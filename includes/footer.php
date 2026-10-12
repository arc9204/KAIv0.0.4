<?php
/*
 * footer.php
 * Included at the bottom of every page.
 * $pageJs (optional) - page specific js file, ex: 'estimate.js'
 */
?>
<!-- ===== FOOTER ===== -->
<footer class="footer">
    <div class="footer-inner">
        <div class="footer-brand">
            <div class="footer-logo">
                <img src="assets/images/icons/logo.svg" alt="KAI logo" width="50" height="53">
                <span>Kai Aluminum &amp; Glass Supply</span>
            </div>
            <p>
                Premium aluminum and glass solutions for residential and commercial projects.
                Founded by Engr. Kenneth and Joan Ballao, delivering innovation, trust, and superior service.
            </p>

            <div class="footer-socials">
                <a href="<?= e(BUSINESS['fb_link']) ?>" target="_blank" rel="noopener" title="Facebook"><span class="fb-letter">f</span></a>
                <a href="mailto:<?= e(BUSINESS['email']) ?>" title="Email us"><?= icon('mail', 18) ?></a>
                <a href="tel:<?= e(BUSINESS['phone']) ?>" title="Call us"><?= icon('phone', 18) ?></a>
            </div>
        </div>

        <div class="footer-col">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="about.php">About Us</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="booking.php">Booking</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Contact Info</h4>
            <ul class="footer-contact">
                <li>
                    <?= icon('pin', 18) ?>
                    <span><?= implode('<br>', array_map('e', BUSINESS['address_lines'])) ?></span>
                </li>
                <li>
                    <?= icon('phone', 18) ?>
                    <a href="tel:<?= e(BUSINESS['phone']) ?>"><?= e(BUSINESS['phone']) ?></a>
                </li>
                <li>
                    <?= icon('mail', 18) ?>
                    <a href="mailto:<?= e(BUSINESS['email']) ?>"><?= e(BUSINESS['email']) ?></a>
                </li>
            </ul>
        </div>
    </div>

    <hr class="footer-line">
    <p class="copyright">&copy; <?= date('Y') ?> KAI Aluminum &amp; Glass Supply. All rights reserved.</p>
</footer>

<script src="<?= e(asset('js/main.js')) ?>"></script>
<?php if (!empty($pageJs)): ?>
    <script src="<?= e(asset('js/' . $pageJs)) ?>"></script>
<?php endif; ?>
</body>
</html>

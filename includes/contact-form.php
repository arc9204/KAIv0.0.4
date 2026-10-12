<?php
/*
 * contact-form.php
 * The dark "send a message" form. Used in the home page and the contact page.
 * set $formRedirect before including so we know where to go back after sending.
 */
if (!isset($formRedirect)) {
    $formRedirect = 'contact.php';
}

$status = isset($_GET['msg']) ? $_GET['msg'] : '';
?>
<form action="process/send_message.php" method="POST" class="dark-form js-contact-form" novalidate>

    <?php if ($status === 'sent'): ?>
        <div class="alert alert-success">Thank you! Your message has been sent. We'll get back to you soon.</div>
    <?php elseif ($status === 'error'): ?>
        <div class="alert alert-error">Sorry, something went wrong. Please check your details and try again.</div>
    <?php endif; ?>

    <input type="hidden" name="redirect" value="<?= e($formRedirect) ?>">

    <div class="form-row">
        <div class="field">
            <input type="text" name="first_name" placeholder="First Name" maxlength="50" data-rule="name" required>
            <p class="error-text"></p>
        </div>
        <div class="field">
            <input type="text" name="last_name" placeholder="LastName" maxlength="50" data-rule="name" required>
            <p class="error-text"></p>
        </div>
    </div>

    <div class="field">
        <input type="email" name="email" placeholder="Email Address (@gmail.com / @yahoo.com)" maxlength="100" data-rule="email" required>
        <p class="error-text"></p>
    </div>

    <div class="field">
        <div class="select-wrap">
            <select name="inquiry_type" required>
                <option value="">Select Inquiry Type</option>
                <option value="Product Inquiry">Product Inquiry</option>
                <option value="Quotation Request">Quotation Request</option>
                <option value="Installation">Installation</option>
                <option value="Consultation">Consultation</option>
                <option value="Others">Others</option>
            </select>
        </div>
        <p class="error-text"></p>
    </div>

    <div class="field">
        <textarea name="message" placeholder="Tell us about your project requirements..." maxlength="1000" required></textarea>
        <p class="error-text"></p>
    </div>

    <button type="submit" class="btn-send">Send Message</button>
</form>

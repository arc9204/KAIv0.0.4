/*
 * main.js
 * stuff used on every page: mobile menu, navbar on scroll,
 * scroll animations, and the contact form validation
 */

document.addEventListener('DOMContentLoaded', function () {

    // ---------- mobile menu ----------
    const navToggle = document.getElementById('navToggle');
    const navLinks = document.getElementById('navLinks');

    if (navToggle) {
        navToggle.addEventListener('click', function () {
            navLinks.classList.toggle('open');
        });
    }

    // close the menu when you click outside of it
    document.addEventListener('click', function (e) {
        if (navLinks && !e.target.closest('.navbar')) {
            navLinks.classList.remove('open');
        }
    });

    // ---------- navbar moves up a bit when scrolling ----------
    const navbar = document.getElementById('navbar');

    window.addEventListener('scroll', function () {
        if (window.scrollY > 60) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // ---------- fade in sections when they appear on screen ----------
    const revealItems = document.querySelectorAll('.reveal');

    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                    observer.unobserve(entry.target); // only animate once
                }
            });
        }, { threshold: 0.15 });

        revealItems.forEach(function (item) {
            observer.observe(item);
        });
    } else {
        // old browsers, just show everything
        revealItems.forEach(function (item) {
            item.classList.add('show');
        });
    }

    // ---------- select color (gray placeholder -> white when picked) ----------
    document.querySelectorAll('.dark-form select').forEach(function (select) {
        select.addEventListener('change', function () {
            select.classList.toggle('has-value', select.value !== '');
        });
    });

    // ---------- contact form validation (home page + contact page) ----------
    const contactForms = document.querySelectorAll('.js-contact-form');

    contactForms.forEach(function (form) {
        form.addEventListener('submit', function (e) {
            let isValid = true;

            // reset errors first
            form.querySelectorAll('.field').forEach(function (field) {
                field.classList.remove('has-error');
            });

            form.querySelectorAll('[required]').forEach(function (input) {
                const field = input.closest('.field');
                const message = checkField(input);

                if (message !== '') {
                    showError(field, message);
                    isValid = false;
                }
            });

            if (!isValid) {
                e.preventDefault();
                return;
            }

            // prevent double submit
            const btn = form.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.textContent = 'Sending...';
        });

    });
});

/* =========================================================
   INPUT RULES (name / email / phone)
   used by the contact form, booking form and quote form.
   it has its own DOMContentLoaded so it still works
   even if something else in this file has an error.
   ========================================================= */
document.addEventListener('DOMContentLoaded', setupInputRules);

// what each kind of field is allowed to contain while typing
const ALLOWED_CHARS = {
    name: /[\p{L} .'-]/u,          // letters (with ñ), space . - '
    email: /[A-Za-z0-9._%+@-]/,    // no spaces or weird symbols
    phone: /[\d+]/                 // numbers and +
};

const BLOCKED_HINT = {
    name: 'Letters only (no numbers or symbols).',
    email: 'Spaces and symbols are not allowed in an email.',
    phone: 'Numbers only, ex. +639171234567.'
};

function setupInputRules() {
    document.querySelectorAll('[data-rule]').forEach(function (input) {
        const rule = input.dataset.rule;
        const allowed = ALLOWED_CHARS[rule];

        // 1. stop bad characters BEFORE they show up in the box (typing)
        input.addEventListener('beforeinput', function (e) {
            if (!allowed || !e.data) return; // deleting, etc.

            const hasBadChar = Array.from(e.data).some(function (ch) {
                return !allowed.test(ch);
            });

            if (hasBadChar && e.inputType !== 'insertFromPaste') {
                e.preventDefault();
                flashHint(input, BLOCKED_HINT[rule]);
            }
        });

        // 2. clean up pasted / autofilled text too
        input.addEventListener('input', function () {
            if (allowed) {
                const cleaned = cleanValue(input.value, rule);
                if (cleaned !== input.value) {
                    input.value = cleaned;
                    flashHint(input, BLOCKED_HINT[rule]);
                }
            }

            // remove the red error once it's fixed
            if (isMarked(input) && checkField(input) === '') {
                markField(input, '');
            }
        });

        // 3. check the whole value when the user leaves the field
        input.addEventListener('blur', function () {
            if (input.value.trim() !== '') {
                markField(input, checkField(input));
            }
        });
    });
}

function cleanValue(value, rule) {
    const allowed = ALLOWED_CHARS[rule];
    let cleaned = Array.from(value).filter(function (ch) {
        return allowed.test(ch);
    }).join('');

    // phone: "+" is only allowed as the first character
    if (rule === 'phone') {
        cleaned = cleaned.charAt(0) + cleaned.slice(1).replace(/\+/g, '');
    }
    return cleaned;
}

// shows the red message for a short time when a key is blocked
function flashHint(input, message) {
    markField(input, message);
    clearTimeout(input._hintTimer);
    input._hintTimer = setTimeout(function () {
        // only hide it if the value itself is fine (or still empty)
        if (input.value.trim() === '' || checkField(input) === '') {
            markField(input, '');
        }
    }, 1800);
}

// show or hide the error for one input.
// contact form has a <p class="error-text"> under each input,
// booking + quote forms only get a red border
function markField(input, message) {
    const field = input.closest('.field');
    const errorText = field ? field.querySelector('.error-text') : null;

    if (errorText) {
        field.classList.toggle('has-error', message !== '');
        errorText.textContent = message;
    } else {
        input.classList.toggle('invalid', message !== '');
        input.title = message;
    }
}

function isMarked(input) {
    const field = input.closest('.field');
    if (field && field.querySelector('.error-text')) {
        return field.classList.contains('has-error');
    }
    return input.classList.contains('invalid');
}

/* =========================================================
   validation rules (same as includes/config.php)
   ========================================================= */

const ALLOWED_EMAIL_DOMAINS = ['gmail.com', 'yahoo.com', 'yahoo.com.ph'];

// returns the error message, or '' if the input is ok
function checkField(input) {
    const value = input.value.trim();
    const rule = input.dataset.rule;

    if (value === '') {
        return 'This field is required.';
    }
    if (rule === 'name' && !isValidName(value)) {
        return 'Letters only please (no numbers or symbols).';
    }
    if (rule === 'email') {
        const emailError = emailProblem(value);
        if (emailError !== '') {
            return emailError;
        }
    }
    if (rule === 'phone' && !isPhPhone(value)) {
        return 'Use a PH mobile number like +639171234567.';
    }
    return '';
}

// letters (with ñ and accents) + space . - ' and at least 2 letters
function isValidName(name) {
    const letters = name.match(/\p{L}/gu) || [];
    return /^[\p{L} .'-]+$/u.test(name) && letters.length >= 2;
}

// must have @ and the domain must be gmail or yahoo
function isEmail(email) {
    return emailProblem(email) === '';
}

// tells the user exactly what's wrong with the email ('' = ok)
function emailProblem(email) {
    const parts = email.split('@');

    if (parts.length !== 2) {
        return 'Email must have one @ (ex. juan@gmail.com).';
    }
    if (!/^[A-Za-z0-9._%+-]+$/.test(parts[0])) {
        return 'Please type your email name before the @.';
    }
    if (!ALLOWED_EMAIL_DOMAINS.includes(parts[1].toLowerCase())) {
        return 'Only @gmail.com or @yahoo.com emails are accepted.';
    }
    return '';
}

// +639XXXXXXXXX or 09XXXXXXXXX
function isPhPhone(phone) {
    const cleaned = phone.replace(/[\s-]/g, '');
    return /^\+639\d{9}$/.test(cleaned) || /^09\d{9}$/.test(cleaned);
}

function showError(field, message) {
    if (!field) return;
    field.classList.add('has-error');
    const errorText = field.querySelector('.error-text');
    if (errorText) {
        errorText.textContent = message;
    }
}

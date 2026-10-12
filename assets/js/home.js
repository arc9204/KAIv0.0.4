/*
 * home.js
 * - hero slider
 * - drag to scroll for the products cards
 * - the 4 step "Instant Preliminary Quote" estimator
 *
 * the prices come from config.php thru the data-* attributes of #quoteForm
 */

document.addEventListener('DOMContentLoaded', function () {
    initHeroSlider();
    initProductDrag();
    initEstimator();
});


/* ================= HERO SLIDER ================= */
function initHeroSlider() {
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('#heroDots .dot');
    let current = 0;
    let timer;

    if (slides.length === 0) return;

    function showSlide(index) {
        slides[current].classList.remove('active');
        dots[current].classList.remove('active');

        current = index;

        slides[current].classList.add('active');
        dots[current].classList.add('active');
    }

    function nextSlide() {
        let next = current + 1;
        if (next >= slides.length) {
            next = 0;
        }
        showSlide(next);
    }

    function startAuto() {
        clearInterval(timer);
        timer = setInterval(nextSlide, 6000);
    }

    dots.forEach(function (dot) {
        dot.addEventListener('click', function () {
            showSlide(parseInt(dot.dataset.slide));
            startAuto(); // restart the timer so it doesn't change right away
        });
    });

    startAuto();
}


/* ================= PRODUCTS DRAG ================= */
function initProductDrag() {
    const strip = document.getElementById('productStrip');
    if (!strip) return;

    let isDown = false;
    let startX = 0;
    let scrollStart = 0;
    let moved = false;

    strip.addEventListener('mousedown', function (e) {
        isDown = true;
        moved = false;
        startX = e.pageX;
        scrollStart = strip.scrollLeft;
        strip.classList.add('dragging');
    });

    window.addEventListener('mouseup', function () {
        isDown = false;
        strip.classList.remove('dragging');
    });

    strip.addEventListener('mousemove', function (e) {
        if (!isDown) return;
        e.preventDefault();
        const walk = e.pageX - startX;
        if (Math.abs(walk) > 5) moved = true;
        strip.scrollLeft = scrollStart - walk;
    });

    // if the user was dragging, don't open the link
    strip.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function (e) {
            if (moved) e.preventDefault();
        });
        link.addEventListener('dragstart', function (e) {
            e.preventDefault();
        });
    });
}


/* ================= QUOTE ESTIMATOR ================= */
function initEstimator() {
    const form = document.getElementById('quoteForm');
    if (!form) return;

    // prices from config.php (see data-prices etc. in index.php)
    const KAI_PRICES = JSON.parse(form.dataset.prices);
    const KAI_GLASS = JSON.parse(form.dataset.glass);
    const KAI_FINISH = JSON.parse(form.dataset.finish);

    // allowed sizes per unit (1 inch = 2.54 cm). same limits as save_quote.php
    const UNITS = {
        cm: { label: 'cm', min: 30, max: 1000, example: [120, 210] },
        in: { label: 'in', min: 12, max: 393, example: [48, 84] }
    };

    const stepPanels = form.querySelectorAll('.quote-step');
    const stepDots = document.querySelectorAll('#steps .step');
    const stepBars = document.querySelectorAll('#steps .step-bar');
    const btnNext = document.getElementById('btnNext');
    const btnBack = document.getElementById('btnBack');

    const typeSelect = document.getElementById('productType');
    const glassField = document.getElementById('glassField');
    const fileInput = document.getElementById('planFile');
    const uploadBox = document.getElementById('uploadBox');
    const uploadText = document.getElementById('uploadText');

    let currentStep = 1;
    const lastStep = 4;
    let currentUnit = 'cm';

    const widthInput = document.getElementById('width');
    const heightInput = document.getElementById('height');

    // ----- step 2: CM or INCH -----
    form.querySelectorAll('input[name="unit"]').forEach(function (radio) {
        radio.addEventListener('change', function () {
            setUnit(radio.value, true);
        });
    });

    // convert = true -> also convert the numbers already typed (ex. 120 cm -> 47.2 in)
    function setUnit(newUnit, convert) {
        if (convert && newUnit !== currentUnit) {
            [widthInput, heightInput].forEach(function (input) {
                const value = parseFloat(input.value);
                if (!isNaN(value)) {
                    const converted = newUnit === 'in' ? value / 2.54 : value * 2.54;
                    input.value = Math.round(converted * 10) / 10; // 1 decimal place
                }
            });
        }

        currentUnit = newUnit;
        const unit = UNITS[newUnit];

        document.querySelectorAll('.unit-label').forEach(function (label) {
            label.textContent = unit.label;
        });
        widthInput.min = heightInput.min = unit.min;
        widthInput.max = heightInput.max = unit.max;
        widthInput.placeholder = 'e.g. ' + unit.example[0];
        heightInput.placeholder = 'e.g. ' + unit.example[1];
        document.getElementById('sizeLimit').textContent = unit.min + ' - ' + unit.max + ' ' + unit.label;
    }

    // inches -> cm (the prices are computed in cm / sqm)
    function toCm(value) {
        return currentUnit === 'in' ? value * 2.54 : value;
    }

    // ----- step 1: when a category is picked, fill the "Type" dropdown -----
    form.querySelectorAll('input[name="category"]').forEach(function (radio) {
        radio.addEventListener('change', function () {
            const cat = KAI_PRICES[radio.value];

            typeSelect.innerHTML = '';
            Object.keys(cat.types).forEach(function (type) {
                const option = document.createElement('option');
                option.value = type;
                option.textContent = type;
                typeSelect.appendChild(option);
            });

            document.getElementById('chosenCategory').textContent = cat.label;

            // shutters and blinds have no glass
            if (radio.value === 'shutters' || radio.value === 'blinds') {
                glassField.classList.add('hidden');
            } else {
                glassField.classList.remove('hidden');
            }

            hideError(1);
            btnNext.classList.add('ready');
        });
    });

    // ----- step 3: file upload -----
    fileInput.addEventListener('change', function () {
        handleFile(fileInput.files[0]);
    });

    ['dragenter', 'dragover'].forEach(function (evt) {
        uploadBox.addEventListener(evt, function (e) {
            e.preventDefault();
            uploadBox.classList.add('dragover');
        });
    });

    ['dragleave', 'drop'].forEach(function (evt) {
        uploadBox.addEventListener(evt, function (e) {
            e.preventDefault();
            uploadBox.classList.remove('dragover');
        });
    });

    uploadBox.addEventListener('drop', function (e) {
        if (e.dataTransfer.files.length > 0) {
            fileInput.files = e.dataTransfer.files;
            handleFile(fileInput.files[0]);
        }
    });

    function handleFile(file) {
        hideError(3);
        if (!file) {
            uploadBox.classList.remove('has-file');
            uploadText.textContent = 'Click to choose a file or drag it here';
            return;
        }
        if (!isValidFile(file)) {
            showError(3);
            fileInput.value = '';
            uploadBox.classList.remove('has-file');
            uploadText.textContent = 'Click to choose a file or drag it here';
            return;
        }
        uploadBox.classList.add('has-file');
        uploadText.textContent = file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
    }

    function isValidFile(file) {
        const allowed = ['image/jpeg', 'image/png', 'application/pdf'];
        return allowed.includes(file.type) && file.size <= 5 * 1024 * 1024;
    }

    // ----- next / back buttons -----
    btnNext.addEventListener('click', function () {
        if (!validateStep(currentStep)) return;

        if (currentStep === lastStep) {
            // last step: "Start Over"
            resetEstimator();
            return;
        }

        if (currentStep === 3) {
            showEstimate();
        }

        goToStep(currentStep + 1);
    });

    btnBack.addEventListener('click', function () {
        if (currentStep > 1) {
            goToStep(currentStep - 1);
        }
    });

    function goToStep(step) {
        stepPanels[currentStep - 1].classList.remove('active');
        currentStep = step;
        stepPanels[currentStep - 1].classList.add('active');

        // update the step indicator
        stepDots.forEach(function (dot, i) {
            dot.classList.remove('active', 'done');
            if (i + 1 < currentStep) dot.classList.add('done');
            if (i + 1 === currentStep) dot.classList.add('active');
        });
        stepBars.forEach(function (bar, i) {
            bar.classList.toggle('done', i + 1 < currentStep);
        });

        btnBack.style.visibility = currentStep > 1 ? 'visible' : 'hidden';

        if (currentStep === lastStep) {
            btnNext.textContent = 'Start Over';
        } else if (currentStep === 3) {
            btnNext.textContent = 'See Estimate';
        } else {
            btnNext.textContent = 'Next';
        }

        // scroll back up to the box on small screens
        if (window.innerWidth < 1024) {
            document.getElementById('steps').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    function validateStep(step) {
        if (step === 1) {
            if (!form.querySelector('input[name="category"]:checked')) {
                showError(1);
                return false;
            }
        }

        if (step === 2) {
            const w = parseFloat(document.getElementById('width').value);
            const h = parseFloat(document.getElementById('height').value);
            const qtyInput = document.getElementById('quantity');
            let qty = parseInt(qtyInput.value);

            if (isNaN(qty) || qty < 1) {
                qty = 1;
                qtyInput.value = 1;
            }

            const limit = UNITS[currentUnit];
            if (isNaN(w) || isNaN(h) || w < limit.min || h < limit.min || w > limit.max || h > limit.max) {
                showError(2);
                return false;
            }
            hideError(2);
        }

        return true;
    }

    // same formula as includes/estimate.php
    function computeEstimate() {
        const category = form.querySelector('input[name="category"]:checked').value;
        const type = typeSelect.value;
        const w = parseFloat(widthInput.value);
        const h = parseFloat(heightInput.value);
        const qty = parseInt(document.getElementById('quantity').value);
        const finish = document.getElementById('finish').value;
        const noGlass = category === 'shutters' || category === 'blinds';
        const glass = noGlass ? '' : document.getElementById('glass').value;

        const rate = KAI_PRICES[category].types[type];
        let area = (toCm(w) * toCm(h)) / 10000; // sqm
        if (area < 0.5) area = 0.5;

        const glassMult = glass ? KAI_GLASS[glass] : 1;
        const finishMult = KAI_FINISH[finish];

        const unitPrice = rate * area * glassMult * finishMult;
        const total = unitPrice * qty;

        return {
            label: KAI_PRICES[category].label + ' - ' + type,
            size: w + ' x ' + h + ' ' + UNITS[currentUnit].label + ' (' + area.toFixed(2) + ' sqm) x ' + qty,
            unitPrice: unitPrice,
            total: total,
            low: Math.round((total * 0.9) / 100) * 100,
            high: Math.round((total * 1.1) / 100) * 100
        };
    }

    function showEstimate() {
        const est = computeEstimate();

        document.getElementById('estimateRange').textContent = peso(est.low) + ' - ' + peso(est.high);
        document.getElementById('sumProduct').textContent = est.label;
        document.getElementById('sumSize').textContent = est.size;
        document.getElementById('sumUnit').textContent = peso(est.unitPrice);
        document.getElementById('sumTotal').textContent = peso(est.total);
    }

    function resetEstimator() {
        form.reset();
        setUnit('cm', false); // form.reset() puts the radio back to CM
        typeSelect.innerHTML = '';
        handleFile(null);
        btnNext.classList.remove('ready');
        const msg = document.getElementById('quoteMsg');
        msg.textContent = '';
        msg.className = 'quote-msg';
        goToStep(1);
    }

    function showError(step) {
        document.getElementById('error' + step).classList.add('show');
    }

    function hideError(step) {
        document.getElementById('error' + step).classList.remove('show');
    }

    // ----- send the quote to KAI (saved in the database) -----
    const sendBtn = document.getElementById('sendQuote');
    const quoteMsg = document.getElementById('quoteMsg');

    sendBtn.addEventListener('click', function () {
        quoteMsg.className = 'quote-msg';

        // checkField() is in main.js (name = letters only, gmail/yahoo email, +639 number)
        const checks = [
            ['Name', document.getElementById('qName')],
            ['Email', document.getElementById('qEmail')],
            ['Phone', document.getElementById('qPhone')]
        ];

        for (let i = 0; i < checks.length; i++) {
            const error = checkField(checks[i][1]);
            if (error !== '') {
                quoteMsg.textContent = checks[i][0] + ': ' + error;
                quoteMsg.classList.add('fail');
                checks[i][1].focus();
                return;
            }
        }

        sendBtn.disabled = true;
        sendBtn.textContent = 'Sending...';

        const data = new FormData(form);

        fetch('process/save_quote.php', {
            method: 'POST',
            body: data
        })
            .then(function (res) {
                return res.json();
            })
            .then(function (result) {
                if (result.success) {
                    quoteMsg.textContent = 'Sent! Your reference no. is ' + result.reference + '. We will contact you soon.';
                    quoteMsg.classList.add('ok');
                } else {
                    quoteMsg.textContent = result.message || 'Something went wrong. Please try again.';
                    quoteMsg.classList.add('fail');
                }
            })
            .catch(function () {
                quoteMsg.textContent = 'Could not connect to the server. Please try again later.';
                quoteMsg.classList.add('fail');
            })
            .finally(function () {
                sendBtn.disabled = false;
                sendBtn.textContent = 'Send to KAI';
            });
    });
}

// format number as peso, ex. 12500 -> ₱12,500.00
function peso(amount) {
    return '₱' + Number(amount).toLocaleString('en-PH', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

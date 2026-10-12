/*
 * booking.js
 * 3 step booking form (service -> schedule -> details)
 */

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('bookingForm');
    if (!form) return; // success page, walang form

    const panels = form.querySelectorAll('.b-panel');
    const stepLabels = document.querySelectorAll('.b-step');
    const stepLines = document.querySelectorAll('.b-step-line');
    const btnNext = document.getElementById('bNext');
    const btnBack = document.getElementById('bBack');
    const btnSubmit = document.getElementById('bSubmit');
    const dateInput = document.getElementById('bookingDate');

    let step = 1;

    // ----- date: tomorrow up to 60 days ahead -----
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    const maxDate = new Date();
    maxDate.setDate(maxDate.getDate() + 60);

    dateInput.min = toInputDate(tomorrow);
    dateInput.max = toInputDate(maxDate);

    // Sunday closes at 5 PM, so the 5:00 PM slot is not available
    dateInput.addEventListener('change', function () {
        const picked = new Date(dateInput.value + 'T00:00:00');
        const isSunday = picked.getDay() === 0;

        form.querySelectorAll('input[name="booking_time"]').forEach(function (slot) {
            if (slot.value === '5:00 PM') {
                slot.disabled = isSunday;
                if (isSunday) slot.checked = false;
            }
        });
    });

    // ----- buttons -----
    btnNext.addEventListener('click', function () {
        if (!checkStep(step)) return;
        goTo(step + 1);
    });

    btnBack.addEventListener('click', function () {
        goTo(step - 1);
    });

    form.addEventListener('submit', function (e) {
        if (!checkStep(3)) {
            e.preventDefault();
            return;
        }
        btnSubmit.disabled = true;
        btnSubmit.textContent = 'Saving...';
    });

    function goTo(newStep) {
        panels[step - 1].classList.remove('active');
        step = newStep;
        panels[step - 1].classList.add('active');

        stepLabels.forEach(function (label, i) {
            label.classList.toggle('active', i + 1 === step);
            label.classList.toggle('done', i + 1 < step);
        });
        stepLines.forEach(function (line, i) {
            line.classList.toggle('done', i + 1 < step);
        });

        btnBack.style.visibility = step > 1 ? 'visible' : 'hidden';
        btnNext.style.display = step < 3 ? 'inline-block' : 'none';
        btnSubmit.style.display = step === 3 ? 'inline-block' : 'none';

        if (step === 3) {
            updateSummary();
        }
    }

    function checkStep(n) {
        let ok = true;

        if (n === 1) {
            ok = getValue('service') !== '' && getValue('project_type') !== '';
        }

        if (n === 2) {
            const date = dateInput.value;
            ok = date !== '' && date >= dateInput.min && date <= dateInput.max && getValue('booking_time') !== '';
        }

        if (n === 3) {
            // checkField() is in main.js (name = letters only, gmail/yahoo email, +639 number)
            const fields = [form.full_name, form.email, form.phone, form.address];
            const labels = { full_name: 'Name', email: 'Email', phone: 'Phone', address: 'Address' };
            let message = '';

            fields.forEach(function (input) {
                const error = checkField(input);
                input.classList.toggle('invalid', error !== '');
                if (error !== '' && message === '') {
                    message = labels[input.name] + ': ' + error;
                }
            });

            ok = message === '';
            if (!ok) {
                document.getElementById('bError3').textContent = message;
            }
        }

        document.getElementById('bError' + n).classList.toggle('show', !ok);
        return ok;
    }

    function updateSummary() {
        document.getElementById('sumService').textContent = getValue('service');
        document.getElementById('sumType').textContent = getValue('project_type');
        document.getElementById('sumTime').textContent = getValue('booking_time');

        const date = new Date(dateInput.value + 'T00:00:00');
        document.getElementById('sumDate').textContent = date.toLocaleDateString('en-PH', {
            weekday: 'short', month: 'short', day: 'numeric', year: 'numeric'
        });
    }

    // value of the checked radio button
    function getValue(name) {
        const checked = form.querySelector('input[name="' + name + '"]:checked');
        return checked ? checked.value : '';
    }
});

// Date -> "YYYY-MM-DD" (local time, not UTC)
function toInputDate(date) {
    const m = String(date.getMonth() + 1).padStart(2, '0');
    const d = String(date.getDate()).padStart(2, '0');
    return date.getFullYear() + '-' + m + '-' + d;
}

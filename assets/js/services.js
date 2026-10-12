/*
 * services.js
 * - "What We Offer" slider (prev / next buttons + progress bar)
 * - video play button
 */

document.addEventListener('DOMContentLoaded', function () {

    // ---------- What We Offer slider ----------
    const slides = document.querySelectorAll('.offer-slide');
    const prevBtn = document.getElementById('offerPrev');
    const nextBtn = document.getElementById('offerNext');
    const progress = document.getElementById('offerProgress');
    const count = document.getElementById('offerCount');
    let current = 0;

    function showOffer(index) {
        // loop around
        if (index < 0) index = slides.length - 1;
        if (index >= slides.length) index = 0;

        slides[current].classList.remove('active');
        current = index;
        slides[current].classList.add('active');

        progress.style.width = ((current + 1) / slides.length * 100) + '%';
        count.textContent = (current + 1) + ' / ' + slides.length;
    }

    if (slides.length > 0) {
        prevBtn.addEventListener('click', function () {
            showOffer(current - 1);
        });

        nextBtn.addEventListener('click', function () {
            showOffer(current + 1);
        });

        // arrow keys also work when the slider is on screen
        document.addEventListener('keydown', function (e) {
            const rect = document.getElementById('offerSlider').getBoundingClientRect();
            const isVisible = rect.top < window.innerHeight && rect.bottom > 0;
            if (!isVisible) return;

            if (e.key === 'ArrowLeft') showOffer(current - 1);
            if (e.key === 'ArrowRight') showOffer(current + 1);
        });

        // if the url has #offer-2 etc, open that slide (from the home page "Read More")
        const match = window.location.hash.match(/offer-(\d+)/);
        if (match) {
            showOffer(parseInt(match[1]) - 1);
            document.getElementById('offer').scrollIntoView();
        } else {
            showOffer(0);
        }
    }

    // ---------- video ----------
    const videoBox = document.getElementById('videoBox');
    const video = document.getElementById('kaiVideo');
    const playBtn = document.getElementById('playBtn');
    const videoMsg = document.getElementById('videoMsg');

    playBtn.addEventListener('click', function () {
        video.controls = true;
        video.play()
            .then(function () {
                videoBox.classList.add('playing');
            })
            .catch(function () {
                // wala pang video file
                videoMsg.classList.add('show');
                setTimeout(function () {
                    videoMsg.classList.remove('show');
                }, 2500);
            });
    });
});

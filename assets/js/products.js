/*
 * products.js
 * filter tabs (ALL / doors / windows / shutters / blinds)
 */

document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('#filterTabs .tab');
    const sections = document.querySelectorAll('.product-category');

    function filterProducts(filter) {
        tabs.forEach(function (tab) {
            tab.classList.toggle('active', tab.dataset.filter === filter);
        });

        sections.forEach(function (section) {
            if (filter === 'all' || section.dataset.category === filter) {
                section.classList.remove('hidden');
            } else {
                section.classList.add('hidden');
            }
        });
    }

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            filterProducts(tab.dataset.filter);

            // scroll so the products are visible after clicking
            const target = tab.dataset.filter === 'all' ? sections[0] : document.getElementById(tab.dataset.filter);
            target.scrollIntoView({ behavior: 'smooth' });
        });
    });

    // links like products.php#windows (from the home page) open that category
    const hash = window.location.hash.replace('#', '');
    if (document.getElementById(hash) && document.getElementById(hash).classList.contains('product-category')) {
        filterProducts(hash);
    }
});

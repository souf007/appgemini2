
document.addEventListener('DOMContentLoaded', function() {
    // Function to load proforma invoices
    function loadFacturesProforma(page) {
        const keyword = document.getElementById('keyword').value;
        const datestart = document.getElementById('datestart').value;
        const dateend = document.getElementById('dateend').value;
        const company = document.getElementById('company').dataset.ids;
        const client = document.getElementById('client').dataset.ids;
        const product = document.getElementById('product').dataset.ids;
        const user = document.getElementById('user').dataset.ids;
        const pricemin = document.getElementById('pricemin').value;
        const pricemax = document.getElementById('pricemax').value;
        const nbrows = document.querySelector('select[name="nbrows"]').value;

        const params = new URLSearchParams({
            page,
            keyword,
            datestart,
            dateend,
            company,
            client,
            product,
            user,
            pricemin,
            pricemax,
            nbrows
        });

        fetch(`ajax.php?action=loadfacturesproforma&${params.toString()}`)
            .then(response => response.text())
            .then(data => {
                document.querySelector('.lx-table-facturesproforma').innerHTML = data;
            });
    }

    // Function to load price range
    function loadPriceRange() {
        fetch('ajax.php?action=loadpricerange&type=factureproforma')
            .then(response => response.json())
            .then(data => {
                const priceRangeSlider = document.querySelector('.js-range-slider');
                // Initialize ionRangeSlider here
            });
    }

    // Initialize date range picker
    const dateadd = document.getElementById('dateadd');
    if (dateadd) {
        new DateRangePicker(dateadd, {
            // options
        });
    }

    // Event listeners
    document.getElementById('keyword').addEventListener('keyup', () => loadFacturesProforma(1));
    document.querySelector('.lx-price-filter').addEventListener('click', () => loadFacturesProforma(1));
    document.querySelector('select[name="nbrows"]').addEventListener('change', () => loadFacturesProforma(1));

    // Load initial data
    loadFacturesProforma(1);
    loadPriceRange();
});

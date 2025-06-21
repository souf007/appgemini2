
document.addEventListener('DOMContentLoaded', function() {
    // Function to load companies
    function loadCompanies(page) {
        const keyword = document.getElementById('keyword').value;
        const nbrows = document.querySelector('select[name="nbrows"]').value;

        const params = new URLSearchParams({
            page,
            keyword,
            nbrows
        });

        fetch(`ajax.php?action=loadcompanies&${params.toString()}`)
            .then(response => response.text())
            .then(data => {
                document.querySelector('.lx-table-companies').innerHTML = data;
            });
    }

    // Event listeners
    document.getElementById('keyword').addEventListener('keyup', () => loadCompanies(1));
    document.querySelector('select[name="nbrows"]').addEventListener('change', () => loadCompanies(1));

    // Load initial data
    loadCompanies(1);
});

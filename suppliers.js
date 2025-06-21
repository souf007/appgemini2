
document.addEventListener('DOMContentLoaded', function() {
    // Function to load suppliers
    function loadSuppliers(page) {
        const keyword = document.getElementById('keyword').value;
        const nbrows = document.querySelector('select[name="nbrows"]').value;

        const params = new URLSearchParams({
            page,
            keyword,
            nbrows
        });

        fetch(`ajax.php?action=loadsuppliers&${params.toString()}`)
            .then(response => response.text())
            .then(data => {
                document.querySelector('.lx-table-suppliers').innerHTML = data;
            });
    }

    // Event listeners
    document.getElementById('keyword').addEventListener('keyup', () => loadSuppliers(1));
    document.querySelector('select[name="nbrows"]').addEventListener('change', () => loadSuppliers(1));

    // Load initial data
    loadSuppliers(1);
});


document.addEventListener('DOMContentLoaded', function() {
    // Function to load clients
    function loadClients(page) {
        const keyword = document.getElementById('keyword').value;
        const nbrows = document.querySelector('select[name="nbrows"]').value;

        const params = new URLSearchParams({
            page,
            keyword,
            nbrows
        });

        fetch(`ajax.php?action=loadclients&${params.toString()}`)
            .then(response => response.text())
            .then(data => {
                document.querySelector('.lx-table-clients').innerHTML = data;
            });
    }

    // Event listeners
    document.getElementById('keyword').addEventListener('keyup', () => loadClients(1));
    document.querySelector('select[name="nbrows"]').addEventListener('change', () => loadClients(1));

    // Load initial data
    loadClients(1);
});

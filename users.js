
document.addEventListener('DOMContentLoaded', function() {
    // Function to load users
    function loadUsers(page) {
        const keyword = document.getElementById('keyword').value;
        const nbrows = document.querySelector('select[name="nbrows"]').value;

        const params = new URLSearchParams({
            page,
            keyword,
            nbrows
        });

        fetch(`ajax.php?action=loadusers&${params.toString()}`)
            .then(response => response.text())
            .then(data => {
                document.querySelector('.lx-table-users').innerHTML = data;
            });
    }

    // Event listeners
    document.getElementById('keyword').addEventListener('keyup', () => loadUsers(1));
    document.querySelector('select[name="nbrows"]').addEventListener('change', () => loadUsers(1));

    // Load initial data
    loadUsers(1);
});

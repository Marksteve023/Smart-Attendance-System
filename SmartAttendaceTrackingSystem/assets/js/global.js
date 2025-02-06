

    /*=============== LOGIN ===============*/
    document.getElementById('logIn').addEventListener('submit', function (e) {
        const role = document.getElementById('role');
        const roleError = document.getElementById('roleError');

        // Check if the role is selected
        if (!role.value) {
            e.preventDefault(); // Prevent form submission
            roleError.style.display = 'block'; // Show error message
        } else {
            roleError.style.display = 'none'; // Hide error message
        }
    });

/*=============== SHOW SIDEBAR ===============*/
const showSidebar = (toggleId, sidebarId, headerId, mainId) => {
    const toggle = document.getElementById(toggleId),
          sidebar = document.getElementById(sidebarId),
          header = document.getElementById(headerId),
          main = document.getElementById(mainId);

    if(toggle && sidebar && header && main) {
        toggle.addEventListener('click', () => {
            /* Show sidebar */
            sidebar.classList.toggle('show-sidebar');
            /* Add padding header */
            header.classList.toggle('left-pd');
            /* Add padding main */
            main.classList.toggle('left-pd');
        });
    }
};
showSidebar('header-toggle', 'sidebar', 'header', 'main');

/*=============== LINK ACTIVE ===============*/
const sidebarLink = document.querySelectorAll('.sidebar__list a');

function linkColor() {
    sidebarLink.forEach(l => l.classList.remove('active-link'));
    this.classList.add('active-link');
}

sidebarLink.forEach(l => l.addEventListener('click', linkColor));

/*=============== DARK LIGHT THEME ===============*/ 
const themeButton = document.getElementById('theme-button');
const darkTheme = 'dark-theme';
const iconTheme = 'ri-sun-fill';

// Previously selected topic (if user selected)
const selectedTheme = localStorage.getItem('selected-theme');
const selectedIcon = localStorage.getItem('selected-icon');

// We obtain the current theme that the interface has by validating the dark-theme class
const getCurrentTheme = () => document.body.classList.contains(darkTheme) ? 'dark' : 'light';
const getCurrentIcon = () => themeButton.classList.contains(iconTheme) ? 'ri-moon-clear-fill' : 'ri-sun-fill';

// We validate if the user previously chose a topic
if (selectedTheme) {
    document.body.classList[selectedTheme === 'dark' ? 'add' : 'remove'](darkTheme);
    themeButton.classList[selectedIcon === 'ri-moon-clear-fill' ? 'add' : 'remove'](iconTheme);
}

// Activate / deactivate the theme manually with the button
themeButton.addEventListener('click', () => {
    document.body.classList.toggle(darkTheme);
    themeButton.classList.toggle(iconTheme);
    // We save the theme and the current icon that the user chose
    localStorage.setItem('selected-theme', getCurrentTheme());
    localStorage.setItem('selected-icon', getCurrentIcon());
});

/*=============== COURSE FUNCTION ===============*/




/*=============== MANAGE TEACHER FUNCTION ===============*/




    // Search functionality for filtering teachers
    document.getElementById("search").addEventListener("input", function() {
        const query = this.value.toLowerCase();
        const rows = document.querySelectorAll(".assigned-teacher-table tbody tr");

        rows.forEach(row => {
            const teacherName = row.cells[2].innerText.toLowerCase();
            const teacherId = row.cells[1].innerText.toLowerCase();
            const course = row.cells[3].innerText.toLowerCase();
            const section = row.cells[4].innerText.toLowerCase();

            if (teacherName.includes(query) || teacherId.includes(query) || course.includes(query) || section.includes(query)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
});




/*=============== MANAGE STUDENT FUNCTION ===============*/






















/*=============== ACCOUNT Function ===============*/

document.getElementById('create-account-form').addEventListener('submit', function(event) {
    event.preventDefault();  // Prevent form submission to handle via AJAX

    var formData = new FormData(this);

    fetch('../admin/scripts/create-account.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show the success message
            var successMessage = document.getElementById('success-message');
            successMessage.style.display = 'block';  // Make the success message visible
            successMessage.textContent = data.message;  // Set the message content
            
            // Hide the success message after 3 seconds
            setTimeout(function() {
                successMessage.style.display = 'none';  // Hide after 3 seconds
            }, 3000); // 3000 milliseconds = 3 seconds
            
            // Optionally reset the form after success
            document.getElementById('create-account-form').reset();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});



document.getElementById('create-account-form').addEventListener('submit', function(event) {
    var password = document.getElementById('password').value;
    var passwordError = document.getElementById('password-error');  // Assuming you want to show the error message

    if (password.length < 8) {
        event.preventDefault(); // Prevent form submission
        passwordError.style.display = 'block';  // Show error message
        passwordError.textContent = 'Password must be at least 8 characters long.';
    } else {
        passwordError.style.display = 'none';  // Hide error message
    }
});

//Delete Account
function deleteAccount(id) {
    console.log("Delete function triggered for ID: " + id);  // Log the ID being passed

    if (confirm("Are you sure you want to delete this account?")) {
        fetch("scripts/delete-account.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `id=${id}` // Pass the ID to be deleted
        })
        .then(response => response.json())
        .then(data => {
            console.log("Response from delete request:", data); // Log the response

            if (data.success) {
                alert("Account deleted successfully!");
                location.reload(); // Reload the page to reflect changes
            } else {
                alert("Failed to delete account. Error: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error deleting account:", error);
        });
    }
}

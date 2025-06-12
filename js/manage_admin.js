// Store all admins data globally for search functionality
let allAdmins = [];

// Load admin data when page loads
document.addEventListener('DOMContentLoaded', () => {
    loadAdmins();

    // Add search input event listener
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', handleSearch);
});

async function loadAdmins() {
    const loadingDiv = document.getElementById('loading');
    const tableBody = document.getElementById('adminTableBody');

    try {
        loadingDiv.style.display = 'block';
        tableBody.innerHTML = ''; // Clear existing content

        const response = await fetch('../../php/get_admins.php');
        const data = await response.json();

        if (data.status === 'success') {
            allAdmins = data.data; // Store all admins for search
            displayAdmins(allAdmins); // Display all admins initially
        } else {
            showError('Failed to load admins', data.message);
        }
    } catch (error) {
        console.error('Error:', error);
        showError('Error', 'Failed to load admins');
    } finally {
        loadingDiv.style.display = 'none';
    }
}

function handleSearch(event) {
    const searchTerm = event.target.value.toLowerCase().trim();
    const noResultsDiv = document.getElementById('noResults');

    if (searchTerm === '') {
        displayAdmins(allAdmins);
        noResultsDiv.style.display = 'none';
        return;
    }

    const filteredAdmins = allAdmins.filter(admin => {
        return admin.admin_id.toLowerCase().includes(searchTerm) ||
            admin.fname.toLowerCase().includes(searchTerm) ||
            admin.lname.toLowerCase().includes(searchTerm) ||
            admin.email.toLowerCase().includes(searchTerm);
    });

    displayAdmins(filteredAdmins);
    noResultsDiv.style.display = filteredAdmins.length === 0 ? 'block' : 'none';
}

function displayAdmins(admins) {
    const tableBody = document.getElementById('adminTableBody');
    tableBody.innerHTML = ''; // Clear existing content

    admins.forEach(admin => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${admin.admin_id}</td>
            <td>${admin.fname}</td>
            <td>${admin.lname}</td>
            <td>${admin.email}</td>
            <td>${formatDate(admin.created_at)}</td>
            <td class="action-buttons">
                <button class="btn-edit" onclick="editAdmin('${admin.admin_id}')">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn-delete" onclick="deleteAdmin('${admin.admin_id}')">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

function formatDate(dateString) {
    const options = {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    return new Date(dateString).toLocaleDateString('en-US', options);
}

function showError(title, text) {
    Swal.fire({
        icon: 'error',
        title: title,
        text: text,
        confirmButtonColor: '#1976a5'
    });
}

function showSuccess(title, text) {
    Swal.fire({
        icon: 'success',
        title: title,
        text: text,
        confirmButtonColor: '#1976a5'
    });
}

function openAddAdminModal() {
    Swal.fire({
        title: 'Add New Admin',
        html: `
            <div class="swal2-input-group">
                <input type="text" id="fname" class="swal2-input" placeholder="First Name">
                <input type="text" id="lname" class="swal2-input" placeholder="Last Name">
                <input type="email" id="email" class="swal2-input" placeholder="Email">
                <input type="password" id="password" class="swal2-input" placeholder="Password">
            </div>
        `,
        confirmButtonText: 'Add Admin',
        confirmButtonColor: '#1976a5',
        showCancelButton: true,
        focusConfirm: false,
        preConfirm: () => {
            const fname = document.getElementById('fname').value.trim();
            const lname = document.getElementById('lname').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;

            if (!fname || !lname || !email || !password) {
                Swal.showValidationMessage('Please fill in all fields');
                return false;
            }

            if (!isValidEmail(email)) {
                Swal.showValidationMessage('Please enter a valid email address');
                return false;
            }

            return { fname, lname, email, password };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            addAdmin(result.value);
        }
    });
}

function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

async function addAdmin(adminData) {
    try {
        const response = await fetch('../../php/add_admin.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(adminData)
        });

        const data = await response.json();

        if (data.status === 'success') {
            // Log the activity
            await logActivity('CREATE', `Added new admin: ${adminData.fname} ${adminData.lname}`);
            showSuccess('Success', 'Admin added successfully');
            loadAdmins();
        } else {
            showError('Error', data.message || 'Failed to add admin');
        }
    } catch (error) {
        console.error('Error:', error);
        showError('Error', 'Failed to add admin');
    }
}

async function editAdmin(adminId) {
    try {
        const response = await fetch(`../../php/get_admin.php?id=${adminId}`);
        const data = await response.json();

        if (data.status === 'success') {
            const admin = data.data;
            Swal.fire({
                title: 'Edit Admin',
                html: `
                    <div class="swal2-input-group">
                        <input type="text" id="edit-fname" class="swal2-input" value="${admin.fname}" placeholder="First Name">
                        <input type="text" id="edit-lname" class="swal2-input" value="${admin.lname}" placeholder="Last Name">
                        <input type="email" id="edit-email" class="swal2-input" value="${admin.email}" placeholder="Email">
                        <input type="password" id="edit-password" class="swal2-input" placeholder="New Password (leave blank to keep current)">
                    </div>
                `,
                confirmButtonText: 'Update',
                confirmButtonColor: '#1976a5',
                showCancelButton: true,
                focusConfirm: false,
                preConfirm: () => {
                    const fname = document.getElementById('edit-fname').value.trim();
                    const lname = document.getElementById('edit-lname').value.trim();
                    const email = document.getElementById('edit-email').value.trim();
                    const password = document.getElementById('edit-password').value;

                    if (!fname || !lname || !email) {
                        Swal.showValidationMessage('Please fill in all required fields');
                        return false;
                    }

                    if (!isValidEmail(email)) {
                        Swal.showValidationMessage('Please enter a valid email address');
                        return false;
                    }

                    return { adminId, fname, lname, email, password };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    updateAdmin(result.value);
                }
            });
        } else {
            showError('Error', 'Failed to fetch admin details');
        }
    } catch (error) {
        console.error('Error:', error);
        showError('Error', 'Failed to fetch admin details');
    }
}

async function updateAdmin(adminData) {
    try {
        const response = await fetch('../../php/update_admin.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(adminData)
        });

        const data = await response.json();

        if (data.status === 'success') {
            // Log the activity
            await logActivity('UPDATE', `Updated admin: ${adminData.fname} ${adminData.lname}`);
            showSuccess('Success', 'Admin updated successfully');
            loadAdmins();
        } else {
            showError('Error', data.message || 'Failed to update admin');
        }
    } catch (error) {
        console.error('Error:', error);
        showError('Error', 'Failed to update admin');
    }
}

function deleteAdmin(adminId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e74c3c',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                // Get admin details before deletion for logging
                const adminResponse = await fetch(`../../php/get_admin.php?id=${adminId}`);
                const adminData = await adminResponse.json();
                const adminName = adminData.status === 'success' ?
                    `${adminData.data.fname} ${adminData.data.lname}` :
                    adminId;

                const response = await fetch('../../php/delete_admin.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ adminId })
                });

                const data = await response.json();

                if (data.status === 'success') {
                    // Log the activity
                    await logActivity('DELETE', `Deleted admin: ${adminName}`);
                    showSuccess('Deleted!', 'Admin has been deleted.');
                    loadAdmins();
                } else {
                    showError('Error', data.message || 'Failed to delete admin');
                }
            } catch (error) {
                console.error('Error:', error);
                showError('Error', 'Failed to delete admin');
            }
        }
    });
}

async function logActivity(actionType, description) {
    try {
        const response = await fetch('../../php/log_activity.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                action_type: actionType,
                description: description
            })
        });

        const data = await response.json();
        if (data.status !== 'success') {
            console.error('Failed to log activity:', data.message);
        }
    } catch (error) {
        console.error('Error logging activity:', error);
    }
}

// Handle logout button
document.getElementById('logoutBtn').addEventListener('click', function () {
    Swal.fire({
        title: 'Logout',
        text: 'Are you sure you want to logout?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#e74c3c',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, logout'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '../../php/logout.php';
        }
    });
}); 
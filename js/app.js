// Core JavaScript
document.addEventListener('DOMContentLoaded', () => {
    // Initialize VanillaTilt if available
    init3D();
    
    // Check authentication state for dynamic navbar
    updateNavbar();
});

function init3D() {
    if (typeof VanillaTilt !== 'undefined') {
        VanillaTilt.init(document.querySelectorAll("[data-tilt]"), {
            max: 15,
            speed: 400,
            glare: true,
            "max-glare": 0.2,
            perspective: 1000
        });
    }
}

// Simple Auth checking (simulating token check)
function updateNavbar() {
    const userRole = localStorage.getItem('userRole'); // 'voter' or 'admin'
    const isLoggedIn = !!userRole;
    
    const unauthNav = document.getElementById('nav-unauth');
    const authNav = document.getElementById('nav-auth');
    
    if (unauthNav && authNav) {
        if (isLoggedIn) {
            unauthNav.style.display = 'none';
            authNav.style.display = 'flex';
            
            // Adjust links based on role
            const dashboardLink = document.getElementById('nav-dashboard-link');
            if (dashboardLink) {
                if (userRole === 'admin') {
                    dashboardLink.href = 'admin.php';
                    dashboardLink.innerHTML = '<i class="fas fa-shield-alt"></i> Admin Panel';
                } else {
                    dashboardLink.href = 'dashboard.php';
                    dashboardLink.innerHTML = '<i class="fas fa-user"></i> Dashboard';
                }
            }
        } else {
            unauthNav.style.display = 'flex';
            authNav.style.display = 'none';
        }
    }
}

function logout() {
    localStorage.removeItem('userRole');
    localStorage.removeItem('userId');
    window.location.href = 'index.php';
}

// Helper function to handle fetch API responses beautifully
async function fetchAPI(url, options = {}) {
    try {
        const response = await fetch(url, options);
        return await response.json();
    } catch (error) {
        console.error('API Error:', error);
        return { status: 'error', message: 'Failed to connect to server' };
    }
}

// Helper to show modern alerts using SweetAlert2
function showAlert(title, text, icon) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            background: '#111827',
            color: '#f8fafc',
            confirmButtonColor: '#fbbf24'
        });
    } else {
        alert(`${title}: ${text}`);
    }
}

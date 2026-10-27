<?php include 'header.php'; ?>

<style>
/* Admin specific styles */
.admin-sidebar {
    background: rgba(10, 15, 28, 0.9);
    border-right: 1px solid var(--card-border);
    padding: 2rem 1rem;
    min-height: 80vh;
}
.sidebar-item {
    display: block;
    padding: 1rem;
    color: var(--text-muted);
    text-decoration: none;
    border-radius: 8px;
    margin-bottom: 0.5rem;
    transition: var(--transition);
}
.sidebar-item:hover, .sidebar-item.active {
    background: rgba(251, 191, 36, 0.1);
    color: var(--gold-accent);
}
.admin-table {
    width: 100%;
    border-collapse: collapse;
}
.admin-table th, .admin-table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid var(--card-border);
}
.admin-table th {
    color: var(--gold-accent);
    font-weight: 600;
}
.content-section {
    display: none;
    animation: fadeInUp 0.5s ease;
}
.content-section.active {
    display: block;
}
</style>

<div style="display: flex;">
    <aside class="admin-sidebar" style="width: 250px;">
        <h3 style="color: var(--text-light); text-align: center; margin-bottom: 2rem;">Admin Panel</h3>
        <a href="#dashboard" class="sidebar-item active" onclick="switchTab('dashboard')"><i class="fas fa-chart-line"></i> Overview</a>
        <a href="#elections" class="sidebar-item" onclick="switchTab('elections')"><i class="fas fa-person-booth"></i> Manage Elections</a>
        <a href="#candidates" class="sidebar-item" onclick="switchTab('candidates')"><i class="fas fa-users"></i> Manage Candidates</a>
        <a href="#users" class="sidebar-item" onclick="switchTab('users')"><i class="fas fa-id-card"></i> Manage Users</a>
    </aside>

    <main style="flex: 1; padding: 2rem;">
        <!-- Dashboard Tab -->
        <section id="tab-dashboard" class="content-section active">
            <h2 style="font-size: 2rem; color: var(--gold-accent); margin-bottom: 2rem;">System Overview</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                <div class="glass-card" data-tilt>
                    <div class="tz-20">
                        <i class="fas fa-users fa-2x text-muted" style="margin-bottom: 1rem; color: var(--gold-accent);"></i>
                        <h3>Total Users</h3>
                        <p style="font-size: 2rem; font-weight: bold;">Loading...</p>
                    </div>
                </div>
                <div class="glass-card" data-tilt>
                    <div class="tz-20">
                        <i class="fas fa-person-booth fa-2x text-muted" style="margin-bottom: 1rem; color: var(--success);"></i>
                        <h3>Active Elections</h3>
                        <p style="font-size: 2rem; font-weight: bold;" id="admin-act-elections">Loading...</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Elections Tab -->
        <section id="tab-elections" class="content-section">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h2 style="font-size: 2rem; color: var(--gold-accent);">Manage Elections</h2>
                <button class="btn-primary" onclick="createElectionModal()"><i class="fas fa-plus"></i> New Election</button>
            </div>
            <div class="glass-card" style="padding: 1rem; overflow-x: auto;">
                <table class="admin-table">
                    <thead><tr><th>ID</th><th>Title</th><th>Status</th><th>End Date</th><th>Actions</th></tr></thead>
                    <tbody id="admin-election-tbody"><tr><td colspan="5">Loading...</td></tr></tbody>
                </table>
            </div>
        </section>

        <!-- Candidates Tab -->
        <section id="tab-candidates" class="content-section">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h2 style="font-size: 2rem; color: var(--gold-accent);">Manage Candidates</h2>
                <button class="btn-primary" onclick="showAlert('Demo', 'Add candidate functionality opens a modal in full version.', 'info')"><i class="fas fa-plus"></i> Add Candidate</button>
            </div>
            <div class="glass-card" style="padding: 1rem; overflow-x: auto;">
                <table class="admin-table">
                    <thead><tr><th>ID</th><th>Name</th><th>Party</th><th>Election ID</th><th>Actions</th></tr></thead>
                    <tbody id="admin-candidate-tbody"><tr><td colspan="5">Loading...</td></tr></tbody>
                </table>
            </div>
        </section>
        
        <!-- Users Tab -->
        <section id="tab-users" class="content-section">
            <h2 style="font-size: 2rem; color: var(--gold-accent); margin-bottom: 2rem;">Manage Users</h2>
            <div class="glass-card" style="padding: 1rem; overflow-x: auto;">
                <table class="admin-table">
                    <thead><tr><th>ID</th><th>Name</th><th>CNIC</th><th>Role</th><th>Actions</th></tr></thead>
                    <tbody id="admin-user-tbody"><tr><td colspan="5">Loading...</td></tr></tbody>
                </table>
            </div>
        </section>

    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Auth Check
    const role = localStorage.getItem('userRole');
    if (role !== 'admin') {
        showAlert('Access Denied', 'Admin privileges required.', 'error');
        window.location.href = 'index.php';
        return;
    }
    loadAdminData();
});

function switchTab(tabId) {
    document.querySelectorAll('.sidebar-item').forEach(item => item.classList.remove('active'));
    event.currentTarget.classList.add('active');
    
    document.querySelectorAll('.content-section').forEach(sec => sec.classList.remove('active'));
    document.getElementById(`tab-${tabId}`).classList.add('active');
}

async function loadAdminData() {
    // Load Elections
    const e_res = await fetchAPI('api/elections/read.php');
    if(e_res.status === 'success') {
        const tbody = document.getElementById('admin-election-tbody');
        tbody.innerHTML = '';
        document.getElementById('admin-act-elections').innerText = e_res.data.length;
        
        e_res.data.forEach(e => {
            tbody.innerHTML += `
                <tr>
                    <td>${e.id}</td>
                    <td>${e.title}</td>
                    <td><span class="badge ${e.status}">${e.status.toUpperCase()}</span></td>
                    <td>${new Date(e.end_date).toLocaleDateString()}</td>
                    <td>
                        <button class="btn-secondary" style="padding: 0.3rem 0.6rem; font-size: 0.8rem;" onclick="deleteElection(${e.id})"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            `;
        });
    }
}

function createElectionModal() {
    Swal.fire({
        title: 'Create New Election',
        html: `
            <input type="text" id="e_title" class="swal2-input" placeholder="Title (e.g. 2026 President)">
            <textarea id="e_desc" class="swal2-textarea" placeholder="Description"></textarea>
        `,
        focusConfirm: false,
        background: '#111827',
        color: '#f8fafc',
        confirmButtonColor: '#fbbf24',
        preConfirm: () => {
            const title = Swal.getPopup().querySelector('#e_title').value;
            if (!title) { Swal.showValidationMessage(`Please enter a title`); }
            return { title: title, desc: Swal.getPopup().querySelector('#e_desc').value }
        }
    }).then(async (result) => {
        if (result.isConfirmed) {
            const res = await fetchAPI('api/elections/create.php', {
                method: 'POST', body: JSON.stringify({ title: result.value.title, description: result.value.desc })
            });
            if(res.status === 'success') {
                showAlert('Created!', 'Election created successfully.', 'success');
                loadAdminData();
            }
        }
    })
}

async function deleteElection(id) {
    if(confirm('Are you sure you want to delete this election? All votes and candidates will be lost.')) {
        await fetchAPI('api/elections/delete.php', { method: 'POST', body: JSON.stringify({ id }) });
        loadAdminData();
    }
}
</script>

<?php include 'footer.php'; ?>

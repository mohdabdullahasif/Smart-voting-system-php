<?php include 'header.php'; ?>

<section style="padding: 3rem 5%;">
    <div class="container">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div>
                <h2 style="font-size: 2.5rem; color: var(--gold-accent);">Voter Dashboard</h2>
                <p style="color: var(--text-muted);" id="welcomeMessage">Welcome back!</p>
            </div>
            
            <div class="glass-card" style="padding: 1rem 2rem; text-align: center; border-color: var(--gold-accent);">
                <i class="fas fa-id-card" style="font-size: 2rem; color: var(--gold-accent); margin-bottom: 0.5rem;"></i>
                <h3 style="margin-bottom: 0.2rem;" id="profile_status">Status: Verified</h3>
            </div>
        </div>

        <h3 style="margin-bottom: 1.5rem; font-size: 1.8rem; border-bottom: 1px solid var(--card-border); padding-bottom: 0.5rem;">Available Elections</h3>
        
        <div id="electionsContainer" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            <!-- Fetched Elections Will Appear Here -->
            <div style="color: var(--text-muted);"><i class="fas fa-spinner fa-spin"></i> Loading elections...</div>
        </div>

    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Auth Check
    const userId = localStorage.getItem('userId');
    const role = localStorage.getItem('userRole');
    if(!userId || role !== 'voter') {
        showAlert('Access Denied', 'Please sign in as a voter.', 'error');
        setTimeout(() => window.location.href = 'login.php', 1500);
        return;
    }

    loadElections();
});

async function loadElections() {
    const res = await fetchAPI('api/elections/read.php');
    const container = document.getElementById('electionsContainer');
    
    if (res.status === 'success' && res.data.length > 0) {
        container.innerHTML = '';
        res.data.forEach((election, index) => {
            const delayClass = `delay-${(index%3)+1}`;
            
            let statusBadge = '';
            if (election.status === 'active') {
                statusBadge = `<span style="background: rgba(16,185,129,0.2); color: var(--success); padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.8rem; font-weight: bold;"><i class="fas fa-circle" style="font-size: 0.5rem; vertical-align: middle;"></i> ACTIVE</span>`;
            } else if (election.status === 'upcoming') {
                statusBadge = `<span style="background: rgba(251,191,36,0.2); color: var(--gold-accent); padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.8rem; font-weight: bold;">UPCOMING</span>`;
            } else {
                statusBadge = `<span style="background: rgba(239,68,68,0.2); color: var(--danger); padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.8rem; font-weight: bold;">CLOSED</span>`;
            }

            let actionBtn = '';
            if (election.status === 'active') {
                actionBtn = `<a href="voting.php?id=${election.id}" class="btn-primary" style="margin-top: 1.5rem; width: 100%; justify-content: center;">Enter Voting Area <i class="fas fa-arrow-right"></i></a>`;
            } else {
                actionBtn = `<button class="btn-secondary" style="margin-top: 1.5rem; width: 100%; opacity: 0.5; cursor: not-allowed;" disabled>Voting Closed</button>`;
            }

            container.innerHTML += `
            <div class="glass-card animate-up ${delayClass}" data-tilt data-tilt-max="5" style="display: flex; flex-direction: column;">
                <div class="tz-20" style="flex: 1;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                        <h3 style="font-size: 1.4rem; color: var(--text-light);">${election.title}</h3>
                    </div>
                    ${statusBadge}
                    <p style="color: var(--text-muted); margin-top: 1rem; line-height: 1.5;">${election.description}</p>
                    <div style="margin-top: 1rem; font-size: 0.9rem; color: var(--text-muted);">
                        <i class="far fa-calendar-alt"></i> Ends: ${new Date(election.end_date).toLocaleDateString()}
                    </div>
                </div>
                ${actionBtn}
            </div>
            `;
        });
        
        // Re-init vanilla-tilt for newly added DOM elements
        if (typeof VanillaTilt !== 'undefined') {
            VanillaTilt.init(document.querySelectorAll("[data-tilt]"), {
                max: 10,
                speed: 400,
                glare: true,
                "max-glare": 0.1
            });
        }
    } else {
        container.innerHTML = '<div class="glass-card"><p>No elections found.</p></div>';
    }
}
</script>

<?php include 'footer.php'; ?>

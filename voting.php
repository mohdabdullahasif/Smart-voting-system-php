<?php include 'header.php'; ?>

<section style="padding: 3rem 5%; min-height: 80vh;">
    <div class="container" style="max-width: 900px;">
        
        <div style="text-align: center; margin-bottom: 3rem;">
            <a href="dashboard.php" style="color: var(--text-muted); text-decoration: none; display: inline-block; margin-bottom: 1rem;"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
            <h2 style="font-size: 2.5rem; color: var(--gold-accent);" id="electionTitle">Digital Ballot</h2>
            <p style="color: var(--text-muted);">Please review the candidates below carefully before making your selection.</p>
        </div>

        <div id="candidatesContainer" style="display: flex; flex-direction: column; gap: 1.5rem; margin-bottom: 3rem;">
            <div style="text-align: center;"><i class="fas fa-spinner fa-spin fa-2x"></i></div>
        </div>

        <div style="text-align: center;">
            <button id="submitVoteBtn" class="btn-primary" style="font-size: 1.2rem; padding: 1rem 3rem;" onclick="confirmVote()">
                <i class="fas fa-check-circle"></i> Submit Official Vote
            </button>
        </div>
    </div>
</section>

<!-- Custom Selection Styles -->
<style>
.candidate-card {
    transition: var(--transition);
    border: 2px solid var(--card-border);
    cursor: pointer;
    position: relative;
    overflow: hidden;
}
.candidate-card:hover {
    border-color: rgba(251,191,36,0.5);
    transform: translateX(10px);
}
.candidate-card.selected {
    border-color: var(--success);
    background: rgba(16,185,129,0.1);
}
.candidate-card.selected::before {
    content: '\f058';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    position: absolute;
    top: 50%;
    right: 2rem;
    transform: translateY(-50%);
    font-size: 2.5rem;
    color: var(--success);
    animation: popIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
@keyframes popIn {
    0% { transform: translateY(-50%) scale(0); opacity: 0; }
    100% { transform: translateY(-50%) scale(1); opacity: 1; }
}
</style>

<script>
let selectedCandidateId = null;
let currentElectionId = new URLSearchParams(window.location.search).get('id');

document.addEventListener('DOMContentLoaded', () => {
    if(!currentElectionId) {
        window.location.href = 'dashboard.php';
        return;
    }
    loadCandidates();
});

async function loadCandidates() {
    const res = await fetchAPI(`api/candidates/read.php?election_id=${currentElectionId}`);
    const container = document.getElementById('candidatesContainer');
    
    if (res.status === 'success' && res.data.length > 0) {
        container.innerHTML = '';
        res.data.forEach((candidate, index) => {
            container.innerHTML += `
            <div class="glass-card candidate-card animate-up" style="animation-delay: ${index * 0.1}s" onclick="selectCandidate(${candidate.id}, this)">
                <div style="display: flex; align-items: center; gap: 2rem;">
                    <div style="width: 80px; height: 80px; border-radius: 50%; background: var(--secondary-dark); border: 2px solid var(--gold-accent); overflow: hidden; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
                        <i class="fas fa-user-tie text-muted"></i>
                    </div>
                    <div style="flex: 1;">
                        <h3 style="font-size: 1.5rem; color: var(--gold-accent); margin-bottom: 0.2rem;">${candidate.name}</h3>
                        <p style="font-weight: bold; margin-bottom: 0.5rem; color: var(--text-light);"><i class="fas fa-flag"></i> ${candidate.party}</p>
                        <p style="color: var(--text-muted); font-size: 0.9rem;">${candidate.description}</p>
                    </div>
                </div>
            </div>
            `;
        });
    } else {
        container.innerHTML = '<p style="text-align:center;">No candidates available for this election.</p>';
        document.getElementById('submitVoteBtn').style.display = 'none';
    }
}

function selectCandidate(id, element) {
    // Remove selected class from all
    document.querySelectorAll('.candidate-card').forEach(card => card.classList.remove('selected'));
    // Add to clicked
    element.classList.add('selected');
    selectedCandidateId = id;
}

function confirmVote() {
    if(!selectedCandidateId) {
        showAlert('Selection Required', 'Please select a candidate before submitting.', 'warning');
        return;
    }

    Swal.fire({
        title: 'Confirm Your Vote',
        text: "Are you absolutely sure you want to submit your vote? This action cannot be undone.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#ef4444',
        confirmButtonText: 'Yes, Submit Vote',
        background: '#111827',
        color: '#f8fafc'
    }).then((result) => {
        if (result.isConfirmed) {
            submitVote();
        }
    })
}

async function submitVote() {
    const userId = localStorage.getItem('userId');
    const btn = document.getElementById('submitVoteBtn');
    
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';

    const payload = {
        election_id: currentElectionId,
        candidate_id: selectedCandidateId,
        user_id: userId
    };

    const res = await fetchAPI('api/votes/cast.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
    });

    if(res.status === 'success') {
        Swal.fire({
            title: 'Vote Submitted!',
            text: res.message,
            icon: 'success',
            background: '#111827',
            color: '#f8fafc',
            confirmButtonColor: '#fbbf24'
        }).then(() => {
            window.location.href = 'dashboard.php';
        });
    } else {
        showAlert('Voting Error', res.message, 'error');
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-check-circle"></i> Submit Official Vote';
    }
}
</script>

<?php include 'footer.php'; ?>

<?php include 'header.php'; ?>

<section style="padding: 3rem 5%;">
    <div class="container">
        <div style="text-align: center; margin-bottom: 3rem;">
            <h2 style="font-size: 2.5rem; color: var(--gold-accent);">Live Election Results</h2>
            <p style="color: var(--text-muted);">Real-time transparency and analytics</p>
        </div>

        <div style="margin-bottom: 2rem;">
            <label style="color: var(--text-muted);">Select Election:</label>
            <select id="electionSelect" class="form-control" style="background: var(--card-bg); color: white; max-width: 400px; margin-top: 0.5rem;" onchange="fetchResults(this.value)">
                <option value="">Choosing...</option>
            </select>
        </div>

        <div id="resultsContent" style="display: none;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
                <div class="glass-card" data-tilt>
                    <div class="tz-10">
                        <h3 style="color: var(--gold-accent); margin-bottom: 1rem;"><i class="fas fa-trophy"></i> Current Leader</h3>
                        <div id="leaderDisplay"></div>
                    </div>
                </div>
                <div class="glass-card" data-tilt>
                    <div class="tz-10">
                        <h3 style="margin-bottom: 1rem;">Turnout / Total Votes</h3>
                        <div id="totalVotesDisplay" style="font-size: 3rem; font-weight: bold; color: var(--success);">0</div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
                <div class="glass-card">
                    <h3 style="margin-bottom: 1rem;">Vote Distribution (Bar)</h3>
                    <canvas id="barChart"></canvas>
                </div>
                <div class="glass-card">
                    <h3 style="margin-bottom: 1rem;">Percentage Share (Pie)</h3>
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 3rem;">
                <button class="btn-primary" onclick="alert('PDF downloaded! (Simulated)')"><i class="fas fa-download"></i> Download Report</button>
            </div>
        </div>
        
    </div>
</section>

<script>
let barChartInstance = null;
let pieChartInstance = null;

document.addEventListener('DOMContentLoaded', async () => {
    // Populate Election Dropdown
    const res = await fetchAPI('api/elections/read.php');
    if(res.status === 'success') {
        const select = document.getElementById('electionSelect');
        select.innerHTML = '<option value="">-- Choose an Election --</option>';
        res.data.forEach(e => {
            select.innerHTML += `<option value="${e.id}">${e.title}</option>`;
        });
        
        // Auto select first if exists
        if(res.data.length > 0) {
            select.value = res.data[0].id;
            fetchResults(res.data[0].id);
        }
    }
});

async function fetchResults(electionId) {
    if(!electionId) return;
    
    document.getElementById('resultsContent').style.display = 'block';
    
    const res = await fetchAPI(`api/votes/results.php?election_id=${electionId}`);
    if(res.status === 'success') {
        document.getElementById('totalVotesDisplay').innerText = res.total_votes;
        
        if (res.data.length > 0) {
            const leader = res.data[0];
            document.getElementById('leaderDisplay').innerHTML = `
                <h4 style="font-size: 1.5rem;">${leader.name}</h4>
                <p style="color: var(--text-muted);">${leader.party}</p>
                <div style="margin-top: 1rem; font-weight: bold; color: var(--success);">${leader.votes} Votes (${leader.percentage}%)</div>
            `;
        }
        
        renderCharts(res.data);
    }
}

function renderCharts(data) {
    const labels = data.map(d => d.name);
    const votes = data.map(d => d.votes);
    
    // Setup Bar Chart
    const barCtx = document.getElementById('barChart').getContext('2d');
    if(barChartInstance) barChartInstance.destroy();
    barChartInstance = new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Votes Cast',
                data: votes,
                backgroundColor: 'rgba(251, 191, 36, 0.6)',
                borderColor: 'rgba(251, 191, 36, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.1)' }, ticks: { color: '#94a3b8'} },
                x: { grid: { color: 'rgba(255,255,255,0.1)' }, ticks: { color: '#94a3b8'} }
            },
            plugins: { legend: { labels: { color: '#f8fafc' } } }
        }
    });

    // Setup Pie Chart
    const pieCtx = document.getElementById('pieChart').getContext('2d');
    if(pieChartInstance) pieChartInstance.destroy();
    pieChartInstance = new Chart(pieCtx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: votes,
                backgroundColor: [
                    '#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom', labels: { color: '#f8fafc' } } }
        }
    });
}
</script>

<?php include 'footer.php'; ?>

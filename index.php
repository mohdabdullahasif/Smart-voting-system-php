<?php include 'header.php'; ?>

<!-- Hero Section with 3D Perspecitve -->
<section class="hero-container" style="min-height: 80vh; display: flex; align-items: center; justify-content: center; position: relative;">
    <div class="container animate-up">
        <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between;">
            
            <div style="flex: 1; min-width: 300px; padding-right: 2rem;">
                <h1 style="font-size: 4rem; margin-bottom: 1rem; line-height: 1.1; font-weight: 800;">
                    Your <span style="color: var(--gold-accent);">Voice</span>,<br> Your <span style="color: var(--gold-accent);">Choice</span>
                </h1>
                <p style="font-size: 1.25rem; color: var(--text-muted); margin-bottom: 2.5rem; max-width: 500px;">
                    Experience the future of democracy. VoteSphere provides a highly secure, transparent, and user-friendly digital voting platform. 
                </p>
                <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                    <a href="login.php" class="btn-primary" style="padding: 0.8rem 2rem; font-size: 1.1rem;">Get Started</a>
                    <a href="results.php" class="btn-secondary" style="padding: 0.8rem 2rem; font-size: 1.1rem;">View Elections <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

            <!-- 3D Hero Graphic -->
            <div style="flex: 1; min-width: 300px; display: flex; justify-content: center; transform-style: preserve-3d; perspective: 1000px;" class="animate-up delay-1">
                <div data-tilt data-tilt-max="10" data-tilt-speed="400" data-tilt-glare="true" data-tilt-max-glare="0.5" style="background: linear-gradient(145deg, rgba(30, 58, 138, 0.4), rgba(10, 15, 28, 0.8)); border: 1px solid var(--gold-accent); border-radius: 20px; padding: 3rem; text-align: center; box-shadow: 0 20px 50px rgba(0,0,0,0.5); transform-style: preserve-3d;">
                    <div class="tz-40">
                        <i class="fas fa-box-ballot" style="font-size: 6rem; color: var(--gold-accent); margin-bottom: 1rem;"></i>
                        <h2 style="font-size: 2rem; margin-bottom: 0.5rem;">Secure VoteBox</h2>
                        <p style="color: var(--text-muted);">End-to-End Encrypted</p>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- Features Section -->
<section style="padding: 5rem 0; background: rgba(0,0,0,0.2);">
    <div class="container text-center">
        <h2 style="font-size: 2.5rem; margin-bottom: 3rem; text-align: center;">Why Choose <span style="color: var(--gold-accent)">VoteSphere</span>?</h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
            
            <div class="glass-card animate-up delay-1" data-tilt>
                <div class="tz-30">
                    <div style="width: 70px; height: 70px; background: rgba(251,191,36,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: var(--gold-accent); font-size: 1.8rem;">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 style="margin-bottom: 1rem; font-size: 1.4rem;">Secure Voting</h3>
                    <p style="color: var(--text-muted); line-height: 1.6;">Military-grade encryption ensures your vote is completely anonymous and tamper-proof.</p>
                </div>
            </div>
            
            <div class="glass-card animate-up delay-2" data-tilt>
                <div class="tz-30">
                    <div style="width: 70px; height: 70px; background: rgba(16,185,129,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: var(--success); font-size: 1.8rem;">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h3 style="margin-bottom: 1rem; font-size: 1.4rem;">Fast Results</h3>
                    <p style="color: var(--text-muted); line-height: 1.6;">Real-time tallying delivers instant and accurate results the moment the polls close.</p>
                </div>
            </div>
            
            <div class="glass-card animate-up delay-3" data-tilt>
                <div class="tz-30">
                    <div style="width: 70px; height: 70px; background: rgba(59,130,246,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: #3b82f6; font-size: 1.8rem;">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 style="margin-bottom: 1rem; font-size: 1.4rem;">Transparent</h3>
                    <p style="color: var(--text-muted); line-height: 1.6;">Fully auditable logs and transparent counting algorithms build absolute public trust.</p>
                </div>
            </div>
            
        </div>
    </div>
</section>

<!-- How it works -->
<section style="padding: 5rem 0;">
    <div class="container">
        <h2 style="font-size: 2.5rem; margin-bottom: 4rem; text-align: center;">How It <span style="color: var(--gold-accent)">Works</span></h2>
        
        <div style="display: flex; justify-content: space-between; position: relative; flex-wrap: wrap; gap: 2rem;">
            <!-- Connector Line (desktop only, hidden on mobile) -->
            <div style="position: absolute; top: 40px; left: 10%; right: 10%; height: 2px; background: var(--card-border); z-index: -1;" class="d-none-mobile"></div>
            
            <div style="flex: 1; min-width: 200px; text-align: center;" class="animate-up">
                <div style="width: 80px; height: 80px; background: var(--primary-dark); border: 2px solid var(--gold-accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 1.5rem; font-weight: bold; color: var(--gold-accent); box-shadow: 0 0 20px rgba(251,191,36,0.2);">1</div>
                <h3 style="margin-bottom: 0.5rem;">Register Account</h3>
                <p style="color: var(--text-muted); font-size: 0.9rem;">Sign up using your CNIC</p>
            </div>
            
            <div style="flex: 1; min-width: 200px; text-align: center;" class="animate-up delay-1">
                <div style="width: 80px; height: 80px; background: var(--primary-dark); border: 2px solid var(--gold-accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 1.5rem; font-weight: bold; color: var(--gold-accent); box-shadow: 0 0 20px rgba(251,191,36,0.2);">2</div>
                <h3 style="margin-bottom: 0.5rem;">Verify Identity</h3>
                <p style="color: var(--text-muted); font-size: 0.9rem;">Authenticate your login securely</p>
            </div>
            
            <div style="flex: 1; min-width: 200px; text-align: center;" class="animate-up delay-2">
                <div style="width: 80px; height: 80px; background: var(--primary-dark); border: 2px solid var(--gold-accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 1.5rem; font-weight: bold; color: var(--gold-accent); box-shadow: 0 0 20px rgba(251,191,36,0.2);">3</div>
                <h3 style="margin-bottom: 0.5rem;">Cast Vote</h3>
                <p style="color: var(--text-muted); font-size: 0.9rem;">Choose via digital ballot</p>
            </div>
            
            <div style="flex: 1; min-width: 200px; text-align: center;" class="animate-up delay-3">
                <div style="width: 80px; height: 80px; background: var(--primary-dark); border: 2px solid var(--gold-accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 1.5rem; font-weight: bold; color: var(--gold-accent); box-shadow: 0 0 20px rgba(251,191,36,0.2);">4</div>
                <h3 style="margin-bottom: 0.5rem;">View Results</h3>
                <p style="color: var(--text-muted); font-size: 0.9rem;">See real-time transparent data</p>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section style="padding: 5rem 0; background: linear-gradient(0deg, rgba(0,0,0,0.5), transparent);">
    <div class="container">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; text-align: center;">
            <div class="glass-card animate-up" data-tilt>
                <div class="tz-20">
                    <h2 style="font-size: 3rem; color: var(--gold-accent); margin-bottom: 0.5rem;" id="stat-voters">15k+</h2>
                    <p style="font-size: 1.1rem; color: var(--text-light); text-transform: uppercase; letter-spacing: 2px;">Total Voters</p>
                </div>
            </div>
            <div class="glass-card animate-up delay-1" data-tilt>
                <div class="tz-20">
                    <h2 style="font-size: 3rem; color: var(--gold-accent); margin-bottom: 0.5rem;" id="stat-elections">12</h2>
                    <p style="font-size: 1.1rem; color: var(--text-light); text-transform: uppercase; letter-spacing: 2px;">Active Elections</p>
                </div>
            </div>
            <div class="glass-card animate-up delay-2" data-tilt>
                <div class="tz-20">
                    <h2 style="font-size: 3rem; color: var(--gold-accent); margin-bottom: 0.5rem;" id="stat-candidates">45</h2>
                    <p style="font-size: 1.1rem; color: var(--text-light); text-transform: uppercase; letter-spacing: 2px;">Candidates</p>
                </div>
            </div>
            <div class="glass-card animate-up delay-3" data-tilt>
                <div class="tz-20">
                    <h2 style="font-size: 3rem; color: var(--gold-accent); margin-bottom: 0.5rem;" id="stat-votes">98k</h2>
                    <p style="font-size: 1.1rem; color: var(--text-light); text-transform: uppercase; letter-spacing: 2px;">Votes Cast</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    @media(max-width: 768px) {
        .d-none-mobile { display: none !important; }
    }
</style>

<!-- Add FontAwesome Box Ballot icon specifically if not loaded -->
<script>
    // Simple counter animation logic can go here for the stats
</script>

<?php include 'footer.php'; ?>

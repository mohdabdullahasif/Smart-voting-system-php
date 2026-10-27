<?php include 'header.php'; ?>

<section style="min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 2rem 5%;">
    <div class="glass-card animate-up" data-tilt style="width: 100%; max-width: 450px;">
        <div class="tz-20">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h2 style="font-size: 2rem; color: var(--gold-accent);">Welcome Back</h2>
                <p style="color: var(--text-muted);">Secure Login Panel</p>
            </div>
            
            <form id="loginForm" onsubmit="handleLogin(event)">
                <div class="form-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                    <input type="email" id="email" class="form-control" required placeholder="admin@gmail.com">
                </div>
                
                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" id="password" class="form-control" required placeholder="admin123">
                </div>
                
                <div class="form-group" style="display: flex; justify-content: space-between; align-items: center;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; margin: 0; cursor: pointer;">
                        <input type="checkbox"> Remember me
                    </label>
                    <a href="#" style="color: var(--gold-accent); text-decoration: none; font-size: 0.9rem;">Forgot Password?</a>
                </div>
                
                <!-- Simulated CAPTCHA -->
                <div class="form-group" style="background: rgba(0,0,0,0.3); padding: 1rem; border-radius: 8px; border: 1px solid var(--card-border); display: flex; align-items: center; gap: 1rem;">
                    <input type="checkbox" id="captcha" required style="width: 20px; height: 20px;">
                    <span>I am human (Simulated Secure CAPTCHA)</span>
                </div>
                
                <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; margin-top: 1rem;">
                    Sign In
                </button>
            </form>
            
            <p style="text-align: center; margin-top: 1.5rem; color: var(--text-muted);">
                Don't have an account? <a href="register.php" style="color: var(--gold-accent); text-decoration: none;">Register here</a>
            </p>
        </div>
    </div>
</section>

<script>
async function handleLogin(e) {
    e.preventDefault();
    
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    
    // Using fetch API to talk to our PHP backend
    const res = await fetchAPI('api/auth/login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, password })
    });
    
    if (res.status === 'success') {
        localStorage.setItem('userRole', res.data.role);
        localStorage.setItem('userId', res.data.id);
        
        showAlert('Success', 'Logged in securely!', 'success');
        setTimeout(() => {
            if(res.data.role === 'admin') {
                window.location.href = 'admin.php';
            } else {
                window.location.href = 'dashboard.php';
            }
        }, 1500);
    } else {
        showAlert('Access Denied', res.message, 'error');
    }
}
</script>

<?php include 'footer.php'; ?>

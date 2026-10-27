<?php include 'header.php'; ?>

<section style="min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 3rem 5%;">
    <div class="glass-card animate-up" data-tilt style="width: 100%; max-width: 600px;">
        <div class="tz-20">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h2 style="font-size: 2rem; color: var(--gold-accent);">Voter Registration</h2>
                <p style="color: var(--text-muted);">Create your secure voting identity.</p>
            </div>
            
            <form id="registerForm" onsubmit="handleRegister(event)">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" id="name" class="form-control" required placeholder="John Doe">
                    </div>
                    <div class="form-group">
                        <label>CNIC / Voter ID</label>
                        <input type="text" id="cnic" class="form-control" required placeholder="00000-0000000-0">
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" id="email" class="form-control" required placeholder="john@example.com">
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" id="phone" class="form-control" required placeholder="0300-1234567">
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" id="password" class="form-control" required minlength="6">
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" id="confirm_password" class="form-control" required minlength="6">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Profile Picture</label>
                    <input type="file" id="pic" class="form-control" accept="image/*">
                    <small style="color: var(--text-muted);">For prototype, file inputs are simulated on frontend.</small>
                </div>
                
                <div class="form-group">
                    <label>Register As</label>
                    <select id="role" class="form-control" required style="background: rgba(255,255,255,0.03); color: white;">
                        <option value="voter">Voter</option>
                        <option value="candidate">Candidate (Needs admin approval)</option>
                    </select>
                </div>
                
                <button type="submit" class="btn-primary" style="width: 100%; justify-content: center; margin-top: 1rem;">
                    Register Now
                </button>
            </form>
            
            <p style="text-align: center; margin-top: 1.5rem; color: var(--text-muted);">
                Already have an account? <a href="login.php" style="color: var(--gold-accent); text-decoration: none;">Sign In</a>
            </p>
        </div>
    </div>
</section>

<script>
async function handleRegister(e) {
    e.preventDefault();
    
    const password = document.getElementById('password').value;
    const confirm = document.getElementById('confirm_password').value;
    
    if (password !== confirm) {
        showAlert('Registration Error', 'Passwords do not match.', 'error');
        return;
    }
    
    const payload = {
        name: document.getElementById('name').value,
        cnic: document.getElementById('cnic').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        password: password,
        role: document.getElementById('role').value
    };
    
    const res = await fetchAPI('api/auth/register.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
    });
    
    if (res.status === 'success') {
        showAlert('Registration Successful', 'You can now log in to the system.', 'success');
        document.getElementById('registerForm').reset();
        setTimeout(() => {
            window.location.href = 'login.php';
        }, 2000);
    } else {
        showAlert('Registration Failed', res.message, 'error');
    }
}
</script>

<?php include 'footer.php'; ?>

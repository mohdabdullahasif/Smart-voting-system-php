<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VoteSphere - Smart Digital Election Platform</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 for beautiful Modals -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="bg-mesh"></div>
    
    <nav>
        <a href="index.php" class="logo-container">
            <i class="fa-solid fa-check-to-slot logo-icon"></i>
            VoteSphere
        </a>
        
        <!-- Unauthenticated Nav -->
        <div class="nav-links" id="nav-unauth">
            <a href="index.php">Home</a>
            <a href="results.php">View Elections</a>
            <a href="login.php" class="btn-secondary">Login</a>
            <a href="register.php" class="btn-primary">Register</a>
        </div>
        
        <!-- Authenticated Nav -->
        <div class="nav-links" id="nav-auth" style="display: none;">
            <a href="index.php">Home</a>
            <a href="results.php">Results</a>
            <a href="dashboard.php" id="nav-dashboard-link"><i class="fas fa-user"></i> Dashboard</a>
            <a href="#" onclick="logout()" class="btn-secondary"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </nav>

<?php
// includes/header.php - Add this at the top
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!-- Rest of your header content -->
<!-- Header -->
<header>
    <div class="container header-container">
        <div class="logo">
            <i class="fas fa-shield-alt"></i>
            <h1>Secure<span>Guard</span> Pro</h1>
        </div>
        <nav>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="#hiring">Hire Guards</a></li>
                <li><a href="#guards">Our Guards</a></li>
                <li><a href="#contact">Contact</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="dashboard.php">Dashboard</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <div class="auth-buttons">
            <?php if (isset($_SESSION['user_id'])): ?>
                <span class="welcome-text">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <form method="POST" action="auth.php" style="display: inline;">
                    <input type="hidden" name="action" value="logout">
                    <button type="submit" class="btn btn-outline">Logout</button>
                </form>
            <?php else: ?>
                <button class="btn btn-outline" onclick="showLoginModal()">Login</button>
                <button class="btn btn-primary" onclick="showSignupModal()">Sign Up</button>
            <?php endif; ?>
        </div>
    </div>
</header>

<!-- Login Modal -->
<div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeLoginModal()">&times;</span>
        <h2>Login to Your Account</h2>
        <form method="POST" action="auth.php">
            <input type="hidden" name="action" value="login">
            <div class="form-group">
                <label for="loginEmail">Email Address</label>
                <input type="email" id="loginEmail" name="email" required>
            </div>
            <div class="form-group">
                <label for="loginPassword">Password</label>
                <input type="password" id="loginPassword" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary submit-btn">Login</button>
        </form>
        <p class="modal-switch">
            Don't have an account? <a href="#" onclick="switchToSignup()">Sign up here</a>
        </p>
    </div>
</div>

<!-- Signup Modal -->
<div id="signupModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeSignupModal()">&times;</span>
        <h2>Create New Account</h2>
        <form method="POST" action="auth.php">
            <input type="hidden" name="action" value="signup">
            <div class="form-group">
                <label for="signupUsername">Username</label>
                <input type="text" id="signupUsername" name="username" required>
            </div>
            <div class="form-group">
                <label for="signupEmail">Email Address</label>
                <input type="email" id="signupEmail" name="email" required>
            </div>
            <div class="form-group">
                <label for="signupPassword">Password</label>
                <input type="password" id="signupPassword" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary submit-btn">Create Account</button>
        </form>
        <p class="modal-switch">
            Already have an account? <a href="#" onclick="switchToLogin()">Login here</a>
        </p>
    </div>
</div>
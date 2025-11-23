<?php
// Start session only once - removed duplicate session_start()
require_once 'config/database.php';

// Display success/error messages
if (isset($_SESSION['success'])) {
    echo '<div class="global-message success-message">';
    echo '<i class="fas fa-check-circle"></i> ' . $_SESSION['success'];
    echo '</div>';
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    echo '<div class="global-message error-message">';
    echo '<i class="fas fa-exclamation-circle"></i> ' . $_SESSION['error'];
    echo '</div>';
    unset($_SESSION['error']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecureGuard Pro | Security Guard Hiring System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <h2>Professional Security Guard Hiring Made Simple</h2>
            <p>Find highly-trained, verified security personnel for your business or event. Our platform connects you with the best security professionals in your area.</p>
            <div class="hero-buttons">
                <button class="btn btn-light" onclick="scrollToSection('hiring')">Hire a Guard</button>
                <button class="btn btn-outline" style="border-color: white; color: white;">Learn More</button>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-title">
                <h2>Why Choose SecureGuard Pro</h2>
                <p>We provide a comprehensive solution for all your security guard hiring needs</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <h3>Verified Professionals</h3>
                    <p>All our guards undergo thorough background checks and verification processes.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>24/7 Availability</h3>
                    <p>Find security personnel anytime, day or night, for your urgent needs.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Specialized Training</h3>
                    <p>Our guards receive ongoing training in the latest security protocols.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Hiring Form Section -->
    <section class="hiring-form" id="hiring">
        <div class="container">
            <div class="form-container">
                <div class="form-title">
                    <h2>Hire a Security Guard</h2>
                    <p>Fill out the form below and we'll connect you with qualified security personnel</p>
                </div>
                
                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="success-message">
                        <i class="fas fa-check-circle"></i> <?php echo $_SESSION['success_message']; ?>
                    </div>
                    <?php unset($_SESSION['success_message']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i> <?php echo $_SESSION['error_message']; ?>
                    </div>
                    <?php unset($_SESSION['error_message']); ?>
                <?php endif; ?>

                <form id="hiringForm" action="process-hiring.php" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="firstName">First Name *</label>
                            <input type="text" id="firstName" name="firstName" value="<?php echo isset($_SESSION['form_data']['firstName']) ? $_SESSION['form_data']['firstName'] : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name *</label>
                            <input type="text" id="lastName" name="lastName" value="<?php echo isset($_SESSION['form_data']['lastName']) ? $_SESSION['form_data']['lastName'] : ''; ?>" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" value="<?php echo isset($_SESSION['form_data']['email']) ? $_SESSION['form_data']['email'] : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" value="<?php echo isset($_SESSION['form_data']['phone']) ? $_SESSION['form_data']['phone'] : ''; ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="company">Company Name</label>
                        <input type="text" id="company" name="company" value="<?php echo isset($_SESSION['form_data']['company']) ? $_SESSION['form_data']['company'] : ''; ?>">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="guardType">Type of Guard Needed *</label>
                            <select id="guardType" name="guardType" required>
                                <option value="">Select a type</option>
                                <option value="event" <?php echo (isset($_SESSION['form_data']['guardType']) && $_SESSION['form_data']['guardType'] == 'event') ? 'selected' : ''; ?>>Event Security</option>
                                <option value="corporate" <?php echo (isset($_SESSION['form_data']['guardType']) && $_SESSION['form_data']['guardType'] == 'corporate') ? 'selected' : ''; ?>>Corporate Security</option>
                                <option value="residential" <?php echo (isset($_SESSION['form_data']['guardType']) && $_SESSION['form_data']['guardType'] == 'residential') ? 'selected' : ''; ?>>Residential Security</option>
                                <option value="retail" <?php echo (isset($_SESSION['form_data']['guardType']) && $_SESSION['form_data']['guardType'] == 'retail') ? 'selected' : ''; ?>>Retail Security</option>
                                <option value="personal" <?php echo (isset($_SESSION['form_data']['guardType']) && $_SESSION['form_data']['guardType'] == 'personal') ? 'selected' : ''; ?>>Personal Bodyguard</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="duration">Duration Needed *</label>
                            <select id="duration" name="duration" required>
                                <option value="">Select duration</option>
                                <option value="one-time" <?php echo (isset($_SESSION['form_data']['duration']) && $_SESSION['form_data']['duration'] == 'one-time') ? 'selected' : ''; ?>>One-time Event</option>
                                <option value="short-term" <?php echo (isset($_SESSION['form_data']['duration']) && $_SESSION['form_data']['duration'] == 'short-term') ? 'selected' : ''; ?>>Short-term (1-4 weeks)</option>
                                <option value="long-term" <?php echo (isset($_SESSION['form_data']['duration']) && $_SESSION['form_data']['duration'] == 'long-term') ? 'selected' : ''; ?>>Long-term (1+ months)</option>
                                <option value="permanent" <?php echo (isset($_SESSION['form_data']['duration']) && $_SESSION['form_data']['duration'] == 'permanent') ? 'selected' : ''; ?>>Permanent Position</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="location">Location *</label>
                        <input type="text" id="location" name="location" value="<?php echo isset($_SESSION['form_data']['location']) ? $_SESSION['form_data']['location'] : ''; ?>" placeholder="City, State" required>
                    </div>
                    <div class="form-group">
                        <label for="requirements">Specific Requirements</label>
                        <textarea id="requirements" name="requirements" placeholder="Please describe any specific skills or requirements..."><?php echo isset($_SESSION['form_data']['requirements']) ? $_SESSION['form_data']['requirements'] : ''; ?></textarea>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="agreeTerms" name="agreeTerms" required <?php echo (isset($_SESSION['form_data']['agreeTerms'])) ? 'checked' : ''; ?>>
                        <label for="agreeTerms">I agree to the terms and conditions *</label>
                    </div>
                    <button type="submit" class="btn btn-primary submit-btn">Submit Request</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Guards Section -->
    <section class="guards" id="guards">
        <div class="container">
            <div class="section-title">
                <h2>Our Security Professionals</h2>
                <p>Meet some of our highly-rated security guards</p>
            </div>
            <div class="guards-grid">
                <?php
                // Fetch guards from database
                try {
                    $stmt = $pdo->query("SELECT * FROM guards WHERE available = 1 ORDER BY rating DESC LIMIT 4");
                    $guards = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    if (empty($guards)) {
                        echo "<p>No guards available at the moment.</p>";
                    } else {
                        foreach ($guards as $guard) {
                            echo '
                            <div class="guard-card">
                                <div class="guard-img">
                                    <i class="fas fa-user fa-3x"></i>
                                </div>
                                <div class="guard-info">
                                    <h3>' . htmlspecialchars($guard['name']) . '</h3>
                                    <div class="guard-specialty">' . htmlspecialchars($guard['specialty']) . '</div>
                                    <div class="guard-rating">
                                        ' . generateStars($guard['rating']) . '
                                        <span>' . number_format($guard['rating'], 1) . '/5</span>
                                    </div>
                                    <div class="guard-experience">
                                        <i class="fas fa-briefcase"></i> ' . $guard['experience'] . ' years experience
                                    </div>
                                    <div class="guard-price">$' . number_format($guard['hourly_rate'], 2) . '/hour</div>
                                </div>
                            </div>';
                        }
                    }
                } catch (PDOException $e) {
                    echo "<p>Unable to load guards. Please try again later.</p>";
                }
                
                function generateStars($rating) {
                    $stars = '';
                    $fullStars = floor($rating);
                    $halfStar = ($rating - $fullStars) >= 0.5;
                    
                    for ($i = 0; $i < $fullStars; $i++) {
                        $stars .= '<i class="fas fa-star"></i>';
                    }
                    
                    if ($halfStar) {
                        $stars .= '<i class="fas fa-star-half-alt"></i>';
                        $fullStars++;
                    }
                    
                    for ($i = $fullStars; $i < 5; $i++) {
                        $stars .= '<i class="far fa-star"></i>';
                    }
                    
                    return $stars;
                }
                ?>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    
    <script src="js/script.js"></script>
</body>
</html>
<?php
// Clear form data from session after displaying
if (isset($_SESSION['form_data'])) {
    unset($_SESSION['form_data']);
}
?>
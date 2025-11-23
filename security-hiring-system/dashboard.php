<?php
session_start();
require_once 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Fetch user's hiring requests
$stmt = $pdo->prepare("SELECT * FROM hiring_requests WHERE email = ? ORDER BY submitted_at DESC");
$stmt->execute([$_SESSION['email']]);
$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SecureGuard Pro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <section class="dashboard">
        <div class="container">
            <h1>Welcome to Your Dashboard, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            
            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <h3>My Hiring Requests</h3>
                    <?php if (empty($requests)): ?>
                        <p>You haven't made any hiring requests yet.</p>
                    <?php else: ?>
                        <div class="requests-list">
                            <?php foreach ($requests as $request): ?>
                                <div class="request-item">
                                    <h4><?php echo htmlspecialchars(ucfirst($request['guard_type'])); ?> Guard</h4>
                                    <p><strong>Location:</strong> <?php echo htmlspecialchars($request['location']); ?></p>
                                    <p><strong>Duration:</strong> <?php echo htmlspecialchars($request['duration']); ?></p>
                                    <p><strong>Status:</strong> 
                                        <span class="status-<?php echo $request['status']; ?>">
                                            <?php echo ucfirst($request['status']); ?>
                                        </span>
                                    </p>
                                    <p><strong>Submitted:</strong> <?php echo date('M j, Y', strtotime($request['submitted_at'])); ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="dashboard-card">
                    <h3>Quick Actions</h3>
                    <div class="action-buttons">
                        <a href="index.php#hiring" class="btn btn-primary">Hire New Guard</a>
                        <a href="index.php#guards" class="btn btn-outline">View Available Guards</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
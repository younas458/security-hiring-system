<?php
session_start();
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'login') {
        handleLogin();
    } elseif ($action === 'signup') {
        handleSignup();
    } elseif ($action === 'logout') {
        handleLogout();
    }
}

function handleLogin() {
    global $pdo;
    
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    
    // Validation
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Please fill in all fields.";
        header('Location: index.php');
        exit();
    }
    
    try {
        // Check if user exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password_hash'])) {
            // Login successful
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_type'] = $user['user_type'];
            $_SESSION['success'] = "Login successful! Welcome back, " . $user['username'];
        } else {
            $_SESSION['error'] = "Invalid email or password.";
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Login failed. Please try again.";
    }
    
    header('Location: index.php');
    exit();
}

function handleSignup() {
    global $pdo;
    
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validation
    $errors = [];
    
    if (empty($username) || strlen($username) < 3) {
        $errors[] = "Username must be at least 3 characters long.";
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }
    
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }
    
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }
    
    if (!empty($errors)) {
        $_SESSION['error'] = implode("<br>", $errors);
        header('Location: index.php');
        exit();
    }
    
    try {
        // Check if username or email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        
        if ($stmt->fetch()) {
            $_SESSION['error'] = "Username or email already exists.";
            header('Location: index.php');
            exit();
        }
        
        // Create new user
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password_hash]);
        
        $_SESSION['success'] = "Account created successfully! You can now login.";
        
    } catch (PDOException $e) {
        $_SESSION['error'] = "Registration failed. Please try again.";
    }
    
    header('Location: index.php');
    exit();
}

function handleLogout() {
    session_destroy();
    $_SESSION['success'] = "You have been logged out successfully.";
    header('Location: index.php');
    exit();
}
?>
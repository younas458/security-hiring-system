<?php
$host = 'localhost';
$dbname = 'security_hiring_system';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create tables if they don't exist
    $pdo->exec("CREATE TABLE IF NOT EXISTS hiring_requests (
        id INT AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(100) NOT NULL,
        last_name VARCHAR(100) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        company VARCHAR(255),
        guard_type VARCHAR(50) NOT NULL,
        duration VARCHAR(50) NOT NULL,
        location VARCHAR(255) NOT NULL,
        requirements TEXT,
        status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
        submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    $pdo->exec("CREATE TABLE IF NOT EXISTS guards (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        specialty VARCHAR(100) NOT NULL,
        experience INT NOT NULL,
        rating DECIMAL(2,1) DEFAULT 0.0,
        hourly_rate DECIMAL(6,2) NOT NULL,
        available BOOLEAN DEFAULT TRUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Insert sample guards if table is empty
    $stmt = $pdo->query("SELECT COUNT(*) FROM guards");
    if ($stmt->fetchColumn() == 0) {
        $sampleGuards = [
            ['Michael Johnson', 'Corporate Security', 8, 4.5, 25.00],
            ['Sarah Williams', 'Event Security', 6, 5.0, 30.00],
            ['David Chen', 'Personal Protection', 10, 4.0, 45.00],
            ['James Rodriguez', 'Retail Security', 5, 4.5, 22.00]
        ];
        
        $insertStmt = $pdo->prepare("INSERT INTO guards (name, specialty, experience, rating, hourly_rate) VALUES (?, ?, ?, ?, ?)");
        foreach ($sampleGuards as $guard) {
            $insertStmt->execute($guard);
        }
    }
    
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
<?php
session_start();
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input data
    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $company = filter_input(INPUT_POST, 'company', FILTER_SANITIZE_STRING);
    $guardType = filter_input(INPUT_POST, 'guardType', FILTER_SANITIZE_STRING);
    $duration = filter_input(INPUT_POST, 'duration', FILTER_SANITIZE_STRING);
    $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_STRING);
    $requirements = filter_input(INPUT_POST, 'requirements', FILTER_SANITIZE_STRING);
    $agreeTerms = isset($_POST['agreeTerms']);

    // Store form data in session for repopulation
    $_SESSION['form_data'] = [
        'firstName' => $firstName,
        'lastName' => $lastName,
        'email' => $email,
        'phone' => $phone,
        'company' => $company,
        'guardType' => $guardType,
        'duration' => $duration,
        'location' => $location,
        'requirements' => $requirements,
        'agreeTerms' => $agreeTerms
    ];

    // Validation
    $errors = [];

    if (empty($firstName) || strlen($firstName) < 2) {
        $errors[] = "First name must be at least 2 characters long.";
    }

    if (empty($lastName) || strlen($lastName) < 2) {
        $errors[] = "Last name must be at least 2 characters long.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    if (empty($phone) || !preg_match('/^[\+]?[1-9][\d]{0,15}$/', str_replace([' ', '-', '(', ')'], '', $phone))) {
        $errors[] = "Please enter a valid phone number.";
    }

    if (empty($guardType)) {
        $errors[] = "Please select a guard type.";
    }

    if (empty($duration)) {
        $errors[] = "Please select a duration.";
    }

    if (empty($location) || strlen($location) < 3) {
        $errors[] = "Please enter a valid location.";
    }

    if (!$agreeTerms) {
        $errors[] = "You must agree to the terms and conditions.";
    }

    if (empty($errors)) {
        try {
            // Insert into database
            $stmt = $pdo->prepare("INSERT INTO hiring_requests (first_name, last_name, email, phone, company, guard_type, duration, location, requirements) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$firstName, $lastName, $email, $phone, $company, $guardType, $duration, $location, $requirements]);

            // Clear form data from session
            unset($_SESSION['form_data']);

            // Set success message
            $_SESSION['success_message'] = "Your request has been submitted successfully! We'll contact you within 24 hours.";

            // Send email notification (optional)
            sendNotificationEmail($firstName, $lastName, $email, $guardType, $location);

        } catch (PDOException $e) {
            $_SESSION['error_message'] = "There was an error processing your request. Please try again.";
        }
    } else {
        $_SESSION['error_message'] = implode("<br>", $errors);
    }

    // Redirect back to form
    header('Location: index.php#hiring');
    exit();
}

function sendNotificationEmail($firstName, $lastName, $email, $guardType, $location) {
    $to = "admin@secureguardpro.com";
    $subject = "New Security Guard Hiring Request";
    $message = "
    A new security guard hiring request has been submitted:

    Name: $firstName $lastName
    Email: $email
    Guard Type: $guardType
    Location: $location

    Please review the request in the admin panel.
    ";
    $headers = "From: noreply@secureguardpro.com";

    // In a real application, you would use a proper email library
    // mail($to, $subject, $message, $headers);
}
?>
<?php
session_start();
require 'config.php';

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!$name || !$email || !$password) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all fields.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
        exit;
    }

    if (strlen($password) < 6) {
        echo json_encode(['success' => false, 'message' => 'Password must be at least 6 characters.']);
        exit;
    }


    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    if (!$stmt) { die(json_encode(['success'=>false,'message'=>'Prepare failed: '.$conn->error])); }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Email already registered.']);
        exit;
    }


    $passwordHash = password_hash($password, PASSWORD_DEFAULT);


    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    if (!$stmt) { die(json_encode(['success'=>false,'message'=>'Prepare failed: '.$conn->error])); }
    $stmt->bind_param("sss", $name, $email, $passwordHash);

    if ($stmt->execute()) {
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['email'] = $email;
        echo json_encode(['success' => true]);
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error: '.$stmt->error]);
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logi Track Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="neural-background">
        <div class="neural-node"></div>
        <div class="neural-node"></div>
        <div class="neural-node"></div>
        <div class="neural-node"></div>
        <div class="neural-node"></div>
    </div>

    <div class="login-container">
        <div class="login-card">
            <div class="ai-glow"></div>
            
            <div class="login-header">
                <div class="ai-logo">
                    <div class="logo-core">
                        <!-- Forklift Delivery Logo -->
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                <!-- Forklift body -->
                <path d="M4 6h8v8H4z"
                      stroke="currentColor"
                      stroke-width="2.5"
                      stroke-linejoin="round"/>

                <!-- Cabin -->
                <path d="M8 6V4h4v6"
                      stroke="currentColor"
                      stroke-width="2.5"
                      stroke-linecap="round"/>

                <!-- Mast -->
                <path d="M14 4v12"
                      stroke="currentColor"
                      stroke-width="2.5"
                      stroke-linecap="round"/>

                <!-- Forks -->
                <path d="M14 14h5M14 16h4"
                      stroke="currentColor"
                      stroke-width="2.5"
                      stroke-linecap="round"/>

                <!-- Wheels -->
                <circle cx="7" cy="17" r="2"
                        stroke="currentColor"
                        stroke-width="2.5"/>
                <circle cx="13" cy="17" r="2"
                        stroke="currentColor"
                        stroke-width="2.5"/>
            </svg>
        </div>

        <div class="logo-rings">
            <div class="ring ring-1"></div>
            <div class="ring ring-2"></div>
            <div class="ring ring-3"></div>
        </div>
            </div>
                <h1>Logi Track</h1>
                <p>Track your package right now!</p>
            </div>
            

        <form id="signupForm" method="POST" novalidate>
    <div class="smart-field">
        <div class="field-background"></div>
        <input type="text" id="name" name="name" required placeholder=" ">
        <label for="name">Full Name</label>
        <span class="error-message" id="nameError"></span>
    </div>

    <div class="smart-field">
        <div class="field-background"></div>
        <input type="email" id="email" name="email" required placeholder=" ">
        <label for="email">Email Address</label>
        <span class="error-message" id="emailError"></span>
    </div>

    <div class="smart-field">
        <div class="field-background"></div>
        <input type="password" id="password" name="password" required placeholder=" ">
        <label for="password">Password</label>
        <button type="button" class="smart-toggle" id="passwordToggle" aria-label="Toggle password visibility">

        </button>
        <span class="error-message" id="passwordError"></span>
    </div>

    <button type="submit" class="neural-button">
        <div class="button-bg"></div>
        <span class="button-text">Sign Up</span>
        <div class="button-loader">
            <div class="neural-spinner">
                <div class="spinner-segment"></div>
                <div class="spinner-segment"></div>
                <div class="spinner-segment"></div>
            </div>
        </div>
        <div class="button-glow"></div>
    </button>
</form>

<div class="popup-error" id="errorPopup"></div>
<div class="success-neural" id="successMessage">
    <h3>Neural Link Established</h3>
    <p>Account created! Redirecting...</p>
</div>




        <div class="success-neural" id="successMessage">
            <h3>Neural Link Established</h3>
            <p>Accessing your AI workspace...</p>
        </div>

            <div class="auth-separator">
                <div class="separator-line"></div>
                <span class="separator-text">or connect via</span>
                <div class="separator-line"></div>
            </div>

            <div class="neural-social">
                <button type="button" class="social-neural">
                    <div class="social-bg"></div>
                    <svg width="16" height="16" viewBox="0 0 16 16">
                        <path fill="#4285F4" d="M14.9 8.161c0-.476-.039-.954-.118-1.421H8.021v2.681h3.833a3.321 3.321 0 01-1.431 2.161v1.785h2.3c1.349-1.25 2.177-3.103 2.177-5.206z"/>
                        <path fill="#34A853" d="M8.021 15c1.951 0 3.57-.65 4.761-1.754l-2.3-1.785c-.653.447-1.477.707-2.461.707-1.887 0-3.487-1.274-4.057-2.991H1.617V11.1C2.8 13.481 5.282 15 8.021 15z"/>
                        <path fill="#FBBC05" d="M3.964 9.177a4.97 4.97 0 010-2.354V4.9H1.617a8.284 8.284 0 000 7.623l2.347-1.346z"/>
                        <path fill="#EA4335" d="M8.021 3.177c1.064 0 2.02.375 2.75 1.111l2.041-2.041C11.616 1.016 9.97.446 8.021.446c-2.739 0-5.221 1.519-6.404 3.9l2.347 1.346c.57-1.717 2.17-2.515 4.057-2.515z"/>
                    </svg>
                    <span>Google</span>
                    <div class="social-glow"></div>
                </button>
            </div>

            <div class="signup-section">
                <span>Already have an account? </span>
                <a href="login.php" class="neural-signup">Sign In</a>
            </div>

            <div class="success-neural" id="successMessage">
                <div class="success-core">
                    <div class="success-rings">
                        <div class="success-ring"></div>
                        <div class="success-ring"></div>
                        <div class="success-ring"></div>
                    </div>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3>Neural Link Established</h3>
                <p>Accessing your AI workspace...</p>
            </div>
        </div>
    </div>

    
    <script src="form-utils.js"></script>
    <script src="neural-ui.js"></script>
    <script src="script.js"></script>
</body>
</html>
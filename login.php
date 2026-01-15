<?php
session_start();
require 'config.php';

$errors = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $errors[] = "Please fill in all fields.";
    } else {
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $email;
                $success = true;
                echo json_encode(['success' => true]);
                exit();
            } else {
                echo json_encode(['success' => false, 'message' => 'Incorrect email or password.']);
                exit();
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Incorrect email or password.']);
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logi Track Login</title>
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
            

        <form class="login-form" id="loginForm" method="POST" novalidate>
            <div class="smart-field" data-field="email">
                <div class="field-background"></div>
                <input type="email" id="email" name="email" required autocomplete="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
                <label for="email">Email Address</label>
                <div class="ai-indicator"><div class="ai-pulse"></div></div>
                <div class="field-completion"></div>
                <span class="error-message" id="emailError">
                    <?php if (!empty($errors)) echo htmlspecialchars($errors[0]); ?>
                </span>
            </div>

            <div class="smart-field" data-field="password">
                <div class="field-background"></div>
                <input type="password" id="password" name="password" required autocomplete="current-password">
                <label for="password">Password</label>
                <button type="button" class="smart-toggle" id="passwordToggle" aria-label="Toggle password visibility">
                    <svg class="toggle-show" width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path d="M9 3.75c-3.15 0-5.85 1.89-7.02 4.72a.75.75 0 000 .56c1.17 2.83 3.87 4.72 7.02 4.72s5.85-1.89 7.02-4.72a.75.75 0 000-.56C14.85 5.64 12.15 3.75 9 3.75zM9 12a3 3 0 110-6 3 3 0 010 6z" fill="currentColor"/>
                    </svg>
                    <svg class="toggle-hide" width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path d="M3.53 2.47a.75.75 0 00-1.06 1.06l11 11a.75.75 0 101.06-1.06l-2.82-2.82c.8-.67 1.5-1.49 2.04-2.42a.75.75 0 000-.56C12.58 4.84 10.89 3.75 9 3.75c-.69 0-1.36.1-2 .29L3.53 2.47zM7.974 5.847L10.126 8a1.5 1.5 0 01-2.126-2.126l-.026-.027z" fill="currentColor"/>
                    </svg>
                </button>
                <div class="ai-indicator"><div class="ai-pulse"></div></div>
                <div class="field-completion"></div>
                <span class="error-message" id="passwordError"></span>
            </div>

            <div class="form-options">
                <label class="smart-checkbox">
                    <input type="checkbox" id="remember" name="remember">
                    <span class="checkbox-ai">
                        <div class="checkbox-core"></div>
                        <svg width="12" height="10" viewBox="0 0 12 10" fill="none">
                            <path d="M1 5l3 3 7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span class="checkbox-text">Remember this session</span>
                </label>
                <a href="#" class="neural-link">Reset access</a>
            </div>

            <button type="submit" class="neural-button">
                <div class="button-bg"></div>
                <span class="button-text">Log in</span>
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


        <!-- Success Animation -->
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
                <span>Don't have an account? </span>
                <a href="signup.php" class="neural-signup">Sign Up</a>
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
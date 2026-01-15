<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Logi Track — Welcome</title>
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

<section class="landing-container">
    <header class="landing-header">
        <div class="ai-logo">
            <div class="logo-core">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none">
                    <rect x="3" y="6" width="9" height="8" rx="1" stroke="currentColor" stroke-width="3"/>
                    <path d="M8 6V3h5v7M14 3v13M14 15h6M14 18h5"
                          stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                    <circle cx="7" cy="19" r="2.3" fill="currentColor"/>
                    <circle cx="13" cy="19" r="2.3" fill="currentColor"/>
                </svg>
            </div>
            <div class="logo-rings">
                <div class="ring ring-1"></div>
                <div class="ring ring-2"></div>
                <div class="ring ring-3"></div>
            </div>
        </div>

        <h1>Welcome to Logi Track</h1>
        <p>Start tracking your shipments with real-time intelligence</p>
    </header>

    <div class="landing-actions">
        <a href="login.php" class="neural-button">
            <div class="button-bg"></div>
            <span class="button-text">Log in</span>
            <div class="button-glow"></div>
        </a>
    </div>
</section>

<script src="neural-ui.js"></script>
<script src="script.js"></script>
</body>
</html>

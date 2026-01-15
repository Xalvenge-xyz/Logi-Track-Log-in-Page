<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Dashboard — Logi Track</title>
<link rel="stylesheet" href="style.css" />
</head>
<body>

<div class="neural-background">
    <div class="neural-node"></div>
    <div class="neural-node"></div>
    <div class="neural-node"></div>
    <div class="neural-node"></div>
    <div class="neural-node"></div>
</div>

<div class="dashboard-container">

    <aside class="sidebar">
        <h2>Logi Track</h2>
        <p>Demo Only - Static Data</p>
        <nav>
            <a class="active">Dashboard</a>
            <a>My Shipments</a>
            <a>Fleet</a>
            <a>Analytics</a>
            <a>Settings</a>
            <a href="index.php">Log out</a>
        </nav>
    </aside>

    <main class="dashboard-main">
        <h1>Welcome back, <?php echo htmlspecialchars($_SESSION['email']); ?>!</h1>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Active Shipments</h3>
                <span>12</span>
            </div>
            <div class="stat-card">
                <h3>In Transit</h3>
                <span>8</span>
            </div>
            <div class="stat-card">
                <h3>Delivered</h3>
                <span>124</span>
            </div>
        </div>

        <div class="activity-card">
            <h3>Recent Activity</h3>
            
            <ul>
                <li>📦 Package #48392 departed hub</li>
                <li>🚚 Vehicle TR-21 arrived Cebu</li>
                <li>✅ Package #48211 delivered</li>
            </ul>
        </div>
    </main>

</div>

</body>
</html>

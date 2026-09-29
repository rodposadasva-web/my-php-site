<?php
// Start the session to gain access to active session data token layers
session_start();

// 1. Clear all session global variable references completely
$_SESSION = array();

// 2. Erase the active tracking session cookie if it exists
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 3. Destroy the actual server session execution thread completely
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logged Out - CCNHS Research Portal</title>
    <link rel="icon" href="img/CCNHS.png">
    <!-- Bootstrap 5 CSS Framework CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons Font Library CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #f4f6f9;
            height: 100vh;
        }
        .login-style-card {
            max-width: 450px;
            width: 100%;
        }
        .school-logo {
            width: 100px;
            height: 100px;
            object-fit: contain;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center p-3">

<div class="login-style-card">
    <!-- Main Form Card Container mirroring typical Login Panel UIs -->
    <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5 bg-white">
        
        <!-- School Logo Presentation Header -->
        <div class="text-center mb-4">
            <img src="img/CCNHS2.png" alt="CCNHS Logo" class="school-logo mb-3">
            <h4 class="fw-bold text-dark mb-1">CCNHS Research Portal</h4>
            <span class="text-muted small text-uppercase tracking-wider">Session Terminated</span>
        </div>

        <hr class="text-muted opacity-25 mb-4">

        <!-- Core Message Body Section -->
        <div class="text-center">
            <h5 class="fw-bold text-dark mb-3">Thank you for logging out.</h5>
            <p class="text-secondary small lh-base mb-4">
                Your session has been securely closed. If you want to explore the CCNHS research articles, click the button below to sign back into your account.
            </p>
        </div>

        <!-- Primary Call to Action Button Layout Router -->
        <div class="mb-2">
            <a href="login.php" class="btn text-white w-100 py-2.5 fw-semibold rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2" style="background-color: #7e3af2; border: none;">
                <i class="bi bi-box-arrow-in-right"></i> Click Here to Log In
            </a>
        </div>
        
    </div>

    <!-- Interface Footer Information Utility Line -->
    <div class="text-center mt-4 text-muted extra-small" style="font-size: 0.8rem;">
        &copy; <?php echo date('Y'); ?> CCNHS Senior High School Research Archive
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
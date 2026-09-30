<?php
session_start();
include 'database.php';

if (isset($_POST['login'])) {
    // 1. Change from 'email' to match your form input field name 'username'
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password']; 

    $user = null;
    $role = '';
    $uid_column = '';

    // 🔍 Step 1: Check the Students Table using student_uid
    $student_check = mysqli_query($conn, "SELECT * FROM portal_students WHERE student_uid = '$username'");
    if (mysqli_num_rows($student_check) > 0) {
        $user = mysqli_fetch_assoc($student_check);
        $role = 'student';
        $uid_column = 'student_uid';
    } 
    // 🔍 Step 2: Check Faculty Table using faculty_uid
    else {
        $faculty_check = mysqli_query($conn, "SELECT * FROM portal_faculty WHERE faculty_uid = '$username'");
        if (mysqli_num_rows($faculty_check) > 0) {
            $user = mysqli_fetch_assoc($faculty_check);
            $role = 'faculty';
            $uid_column = 'faculty_uid';
        } 
        // 🔍 Step 3: Check Non-Teaching Table using staff_uid
        else {
            $nt_check = mysqli_query($conn, "SELECT * FROM portal_non_teaching WHERE staff_uid = '$username'");
            if (mysqli_num_rows($nt_check) > 0) {
                $user = mysqli_fetch_assoc($nt_check);
                $role = 'non-teaching';
                $uid_column = 'staff_uid';
            } 
            // 🔍 Step 4: Lastly, check Admin Table using admin_uid
            else {
                $admin_check = mysqli_query($conn, "SELECT * FROM portal_admin WHERE admin_uid = '$username'");
                if (mysqli_num_rows($admin_check) > 0) {
                    $user = mysqli_fetch_assoc($admin_check);
                    $role = 'admin';
                    $uid_column = 'admin_uid';
                }
            }
        }
    }

    // 🔑 Step 5: Verify password if a user record was found
    // NOTE: Changed to plain-text check ($password == $user['password']) to match your system settings.
    // If you hash your passwords later, change this back to password_verify().
    if ($user && $password == $user['password']) {
        
        // Store structural classification data tokens inside session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user[$uid_column]; // Matches your 'username' label
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $role;

        // Redirect dynamically based on determined role context
        if ($role === 'admin') {
            header("Location: admin/admin_dashboard.php");
        } else {
            header("Location: dashboard.php");
        }
        exit();
    } else {
        echo "<script>
        alert('Invalid Alphanumeric ID or Password');
        window.location.href='login.php';
        </script>";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | CCNHS Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="img/CCNHS.png">
    <link rel="stylesheet" href="css/login_design.css">
</head>
<body class="bg-light d-flex align-items-center">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card login-card">
                    <div class="row g-0">
                        <div class="col-md-6 d-none d-md-flex image-section">
                            <div class="mb-4">
                                <img src="img/CCNHS2.png" alt="Logo" style="width: 80px;">
                            </div>
                            <h1 class="display-5 fw-bold text-white mb-3">Welcome to <span class="text-primary">CCNHS</span></h1>
                            <p class="lead text-light">CCNHS Center for Active Research and Innovation Navigating All Areas</p>
                            <div class="mt-auto">
                                <small class="text-white-50">© 2026 Calasiao Comprehensive National High School</small>
                            </div>
                        </div>

                        <div class="col-md-6 form-section">
                            <div class="text-center mb-5 d-md-none">
                                <img src="img/CCNHS.png" alt="Logo" class="mb-3" style="width: 60px;">
                                <h3 class="fw-bold">CCNHS Research Portal</h3>
                            </div>
                            
                            <div class="mb-4">
                                <h2 class="fw-bold">Sign In</h2>
                                <p class="text-muted">Enter your credentials to manage your research.</p>
                            </div>

                            <form method="POST" action="login_process.php">
    <div class="form-floating mb-3">
        <input type="text" name="username" class="form-control rounded-3" id="floatingUser" placeholder="Username" required>
        <label for="floatingUser"><i class="fa fa-user me-2"></i>Username</label>
    </div>

    <div class="form-floating mb-4">
        <input type="password" name="password" class="form-control rounded-3" id="floatingPassword" placeholder="Password" required>
        <label for="floatingPassword"><i class="fa fa-lock me-2"></i>Password</label>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4 small">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="togglePassword">
            <label class="form-check-label text-muted" for="togglePassword">Show password</label>
        </div>
    </div>

    <button type="submit" name="login" class="btn btn-primary w-100 btn-login rounded-pill shadow-sm mb-3">
        Sign In <i class="fa fa-sign-in-alt ms-2"></i>
    </button>
    <a href="guest_dashboard.php" class="btn btn-secondary w-100 rounded-pill shadow-sm mb-3 d-flex align-items-center justify-content-center" style="background-color: #6c757d; border-color: #6c757d; padding: 0.375rem 0.75rem;">
        Continue as Guest <i class="fa fa-user-secret ms-2"></i>
    </a>
    
    <div class="text-center mt-4">
        <p class="text-muted small">Need help accessing your account? <br> Contact the IT administrator.</p>
    </div>
</form>
                        </div>
                    </div> </div> </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Toggle Password Visibility Logic
    document.getElementById('togglePassword').addEventListener('change', function() {
        const passwordField = document.getElementById('floatingPassword');
        
        // Switch the input element type attribute based on checkbox check state
        if (this.checked) {
            passwordField.type = 'text';
        } else {
            passwordField.type = 'password';
        }
    });
    </script>
</body>
</html>

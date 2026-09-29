<?php
session_start();
include "database.php";

if (isset($_POST['login'])) {

    // Clean user inputs to protect against basic SQL injection
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = $_POST['password']; 

    $userData = null;
    $role = '';
    $uid_column = '';

    // 🔍 1. Search the Students Table
    $student_query = "SELECT * FROM portal_students WHERE student_uid='$user'";
    $student_result = mysqli_query($conn, $student_query);

    if (mysqli_num_rows($student_result) > 0) {
        $userData = mysqli_fetch_assoc($student_result);
        $role = 'student';
        $uid_column = 'student_uid';
    } 
    // 🔍 2. Search Faculty Table if not found in students
    else {
        $faculty_query = "SELECT * FROM portal_faculty WHERE faculty_uid='$user'";
        $faculty_result = mysqli_query($conn, $faculty_query);

        if (mysqli_num_rows($faculty_result) > 0) {
            $userData = mysqli_fetch_assoc($faculty_result);
            $role = 'faculty';
            $uid_column = 'faculty_uid';
        } 
        // 🔍 3. Search Non-Teaching Table if still not found
        else {
            $nt_query = "SELECT * FROM portal_non_teaching WHERE staff_uid='$user'";
            $nt_result = mysqli_query($conn, $nt_query);

            if (mysqli_num_rows($nt_result) > 0) {
                $userData = mysqli_fetch_assoc($nt_result);
                $role = 'non-teaching';
                $uid_column = 'staff_uid';
            } 
            // 🔍 4. Finally, search the Admin Table
            else {
                $admin_query = "SELECT * FROM portal_admin WHERE admin_uid='$user'";
                $admin_result = mysqli_query($conn, $admin_query);

                if (mysqli_num_rows($admin_result) > 0) {
                    $userData = mysqli_fetch_assoc($admin_result);
                    $role = 'admin';
                    $uid_column = 'admin_uid';
                }
            }
        }
    }

    // 🔑 5. Verify the password and establish session values if a user was found
    // Note: If you are using plain text passwords right now, use: ($userData && $pass == $userData['password'])
    // If you are using secure hashes, use: ($userData && password_verify($pass, $userData['password']))
    if ($userData && $pass == $userData['password']) {

        // Store consistent session tokens across your portal
        $_SESSION['user_id'] = $userData['id'];
        $_SESSION['username'] = $userData[$uid_column]; // e.g., 26-CC-0001
        $_SESSION['user_name'] = $userData['name'];
        $_SESSION['user_role'] = $role;

        // Route routing directives by determined classification profile
        if ($role == "admin") {
            header("Location: admin/admin_dashboard.php");
        } else {
            header("Location: dashboard.php");
        }
        exit();

    } else {
        // Triggers JavaScript error modal if no table entry matched credentials
        echo "<script>
        alert('Invalid Alphanumeric ID or Password');
        window.location.href='login.php';
        </script>";
    }
}
?>
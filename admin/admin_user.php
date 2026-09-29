<?php
include '../database.php';

$message = "";
$messageClass = "";


// --- PROCESSING 2: EDIT ACCOUNT DETAILS ---
if (isset($_POST['edit_user'])) {
    $old_uid = mysqli_real_escape_string($conn, $_POST['old_uid']);
    $new_uid = mysqli_real_escape_string($conn, $_POST['uid']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = $_POST['role'];

    // Determine target table and key column configurations
    if ($role === 'student') { $table = 'portal_students'; $col = 'student_uid'; }
    elseif ($role === 'faculty') { $table = 'portal_faculty'; $col = 'faculty_uid'; }
    elseif ($role === 'non-teaching') { $table = 'portal_non_teaching'; $col = 'staff_uid'; }
    elseif ($role === 'admin') { $table = 'portal_admin'; $col = 'admin_uid'; }

    // Check if the user specified a new password or wants to keep the old one
    if (!empty($password)) {
        $query = "UPDATE $table SET $col = '$new_uid', name = '$name', email = '$email', password = '$password' WHERE $col = '$old_uid'";
    } else {
        $query = "UPDATE $table SET $col = '$new_uid', name = '$name', email = '$email' WHERE $col = '$old_uid'";
    }

    if (mysqli_query($conn, $query)) {
        $message = "Account updated successfully!";
        $messageClass = "alert-success";
    } else {
        $message = "Update Error: " . mysqli_error($conn);
        $messageClass = "alert-danger";
    }
}

// --- PROCESSING 3: DELETE ACCOUNT ---
if (isset($_GET['delete_uid']) && isset($_GET['from_role'])) {
    $del_uid = mysqli_real_escape_string($conn, $_GET['delete_uid']);
    $from_role = $_GET['from_role'];

    if ($from_role === 'student') { $query = "DELETE FROM portal_students WHERE student_uid = '$del_uid'"; }
    elseif ($from_role === 'faculty') { $query = "DELETE FROM portal_faculty WHERE faculty_uid = '$del_uid'"; }
    elseif ($from_role === 'non-teaching') { $query = "DELETE FROM portal_non_teaching WHERE staff_uid = '$del_uid'"; }
    elseif ($from_role === 'admin') { $query = "DELETE FROM portal_admin WHERE admin_uid = '$del_uid'"; }

    if (mysqli_query($conn, $query)) {
        $message = "Account deleted completely.";
        $messageClass = "alert-warning";
    } else {
        $message = "Deletion Failure: " . mysqli_error($conn);
        $messageClass = "alert-danger";
    }
}

// --- FETCH ALL RECORDS VIA DATABASE TABLES UNION MERGE ---
$union_query = "
    SELECT student_uid AS uid, name, email, 'student' AS role FROM portal_students
    UNION ALL
    SELECT faculty_uid AS uid, name, email, 'faculty' AS role FROM portal_faculty
    UNION ALL
    SELECT staff_uid AS uid, name, email, 'non-teaching' AS role FROM portal_non_teaching
    UNION ALL
    SELECT admin_uid AS uid, name, email, 'admin' AS role FROM portal_admin
    ORDER BY name ASC";

$result = mysqli_query($conn, $union_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Management - CCNHS Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="../img/admin.png"/>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #fff;
            border-right: 1px solid #dee2e6;
        }
        .sidebar .nav-link {
            color: #495057;
            font-weight: 500;
            padding: 0.75rem 1.25rem;
            border-radius: 0.375rem;
            margin-bottom: 0.25rem;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background-color: #f0e6ff;
            color: #6f42c1;
        }
        .sidebar .nav-link.active {
            border-left: 4px solid #7e3af2;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }
        .avatar-placeholder {
            width: 40px;
            height: 40px;
            background-color: #e9ecef;
            color: #495057;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse p-3 d-flex flex-column" style="min-height: 100vh;">
            <div>
                <div class="d-flex align-items-center mb-4 ps-2">
                    <a class="text-decoration-none fs-5 fw-bold text-dark" href="admin_dashboard.php">CCNHS Admin</a>
                </div>
                <ul class="nav flex-column gap-1">
                    <li class="nav-item"><a class="nav-link" href="admin_dashboard.php"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_spotlight.php"><i class="bi bi-star-fill me-2 text-warning"></i> Spotlight Feature</a></li>
                    <li class="nav-item"><a class="nav-link active" href="admin_user.php"><i class="bi bi-people me-2"></i> Manage Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_viewRequest.php"><i class="bi bi-file-earmark-lock2 me-2"></i> DL Requests</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_research.php"><i class="bi bi-file-earmark-text me-2"></i> Submission Queue</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_published.php"><i class="bi bi-file-earmark-text me-2"></i> Published Articles</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_announcements.php"><i class="bi bi-megaphone me-2"></i> Announcements</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_news.php"><i class="bi bi-megaphone me-2"></i> News</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_policies.php"><i class="bi bi-file-earmark-ruled me-2"></i> Policies</a></li>
                </ul>
            </div>
            <hr>
            <div class="d-flex align-items-center mb-4 ps-2">
                <a href="../logout_page.php" class="nav-link text-danger fw-semibold px-2 py-1 d-block">
                    <i class="bi bi-box-arrow-right me-2"></i> Sign Out
                </a>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 fw-bold text-dark mb-1 pt-1">User Management</h1>
        <a href="admin_bulk_import.php" class="btn btn-primary d-inline-flex align-items-center text-white text-decoration-none" style="background-color: #7e3af2; border: none;">
            <i class="bi bi-file-earmark-spreadsheet-fill me-2"></i> Bulk Import Accounts
        </a>
    </div>

    <?php if (!empty($message)): ?>
        <div class="alert <?php echo $messageClass; ?> alert-dismissible fade show" role="alert">
            <?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card mb-4 border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="table-responsive">
            <table class="table align-middle mb-0 table-hover">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4 text-muted small text-uppercase">Account Holder Details</th>
                        <th class="text-muted small text-uppercase">Email Address</th>
                        <th class="text-muted small text-uppercase">Role</th>
                        <th class="text-end pe-4 text-muted small text-uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-placeholder" style="width: 38px; height: 38px; background-color: #f0e6ff; color: #7e3af2; display: flex; align-items: center; justify-content: center; border-radius: 50%; font-weight: bold;">
                                            <?php echo strtoupper(substr($row['name'], 0, 1)); ?>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark"><?php echo htmlspecialchars($row['name']); ?></div>
                                            <small class="text-muted font-monospace" style="font-size: 0.8rem;">ID: <?php echo htmlspecialchars($row['uid']); ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-secondary small"><?php echo htmlspecialchars($row['email']); ?></span>
                                </td>
                                <td>
                                    <?php 
                                        if ($row['role'] == 'admin') {
                                            $badgeClass = 'bg-danger-subtle text-danger'; $displayedRole = 'Admin';
                                        } elseif ($row['role'] == 'faculty') {
                                            $badgeClass = 'bg-primary-subtle text-primary'; $displayedRole = 'Faculty';
                                        } elseif ($row['role'] == 'non-teaching') {
                                            $badgeClass = 'bg-warning-subtle text-dark'; $displayedRole = 'Non-Teaching';
                                        } else {
                                            $badgeClass = 'bg-success-subtle text-success'; $displayedRole = 'Student'; 
                                        }
                                    ?>
                                    <span class="badge <?php echo $badgeClass; ?> px-2.5 py-1 rounded-pill small fw-semibold">
                                        <?php echo $displayedRole; ?>
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-secondary edit-btn" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editUserModal"
                                                data-uid="<?php echo htmlspecialchars($row['uid']); ?>"
                                                data-name="<?php echo htmlspecialchars($row['name']); ?>"
                                                data-email="<?php echo htmlspecialchars($row['email']); ?>"
                                                data-role="<?php echo htmlspecialchars($row['role']); ?>">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <a href="admin_user.php?delete_uid=<?php echo urlencode($row['uid']); ?>&from_role=<?php echo $row['role']; ?>" 
                                           class="btn btn-outline-danger" 
                                           onclick="return confirm('Are you sure you want to delete this account?');">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted small">No systematic registration logs found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>



<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="admin_user.php" method="POST" class="modal-content border-0 shadow-lg">
            <input type="hidden" name="old_uid" id="edit-old-uid">
            <input type="hidden" name="role" id="edit-role-hidden">
            
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Modify Account Profiles</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body d-flex flex-column gap-3">
                <div class="alert alert-secondary py-2 px-3 small mb-0">
                    <i class="bi bi-info-circle-fill me-1 text-primary"></i> Account classification role categories are locked during modifications.
                </div>
                <div>
                    <label class="form-label fw-semibold text-secondary small">Unique Identifier (UID)</label>
                    <input type="text" name="uid" id="edit-uid" class="form-control" required>
                </div>
                <div>
                    <label class="form-label fw-semibold text-secondary small">Full Name</label>
                    <input type="text" name="name" id="edit-name" class="form-control" required>
                </div>
                <div>
                    <label class="form-label fw-semibold text-secondary small">Email Address</label>
                    <input type="email" name="email" id="edit-email" class="form-control" required>
                </div>
                <div>
                    <label class="form-label fw-semibold text-secondary small">Password <span class="text-muted font-normal">(Leave completely blank to retain existing string)</span></label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••">
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" name="edit_user" class="btn text-white px-4" style="background-color: #7e3af2;">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const editButtons = document.querySelectorAll(".edit-btn");
    editButtons.forEach(button => {
        button.addEventListener("click", function() {
            // Pull tracking attributes from clicked element node
            const uid = this.getAttribute("data-uid");
            const name = this.getAttribute("data-name");
            const email = this.getAttribute("data-email");
            const role = this.getAttribute("data-role");

            // Feed elements in the update target modal
            document.getElementById("edit-old-uid").value = uid;
            document.getElementById("edit-uid").value = uid;
            document.getElementById("edit-name").value = name;
            document.getElementById("edit-email").value = email;
            document.getElementById("edit-role-hidden").value = role;
        });
    });
});
</script>
</body>
</html>
<?php
include '../database.php';

// User Role Counts from individual tables
$faculty_q = mysqli_query($conn, "SELECT COUNT(*) as total FROM portal_faculty");
$total_faculty = mysqli_fetch_assoc($faculty_q)['total'];

$student_q = mysqli_query($conn, "SELECT COUNT(*) as total FROM portal_students");
$total_students = mysqli_fetch_assoc($student_q)['total'];

$nt_q = mysqli_query($conn, "SELECT COUNT(*) as total FROM portal_non_teaching");
$total_non_teaching = mysqli_fetch_assoc($nt_q)['total'];

// Content Counts
$res_q = mysqli_query($conn, "SELECT COUNT(*) as total FROM research_articles");
$total_research = mysqli_fetch_assoc($res_q)['total'];

$ann_q = mysqli_query($conn, "SELECT COUNT(*) as total FROM announcements");
$total_announcements = mysqli_fetch_assoc($ann_q)['total'];


$dash_msg = "";
if (isset($_GET['download_action']) && isset($_GET['req_id'])) {
    $req_id = intval($_GET['req_id']);
    $action = $_GET['download_action'];
    
    if ($action === 'grant') {
        $conn->query("UPDATE download_requests SET status = 'Approved' WHERE id = $req_id");
        $dash_msg = "<div class='alert alert-success'>Download permission granted successfully!</div>";
    } elseif ($action === 'deny') {
        $conn->query("UPDATE download_requests SET status = 'Denied' WHERE id = $req_id");
        $dash_msg = "<div class='alert alert-warning'>Download request rejected.</div>";
    }
}

// Fetch only active pending requests
$requests_query = "SELECT dr.id, dr.status, dr.requested_at, ra.title, ra.author 
                   FROM download_requests dr 
                   JOIN research_articles ra ON dr.article_id = ra.id 
                   WHERE dr.status = 'Pending' 
                   ORDER BY dr.id DESC";
$requests_result = $conn->query($requests_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - CCNHS Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="../img/admin.png"/>
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background-color: #fff; border-right: 1px solid #dee2e6; }
        .sidebar .nav-link { color: #495057; font-weight: 500; padding: 0.75rem 1.25rem; border-radius: 0.375rem; margin-bottom: 0.25rem; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: #f0e6ff; color: #6f42c1; }
        .sidebar .nav-link.active { border-left: 4px solid #7e3af2; border-top-left-radius: 0; border-bottom-left-radius: 0; }
        .thumbnail-img { width: 50px; height: 50px; object-fit: cover; border-radius: 6px; background-color: #e9ecef; }
    </style>
    <link rel="stylesheet" href="../css/admin_dash_design.css">
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
                    <li class="nav-item"><a class="nav-link active" href="admin_dashboard.php"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_spotlight.php"><i class="bi bi-star-fill me-2 text-warning"></i> Spotlight Feature</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_user.php"><i class="bi bi-people me-2"></i> Manage Users</a></li>
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

            <div class="pt-3 pb-2 mb-3 border-bottom">
                 <h1 class="h2 fw-bold text-dark mb-1">Dashboard</h1>
            </div>

           <h5 class="mb-3 text-muted small text-uppercase fw-bold tracking-wide">User Management</h5>
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-lg-4">
        <div class="card border-0 shadow-sm rounded-3 p-3 border-start border-primary border-4">
            <div class="d-flex align-items-center">
                <div class="stat-card-icon bg-primary-subtle text-primary mb-0 me-3" style="padding: 0.5rem 0.75rem; border-radius: 0.375rem;">
                    <i class="bi bi-person-workspace fs-4"></i>
                </div>
                <div>
                    <p class="text-muted small mb-1 fw-medium">Total Faculty</p>
                    <h3 class="mb-0 fw-bold text-dark"><?php echo $total_faculty; ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-4">
        <div class="card border-0 shadow-sm rounded-3 p-3 border-start border-success border-4">
            <div class="d-flex align-items-center">
                <div class="stat-card-icon bg-success-subtle text-success mb-0 me-3" style="padding: 0.5rem 0.75rem; border-radius: 0.375rem;">
                    <i class="bi bi-mortarboard-fill fs-4"></i>
                </div>
                <div>
                    <p class="text-muted small mb-1 fw-medium">Total Students</p>
                    <h3 class="mb-0 fw-bold text-dark"><?php echo $total_students; ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-lg-4">
        <div class="card border-0 shadow-sm rounded-3 p-3 border-start border-purple border-4" style="border-left-color: #7e3af2 !important;">
            <div class="d-flex align-items-center">
                <div class="stat-card-icon mb-0 me-3" style="background-color: #f0e6ff; color: #7e3af2; padding: 0.5rem 0.75rem; border-radius: 0.375rem;">
                    <i class="bi bi-people-fill fs-4"></i>
                </div>
                <div>
                    <p class="text-muted small mb-1 fw-medium">Non-Teaching Staff</p>
                    <h3 class="mb-0 fw-bold text-dark"><?php echo $total_non_teaching; ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>

            <h5 class="mb-3 text-muted small text-uppercase fw-bold tracking-wide">Content Management</h5>
            <div class="row g-3 mb-5">
                <div class="col-12 col-sm-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 border-start border-info border-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-card-icon bg-info-subtle text-info mb-0 me-3">
                                <i class="bi bi-journal-text"></i>
                            </div>
                            <div>
                                <p class="text-muted small mb-1 fw-medium">Research Articles</p>
                                <h3 class="mb-0 fw-bold text-dark"><?php echo $total_research; ?></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 border-start border-danger border-4">
                        <div class="d-flex align-items-center">
                            <div class="stat-card-icon bg-danger-subtle text-danger mb-0 me-3">
                                <i class="bi bi-megaphone-fill"></i>
                            </div>
                            <div>
                                <p class="text-muted small mb-1 fw-medium">Announcements</p>
                                <h3 class="mb-0 fw-bold text-dark"><?php echo $total_announcements; ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-0 shadow-sm rounded-3 mb-4">
    
    
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
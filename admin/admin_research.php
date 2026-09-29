<?php
include '../database.php';

$message = "";
$messageClass = "";

// HANDLE PIPELINE INTERFACES
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'];
    
    if ($action === 'approve') {
        // 1. Fetch the data out of staging table
        $fetch_sql = "SELECT * FROM research_submissions WHERE id = $id";
        $fetch_res = $conn->query($fetch_sql);
        
        if ($fetch_res && $fetch_res->num_rows > 0) {
            $row = $fetch_res->fetch_assoc();
            $title = $conn->real_escape_string($row['title']);
            $abstract = $conn->real_escape_string($row['abstract']);
            $author = $conn->real_escape_string($row['author']);
            
            // CAPTURE TRANSITIONAL STAGING DATA ALIGNED WITH RESEARCH.PHP
            $research_category = $conn->real_escape_string($row['research_category']);
            $research_type     = $conn->real_escape_string($row['research_type']);
            $year_completed    = $conn->real_escape_string($row['year_completed']);
            $file_name         = $conn->real_escape_string($row['file_path']); // Staging uses file_path
            
            $grade_level       = $conn->real_escape_string($row['grade_level']);
            $strand            = $conn->real_escape_string($row['strand']);
            
            // 🌟 SPOT 2: INSERT STATEMENT UPDATED TO REFLECT THE EXACT COLUMNS IN RESEARCH.PHP
            $approve_sql = "INSERT INTO research_articles (title, abstract, author, research_category, research_type, year_completed, file, grade_level, strand) 
                            VALUES ('$title', '$abstract', '$author', '$research_category', '$research_type', '$year_completed', '$file_name', '$grade_level', '$strand')";
            
            if ($conn->query($approve_sql) === TRUE) {
                // 3. Clear the row out of our queue staging container
                $conn->query("DELETE FROM research_submissions WHERE id = $id");
                $message = "Article approved and successfully published!";
                $messageClass = "alert-success";
            } else {
                $message = "Publishing error: " . $conn->error;
                $messageClass = "alert-danger";
            }
        }
    }
    elseif ($action === 'disapprove') {
        $disapprove_sql = "UPDATE research_submissions SET status = 'Disapproved' WHERE id = $id";
        
        if ($conn->query($disapprove_sql) === TRUE) {
            $message = "Research proposal has been disapproved.";
            $messageClass = "alert-warning";
        } else {
            $message = "Error updates: " . $conn->error;
            $messageClass = "alert-danger";
        }
    }
}

// FETCH OUTSTANDING REQUEST QUEUES
// Updated to select the corrected variable structures from your submission staging table
$sql = "SELECT id, title, author, abstract, research_category, research_type, year_completed, grade_level, strand, file_path, status, submitted_at FROM research_submissions ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Research Pipeline - CCNHS Admin</title>
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
                    <li class="nav-item"><a class="nav-link" href="admin_user.php"><i class="bi bi-people me-2"></i> Manage Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_viewRequest.php"><i class="bi bi-file-earmark-lock2 me-2"></i> DL Requests</a></li>
                    <li class="nav-item"><a class="nav-link active" href="admin_research.php"><i class="bi bi-file-earmark-text me-2"></i> Submission Queue</a></li>
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
                <h1 class="h2 fw-bold text-dark mb-1 pt-1">Incoming Research Submission Queue</h1>
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
                                <th class="ps-4" style="width: 45%;">Submission Profile</th>
                                <th style="width: 20%;">Date Submitted</th>
                                <th style="width: 15%;">Queue Status</th>
                                <th class="text-end pe-4" style="width: 20%;">Moderation Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result && $result->num_rows > 0): ?>
                                <?php while($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td class="ps-4 py-3">
                                            <div class="fw-bold text-dark mb-1"><?php echo htmlspecialchars($row['title']); ?></div>
                                            <div class="text-muted small mb-1">
                                                <i class="bi bi-person me-1"></i><?php echo htmlspecialchars($row['author']); ?> 
                                                <span class="text-dark-50 mx-1">|</span> 
                                                <i class="bi bi-calendar3 me-1"></i>Year: <?php echo htmlspecialchars($row['year_completed']); ?>
                                            </div>
                                            <div class="mb-2">
                                                <span class="badge bg-primary-subtle text-primary text-uppercase small" style="font-size: 0.7rem;"><?php echo htmlspecialchars($row['research_category']); ?></span>
                                                <span class="badge bg-secondary-subtle text-dark text-uppercase small" style="font-size: 0.7rem;"><?php echo htmlspecialchars($row['research_type']); ?></span>
                                                <span class="badge bg-light text-secondary border small" style="font-size: 0.7rem;"><?php echo htmlspecialchars($row['grade_level']); ?> - <?php echo htmlspecialchars($row['strand']); ?></span>
                                            </div>
                                            <div class="text-secondary small text-truncate mb-2" style="max-width: 400px; font-style: italic;">
                                                "<?php echo htmlspecialchars($row['abstract']); ?>"
                                            </div>
                                            <a href="../<?php echo htmlspecialchars($row['file_path']); ?>" target="_blank" class="btn btn-light btn-sm py-1 px-2 border text-primary small">
                                                <i class="bi bi-file-pdf me-1 text-danger"></i> Open Attached PDF
                                            </a>
                                        </td>
                                        <td><span class="text-secondary small fw-medium"><?php echo date('M d, Y g:i A', strtotime($row['submitted_at'])); ?></span></td>
                                        <td>
                                            <?php 
                                                $status = $row['status'];
                                                $badgeStyle = ($status == 'Disapproved') ? 'bg-danger-subtle text-danger' : 'bg-warning-subtle text-warning text-dark';
                                            ?>
                                            <span class="badge <?php echo $badgeStyle; ?> px-2 py-1"><?php echo $status; ?></span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group btn-group-sm">
                                                <a href="admin_research.php?action=approve&id=<?php echo $row['id']; ?>" class="btn btn-outline-success" onclick="return confirm('Approve and publish this research piece to the library?');">
                                                    <i class="bi bi-check-circle-fill"></i> Approve
                                                </a>
                                                <a href="admin_research.php?action=disapprove&id=<?php echo $row['id']; ?>" class="btn btn-outline-danger <?php echo ($status == 'Disapproved') ? 'disabled opacity-50' : ''; ?>" onclick="return confirm('Reject this research proposal?');">
                                                    <i class="bi bi-x-circle-fill"></i> Disapprove
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="text-center py-4 text-muted">The research review queue is completely empty.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
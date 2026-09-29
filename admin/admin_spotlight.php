<?php
include '../database.php';

$message = "";
$messageClass = "";

// --- WORKFLOW: UPDATE ACTIVE PORTAL SPOTLIGHT ARTIFACT ---
if (isset($_POST['set_spotlight'])) {
    $target_article_id = intval($_POST['article_id']);
    
    $update_spotlight = $conn->query("UPDATE portal_settings SET setting_value = '$target_article_id' WHERE setting_key = 'spotlight_article_id'");
    
    if ($update_spotlight) {
        $message = "Dashboard Research Spotlight assignment successfully updated!";
        $messageClass = "alert-success";
    } else {
        $message = "Failed to update configuration parameter settings: " . $conn->error;
        $messageClass = "alert-danger";
    }
}

// Fetch the current spotlight ID setting value 
$current_setting = $conn->query("SELECT setting_value FROM portal_settings WHERE setting_key = 'spotlight_article_id'")->fetch_assoc();
$current_spotlight_id = isset($current_setting['setting_value']) ? intval($current_setting['setting_value']) : 0;

// Fetch all available published research articles to display in the control table
$all_articles = $conn->query("SELECT id, title, author, research_area, strand FROM research_articles ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Spotlight Feature - CCNHS Admin</title>
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
                    <li class="nav-item"><a class="nav-link active" href="admin_spotlight.php"><i class="bi bi-star-fill me-2 text-warning"></i> Spotlight Feature</a></li>
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
                <a href="../logout_paget.php" class="nav-link text-danger fw-semibold px-2 py-1 d-block">
                    <i class="bi bi-box-arrow-right me-2"></i> Sign Out
                </a>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            
            <?php if (!empty($message)): ?>
                <div class="alert <?php echo $messageClass; ?> alert-dismissible fade show shadow-sm" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                <div>
                     <h1 class="h2 fw-bold text-dark mb-1 pt-3">Research Spotlight Controller</h1>
                </div>
            </div>

            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="table-responsive">
                    <table class="table align-middle mb-0 text-nowrap">
                        <thead class="table-light text-secondary small fw-semibold uppercase">
                            <tr>
                                <th class="px-4 py-3">Status Badge</th>
                                <th class="py-3">Manuscript Research Title</th>
                                <th class="py-3">Lead Author</th>
                                <th class="py-3">Academic Strand</th>
                                <th class="px-4 py-3 text-end">Operational Controls</th>
                            </tr>
                        </thead>
                        <tbody class="small text-secondary">
                            <?php if ($all_articles && $all_articles->num_rows > 0): ?>
                                <?php while($row = $all_articles->fetch_assoc()): 
                                    $is_current = ($row['id'] == $current_spotlight_id);
                                ?>
                                    <tr class="<?php echo $is_current ? 'highlighted-row' : ''; ?>">
                                        <td class="px-4">
                                            <?php if ($is_current): ?>
                                                <span class="badge bg-success text-white px-2 py-1"><i class="bi bi-star-fill me-1"></i> Active Spotlight</span>
                                            <?php else: ?>
                                                <span class="badge bg-light text-muted border px-2 py-1">Standard Entry</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark text-wrap" style="max-width: 360px;"><?php echo htmlspecialchars($row['title']); ?></div>
                                            <span class="text-muted opacity-75 small"><?php echo htmlspecialchars($row['research_area']); ?></span>
                                        </td>
                                        <td class="fw-medium text-dark"><?php echo htmlspecialchars($row['author']); ?></td>
                                        <td><span class="badge bg-secondary-subtle text-secondary px-2 py-1 rounded"><?php echo htmlspecialchars($row['strand']); ?></span></td>
                                        <td class="px-4 text-end">
                                            <?php if ($is_current): ?>
                                                <button type="button" class="btn btn-sm btn-success rounded px-3 shadow-sm disabled" disabled>
                                                    <i class="bi bi-check-circle-fill"></i> Currently Active
                                                </button>
                                            <?php else: ?>
                                                <form action="" method="POST" class="d-inline">
                                                    <input type="hidden" name="article_id" value="<?php echo $row['id']; ?>">
                                                    <button type="submit" name="set_spotlight" class="btn btn-sm btn-outline-dark rounded px-3">
                                                        <i class="bi bi-pin-angle-fill me-1"></i> Highlight This Paper
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-journal-x fs-2 d-block text-secondary opacity-50 mb-2"></i>
                                        No published articles available to select.
                                    </td>
                                </tr>
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
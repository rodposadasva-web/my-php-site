<?php
include '../database.php'; //

// Action Handler for Approving or Denying requests straight from this log panel
$dash_msg = ""; //
if (isset($_GET['download_action']) && isset($_GET['req_id'])) { //
    $req_id = intval($_GET['req_id']); //
    $action = $_GET['download_action']; //
    
    if ($action === 'grant') { //
        $conn->query("UPDATE download_requests SET status = 'Approved' WHERE id = $req_id"); //
        $dash_msg = "<div class='alert alert-success d-flex align-items-center shadow-sm'><i class='bi bi-check-circle-fill me-2'></i> Download permission granted successfully!</div>"; //
    } elseif ($action === 'deny') { //
        $conn->query("UPDATE download_requests SET status = 'Denied' WHERE id = $req_id"); //
        $dash_msg = "<div class='alert alert-warning d-flex align-items-center shadow-sm'><i class='bi bi-exclamation-triangle-fill me-2'></i> Download request successfully rejected.</div>"; //
    }
}

// FIXED: Pull all updated metadata columns from table layout cleanly
$requests_query = "SELECT dr.*, ra.title, ra.author 
                   FROM download_requests dr 
                   JOIN research_articles ra ON dr.article_id = ra.id 
                   ORDER BY dr.id DESC"; //
$requests_result = $conn->query($requests_query); //
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manuscript Download Logs - CCNHS Admin</title>
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
        .manuscript-link { color: #222; text-decoration: none; font-weight: 600; transition: color 0.2s; cursor: pointer; }
        .manuscript-link:hover { color: #7e3af2; text-decoration: underline; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse p-3 d-flex flex-column">
            <div>
                <div class="d-flex align-items-center mb-4 ps-2">
                    <a class="text-decoration-none fs-5 fw-bold text-dark" href="admin_dashboard.php">CCNHS Admin</a>
                </div>
                <ul class="nav flex-column gap-1">
                    <li class="nav-item"><a class="nav-link" href="admin_dashboard.php"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_spotlight.php"><i class="bi bi-star-fill me-2 text-warning"></i> Spotlight Feature</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_user.php"><i class="bi bi-people me-2"></i> Manage Users</a></li>
                    <li class="nav-item"><a class="nav-link active" href="admin_viewRequest.php"><i class="bi bi-file-earmark-lock2 me-2"></i> DL Requests</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_research.php"><i class="bi bi-file-earmark-text me-2"></i> Submission Queue</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_published.php"><i class="bi bi-file-earmark-text me-2"></i> Published Articles</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_announcements.php"><i class="bi bi-megaphone me-2"></i> Announcements</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_news.php"><i class="bi bi-megaphone me-2"></i> News</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_policies.php"><i class="bi bi-file-earmark-ruled me-2"></i> Policies</a></li>
                </ul>
            </div>
            <hr>
            <div>
                <a href="../logout.php" class="nav-link text-danger fw-semibold px-2 py-1 d-block">
                    <i class="bi bi-box-arrow-right me-2"></i> Sign Out
                </a>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <div>
                    <h1 class="h2 fw-bold text-dark mb-1">Manuscript Download Logs</h1>
                    <p class="text-muted small">Review and manage access validation controls for archived academic properties.</p>
                </div>
            </div>

            <?php echo $dash_msg; ?>

            <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4" style="width: 30%;">Target Manuscript (Click to view form)</th>
                                    <th style="width: 15%;">Requester Username</th>
                                    <th style="width: 25%;">Stated Request Purpose</th>
                                    <th style="width: 15%;">Timestamp</th>
                                    <th style="width: 10%;">Status</th>
                                    <th class="text-end pe-4" style="width: 5%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($requests_result && $requests_result->num_rows > 0): ?>
                                    <?php while($row = $requests_result->fetch_assoc()): 
                                        // Dynamic mapping for backward-compatibility fallbacks
                                        $display_name = !empty($row['first_name']) ? htmlspecialchars($row['title_prefix'] . ' ' . $row['first_name'] . ' ' . $row['last_name']) : 'N/A';
                                        $display_school = !empty($row['school']) ? htmlspecialchars($row['school']) : 'N/A';
                                        $display_address = !empty($row['school_address']) ? htmlspecialchars($row['school_address']) : 'N/A';
                                        $display_position = !empty($row['position']) ? htmlspecialchars($row['position']) : 'N/A';
                                        $display_country = !empty($row['country']) ? htmlspecialchars($row['country']) : 'N/A';
                                        $display_region = !empty($row['region']) ? htmlspecialchars($row['region']) : 'N/A';
                                        $display_email = !empty($row['email_address']) ? htmlspecialchars($row['email_address']) : 'N/A';
                                        $display_contact = !empty($row['contact_number']) ? htmlspecialchars($row['contact_number']) : 'N/A';
                                        $display_type = !empty($row['researcher_type']) ? htmlspecialchars($row['researcher_type']) : 'N/A';
                                        $display_req_type = !empty($row['request_type']) ? htmlspecialchars($row['request_type']) : 'View Full Manuscript';
                                    ?>
                                        <tr>
                                            <td class="ps-4">
                                                <div class="manuscript-link text-wrap view-details-btn" 
                                                     data-bs-toggle="modal" 
                                                     data-bs-target="#requestDetailsModal"
                                                     data-title="<?php echo htmlspecialchars($row['title'], ENT_QUOTES); ?>"
                                                     data-author="<?php echo htmlspecialchars($row['author'], ENT_QUOTES); ?>"
                                                     data-username="<?php echo htmlspecialchars($row['user_name'], ENT_QUOTES); ?>"
                                                     data-fullname="<?php echo $display_name; ?>"
                                                     data-school="<?php echo $display_school; ?>"
                                                     data-address="<?php echo $display_address; ?>"
                                                     data-position="<?php echo $display_position; ?>"
                                                     data-country="<?php echo $display_country; ?>"
                                                     data-region="<?php echo $display_region; ?>"
                                                     data-email="<?php echo $display_email; ?>"
                                                     data-contact="<?php echo $display_contact; ?>"
                                                     data-type="<?php echo $display_type; ?>"
                                                     data-purpose="<?php echo htmlspecialchars($row['purpose'], ENT_QUOTES); ?>"
                                                     data-reqtype="<?php echo $display_req_type; ?>">
                                                    <?php echo htmlspecialchars($row['title']); ?>
                                                </div>
                                                <span class="text-muted small d-block">by <?php echo htmlspecialchars($row['author']); ?></span>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary-subtle text-secondary fw-semibold">
                                                    <i class="bi bi-person me-1"></i><?php echo htmlspecialchars($row['user_name']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="text-secondary small text-truncate" style="max-width: 260px;" title="<?php echo htmlspecialchars($row['purpose']); ?>">
                                                    <?php echo htmlspecialchars($row['purpose']); ?>
                                                </div>
                                            </td>
                                            <td class="text-muted small">
                                                <?php echo date('M d, Y • h:i A', strtotime($row['requested_at'])); ?>
                                            </td>
                                            <td>
                                                <?php if($row['status'] === 'Approved'): ?>
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1">Approved</span>
                                                <?php elseif($row['status'] === 'Denied'): ?>
                                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1">Denied</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1">Pending</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-end pe-4">
                                                <?php if ($row['status'] === 'Pending'): ?>
                                                    <div class="d-flex justify-content-end gap-1.5">
                                                        <a href="admin_viewRequest.php?download_action=grant&req_id=<?php echo $row['id']; ?>" 
                                                           class="btn btn-sm btn-success d-inline-flex align-items-center px-2 py-1" title="Grant Permission">
                                                            <i class="bi bi-check-lg"></i>
                                                        </a>
                                                        <a href="admin_viewRequest.php?download_action=deny&req_id=<?php echo $row['id']; ?>" 
                                                           class="btn btn-sm btn-danger d-inline-flex align-items-center px-2 py-1" title="Deny Permission"
                                                           onclick="return confirm('Reject this download permission request?');">
                                                            <i class="bi bi-x-lg"></i>
                                                        </a>
                                                    </div>
                                                <?php else: ?>
                                                    <button class="btn btn-sm btn-light text-muted" disabled><i class="bi bi-lock-fill"></i></button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted small">
                                            <i class="bi bi-folder-x text-secondary fs-3 d-block mb-2"></i>No download transactions logged.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<div class="modal fade" id="requestDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow rounded-3">
            <div class="modal-header border-0 bg-light p-4">
                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-file-earmark-person-fill text-primary me-2"></i>Submitted Request Form Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="p-3 mb-4 rounded bg-light border-start border-4 border-primary">
                    <div class="small fw-bold text-secondary mb-1">Target Manuscript File:</div>
                    <h6 class="text-dark fw-bold mb-1" id="mdl-title">Manuscript Title</h6>
                    <div class="small text-muted" id="mdl-author">by Author</div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold text-uppercase d-block mb-1">Requester Full Name</label>
                        <div class="p-2 border rounded bg-white text-dark fw-medium" id="mdl-fullname">N/A</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold text-uppercase d-block mb-1">Portal Account Username</label>
                        <div class="p-2 border rounded bg-white text-dark" id="mdl-username">N/A</div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="text-muted small fw-bold text-uppercase d-block mb-1">School</label>
                        <div class="p-2 border rounded bg-white text-dark" id="mdl-school">N/A</div>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small fw-bold text-uppercase d-block mb-1">School Address</label>
                        <div class="p-2 border rounded bg-white text-dark" id="mdl-address">N/A</div>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small fw-bold text-uppercase d-block mb-1">Position / Designation</label>
                        <div class="p-2 border rounded bg-white text-dark" id="mdl-position">N/A</div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="text-muted small fw-bold text-uppercase d-block mb-1">Country</label>
                        <div class="p-2 border rounded bg-white text-dark" id="mdl-country">N/A</div>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small fw-bold text-uppercase d-block mb-1">Region</label>
                        <div class="p-2 border rounded bg-white text-dark" id="mdl-region">N/A</div>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small fw-bold text-uppercase d-block mb-1">Researcher Category</label>
                        <div class="p-2 border rounded bg-white text-dark fw-bold text-primary" id="mdl-type">N/A</div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold text-uppercase d-block mb-1">Email Address</label>
                        <div class="p-2 border rounded bg-white text-dark" id="mdl-email">N/A</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small fw-bold text-uppercase d-block mb-1">Contact Number</label>
                        <div class="p-2 border rounded bg-white text-dark" id="mdl-contact">N/A</div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="text-muted small fw-bold text-uppercase d-block mb-1">Stated Intent / Purpose</label>
                    <div class="p-3 border rounded bg-white text-dark italic bg-light-subtle" id="mdl-purpose" style="min-height: 60px; white-space: pre-line;">N/A</div>
                </div>

                <div>
                    <label class="text-muted small fw-bold text-uppercase d-block mb-1">Requested Action Scope</label>
                    <div class="p-2 border rounded bg-info-subtle text-info-dark fw-semibold" id="mdl-reqtype">N/A</div>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close Profile View</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// JavaScript Bridge Payload Handler
document.querySelectorAll('.view-details-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.getElementById('mdl-title').textContent = this.getAttribute('data-title');
        document.getElementById('mdl-author').textContent = 'by ' + this.getAttribute('data-author');
        document.getElementById('mdl-fullname').textContent = this.getAttribute('data-fullname');
        document.getElementById('mdl-username').textContent = this.getAttribute('data-username');
        document.getElementById('mdl-school').textContent = this.getAttribute('data-school');
        document.getElementById('mdl-address').textContent = this.getAttribute('data-address');
        document.getElementById('mdl-position').textContent = this.getAttribute('data-position');
        document.getElementById('mdl-country').textContent = this.getAttribute('data-country');
        document.getElementById('mdl-region').textContent = this.getAttribute('data-region');
        document.getElementById('mdl-type').textContent = this.getAttribute('data-type');
        document.getElementById('mdl-email').textContent = this.getAttribute('data-email');
        document.getElementById('mdl-contact').textContent = this.getAttribute('data-contact');
        document.getElementById('mdl-purpose').textContent = `"${this.getAttribute('data-purpose')}"`;
        document.getElementById('mdl-reqtype').textContent = this.getAttribute('data-reqtype');
    });
});
</script>
</body>
</html>
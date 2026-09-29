<?php
include '../database.php';

$message = "";
$messageClass = "";

// --- WORKFLOW: REMOVE / DELETE POLICY ENTRY ---
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Fetch file path to clear local folder disk space safely
    $file_check = $conn->query("SELECT file_path FROM portal_policies WHERE id = $id");
    if ($file_check && $file_check->num_rows > 0) {
        $file_row = $file_check->fetch_assoc();
        $clean_path = str_replace('../', '', $file_row['file_path']);
        $physical_file = "../" . $clean_path;
        
        if (!empty($file_row['file_path']) && file_exists($physical_file)) {
            unlink($physical_file); 
        }
    }
    
    if ($conn->query("DELETE FROM portal_policies WHERE id = $id") === TRUE) {
        $message = "Policy guidance reference document successfully deleted.";
        $messageClass = "alert-success";
    } else {
        $message = "Execution failure: " . $conn->error;
        $messageClass = "alert-danger";
    }
}

// --- WORKFLOW: ADD NEW POLICY ---
if (isset($_POST['submit_policy'])) {
    $policy_num = $conn->real_escape_string($_POST['policy_number']);
    $title = $conn->real_escape_string($_POST['title']);
    $issue_date = $conn->real_escape_string($_POST['issuance_date']);
    $scope = $conn->real_escape_string($_POST['scope']);
    $description = $conn->real_escape_string($_POST['description']);
    $portal_link = $conn->real_escape_string($_POST['portal_link']);

    if (isset($_FILES['policy_file']) && $_FILES['policy_file']['error'] == 0) {
        $allowed_ext = ['pdf'];
        $filename = $_FILES['policy_file']['name'];
        $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (in_array($file_ext, $allowed_ext)) {
            $unique_filename = 'policy_' . time() . '_' . uniqid() . '.' . $file_ext;
            $upload_dir = '../uploads/policies/';
            
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            if (move_uploaded_file($_FILES['policy_file']['tmp_name'], $upload_dir . $unique_filename)) {
                $db_file_path = 'uploads/policies/' . $unique_filename;
                
                $insert_sql = "INSERT INTO portal_policies (policy_number, title, issuance_date, scope, description, file_path, portal_link) 
                               VALUES ('$policy_num', '$title', '$issue_date', '$scope', '$description', '$db_file_path', '$portal_link')";
                
                if ($conn->query($insert_sql) === TRUE) {
                    $message = "New institutional regulatory policy published successfully!";
                    $messageClass = "alert-success";
                } else {
                    $message = "Database error: " . $conn->error;
                    $messageClass = "alert-danger";
                }
            } else {
                $message = "Failed to copy documentation file attachment onto system storage disks.";
                $messageClass = "alert-danger";
            }
        } else {
            $message = "Unsupported profile format type. Please upload standardized PDF files.";
            $messageClass = "alert-danger";
        }
    } else {
        $message = "Please attach the associated verification PDF issuance document.";
        $messageClass = "alert-danger";
    }
}

// --- WORKFLOW: UPDATE / EDIT EXISTING POLICY ---
if (isset($_POST['update_policy'])) {
    $id = intval($_POST['policy_id']);
    $policy_num = $conn->real_escape_string($_POST['policy_number']);
    $title = $conn->real_escape_string($_POST['title']);
    $issue_date = $conn->real_escape_string($_POST['issuance_date']);
    $scope = $conn->real_escape_string($_POST['scope']);
    $description = $conn->real_escape_string($_POST['description']);
    $portal_link = $conn->real_escape_string($_POST['portal_link']);

    // Check if a new file is being uploaded
    if (isset($_FILES['policy_file']) && $_FILES['policy_file']['error'] == 0) {
        $allowed_ext = ['pdf'];
        $filename = $_FILES['policy_file']['name'];
        $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (in_array($file_ext, $allowed_ext)) {
            $unique_filename = 'policy_' . time() . '_' . uniqid() . '.' . $file_ext;
            $upload_dir = '../uploads/policies/';
            
            if (move_uploaded_file($_FILES['policy_file']['tmp_name'], $upload_dir . $unique_filename)) {
                $db_file_path = 'uploads/policies/' . $unique_filename;
                
                // Remove old file
                $file_check = $conn->query("SELECT file_path FROM portal_policies WHERE id = $id");
                if ($file_check && $file_check->num_rows > 0) {
                    $file_row = $file_check->fetch_assoc();
                    $physical_file = "../" . str_replace('../', '', $file_row['file_path']);
                    if (file_exists($physical_file)) { unlink($physical_file); }
                }

                $update_sql = "UPDATE portal_policies SET policy_number='$policy_num', title='$title', issuance_date='$issue_date', scope='$scope', description='$description', file_path='$db_file_path', portal_link='$portal_link' WHERE id=$id";
            }
        }
    } else {
        // Update without changing file path
        $update_sql = "UPDATE portal_policies SET policy_number='$policy_num', title='$title', issuance_date='$issue_date', scope='$scope', description='$description', portal_link='$portal_link' WHERE id=$id";
    }

    if (isset($update_sql) && $conn->query($update_sql) === TRUE) {
        $message = "Policy changes saved successfully!";
        $messageClass = "alert-success";
    } else {
        $message = "Failed to update record: " . $conn->error;
        $messageClass = "alert-danger";
    }
}

// Fetch all policy files currently logged in the infrastructure database
$policies_list = $conn->query("SELECT * FROM portal_policies ORDER BY issuance_date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Policy Manager - CCNHS Admin</title>
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
        <!-- Sidebar Navigation -->
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
                    <li class="nav-item"><a class="nav-link" href="admin_research.php"><i class="bi bi-file-earmark-text me-2"></i> Submission Queue</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_published.php"><i class="bi bi-file-earmark-text me-2"></i> Published Articles</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_announcements.php"><i class="bi bi-megaphone me-2"></i> Announcements</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_news.php"><i class="bi bi-megaphone me-2"></i> News</a></li>
                    <li class="nav-item"><a class="nav-link active" href="admin_policies.php"><i class="bi bi-file-earmark-ruled me-2"></i> Policies</a></li>
                </ul>
            </div>
            <hr>
            <div class="d-flex align-items-center mb-4 ps-2">
                <a href="../logout_page.php" class="nav-link text-danger fw-semibold px-2 py-1 d-block">
                    <i class="bi bi-box-arrow-right me-2"></i> Sign Out
                </a>
            </div>
        </nav>

        <!-- Main Workspace -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            
            <?php if (!empty($message)): ?>
                <div class="alert <?php echo $messageClass; ?> alert-dismissible fade show shadow-sm" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                <div>
                    <h1 class="h2 fw-bold text-dark mb-1 pt-3">Regulatory Policies & Framework Guidelines</h1>
                    <p class="text-muted small mb-0">Manage basic education provisions, research foundations, and institutional mandates across four structural levels.</p>
                </div>
                <button type="button" class="btn btn-dark btn-sm rounded px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#addPolicyModal">
                    <i class="bi bi-plus-circle-fill me-1"></i> Register Mandate Policy
                </button>
            </div>

            <!-- Table -->
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="table-responsive">
                    <table class="table align-middle mb-0 text-nowrap">
                        <thead class="table-light text-secondary small fw-semibold uppercase">
                            <tr>
                                <th class="px-4 py-3">Reference No.</th>
                                <th class="py-3">Policy Project Title / Focus Heading</th>
                                <th class="py-3">Issuance Date</th>
                                <th class="py-3">Jurisdiction Scope</th>
                                <th class="px-4 py-3 text-end text-muted">Operational Controls</th>
                            </tr>
                        </thead>
                        <tbody class="small text-secondary">
                            <?php if ($policies_list && $policies_list->num_rows > 0): ?>
                                <?php while($row = $policies_list->fetch_assoc()): ?>
                                    <?php 
                                        $scope_label = htmlspecialchars($row['scope']);
                                        $badge_class = "bg-secondary-subtle text-secondary";
                                        
                                        if (stripos($scope_label, 'central') !== false) {
                                            $badge_class = "bg-danger-subtle text-danger border border-danger-subtle";
                                        } elseif (stripos($scope_label, 'regional') !== false) {
                                            $badge_class = "bg-primary-subtle text-primary border border-primary-subtle";
                                        } elseif (stripos($scope_label, 'division') !== false) {
                                            $badge_class = "bg-warning-subtle text-warning border border-warning-subtle";
                                        } elseif (stripos($scope_label, 'school') !== false) {
                                            $badge_class = "bg-success-subtle text-success border border-success-subtle";
                                        }
                                    ?>
                                    <tr>
                                        <td class="px-4 fw-bold text-dark"><?php echo htmlspecialchars($row['policy_number']); ?></td>
                                        <td>
                                            <div class="fw-semibold text-dark text-wrap" style="max-width: 320px;"><?php echo htmlspecialchars($row['title']); ?></div>
                                            <span class="text-muted text-wrap d-block mt-1 opacity-75" style="max-width: 320px; font-size: 0.8rem;"><?php echo htmlspecialchars($row['description']); ?></span>
                                            <?php if (!empty($row['portal_link'])): ?>
                                                <small class="d-block mt-1 text-primary text-wrap break-all" style="font-size: 0.75rem;">
                                                    <i class="bi bi-link-45deg"></i> Link: <?php echo htmlspecialchars($row['portal_link']); ?>
                                                </small>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo date("F d, Y", strtotime($row['issuance_date'])); ?></td>
                                        <td><span class="badge <?php echo $badge_class; ?> px-2 py-1 rounded text-uppercase" style="font-size: 0.7rem;"><?php echo $scope_label; ?></span></td>
                                        <td class="px-4 text-end">
                                            <div class="btn-group gap-2">
                                                <!-- Changed from "Read Issuance" to dynamic modal trigger "Edit" -->
                                                <button type="button" 
                                                        class="btn btn-outline-dark btn-sm rounded edit-policy-btn" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editPolicyModal"
                                                        data-id="<?php echo $row['id']; ?>"
                                                        data-number="<?php echo htmlspecialchars($row['policy_number']); ?>"
                                                        data-title="<?php echo htmlspecialchars($row['title']); ?>"
                                                        data-date="<?php echo $row['issuance_date']; ?>"
                                                        data-scope="<?php echo htmlspecialchars($row['scope']); ?>"
                                                        data-link="<?php echo htmlspecialchars($row['portal_link']); ?>"
                                                        data-desc="<?php echo htmlspecialchars($row['description']); ?>">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </button>
                                                <a href="admin_policies.php?action=delete&id=<?php echo $row['id']; ?>" class="btn btn-outline-danger btn-sm rounded" onclick="return confirm('Permanently remove this statutory template from server file directories?');">
                                                    <i class="bi bi-trash-fill"></i> Delete
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-folder-x fs-2 d-block text-secondary opacity-50 mb-2"></i>
                                        No structural directives or baseline institutional guidelines are uploaded yet.
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

<!-- Modal: Add Policy -->
<div class="modal fade" id="addPolicyModal" tabindex="-1" aria-labelledby="addPolicyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-header bg-dark text-white p-3">
                    <h5 class="modal-title fs-6" id="addPolicyModalLabel"><i class="bi bi-file-earmark-plus me-2"></i> Publish Strategic Reference Policy</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Policy / Memorandum Reference Number</label>
                        <input type="text" name="policy_number" class="form-control" placeholder="e.g., RM No. 283, s. 2024" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Official Document Title Header</label>
                        <input type="text" name="title" class="form-control" placeholder="e.g., Guidelines on the Utilization of DepEd Region I Research Portal" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Date of Legal Issuance</label>
                            <input type="date" name="issuance_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Jurisdictional Scope Level</label>
                            <select name="scope" class="form-select" required>
                                <option value="Central Level" selected>Central Level</option>
                                <option value="Regional Level">Regional Level</option>
                                <option value="Division Level">Division Level</option>
                                <option value="School Level">School Level</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Associated Portal Link <span class="text-muted fw-normal">(Optional)</span></label>
                        <input type="url" name="portal_link" class="form-control" placeholder="e.g., https://researchportal.depedro1.com/">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Brief Description / Scope Rationale Summary</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Describe the structural intent of the provision rules..."></textarea>
                    </div>
                    <div class="mb-1">
                        <label class="form-label small fw-semibold text-secondary">Attach Verification PDF Document</label>
                        <input type="file" name="policy_file" class="form-control" accept=".pdf" required>
                    </div>
                </div>
                <div class="modal-footer border-top-0 px-4 py-3 bg-light">
                    <button type="button" class="btn btn-secondary btn-sm rounded px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit_policy" class="btn btn-primary btn-sm rounded px-3 shadow-sm"><i class="bi bi-cloud-arrow-up-fill me-1"></i> Upload Issuance</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- NEW Modal: Edit Policy Layout Popup Window -->
<div class="modal fade" id="editPolicyModal" tabindex="-1" aria-labelledby="editPolicyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="policy_id" id="edit_id">
                <div class="modal-header bg-dark text-white p-3">
                    <h5 class="modal-title fs-6" id="editPolicyModalLabel"><i class="bi bi-pencil-square me-2"></i> Edit Reference Policy & Mandate</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Policy / Memorandum Reference Number</label>
                        <input type="text" name="policy_number" id="edit_number" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Official Document Title Header</label>
                        <input type="text" name="title" id="edit_title" class="form-control" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Date of Legal Issuance</label>
                            <input type="date" name="issuance_date" id="edit_date" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Jurisdictional Scope Level</label>
                            <select name="scope" id="edit_scope" class="form-select" required>
                                <option value="Central Level">Central Level</option>
                                <option value="Regional Level">Regional Level</option>
                                <option value="Division Level">Division Level</option>
                                <option value="School Level">School Level</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Associated Portal Link <span class="text-muted fw-normal">(Optional)</span></label>
                        <input type="url" name="portal_link" id="edit_link" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Brief Description / Scope Rationale Summary</label>
                        <textarea name="description" id="edit_desc" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-1">
                        <label class="form-label small fw-semibold text-secondary">Update Verification PDF Document <span class="text-muted fw-normal">(Leave blank to keep existing)</span></label>
                        <input type="file" name="policy_file" class="form-control" accept=".pdf">
                    </div>
                </div>
                <div class="modal-footer border-top-0 px-4 py-3 bg-light">
                    <button type="button" class="btn btn-secondary btn-sm rounded px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="update_policy" class="btn btn-success btn-sm rounded px-3 shadow-sm"><i class="bi bi-check-circle-fill me-1"></i> Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const editButtons = document.querySelectorAll('.edit-policy-btn');
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            document.getElementById('edit_id').value = this.getAttribute('data-id');
            document.getElementById('edit_number').value = this.getAttribute('data-number');
            document.getElementById('edit_title').value = this.getAttribute('data-title');
            document.getElementById('edit_date').value = this.getAttribute('data-date');
            document.getElementById('edit_scope').value = this.getAttribute('data-scope');
            document.getElementById('edit_link').value = this.getAttribute('data-link');
            document.getElementById('edit_desc').value = this.getAttribute('data-desc');
        });
    });
});
</script>
</body>
</html>
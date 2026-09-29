<?php
include '../database.php';

$message = "";
$messageClass = "";

// ==========================================
// 1. HANDLE PIPELINE ACTIONS (DELETE & EDIT)
// ==========================================
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'];
    
    // --- WORKFLOW: DELETE LIVE ARTICLE ---
    if ($action === 'delete') {
        // Fetch filename first to remove it from disk storage safely
        $file_check = $conn->query("SELECT file FROM research_articles WHERE id = $id");
        if ($file_check && $file_check->num_rows > 0) {
            $file_row = $file_check->fetch_assoc();
            
            // Replaced ltrim with str_replace to avoid the invalid range warning
            $clean_path = str_replace('../', '', $file_row['file']);
            $physical_file = "../" . $clean_path;
            
            if (!empty($file_row['file']) && file_exists($physical_file)) {
                unlink($physical_file); 
            }
        }
        
        if ($conn->query("DELETE FROM research_articles WHERE id = $id") === TRUE) {
            $message = "Published manuscript record permanently purged from storage library.";
            $messageClass = "alert-success";
        } else {
            $message = "Deletion error: " . $conn->error;
            $messageClass = "alert-danger";
        }
    }
}

// --- WORKFLOW: SAVE INLINE MODAL EDITS (WITH PDF REPLACEMENT) ---
if (isset($_POST['submit_update'])) {
    $article_id = intval($_POST['article_id']);
    $up_title = $conn->real_escape_string($_POST['title']);
    $up_author = $conn->real_escape_string($_POST['author']);
    $up_abstract = $conn->real_escape_string($_POST['abstract']);
    $up_grade = $conn->real_escape_string($_POST['grade_level']);
    $up_strand = $conn->real_escape_string($_POST['strand']);
    
    // UPDATED PIPELINE VARIABLES ACCORDING TO RESEARCH.PHP
    $up_category = $conn->real_escape_string($_POST['research_category']);
    $up_type = $conn->real_escape_string($_POST['research_type']);
    $up_design= $conn->real_escape_string($_POST['research_design']);
    $up_year = $conn->real_escape_string($_POST['year_completed']);

    $file_update_sql = "";

    // Check if a new file is uploaded
    if (isset($_FILES['new_file']) && $_FILES['new_file']['error'] == 0) {
        $allowed_ext = ['pdf'];
        $filename = $_FILES['new_file']['name'];
        $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (in_array($file_ext, $allowed_ext)) {
            // 1. Fetch old file path to delete it from disk storage
            $old_file_check = $conn->query("SELECT file FROM research_articles WHERE id = $article_id");
            if ($old_file_check && $old_file_check->num_rows > 0) {
                $old_file_row = $old_file_check->fetch_assoc();
                $clean_path = str_replace('../', '', $old_file_row['file']);
                $physical_old_file = "../" . $clean_path;
                
                if (!empty($old_file_row['file']) && file_exists($physical_old_file)) {
                    unlink($physical_old_file); // Remove old PDF
                }
            }

            // 2. Upload the new file
            $unique_filename = time() . '_' . uniqid() . '.' . $file_ext;
            $upload_dir = '../uploads/'; 
            
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            if (move_uploaded_file($_FILES['new_file']['tmp_name'], $upload_dir . $unique_filename)) {
                $db_file_path = 'uploads/' . $unique_filename;
                $file_update_sql = ", file = '$db_file_path'";
            }
        } else {
            $message = "Invalid file type. Only PDF documents are allowed.";
            $messageClass = "alert-danger";
        }
    }

    // Process update query if no prior errors occurred
    if ($messageClass !== "alert-danger") {
        $update_sql = "UPDATE research_articles SET 
                        title = '$up_title', 
                        author = '$up_author', 
                        abstract = '$up_abstract', 
                        grade_level = '$up_grade', 
                        strand = '$up_strand', 
                        research_category = '$up_category',
                        research_type = '$up_type',
                        research_design = '$up_design',
                        year_completed = '$up_year'
                        $file_update_sql 
                      WHERE id = $article_id";

        if ($conn->query($update_sql) === TRUE) {
            $message = "Article modifications and file changes successfully applied!";
            $messageClass = "alert-success";
        } else {
            $message = "Update failure: " . $conn->error;
            $messageClass = "alert-danger";
        }
    }
}

// ==========================================
// 2. RETRIEVE CURRENT RECORDSETS FROM DATA
// ==========================================
$articles_sql = "SELECT * FROM research_articles ORDER BY id DESC";
$articles_result = $conn->query($articles_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Published Catalog - CCNHS Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"> 
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; } 
        .sidebar { min-height: 100vh; background-color: #fff; border-right: 1px solid #dee2e6; } 
        .sidebar .nav-link { color: #495057; font-weight: 500; padding: 0.75rem 1.25rem; border-radius: 0.375rem; margin-bottom: 0.25rem; } 
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background-color: #f0e6ff; color: #6f42c1; } 
        .sidebar .nav-link.active { border-left: 4px solid #7e3af2; border-top-left-radius: 0; border-bottom-left-radius: 0; } 
    </style>
    <link rel="icon" type="image/png" href="../img/admin.png"/>
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
                    <li class="nav-item"><a class="nav-link" href="admin_research.php"><i class="bi bi-file-earmark-text me-2"></i> Submission Queue</a></li>
                    <li class="nav-item"><a class="nav-link active" href="admin_published.php"><i class="bi bi-file-earmark-text me-2"></i> Published Articles</a></li>
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

            <?php if (!empty($message)): ?> 
                <div class="alert <?php echo $messageClass; ?> alert-dismissible fade show" role="alert"> 
                    <?php echo $message; ?> 
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>    
                </div>       
            <?php endif; ?> 
            
            <div class="pt-3 pb-2 mb-3 border-bottom">
                 <h1 class="h2 fw-bold text-dark mb-1 pt-1">Published Research Articles</h1>
            </div>

            <div class="card mb-5 border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="table-responsive">
                    <table class="table align-middle mb-0 table-hover">
                        <thead class="table-light"> 
                            <tr>
                                <th class="ps-4" style="width: 45%;">Article Profiles & Meta Metrics</th>
                                <th style="width: 20%;">Scope Framework</th>
                                <th style="width: 15%;">Classification Academic</th>
                                <th class="text-end pe-4" style="width: 20%;">Directory Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($articles_result && $articles_result->num_rows > 0): ?>
                                <?php while($art = $articles_result->fetch_assoc()): ?>
                                    <tr>
                                        <td class="ps-4 py-3">
                                            <div class="fw-bold text-dark mb-1"><?php echo htmlspecialchars($art['title']); ?></div>
                                            <div class="text-muted small mb-1">
                                                <i class="bi bi-person me-1"></i><?php echo htmlspecialchars($art['author']); ?>
                                                <span class="text-dark-50 mx-1">|</span>
                                                <i class="bi bi-calendar3 me-1"></i>Year: <?php echo htmlspecialchars($art['year_completed']); ?>
                                            </div>
                                            
                                            <div class="text-secondary small text-truncate mb-2" style="max-width: 400px; font-style: italic;">
                                                "<?php echo htmlspecialchars($art['abstract']); ?>"
                                            </div>

                                            <a href="../<?php echo htmlspecialchars($art['file']); ?>" target="_blank" class="btn btn-light btn-sm py-1 px-2 border text-success small">
                                                <i class="bi bi-file-pdf me-1 text-danger"></i> View Published PDF
                                            </a>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column gap-1 align-items-start">
                                                <span class="badge bg-primary-subtle text-primary text-uppercase px-2 py-1 small" style="font-size: 0.7rem;">
                                                    <?php echo !empty($art['research_category']) ? htmlspecialchars($art['research_category']) : 'General'; ?>
                                                </span>
                                                <span class="badge bg-secondary-subtle text-dark text-uppercase px-2 py-1 small" style="font-size: 0.7rem;">
                                                    <?php echo !empty($art['research_type']) ? htmlspecialchars($art['research_type']) : 'Not Specified'; ?>
                                                </span>
                                                <span class="badge bg-secondary-subtle text-dark text-uppercase px-2 py-1 small" style="font-size: 0.7rem;">
                                                    <?php echo !empty($art['research_design']) ? htmlspecialchars($art['research_design']) : 'Not Specified'; ?>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <small class="d-block text-dark"><strong>Grade:</strong> <?php echo htmlspecialchars($art['grade_level']); ?></small>
                                            <small class="d-block text-muted"><strong>Strand:</strong> <?php echo htmlspecialchars($art['strand']); ?></small>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" 
                                                        class="btn btn-outline-primary edit-btn"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editArticleModal"
                                                        data-id="<?php echo $art['id']; ?>"
                                                        data-title="<?php echo htmlspecialchars($art['title'], ENT_QUOTES); ?>"
                                                        data-author="<?php echo htmlspecialchars($art['author'], ENT_QUOTES); ?>"
                                                        data-abstract="<?php echo htmlspecialchars($art['abstract'], ENT_QUOTES); ?>"
                                                        data-grade="<?php echo htmlspecialchars($art['grade_level'], ENT_QUOTES); ?>"
                                                        data-strand="<?php echo htmlspecialchars($art['strand'], ENT_QUOTES); ?>"
                                                        data-category="<?php echo htmlspecialchars($art['research_category'], ENT_QUOTES); ?>"
                                                        data-type="<?php echo htmlspecialchars($art['research_type'], ENT_QUOTES); ?>"
                                                        data-design="<?php echo htmlspecialchars($art['research_design'], ENT_QUOTES); ?>"
                                                        data-year="<?php echo htmlspecialchars($art['year_completed'], ENT_QUOTES); ?>">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </button>
                                                <a href="admin_published.php?action=delete&id=<?php echo $art['id']; ?>" 
                                                   class="btn btn-outline-danger" 
                                                   onclick="return confirm('Are you sure you want to completely purge this published catalog piece and delete its source files? This cannot be undone.');">
                                                    <i class="bi bi-trash3"></i> Delete
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="text-center py-4 text-muted">There are no published documents in the active repository catalogue yet.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- ==========================================
      RE-ENGINEERED STRUCTURAL EDIT MODAL
     ========================================== -->
<div class="modal fade" id="editArticleModal" tabindex="-1" aria-labelledby="editArticleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-header bg-dark text-white p-3">
                    <h5 class="modal-title fs-6" id="editArticleModalLabel"><i class="bi bi-sliders2 me-2"></i> Alter Published Article Parameters</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="article_id" id="modal_article_id">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Manuscript Project Title</label>
                        <input type="text" name="title" id="modal_title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Primary Lead Authors</label>
                        <input type="text" name="author" id="modal_author" class="form-control" required>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Research Category</label>
                            <select name="research_category" id="modal_category" class="form-select" required>
                                <option value="Science and Technology">Science and Technology</option>
                                <option value="Education">Education</option>
                                <option value="Business">Business</option>
                                <option value="Health">Health</option>
                            </select>
                    </div>

                    <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Research Type</label>
                            <select name="research_type" id="modal_type" class="form-select" required>
                                <option value="Qualitative">Qualitative</option>
                                <option value="Quantitative">Quantitative</option>
                                <option value="Mixed Methods">Mixed Methods</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-secondary">Research Design</label>
                            <select name="research_design" class="form-select rounded-3" required>
                                <option value="" disabled selected>- Select Research Design -</option>
                                
                                <!-- Qualitative Category -->
                                <optgroup label="Qualitative Research Design">
                                    <option value="Phenomenology">Phenomenology</option>
                                    <option value="Grounded Theory">Grounded Theory</option>
                                    <option value="Ethnography">Ethnography</option>
                                    <option value="Historical Study">Historical Study</option>
                                    <option value="Case Study">Case Study</option>
                                    <option value="Qualitative - Others">Others (please specify)</option>
                                </optgroup>

                                <!-- Quantitative Category -->
                                <optgroup label="Quantitative Research Design">
                                    <option value="Descriptive">Descriptive</option>
                                    <option value="Correlational">Correlational</option>
                                    <option value="Causal-comparative">Causal-comparative</option>
                                    <option value="Quasi-experimental">Quasi-experimental</option>
                                    <option value="Experimental">Experimental</option>
                                    <option value="Quantitative - Others">Others (please specify)</option>
                                </optgroup>

                                <!-- Mixed-method Category -->
                                <optgroup label="Mixed-method Research Design">
                                    <option value="Sequential Explanatory Design">Sequential Explanatory Design</option>
                                    <option value="Sequential Exploratory Design">Sequential Exploratory Design</option>
                                    <option value="Sequential Transformative Design">Sequential Transformative Design</option>
                                    <option value="Concurrent Triangulation Design">Concurrent Triangulation Design</option>
                                    <option value="Concurrent Embedded Design">Concurrent Embedded Design</option>
                                    <option value="Concurrent Transformative Design">Concurrent Transformative Design</option>
                                </optgroup>
                            </select>
                        </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Grade Classification Group</label>
                            <select name="grade_level" id="modal_grade" class="form-select" required>
                                <option value="STE">STE (Science, Technology, Engineering)</option>
                                <option value="Grade 11">Grade 11</option>
                                <option value="Grade 12">Grade 12</option>
                                <option value="Faculty / Teacher">Faculty / Teacher</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Track Strand Academic Domain</label>
                            <select name="strand" id="modal_strand" class="form-select" required>
                                <option value="STE">STE (Science, Technology, Engineering)</option>
                                <option value="STEM">STEM (Science, Technology, Engineering, Math)</option>
                                <option value="ABM">ABM (Accountancy, Business, Management)</option>
                                <option value="HUMSS">HUMSS (Humanities and Social Sciences)</option>
                                <option value="GAS">GAS (General Academic Strand)</option>
                                <option value="TVL">TVL (Technical-Vocational-Livelihood)</option>
                                <option value="Not Applicable">Not Applicable / Faculty</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Year Completed</label>
                        <input type="number" name="year_completed" id="modal_year" class="form-control" min="1900" max="2026" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Executive Project Abstract Text Documentation</label>
                        <textarea name="abstract" id="modal_abstract" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="mb-1">
                        <label class="form-label small fw-semibold text-secondary">Replace Attached Manuscript PDF <span class="text-muted fw-normal">(Leave blank to keep existing file)</span></label>
                        <input type="file" name="new_file" class="form-control" accept=".pdf">
                    </div>
                </div>
                <div class="modal-footer border-top-0 px-4 py-3 bg-light">
                    <button type="button" class="btn btn-secondary btn-sm rounded px-3" data-bs-dismiss="modal">Close Window</button>
                    <button type="submit" name="submit_update" class="btn btn-primary btn-sm rounded px-3 shadow-sm"><i class="bi bi-save2 me-1"></i> Apply Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> 
<script>
// Dynamic parameter mapping into modal components on request actions
document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function() {
        document.getElementById('modal_article_id').value = this.getAttribute('data-id');
        document.getElementById('modal_title').value = this.getAttribute('data-title');
        document.getElementById('modal_author').value = this.getAttribute('data-author');
        document.getElementById('modal_abstract').value = this.getAttribute('data-abstract');
        document.getElementById('modal_grade').value = this.getAttribute('data-grade');
        document.getElementById('modal_strand').value = this.getAttribute('data-strand');
        document.getElementById('modal_category').value = this.getAttribute('data-category');
        document.getElementById('modal_type').value = this.getAttribute('data-type');
        document.getElementById('modal_year').value = this.getAttribute('data-year');
    });
});
</script>
</body>
</html>
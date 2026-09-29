<?php
include '../database.php';

$message = "";
$messageClass = "";

// ADD ANNOUNCEMENT
if (isset($_POST['add_announcement'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $date_posted = mysqli_real_escape_string($conn, $_POST['date_posted']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
   
    // Query stripped down to basic text inputs only
    $query = "INSERT INTO announcements (title, author, description, date_posted) 
              VALUES ('$title', '$author', '$description', '$date_posted')";
              
    if (mysqli_query($conn, $query)) {
        header("Location: admin_announcements.php?success=1");
        exit();
    } else {
        $message = "Database Error: " . mysqli_error($conn);
        $messageClass = "alert-danger";
    }
}

// EDIT ANNOUNCEMENT
if (isset($_POST['edit_announcement'])) {
    $id = intval($_POST['id']);
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $description = $conn->real_escape_string($_POST['description']);
    $date_posted = $conn->real_escape_string($_POST['date_posted']);

    $sql = "UPDATE announcements SET title='$title', author='$author', description='$description', date_posted='$date_posted' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        $message = "Announcement updated successfully!";
        $messageClass = "alert-success";
    } else {
        $message = "Error: " . $conn->error;
        $messageClass = "alert-danger";
    }
}

// DELETE ANNOUNCEMENT
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM announcements WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        $message = "Announcement deleted successfully!";
        $messageClass = "alert-success";
    } else {
        $message = "Error: " . $conn->error;
        $messageClass = "alert-danger";
    }
}

if (isset($_GET['success'])) {
    $message = "New announcement published successfully!";
    $messageClass = "alert-success";
}

// FETCH ANNOUNCEMENTS (Removed unknown facebook_link and image columns)
$sql = "SELECT id, title, author, description, date_posted FROM announcements ORDER BY date_posted DESC, id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Announcement Manager - CCNHS Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="../img/admin.png"/>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background-color: #fff; border-right: 1px solid #dee2e6; }
        .sidebar .nav-link { color: #495057; font-weight: 500; padding: 0.75rem 1.25rem; border-radius: 0.375rem; margin-bottom: 0.25rem; }
        .sidebar .nav-link:hover { background-color: #f0e6ff; color: #6f42c1; }
        .sidebar .nav-link.active { background-color: #f0e6ff; color: #6f42c1; border-left: 4px solid #7e3af2; border-top-left-radius: 0; border-bottom-left-radius: 0; }
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
                    <li class="nav-item"><a class="nav-link active" href="admin_announcements.php"><i class="bi bi-megaphone me-2"></i> Announcements</a></li>
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
                <h1 class="h2 fw-bold text-dark mb-1">Announcement Manager</h1>
                <button class="btn text-white d-flex align-items-center gap-2" style="background-color: #7e3af2;" data-bs-toggle="modal" data-bs-target="#addAnnouncementModal">
                    <i class="bi bi-plus-lg"></i> Post Announcement
                </button>
            </div>

            <?php if (!empty($message)): ?>
                <div class="alert <?php echo $messageClass; ?> alert-dismissible fade show" role="alert">
                    <i class="bi bi-info-circle-fill me-2"></i><?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Table Container (Columns rearranged cleanly without Cover image layout) -->
            <div class="card mb-4 border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="table-responsive">
                    <table class="table align-middle mb-0 table-hover">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width: 30%;">Announcement Headline</th>
                                <th style="width: 40%;">Description Content</th>
                                <th style="width: 15%;">Date Posted</th>
                                <th class="text-end pe-4" style="width: 15%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result && $result->num_rows > 0): ?>
                                <?php while($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark mb-1"><?php echo htmlspecialchars($row['title']); ?></div>
                                            <div class="text-muted small"><i class="bi bi-person me-1"></i>By: <?php echo htmlspecialchars($row['author']); ?></div>
                                        </td>
                                        <td>
                                            <div class="text-secondary small text-truncate" style="max-width: 450px;">
                                                <?php echo htmlspecialchars($row['description']); ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-secondary small fw-medium">
                                                <?php echo date('M d, Y', strtotime($row['date_posted'])); ?>
                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="d-flex justify-content-end gap-2">
                                                <button class="btn btn-light btn-sm edit-btn text-secondary border" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editAnnouncementModal"
                                                        data-id="<?php echo $row['id']; ?>"
                                                        data-title="<?php echo htmlspecialchars($row['title'], ENT_QUOTES); ?>"
                                                        data-author="<?php echo htmlspecialchars($row['author'], ENT_QUOTES); ?>"
                                                        data-description="<?php echo htmlspecialchars($row['description'], ENT_QUOTES); ?>"
                                                        data-date="<?php echo $row['date_posted']; ?>">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </button>
                                                <a href="admin_announcements.php?delete=<?php echo $row['id']; ?>" 
                                                   class="btn btn-light btn-sm text-danger border"
                                                   onclick="return confirm('Permanently remove this announcement post?');">
                                                    <i class="bi bi-trash-fill"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="text-center py-4 text-muted">No announcements listed.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Modal Pop Up when Uploading New Announcements -->
<div class="modal fade" id="addAnnouncementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="admin_announcements.php" method="POST" class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-light">
                <h5 class="modal-title fw-bold text-dark">Post New Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 d-flex flex-column gap-3">
                <div>
                    <label class="form-label fw-semibold text-secondary small">Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Enter announcement headline" required>
                </div>
                <div>
                    <label class="form-label fw-semibold text-secondary small">Author / Department Publisher</label>
                    <input type="text" name="author" class="form-control" placeholder="e.g. Office of the Principal, Research Center" required>
                </div>
                <div>
                    <label class="form-label fw-semibold text-secondary small">Publishing Date Schedule</label>
                    <input type="date" name="date_posted" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <div>
                    <label class="form-label fw-semibold text-secondary small">Content Description Text</label>
                    <textarea name="description" class="form-control" rows="5" placeholder="Type core announcement paragraph fields here..." required></textarea>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" name="add_announcement" class="btn text-white" style="background-color: #7e3af2;">Publish Announcement</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Pop Up when Editing Announcements -->
<div class="modal fade" id="editAnnouncementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="admin_announcements.php" method="POST" class="modal-content border-0 shadow">
            <input type="hidden" name="id" id="edit-id">
            <div class="modal-header border-0 bg-light">
                <h5 class="modal-title fw-bold text-dark">Modify Announcement Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 d-flex flex-column gap-3">
                <div>
                    <label class="form-label fw-semibold text-secondary small">Title</label>
                    <input type="text" name="title" id="edit-title" class="form-control" required>
                </div>
                <div>
                    <label class="form-label fw-semibold text-secondary small">Author / Department Publisher</label>
                    <input type="text" name="author" id="edit-author" class="form-control" required>
                </div>
                <div>
                    <label class="form-label fw-semibold text-secondary small">Publishing Date Schedule</label>
                    <input type="date" name="date_posted" id="edit-date" class="form-control" required>
                </div>
                <div>
                    <label class="form-label fw-semibold text-secondary small">Content Description Text</label>
                    <textarea name="description" id="edit-description" class="form-control" rows="5" required></textarea>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" name="edit_announcement" class="btn text-white" style="background-color: #7e3af2;">Save Modifications</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function() {
        document.getElementById('edit-id').value = this.getAttribute('data-id');
        document.getElementById('edit-title').value = this.getAttribute('data-title');
        document.getElementById('edit-author').value = this.getAttribute('data-author');
        document.getElementById('edit-description').value = this.getAttribute('data-description');
        document.getElementById('edit-date').value = this.getAttribute('data-date');
    });
});
</script>
</body>
</html>
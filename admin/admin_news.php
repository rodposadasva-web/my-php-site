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
    $facebook_link = mysqli_real_escape_string($conn, $_POST['facebook_link']);

    // Initialize an empty array to track up to 5 image slots cleanly
    $img_slots = [null, null, null, null, null];
    
    // Check if files are uploaded through the input array
    if (!empty($_FILES['announcement_images']['name'][0])) {
        $target_dir = "../announcement_uploads/";
        
        // Ensure the directory exists; if not, create it dynamically
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        // Loop through uploaded files up to a maximum of 5 images
        $total_files = min(count($_FILES['announcement_images']['name']), 5);
        for ($i = 0; $i < $total_files; $i++) {
            if ($_FILES['announcement_images']['error'][$i] === UPLOAD_ERR_OK) {
                $original_name = basename($_FILES['announcement_images']['name'][$i]);
                $file_extension = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
                
                // Whitelist supported image formats
                if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    // Prepend a timestamp to guarantee a unique filename
                    $new_filename = time() . '_' . $i . '.' . $file_extension;
                    $target_file = $target_dir . $new_filename;
                    
                    if (move_uploaded_file($_FILES['announcement_images']['tmp_name'][$i], $target_file)) {
                        // Store just the clean filename string into our slots array
                        $img_slots[$i] = $new_filename;
                    }
                }
            }
        }
    }

    // Map out variable strings to use in your SQL statement columns
    $img1 = $img_slots[0];
    $img2 = $img_slots[1];
    $img3 = $img_slots[2];
    $img4 = $img_slots[3];
    $img5 = $img_slots[4];
   
    // Insert statement with safe string values
    $query = "INSERT INTO news (title, author, description, facebook_link, date_posted, image, image2, image3, image4, image5) 
              VALUES ('$title', '$author', '$description', '$facebook_link', '$date_posted', '$img1', '$img2', '$img3', '$img4', '$img5')";
              
    if (mysqli_query($conn, $query)) {
        header("Location: admin_news.php?success=1");
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
    $facebook_link = $conn->real_escape_string($_POST['facebook_link']);

    // Handle Optional New Image Upload
    if (!empty($_FILES['image']['name'])) {
        // FIXED: Point to your exact announcement uploads directory relative to the admin folder
        $target_dir = "../announcement_uploads/"; 
        $file_name = time() . '_' . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $file_name;
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        if (in_array($file_type, ['jpg', 'jpeg', 'png', 'gif'])) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // FIXED: Save only the clean filename (or relative path matching how your ADD logic inserts it)
                $image_path = $file_name; 
                // Update with new image
                $sql = "UPDATE news SET title='$title', author='$author', description='$description', image='$image_path', date_posted='$date_posted', facebook_link='$facebook_link' WHERE id=$id";
            }
        }
    } else {
        // Update without changing the existing image
        $sql = "UPDATE news SET title='$title', author='$author', description='$description', date_posted='$date_posted', facebook_link='$facebook_link' WHERE id=$id";
    }

    if (isset($sql) && $conn->query($sql) === TRUE) {
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
    $sql = "DELETE FROM news WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        $message = "Announcement deleted successfully!";
        $messageClass = "alert-success";
    } else {
        $message = "Error: " . $conn->error;
        $messageClass = "alert-danger";
    }
}

// 2. FETCH ANNOUNCEMENTS (Using accurate column layout)
$sql = "SELECT id, title, author, description, facebook_link, image, date_posted FROM news ORDER BY date_posted DESC, id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Latest News Manager - CCNHS Admin</title>
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
                    <li class="nav-item"><a class="nav-link" href="admin_spotlight.php"><i class="bi bi-star-fill me-2 text-warning"></i> Spotlight Feature</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_user.php"><i class="bi bi-people me-2"></i> Manage Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_viewRequest.php"><i class="bi bi-file-earmark-lock2 me-2"></i> DL Requests</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_research.php"><i class="bi bi-file-earmark-text me-2"></i> Submission Queue</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_published.php"><i class="bi bi-file-earmark-text me-2"></i> Published Articles</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_announcements.php"><i class="bi bi-megaphone me-2"></i> Announcements</a></li>
                    <li class="nav-item"><a class="nav-link active" href="admin_news.php"><i class="bi bi-megaphone me-2"></i> News</a></li>
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
                   <h1 class="h2 fw-bold text-dark mb-1">Latest News Manager</h1>
                <button class="btn text-white d-flex align-items-center gap-2" style="background-color: #7e3af2;" data-bs-toggle="modal" data-bs-target="#addAnnouncementModal">
                    <i class="bi bi-plus-lg"></i> Post News
                </button>
            </div>

            <?php if (!empty($message)): ?>
                <div class="alert <?php echo $messageClass; ?> alert-dismissible fade show" role="alert">
                    <i class="bi bi-info-circle-fill me-2"></i><?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card mb-4 border-0 shadow-sm rounded-3 overflow-hidden">
                <div class="table-responsive">
                    <table class="table align-middle mb-0 table-hover">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width: 10%;">Cover</th>
                                <th style="width: 25%;">Announcement Info</th>
                                <th style="width: 35%;">Description Content</th>
                                <th style="width: 15%;">Date Posted</th>
                                <th class="text-end pe-4" style="width: 15%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result && $result->num_rows > 0): ?>
                                <?php while($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <?php if(!empty($row['image'])): ?>
                                                <img src="../<?php echo htmlspecialchars($row['image']); ?>" class="thumbnail-img" alt="news image">
                                            <?php else: ?>
                                                <div class="thumbnail-img d-flex align-items-center justify-content-center text-muted">
                                                    <i class="bi bi-image small"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark mb-1"><?php echo htmlspecialchars($row['title']); ?></div>
                                            <div class="text-muted small"><i class="bi bi-person me-1"></i>By: <?php echo htmlspecialchars($row['author']); ?></div>
                                        </td>
                                        <td>
                                            <div class="text-secondary small text-truncate" style="max-width: 380px;">
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
                                                        data-date="<?php echo $row['date_posted']; ?>"
                                                        data-facebook-link="<?php echo htmlspecialchars($row['facebook_link'], ENT_QUOTES); ?>">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </button>
                                                <a href="admin_news.php?delete=<?php echo $row['id']; ?>" 
                                                   class="btn btn-light btn-sm text-danger border"
                                                   onclick="return confirm('Permanently wipe this post announcement item out of active registers?');">
                                                    <i class="bi bi-trash-fill"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="5" class="text-center py-4 text-muted">No news listed.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<div class="modal fade" id="addAnnouncementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="admin_news.php" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow">
            <div class="modal-header border-0 bg-light">
                <h5 class="modal-title fw-bold text-dark">Post New Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 d-flex flex-column gap-3">
                <div>
                    <label class="form-label fw-semibold text-secondary small">Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Enter headline title" required>
                </div>
                <div>
                    <label class="form-label fw-semibold text-secondary small">Author / Department Publisher</label>
                    <input type="text" name="author" class="form-control" placeholder="e.g. Office of the Principal, Admin Desk" required>
                </div>
                <div>
                    <label class="form-label fw-semibold text-secondary small">Publishing Date Schedule</label>
                    <input type="date" name="date_posted" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
                
                <div>
                    <label class="form-label fw-semibold text-secondary small">Facebook Post Link (Optional)</label>
                    <input type="url" name="facebook_link" class="form-control" placeholder="https://www.facebook.com/permalink.php?story_fbid=...">
                    <div class="form-text text-muted" style="font-size: 0.72rem;">
                        Paste the specific Facebook post link created for this announcement here.
                    </div>
                </div>

                <div>
                    <label class="form-label fw-semibold text-secondary small">Content Description Text</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Type core announcement paragraph fields here..." required></textarea>
                </div>
                <div>
                    <label class="form-label fw-semibold text-secondary small">Attach Media Files (Max 5 images)</label>
                    <input type="file" name="announcement_images[]" class="form-control" accept="image/*" multiple>
                    <div class="form-text text-muted" style="font-size: 0.75rem;">
                        <i class="bi bi-info-circle-fill text-primary"></i> Hold <strong>Ctrl</strong> (Windows) or <strong>Cmd</strong> (Mac) to select multiple photos.
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" name="add_announcement" class="btn text-white" style="background-color: #7e3af2;">Publish Announcement</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="editAnnouncementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="admin_news.php" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow">
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
                    <label class="form-label fw-semibold text-secondary small">Facebook Post Link</label>
                    <input type="url" name="facebook_link" id="edit-facebook-link" class="form-control" required>
                </div>
                <div>
                    <label class="form-label fw-semibold text-secondary small">Content Description Text</label>
                    <textarea name="description" id="edit-description" class="form-control" rows="4" required></textarea>
                </div>
                <div>
                    <label class="form-label fw-semibold text-secondary small">Replace Cover Photo (Leave blank to keep current)</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" name="edit_announcement" class="btn text-white" style="background-color: #7e3af2;">Save System Alterations</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Bridge data row arrays securely across target interactive inputs
document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function() {
        document.getElementById('edit-id').value = this.getAttribute('data-id');
        document.getElementById('edit-title').value = this.getAttribute('data-title');
        document.getElementById('edit-author').value = this.getAttribute('data-author');
        document.getElementById('edit-description').value = this.getAttribute('data-description');
        document.getElementById('edit-date').value = this.getAttribute('data-date');
        document.getElementById('edit-facebook-link').value = this.getAttribute('data-facebook-link') || '';
    });
});
</script>
</body>
</html>
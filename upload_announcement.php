<?php
include 'database.php';

$message = "";

if(isset($_POST['upload'])){
    // Sanitize inputs to prevent SQL errors from quotes/apostrophes
    $title       = mysqli_real_escape_string($conn, $_POST['title']);
    $author      = mysqli_real_escape_string($conn, $_POST['author']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $date        = $_POST['date_posted'];

    /* IMAGE UPLOAD LOGIC */
    $image = $_FILES['image']['name'];
    $tmp   = $_FILES['image']['tmp_name'];
    $target_dir = "announcement_uploads/";

    // Ensure the directory exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if(move_uploaded_file($tmp, $target_dir . $image)){
        /* INSERT QUERY */
        $query = "INSERT INTO announcements (title, author, description, image, date_posted) 
                  VALUES ('$title', '$author', '$description', '$image', '$date')";
        
        if(mysqli_query($conn, $query)){
            $message = "<div class='alert alert-success'>Announcement posted successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
        }
    } else {
        $message = "<div class='alert alert-warning'>Failed to upload image.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Announcement | CCNHS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; }
        .announcement-card { 
            max-width: 700px; 
            margin: 50px auto; 
            border: none; 
            border-radius: 12px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.08); 
        }
        .header-accent { color: #0099ab; font-weight: 700; }
        .btn-upload { background-color: #0099ab; border: none; color: white; transition: 0.3s; }
        .btn-upload:hover { background-color: #007c8a; color: white; transform: translateY(-2px); }
    </style>
</head>
<body>

<div class="container">
    <div class="card announcement-card p-4 p-md-5">
        <div class="text-center mb-4">
            <h2 class="header-accent">Post New Announcement</h2>
            <p class="text-muted">Fill out the details below to notify the campus.</p>
        </div>
        
        <?php echo $message; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label fw-semibold">Announcement Title</label>
                    <input type="text" name="title" class="form-control" placeholder="What's happening?" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Author/Department</label>
                    <input type="text" name="author" class="form-control" placeholder="Admin, Principal, etc." required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Date Posted</label>
                    <input type="date" name="date_posted" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Content Description</label>
                    <textarea name="description" class="form-control" rows="6" placeholder="Provide full details of the announcement..." required></textarea>
                </div>

                <div class="col-12">
                    <label class="form-label fw-semibold">Cover Image / Poster</label>
                    <div class="input-group">
                        <input type="file" name="image" class="form-control" id="inputGroupFile02" accept="image/*" required>
                    </div>
                    <small class="text-muted">Accepted formats: JPG, PNG, GIF</small>
                </div>

                <div class="col-12 mt-4">
                    <button type="submit" name="upload" class="btn btn-upload btn-lg w-100">
                        Publish Announcement
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
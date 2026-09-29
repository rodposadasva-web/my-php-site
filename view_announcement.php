<?php
include 'database.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$query = mysqli_query($conn, "SELECT * FROM news WHERE id='$id'");
$row = mysqli_fetch_assoc($query);

if (!$row) {
    echo "<div class='container text-center py-5'><h3>News Article not found.</h3><a href='news.php' class='btn btn-primary'>Back</a></div>";
    exit();
}

// Filter and collect only the image paths that actually exist in the database rows
$gallery = [];
for ($m = 1; $m <= 5; $m++) {
    $col_key = ($m === 1) ? 'image' : 'image' . $m;
    if (!empty($row[$col_key])) {
        $gallery[] = $row[$col_key];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/CCNHS.png">
    <title>
        <?php echo htmlspecialchars($row['title']); ?>
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body{
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .breadcrumb-text{
            font-size: 14px;
            font-weight: 600;
            color: #0091a8;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .container{
            width: 80%;
            max-width: 900px;
            margin: 40px auto;
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        /* Enforce structured boundaries for the new primary featured gallery position */
        .main-view-img {
            width: 100%;
            height: 480px;
            object-fit: cover;
            border-radius: 6px;
        }

        /* Thumbnails custom layout constraints */
        .thumb-box {
            height: 90px;
            overflow: hidden;
            border-radius: 4px;
            border: 2px solid transparent;
            transition: all 0.2s ease-in-out;
        }
        .thumb-box:hover {
            border-color: #7e3af2;
        }
        .thumb-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            cursor: pointer;
        }

        h1{
            color: #222;
            font-size: 2.2rem;
        }

        .meta{
            color: gray;
            margin-bottom: 30px;
            font-size: 0.95rem;
        }

        .description{
            font-size: 18px;
            line-height: 1.8;
            color: #333;
            text-align: justify;
        }
        .facebook-meta-btn {
            color: #1877F2;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 2px 8px;
            border-radius: 4px;
            transition: all 0.2s ease-in-out;
            background-color: rgba(24, 119, 242, 0.05);
        }
        .facebook-meta-btn:hover {
            background-color: #1877F2;
            color: white !important;
        }
        /* Ensures the icon changes white on hover along with the text */
        .facebook-meta-btn:hover i {
            color: white !important;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="breadcrumb-text">
        <a href="news.php" class="text-decoration-none" style="color: #0091a8;">
            <i class="bi bi-chevron-double-left"></i>
            <i class="bi bi-house-door-fill"></i>
            GO BACK
        </a>
    </div>

   <?php if (!empty($gallery)): ?>
        <div class="announcement-gallery-wrapper mb-4">
            
            <div class="featured-image-box mb-2">
                <?php 
                // Checks if the database path already contains the folder, otherwise prepends 'announcement_uploads/'
                $main_image_path = (strpos($gallery[0], 'announcement_uploads/') !== false) ? $gallery[0] : 'announcement_uploads/' . $gallery[0];
                ?>
                <img src="<?php echo $main_image_path; ?>" alt="Featured News Image" class="main-view-img img-fluid">
            </div>
            
            <?php if (count($gallery) > 1): ?>
                <div class="row g-2">
                    <?php for ($img_idx = 1; $img_idx < count($gallery); $img_idx++): 
                        $thumb_image_path = (strpos($gallery[$img_idx], 'announcement_uploads/') !== false) ? $gallery[$img_idx] : 'announcement_uploads/' . $gallery[$img_idx];
                    ?>
                        <div class="col-3 col-sm-2">
                            <div class="thumb-box shadow-sm border rounded">
                                <img src="<?php echo $thumb_image_path; ?>" alt="Thumbnail Grid Item" class="thumbnail-click-trigger">
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
            
        </div>
    <?php else: ?>
        <div class="bg-light text-center text-muted py-5 rounded mb-4">
            <i class="bi bi-image fs-1 d-block mb-2"></i> No Media Attached to this News Article
        </div>
    <?php endif; ?>

    <h1>
        <b><?php echo htmlspecialchars($row['title']); ?></b>
    </h1>

    <div class="meta d-flex align-items-center flex-wrap gap-2">
        <span>by <?php echo htmlspecialchars($row['author']); ?></span>
        <span class="text-muted">|</span>
        <span>
            <i class="bi bi-calendar3"></i> <?php echo date("F d, Y", strtotime($row['date_posted'])); ?>
        </span>
        
        <?php if (!empty($row['facebook_link'])): ?>
            <span class="text-muted">|</span>
            <a href="<?php echo htmlspecialchars($row['facebook_link']); ?>" 
               target="_blank" 
               class="facebook-meta-btn text-decoration-none d-inline-flex align-items-center gap-1" 
               title="View Original Post">
                <i class="bi bi-facebook" style="color: #1877F2; font-size: 1.05rem;"></i> 
                <span>View on Facebook</span>
            </a>
        <?php endif; ?>
    </div>
    <div class="description">
        <?php echo nl2br(htmlspecialchars($row['description'])); ?>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const thumbnails = document.querySelectorAll(".thumbnail-click-trigger");
    
    thumbnails.forEach(thumb => {
        thumb.addEventListener("click", function() {
            const parentGallery = this.closest(".announcement-gallery-wrapper");
            const mainFeaturedImg = parentGallery.querySelector(".main-view-img");
            
            // Execute path reference swap cycle smoothly
            const oldFeaturedSrc = mainFeaturedImg.src;
            mainFeaturedImg.src = this.src;
            this.src = oldFeaturedSrc;
        });
    });
});
</script>

</body>
</html>
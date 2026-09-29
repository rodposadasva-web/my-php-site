<?php
// 1. Initialize session storage to verify who is logged in
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'database.php';

// 2. Access Protection Check: Kick unauthorized visitors to the login screen
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); 
    exit();
}

// Assign active student identity context parameters
$logged_user = $_SESSION['username']; 
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// 3. Fetch primary manuscript dataset details
$query = mysqli_query($conn, "SELECT * FROM research_articles WHERE id='$id'");
$row = mysqli_fetch_assoc($query);

if (!$row) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Research article not found.</div></div>";
    exit();
}

$is_approved_for_download = false;
$has_pending_request = false;

// 4. Query evaluation filtered strictly by the logged-in user's account name
$check_status = $conn->query("SELECT status FROM download_requests WHERE article_id = '$id' AND user_name = '$logged_user' ORDER BY id DESC LIMIT 1");

if($check_status && $check_status->num_rows > 0) {
    $status_row = $check_status->fetch_assoc();
    if($status_row['status'] == 'Approved') {
        $is_approved_for_download = true;
    } elseif($status_row['status'] == 'Pending') {
        $has_pending_request = true;
    }
}

// 5. Handle Form Submission for Account Holders
if (isset($_POST['submit_download_request'])) {
    $title_prefix = mysqli_real_escape_string($conn, $_POST['title_prefix']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
    $school = mysqli_real_escape_string($conn, $_POST['school']);
    $school_address = mysqli_real_escape_string($conn, $_POST['school_address']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $region = mysqli_real_escape_string($conn, $_POST['region']);
    $email_address = mysqli_real_escape_string($conn, $_POST['email_address']);
    $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);
    $researcher_type = mysqli_real_escape_string($conn, $_POST['researcher_type']);
    $purpose = mysqli_real_escape_string($conn, $_POST['purpose']);
    $request_type = mysqli_real_escape_string($conn, $_POST['request_type'] ?? 'Download');

    $insert_query = "INSERT INTO download_requests 
        (article_id, user_name, title_prefix, first_name, last_name, middle_name, school, school_address, position, country, region, email_address, contact_number, researcher_type, purpose, request_type, status) 
        VALUES 
        ('$id', '$logged_user', '$title_prefix', '$first_name', '$last_name', '$middle_name', '$school', '$school_address', '$position', '$country', '$region', '$email_address', '$contact_number', '$researcher_type', '$purpose', '$request_type', 'Pending')";
                     
    if (mysqli_query($conn, $insert_query)) {
        echo "<script>
            alert('Your institutional access request has been submitted successfully! The administrator will review your purpose.');
            window.location.href = 'view_research.php?id=" . $id . "';
        </script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/CCNHS.png">
    <title><?php echo htmlspecialchars($row['title']); ?> - CCNHS Portal</title>
    <link rel="icon" href="img/CCNHS.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; color: #333; }
        .research-card { background: #ffffff; border: none; border-radius: 12px; }
        .meta-label { font-size: 0.75rem; text-transform: uppercase; font-weight: 700; color: #6c757d; letter-spacing: 0.5px; }
        .meta-value { font-size: 0.95rem; color: #212529; font-weight: 500; }
        .abstract-box { font-size: 1rem; line-height: 1.7; color: #4a5568; text-align: justify; }
        .badge-pill { padding: 0.4rem 0.75rem; border-radius: 50px; font-weight: 500; font-size: 0.8rem; }
    </style>
</head>
<body>

<div class="container py-4">
    <div class="mb-4">
        <a href="research.php" class="text-decoration-none text-secondary small fw-medium">
            <i class="bi bi-arrow-left me-1"></i> Back to Catalog Discovery
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="research-card shadow-sm p-4 p-md-5 mb-4">
                
                <span class="badge bg-primary-subtle text-primary mb-3 badge-pill text-uppercase">
                    <i class="bi bi-journal-bookmark-fill me-1"></i> <?php echo htmlspecialchars($row['research_category'] ?? 'General Research'); ?>
                </span>
                
                <h1 class="fw-bold text-dark lh-sm mb-3" style="font-size: 1.85rem;">
                    <?php echo htmlspecialchars($row['title']); ?>
                </h1>

                <div class="d-flex flex-wrap gap-3 align-items-center mb-4 pb-3 border-bottom text-muted small">
                    <div><i class="bi bi-person-fill me-1"></i> <strong><?php echo htmlspecialchars($row['author']); ?></strong></div>
                    <div>
                        <i class="bi bi-calendar3 me-1"></i> Year Completed: <strong><?php echo htmlspecialchars($row['year_completed']); ?></strong>
                    </div>
                   <!-- 1. Handle Research Type independently -->
                    <?php if (!empty($row['research_type'])): ?>
                    <div>
                        <i class="bi bi-tags-fill me-1"></i> Research Type: <span class="badge bg-secondary-subtle text-dark text-uppercase rounded-pill px-2" style="font-size:0.75rem;"><?php echo htmlspecialchars($row['research_type']); ?></span>
                    </div>
                    <?php endif; ?>

                    <!-- 2. Handle Research Design independently -->
                    <?php if (!empty($row['research_design'])): ?>
                    <div>
                        <i class="bi bi-compass-fill me-1"></i> Research Design: <span class="badge bg-secondary-subtle text-dark text-uppercase rounded-pill px-2" style="font-size:0.75rem;"><?php echo htmlspecialchars($row['research_design']); ?></span>
                    </div>
                    <?php endif; ?>
                </div>

                <h5 class="fw-bold text-dark mb-3">Abstract</h5>
                <div class="abstract-box p-3 bg-light rounded-3 border-start border-3 border-secondary-subtle">
                    <?php echo nl2br(htmlspecialchars($row['abstract'])); ?>
                </div>

                <div class="mt-5 p-4 rounded-3 text-center border bg-white shadow-sm">
                    <?php if ($is_approved_for_download): ?>
                        <div class="text-success mb-2"><i class="bi bi-check-circle-fill fs-2"></i></div>
                        <h6 class="fw-bold text-dark mb-2">Request Approved! File Unlocked.</h6>
                        <p class="text-muted small mx-auto mb-4" style="max-width: 500px;">
                            The administrative council has granted access clearance for your account profile.
                        </p>
                        <?php if (!empty($row['file'])): ?>
                            <?php 
                            $clean_title = preg_replace('/[^A-Za-z0-9_\-]/', '_', $row['title']);
                            $clean_title = substr($clean_title, 0, 50); 
                            ?>
                            <a href="<?php echo trim($row['file']); ?>" 
                               download="<?php echo htmlspecialchars($clean_title); ?>_Manuscript.pdf" 
                               target="_blank" 
                               class="btn btn-success px-4 py-2 fw-semibold shadow-sm">
                                <i class="bi bi-download me-2"></i> Download Full PDF
                            </a>
                        <?php else: ?>
                            <button type="button" class="btn btn-secondary px-4 py-2 fw-semibold" disabled>
                                <i class="bi bi-exclamation-triangle me-2"></i> No File Attached
                            </button>
                        <?php endif; ?>

                    <?php elseif ($has_pending_request): ?>
                        <div class="text-warning mb-2"><i class="bi bi-hourglass-split fs-2"></i></div>
                        <h6 class="fw-bold text-dark mb-2">Access Status: Request Pending</h6>
                        <p class="text-muted small mx-auto mb-0" style="max-width: 500px;">
                            Your download validation file parameters are currently awaiting administrative review clearance.
                        </p>

                    <?php else: ?>
                        <div class="text-warning mb-2"><i class="bi bi-lock-fill fs-2"></i></div>
                        <h6 class="fw-bold text-dark mb-2">Manuscript File Access is Restricted</h6>
                        <div class="alert alert-secondary mx-auto mb-3 small text-start" style="max-width: 550px;">
                            <i class="bi bi-info-circle me-1"></i> Logged in as: <strong><?php echo htmlspecialchars($logged_user); ?></strong>.<br>Institutional guidelines require you to submit an academic purpose log entry statement before downloading this resource.
                        </div>
                        <button type="button" class="btn btn-info text-white px-4 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#userRequestModal">
                            <i class="bi bi-clipboard-check-fill me-2"></i>Open Download Access Form
                        </button>
                    <?php endif; ?>
                </div>

            </div>
        </div>

        <div class="col-lg-4">
            <div class="research-card shadow-sm p-4">
                <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">Document Index Properties</h5>
                
                <div class="mb-3">
                    <div class="meta-label"><i class="bi bi-mortarboard-fill me-1"></i> Grade Level</div>
                    <div class="meta-value mt-1">
                        <?php echo !empty($row['grade_level']) ? htmlspecialchars($row['grade_level']) : '<span class="text-muted italic">Not Specified</span>'; ?>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="meta-label"><i class="bi bi-book-half"></i> Strand / Track</div>
                    <div class="meta-value mt-1">
                        <?php echo !empty($row['strand']) ? htmlspecialchars($row['strand']) : '<span class="text-muted italic">Not Specified</span>'; ?>
                    </div>
                </div>

                <hr class="text-muted my-3">

                <div class="mb-3">
                    <div class="meta-label">Publisher Institution</div>
                    <div class="meta-value mt-1">Calasiao Comprehensive National High School (CCNHS)</div>
                </div>

                <div class="mb-3">
                    <div class="meta-label">Document Citation Index Reference</div>
                    <div class="p-2 border rounded bg-light font-monospace text-secondary mt-1" style="font-size: 0.75rem; word-break: break-all;">
                        <?php echo htmlspecialchars($row['author']); ?>. (<?php echo htmlspecialchars($row['year_completed']); ?>). <em><?php echo htmlspecialchars($row['title']); ?></em>. CCNHS Archives.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="userRequestModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header bg-light border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-dark">
                    <i class="bi bi-clipboard-check-fill me-2 text-primary"></i> Request Access Form
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <form action="" method="POST">
                <div class="modal-body px-4 py-4" style="background-color: #fdfdfd;">
                    
                    <div class="p-3 mb-4 rounded-2 border-start border-4 border-info" style="background-color: #eef9fd;">
                        <div class="small text-secondary fw-semibold">
                            Title: <span class="text-dark fw-bold"><?php echo htmlspecialchars($row['title']); ?></span>
                        </div>
                        <div class="small text-secondary fw-semibold mt-1">
                            Author(s): <span class="text-info-dark fw-bold"><?php echo htmlspecialchars($row['author']); ?></span>
                        </div>
                    </div>

                    <div class="text-muted small italic mb-3">Please fill up the request access form</div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <label class="form-label small fw-bold text-uppercase text-secondary" style="font-size: 0.75rem;">Title</label>
                            <input type="text" name="title_prefix" class="form-control" placeholder="ex. Mr / Ms" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold text-uppercase text-secondary" style="font-size: 0.75rem;">First Name</label>
                            <input type="text" name="first_name" class="form-control" placeholder="Juan" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold text-uppercase text-secondary" style="font-size: 0.75rem;">Last Name</label>
                            <input type="text" name="last_name" class="form-control" placeholder="Dela Cruz" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold text-uppercase text-secondary" style="font-size: 0.75rem;">Middle Name</label>
                            <input type="text" name="middle_name" class="form-control" placeholder="Middlename">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase text-secondary" style="font-size: 0.75rem;">What type of researcher are you?</label>
                        <select id="researcherType" name="researcher_type" class="form-select" onchange="updateDynamicField()">
                            <option value="Student" selected>Student</option>
                            <option value="Teacher">Teacher/ Non Teaching</option>
                            <option value="External">External Researcher</option>
                        </select>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-uppercase text-secondary" style="font-size: 0.75rem;">School</label>
                            <input type="text" name="school" class="form-control" value="Calasiao Comprehensive National High School" readonly style="background-color: #f1f3f5;">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-uppercase text-secondary" style="font-size: 0.75rem;">School Address</label>
                            <input type="text" name="school_address" class="form-control" placeholder="e.g. Calasiao, Pangasinan">
                        </div>
                        
                        <!-- Dynamic Column: Starts as Grade Level because Student is selected by default -->
                        <div class="col-md-4">
                            <label id="dynamicLabel" class="form-label small fw-bold text-uppercase text-secondary" style="font-size: 0.75rem;">Grade Level</label>
                            <input type="text" id="dynamicInput" name="researcher_profile" class="form-control" placeholder="e.g. Grade 11 / Grade 12">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-secondary" style="font-size: 0.75rem;">Country</label>
                            <input type="text" name="country" class="form-control" value="Philippines">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-secondary" style="font-size: 0.75rem;">Region</label>
                            <input type="text" name="region" class="form-control" placeholder="ex. Region I">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-secondary" style="font-size: 0.75rem;">Email Address</label>
                            <input type="email" name="email_address" class="form-control" placeholder="email@example.com" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-secondary" style="font-size: 0.75rem;">Contact Number</label>
                            <input type="text" name="contact_number" class="form-control" placeholder="09123456789">
                        </div>
                    </div>


                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase text-secondary" style="font-size: 0.75rem;">Purpose</label>
                        <textarea name="purpose" class="form-control" rows="3" placeholder="Briefly state why you need this research..." required></textarea>
                    </div>

                </div>
                
                <div class="modal-footer bg-light border-0 px-4 pb-4">
                    <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal" style="background-color: #6c757d;">Close</button>
                    <button type="submit" name="submit_download_request" class="btn text-white px-4" style="background-color: #17a2b8;">
                        <i class="bi bi-send-fill me-2" style="font-size: 0.85rem;"></i>Send Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateDynamicField() {
    const researcherType = document.getElementById('researcherType').value;
    const dynamicLabel = document.getElementById('dynamicLabel');
    const dynamicInput = document.getElementById('dynamicInput');

    // Clear the field value whenever they change user types so data doesn't get mixed up
    dynamicInput.value = '';

    if (researcherType === 'Student') {
        dynamicLabel.textContent = 'Grade Level';
        dynamicInput.placeholder = 'e.g. Grade 11 / Grade 12';
    } else if (researcherType === 'Teacher') {
        dynamicLabel.textContent = 'Position';
        dynamicInput.placeholder = 'e.g. Teacher I, Master Teacher, etc.';
    } else if (researcherType === 'External') {
        dynamicLabel.textContent = 'Position / Affiliation';
        dynamicInput.placeholder = 'e.g. Professor, Independent Consultant';
    }
}

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
include 'database.php';

// Fallback checking to prevent breaking if a direct request is made without an explicit ID string parameter
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);

// Fetch target research publication metrics
$query = "SELECT * FROM research_articles WHERE id = $id LIMIT 1";
$result = $conn->query($query);

if (!$result || $result->num_rows === 0) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Research article not found.</div></div>";
    exit();
}

$row = $result->fetch_assoc();

// Form transaction processing execution for guest entries
if (isset($_POST['submit_download_request'])) {
    // Generate a structured placeholder guest identifier username tracking flag for tracking non-authenticated submissions
    $user_name = "Guest_" . substr(mdid(uniqid(rand(), true)), 0, 8);
    
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
    $request_type = mysqli_real_escape_string($conn, $_POST['request_type']);

    // Construct a composite display identity name string structure for basic logging columns matching existing datasets
    $guest_composite_name = trim($title_prefix . " " . $first_name . " " . $last_name);

    $insert_query = "INSERT INTO download_requests 
        (article_id, user_name, guest_name, guest_institution, title_prefix, first_name, last_name, middle_name, school, school_address, position, country, region, email_address, contact_number, researcher_type, purpose, request_type, status) 
        VALUES 
        ('$id', '$user_name', '$guest_composite_name', '$school', '$title_prefix', '$first_name', '$last_name', '$middle_name', '$school', '$school_address', '$position', '$country', '$region', '$email_address', '$contact_number', '$researcher_type', '$purpose', '$request_type', 'Pending')";
    
    if ($conn->query($insert_query)) {
        echo "<script>alert('Your access request has been sent successfully! The institutional review administrators will evaluate your request.'); window.location.href='guest_view_research.php?id=".$id."';</script>";
        exit();
    } else {
        echo "<script>alert('Database error: Unable to submit your request form.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($row['title']); ?> - CCNHS Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="img/CCNHS.png">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; color: #333; }
        .research-card { background: #ffffff; border: none; border-radius: 12px; }
        .meta-label { font-size: 0.75rem; text-uppercase: uppercase; font-weight: 700; color: #6c757d; letter-spacing: 0.5px; }
        .meta-value { font-size: 0.95rem; color: #212529; font-weight: 500; }
        .abstract-box { font-size: 1rem; line-height: 1.7; color: #4a5568; text-align: justify; }
        .badge-pill { padding: 0.4rem 0.75rem; border-radius: 50px; font-weight: 500; font-size: 0.8rem; }
    </style>
</head>
<body>

<!-- Basic Header / Breadcrumbs -->
<div class="container py-4">
    <div class="mb-4">
        <a href="guest_research.php" class="text-decoration-none text-secondary small fw-medium">
            <i class="bi bi-arrow-left me-1"></i> Back to Catalog Discovery
        </a>
    </div>

    <div class="row g-4">
        <!-- Left Side: Main Core Abstract Data Column Block -->
        <div class="col-lg-8">
            <div class="research-card shadow-sm p-4 p-md-5 mb-4">
                
                <span class="badge bg-primary-subtle text-primary mb-3 badge-pill text-uppercase tracking-wider">
                    <i class="bi bi-journal-bookmark-fill me-1"></i> <?php echo htmlspecialchars($row['category'] ?? 'Research Paper'); ?>
                </span>
                
                <h1 class="fw-bold text-dark lh-sm mb-3" style="font-size: 1.85rem;">
                    <?php echo htmlspecialchars($row['title']); ?>
                </h1>

                 <div class="d-flex flex-wrap gap-3 align-items-center mb-4 pb-3 border-bottom text-muted small">
                    <div><i class="bi bi-person-fill me-1"></i> <strong><?php echo htmlspecialchars($row['author']); ?></strong></div>
                    <div>
                        <i class="bi bi-calendar3 me-1"></i> Year Completed: <strong><?php echo htmlspecialchars($row['year_completed']); ?></strong>
                    </div>
                    <?php if (!empty($row['research_type'])): ?>
                    <div>
                        <i class="bi bi-tags-fill me-1"></i> Type: <span class="badge bg-secondary-subtle text-dark text-uppercase rounded-pill px-2" style="font-size:0.75rem;"><?php echo htmlspecialchars($row['research_type']); ?></span>
                    </div>
                    <?php endif; ?>
                </div>

                <h5 class="fw-bold text-dark mb-3">Abstract</h5>
                <div class="abstract-box p-3 bg-light rounded-3 border-start border-3 border-secondary-subtle">
                    <?php echo nl2br(htmlspecialchars($row['abstract'] ?? 'No abstract description provided for this catalog index registry.')); ?>
                </div>

                <!-- Protected Content Notice Callout Box Banner block -->
                <div class="mt-5 p-4 rounded-3 text-center border bg-white shadow-sm">
                    <div class="text-warning mb-2"><i class="bi bi-lock-fill fs-2"></i></div>
                    <h6 class="fw-bold text-dark mb-2">Manuscript File Access is Restricted</h6>
                    <p class="text-muted small mx-auto mb-4" style="max-width: 500px;">
                        To view or download the full copy of this manuscript document file layout, please complete the institutional security screening request access form.
                    </p>
                    <button type="button" class="btn btn-info text-white px-4 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#userRequestModal">
                        <i class="bi bi-clipboard-check-fill me-2"></i>Request Access to Full Manuscript
                    </button>
                </div>

            </div>
        </div>

        <!-- Right Side: Secondary Index Metadata Fields Sidebar Box Grid -->
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
                    <div class="meta-label">Publisher Location Institution</div>
                    <div class="meta-value">Calasiao Comprehensive National High School (CCNHS)</div>
                </div>

                <div class="mb-3">
                    <div class="meta-label">Document Citation Index Reference</div>
                    <div class="p-2 border rounded bg-light font-monospace text-secondary" style="font-size: 0.75rem; word-break: break-all;">
                        <?php echo htmlspecialchars($row['author']); ?>. (<?php echo date('Y', strtotime($row['published_date'] ?? 'now')); ?>). <em><?php echo htmlspecialchars($row['title']); ?></em>. CCNHS Archives.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- GUEST APPLICATION DISPATCH POP-UP ACCESS MODAL FOR GRID INTERACTION -->
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
                    
                    <!-- Research Blueprint Target Header Bar Layout Banner container info wrapper -->
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
                
                <!-- Action Footer Buttons Matching Design Elements Layout rules -->
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
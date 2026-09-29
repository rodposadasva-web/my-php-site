<!DOCTYPE html>
<html lang="en">
<?php
include 'database.php';

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Adjust this file name to your actual login panel path
    exit();
}

/* SEARCH - Added 'year' and basic security */
$keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($conn, $_GET['keyword']) : '';
$area    = isset($_GET['area'])    ? mysqli_real_escape_string($conn, $_GET['area'])    : '';
$year    = isset($_GET['year'])    ? mysqli_real_escape_string($conn, $_GET['year'])    : '';

/* PAGINATION */
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = ($page < 1) ? 1 : $page;
$offset = ($page - 1) * $limit;

/* BASE QUERY */
$sql = "SELECT * FROM research_articles WHERE 1=1";

if (!empty($keyword)) {
    // UPDATED: Now searches by title OR author
    $sql .= " AND (title LIKE '%$keyword%' OR author LIKE '%$keyword%')";
}

if (!empty($area)) {
    $sql .= " AND research_category = '$area'";
}

if (!empty($year)) {
    $sql .= " AND year_completed = '$year'";
}

/* COUNT TOTAL - Crucial for pagination to reflect search results */
$count_query = mysqli_query($conn, $sql); 
$total_items = mysqli_num_rows($count_query);
$total_pages = ceil($total_items / $limit);

/* FINAL QUERY - Append sorting and limits */
$sql_final = $sql . " ORDER BY id DESC LIMIT $offset, $limit";
$result = mysqli_query($conn, $sql_final);

?>

<head>
    <meta charset="utf-8">
    <title>Research Articles</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="icon" href="img/newCenter.png">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <link href="img/favicon.ico" rel="icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet">
    <link href="css/research_css.css" rel="stylesheet">
        
</head>

<body>
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    
    <!--Top Bar Start-->
    <div class="container-fluid py-2 text-white" style="background-color: #00a0b8; font-size: 13px; font-family: sans-serif; position: relative; z-index: 1030;">
        <div class="container-xl d-flex justify-content-between align-items-center flex-wrap" style="padding-top: 0 !important;">
            
            <div class="d-flex align-items-center flex-wrap">
                <span class="me-4 d-flex align-items-center">
                    <i class="fa fa-phone-alt me-2" style="font-size: 12px;"></i>
                    (075)-522-6653
                </span>
                <span class="me-4 d-none d-md-inline text-white-50">|</span>
                <span class="d-flex align-items-center">
                    <i class="fa fa-envelope me-2" style="font-size: 12px;"></i>
                    ccnhsresearchandinnovationcenter@gmail.com
                </span>
            </div>
            
            <div class="d-flex align-items-center">
                <a href="https://www.facebook.com/profile.php?id=61553308320934" 
                class="text-white text-decoration-none d-flex align-items-center me-3" 
                target="_blank" 
                title="Follow us on Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <span class="me-3 text-white-50">|</span>
                <span class="fw-bold text-uppercase tracking-wider" style="font-size: 11px; letter-spacing: 0.5px;">
                    Research Portal Official Website
                </span>
            </div>

        </div>
    </div>
    <!--Top Bar End-->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="dashboard.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h2 class="m-0 text-primary">
                <img src="img/newCCNHS.png"
                    alt="CCNHS Logo"
                    style="width: 50px;
                            height: 50px;
                            object-fit: contain;
                            margin-right: 15px;">
            CCNHS Research Portal </h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="dashboard.php" class="nav-item nav-link">Home</a>
                <a href="about.php" class="nav-item nav-link">About us</a>
                <a href="research.php" class="nav-item nav-link active">Research</a>
                <a href="announcement.php" class="nav-item nav-link">Announcements</a>
                <a href="news.php" class="nav-item nav-link">News</a>
                
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Resources</a>
                    <div class="dropdown-menu fade-down m-0 shadow border-0 rounded-bottom">
                        <a href="policies.php" class="dropdown-item">Issuances</a>
                        <a href="downloadables.php" class="dropdown-item">Downloadables</a>
                        <a href="journal.php" class="dropdown-item">Journal Publication</a>
                        <a href="accomp.php" class="dropdown-item">Accomplishment Reports</a>
                    </div>
                </div>
            </div>
            <a href="logout_page.php" class="nav-item nav-link">Logout</a>
        </div>
    </nav>
    <!-- Navbar End -->


    <div class="container-fluid py-5 mb-5 page-header" style="background: linear-gradient(rgba(24, 29, 56, .7), rgba(24, 29, 56, .7)), url('img/ccn.jpg') center center no-repeat; background-size: cover;">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">RESEARCH ARTICLES</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="#research-list">Articles</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">

    <form method="GET" class="mb-4">
        <div class="card border-0 shadow-sm rounded-3 p-4 bg-white">
            <div class="row g-3 align-items-end">
                <!-- Search Query Input Field -->
                <div class="col-lg-4 col-md-6">
                    <label class="form-label small fw-bold text-uppercase text-secondary tracking-wider" style="font-size: 0.75rem;">Manuscript Search</label>
                    <div class="input-group border rounded-3 overflow-hidden bg-light">
                        <span class="input-group-text bg-transparent border-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" name="keyword" class="form-control bg-transparent border-0 py-2" placeholder="Topic, keywords, or author..." value="<?php echo htmlspecialchars($keyword); ?>">
                    </div>
                </div>

                <!-- Research Category Dropdown Menu Filter -->
                <div class="col-lg-3 col-md-6">
                    <label class="form-label small fw-bold text-uppercase text-secondary tracking-wider" style="font-size: 0.75rem;">Research Category</label>
                    <select name="area" class="form-select bg-light border-1 py-2 rounded-3">
                        <option value="">- All Research Categories -</option>
                        <option value="Science and Technology" <?php if($area == 'Science and Technology') echo 'selected'; ?>>Science and Technology</option>
                        <option value="Education" <?php if($area == 'Education') echo 'selected'; ?>>Education</option>
                        <option value="Business" <?php if($area == 'Business') echo 'selected'; ?>>Business</option>
                        <option value="Health" <?php if($area == 'Health') echo 'selected'; ?>>Health</option>
                    </select>
                </div>

                <!-- Calendar Year Form Field Filtering Component -->
                <div class="col-lg-3 col-md-6">
                    <label class="form-label small fw-bold text-uppercase text-secondary tracking-wider" style="font-size: 0.75rem;">Year Completed</label>
                    <input type="number" name="year" class="form-control bg-light border-1 py-2 rounded-3" placeholder="e.g. 2026" value="<?php echo htmlspecialchars($year); ?>">
                </div>

                <!-- Submit Button Controls Layout Trigger -->
                <div class="col-lg-2 col-md-6 d-grid">
                    <button type="submit" class="btn btn-info text-white fw-semibold py-2 rounded-3 shadow-sm hover-up">
                        <i class="bi bi-sliders me-2"></i>Apply Filters
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- Upload CTA Container Bar -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4 px-1">
        <div class="text-secondary small fw-medium">
            Showing <span class="text-dark fw-bold"><?php echo $offset + 1; ?></span> – <span class="text-dark fw-bold"><?php echo min($offset + $limit, $total_items); ?></span> of <span class="text-dark fw-bold"><?php echo $total_items; ?></span> document assets.
        </div>
        <button type="button" class="btn btn-primary rounded-pill py-2 px-4 shadow-sm fw-semibold" data-bs-toggle="modal" data-bs-target="#uploadResearchModal">
            <i class="bi bi-cloud-arrow-up-fill me-2"></i>Upload Research
        </button>
    </div>

    <!-- Core Dynamic Catalog Grid Rows Loop Configuration -->
    <div class="row g-3 mb-4" id="research-list">
        <?php if ($total_items > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white position-relative overflow-hidden transition-all hover-shadow" style="border-left: 4px solid #00a0b8 !important;">
                        <div class="row g-3 align-items-center">
                            
                            <!-- Main Structural Payload Context Block Container Area -->
                            <div class="col-lg-9 col-md-8">
                                <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                                    <span class="badge bg-primary-subtle text-primary text-uppercase px-2.5 py-1 rounded-pill small fw-semibold" style="font-size: 0.7rem;">
                                        <i class="bi bi-bookmark-fill me-1"></i><?php echo !empty($row['research_category']) ? htmlspecialchars($row['research_category']) : 'General Research'; ?>
                                    </span>
                                    <span class="badge bg-secondary-subtle text-dark text-uppercase px-2.5 py-1 rounded-pill small fw-semibold" style="font-size: 0.7rem;">
                                        <i class="bi bi-gear-wide-connected me-1"></i><?php echo !empty($row['research_type']) ? htmlspecialchars($row['research_type']) : 'Not Specified'; ?>
                                    </span>
                                    <span class="badge bg-secondary-subtle text-dark text-uppercase px-2.5 py-1 rounded-pill small fw-semibold" style="font-size: 0.7rem;">
                                        <i class="bi bi-gear-wide-connected me-1"></i><?php echo !empty($row['research_design']) ? htmlspecialchars($row['research_design']) : 'Not Specified'; ?>
                                    </span>
                                    <span class="text-muted small d-flex align-items-center ms-2">
                                        <i class="bi bi-calendar3 me-1"></i> 
                                        Completed: <?php echo !empty($row['year_completed']) ? htmlspecialchars($row['year_completed']) : 'N/A'; ?>
                                    </span>
                                </div>

                                <h4 class="fw-bold text-dark mb-2 lh-sm h5 hover-text-primary transition-all">
                                    <?php echo htmlspecialchars($row['title']); ?>
                                </h4>
                                
                                <p class="text-secondary small mb-3">
                                    <i class="bi bi-person-circle me-1 text-muted"></i>Author(s): <strong class="text-dark fw-semibold"><?php echo htmlspecialchars($row['author']); ?></strong>
                                </p>

                                <!-- Secondary Metadata Inline Flex Matrices Grid Details -->
                                <div class="d-flex flex-wrap gap-x-4 gap-y-2 text-muted small border-top pt-3 mt-2" style="font-size: 0.85rem;">
                                    <div class="me-3"><i class="bi bi-mortarboard me-1.5 text-secondary"></i>Grade Level: <span class="text-dark fw-medium"><?php echo !empty($row['grade_level']) ? htmlspecialchars($row['grade_level']) : 'Not Specified'; ?></span></div>
                                    <div class="me-3"><i class="bi bi-book-half me-1.5 text-secondary"></i>Cluster: <span class="text-dark fw-medium"><?php echo !empty($row['strand']) ? htmlspecialchars($row['strand']) : 'Not Specified'; ?></span></div>
                                    <div><i class="bi bi-check-circle-fill me-1.5 text-secondary"></i>Year Published: <span class="text-dark fw-medium"><?php echo !empty($row['year_completed']) ? htmlspecialchars($row['year_completed']) : 'Not Specified'; ?></span></div>
                                </div>
                            </div>

                            <!-- Right-aligned Target View Button Navigation Block Layout -->
                            <div class="col-lg-3 col-md-4 text-md-end d-grid d-md-block">
                                <a href="view_research.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-info px-4 py-2.5 rounded-3 fw-semibold small w-100 transition-all hover-bg-info">
                                    Examine Record <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-3 p-5 text-center bg-white">
                    <i class="bi bi-search-heart text-muted display-4 mb-3 d-block"></i>
                    <h5 class="fw-bold text-dark">No Matching Artifacts Located</h5>
                    <p class="text-muted small mx-auto mb-0" style="max-width: 420px;">We couldn't trace any documents pairing those specific criteria inputs. Try clearing your queries or filters.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Redesigned Smooth Pagination Framework Control Strip -->
    <?php if ($total_pages > 1): ?>
        <nav class="d-flex justify-content-center mt-4">
            <ul class="pagination shadow-sm bg-white p-1.5 rounded-pill border-0 mb-0">
                <!-- Previous Navigation Button -->
                <li class="page-item <?php if($page <= 1) echo 'disabled'; ?>">
                    <a class="page-link rounded-circle border-0 text-center d-inline-flex align-items-center justify-content-center m-1 shadow-none" 
                       href="?page=<?php echo $page-1; ?><?php echo !empty($keyword) ? '&keyword='.urlencode($keyword) : ''; ?><?php echo !empty($area) ? '&area='.urlencode($area) : ''; ?><?php echo !empty($year) ? '&year='.urlencode($year) : ''; ?>" 
                       style="width: 38px; height: 38px;"><i class="bi bi-chevron-left"></i></a>
                </li>

                <!-- Digital Matrix Items Links Loop Counter Elements Block -->
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <?php 
                    $link = "?page=" . $i;
                    if (!empty($keyword)) { $link .= "&keyword=" . urlencode($keyword); }
                    if (!empty($area)) { $link .= "&area=" . urlencode($area); }
                    if (!empty($year)) { $link .= "&year=" . urlencode($year); }
                    $is_active = ($page == $i);
                    ?>
                    <li class="page-item <?php echo $is_active ? 'active' : ''; ?>">
                        <a class="page-link rounded-circle border-0 text-center d-inline-flex align-items-center justify-content-center m-1 fw-semibold shadow-none <?php echo $is_active ? 'bg-info text-white' : 'text-secondary'; ?>" 
                           href="<?php echo htmlspecialchars($link); ?>"
                           style="width: 38px; height: 38px; font-size: 0.9rem;">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <!-- Next Page Target Link Anchor Row Button -->
                <li class="page-item <?php if($page >= $total_pages) echo 'disabled'; ?>">
                    <a class="page-link rounded-circle border-0 text-center d-inline-flex align-items-center justify-content-center m-1 shadow-none" 
                       href="?page=<?php echo $page+1; ?><?php echo !empty($keyword) ? '&keyword='.urlencode($keyword) : ''; ?><?php echo !empty($area) ? '&area='.urlencode($area) : ''; ?><?php echo !empty($year) ? '&year='.urlencode($year) : ''; ?>" 
                       style="width: 38px; height: 38px;"><i class="bi bi-chevron-right"></i></a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>

</div><br>
        
<!--Footer Start-->
 <footer class="container-fluid bg-dark text-secondary py-3 border-top border-secondary wow fadeIn" data-wow-delay="0.1s" style="background-color: #181d38 !important;">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
        
        <!-- Left Side: Developers -->
        <div class="small text-center text-md-start">
            <span class="text-white-50 me-2 fw-semibold"><i class="fa fa-code me-1 text-primary"></i> Developers:</span>
            <span class="text-secondary me-2">Rod C. Posadas</span>&middot;
            <span class="text-secondary mx-2">Shiela Mae L. Cena</span>&middot;
            <span class="text-secondary ms-2">Genesis Paul S. Crisostomo</span>
        </div>
        
        <!-- Right Side: Redesigned Survey Prompt & Link -->
        <div class="small text-center text-md-end text-white-50 d-flex align-items-center flex-wrap justify-content-center justify-content-md-end gap-2">
            <span>Help us improve this website by answering our</span>
            <a href="https://tinyurl.com/CCNHSResearchCenterEvalForm" 
               target="_blank" 
               class="text-primary fw-medium text-decoration-none hover-link-accent">
                Quick Evaluation Survey <i class="fa fa-external-link-alt ms-1" style="font-size: 0.75rem;"></i>
            </a>
        </div>

    </div>
</footer>
<!--Footer End-->

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <script src="js/main.js"></script>

    <script>
    function toggleOthersField() {
        const selectElement = document.getElementById('designSelect');
        const othersContainer = document.getElementById('othersContainer');
        const othersInput = document.getElementById('othersInput');
        
        // Checks if the selected value contains the word 'Others'
        if (selectElement.value.includes('Others')) {
            othersContainer.classList.remove('d-none');
            othersInput.setAttribute('required', 'required');
        } else {
            othersContainer.classList.add('d-none');
            othersInput.removeAttribute('required');
            othersInput.value = ''; 
        }
    }
    </script>
</body>

<!-- Re-engineered Upload Research Modal Structure Component -->
<div class="modal fade" id="uploadResearchModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <form action="process_upload.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header border-0 bg-light px-4 py-3">
                    <h5 class="modal-title fw-bold text-dark" id="uploadModalLabel">
                        <i class="bi bi-cloud-arrow-up-fill text-primary me-2"></i>Submit New Research
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body px-4 py-4" style="background-color: #fdfdfd;">
                    <?php if (isset($_GET['status']) && $_GET['status'] == 'pending'): ?>
                        <div class="alert alert-warning alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
                            <i class="bi bi-clock-history me-2"></i><strong>Submission Received!</strong> Your research article is now pending admin approval.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php echo "<script>window.addEventListener('DOMContentLoaded', () => { new bootstrap.Modal(document.getElementById('uploadResearchModal')).show(); });</script>"; ?>
                    <?php endif; ?>

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold text-uppercase text-secondary">Research Title</label>
                            <input type="text" name="title" class="form-control rounded-3" placeholder="Enter full research title" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold text-uppercase text-secondary">Abstract Summary Statement</label>
                            <textarea name="abstract" class="form-control rounded-3" rows="5" placeholder="Provide a brief summary of the research (objectives, methodology, and results)..." required></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold text-uppercase text-secondary">Author(s)</label>
                            <input type="text" name="author" class="form-control rounded-3" placeholder="e.g. John Doe, Jane Smith" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-secondary">Research Category</label>
                            <select name="research_category" class="form-select rounded-3" required>
                                <option value="" disabled selected>- Select Research Category -</option>
                                <option value="Science and Technology">Science and Technology</option>
                                <option value="Education">Education</option>
                                <option value="Business">Business</option>
                                <option value="Health">Health</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-secondary">Research Type</label>
                            <select name="research_type" class="form-select rounded-3" required>
                                <option value="" disabled selected>- Select Research Type -</option>
                                <option value="Qualitative">Qualitative</option>
                                <option value="Quantitative">Quantitative</option>
                                <option value="Mixed Methods">Mixed Methods</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-secondary">Research Design</label>
                            
                            <!-- Select Element Opens -->
                            <select id="designSelect" name="research_design" class="form-select rounded-3" required onchange="toggleOthersField()">
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
                            <!-- Select Element Closes Cleanly Here -->

                            <!-- Textbox Container is now safely placed underneath with a tiny top margin (mt-2) -->
                            <div id="othersContainer" class="d-none mt-2">
                                <label class="form-label small fw-bold text-uppercase text-danger mb-1" style="font-size: 0.75rem;">Please Specify</label>
                                <input type="text" id="othersInput" name="research_design_others" class="form-control rounded-3" placeholder="Enter your research design...">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-secondary">Grade Level</label>
                            <select name="grade_level" class="form-select rounded-3" required>
                                <option value="" disabled selected>- Select Grade Level -</option>
                                <option value="STE">STE (Science, Technology, Engineering)</option>
                                <option value="Grade 11">Grade 11</option>
                                <option value="Grade 12">Grade 12</option>
                                <option value="Faculty / Teacher">Faculty / Teacher</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-secondary">Academic Cluster</label>
                            <select name="strand" class="form-select rounded-3" required>
                                <option value="" disabled selected>- Select Cluster -</option>
                                <option value="STE">STE (Science, Technology, Engineering)</option>
                                <option value="STEM">STEM (Science, Technology, Engineering, Math)</option>
                                <option value="ABM">ABM (Accountancy, Business, Management)</option>
                                <option value="HUMSS">HUMSS (Humanities and Social Sciences)</option>
                                <option value="GAS">GAS (General Academic Strand)</option>
                                <option value="TVL">TVL (Technical-Vocational-Livelihood)</option>
                                <option value="Not Applicable">Not Applicable / Faculty</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold text-uppercase text-secondary">Year Completed</label>
                            <input type="number" name="year_completed" class="form-control rounded-3" min="1900" max="2026" placeholder="e.g. 2026" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold text-uppercase text-secondary">Select PDF File Source</label>
                            <input type="file" name="research_file" class="form-control rounded-3" accept=".pdf" required>
                            <div class="form-text text-muted small"><i class="bi bi-info-circle me-1"></i>Maximum file size: 10MB (PDF format only)</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light px-4 py-3">
                    <button type="button" class="btn btn-secondary px-4 rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit_upload" class="btn btn-primary px-4 rounded-3 fw-semibold">Submit for Approval</button>
                </div>
            </form>
        </div>
    </div>
</div>

</html>
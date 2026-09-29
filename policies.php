<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include 'database.php';

// Fetch all institutional regulatory policies uploaded by admins
$policies_query = mysqli_query($conn, "SELECT * FROM portal_policies ORDER BY issuance_date DESC");

// Initialize buckets for the 4 levels of issuances
$issuance_levels = [
    'central'  => [],
    'regional' => [],
    'division' => [],
    'school'   => []
];

// Distribute policies into their respective level categories
// (Assuming your database field matches or contains these keywords; updates match seamlessly)
while ($policy = mysqli_fetch_assoc($policies_query)) {
    $scope = strtolower($policy['scope'] ?? '');
    
    if (strpos($scope, 'central') !== false || strpos($scope, 'national') !== false) {
        $issuance_levels['central'][] = $policy;
    } elseif (strpos($scope, 'regional') !== false || strpos($scope, 'region') !== false) {
        $issuance_levels['regional'][] = $policy;
    } elseif (strpos($scope, 'division') !== false) {
        $issuance_levels['division'][] = $policy;
    } else {
        // Default fall-through or explicit school context scope
        $issuance_levels['school'][] = $policy;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
    <title>Issuances</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="icon" href="img/newCenter.png">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/policies_design.css" rel="stylesheet">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!--Top Bar Start-->
    <div class="container-fluid py-2 text-white" style="background-color: #00a0b8; font-size: 13px; font-family: sans-serif; position: relative; z-index: 1030;">
        <div class="container-xl d-flex justify-content-between align-items-center flex-wrap" style="padding-top: 0 !important;">
            <div class="d-flex align-items-center flex-wrap">
                <span class="me-4 d-flex align-items-center">
                    <i class="fa fa-phone-alt me-2" style="font-size: 12px;"></i>(075)-522-6653
                </span>
                <span class="me-4 d-none d-md-inline text-white-50">|</span>
                <span class="d-flex align-items-center">
                    <i class="fa fa-envelope me-2" style="font-size: 12px;"></i>ccnhsresearchandinnovationcenter@gmail.com
                </span>
            </div>
            <div class="d-flex align-items-center">
                <a href="https://www.facebook.com/profile.php?id=61553308320934" class="text-white text-decoration-none d-flex align-items-center me-3" target="_blank" title="Follow us on Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <span class="me-3 text-white-50">|</span>
                <span class="fw-bold text-uppercase tracking-wider" style="font-size: 11px; letter-spacing: 0.5px;">Research Portal Official Website</span>
            </div>
        </div>
    </div>
    <!--Top Bar End-->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="dashboard.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h2 class="m-0 text-primary">
                <img src="img/newCCNHS.png" alt="CCNHS Logo" style="width: 50px; height: 50px; object-fit: contain; margin-right: 15px;">
                CCNHS Research Portal
            </h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="dashboard.php" class="nav-item nav-link">Home</a>
                <a href="about.php" class="nav-item nav-link">About us</a>
                <a href="research.php" class="nav-item nav-link">Research</a>
                <a href="announcement.php" class="nav-item nav-link">Announcements</a>
                <a href="news.php" class="nav-item nav-link">News</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Resources</a>
                    <div class="dropdown-menu fade-down m-0 shadow border-0 rounded-bottom">
                        <a href="policies.php" class="dropdown-item active">Issuances</a>
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

    <!-- Header Start -->
    <div class="container-fluid py-5 mb-5 page-header" style="background: linear-gradient(rgba(24, 29, 56, .7), rgba(24, 29, 56, .7)), url('img/ccn.jpg') center center no-repeat; background-size: cover;">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">RESEARCH RELATED ISSUANCES</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="#policy">Latest Policies</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <div class="container-xxl py-5">
        <div class="container">
            
            <!-- Issuance Level Navigation Tabs Selector -->
            <ul class="nav nav-pills nav-justified mb-4 shadow-sm rounded-3 p-1 bg-light border border-1" id="issuanceTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link py-2.5 fw-bold text-uppercase active" id="central-tab" data-bs-toggle="tab" data-bs-target="#central-pane" type="button" role="tab">
                        <i class="fa fa-university me-2"></i>Central Issuances
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link py-2.5 fw-bold text-uppercase" id="regional-tab" data-bs-toggle="tab" data-bs-target="#regional-pane" type="button" role="tab">
                        <i class="fa fa-map-marked-alt me-2"></i>Regional Issuances
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link py-2.5 fw-bold text-uppercase" id="division-tab" data-bs-toggle="tab" data-bs-target="#division-pane" type="button" role="tab">
                        <i class="fa fa-tags me-2"></i>Division Issuances
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link py-2.5 fw-bold text-uppercase" id="school-tab" data-bs-toggle="tab" data-bs-target="#school-pane" type="button" role="tab">
                        <i class="fa fa-school me-2"></i>School Issuances
                    </button>
                </li>
            </ul>

            <div class="row g-4">
                <div class="col-lg-7 col-md-12 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="pe-lg-3 tab-content" id="issuanceTabsContent">
                        
                        <?php 
                        $isFirst = true;
                        foreach ($issuance_levels as $levelKey => $policiesList): 
                        ?>
                            <!-- Tab Content Window Array Panel -->
                            <div class="tab-pane fade <?php echo $isFirst ? 'show active' : ''; ?>" id="<?php echo $levelKey; ?>-pane" role="tabpanel">
                                <?php if (!empty($policiesList)): ?>
                                    <?php foreach ($policiesList as $policy): ?>
                                        <div class="card policy-card border-0 shadow-sm p-4 mb-4 bg-white rounded">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <span class="badge bg-light text-primary border px-2 py-1 small fw-bold">
                                                    <i class="fa fa-tag me-1"></i> <?php echo htmlspecialchars($policy['policy_number']); ?>
                                                </span>
                                                <small class="text-muted">
                                                    <i class="fa fa-calendar-alt me-1"></i> <?php echo date("F d, Y", strtotime($policy['issuance_date'])); ?>
                                                </small>
                                            </div>
                                            
                                            <!-- Title Heading Element Layout Configured -->
                                            <h4 class="text-dark mb-2 mt-1"><?php echo htmlspecialchars($policy['title']); ?></h4>
                                            
                                            <p class="text-muted small mb-3">
                                                <?php echo htmlspecialchars($policy['description']); ?>
                                            </p>

                                            <!-- Formatted Dynamic External URL Block -->
                                            <?php if (!empty($policy['portal_link'])): ?>
                                                <div class="bg-light p-2.5 rounded-3 mb-3 border-start border-info border-3 fs-7">
                                                    <span class="fw-bold text-dark d-block mb-0.5" style="font-size: 0.8rem;">External Reference Link</span>
                                                    <a href="<?php echo htmlspecialchars($policy['portal_link']); ?>" target="_blank" class="text-decoration-none text-primary break-all small">
                                                        <?php echo htmlspecialchars($policy['portal_link']); ?>
                                                    </a>
                                                </div>
                                            <?php endif; ?>

                                            <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                                <span class="small text-secondary fw-semibold text-uppercase" style="font-size: 0.75rem;">
                                                    <i class="fa fa-layer-group me-1 text-success"></i> Level: <?php echo htmlspecialchars($policy['scope']); ?>
                                                </span>
                                                <a href="javascript:void(0);" 
                                                   onclick="viewPolicyPDF('<?php echo htmlspecialchars($policy['file_path']); ?>', '<?php echo htmlspecialchars($policy['title'], ENT_QUOTES); ?>')" 
                                                   class="btn btn-sm btn-primary px-3 rounded-pill shadow-sm">
                                                    <i class="fa fa-file-pdf me-1"></i> View Document Inside Portal
                                                </a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="text-center p-5 border border-dashed rounded bg-light">
                                        <i class="fa fa-folder-open text-muted mb-3 fs-1"></i>
                                        <p class="text-muted mb-0">No entries logged currently under this specific issuance classification layer.</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php 
                        $isFirst = false;
                        endforeach; 
                        ?>

                    </div>
                </div>

                <!-- PDF Layout Engine Window Sidebar Panel View -->
                <div class="col-lg-5 col-md-12 wow fadeInUp" data-wow-delay="0.4s">
                    <div class="position-sticky" style="top: 100px;">
                        <div class="card border-0 shadow-sm overflow-hidden rounded bg-white">
                            <div class="card-header bg-primary-custom text-white py-3 px-4 d-flex align-items-center justify-content-between">
                                <h5 class="m-0 text-white small fw-bold" id="viewer-title"><i class="fa fa-eye me-2 text-primary"></i> Select a Policy Document</h5>
                                <span class="badge bg-success small py-1 px-2" id="pdf-viewer-badge" style="display:none;">Active File</span>
                            </div>
                            <div class="card-body p-0 bg-light" style="height: 600px; min-height: 500px;" id="pdf-viewer-container">
                                <div class="d-flex flex-column align-items-center justify-content-center text-center p-5 h-100" id="viewer-placeholder">
                                    <i class="fa fa-file-pdf text-muted mb-3" style="font-size: 4rem; opacity: 0.3;"></i>
                                    <h5 class="text-secondary fw-normal">Interactive PDF Storage Vault</h5>
                                    <p class="text-muted small px-3">Click on any document link's "View Document" button on the left panel to load and read full mandate layouts here.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Footer Start-->
    <footer class="container-fluid bg-dark text-secondary py-3 border-top border-secondary wow fadeIn" data-wow-delay="0.1s" style="background-color: #181d38 !important;">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <div class="small text-center text-md-start">
                <span class="text-white-50 me-2 fw-semibold"><i class="fa fa-code me-1 text-primary"></i> Developers:</span>
                <span class="text-secondary me-2">Rod C. Posadas</span>&middot;
                <span class="text-secondary mx-2">Shiela Mae L. Cena</span>&middot;
                <span class="text-secondary ms-2">Genesis Paul S. Crisostomo</span>
            </div>
            <div class="small text-center text-md-end text-white-50 d-flex align-items-center flex-wrap justify-content-center justify-content-md-end gap-2">
                <span>Help us improve this website by answering our</span>
                <a href="https://tinyurl.com/CCNHSResearchCenterEvalForm" target="_blank" class="text-primary fw-medium text-decoration-none hover-link-accent">
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

    <script>
    function viewPolicyPDF(filePath, titleText) {
        document.getElementById('viewer-placeholder').style.display = 'none';
        document.getElementById('pdf-viewer-badge').style.display = 'block';
        document.getElementById('viewer-title').innerHTML = '<i class="fa fa-file-alt me-2 text-primary"></i> ' + titleText;
        
        const container = document.getElementById('pdf-viewer-container');
        container.innerHTML = `<object data="${filePath}" type="application/pdf" width="100%" height="100%">
            <div class="p-4 text-center">
                <p class="text-danger small fw-medium"><i class="fa fa-exclamation-triangle"></i> Browser plugin missing.</p>
                <a href="${filePath}" target="_blank" class="btn btn-sm btn-dark rounded px-3">Open PDF in Separate Window</a>
            </div>
        </object>`;
    }
    </script>
     <script src="js/main.js"></script>
</body>
</html>
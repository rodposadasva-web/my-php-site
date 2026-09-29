<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include 'database.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
    <title>Accomplishment Reports</title>
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
                <a href="research.php" class="nav-item nav-link">Research</a>
                <a href="announcement.php" class="nav-item nav-link">Announcements</a>
                <a href="news.php" class="nav-item nav-link">News</a>
                
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Resources</a>
                    <div class="dropdown-menu fade-down m-0 shadow border-0 rounded-bottom">
                        <a href="policies.php" class="dropdown-item">Issuances</a>
                        <a href="downloadables.php" class="dropdown-item ">Downloadables</a>
                        <a href="journal.php" class="dropdown-item active">Journal Publication</a>
                        <a href="accomp.php" class="dropdown-item ">Accomplishment Reports</a>
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
                    <h1 class="display-3 text-white animated slideInDown">JOURNAL PUBLICATION</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="#policy">Year 2026</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Research Sources Section Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px; margin: 0 auto 3rem auto;">
                <h6 class="section-title bg-white text-center text-primary px-3 text-uppercase fw-bold">Publication</h6>
                <h1 class="mb-4">Journal Publication</h1>
            </div>

            <!-- PDF Viewer Interactive Layout Start -->
            <div class="row g-4 wow fadeInUp" data-wow-delay="0.3s">
                
                <!-- Document List Selection Sidebar -->
                <div class="col-lg-4 col-md-12">
                    <div class="list-group shadow-sm">
                        <!-- PDF 1 -->
                        <button type="button" class="list-group-item list-group-item-action d-flex align-items-center py-3 active" onclick="viewPolicyPDF('journal/CommuNation.pdf', 'CommuNation')">
                            <i class="fa fa-file-pdf fa-2x text-primary me-3"></i>
                            <div class="text-start">
                                <h6 class="mb-0">CommuNation.pdf</h6>
                                <small class="text-muted">View CommuNation publication</small>
                            </div>
                        </button>
                        
                        <!-- PDF 2 -->
                        <button type="button" class="list-group-item list-group-item-action d-flex align-items-center py-3" onclick="viewPolicyPDF('journal/Expoliarmus_Vol.2.pdf', 'Expoliarmus Vol. 2')">
                            <i class="fa fa-file-pdf fa-2x text-primary me-3"></i>
                            <div class="text-start">
                                <h6 class="mb-0">Expoliarmus_Vol.2.pdf</h6>
                                <small class="text-muted">View Expoliarmus publication</small>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- Main PDF Viewing Container -->
                <div class="col-lg-8 col-md-12">
                    <div class="card shadow-sm border-0" style="min-height: 600px;">
                        
                        <!-- Viewer Header (Visible by default) -->
                        <div class="card-header bg-primary text-white" id="pdf-viewer-badge" style="display: block;">
                            <h5 class="m-0 text-white" id="viewer-title"><i class="fa fa-file-alt me-2"></i> CommuNation</h5>
                        </div>
                        
                        <!-- Viewer Body -->
                        <div class="card-body p-0">
                            <!-- PDF Injection Target (Loads journal/Communtion.pdf immediately) -->
                            <div id="pdf-viewer-container" class="h-100 w-100" style="min-height: 600px;">
                                <object data="journal/Communtion.pdf" type="application/pdf" width="100%" height="100%" style="min-height: 600px; display: block;">
                                    <div class="p-4 text-center d-flex flex-column justify-content-center h-100">
                                        <p class="text-danger small fw-medium"><i class="fa fa-exclamation-triangle"></i> Browser plugin missing.</p>
                                        <a href="journal/Communtion.pdf" target="_blank" class="btn btn-sm btn-dark rounded px-3 mt-2">Open PDF in Separate Window</a>
                                    </div>
                                </object>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- PDF Viewer Interactive Layout End -->
            
        </div>
    </div>
    <!-- Research Sources Section End -->

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

    <script>
    function viewPolicyPDF(filePath, titleText) {
        // Update title bar label text 
        document.getElementById('viewer-title').innerHTML = '<i class="fa fa-file-alt me-2 text-white"></i> ' + titleText;
        
        // Target canvas and replace it with an interactive responsive browser object tag framework pointing to our file source URL
        const container = document.getElementById('pdf-viewer-container');
        container.innerHTML = `<object data="${filePath}" type="application/pdf" width="100%" height="100%" style="min-height: 600px; display: block;">
            <div class="p-4 text-center d-flex flex-column justify-content-center h-100">
                <p class="text-danger small fw-medium"><i class="fa fa-exclamation-triangle"></i> Browser plugin missing.</p>
                <a href="${filePath}" target="_blank" class="btn btn-sm btn-dark rounded px-3 mt-2">Open PDF in Separate Window</a>
            </div>
        </object>`;
    }
    
    // Add active state styling to buttons when clicked
    $(document).ready(function() {
        $('.list-group-item').click(function() {
            $('.list-group-item').removeClass('active');
            $(this).addClass('active');
        });
    });
    </script>

     <script src="js/main.js"></script>
</body>
</html>
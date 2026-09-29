<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include 'database.php';

// Fetch all institutional regulatory policies uploaded by admins
$policies_query = mysqli_query($conn, "SELECT * FROM portal_policies ORDER BY issuance_date DESC");
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
                        <a href="downloadables.php" class="dropdown-item active">Downloadables</a>
                        <a href="journal.php" class="dropdown-item">Journal Publication</a>
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
                    <h1 class="display-3 text-white animated slideInDown">DOWNLOADABLES AND RESEARCH SOURCES</h1>
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
    
    <!-- Abstract Files Download Section Start -->
    <div class="container my-5 px-3 px-md-5">
        <div class="card shadow-sm border-0 mx-auto" style="max-width: 1000px;">
            <div class="card-header bg-primary text-white d-flex align-items-center py-3 px-4">
                <i class="fa fa-file-pdf fa-lg me-2"></i>
                <h5 class="m-0 text-white">Research Abstracts</h5>
            </div>
            <div class="card-body p-4 p-md-5">
                <p class="text-muted mb-4">
                    Click the download buttons below to access the available research abstracts.
                </p>

                <div class="row g-4">
                    <!-- Abstract 1 -->
                    <div class="col-lg-6 col-md-12">
                        <div class="border rounded p-3 p-md-4 d-flex align-items-center justify-content-between bg-light h-100">
                            <div class="d-flex align-items-center me-3">
                                <i class="fa fa-file-alt fa-2x text-primary me-3"></i>
                                <div>
                                    <h6 class="mb-1 fw-bold">Front Page</h6>
                                    <small class="text-muted">Document • Abstract File</small>
                                </div>
                            </div>
                            <a href="downloadables/abstract1.jpe" download="abstract1" class="btn btn-primary btn-sm px-3 text-nowrap">
                                <i class="fa fa-download me-1"></i> Download
                            </a>
                        </div>
                    </div>

                    <!-- Abstract 2 -->
                    <div class="col-lg-6 col-md-12">
                        <div class="border rounded p-3 p-md-4 d-flex align-items-center justify-content-between bg-light h-100">
                            <div class="d-flex align-items-center me-3">
                                <i class="fa fa-file-alt fa-2x text-primary me-3"></i>
                                <div>
                                    <h6 class="mb-1 fw-bold">Page 1</h6>
                                    <small class="text-muted">Document • Abstract File</small>
                                </div>
                            </div>
                            <a href="downloadables/abstract2.jpe" download="abstract2" class="btn btn-primary btn-sm px-3 text-nowrap">
                                <i class="fa fa-download me-1"></i> Download
                            </a>
                        </div>
                    </div>

                    <!-- Abstract 3 -->
                    <div class="col-lg-6 col-md-12">
                        <div class="border rounded p-3 p-md-4 d-flex align-items-center justify-content-between bg-light h-100">
                            <div class="d-flex align-items-center me-3">
                                <i class="fa fa-file-alt fa-2x text-primary me-3"></i>
                                <div>
                                    <h6 class="mb-1 fw-bold">Page 2</h6>
                                    <small class="text-muted">Document • Abstract File</small>
                                </div>
                            </div>
                            <a href="downloadables/abstract3.jpe" download="abstract3" class="btn btn-primary btn-sm px-3 text-nowrap">
                                <i class="fa fa-download me-1"></i> Download
                            </a>
                        </div>
                    </div>

                    <!-- Abstract 4 -->
                    <div class="col-lg-6 col-md-12">
                        <div class="border rounded p-3 p-md-4 d-flex align-items-center justify-content-between bg-light h-100">
                            <div class="d-flex align-items-center me-3">
                                <i class="fa fa-file-alt fa-2x text-primary me-3"></i>
                                <div>
                                    <h6 class="mb-1 fw-bold">Page 3</h6>
                                    <small class="text-muted">Document • Abstract File</small>
                                </div>
                            </div>
                            <a href="downloadables/abstract4.jpe" download="abstract4" class="btn btn-primary btn-sm px-3 text-nowrap">
                                <i class="fa fa-download me-1"></i> Download
                            </a>
                        </div>
                    </div>

                    <!-- Abstract 5 -->
                    <div class="col-lg-6 col-md-12">
                        <div class="border rounded p-3 p-md-4 d-flex align-items-center justify-content-between bg-light h-100">
                            <div class="d-flex align-items-center me-3">
                                <i class="fa fa-file-alt fa-2x text-primary me-3"></i>
                                <div>
                                    <h6 class="mb-1 fw-bold">Page 4</h6>
                                    <small class="text-muted">Document • Abstract File</small>
                                </div>
                            </div>
                            <a href="downloadables/abstract5.jpe" download="abstract5" class="btn btn-primary btn-sm px-3 text-nowrap">
                                <i class="fa fa-download me-1"></i> Download
                            </a>
                        </div>
                    </div>

                    <!-- Abstract 6 -->
                    <div class="col-lg-6 col-md-12">
                        <div class="border rounded p-3 p-md-4 d-flex align-items-center justify-content-between bg-light h-100">
                            <div class="d-flex align-items-center me-3">
                                <i class="fa fa-file-alt fa-2x text-primary me-3"></i>
                                <div>
                                    <h6 class="mb-1 fw-bold">Page 5</h6>
                                    <small class="text-muted">Document • Abstract File</small>
                                </div>
                            </div>
                            <a href="downloadables/abstract6.jpe" download="abstract6" class="btn btn-primary btn-sm px-3 text-nowrap">
                                <i class="fa fa-download me-1"></i> Download
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Abstract Files Download Section End -->

    <!-- Downloadable Word Templates Section Start -->
    <div class="container my-5 px-3 px-md-5">
        <div class="card shadow-sm border-0 mx-auto" style="max-width: 1000px;">
            <div class="card-header bg-primary text-white d-flex align-items-center py-3 px-4">
                <i class="fa fa-file-word fa-lg me-2"></i>
                <h5 class="m-0 text-white">Downloadable Research Templates & Appendices</h5>
            </div>
            <div class="card-body p-4 p-md-5">
                <p class="text-muted mb-4">
                    Click the download buttons below to get the official Microsoft Word (<code>.docx</code>) templates for your research proposal and required cluster appendices.
                </p>

                <div class="row g-4">
                    <!-- Document 1: Research Proposal Template -->
                    <div class="col-lg-6 col-md-12">
                        <div class="border rounded p-3 p-md-4 d-flex align-items-center justify-content-between bg-light h-100">
                            <div class="d-flex align-items-center me-3">
                                <i class="fa fa-file-word fa-2x text-primary me-3"></i>
                                <div>
                                    <h6 class="mb-1 fw-bold">Research Proposal Template</h6>
                                    <small class="text-muted">Format: DOCX • Word Document</small>
                                </div>
                            </div>
                            <a href="downloadables/Research Proposal Template.docx" download="Research Proposal Template.docx" class="btn btn-primary btn-sm px-3 text-nowrap">
                                <i class="fa fa-download me-1"></i> Download
                            </a>
                        </div>
                    </div>

                    <!-- Document 2: Appendices (Arts, SocSci, Humanities Cluster) -->
                    <div class="col-lg-6 col-md-12">
                        <div class="border rounded p-3 p-md-4 d-flex align-items-center justify-content-between bg-light h-100">
                            <div class="d-flex align-items-center me-3">
                                <i class="fa fa-file-word fa-2x text-primary me-3"></i>
                                <div>
                                    <h6 class="mb-1 fw-bold">Appendices (Arts, SocSci & Humanities)</h6>
                                    <small class="text-muted">Format: DOCX • Word Document</small>
                                </div>
                            </div>
                            <a href="downloadables/Appendices (Arts SocSci Humanities Cluster).docx" download="Appendices (Arts SocSci Humanities Cluster).docx" class="btn btn-primary btn-sm px-3 text-nowrap">
                                <i class="fa fa-download me-1"></i> Download
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Downloadable Word Templates Section End -->

    <!-- Research Sources Section Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px; margin: 0 auto 3rem auto;">
                <h6 class="section-title bg-white text-center text-primary px-3 text-uppercase fw-bold">Resources</h6>
                <h1 class="mb-4">Research Sources</h1>
            </div>

            <!-- Grid Layout configured to force 5 equal columns per row on Medium screens and up -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-5 g-4 justify-content-center text-center wow fadeInUp" data-wow-delay="0.3s">
                
                <!-- Link item 1 -->
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm p-3 bg-white rounded hover-shadow transition-all">
                        <!-- Replaced icon with an image tag -->
                        <div class="mb-3 d-flex align-items-center justify-content-center" style="height: 60px;">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/c/c7/Google_Scholar_logo.svg" alt="Google Scholar" 
                            style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>
                        <h6 class="mb-2 fw-bold text-dark">Google Scholar</h6>
                        <a href="https://scholar.google.com" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 mt-auto">Visit Site</a>
                    </div>
                </div>

                <!-- Link item 2 -->
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm p-3 bg-white rounded hover-shadow transition-all">
                        <!-- Replaced icon with an image tag -->
                        <div class="mb-3 d-flex align-items-center justify-content-center" style="height: 60px;">
                            <img src="https://e-saliksik.deped.gov.ph/wp-content/uploads/2019/11/web-page-29.png" alt="E-Saliksik" 
                            style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>
                        <h6 class="mb-2 fw-bold text-dark">E-Saliksik</h6>
                        <a href="https://e-saliksik.deped.gov.ph/" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 mt-auto">Visit Site</a>
                    </div>
                </div>

                <!-- Link item 3 -->
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm p-3 bg-white rounded hover-shadow transition-all">
                        <!-- Replaced icon with an image tag -->
                        <div class="mb-3 d-flex align-items-center justify-content-center" style="height: 60px;">
                            <img src="https://researchportal.depedro1.com/rps/src/media/logo.png" alt="DepEd Region 1" 
                            style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>
                        <h6 class="mb-2 fw-bold text-dark">DepEd Region I Research Portal</h6>
                        <a href="https://researchportal.depedro1.com/" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 mt-auto">Visit Site</a>
                    </div>
                </div>

                <!-- Link item 4 -->
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm p-3 bg-white rounded hover-shadow transition-all">
                        <!-- Replaced icon with an image tag -->
                        <div class="mb-3 d-flex align-items-center justify-content-center" style="height: 60px;">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSLvi9FQmRTtpdkCxXghtD0XYJs2lA7itwixr2lsRgutQ&s=10" alt="PH Ejournals" 
                            style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>
                        <h6 class="mb-2 fw-bold text-dark">PH EJournals</h6>
                        <a href="https://ejournals.ph/journals.php" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 mt-auto">Visit Site</a>
                    </div>
                </div>

                <!-- Link item 5 -->
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm p-3 bg-white rounded hover-shadow transition-all">
                        <!-- Replaced icon with an image tag -->
                        <div class="mb-3 d-flex align-items-center justify-content-center" style="height: 60px;">
                            <img src="https://landportal.org/sites/default/files/2023-05/ScienceDirect.JPG" alt="ScienceDirect" 
                            style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>
                        <h6 class="mb-2 fw-bold text-dark">ScienceDirect</h6>
                        <a href="https://www.sciencedirect.com" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 mt-auto">Visit Site</a>
                    </div>
                </div>
                
            </div>
            <!-- Grid Layout configured to force 5 equal columns per row on Medium screens and up -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-5 g-4 justify-content-center text-center wow fadeInUp" data-wow-delay="0.3s">
                
                <!-- Link item 6 -->
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm p-3 bg-white rounded hover-shadow transition-all">
                        <!-- Replaced icon with an image tag -->
                        <div class="mb-3 d-flex align-items-center justify-content-center" style="height: 60px;">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSSPo7dSYgSOlak6Xlyo8oTt3IgPAlnwlKgm24xUjXexetm7TEcOEpcvsw&s=10" alt="JSTOR" 
                            style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>
                        <h6 class="mb-2 fw-bold text-dark">JSTOR</h6>
                        <a href="https://www.jstor.org/" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 mt-auto">Visit Site</a>
                    </div>
                </div>

                <!-- Link item 7 -->
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm p-3 bg-white rounded hover-shadow transition-all">
                        <!-- Replaced icon with an image tag -->
                        <div class="mb-3 d-flex align-items-center justify-content-center" style="height: 60px;">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSeGoV4EohHOpA7O0OcSCN3G0hnVToFxsa5taMdBO_H7g&s=10" alt="DOAJ" 
                            style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>
                        <h6 class="mb-2 fw-bold text-dark">DOAJ</h6>
                        <a href="https://doaj.org" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 mt-auto">Visit Site</a>
                    </div>
                </div>

                <!-- Link item 8 -->
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm p-3 bg-white rounded hover-shadow transition-all">
                        <!-- Replaced icon with an image tag -->
                        <div class="mb-3 d-flex align-items-center justify-content-center" style="height: 60px;">
                            <img src="https://scispace.com/resources/content/images/2022/10/Elsevier.png" alt="Elsevier" 
                            style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>
                        <h6 class="mb-2 fw-bold text-dark">Elsevier</h6>
                        <a href="https://www.elsevier.com/" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 mt-auto">Visit Site</a>
                    </div>
                </div>

                <!-- Link item 9 -->
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm p-3 bg-white rounded hover-shadow transition-all">
                        <!-- Replaced icon with an image tag -->
                        <div class="mb-3 d-flex align-items-center justify-content-center" style="height: 60px;">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRcRaPlZ2xfLy5ntrGIzGphR_Zz6YtNRAZ-avAWqQWPjw&s=10" alt="SagePub" 
                            style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>
                        <h6 class="mb-2 fw-bold text-dark">SagePub</h6>
                        <a href="https://journals.sagepub.com/" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 mt-auto">Visit Site</a>
                    </div>
                </div>

                <!-- Link item 10 -->
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm p-3 bg-white rounded hover-shadow transition-all">
                        <!-- Replaced icon with an image tag -->
                        <div class="mb-3 d-flex align-items-center justify-content-center" style="height: 60px;">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSopcmzZAnYBwJwB9yAEshzdMZQG4l4ZcUYAxL4RL2g&s=10" alt="EricEd" 
                            style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>
                        <h6 class="mb-2 fw-bold text-dark">EricEd</h6>
                        <a href="https://eric.ed.gov/" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 mt-auto">Visit Site</a>
                    </div>
                </div>
                
            </div>
            <!-- Grid Layout configured to force 5 equal columns per row on Medium screens and up -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-5 g-4 justify-content-center text-center wow fadeInUp" data-wow-delay="0.3s">
                
                <!-- Link item 11 -->
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm p-3 bg-white rounded hover-shadow transition-all">
                        <!-- Replaced icon with an image tag -->
                        <div class="mb-3 d-flex align-items-center justify-content-center" style="height: 60px;">
                            <img src="https://library.northsouth.edu/wp-content/uploads/2021/03/springer-links.png" alt="Springer Nature" 
                            style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>
                        <h6 class="mb-2 fw-bold text-dark">Springer Nature</h6>
                        <a href="https://link.springer.com/journals" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 mt-auto">Visit Site</a>
                    </div>
                </div>

                <!-- Link item 12 -->
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm p-3 bg-white rounded hover-shadow transition-all">
                        <!-- Replaced icon with an image tag -->
                        <div class="mb-3 d-flex align-items-center justify-content-center" style="height: 60px;">
                            <img src="https://pbs.twimg.com/profile_images/1995842947263160320/enBgHEI__400x400.jpg" alt="SciMagoJr" 
                            style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>
                        <h6 class="mb-2 fw-bold text-dark">SciMagoJr</h6>
                        <a href="https://www.scimagojr.com/journalrank.php" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 mt-auto">Visit Site</a>
                    </div>
                </div>

                <!-- Link item 13 -->
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm p-3 bg-white rounded hover-shadow transition-all">
                        <!-- Replaced icon with an image tag -->
                        <div class="mb-3 d-flex align-items-center justify-content-center" style="height: 60px;">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS7R69XjUNUjadoivwWLF3f8hjefLrYX0xFfdnIGlPNz3yQdBITMQ_6-z8&s=10" alt="Wiley" 
                            style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>
                        <h6 class="mb-2 fw-bold text-dark">Wiley Online Library</h6>
                        <a href="https://onlinelibrary.wiley.com/" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 mt-auto">Visit Site</a>
                    </div>
                </div>

                <!-- Link item 14 -->
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm p-3 bg-white rounded hover-shadow transition-all">
                        <!-- Replaced icon with an image tag -->
                        <div class="mb-3 d-flex align-items-center justify-content-center" style="height: 60px;">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQINhphRHbdu7lA20gwQoKDMuQRui0RpeSPGKL4o53qS7jxRWIpBOboDHe9&s=10" alt="T&F" 
                            style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>
                        <h6 class="mb-2 fw-bold text-dark">Taylor and Francis Group</h6>
                        <a href="https://www.tandfonline.com/" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 mt-auto">Visit Site</a>
                    </div>
                </div>

                <!-- Link item 15 -->
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm p-3 bg-white rounded hover-shadow transition-all">
                        <!-- Replaced icon with an image tag -->
                        <div class="mb-3 d-flex align-items-center justify-content-center" style="height: 60px;">
                            <img src="https://mdpiblog.wordpress.sciforum.net/wp-content/uploads/sites/4/2021/04/logo-mdpi-25-SM.jpg" alt="MDPI" 
                            style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>
                        <h6 class="mb-2 fw-bold text-dark">MDPI</h6>
                        <a href="https://www.mdpi.com/" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 mt-auto">Visit Site</a>
                    </div>
                </div>
                
            </div>
            <!-- Grid Layout configured to force 5 equal columns per row on Medium screens and up -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-5 g-4 justify-content-center text-center wow fadeInUp" data-wow-delay="0.3s">
                
                <!-- Link item 16 -->
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm p-3 bg-white rounded hover-shadow transition-all">
                        <!-- Replaced icon with an image tag -->
                        <div class="mb-3 d-flex align-items-center justify-content-center" style="height: 60px;">
                            <img src="https://plos.org/wp-content/uploads/2021/04/PLOS-logo_300px-wide_navy.png" alt="Plos" 
                            style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>
                        <h6 class="mb-2 fw-bold text-dark">Plos</h6>
                        <a href="https://plos.org/" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 mt-auto">Visit Site</a>
                    </div>
                </div>

                
            </div>
            <!-- Mandatory Disclaimer Note Component -->
            <div class="row mt-5 wow fadeInUp" data-wow-delay="0.5s">
                <div class="col-10 mx-auto">
                    <div class="p-4 rounded-3 border-start border-warning border-4 bg-light text-muted" style="font-size: 0.85rem; line-height: 1.6;">
                        <span class="fw-bold text-dark d-block mb-1 text-uppercase small"><i class="fa fa-exclamation-circle text-warning me-1"></i> Note:</span>
                        The sources listed above are provided as starting points for locating credible, peer-reviewed, and institutionally recognized research materials. Teachers, learners, and other researchers are still responsible for independently verifying each source's currency, authorship, peer-review status, and relevance to their specific research topic before citing or referencing it. Availability of access (free vs. subscription-based) may also vary per database.
                    </div>
                </div>
            </div>
            <br>
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px; margin: 0 auto 3rem auto;">
                <h6 class="section-title bg-white text-center text-primary px-3 text-uppercase fw-bold"> American Psychological Association</h6>
                <h1 class="mb-4">APA STYLE</h1>
            </div>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-5 g-4 justify-content-center text-center wow fadeInUp" data-wow-delay="0.3s">
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm p-3 bg-white rounded hover-shadow transition-all">
                        <!-- Replaced icon with an image tag -->
                        <div class="mb-3 d-flex align-items-center justify-content-center" style="height: 60px;">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRMwp4DvIOoIfXKcIQKBiWFzVc-rwJn7hIe_s8iF3hYloM4yTmL7d-Dhtc&s=10" alt="ZoteroBib" 
                            style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>
                        <h6 class="mb-2 fw-bold text-dark">ZoteroBib</h6>
                        <a href="https://zbib.org/" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 mt-auto">Visit Site</a>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm p-3 bg-white rounded hover-shadow transition-all">
                        <!-- Replaced icon with an image tag -->
                        <div class="mb-3 d-flex align-items-center justify-content-center" style="height: 60px;">
                            <img src="https://apastyle.apa.org/Content/Images/megamenu/images@2x/apa-style-logo.png" alt="APA style" 
                            style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        </div>
                        <h6 class="mb-2 fw-bold text-dark">APA Style Org</h6>
                        <a href="https://plos.org/" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 mt-auto">Visit Site</a>
                    </div>
                </div>

                
            </div>

            
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
        // Hide placeholder graphics context 
        document.getElementById('viewer-placeholder').style.display = 'none';
        document.getElementById('pdf-viewer-badge').style.display = 'block';
        
        // Update title bar label text 
        document.getElementById('viewer-title').innerHTML = '<i class="fa fa-file-alt me-2 text-primary"></i> ' + titleText;
        
        // Target canvas and replace it with an interactive responsive browser object tag framework pointing to our file source URL
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
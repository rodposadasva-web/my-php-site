<?php
include 'database.php';

/* GET ALL NEWS */
$query = mysqli_query($conn,
"SELECT * FROM news
ORDER BY id DESC");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>News Article</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="icon" href="img/CCNHS.png">
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

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/news_css.css" rel="stylesheet">
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
                <a href="guest_dashboard.php" class="nav-item nav-link">Home</a>
                <a href="guest_about.php" class="nav-item nav-link">About us</a>
                <a href="guest_research.php" class="nav-item nav-link">Research</a>
                <a href="guest_announcement.php" class="nav-item nav-link">Announcements</a>
                <a href="guest_news.php" class="nav-item nav-link active">News</a>
                
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Resources</a>
                    <div class="dropdown-menu fade-down m-0 shadow border-0 rounded-bottom">
                        <a href="guest_policies.php" class="dropdown-item">Issuances</a>
                        <a href="guest_downloadables.php" class="dropdown-item">Downloadables</a>
                        <a href="guest_journal.php" class="dropdown-item">Journal Publication</a>
                        <a href="guest_accomp.php" class="dropdown-item">Accomplishment Reports</a>
                    </div>
                </div>
            </div>
            <a href="login.php" class="nav-item nav-link">Log in</a>
        </div>
    </nav>
    <!-- Navbar End -->


   <!-- Header Start -->
     <div class="container-fluid py-5 mb-5 page-header" style="background: linear-gradient(rgba(24, 29, 56, .7), rgba(24, 29, 56, .7)), url('img/ccn.jpg') center center no-repeat; background-size: cover;">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">NEWS ARTICLE</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="#announcement">Latest News</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <div class="container">

        <div class="announcement-grid">

            <?php
            while($row = mysqli_fetch_assoc($query)){
            ?>

            <div class="card" id="announcement" >

                <!-- IMAGE -->
                <img src="announcement_uploads/<?php echo $row['image']; ?>">

                <div class="card-content">

                    <!-- TITLE -->
                    <div class="announcement-title">
                        <?php echo $row['title']; ?>
                    </div>

                    <!-- META -->
                    <div class="meta">

                        by <?php echo $row['author']; ?>

                        |

                        <?php
                        echo date("F d, Y",
                        strtotime($row['date_posted']));
                        ?>

                    </div>

                    <!-- SHORT DESCRIPTION -->
                    <div class="description">

                        <?php
                        echo substr($row['description'], 0, 180);
                        ?>...

                    </div>

                    <!-- READ MORE -->
                    <a class="read-btn"
                    href="guest_view_announcement.php?id=<?php echo $row['id']; ?>">

                        Read More

                    </a>

                </div>

            </div>

            <?php
            }
            ?>

        </div>
    </div>


     <!-- Footer Start -->
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

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
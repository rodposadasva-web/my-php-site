<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include 'database.php';
$query = mysqli_query($conn,
"SELECT * FROM research_articles
ORDER BY id DESC
LIMIT 3");

$news_query = mysqli_query($conn,
"SELECT * FROM news
ORDER BY id DESC
LIMIT 4");



// --- WORKFLOW: DYNAMICALLY FETCH THE SPECIFIC ADMIN-SELECTED SPOTLIGHT ARTICLE ---
$spotlight_id_query = mysqli_query($conn, "SELECT setting_value FROM portal_settings WHERE setting_key = 'spotlight_article_id'");
$spotlight_setting = mysqli_fetch_assoc($spotlight_id_query);
$selected_spotlight_id = isset($spotlight_setting['setting_value']) ? intval($spotlight_setting['setting_value']) : 0;

$spotlight_article = null;
if ($selected_spotlight_id > 0) {
    $spotlight_query = mysqli_query($conn, "SELECT * FROM research_articles WHERE id = $selected_spotlight_id");
    if ($spotlight_query && mysqli_num_rows($spotlight_query) > 0) {
        $spotlight_article = mysqli_fetch_assoc($spotlight_query);
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Welcome to CCNHS</title>
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
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    
    <link href="css/style.css" rel="stylesheet">
    <link href="css/dash_css.css" rel="stylesheet">

     <style>
    /* 1. Setup the card wrapper container to clip the background layer animations safely */
    .rgb-spotlight-card {
        position: relative;
        background: #fff;
        border-radius: 12px !important; /* Slightly larger radius to account for inner padding overlay */
        overflow: hidden; /* Clips the spinning gradient to look like a clean edge border */
        z-index: 1;
        transition: box-shadow 0.5s ease-in-out;
        /* Dynamic subtle RGB outer glow fallback */
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    /* 2. Create the hidden canvas area under the card where the RGB colors will rotate */
    .rgb-spotlight-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        /* Explicit professional RGB spotlight spectrum mix */
        background: conic-gradient(
            #06BB9C, 
            #7e3af2, 
            #00a0b8, 
            #ffc107, 
            #06BB9C
        );
        animation: rotateRGBLights 6s linear infinite;
        z-index: -2;
    }

    /* 3. The inner mask that hides the center color and leaves only a clean 4px border track showing */
    .rgb-spotlight-card::after {
        content: '';
        position: absolute;
        /* Controls border thickness. Change 4px to 6px if you want a thicker light trail */
        top: 4px;
        left: 4px;
        right: 4px;
        bottom: 4px;
        background: #ffffff; /* Matches your card container color perfectly */
        border-radius: 8px;
        z-index: -1;
    }

    /* 4. Smooth Rotation Animation Timeline keyframes */
    @keyframes rotateRGBLights {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

    /* Optional: Elegant pulse glow enhancement when a user floats their mouse over the feature */
    .rgb-spotlight-card:hover {
        box-shadow: 0 15px 35px rgba(6, 187, 156, 0.25);
    }
</style>
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
    <div class="container-fluid py-2 text-white small" style="background-color: #14a2c5;">
        <div class="container d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
            
            <div class="d-flex flex-wrap justify-content-center align-items-center gap-3">
                <span class="d-flex align-items-center">
                    <i class="fa fa-phone-alt me-2" style="font-size: 0.85rem;"></i>
                    (075)-522-6653
                </span>
                <span class="d-none d-md-inline text-white-50">|</span>
                <span class="d-flex align-items-center">
                    <i class="fa fa-envelope me-2" style="font-size: 0.85rem;"></i>
                    ccnhsresearchandinnovationcenter@gmail.com
                </span>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <a href="https://www.facebook.com/profile.php?id=61553308320934" 
                class="text-white text-decoration-none d-flex align-items-center" 
                target="_blank" 
                title="Follow us on Facebook">
                    <i class="fab fa-facebook-f me-1"></i>
                </a>
                <span class="text-white-50 small">|</span>
                <span class="fw-bold text-uppercase tracking-wider" style="font-size: 0.75rem; letter-spacing: 0.5px;">
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
                <a href="dashboard.php" class="nav-item nav-link active">Home</a>
                <a href="about.php" class="nav-item nav-link">About us</a>
                <a href="research.php" class="nav-item nav-link">Research</a>
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


    <!-- Carousel Start -->
   <div class="container-fluid p-0 mb-5">
    <div class="owl-carousel owl-theme header-carousel position-relative">
        
        <div class="owl-carousel-item position-relative">
            <img class="img-fluid" src="img/cover.jpg" alt="CCNHS Campus" style="height: 100vh; object-fit: cover;">
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" 
                 style="background: linear-gradient(to right, rgba(24, 29, 56, 0.9) 0%, rgba(24, 29, 56, 0.2) 100%);">
                <div class="container">
                    <div class="row justify-content-start">
                        <div class="col-sm-10 col-lg-7">
                            <h5 class="text-primary text-uppercase fw-bold mb-3 animated slideInDown" style="letter-spacing: 2px;">
                                Knowledge Hub
                            </h5>
                            <h1 class="display-2 text-white fw-bold mb-4 animated slideInDown">
                                Welcome to CCNHS,<br>
                                <span class="text-primary"><?php echo $_SESSION['username']; ?></span>!
                            </h1>
                            <p class="fs-5 text-light mb-4 pb-2 animated slideInUp lh-base">
                                Empowering minds through technology, arts, and science. <br class="d-none d-md-block"> 
                                Explore our latest publications and academic breakthroughs.
                            </p>
                            <div class="d-flex align-items-center animated slideInLeft">
                                <a href="research.php" class="btn btn-primary rounded-pill py-md-3 px-md-5 me-3 shadow-lg fw-bold">
                                    Explore Research
                                </a>
                                <a href="about.php" class="btn btn-outline-light rounded-pill py-md-3 px-md-5 fw-bold">
                                    About Us
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="owl-carousel-item position-relative">
            <img class="img-fluid" src="img/ccn.jpg" alt="Research at CCNHS" style="height: 100vh; object-fit: cover;">
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" 
                 style="background: linear-gradient(to right, rgba(24, 29, 56, 0.9) 0%, rgba(24, 29, 56, 0.2) 100%);">
                <div class="container">
                    <div class="row justify-content-start">
                        <div class="col-sm-10 col-lg-7">
                            <h5 class="text-primary text-uppercase fw-bold mb-3 animated slideInDown" style="letter-spacing: 2px;">
                                Innovation & Discovery
                            </h5>
                            <h1 class="display-2 text-white fw-bold mb-4 animated slideInDown">
                                Elevate Your Research Journey
                            </h1>
                            <p class="fs-5 text-light mb-4 pb-2 animated slideInUp">
                                Access our comprehensive library of research articles and 
                                innovative projects created by our students and faculty.
                            </p>
                            <a href="research.php" class="btn btn-primary rounded-pill py-md-3 px-md-5 animated slideInLeft shadow-lg fw-bold">
                                Read More <i class="fa fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
    <!-- Carousel End -->


    <div class="container-xxl py-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card border-0 rounded-3 p-5 rgb-spotlight-card">
                        <div class="row align-items-center g-4">
                            
                            <div class="col-lg-9 col-md-8">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <span class="badge px-3 py-2 text-white text-uppercase" style="background-color: #181d38; font-size: 0.8rem; letter-spacing: 1px; border-radius: 30px;">
                                        <i class="fa fa-star text-warning me-1"></i> RESEARCH SPOTLIGHT
                                    </span>
                                    <?php if ($spotlight_article && !empty($spotlight_article['research_area'])): ?>
                                        <span class="badge bg-light text-secondary border px-3 py-2 small text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                            <?php echo htmlspecialchars($spotlight_article['research_area']); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <?php if ($spotlight_article): ?>
                                    <h2 class="text-dark mb-3 fw-bold" style="font-family: 'Nunito', sans-serif; font-size: 2rem; line-height: 1.4;">
                                        <?php echo htmlspecialchars($spotlight_article['title']); ?>
                                    </h2>
                                    
                                    <div class="text-primary mb-4 fw-medium" style="font-size: 1.05rem;">
                                        <span class="me-4"><i class="fa fa-user text-primary me-2"></i>Researchers: <span class="text-dark fw-bold"><?php echo htmlspecialchars($spotlight_article['author']); ?></span></span>
                                        <?php if (!empty($spotlight_article['strand'])): ?>
                                            <span><i class="fa fa-graduation-cap text-primary me-2"></i>Strand: <span class="text-dark fw-bold"><?php echo htmlspecialchars($spotlight_article['strand']); ?></span></span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="bg-light p-4 rounded-3 border-start border-4 border-secondary" style="font-style: italic; color: #334155; font-size: 1.05rem; line-height: 1.6;">
                                        <span class="fw-bold text-secondary d-block small mb-2 text-uppercase" style="font-style: normal; font-size: 0.8rem; letter-spacing: 0.5px;">Executive Abstract:</span>
                                        "<?php echo htmlspecialchars(mb_strimwidth($spotlight_article['abstract'], 0, 450, "...")); ?>"
                                    </div>
                                <?php else: ?>
                                    <h4 class="text-muted fw-normal my-4">No Active Spotlights Currently Available</h4>
                                <?php endif; ?>
                            </div>

                            <div class="col-lg-3 col-md-4 text-md-end text-start">
                                <?php if ($spotlight_article): ?>
                                    <div class="d-flex flex-column gap-3 align-items-md-end">
                                        <a href="research.php" 
                                        class="btn btn-primary px-4 py-3 rounded-pill shadow fw-bold d-inline-flex align-items-center justify-content-center text-uppercase"
                                        style="background-color: #181d38; border-color: #181d38; font-size: 0.9rem; letter-spacing: 0.5px; min-width: 200px;">
                                            <i class="fa fa-file-pdf me-2"></i> Read Full Paper
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- About Start -->
   <div class="container-xxl py-6">
    <div class="container">
        <div class="row g-5 align-items-center">
            <!-- Video Column -->
            <div class="col-lg-6 wow zoomIn" data-wow-delay="0.1s">
                <div class="position-relative overflow-hidden rounded-4 shadow-lg" style="padding-top: 56.25%;">
                    <iframe 
                        class="position-absolute top-0 start-0 w-100 h-100"
                        src="https://www.facebook.com/plugins/video.php?height=314&href=https%3A%2F%2Fwww.facebook.com%2Freel%2F1255439882841345%2F&show_text=false&width=560&t=0" 
                        style="border:none; overflow:hidden;" 
                        scrolling="no" 
                        frameborder="0" 
                        allowfullscreen="true" 
                        allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share">
                    </iframe>
                    
                </div>
            </div>
            
            <!-- Text Content Column -->
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                <h6 class="text-start text-primary text-uppercase fw-bold mb-2">Our Legacy</h6>
                <h1 class="display-5 mb-4 fw-bold">Welcome to <span class="text-primary">CCNHS</span></h1>
                <p class="lead mb-4"><b class="text-dark">CCNHS - CONNECTED ARCHIVAL FOR RESEARCH, INNOVATION, AND NETWORK ACCESS </b> <br>Enhancing Generational Connectivity Engaging Global Community</p>
                
                <div class="row g-3 mb-4">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <div class="btn-sm-square bg-primary rounded-circle me-2">
                                <i class="fa fa-check text-white"></i>
                            </div>
                            <span>Visionary Leadership</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <div class="btn-sm-square bg-primary rounded-circle me-2">
                                <i class="fa fa-check text-white"></i>
                            </div>
                            <span>Community Linked</span>
                        </div>
                    </div>
                </div>
                <a class="btn btn-primary rounded-pill py-3 px-5 shadow" href="about.php">Learn More About Us</a>
            </div>
        </div>
    </div>
</div>
    <!-- About End --> 

    <!-- Research Start -->
    <div class="container-fluid py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5 wow fadeInUp">
                <h6 class=" text-center text-primary px-3">Knowledge Hub</h6>
                <h2 class="fw-bold">Latest Research Articles</h2>
            </div>
            <div class="row g-4">
                <?php while($row = mysqli_fetch_assoc($query)): ?>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
        <div class="card border-0 shadow-sm h-100 research-hover">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between mb-3 small text-primary">
                    <span class="fw-bold">
                        <i class="fa fa-flask me-2"></i><?php echo htmlspecialchars($row['research_area']); ?>
                    </span>
                    <span>
                        <i class="fa fa-calendar-alt me-1"></i>
                        <?php 
                        if (!empty($row['start_date']) && $row['start_date'] !== '0000-00-00') {
                            echo date("Y", strtotime($row['start_date'])); 
                        } else {
                            echo "N/A";
                        }
                        ?>
                    </span>
                </div>
                
                <h5 class="card-title fw-bold mb-2">
                    <?php echo htmlspecialchars($row['title']); ?>
                </h5>
                
                <p class="text-muted small mb-3">
                    <i class="fa fa-user me-2 text-secondary"></i>
                    <strong>Author(s):</strong> <?php echo htmlspecialchars($row['author']); ?>
                </p>

                <p class="card-text text-secondary small mb-0">
                    <?php 
                    $abstract = $row['abstract'];
                    $limit = 150; // Max number of characters to display on the card
                    
                    if (mb_strlen($abstract) > $limit) {
                        // Cuts the text at the limit and appends dots
                        echo htmlspecialchars(mb_substr($abstract, 0, $limit)) . '...';
                    } else {
                        echo htmlspecialchars($abstract);
                    }
                    ?>
                </p>
            </div>
            
            <div class="card-footer bg-white border-0 p-4 pt-0">
                <a href="view_research.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary btn-sm w-100 rounded-pill">Read Full Paper</a>
            </div>
        </div>
    </div>
            <?php endwhile; ?>
        </div>
        <div class="text-center mt-5">
            <a class="btn btn-primary py-3 px-5 rounded-pill shadow" href="research.php">Explore All Publications</a>
        </div>
    </div>
    </div>
    <!-- Research End -->

    <!-- News Start -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="text-center mb-5">
                <h6 class="text-primary text-uppercase fw-bold mb-2">Stay Updated</h6>
                <h1 class="display-6 fw-bold">Latest News</h1>
            </div>

        <div class="owl-carousel owl-theme testimonial-carousel position-relative">
            <?php while($row = mysqli_fetch_assoc($news_query)){ ?>
            <div class="testimonial-item px-3">
                <div class="bg-white rounded-4 shadow-sm border-0 overflow-hidden h-100 transition-hover">
                    <div class="position-relative">
                        <a href="view_announcement.php?id=<?php echo $row['id']; ?>">
                            <img class="img-fluid w-100" 
                                 src="announcement_uploads/<?php echo $row['image']; ?>" 
                                 style="height: 200px; object-fit: cover;" alt="">
                        </a>
                        <div class="bg-primary text-white position-absolute bottom-0 start-0 px-3 py-1 m-3 rounded-pill small">
                            <i class="fa fa-calendar-alt me-2"></i>
                            <?php echo date("M d, Y", strtotime($row['date_posted'])); ?>
                        </div>
                    </div>

                    <div class="p-4 text-center">
                        <h5 class="fw-bold mb-3"><?php echo $row['title']; ?></h5>
                        <p class="text-muted mb-4 small">
                            <?php echo htmlspecialchars(mb_strimwidth($row['description'], 0, 100, "...")); ?>
                        </p>
                        <a href="view_announcement.php?id=<?php echo $row['id']; ?>" 
                           class="btn btn-outline-primary rounded-pill px-4 btn-sm fw-bold">
                           Read Details
                        </a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

            <div class="text-center mt-5">
                <a class="btn btn-primary rounded-pill py-3 px-5 shadow-sm" href="news.php">
                    View All News <i class="fa fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- Announcement End -->

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <script src="js/main.js"></script>

    
</body>

</html>
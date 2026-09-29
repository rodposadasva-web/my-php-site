<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>About Us</title>
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <style>
    .service-item:hover {
        background-color: #0c9881 !important;
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.1) !important;
        border-top-color: #06BB9C !important; /* Changes top border line to matching secondary brand color on hover */
    }
    .border-transparent {
        border-top-color: transparent !important;
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
                <a href="guest_dashboard.php" class="nav-item nav-link ">Home</a>
                <a href="guest_about.php" class="nav-item nav-link active">About us</a>
                <a href="guest_research.php" class="nav-item nav-link">Research</a>
                <a href="guest_announcement.php" class="nav-item nav-link">Announcements</a>
                <a href="guest_news.php" class="nav-item nav-link">News</a>
                
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
                    <h1 class="display-3 text-white animated slideInDown">ABOUT US</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="#numbers">Numbers</a></li>
                            <li class="breadcrumb-item"><a class="text-white" href="#vision">Vision</a></li>
                            <li class="breadcrumb-item"><a class="text-white" href="#programs">Programs</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->
    <div class="container py-5">

    <div class="container py-5">
        <div class="text-center mb-5">
            <h6 class="text-primary text-uppercase fw-bold" style="letter-spacing: 1px;">Leadership & Structure</h6>
            <h2 class="fw-bold text-dark">Center Organizational Chart</h2>
            <div class="mx-auto my-2" style="width: 50px; height: 3px; background-color: #00a0b8;"></div>
        </div>

        <div class="container-fluid py-5 bg-white">
    <div class="container py-4">
        <div class="row g-5 align-items-stretch">
            
            <div class="col-lg-5 d-flex flex-column align-items-center justify-content-center text-center" style="background-color: #ffffff; border-radius: 12px; padding: 40px;">
                <div class="mb-4 rounded-circle overflow-hidden shadow border border-4 border-light" style="width: 280px; height: 280px; max-width: 100%;">
                    <!-- The dimensions are now increased to 280px to make the portrait look prominent and clear -->
                    <img src="img/principal.png" alt="Carina C. Untalasco, PhD" style="width: 280px; height: 280px; min-width: 100%; min-height: 100%; object-fit: cover;">
                </div>
                <h2 class="h3 text-black fw-bold mb-2" style="font-family: 'Nunito', sans-serif; letter-spacing: 0.5px;">
                    CARINA C. UNTALASCO, PhD
                </h2>
                <p class="fw-semibold m-0 tracking-wider text-uppercase" style="color: #00a0b8; font-size: 0.9rem;">
                    Principal IV
                </p>
                <div style="width: 60px; height: 3px; background-color: #dca113; margin-top: 20px;"></div>
            </div>

            <div class="col-lg-7 d-flex flex-column justify-content-between px-lg-5">
                <div class="text-secondary" style="font-family: 'Heebo', sans-serif; font-size: 1.05rem; line-height: 1.7; text-align: justify;">
                    <h4 class="text-primary fw-bold mb-3" style="font-family: 'Nunito', sans-serif;">
                        Message
                    </h4>
                    <p class="mb-4">
                        <b>Welcome to the CCNHS Connected Archival for Research, Innovation, and Network Access.</b> In this fast-changing world, technology now shapes almost everything we do—even the way we learn and discover new things. 
                        Calasiao Comprehensive National High School keeps up with this change by providing our learners, teachers, and other 
                        key stakeholders a place to call their own. A space where good ideas and hard work don’t just gather dust. Instead, 
                        they get shared, read, and truly put to good use.
                    </p>
                    <p class="mb-4">
                        This research portal is more than just a digital library. It is a living collection of the research studies where 
                        learners and teachers have poured their time, curiosity, and dedication—asking real questions and trying to answer 
                        them with evidence. Every study in this archive shows that big change can start small with one question, one study, 
                        one person who decided to find out. Whether you are looking for inspiration, collecting evidence for a research project, 
                        or dreaming up your own journey in research, please know that your ideas matter, your questions matter, and the answers 
                        you’re looking for might just help shape the future of our school.
                    </p>
                    <p class="mb-4">
                        So let every research study in this portal inspire and motivate you. Remember that you also have the full potential 
                        to discover, to question, and to contribute something meaningful and bring transformational impact to society.
                    </p>
                    <p class="mb-4 fw-semibold text-dark">
                        Because at CCNHS, knowledge is never meant to stay still. It is meant to inspire the next question, the next discovery, 
                        the next dream, right at your fingertips.
                    </p>
                </div>

                <div class="mt-4 pt-3 border-top border-light">
                    <h6 class="fw-bold m-0" style="color: #dca113; font-family: 'Nunito', sans-serif; font-size: 1rem; letter-spacing: 0.5px;">
                        CCNHS Connected Archival for Research, Innovation, and Network Access 
                    </h6>
                    <small class="text-muted text-uppercase fw-semibold tracking-wider d-block mt-1" style="font-size: 0.75rem;">
                        – Enhancing Generational Connectivity, Engaging Glocal Community.
                    </small>
                </div>
            </div>

        </div>
    </div>
</div>

        <div class="d-none d-md-block mx-auto bg-secondary-subtle" style="width: 2px; height: 30px; background-color: #ddd;"></div>

        <div class="card border-0 shadow-sm p-4 mb-4 rounded-3 bg-light">
            <div class="text-center mb-3">
                <small class="text-uppercase tracking-wider fw-bold text-secondary" style="font-size: 0.75rem; letter-spacing: 1px;">Departmental Consultants / HT-VI</small>
            </div>
            <div class="row g-3 row-cols-2 row-cols-md-3 row-cols-lg-6 justify-content-center">
                <div class="col">
                    <div class="bg-white p-3 rounded-3 shadow-sm text-center h-100 border-start border-secondary border-3">
                        <p class="fw-bold mb-0 text-dark small" style="line-height: 1.2;">NANCY T. UGON</p>
                        <p class="text-muted mb-0" style="font-size: 11px;">HT-VI, Araling Panlipunan</p>
                    </div>
                </div>
                <div class="col">
                    <div class="bg-white p-3 rounded-3 shadow-sm text-center h-100 border-start border-secondary border-3">
                        <p class="fw-bold mb-0 text-dark small" style="line-height: 1.2;">MARIA SELMA S. SOLIS</p>
                        <p class="text-muted mb-0" style="font-size: 11px;">HT-VI, English Dept.</p>
                    </div>
                </div>
                <div class="col">
                    <div class="bg-white p-3 rounded-3 shadow-sm text-center h-100 border-start border-secondary border-3">
                        <p class="fw-bold mb-0 text-dark small" style="line-height: 1.2;">RENANTE G. DE GUZMAN, PhD</p>
                        <p class="text-muted mb-0" style="font-size: 11px;">HT-VI, Filipino Dept.</p>
                    </div>
                </div>
                <div class="col">
                    <div class="bg-white p-3 rounded-3 shadow-sm text-center h-100 border-start border-secondary border-3">
                        <p class="fw-bold mb-0 text-dark small" style="line-height: 1.2;">MARIA DAISY M. ICO, EdD</p>
                        <p class="text-muted mb-0" style="font-size: 11px;">HT-VI, Mathematics Dept.</p>
                    </div>
                </div>
                <div class="col">
                    <div class="bg-white p-3 rounded-3 shadow-sm text-center h-100 border-start border-secondary border-3">
                        <p class="fw-bold mb-0 text-dark small" style="line-height: 1.2;">SONNY J. DULAY</p>
                        <p class="text-muted mb-0" style="font-size: 11px;">HT-VI, MAPEH Dept.</p>
                    </div>
                </div>
                <div class="col">
                    <div class="bg-white p-3 rounded-3 shadow-sm text-center h-100 border-start border-secondary border-3">
                        <p class="fw-bold mb-0 text-dark small" style="line-height: 1.2;">RUEL S. NEPUSCUA, PhD</p>
                        <p class="text-muted mb-0" style="font-size: 11px;">HT-VI, TLE Dept.</p>
                    </div>
                </div>
            </div>
            
            <div class="row g-3 row-cols-1 row-cols-sm-3 justify-content-center mt-2 border-top pt-3 border-2 border-white">
                <div class="col">
                    <div class="bg-white p-2 px-3 rounded-3 shadow-sm text-center">
                        <p class="fw-bold mb-0 text-dark small">MARLENE Y. CANTO</p>
                        <p class="text-muted mb-0" style="font-size: 11px;">HT-III, Science Dept.</p>
                    </div>
                </div>
                <div class="col">
                    <div class="bg-white p-2 px-3 rounded-3 shadow-sm text-center">
                        <p class="fw-bold mb-0 text-dark small">MELQUISEDEC EDWIN C. OCUMEN, EdD</p>
                        <p class="text-muted mb-0" style="font-size: 11px;">HT-III, ESP Dept.</p>
                    </div>
                </div>
                <div class="col">
                    <div class="bg-white p-2 px-3 rounded-3 shadow-sm text-center">
                        <p class="fw-bold mb-0 text-dark small">JOMER G. MAMARIL, EdD</p>
                        <p class="text-muted mb-0" style="font-size: 11px;">HT-III, TLE Dept.</p>
                    </div>
                </div>
                <div class="col mt-2">
                    <div class="bg-white p-2 px-3 rounded-3 shadow-sm text-center">
                        <p class="fw-bold mb-0 text-dark small">Engr. JACKIELOU D. DECENA</p>
                        <p class="text-muted mb-0" style="font-size: 11px;">OIC - Senior High School</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-none d-md-block mx-auto bg-secondary-subtle" style="width: 2px; height: 30px; background-color: #ddd;"></div>

        <div class="row justify-content-center mb-5">
            <div class="col-md-5 text-center">
                <div class="card border-0 shadow p-3 rounded-3 bg-dark text-white border-bottom border-warning border-4">
                    <h5 class="fw-bold mb-1 text-warning" style="font-size: 1.2rem;">HERNANDO C. ABALOS, Jr.</h5>
                    <p class="mb-0 text-white-50 small tracking-widest text-uppercase fw-semibold" style="font-size: 0.75rem; letter-spacing: 1px;">Master Teacher II / Center Head</p>
                </div>
            </div>
        </div>

        <div class="row g-3 justify-content-center">
            
            <div class="col-xl col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm h-100 bg-white rounded-3">
                    <div class="card-header border-0 py-3 text-center text-white" style="background-color: #00a0b8;">
                        <h6 class="mb-0 fw-bold style-heading" style="font-size: 0.8rem; letter-spacing: 0.5px;">SCHOOL RESEARCH COMMITTEE</h6>
                    </div>
                    <div class="card-body p-3 text-center">
                        <div class="mb-2"><strong class="small text-dark d-block">GENESIS G. PAREL, PhD</strong><span class="text-muted" style="font-size:11px;">Chairperson</span></div>
                        <div class="mb-2"><strong class="small text-dark d-block">Engr. MERIAN D. GALANG, PhD</strong><span class="text-muted" style="font-size:11px;">Co-Chairperson</span></div>
                        <div class="mb-2"><strong class="small text-secondary d-block">MINASOL M. VALLO</strong><span class="text-muted" style="font-size:10px;">Member</span></div>
                        <div><strong class="small text-secondary d-block">CHRISTOPHER V. ZARATE</strong><span class="text-muted" style="font-size:10px;">Member</span></div>
                    </div>
                </div>
            </div>

            <div class="col-xl col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm h-100 bg-white rounded-3">
                    <div class="card-header border-0 py-3 text-center text-white" style="background-color: #00a0b8;">
                        <h6 class="mb-0 fw-bold style-heading" style="font-size: 0.8rem; letter-spacing: 0.5px;">SCHOOL RESEARCH ETHICS COMMITTEE</h6>
                    </div>
                    <div class="card-body p-3 text-center">
                        <div class="mb-2"><strong class="small text-dark d-block">IVANSHANE L. MALALA, PhD</strong><span class="text-muted" style="font-size:11px;">Chairperson</span></div>
                        <div class="mb-2"><strong class="small text-dark d-block">VIRGIE U. PANINGBATAN</strong><span class="text-muted" style="font-size:11px;">Co-Chairperson</span></div>
                        <div class="mt-3"><strong class="small text-secondary d-block">DIONISIA CA. SALAYOG, PhD</strong><span class="text-muted" style="font-size:10px;">Member</span></div>
                    </div>
                </div>
            </div>

            <div class="col-xl col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm h-100 bg-white rounded-3">
                    <div class="card-header border-0 py-3 text-center text-white" style="background-color: #00a0b8;">
                        <h6 class="mb-0 fw-bold style-heading" style="font-size: 0.8rem; letter-spacing: 0.5px;">SCHOOL INNOVATION COMMITTEE</h6>
                    </div>
                    <div class="card-body p-3 text-center">
                        <div class="mb-2"><strong class="small text-dark d-block">BERNADETTE L. ALCANZARE, PhD</strong><span class="text-muted" style="font-size:11px;">Chairperson</span></div>
                        <div class="mb-2"><strong class="small text-dark d-block">BENJIE Q. PAGLINGAYEN, PhD</strong><span class="text-muted" style="font-size:11px;">Co-Chairperson</span></div>
                        <div class="mb-2"><strong class="small text-secondary d-block">JESSELIE L. CALANGIAN, PhD</strong><span class="text-muted" style="font-size:10px;">Member</span></div>
                        <div><strong class="small text-secondary d-block">LORNA S. CALIMQUIM</strong><span class="text-muted" style="font-size:10px;">Member</span></div>
                    </div>
                </div>
            </div>

            <div class="col-xl col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm h-100 bg-white rounded-3">
                    <div class="card-header border-0 py-3 text-center text-white" style="background-color: #00a0b8;">
                        <h6 class="mb-0 fw-bold style-heading" style="font-size: 0.8rem; letter-spacing: 0.5px;">SCHOOL DATA ANALYTICS COMMITTEE</h6>
                    </div>
                    <div class="card-body p-3 text-center">
                        <div class="mb-2"><strong class="small text-dark d-block">Engr. JACKIELOU D. DECENA</strong><span class="text-muted" style="font-size:11px;">Chairperson</span></div>
                        <div class="mb-2"><strong class="small text-secondary d-block">NELDA L. ROSARIO</strong><span class="text-muted" style="font-size:10px;">Member</span></div>
                        <div class="mb-2"><strong class="small text-secondary d-block">GREGORY V. COQUIA</strong><span class="text-muted" style="font-size:10px;">Member</span></div>
                        <div class="mb-2"><strong class="small text-secondary d-block">JERICHO F. AUSTRIA</strong><span class="text-muted" style="font-size:10px;">Member</span></div>
                        <div><strong class="small text-secondary d-block">RICA P. ESTRADA</strong><span class="text-muted" style="font-size:10px;">Member</span></div>
                    </div>
                </div>
            </div>

            <div class="col-xl col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm h-100 bg-white rounded-3">
                    <div class="card-header border-0 py-3 text-center text-white" style="background-color: #00a0b8;">
                        <h6 class="mb-0 fw-bold style-heading" style="font-size: 0.75rem; letter-spacing: 0px;">RESEARCH & INNOVATION EDITORIAL BOARD</h6>
                    </div>
                    <div class="card-body p-3 text-center">
                        <div class="mb-2"><strong class="small text-dark d-block">KIMBERLY M. TICMAN, PhD</strong><span class="text-muted" style="font-size:11px;">Chairperson</span></div>
                        <div class="mb-2"><strong class="small text-dark d-block">CARMELITA M. PORRE, JD</strong><span class="text-muted" style="font-size:11px;">Co-Chairperson</span></div>
                        <div class="mb-2"><strong class="small text-secondary d-block">WILMA G. MACATBAG, PhD</strong><span class="text-muted" style="font-size:10px;">Member</span></div>
                        <div class="mb-2"><strong class="small text-secondary d-block">NINA D. CASTILLO</strong><span class="text-muted" style="font-size:10px;">Member</span></div>
                        <div><strong class="small text-secondary d-block">KARLA ANN C. MACARAEG</strong><span class="text-muted" style="font-size:10px;">Member</span></div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row justify-content-center mt-4">
            <div class="col-12 text-center">
                <div class="bg-secondary text-light py-2 px-4 rounded-pill d-inline-block small tracking-wide fw-medium" style="background-color: #6c757d !important; font-size: 0.8rem;">
                    TEACHING AND NON-TEACHING PERSONNEL, LEARNERS, PARENTS, AND OTHER KEY STAKEHOLDERS
                </div>
            </div>
        </div>
    </div>

    <!-- About the Center Section -->
    <div class="card border-0 shadow-sm p-4 p-md-5 bg-white rounded-3 my-4">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <h6 class="text-primary text-uppercase fw-bold mb-2" style="letter-spacing: 1px;">The Hub</h6>
                <h2 class="fw-bold mb-3 display-6 text-dark">About the Center</h2>
                <div class="bg-primary mb-4" style="width: 50px; height: 3px;"></div>
                
                <p class="text-secondary leading-relaxed">
                    The <strong>Center of Active Research and Innovation Navigating All Areas</strong> is the official research and innovation hub of Calasiao Comprehensive National High School (CCNHS), Calasiao, Pangasinan. Established in 2023 and formally institutionalized through an Unnumbered School Memorandum, series 2024 dated March 22, 2024, signed by <strong>Dr. Carina C. Untalasco, Principal IV</strong>, the center was created to guide the management of research and innovation programs, projects, and activities at the school level.
                </p>
                <p class="text-secondary mb-0">
                    The center was made possible through the generosity of <strong>Engr. Jake Q. Carbonell</strong>, a former student of Dr. Bernadette Alcanzare, who sourced out the structure that now houses the center.
                </p>
            </div>
            <div class="col-lg-5">
                <div class="p-4 bg-light rounded-3 border-start border-primary border-4 h-100">
                    <h5 class="fw-bold text-dark mb-3"><i class="bi bi-geo-alt-fill text-primary me-2"></i>Physical Location</h5>
                    <p class="small text-muted mb-0">
                        Physically located beside the STE (Science, Technology, and Engineering) classrooms, the center positions itself as a direct extension of both the school's science and technology instruction and its Senior High School (SHS) research electives (e.g., Research 1, Research 2, and Design and Innovation). This gives SHS learners convenient, hands-on access to research support as they move from proposal-writing through data analysis and final innovation outputs.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Legal and Policy Basis Section -->
    <div class="card border-0 shadow-sm p-4 p-md-5 bg-light rounded-3 my-4">
        <h6 class="text-secondary text-uppercase fw-bold mb-2" style="letter-spacing: 1px;">Framework</h6>
        <h2 class="fw-bold mb-3 text-dark">Legal & Policy Basis</h2>
        <div class="bg-secondary mb-4" style="width: 50px; height: 3px;"></div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-0 h-100 p-3 bg-white shadow-sm">
                    <h6 class="fw-bold text-primary"><i class="bi bi-shield-check me-2"></i>Constitutional & Legal Mandates</h6>
                    <p class="small text-muted mb-0">
                        Anchored on <strong>Article XIV, Section 10 of the 1987 Philippine Constitution</strong>, which mandates the State to prioritize research and development, and on <strong>Republic Act No. 9155</strong> (the Enhanced Basic Education Act of 2001), which calls for sustained educational research to improve basic education delivery.
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 h-100 p-3 bg-white shadow-sm">
                    <h6 class="fw-bold text-primary"><i class="bi bi-file-earmark-text me-2"></i>DepEd Orders & Issuances</h6>
                    <p class="small text-muted mb-0">
                        Operationalizes <strong>DepEd Order No. 16, s. 2017</strong> (Research Management Guidelines) and its amendment under <strong>DO No. 26, s. 2021</strong>, as well as <strong>DO No. 21, s. 2019</strong> on the K to 12 Basic Education Program.
                    </p>
                </div>
            </div>
            <div class="col-12">
                <div class="p-3 bg-white rounded shadow-sm border-start border-warning border-4">
                    <h6 class="fw-bold text-dark mb-2"><i class="bi bi-journal-bookmark-fill text-warning me-2"></i>DO No. 17, s. 2026: Strengthened Senior High School Curriculum</h6>
                    <p class="small text-muted mb-0">
                        Under this mandate, Research 1, Research 2, and Design and Innovation are offered as elective subjects available to SHS learners. The center supports the delivery of these electives by providing technical assistance, mentoring, and resources to teachers and learners—guiding them from foundational research skills (Research 1) through full research undertakings (Research 2) and into applied, innovation-oriented outputs (Design and Innovation).
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-6 wow fadeInUp" data-wow-delay="0.1s">
            <div class="card border-0 shadow-sm h-100 p-4 p-md-5 border-top border-primary border-4 rounded-3 bg-white">
                <div class="d-flex align-items-center mb-3">
                    <div class="btn-lg-square bg-primary-subtle text-primary rounded-circle p-3 me-3 d-inline-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background-color: #e0f4f7;">
                        <i class="bi bi-eye-fill text-primary fs-4" style="color: #00a0b8 !important;"></i>
                    </div>
                    <h2 class="fw-bold mb-0 text-dark" style="font-size: 1.8rem;">Our Vision</h2>
                </div>
                <p class="text-secondary lh-lg mb-0" style="text-align: justify; font-size: 15px;">
                    The Center for Active Research and Innovation Navigating All Areas envisions to become a hub of facilitating and nurturing research, innovation, and statistical analysis of Calasiao Comprehensive National High School guided by the core values of the Department of Education that will equip and empower love of lifelong learning and utilize information through quality, relevant, and timely research and innovative approaches catering the needs of the teachers, learners, and other key stakeholders.
                </p>
            </div>
        </div>

        <div class="col-md-6 wow fadeInUp" data-wow-delay="0.2s">
            <div class="card border-0 shadow-sm h-100 p-4 p-md-5 border-top border-primary border-4 rounded-3 bg-white">
                <div class="d-flex align-items-center mb-3">
                    <div class="btn-lg-square bg-primary-subtle text-primary rounded-circle p-3 me-3 d-inline-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background-color: #e0f4f7;">
                        <i class="bi bi-compass-fill text-primary fs-4" style="color: #00a0b8 !important;"></i>
                    </div>
                    <h2 class="fw-bold mb-0 text-dark" style="font-size: 1.8rem;">Our Mission</h2>
                </div>
                <p class="text-secondary lh-lg mb-0" style="text-align: justify; font-size: 15px;">
                    To actively support the Department of Education’s 5-point Agenda and Schools Division Office 1 Pangasinan initiatives focusing on fostering a culture of research and innovation at a school level creating a positive socio-cultural impact on the community.
                </p>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm p-4 p-md-5 mb-5 rounded-3 bg-white">
        <div class="text-center mb-4">
            <h6 class="text-primary text-uppercase fw-bold" style="letter-spacing: 1px;">Organizational Pillars</h6>
            <h2 class="fw-bold text-dark">Core Values</h2>
            <div class="mx-auto my-2" style="width: 50px; height: 3px; background-color: #00a0b8;"></div>
        </div>
        
        <div class="row g-4 justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-start p-3 rounded-3 bg-light h-100">
                    <span class="fw-black display-6 text-primary me-3 lh-1 fw-bold" style="color: #00a0b8 !important;">C</span>
                    <div>
                        <h6 class="fw-bold mb-1 text-dark">Commitment and creativity</h6>
                        <small class="text-muted">The center is committed to continuous research and development, fostering innovation, and creativity, and transferring ownership of ideas through creative interaction and learning.</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-start p-3 rounded-3 bg-light h-100">
                    <span class="fw-black display-6 text-primary me-3 lh-1 fw-bold" style="color: #00a0b8 !important;">A</span>
                    <div>
                        <h6 class="fw-bold mb-1 text-dark">Assurance of quality and excellence</h6>
                        <small class="text-muted">The center ensures the research and innovation processes, and its outcomes meet the highest standard. Further, the center sustains relevant and researchable inquiry, appropriate methods, and logical, coherent findings that are substantiated by data.</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-start p-3 rounded-3 bg-light h-100">
                    <span class="fw-black display-6 text-primary me-3 lh-1 fw-bold" style="color: #00a0b8 !important;">R</span>
                    <div>
                        <h6 class="fw-bold mb-1 text-dark">Responsibility and respect</h6>
                        <small class="text-muted">The center reinforces responsibility and respect in conducting research and innovation. This involves conducting work honestly, objectively, and with integrity. Further, this includes reporting data with fairness and openness, avoiding bias, and respecting intellectual property standards. Likewise, the center acknowledges researchers' contributions, treating individuals with dignity, and honoring rights and values. </small>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-start p-3 rounded-3 bg-light h-100">
                    <span class="fw-black display-6 text-primary me-3 lh-1 fw-bold" style="color: #00a0b8 !important;">I</span>
                    <div>
                        <h6 class="fw-bold mb-1 text-dark">Inclusiveness and integrity</h6>
                        <small class="text-muted">The center upholds integrity and transparency in all research and innovation activities. The center guarantees all concerned have equitable access to training, mentorship, and resources; it also incorporates a range of perspectives, protects the integrity of scientific inquiry, and produces quality research, transparent communication, and accountability. </small>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-start p-3 rounded-3 bg-light h-100">
                    <span class="fw-black display-6 text-primary me-3 lh-1 fw-bold" style="color: #00a0b8 !important;">N</span>
                    <div>
                        <h6 class="fw-bold mb-1 text-dark">Nurturing service and sustainability</h6>
                        <small class="text-muted">The center fosters a culture of service and promotes sustainable practices within the research and innovation community. The center is committed to making a positive impact in the school community and on society as a whole and ensuring that research and innovation practices are sustainable for future generations. </small>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-start p-3 rounded-3 bg-light h-100">
                    <span class="fw-black display-6 text-primary me-3 lh-1 fw-bold" style="color: #00a0b8 !important;">A</span>
                    <div>
                        <h6 class="fw-bold mb-1 text-dark">Active partnership and collaboration</h6>
                        <small class="text-muted">The center pursues active partnerships and collaboration with key stakeholders that require building relationships based on open communication, trust, and mutual respect. The center is committed to working together to share a common goal leading to more relevant, feasible, comprehensive research and innovation outcomes.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm p-4 p-md-5 rounded-3 bg-white">
        <div class="mb-4">
            <h6 class="text-primary text-uppercase fw-bold" style="letter-spacing: 1px;">Strategic Framework</h6>
            <h2 class="fw-bold text-dark">Center Objectives</h2>
            <div class="my-2" style="width: 50px; height: 3px; background-color: #00a0b8;"></div>
        </div>
        
        <div class="row g-4">
            <div class="col-12">
                <div class="table-responsive border-0">
                    <table class="table table-hover align-middle mb-0">
                        <tbody>
                            <tr>
                                <td style="width: 40px;" class="border-0 text-primary"><i class="bi bi-arrow-right-circle-fill"></i></td>
                                <td class="border-0 text-secondary py-3">Cultivate <b>active academic and social settings for teachers, learners, and other key stakeholders,</b> enabling the most effective and efficient teaching/learning and research and innovation possible.</td>
                            </tr>
                            <tr>
                                <td class="border-0 text-primary"><i class="bi bi-arrow-right-circle-fill"></i></td>
                                <td class="border-0 text-secondary py-3">Avidly provide <b>leadership and guidance</b> in conducting quality, relevant, and timely research studies in different fields with practical techniques in utilizing statistical tools.</td>
                            </tr>
                            <tr>
                                <td class="border-0 text-primary"><i class="bi bi-arrow-right-circle-fill"></i></td>
                                <td class="border-0 text-secondary py-3">Reflectively serve as a <b>training ground for teacher- and learner-researchers</b> from research (including the formulation, utilization, and dissemination), innovation with data analytics programs, projects, and activities.</td>
                            </tr>
                            <tr>
                                <td class="border-0 text-primary"><i class="bi bi-arrow-right-circle-fill"></i></td>
                                <td class="border-0 text-secondary py-3">Inspire and strengthen <b>collaborative partnerships and relationships</b> with different sectors and stakeholders in dealing with research and innovation.</td>
                            </tr>
                            <tr>
                                <td class="border-0 text-primary"><i class="bi bi-arrow-right-circle-fill"></i></td>
                                <td class="border-0 text-secondary py-3">Nurture and facilitate <b>intellectual discussions, utilization, and dissemination</b> of research and innovation outputs.</td>
                            </tr>
                            <tr>
                                <td class="border-0 text-primary"><i class="bi bi-arrow-right-circle-fill"></i></td>
                                <td class="border-0 text-secondary py-3">Authentically promote <b>positive attitude towards data-driven research and innovation</b> essential for thriving and progressive community.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Organizational Structure Section -->
<div class="card border-0 shadow-sm p-4 p-md-5 rounded-3 bg-white my-4 mx-0 mx-md-4 mx-lg-5">

    <h6 class="text-primary text-uppercase fw-bold mb-2" style="letter-spacing: 1px;">Governance</h6>
    <h2 class="fw-bold mb-3 text-dark">Organizational Structure</h2>
    <div class="bg-primary mb-4" style="width: 50px; height: 3px;"></div>

    <p class="text-secondary mb-4">
        The CCNHS Center for Active Research and Innovation Navigating All Areas is led by a <strong>Core Management Team</strong>, composed of the School Head (Chairperson) and Department Heads (Co-chairpersons), supported by a Center Focal Person/School Research Coordinator.
    </p>

    <h5 class="fw-bold mb-3 text-muted text-uppercase small" style="letter-spacing: 0.5px;">Five Specialized Technical Bodies</h5>
    <div class="row g-3">
        <!-- Committee 1 -->
        <div class="col-md-6 col-xl-4">
            <div class="p-3 bg-light rounded-3 h-100 border-top border-primary border-3">
                <h6 class="fw-bold text-dark small"><i class="bi bi-people text-primary me-2"></i>School Research Committee</h6>
                <p class="small text-muted mb-0">Guides research initiatives and mentors researchers, including learners taking research subjects under STE Program and Strengthened SHS Curriculum.</p>
            </div>
        </div>
        <!-- Committee 2 -->
        <div class="col-md-6 col-xl-4">
            <div class="p-3 bg-light rounded-3 h-100 border-top border-primary border-3">
                <h6 class="fw-bold text-dark small"><i class="bi bi-journal-check text-primary me-2"></i>School Research Ethical Review Board</h6>
                <p class="small text-muted mb-0">Ensures ethical compliance, informed consent, and confidentiality in all research.</p>
            </div>
        </div>
        <!-- Committee 3 -->
        <div class="col-md-6 col-xl-4">
            <div class="p-3 bg-light rounded-3 h-100 border-top border-primary border-3">
                <h6 class="fw-bold text-dark small"><i class="bi bi-lightbulb text-primary me-2"></i>School Innovation Committee</h6>
                <p class="small text-muted mb-0">Oversees innovative work plan initiatives, including Design and Innovation outputs.</p>
            </div>
        </div>
        <!-- Committee 4 -->
        <div class="col-md-6 col-xl-4 offset-xl-2">
            <div class="p-3 bg-light rounded-3 h-100 border-top border-primary border-3">
                <h6 class="fw-bold text-dark small"><i class="bi bi-calculator text-primary me-2"></i>School Data Analysis Committee</h6>
                <p class="small text-muted mb-0">Provides statistical tools, training, and consultation support.</p>
            </div>
        </div>
        <!-- Committee 5 -->
        <div class="col-md-6 col-xl-4">
            <div class="p-3 bg-light rounded-3 h-100 border-top border-primary border-3">
                <h6 class="fw-bold text-dark small"><i class="bi bi-vector-pen text-primary me-2"></i>Editorial Board</h6>
                <p class="small text-muted mb-0">Reviews manuscripts for quality, originality, and proper writing mechanics.</p>
            </div>
        </div>
    </div>
</div>

<!-- What We Do Section -->
<div class="card border-0 shadow-sm p-4 p-md-5 bg-dark text-white rounded-3 my-4 mx-0 mx-md-4 mx-lg-5">
    <div class="row g-4 align-items-center">
        <div class="col-lg-6">
            <h6 class="text-warning text-uppercase fw-bold mb-2" style="letter-spacing: 1px;">Core Mandate</h6>
            <h2 class="fw-bold mb-3 text-white">What We Do</h2>
            <div class="bg-warning mb-4" style="width: 50px; height: 3px;"></div>
            
            <p class="text-light opacity-75">
                Guided by DepEd's Research Management Cycle, the center manages the full lifecycle of a research or innovation project—from the call for proposals and ethical review, through technical assistance and progress monitoring, to final dissemination, utilization, and archival of completed studies.
            </p>
            <p class="text-light opacity-75 mb-0">
                This includes direct operational backing for learners pursuing the research subjects under the STE Program and Research 1, Research 2, and Design and Innovation electives under the Strengthened SHS Curriculum.
            </p>
        </div>
        <div class="col-lg-6">
            <div class="p-4 bg-secondary bg-opacity-25 rounded-3 border-start border-warning border-4">
                <h5 class="text-warning mb-3 fw-bold"><i class="bi bi-archive-fill me-2"></i>Knowledge Management Hub</h5>
                <ul class="list-unstyled mb-0 text-light opacity-90 small d-flex flex-column gap-2">
                    <li class="d-flex align-items-start"><i class="bi bi-check2-circle text-warning me-2 mt-1"></i> Serves as a centralized repository for completed research outputs and learning materials.</li>
                    <li class="d-flex align-items-start"><i class="bi bi-check2-circle text-warning me-2 mt-1"></i> Actively disseminates research findings through official publications, conferences, and open forums.</li>
                    <li class="d-flex align-items-start"><i class="bi bi-check2-circle text-warning me-2 mt-1"></i> Transforms local data insights into actionable items to inform school and division-level policies.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Activities Start -->
<div class="container py-5">
    <div class="row g-5">
        
        <!-- Left Side Column: Timeline Graph & Headings -->
        <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.1s">
            <div class="mb-4">
                <h6 class="text-primary text-uppercase" style="letter-spacing: 1px;">Milestones & Track Record</h6>
                <h1 class="display-6 fw-bold">Research Journey Timeline</h1>
                <p class="text-muted">Overview of completed and verified institutional research studies by fiscal year at CCNHS.</p>
            </div>
            
            <!-- Compact Left-Aligned Timeline Graph Components -->
            <div class="position-relative ps-4 py-2">
                <!-- Vertical Timeline Track Connector Line Line -->
                <div class="position-absolute start-0 h-100" style="width: 4px; background-color: #e9ecef; top: 0; left: 6px !important; z-index: 1;"></div>

                <!-- FY 2022 Block -->
                <div class="position-relative mb-4" style="z-index: 2;">
                    <!-- Timeline Node Pin -->
                    <div class="position-absolute bg-primary rounded-circle shadow-sm" style="width: 14px; height: 14px; left: -31px; top: 16px;"></div>
                    <div class="card border-0 shadow-sm p-3 bg-white rounded-3 border-start border-primary border-4">
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-primary px-3 py-2 fs-6">FY 2022</span>
                        </div>
                        <ul class="list-unstyled mb-0 text-secondary small d-flex flex-column gap-1">
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i><strong>15</strong> Completed Studies (Non-BERF)</li>
                            <li><i class="bi bi-file-earmark-text text-muted me-2"></i><strong>7</strong> Action Research</li>
                            <li><i class="bi bi-journal-bookmark text-muted me-2"></i><strong>8</strong> Basic Research</li>
                        </ul>
                    </div>
                </div>

                <!-- FY 2023 Block -->
                <div class="position-relative mb-4" style="z-index: 2;">
                    <!-- Timeline Node Pin -->
                    <div class="position-absolute bg-warning rounded-circle shadow-sm" style="width: 14px; height: 14px; left: -31px; top: 16px;"></div>
                    <div class="card border-0 shadow-sm p-3 bg-white rounded-3 border-start border-warning border-4">
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-warning text-dark px-3 py-2 fs-6">FY 2023</span>
                        </div>
                        <ul class="list-unstyled mb-0 text-secondary small d-flex flex-column gap-1">
                            <li><i class="bi bi-award-fill text-warning me-2"></i><strong>1</strong> Completed Basic Research Study (BERF 2023)</li>
                        </ul>
                    </div>
                </div>

                <!-- FY 2024 Block -->
                <div class="position-relative mb-4" style="z-index: 2;">
                    <!-- Timeline Node Pin -->
                    <div class="position-absolute bg-success rounded-circle shadow-sm" style="width: 14px; height: 14px; left: -31px; top: 16px;"></div>
                    <div class="card border-0 shadow-sm p-3 bg-white rounded-3 border-start border-success border-4">
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-success px-3 py-2 fs-6">FY 2024</span>
                        </div>
                        <ul class="list-unstyled mb-0 text-secondary small d-flex flex-column gap-1">
                            <li><i class="bi bi-award-fill text-success me-2"></i><strong>1</strong> BERF Study Completed</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i><strong>20</strong> Non-BERF Studies</li>
                            <li><i class="bi bi-file-earmark-text text-muted me-2"></i><strong>6</strong> Action / <strong>5</strong> Basic</li>
                        </ul>
                    </div>
                </div>

                <!-- FY 2025 Block -->
                <div class="position-relative mb-0" style="z-index: 2;">
                    <!-- Timeline Node Pin -->
                    <div class="position-absolute bg-info rounded-circle shadow-sm" style="width: 14px; height: 14px; left: -31px; top: 16px;"></div>
                    <div class="card border-0 shadow-sm p-3 bg-white rounded-3 border-start border-info border-4">
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-info text-dark px-3 py-2 fs-6">FY 2025</span>
                        </div>
                        <ul class="list-unstyled mb-0 text-secondary small d-flex flex-column gap-1">
                            <li><i class="bi bi-award-fill text-info me-2"></i><strong>2</strong> BERF Action Research</li>
                            <li><i class="bi bi-check-circle-fill text-success me-2"></i><strong>11</strong> Non-BERF Studies</li>
                            <li><i class="bi bi-file-earmark-text text-muted me-2"></i><strong>12</strong> Action / <strong>8</strong> Basic</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side Column: Activities Card Panel -->
        <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.3s">
            <div class="card border-0 shadow p-4 p-md-5 bg-dark text-white rounded-3 h-100">
                <div class="mb-4">
                    <h4 class="text-warning mb-2 fw-bold text-uppercase" style="font-size: 1.1rem; letter-spacing: 1px;">
                        Center for Active Research and Innovation
                    </h4>
                    <h2 class="text-white fw-bold mb-0" style="font-size: 1.8rem;">School-Initiated Activities</h2>
                    <div class="bg-warning my-3" style="width: 60px; height: 3px;"></div>
                </div>

                <div style="max-height: 480px; overflow-y: auto; padding-right: 10px;">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3 d-flex align-items-start"><i class="bi bi-gear-fill text-warning me-3 mt-1"></i> Research Capacity Building / Learning & Development</li>
                        <li class="mb-3 d-flex align-items-start"><i class="bi bi-people-fill text-warning me-3 mt-1"></i> Focus Group Discussions</li>
                        <li class="mb-3 d-flex align-items-start"><i class="bi bi-chat-left-quote-fill text-warning me-3 mt-1"></i> School Research and Innovation Meetings</li>
                        <li class="mb-3 d-flex align-items-start"><i class="bi bi-person-bounding-box text-warning me-3 mt-1"></i> Mentoring and Coaching</li>
                        <li class="mb-3 d-flex align-items-start"><i class="bi bi-layers-half text-warning me-3 mt-1"></i> Multimodal Technical Assistance Provision</li>
                        <li class="mb-3 d-flex align-items-start"><i class="bi bi-megaphone-fill text-warning me-3 mt-1"></i> Oral Presentations</li>
                        <li class="mb-3 d-flex align-items-start"><i class="bi bi-shield-check text-warning me-3 mt-1"></i> Proposal and Final Defense (SHS & STE Learners)</li>
                        <li class="mb-3 d-flex align-items-start"><i class="bi bi-eye-fill text-warning me-3 mt-1"></i> Monitoring and Evaluation / Progress Monitoring</li>
                        <li class="mb-3 d-flex align-items-start"><i class="bi bi-clipboard-check-fill text-warning me-3 mt-1"></i> Research Instruments Validation</li>
                        <li class="mb-3 d-flex align-items-start"><i class="bi bi-patch-check-fill text-warning me-3 mt-1"></i> Research Intervention Quality Assurance</li>
                        <li class="mb-3 d-flex align-items-start"><i class="bi bi-calculator-fill text-warning me-3 mt-1"></i> Data Analysis and Statistical Treatment Assistance</li>
                        <li class="mb-3 d-flex align-items-start"><i class="bi bi-journal-text text-warning me-3 mt-1"></i> KALASIAN: Journal of Faculty and Students Research</li>
                        <li class="mb-3 d-flex align-items-start"><i class="bi bi-globe2 text-warning me-3 mt-1"></i> Research and Development Congress</li>
                        <li class="mb-3 d-flex align-items-start"><i class="bi bi-file-earmark-slides-fill text-warning me-3 mt-1"></i> Paper Presentation</li>
                        <li class="mb-3 d-flex align-items-start"><i class="bi bi-mortarboard-fill text-warning me-3 mt-1"></i> Attendance and Participation to Research Trainings</li>
                        <li class="d-flex align-items-start"><i class="bi bi-search text-warning me-3 mt-1"></i> Search for Best Research Papers</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Activities End -->

<!-- Programs Offered Section -->
<div class="container-xxl py-5 bg-light rounded-3" id="programs">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-light text-center text-primary px-3 text-uppercase fw-bold">Academic Paths</h6>
            <h2 class="mb-5">Programs Offered</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4 wow fadeInUp" data-wow-delay="0.2s">
                <div class="p-4 bg-white rounded shadow-sm h-100 border-top border-4 border-primary">
                    <h4 class="fw-bold mb-3">Junior High School</h4>
                    <p class="text-muted small mb-2">Core secondary education levels:</p>
                    <ul class="list-unstyled">
                        <li class="mb-1"><i class="bi bi-chevron-right text-primary me-2 small"></i>Grade 7</li>
                        <li class="mb-1"><i class="bi bi-chevron-right text-primary me-2 small"></i>Grade 8</li>
                        <li class="mb-1"><i class="bi bi-chevron-right text-primary me-2 small"></i>Grade 9</li>
                        <li><i class="bi bi-chevron-right text-primary me-2 small"></i>Grade 10</li>
                    </ul>
                </div>
            </div>
            
            <div class="col-md-4 wow fadeInUp" data-wow-delay="0.4s">
                <div class="p-4 bg-white rounded shadow-sm h-100 border-top border-4 border-primary">
                    <h4 class="fw-bold mb-3">Senior High School</h4>
                    <p class="text-muted small mb-2">Levels & Specialized Tracks:</p>
                    <ul class="list-unstyled mb-3">
                        <li class="mb-1"><i class="bi bi-chevron-right text-primary me-2 small"></i>Grade 11</li>
                        <li><i class="bi bi-chevron-right text-primary me-2 small"></i>Grade 12</li>
                    </ul>
                    <hr class="text-muted my-2 opacity-25">
                    <p class="fw-bold text-secondary small mb-2">Tracks Available:</p>
                    <ul class="list-unstyled">
                        <li class="mb-1"><i class="bi bi-check2-circle text-primary me-2"></i>Academic</li>
                        <li><i class="bi bi-check2-circle text-primary me-2"></i>Technical Professional</li>
                    </ul>
                </div>
            </div>
            
            <div class="col-md-4 wow fadeInUp" data-wow-delay="0.6s">
                <div class="p-4 bg-white rounded shadow-sm h-100 border-top border-4 border-primary">
                    <h4 class="fw-bold mb-3">Special Programs</h4>
                    <p class="text-muted small mb-2">Enriched curricula for advanced development:</p>
                    <ul class="list-unstyled">
                        <li class="mb-3 d-flex align-items-start">
                            <i class="bi bi-star-fill text-warning me-2 mt-1" style="font-size: 0.85rem;"></i>
                            <div>
                                <strong>SPA</strong>
                                <span class="d-block text-muted small">Special Program in the Arts</span>
                            </div>
                        </li>
                        <li class="d-flex align-items-start">
                            <i class="bi bi-star-fill text-warning me-2 mt-1" style="font-size: 0.85rem;"></i>
                            <div>
                                <strong>STE</strong>
                                <span class="d-block text-muted small">Science, Technology, and Engineering</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End--> 

<!--Services--> 
<div class="container-xxl py-5">
    <div class="container">
        <!-- Section Header -->
        <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
            <h6 class="section-title bg-white text-center text-primary px-3 text-uppercase" style="letter-spacing: 1px;">Our Services</h6>
            <h1 class="mb-4">Services Offered</h1>
        </div>

        <!-- Schedule for Assistance Notice Banner -->
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8 text-center">
                <div class="p-4 rounded-pill shadow-sm d-inline-flex align-items-center gap-3 bg-white border-start border-end border-4 border-primary" style="border-radius: 50px !important;">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="fa fa-clock fa-lg"></i>
                    </div>
                    <div class="text-start pe-3">
                        <small class="text-uppercase fw-bold text-muted tracking-wider" style="font-size: 0.75rem; letter-spacing: 1px;">Available Hours</small>
                        <h5 class="text-dark mb-0 fw-bold" style="font-family: 'Nunito', sans-serif;">
                            Schedule for Assistance: <span class="text-primary">8:00 AM – 5:00 PM</span>
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Services Grid -->
        <div class="row g-4">
            
            <!-- 1. Research Capacity and Mentorship -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-item bg-light rounded h-100 p-5 shadow-sm border-top border-4 border-transparent hover-border-primary" style="transition: all 0.3s ease;">
                    <div class="d-flex align-items-center justify-content-center bg-white rounded-circle mb-4 shadow-sm" style="width: 64px; height: 64px;">
                        <i class="fa fa-users text-primary fa-2x"></i>
                    </div>
                    <h5 class="mb-3 fw-bold">1. Research Capacity & Mentorship</h5>
                    <ul class="list-unstyled text-muted mb-0 ps-0">
                        <li class="mb-2"><i class="fa fa-check text-primary me-2"></i>Guidance for learners, teachers, and other researchers.</li>
                        <li><i class="fa fa-check text-primary me-2"></i>Mentorship programs to strengthen research skills and confidence.</li>
                    </ul>
                </div>
            </div>

            <!-- 2. Research Instruments Validation -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                <div class="service-item bg-light rounded h-100 p-5 shadow-sm border-top border-4 border-transparent hover-border-primary" style="transition: all 0.3s ease;">
                    <div class="d-flex align-items-center justify-content-center bg-white rounded-circle mb-4 shadow-sm" style="width: 64px; height: 64px;">
                        <i class="fa fa-file-signature text-primary fa-2x"></i>
                    </div>
                    <h5 class="mb-3 fw-bold">2. Instruments Validation</h5>
                    <ul class="list-unstyled text-muted mb-0 ps-0">
                        <li class="mb-2"><i class="fa fa-check text-primary me-2"></i>Expert review and validation of questionnaires, tests, and tools.</li>
                        <li><i class="fa fa-check text-primary me-2"></i>Ensures reliability and accuracy of research instruments.</li>
                    </ul>
                </div>
            </div>

            <!-- 3. Research Intervention Quality Assurance -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="service-item bg-light rounded h-100 p-5 shadow-sm border-top border-4 border-transparent hover-border-primary" style="transition: all 0.3s ease;">
                    <div class="d-flex align-items-center justify-content-center bg-white rounded-circle mb-4 shadow-sm" style="width: 64px; height: 64px;">
                        <i class="fa fa-shield-alt text-primary fa-2x"></i>
                    </div>
                    <h5 class="mb-3 fw-bold">3. Intervention QA</h5>
                    <ul class="list-unstyled text-muted mb-0 ps-0">
                        <li class="mb-2"><i class="fa fa-check text-primary me-2"></i>Monitoring of interventions to ensure standards are met.</li>
                        <li><i class="fa fa-check text-primary me-2"></i>Provides feedback for continuous improvement.</li>
                    </ul>
                </div>
            </div>

            <!-- 4. Data Analysis and Statistical Treatment Assistance -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-item bg-light rounded h-100 p-5 shadow-sm border-top border-4 border-transparent hover-border-primary" style="transition: all 0.3s ease;">
                    <div class="d-flex align-items-center justify-content-center bg-white rounded-circle mb-4 shadow-sm" style="width: 64px; height: 64px;">
                        <i class="fa fa-chart-pie text-primary fa-2x"></i>
                    </div>
                    <h5 class="mb-3 fw-bold">4. Data Analysis & Statistics</h5>
                    <ul class="list-unstyled text-muted mb-0 ps-0">
                        <li class="mb-2"><i class="fa fa-check text-primary me-2"></i>Support in applying appropriate statistical methods.</li>
                        <li><i class="fa fa-check text-primary me-2"></i>Helps interpret results for meaningful conclusions.</li>
                    </ul>
                </div>
            </div>

            <!-- 5. Data and Repository Services -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                <div class="service-item bg-light rounded h-100 p-5 shadow-sm border-top border-4 border-transparent hover-border-primary" style="transition: all 0.3s ease;">
                    <div class="d-flex align-items-center justify-content-center bg-white rounded-circle mb-4 shadow-sm" style="width: 64px; height: 64px;">
                        <i class="fa fa-database text-primary fa-2x"></i>
                    </div>
                    <h5 class="mb-3 fw-bold">5. Data & Repository Services</h5>
                    <ul class="list-unstyled text-muted mb-0 ps-0">
                        <li class="mb-2"><i class="fa fa-check text-primary me-2"></i>Archiving of research outputs for accessibility.</li>
                        <li><i class="fa fa-check text-primary me-2"></i>Metadata tagging and search functions for easy retrieval.</li>
                    </ul>
                </div>
            </div>

            <!-- 6. Progress Monitoring and Evaluation -->
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="service-item bg-light rounded h-100 p-5 shadow-sm border-top border-4 border-transparent hover-border-primary" style="transition: all 0.3s ease;">
                    <div class="d-flex align-items-center justify-content-center bg-white rounded-circle mb-4 shadow-sm" style="width: 64px; height: 64px;">
                        <i class="fa fa-tasks text-primary fa-2x"></i>
                    </div>
                    <h5 class="mb-3 fw-bold">6. Monitoring & Evaluation</h5>
                    <ul class="list-unstyled text-muted mb-0 ps-0">
                        <li class="mb-2"><i class="fa fa-check text-primary me-2"></i>Tracking research projects from start to completion.</li>
                        <li><i class="fa fa-check text-primary me-2"></i>Evaluation reports to measure impact and effectiveness.</li>
                    </ul>
                </div>
            </div>

            <!-- 7. Journal Writing and Publication Assistance -->
            <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-item bg-light rounded h-100 p-5 shadow-sm border-top border-4 border-transparent hover-border-primary" style="transition: all 0.3s ease;">
                    <div class="d-flex align-items-center justify-content-center bg-white rounded-circle mb-4 shadow-sm" style="width: 64px; height: 64px;">
                        <i class="fa fa-journal-whills text-primary fa-2x"></i>
                    </div>
                    <h5 class="mb-3 fw-bold">7. Journal Writing & Publication</h5>
                    <ul class="list-unstyled text-muted mb-0 ps-0">
                        <li class="mb-2"><i class="fa fa-check text-primary me-2"></i>Coaching in academic writing and formatting.</li>
                        <li><i class="fa fa-check text-primary me-2"></i>Guidance in submitting to academic journals and conferences.</li>
                    </ul>
                </div>
            </div>

            <!-- 8. Collaboration and Partnerships -->
            <div class="col-lg-6 col-md-12 wow fadeInUp" data-wow-delay="0.2s">
                <div class="service-item bg-light rounded h-100 p-5 shadow-sm border-top border-4 border-transparent hover-border-primary" style="transition: all 0.3s ease;">
                    <div class="d-flex align-items-center justify-content-center bg-white rounded-circle mb-4 shadow-sm" style="width: 64px; height: 64px;">
                        <i class="fa fa-handshake text-primary fa-2x"></i>
                    </div>
                    <h5 class="mb-3 fw-bold">8. Collaboration & Partnerships</h5>
                    <ul class="list-unstyled text-muted mb-0 ps-0">
                        <li class="mb-2"><i class="fa fa-check text-primary me-2"></i>Building institutional linkages with universities, government agencies, NGOs, and industry.</li>
                        <li class="mb-2"><i class="fa fa-check text-primary me-2"></i>Hosting research congresses and colloquiums to connect researchers and stakeholders.</li>
                        <li><i class="fa fa-check text-primary me-2"></i>Extending research benefits to local communities through outreach and policy consultancy.</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
<!--End-->
        

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
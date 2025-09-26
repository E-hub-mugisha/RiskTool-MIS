<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ config('app.name')}}</title>
    <meta name="description" content="Disaster Relief Management System">
    <meta name="keywords" content="Disaster Relief, Emergency Response, Volunteers, Resources, MIS">

    <!-- Favicons -->
    <link href="front/assets/img/favicon.png" rel="icon">
    <link href="front/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Poppins:wght@400;500;600;700&family=Raleway:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="front/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="front/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="front/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="front/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="front/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="front/assets/css/main.css" rel="stylesheet">
</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

            <a href="index.html" class="logo d-flex align-items-center">
                <h1 class="sitename">{{ config('app.name')}}</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero" class="active">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#features">Features</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

        </div>
    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background">
            <div class="container">
                <div class="row gy-4">
                    <!-- <div class="col-lg-4 order-lg-last hero-img" data-aos="zoom-out">
                        <img src="assets/img/phone_1.png" alt="Phone 1" class="phone-1">
                        <img src="assets/img/phone_2.png" alt="Phone 2" class="phone-2">
                    </div> -->
                    <div class="col-lg-8 d-flex flex-column justify-content-center align-items text-center text-md-start" data-aos="fade-up">
                        <h2>{{ config('app.name')}}</h2>
                        <p>Efficiently manage disaster relief operations, track resources, coordinate volunteers, and respond faster during emergencies.</p>
                        <div class="d-flex mt-4 justify-content-center justify-content-md-start">
                            @if (Route::has('login'))
                            @auth
                            <a href="{{ url('/dashboard') }}" class="download-btn"><i class="bi bi-speedometer2"></i> <span>Go to Dashboard</span></a>
                            @else
                            <a href="{{ route('login') }}" class="download-btn"><i class="bi bi-box-arrow-in-right"></i> <span>Login</span></a>
                            @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="download-btn"><i class="bi bi-person-plus"></i> <span>Register</span></a>
                            @endif
                            @endauth
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /Hero Section -->

        <!-- About Section -->
        <section id="about" class="about section">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row align-items-xl-center gy-5">
                    <div class="col-xl-5 content">
                        <h3>About Disaster Relief MIS</h3>
                        <h2>Streamlining Emergency Response</h2>
                        <p>Our system enables organizations to efficiently manage disaster relief operations, track volunteers, monitor resource distribution, and ensure timely response to affected communities.</p>
                        <a href="#" class="read-more"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
                    </div>
                    <div class="col-xl-7">
                        <div class="row gy-4 icon-boxes">

                            <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                                <div class="icon-box">
                                    <i class="bi bi-people"></i>
                                    <h3>Volunteer Management</h3>
                                    <p>Track and manage volunteers, assign tasks, and monitor their contributions during relief operations.</p>
                                </div>
                            </div>

                            <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
                                <div class="icon-box">
                                    <i class="bi bi-truck"></i>
                                    <h3>Resource Tracking</h3>
                                    <p>Monitor the distribution of food, medical supplies, and other essential resources to disaster-affected areas.</p>
                                </div>
                            </div>

                            <div class="col-md-6" data-aos="fade-up" data-aos-delay="400">
                                <div class="icon-box">
                                    <i class="bi bi-geo-alt"></i>
                                    <h3>Incident Mapping</h3>
                                    <p>Visualize disaster-affected regions and ongoing relief operations on interactive maps for better decision-making.</p>
                                </div>
                            </div>

                            <div class="col-md-6" data-aos="fade-up" data-aos-delay="500">
                                <div class="icon-box">
                                    <i class="bi bi-bar-chart-line"></i>
                                    <h3>Analytics & Reports</h3>
                                    <p>Generate reports on response times, resource allocation, and volunteer activities to optimize future disaster response.</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /About Section -->

        <!-- Features Section -->
        <section id="featured" class="featured section">
            <div class="container section-title" data-aos="fade-up">
                <h2>Optimize Your Disaster Response</h2>
                <p>Our MIS simplifies coordination, resource management, and communication for effective disaster relief operations.</p>
            </div>

            <div class="container">
                <div class="row gy-4" data-aos="fade-up" data-aos-delay="100">

                    <div class="col-md-4">
                        <div class="card">
                            <div class="img">
                                <img src="assets/img/cards-4.png" alt="" class="img-fluid">
                                <div class="icon"><i class="bi bi-people"></i></div>
                            </div>
                            <h2 class="title">Volunteer Coordination</h2>
                            <p>Assign roles, track activities, and communicate with volunteers effectively during emergencies.</p>
                        </div>
                    </div>

                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="card">
                            <div class="img">
                                <img src="assets/img/cards-2.png" alt="" class="img-fluid">
                                <div class="icon"><i class="bi bi-box-seam"></i></div>
                            </div>
                            <h2 class="title">Resource Management</h2>
                            <p>Monitor stock of essential supplies, ensure timely delivery, and reduce wastage in disaster zones.</p>
                        </div>
                    </div>

                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                        <div class="card">
                            <div class="img">
                                <img src="assets/img/cards-6.png" alt="" class="img-fluid">
                                <div class="icon"><i class="bi bi-globe2"></i></div>
                            </div>
                            <h2 class="title">Incident Reporting</h2>
                            <p>Quickly report new incidents, monitor affected areas, and visualize data for strategic planning.</p>
                        </div>
                    </div>

                </div>
            </div>
        </section><!-- /Features Section -->

    </main>

    <footer id="footer" class="footer dark-background">
        <div class="container">
            <h3 class="sitename">{{ config('app.name')}}</h3>
            <p>Supporting disaster response teams with efficient coordination, resource tracking, and volunteer management.</p>
            <div class="social-links d-flex justify-content-center">
                <a href="#"><i class="bi bi-twitter"></i></a>
                <a href="#"><i class="bi bi-facebook"></i></a>
                <a href="#"><i class="bi bi-instagram"></i></a>
                <a href="#"><i class="bi bi-linkedin"></i></a>
            </div>
            <div class="container">
                <div class="copyright">
                    <span>Copyright</span> <strong class="px-1 sitename">{{ config('app.name')}}</strong> <span>All Rights Reserved</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    
    <!-- Vendor JS Files -->
    <script src="front/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="front/assets/vendor/php-email-form/validate.js"></script>
    <script src="front/assets/vendor/aos/aos.js"></script>
    <script src="front/assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="front/assets/vendor/glightbox/js/glightbox.min.js"></script>

    <!-- Main JS File -->
    <script src="front/assets/js/main.js"></script>

</body>

</html>

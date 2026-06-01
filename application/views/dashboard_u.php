<?php
// --- Personalization data ---
$first_name          = $this->session->userdata('first_name');
$last_name           = $this->session->userdata('last_name');
$alumni_id           = $this->session->userdata('alumni_id');
$hero_profile_image  = base_url('assets/images/person-male.png');

if ($alumni_id) {
    $CI =& get_instance();
    $CI->load->model('user/Alumni_model');
    $hero_user = $CI->Alumni_model->get_alumni_by_id($alumni_id);
    if ($hero_user && $hero_user->profile_image) {
        $hero_profile_image = base_url('assets/uploads/alumni/' . $hero_user->profile_image);
    }
}

$hour = (int) date('G');
if ($hour < 12)     $greeting_time = 'Good Morning';
elseif ($hour < 18) $greeting_time = 'Good Afternoon';
else                $greeting_time = 'Good Evening';
?>

<style>
    :root {
        --primary: #a12124;
        --primary-light: #7d181b;
        --accent: #d4a574;
        --bg-page: #f8fafc;
        --card-bg: rgba(255, 255, 255, 0.9);
        --text-main: #1e293b;
        --text-muted: #64748b;
        --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        --shadow-premium: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
        --radius-xl: 32px;
    }

    .dashboard-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 24px;
    }

    /* ======= PERSONALIZED HERO CONTAINER (Side-by-side) ======= */
    .hero-container {
        display: grid;
        grid-template-columns: 1fr;
        gap: 24px;
        margin-bottom: 40px;
    }

    /* ======= PERSONALIZED HERO ======= */
    .hero-personalized {
        position: relative;
        width: 100%;
        overflow: visible;
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-items: stretch;
        gap: 24px;
        background: transparent;
        box-shadow: none;
        border: none;
        margin-bottom: 40px;
    }

    .hero-personalized > * {
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.10);
        border: 1px solid rgba(0,0,0,0.06);
    }

    /* Subtle top accent bar */
    .hero-personalized::before {
        display: none;
    }

    .hero-personalized-inner {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 56px 32px 48px;
        gap: 0;
        width: 100%;
        justify-content: center;
        background: white;
    }

    /* Hero picture — right side column within personalized */
    .hero-personalized > .hero-picture {
        position: relative;
        width: 100%;
        border-radius: var(--radius-xl);
        overflow: hidden;
        margin-bottom: 0 !important;
        box-shadow: none !important;
        height: 100%;
        background: linear-gradient(135deg, #a12124 0%, #7d181b 100%);
        border: none !important;
    }

    .hero-personalized > .hero-picture::before {
        display: none;
    }

    /* Hero picture — standalone section below hero */
    .hero-picture {
        position: relative;
        width: 100%;
        border-radius: var(--radius-xl);
        overflow: hidden;
        margin-bottom: 40px;
        box-shadow: 0 20px 50px -10px rgba(0,0,0,0.20);
        height: 600px;
        background: linear-gradient(135deg, #a12124 0%, #7d181b 100%);
    }

    .hero-picture::before {
        display: none;
    }

    @keyframes kenBurns {
        0%   { transform: scale(1)    translate(0, 0); }
        40%  { transform: scale(1.06) translate(-1%, 0.5%); }
        70%  { transform: scale(1.04) translate(1%, -0.5%); }
        100% { transform: scale(1)    translate(0, 0); }
    }

    .hero-picture img {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
        top: 0;
        left: 0;
        z-index: 1;
        animation: kenBurns 14s ease-in-out infinite;
        transform-origin: center center;
    }

    /* Bottom-left glass text overlay */
    .hero-glass {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.72) 0%, rgba(0,0,0,0.15) 50%, transparent 100%);
        display: flex;
        align-items: flex-end;
        padding: 40px 48px;
        z-index: 2;
    }

    .hero-text-small {
        color: var(--accent);
        font-size: clamp(11px, 1.5vw, 14px);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 4px;
        display: block;
        margin-bottom: 8px;
        opacity: 0.9;
    }

    .hero-text-main {
        color: #ffffff;
        font-size: clamp(26px, 4.5vw, 42px);
        font-weight: 800;
        margin: 0;
        line-height: 1.15;
        letter-spacing: -0.5px;
    }

    /* Avatar ring */
    .hero-avatar-wrap {
        width: 88px;
        height: 88px;
        border-radius: 50%;
        border: 3px solid #a12124;
        box-shadow: 0 0 0 4px rgba(161,33,36,0.10);
        overflow: hidden;
        margin-bottom: 22px;
        flex-shrink: 0;
        background: #f8f8f8;
    }

    .hero-avatar-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* Welcome badge */
    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: rgba(161,33,36,0.07);
        border: 1px solid rgba(161,33,36,0.18);
        border-radius: 999px;
        padding: 6px 16px;
        font-size: 13px;
        font-weight: 600;
        color: #a12124;
        letter-spacing: 0.3px;
        margin-bottom: 22px;
    }

    .hero-badge i {
        font-size: 12px;
        color: #a12124;
    }

    /* Main heading */
    .hero-heading {
        font-size: clamp(28px, 5vw, 48px);
        font-weight: 800;
        color: #1e293b;
        margin: 0 0 14px;
        line-height: 1.12;
        letter-spacing: -0.5px;
    }

    .hero-heading .hero-name {
        color: #a12124;
    }

    /* Subtitle */
    .hero-subtitle {
        font-size: clamp(14px, 2vw, 17px);
        color: #64748b;
        margin: 0 0 34px;
        line-height: 1.65;
        max-width: 540px;
    }

    /* CTA Buttons */
    .hero-cta-group {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .hero-btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #a12124;
        color: #ffffff;
        font-size: 14px;
        font-weight: 700;
        padding: 11px 26px;
        border-radius: 8px;
        text-decoration: none !important;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(161,33,36,0.25);
        border: 2px solid transparent;
    }

    .hero-btn-primary:hover {
        background: #7d181b;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(161,33,36,0.30);
        color: #ffffff;
    }

    .hero-btn-secondary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: transparent;
        color: #a12124;
        font-size: 14px;
        font-weight: 600;
        padding: 11px 26px;
        border-radius: 8px;
        text-decoration: none !important;
        transition: all 0.3s ease;
        border: 2px solid rgba(161,33,36,0.30);
    }

    .hero-btn-secondary:hover {
        background: rgba(161,33,36,0.07);
        border-color: #a12124;
        color: #a12124;
        transform: translateY(-2px);
    }

    /* ======= Scroll Reveal ======= */
    .reveal {
        position: relative;
        transform: translateY(30px);
        opacity: 0;
        transition: all 0.8s ease-out;
    }

    .reveal.active {
        transform: translateY(0);
        opacity: 1;
    }

    /* ======= Quick Links ======= */
    .links-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .link-card {
        background: white;
        padding: 24px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        text-decoration: none !important;
        color: var(--text-main);
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        transition: var(--transition);
        border: 1px solid rgba(0,0,0,0.05);
    }

    .link-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-premium);
        border-color: var(--primary-light);
    }

    .link-card i {
        font-size: 24px;
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .link-card-logo {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        object-fit: cover;
        display: block;
    }

    .link-card .fb-btn  { background: #1877F2; }
    .link-card .web-btn { background: var(--primary); }

    .link-info h4 { margin: 0; font-size: 16px; font-weight: 700; }
    .link-info p  { margin: 0; font-size: 12px; color: var(--text-muted); }

    /* Picture card in Quick Links */
    .picture-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        text-decoration: none !important;
        color: var(--text-main);
        transition: var(--transition);
        border: 1px solid rgba(0,0,0,0.05);
        cursor: default;
    }

    .picture-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-premium);
        border-color: var(--primary-light);
    }

    .picture-card-img {
        width: 100%;
        height: 240px;
        overflow: hidden;
        background: linear-gradient(135deg, #a12124 0%, #7d181b 100%);
        position: relative;
    }

    .picture-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .picture-card-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.1) 60%, transparent 100%);
        display: flex;
        align-items: flex-end;
        padding: 24px;
        color: white;
    }

    .picture-card-text h4 {
        margin: 0;
        font-size: 18px;
        font-weight: 700;
        color: white;
    }

    .picture-card-text p {
        margin: 4px 0 0 0;
        font-size: 13px;
        color: var(--accent);
        font-weight: 600;
        letter-spacing: 1px;
    }

    /* ======= Content Card ======= */
    .content-card {
        background: white;
        border-radius: var(--radius-xl);
        padding: 64px 48px;
        margin-bottom: 40px;
        box-shadow: var(--shadow-premium);
    }

    .section-header {
        margin-bottom: 48px;
        max-width: 700px;
    }

    .section-header h2 {
        font-size: 32px;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 16px;
    }

    .section-header p {
        font-size: 18px;
        color: var(--text-muted);
    }

    /* ======= Features Grid ======= */
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
        gap: 32px;
    }

    .feature-card {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
        transition: var(--transition);
        display: flex;
        flex-direction: column;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-premium);
        border-color: rgba(112, 10, 10, 0.1);
    }

    .feature-img-box {
        width: 100%;
        height: 200px;
        overflow: hidden;
        background: #f0f2f5;
    }

    .feature-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.8s ease;
    }

    .feature-card:hover .feature-img-box img { transform: scale(1.1); }

    .feature-content { padding: 30px; flex-grow: 1; }

    .feature-content h3 {
        color: var(--primary);
        font-size: 16px;
        font-weight: 800;
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
        line-height: 1.3;
    }

    .feature-content p {
        margin: 0;
        font-size: 15px;
        color: #475569;
        line-height: 1.7;
    }

    .features-grid > *:nth-child(1) { transition-delay: 0.1s; }
    .features-grid > *:nth-child(2) { transition-delay: 0.2s; }
    .features-grid > *:nth-child(3) { transition-delay: 0.3s; }
    .features-grid > *:nth-child(4) { transition-delay: 0.4s; }
    .features-grid > *:nth-child(5) { transition-delay: 0.5s; }
    .features-grid > *:nth-child(6) { transition-delay: 0.6s; }

    .heritage-text {
        font-size: 20px;
        line-height: 1.8;
        color: var(--text-main);
        margin-bottom: 48px;
        position: relative;
        padding-left: 32px;
        border-left: 4px solid var(--accent);
    }

    .heritage-text strong { color: var(--primary); }

    .page-footer {
        text-align: center;
        padding: 40px 0;
        color: var(--text-muted);
        font-size: 14px;
    }

    /* ======= Responsive ======= */
    @media (max-width: 992px) {
        .dashboard-container { padding: 0 20px; }
        .content-card { padding: 48px 32px; }
        .hero-personalized { grid-template-columns: 1fr 1fr; gap: 20px; }
    }

    @media (max-width: 768px) {
        :root { --radius-xl: 24px; }
        .dashboard-container { margin: 20px auto; }
        .content-card { padding: 32px 20px; border-radius: 20px; }
        .hero-container { grid-template-columns: 1fr; gap: 16px; }
        .hero-personalized { grid-template-columns: 1fr; gap: 16px; }
        .hero-personalized { border-radius: 20px; }
        .hero-personalized-inner { padding: 40px 20px 36px; }
        .hero-picture { border-radius: 20px; }
        .picture-card-img { height: 200px; }
        .hero-glass { padding: 28px 24px; }
        .features-grid { grid-template-columns: 1fr; gap: 24px; }
        .feature-img-box { height: 180px; }
        .links-grid { grid-template-columns: 1fr; }
        .section-header h2 { font-size: 26px; }
        .hero-avatar-wrap { width: 72px; height: 72px; }
    }

    @media (max-width: 480px) {
        .hero-personalized-inner { padding: 28px 16px 24px; }
        .hero-glass { padding: 20px 18px; }
        .hero-cta-group { gap: 10px; }
        .hero-btn-primary,
        .hero-btn-secondary { padding: 10px 20px; font-size: 13px; }
        .feature-content { padding: 24px 20px; }
        .feature-content h3 { font-size: 14px; }
        .feature-content p  { font-size: 14px; }
    }
</style>

<div class="dashboard-container">

    <!-- ====== PERSONALIZED HERO (Side-by-side) ====== -->
    <div class="hero-container">
        <!-- HERO CARD 1 -->
        <section class="hero-personalized reveal active">
            <div class="hero-personalized-inner">
                <!-- User avatar -->
                <div class="hero-avatar-wrap">
                    <img src="<?php echo $hero_profile_image; ?>" alt="<?php echo htmlspecialchars($first_name); ?>'s avatar"
                         onerror="this.src='<?php echo base_url('assets/images/person-male.png'); ?>'">
                </div>

                <!-- Welcome badge -->
                <div class="hero-badge">
                    <i class="fas fa-star"></i>
                    Welcome to AConnect
                </div>

                <!-- Personalized heading -->
                <h1 class="hero-heading">
                    <?php echo $greeting_time; ?>,<br>
                    <span class="hero-name"><?php echo htmlspecialchars($first_name . ' ' . $last_name); ?>!</span>
                </h1>

                <!-- Subtitle -->
                <p class="hero-subtitle">
                    Connect with fellow alumni, explore job opportunities, and stay in the loop<br class="d-none d-md-block">
                    with the latest events from St. Dominic College of Asia.
                </p>

                <!-- CTA Buttons -->
                <div class="hero-cta-group">
                    <a href="<?php echo base_url('postcontroller'); ?>" class="hero-btn-primary">
                        <i class="fas fa-home"></i> Go to Feed
                    </a>
                    <a href="<?php echo base_url('profile'); ?>" class="hero-btn-secondary">
                        <i class="fas fa-user"></i> View My Profile
                    </a>
                </div>
            </div>

            <!-- HERO PICTURE (Right side, same size as inner) -->
            <div class="hero-picture reveal">
                <img src="<?php echo base_url('assets/images/andaman-family.png'); ?>"
                     alt="SDCA Heritage"
                     onerror="this.style.display='none';">
                <div class="hero-glass">
                    <div>
                        <span class="hero-text-small">Preserving the Legacy</span>
                        <h2 class="hero-text-main">Revolutionizing Education</h2>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- ====== HERITAGE PHOTO ====== -->
    <!-- <div class="hero-picture reveal">
        <img src="<?php echo base_url('assets/images/andaman-family.png'); ?>"
             alt="SDCA Heritage"
             onerror="this.style.display='none';">
        <div class="hero-glass">
            <div>
                <span class="hero-text-small">Preserving the Legacy</span>
                <h2 class="hero-text-main">Revolutionizing Education</h2>
            </div>
        </div>
    </div> -->

    <!-- Quick Links -->
    <div class="links-grid reveal">
        <a href="https://stdominiccollege.edu.ph/" target="_blank" class="link-card">
            <i class="fas fa-globe web-btn"></i>
            <div class="link-info">
                <h4>SDCA Website</h4>
                <p>Official Institutional Site</p>
            </div>
        </a>
        <a href="https://www.facebook.com/StDominicCollege" target="_blank" class="link-card">
            <i class="fab fa-facebook-f fb-btn"></i>
            <div class="link-info">
                <h4>Official Facebook</h4>
                <p>Stay updated on social</p>
            </div>
        </a>
        <a href="#" class="link-card">
            <img src="<?php echo base_url('assets/images/schoollogo.jpg'); ?>" alt="SDCA Logo" class="link-card-logo">
            <div class="link-info">
                <h4>SDCA Heritage</h4>
                <p>Preserving the Legacy</p>
            </div>
        </a>
    </div>

    <!-- Heritage Narrative -->
    <section class="content-card reveal">
        <div class="heritage-text">
            <strong>St. Dominic College of Asia (SDCA)</strong> traces its roots to the establishment of St. Dominic Medical Center in 1991. What began as a healthcare vision evolved into a comprehensive educational institution that has been transforming lives for over two decades in Bacoor, Cavite.
        </div>

        <div class="section-header">
            <h2>Experience SDCA</h2>
            <p>Discover what makes St. Dominic College of Asia a leader in holistic and innovative education.</p>
        </div>

        <div class="features-grid">
            <div class="feature-card reveal">
                <div class="feature-img-box">
                    <img src="assets/dashboard/Screenshot 2026-02-18 090553.png" alt="Student Life">
                </div>
                <div class="feature-content">
                    <h3>FUN AND COLORFUL STUDENT LIFE</h3>
                    <p>Experience a vibrant student life at St. Dominic College of Asia, where fun institutional events, exciting program activities, and student-centric celebrations create unforgettable memories. Be part of a lively community that fosters friendships, creativity, and personal growth.</p>
                </div>
            </div>

            <div class="feature-card reveal">
                <div class="feature-img-box">
                    <img src="assets/dashboard/Screenshot 2026-02-18 090630.png" alt="Graduates">
                </div>
                <div class="feature-content">
                    <h3>GLOBALLY-COMPETITIVE GRADUATES</h3>
                    <p>Join the ranks of St. Dominic College of Asia's globally-competitive graduates recognized as board exam topnotchers, 100% passers, and highly employable professionals. With success stories spanning industries worldwide, our alumni are equipped to lead and thrive anywhere.</p>
                </div>
            </div>

            <div class="feature-card reveal">
                <div class="feature-img-box">
                    <img src="assets/dashboard/Screenshot 2026-02-18 091047.png" alt="Quality Programs">
                </div>
                <div class="feature-content">
                    <h3>QUALITY PROGRAM OFFERINGS</h3>
                    <p>Achieve academic excellence at St. Dominic College of Asia, home to PACUCOA-accredited programs and an Autonomous Status recognized institution. With ISO certification, WURI Award, Green Gown Award, and ICONS Award, our programs are designed to meet global standards of quality and innovation.</p>
                </div>
            </div>

            <div class="feature-card reveal">
                <div class="feature-img-box">
                    <img src="assets/dashboard/Screenshot 2026-02-18 090618.png" alt="Safe & Secure">
                </div>
                <div class="feature-content">
                    <h3>ACCESSIBLE, SAFE, AND SECURE</h3>
                    <p>Experience learning made easy at St. Dominic College of Asia's digital campus, complete with campus-wide Wi-Fi access. Located along the highway with convenient transportation options and enhanced by tight security measures, SDCA offers a safe and connected space for academic success.</p>
                </div>
            </div>

            <div class="feature-card reveal">
                <div class="feature-img-box">
                    <img src="assets/dashboard/Screenshot 2026-02-18 090607.png" alt="International Partners">
                </div>
                <div class="feature-content">
                    <h3>INTERNATIONAL PARTNERS AND LINKAGES</h3>
                    <p>Gain a global edge with St. Dominic College of Asia's international programs and immersion opportunities. Through partnerships with local corporations and global institutions, we provide students with industry-relevant experiences and cross-cultural learning opportunities.</p>
                </div>
            </div>

            <div class="feature-card reveal">
                <div class="feature-img-box">
                    <img src="assets/dashboard/Screenshot 2026-02-18 090445.png" alt="Faculty">
                </div>
                <div class="feature-content">
                    <h3>INDUSTRY-SEASONED FACULTY MEMBERS AND ADMINISTRATORS</h3>
                    <p>Learn from competitive faculty members and administrators at St. Dominic College of Asia. Our experienced educators bring real-world expertise and insights to prepare students for success in their chosen fields.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="page-footer" style="color: white;">
        <strong>Est. 2003</strong> Bacoor, Cavite<br>
        AConnect&copy; 2026 St. Dominic College of Asia
    </footer>
</div>

<script>
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    } else {
        function reveal() {
            var reveals = document.querySelectorAll(".reveal");
            for (var i = 0; i < reveals.length; i++) {
                var windowHeight = window.innerHeight;
                var elementTop = reveals[i].getBoundingClientRect().top;
                if (elementTop < windowHeight - 150) {
                    reveals[i].classList.add("active");
                }
            }
        }
        window.addEventListener("scroll", reveal);
        reveal();
    }
</script>



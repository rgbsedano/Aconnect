<style>
    :root {
        --primary: #700a0a;
        --primary-light: #8b1538;
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

    /* Scroll Reveal Animation Styles */
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

    /* Hero Image Section */
    .hero-section {
        position: relative;
        border-radius: var(--radius-xl);
        overflow: hidden;
        margin-bottom: 40px;
        box-shadow: var(--shadow-premium);
        background: #000; /* Darker background for transition */
        display: flex;
    }

    .hero-image {
        width: 100%;
        height: auto;
        display: block;
        transition: transform 1.2s ease;
    }

    .hero-section:hover .hero-image {
        transform: scale(1.05);
    }

    .hero-glass {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 60%);
        display: flex;
        align-items: flex-end;
        padding: 48px;
    }

    .hero-text h1 {
        color: white;
        font-size: clamp(32px, 5vw, 48px);
        font-weight: 800;
        margin: 0;
        letter-spacing: -1px;
        line-height: 1.1;
    }

    .hero-text h1 span {
        color: var(--accent);
        display: block;
        font-size: 0.4em;
        text-transform: uppercase;
        letter-spacing: 4px;
        margin-bottom: 8px;
    }

    /* Quick Links Section */
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

    .link-card .fb-btn { background: #1877F2; }
    .link-card .web-btn { background: var(--primary); }

    .link-info h4 { margin: 0; font-size: 16px; font-weight: 700; }
    .link-info p { margin: 0; font-size: 12px; color: var(--text-muted); }

    /* Content Section */
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

    /* Programs Grid / Features Grid */
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

    .feature-card:hover .feature-img-box img {
        transform: scale(1.1);
    }

    .feature-content {
        padding: 30px;
        flex-grow: 1;
    }

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

    /* Staggered Animation Delay for grid items */
    .features-grid > *:nth-child(1) { transition-delay: 0.1s; }
    .features-grid > *:nth-child(2) { transition-delay: 0.2s; }
    .features-grid > *:nth-child(3) { transition-delay: 0.3s; }
    .features-grid > *:nth-child(4) { transition-delay: 0.4s; }
    .features-grid > *:nth-child(5) { transition-delay: 0.5s; }
    .features-grid > *:nth-child(6) { transition-delay: 0.6s; }

    /* Heritage Text */
    .heritage-text {
        font-size: 20px;
        line-height: 1.8;
        color: var(--text-main);
        margin-bottom: 48px;
        position: relative;
        padding-left: 32px;
        border-left: 4px solid var(--accent);
    }

    .heritage-text strong {
        color: var(--primary);
    }

    .page-footer {
        text-align: center;
        padding: 40px 0;
        color: var(--text-muted);
        font-size: 14px;
    }

    @media (max-width: 992px) {
        .dashboard-container { padding: 0 20px; }
        .content-card { padding: 48px 32px; }
    }

    @media (max-width: 768px) {
        :root { --radius-xl: 24px; }
        .dashboard-container { margin: 20px auto; }
        .content-card { padding: 32px 20px; border-radius: 20px; }
        .hero-section { border-radius: 20px; }
        .hero-glass { padding: 32px 24px; }
        .hero-text h1 { font-size: 32px; }
        .features-grid { grid-template-columns: 1fr; gap: 24px; }
        .feature-img-box { height: 180px; }
        .links-grid { grid-template-columns: 1fr; }
        .section-header h2 { font-size: 26px; }
    }

    @media (max-width: 480px) {
        .hero-glass { padding: 24px 16px; }
        .hero-text h1 { font-size: 24px; }
        .feature-content { padding: 24px 20px; }
        .feature-content h3 { font-size: 14px; }
        .feature-content p { font-size: 14px; }
    }
</style>

<div class="dashboard-container">
    <!-- Hero Banner (Reveals immediately) -->
    <section class="hero-section reveal active">
        <img src="assets/images/andaman-family.png" 
             alt="SDCA Heritage" 
             class="hero-image"
             onerror="this.src='https://placehold.co/1200x600/700a0a/FFFFFF?text=SDCA+HERITAGE';">
        <div class="hero-glass">
            <div class="hero-text">
                <h1><span>Preserving the Legacy</span>Revolutionizing Education</h1>
            </div>
        </div>
    </section>

    <!-- Quick Links (New Section) -->
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
                    <p>Join the ranks of St. Dominic College of Asia’s globally-competitive graduates—recognized as board exam topnotchers, 100% passers, and highly employable professionals. With success stories spanning industries worldwide, our alumni are equipped to lead and thrive anywhere.</p>
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
                    <p>Experience learning made easy at St. Dominic College of Asia’s digital campus, complete with campus-wide Wi-Fi access. Located along the highway with convenient transportation options and enhanced by tight security measures, SDCA offers a safe and connected space for academic success.</p>
                </div>
            </div>

            <div class="feature-card reveal">
                <div class="feature-img-box">
                    <img src="assets/dashboard/Screenshot 2026-02-18 090607.png" alt="International Partners">
                </div>
                <div class="feature-content">
                    <h3>INTERNATIONAL PARTNERS AND LINKAGES</h3>
                    <p>Gain a global edge with St. Dominic College of Asia’s international programs and immersion opportunities. Through partnerships with local corporations and global institutions, we provide students with industry-relevant experiences and cross-cultural learning opportunities.</p>
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

    <footer class="page-footer">
        <strong>Est. 2003</strong> • Bacoor, Cavite<br>
        © 2026 St. Dominic College of Asia
    </footer>
</div>

<script>
    // Scroll Reveal Script
    function reveal() {
        var reveals = document.querySelectorAll(".reveal");
        for (var i = 0; i < reveals.length; i++) {
            var windowHeight = window.innerHeight;
            var elementTop = reveals[i].getBoundingClientRect().top;
            var elementVisible = 150;
            if (elementTop < windowHeight - elementVisible) {
                reveals[i].classList.add("active");
            }
        }
    }

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
        window.addEventListener("scroll", reveal);
        // Initial check
        reveal();
    }
</script>

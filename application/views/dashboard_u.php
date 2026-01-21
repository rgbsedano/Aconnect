<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - St. Dominic College of Asia</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <style>
        :root {
            --primary: #8B1538;
            --primary-dark: #6B0F2A;
            --accent: #D4A574;
            --bg-page: #FAFAF8;
            --white: #FFFFFF;
            --text-main: #1F2937;
            --text-muted: #6B7280;
            --border: #E5E7EB;
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.07);
            --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
            --radius-md: 8px;
            --radius-lg: 12px;
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background-color: var(--bg-page);
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            color: var(--text-main);
            line-height: 1.6;
        }

        .header-spacing {
            height: 70px;
        }

        .container {
            max-width: 1200px;
            width: 100%;
            margin: -40px auto 40px 430px;
            display: grid;
            grid-template-columns: 1fr;
            gap: 32px;
            padding: 0 20px;
        }

        @media (min-width: 1024px) {
            .container {
                grid-template-columns: 1fr 360px;
                margin: -40px auto 40px 430px;
            }
        }

        .story-section {
            background: var(--white);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-md);
            overflow: hidden;
            transition: box-shadow 0.3s ease;
        }

        .story-section:hover {
            box-shadow: var(--shadow-lg);
        }

        .hero-banner {
            position: relative;
            width: 100%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            overflow: hidden;
        }

        .hero-banner img {
            width: 100%;
            height: 400px;
            display: block;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .hero-banner:hover img {
            transform: scale(1.02);
        }

        .hero-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 32px;
            background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.4) 50%, transparent);
            color: white;
        }

        .hero-overlay h1 {
            font-size: clamp(24px, 5vw, 36px);
            font-weight: 800;
            margin: 0;
            line-height: 1.3;
            letter-spacing: -0.5px;
        }

        .story-content {
            padding: 48px;
        }

        .story-content p {
            margin-bottom: 24px;
            font-size: 1.02rem;
            color: var(--text-main);
            line-height: 1.8;
        }

        .story-content p strong {
            color: var(--primary);
            font-weight: 700;
        }

        .drop-cap::first-letter {
            float: left;
            font-size: 3.2rem;
            font-weight: 900;
            line-height: 0.8;
            padding-right: 16px;
            color: var(--primary);
            margin-top: 4px;
        }

        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .sidebar-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border);
            padding: 28px;
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
        }

        .sidebar-card:hover {
            box-shadow: var(--shadow-lg);
            border-color: var(--accent);
        }

        .quote-widget {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            text-align: center;
            padding: 32px 28px;
        }

        .quote-widget blockquote {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 700;
            font-style: italic;
            line-height: 1.6;
            letter-spacing: -0.3px;
        }

        .mv-widget h3 {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: var(--primary);
            margin-bottom: 12px;
            margin-top: 0;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
        }

        .mv-widget h3 i {
            color: var(--accent);
            font-size: 1.1rem;
        }

        .mv-widget p {
            font-size: 0.9rem;
            color: var(--text-muted);
            margin: 0;
            line-height: 1.6;
        }

        .divider {
            height: 1px;
            background: var(--border);
            margin: 20px 0;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            width: 100%;
            border: none;
            cursor: pointer;
            box-shadow: var(--shadow-md);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-primary i {
            font-size: 1rem;
        }

        .footer-info {
            text-align: center;
            padding: 16px 12px;
            color: var(--text-muted);
            font-size: 0.8rem;
            line-height: 1.6;
            border-top: 1px solid var(--border);
            margin-top: 8px;
        }

        @media (max-width: 1023px) {
            .container {
                margin: 30px auto;
            }

            .story-content {
                padding: 32px;
            }
        }

        @media (max-width: 640px) {
            .header-spacing {
                height: 60px;
            }

            .container {
                gap: 20px;
                margin: 20px auto;
            }

            .story-content {
                padding: 24px;
            }

            .sidebar-card {
                padding: 20px;
            }

            .hero-overlay {
                padding: 24px;
            }

            .hero-overlay h1 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>

<div class="header-spacing"></div>

<div class="container">
    <main class="story-section">
        <div class="hero-banner">
            <img src="assets/images/andaman-family.png" 
                 alt="The Andaman Family" 
                 onerror="this.src='https://placehold.co/1200x400/8B1538/FFFFFF?text=SDCA+Heritage';">
            <div class="hero-overlay">
                <h1>Our Heritage & Mission</h1>
            </div>
        </div>

        <div class="story-content">
            <p class="drop-cap">
                St. Dominic College of Asia represents more than three decades of educational excellence and unwavering commitment to community development. Our institution stands as a beacon of transformative learning in Southeast Asia, rooted in values of integrity, compassion, and innovation.
            </p>

            <p>
                Founded in 2003 by the visionary Andaman family, SDCA emerged from a legacy that began with the establishment of St. Dominic Medical Center in 1992. What started as a dream to provide quality healthcare evolved into a comprehensive educational institution dedicated to nurturing leaders of tomorrow.
            </p>

            <p>
                Today, our four specialized schools—<strong>Health Science Professions, Arts & Education, International Hospitality Management, and Business & Computer Studies</strong>—serve thousands of students annually. We maintain the highest standards of academic rigor while fostering an inclusive environment where every student can thrive.
            </p>

            <p>
                Under the visionary leadership of <strong>Dr. Gregorio A. Andaman, Jr.</strong>, our institutional motto "<span style="color: var(--primary); font-weight: 700;">Revolutionizing Education</span>" has become more than words—it defines our approach to student-centered learning, cutting-edge research, and meaningful community engagement.
            </p>

            <p>
                We believe that education should transcend classroom walls. Our graduates are prepared not just for careers, but for meaningful contributions to society. Through partnerships with industry leaders, community initiatives, and international collaborations, we ensure our students develop the knowledge, skills, and character needed for global success.
            </p>
        </div>
    </main>

    <aside class="sidebar">
        <div class="sidebar-card quote-widget">
            <blockquote translate="no">
                "Your Vision of the future, is our Mission today."
            </blockquote>
        </div>

        <div class="sidebar-card mv-widget">
            <h3><i class="fas fa-bullseye"></i> Our Mission</h3>
            <p>To revolutionize education by linking training and research with community service, pursuing the holistic development of individuals through innovative programs.</p>
            
            <div class="divider"></div>
            
            <h3><i class="fas fa-eye"></i> Our Vision</h3>
            <p>A dynamic and proactive university in Asia dedicated to excellence in providing learner-centered education and sustainable community service.</p>
        </div>

        <div class="sidebar-card">
            <h4 style="margin: 0 0 12px 0; font-size: 1.05rem; font-weight: 700; color: var(--text-main);">Connect With Us</h4>
            <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 16px; line-height: 1.6;">Join our community and stay informed about campus achievements and opportunities.</p>
            <a href="https://www.facebook.com/stdominiccollege" target="_blank" class="btn-primary">
                <i class="fab fa-facebook-f"></i> Follow SDCA
            </a>
        </div>

        <div class="footer-info">
            <strong style="color: var(--text-main);">Est. 2003</strong> • Bacoor, Cavite<br>
            © 2026 St. Dominic College of Asia
        </div>
    </aside>
</div>

</body>
</html>
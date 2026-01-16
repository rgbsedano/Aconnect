<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>St. Dominic College of Asia - Our Story</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <style>
        :root {
            --primary: #92000A;
            --primary-dark: #6a0007;
            --accent: #fca311;
            --bg-page: #f3f2ef; /* Matches LinkedIn background gray */
            --white: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.1);
            --shadow-md: 0 4px 12px -2px rgba(0,0,0,0.08);
            --radius-lg: 16px;
            --radius-md: 12px;
        }

        * { box-sizing: border-box; }

        body {
            background-color: var(--bg-page);
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            color: var(--text-main);
            line-height: 1.5;
        }

        /* --- Main Layout: Fixed alignment for dashboard --- */
        .container {
            max-width: 1128px; /* Standard feed width to align with top search/nav */
            width: 100%;
            margin: 20px auto; /* Removed the 300px margin that caused the alignment issue */
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
            padding: 0 16px;
        }

        @media (min-width: 992px) {
            .container {
                grid-template-columns: 1fr 340px; /* Aligns with standard dashboard column ratios */
            }
        }

        /* --- Left Column: Story --- */
        .story-section {
            background: var(--white);
            border-radius: 8px; /* LinkedIn standard radius */
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .hero-banner {
            position: relative;
            width: 100%;
            background: #000;
        }

        .hero-banner img {
            width: 100%;
            height: auto;
            max-height: 500px;
            display: block;
            object-fit: cover;
        }

        .hero-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 24px;
            background: linear-gradient(transparent, rgba(0,0,0,0.85));
            color: white;
        }

        .hero-overlay h1 {
            font-size: clamp(20px, 3vw, 28px);
            font-weight: 800;
            margin: 0;
            line-height: 1.2;
        }

        .story-content {
            padding: 32px;
        }

        .story-content p {
            margin-bottom: 20px;
            font-size: 1rem;
            color: #334155;
        }

        .drop-cap::first-letter {
            float: left;
            font-size: 3.5rem;
            font-weight: 900;
            line-height: 0.8;
            padding-right: 12px;
            color: var(--primary);
        }

        /* --- Right Column: Sidebar --- */
        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .sidebar-card {
            background: var(--white);
            border-radius: 8px;
            border: 1px solid var(--border);
            padding: 20px;
            box-shadow: var(--shadow-sm);
        }

        /* Quote Widget */
        .quote-widget {
            background: var(--primary);
            color: white;
            border: none;
            text-align: center;
        }

        .quote-widget blockquote {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 700;
            font-style: italic;
            line-height: 1.4;
        }

        /* Mission/Vision Styles */
        .mv-widget h3 {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--primary);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .mv-widget p {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin: 0;
        }

        .divider {
            height: 1px;
            background: #eee;
            margin: 15px 0;
        }

        /* Follow Button */
        .btn-primary {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: var(--primary);
            color: white;
            padding: 10px;
            border-radius: 20px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: 0.2s;
            width: 100%;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .footer-info {
            text-align: center;
            padding: 10px;
            color: var(--text-muted);
            font-size: 0.75rem;
        }
    </style>
</head>
<body>

<div class="container">
    <main class="story-section">
        <div class="hero-banner">
            <img src="assets/images/andaman-family.png" 
                 alt="The Andaman Family" 
                 onerror="this.src='https://placehold.co/1200x800/92000A/FFFFFF?text=The+Andaman+Family';">
            <div class="hero-overlay">
                <h1>Our Journey: The Story of St. Dominic College of Asia</h1>
            </div>
        </div>

        <div class="story-content">
            <p class="drop-cap">
                The story of St. Dominic College of Asia (SDCA) is a testament to what a dedicated family can achieve through perseverance and a shared vision. The institution traces its roots back to 1992 with the establishment of the <strong>St. Dominic Medical Center (SDMC)</strong> by founders Don Gregorio and Dona Dominga Andaman.
            </p>
            <p>
                In 2003, exactly twelve years after the realization of their dream hospital, the family founded St. Dominic College of Arts & Sciences. This was envisioned as a gift to the community—a manifestation of their commitment to providing excellent yet affordable education in Bacoor and neighboring regions.
            </p>
            <p>
                What began with core programs in Caregiving and Nursing has flourished into a premier collegiate institution. Today, SDCA houses four specialized schools: Health Science Professions, Arts & Education, International Hospitality Management, and Business & Computer Studies.
            </p>
            <p>
                In 2011, the presidency was passed to <strong>Dr. Gregorio A. Andaman, Jr.</strong>, who ignited the institutional battlecry: <span style="color: var(--primary); font-weight: 700;">"Revolutionizing Education."</span> This era marked a rapid expansion in basic education and significant national accreditations, solidifying SDCA's place as a leader in academic innovation.
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
            <h4 style="margin: 0 0 10px 0; font-size: 0.95rem;">Join the Community</h4>
            <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 15px;">Stay connected with the latest campus news and milestones.</p>
            <a href="https://www.facebook.com/stdominiccollege" target="_blank" class="btn-primary">
                <i class="fab fa-facebook-f"></i> Follow SDCA
            </a>
        </div>

        <div class="footer-info">
            Established 2003 • Bacoor, Cavite<br>
            © 2026 St. Dominic College of Asia
        </div>
    </aside>
</div>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - St. Dominic College of Asia</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
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

        * { box-sizing: border-box; }

        body {
            background-color: var(--bg-page);
            background-image: radial-gradient(at 0% 0%, rgba(112, 10, 10, 0.03) 0px, transparent 50%),
                              radial-gradient(at 100% 100%, rgba(212, 165, 116, 0.03) 0px, transparent 50%);
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            padding: 0;
            color: var(--text-main);
            line-height: 1.7;
            overflow-x: hidden;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 24px;
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Hero Image Section */
        .hero-section {
            position: relative;
            height: 480px;
            border-radius: var(--radius-xl);
            overflow: hidden;
            margin-bottom: 40px;
            box-shadow: var(--shadow-premium);
            background: #700a0a; /* Fallback/Letterbox background */
        }

        .hero-image {
            width: 100%;
            height: 100%;
            object-fit: contain; /* Ensure fully visible */
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

        /* Stats Section */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            padding: 32px;
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            text-align: center;
            transition: var(--transition);
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-premium);
            background: white;
        }

        .stat-card i {
            font-size: 24px;
            color: var(--accent);
            margin-bottom: 16px;
        }

        .stat-card h2 {
            font-size: 36px;
            font-weight: 800;
            margin: 0;
            color: var(--primary);
        }

        .stat-card p {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 4px 0 0 0;
        }

        /* Content Section */
        .content-card {
            background: white;
            border-radius: var(--radius-xl);
            padding: 56px;
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

        /* Programs Grid */
        .programs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 32px;
        }

        .program-item {
            display: flex;
            gap: 24px;
            padding: 24px;
            border-radius: 20px;
            transition: var(--transition);
            border: 1px solid transparent;
        }

        .program-item:hover {
            background: #fffcfc;
            border-color: rgba(112, 10, 10, 0.1);
            transform: translateX(10px);
        }

        .program-icon {
            width: 56px;
            height: 56px;
            background: rgba(112, 10, 10, 0.05);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 20px;
            flex-shrink: 0;
        }

        .program-item h4 {
            margin: 0 0 8px 0;
            font-size: 18px;
            font-weight: 700;
        }

        .program-item p {
            margin: 0;
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.6;
        }

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

        /* Footer info */
        .page-footer {
            text-align: center;
            padding: 40px 0;
            color: white; /* Changed to white */
            font-size: 14px;
        }

        @media (max-width: 768px) {
            .dashboard-container { margin: 20px auto; }
            .content-card { padding: 32px; }
            .hero-section { height: 350px; }
            .hero-glass { padding: 24px; }
            .program-item:hover { transform: none; }
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <!-- Hero Banner -->
    <section class="hero-section">
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

    <!-- Heritage Narrative -->
    <section class="content-card">
        <div class="heritage-text">
            <strong>St. Dominic College of Asia (SDCA)</strong> traces its roots to the establishment of St. Dominic Medical Center in 1991. What began as a healthcare vision evolved into a comprehensive educational institution that has been transforming lives for over two decades in Bacoor, Cavite.
        </div>

        <div class="stats-row">
            <div class="stat-card">
                <i class="fas fa-history"></i>
                <h2>30+</h2>
                <p>Years of Service</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-university"></i>
                <h2>5</h2>
                <p>Specialized Schools</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-award"></i>
                <h2>100%</h2>
                <p>Quality Focused</p>
            </div>
        </div>

        <div class="section-header">
            <h2>Academic Excellence</h2>
            <p>Our commitment to holistic development through innovative programs and specialized learning hubs.</p>
        </div>

        <div class="programs-grid">
            <div class="program-item">
                <div class="program-icon"><i class="fas fa-user-md"></i></div>
                <div>
                    <h4>Health & Nursing</h4>
                    <p>Advanced clinical training in Nursing, Physical Therapy, and Radiologic Technology.</p>
                </div>
            </div>
            <div class="program-item">
                <div class="program-icon"><i class="fas fa-microscope"></i></div>
                <div>
                    <h4>Medical Sciences</h4>
                    <p>Cutting-edge laboratory studies in Pharmacy, Biology, and Medical Technology.</p>
                </div>
            </div>
            <div class="program-item">
                <div class="program-icon"><i class="fas fa-chart-line"></i></div>
                <div>
                    <h4>Business & IT</h4>
                    <p>Nurturing the next generation of digital leaders and business strategists.</p>
                </div>
            </div>
            <div class="program-item">
                <div class="program-icon"><i class="fas fa-globe-asia"></i></div>
                <div>
                    <h4>Hospitality & Tourism</h4>
                    <p>International standards in Culinary Arts and Tourism management.</p>
                </div>
            </div>
            <div class="program-item">
                <div class="program-icon"><i class="fas fa-book-reader"></i></div>
                <div>
                    <h4>Education & Sciences</h4>
                    <p>Foundation building through Psychology, Accountancy, and Teacher education.</p>
                </div>
            </div>
            <div class="program-item">
                <div class="program-icon"><i class="fas fa-user-graduate"></i></div>
                <div>
                    <h4>Medicine & Graduate</h4>
                    <p>Professional excellence in MBA, MA Psychology, and Medicine.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="page-footer">
        <strong>Est. 2003</strong> • Bacoor, Cavite<br>
        © 2026 St. Dominic College of Asia
    </footer>
</div>

</body>
</html>

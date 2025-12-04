<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>St. Dominic College of Asia - Our Story</title>
    <!-- Using Inter, a modern, highly legible font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <!-- Font Awesome for modern icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <style>
        /* 🎨 MODERN SOCIAL FEED STYLES - Wider Layout (1400px) */
        :root {
            --primary-color: #92000A; /* SDCA Maroon/Deep Red */
            --accent-color: #fca311; /* A gold/yellow accent */
            --background-light: #f0f2f5; 
            --card-background: #ffffff;
            --text-dark: #1c1e21; 
            --text-muted: #606770; 
            --border-color-light: #e6e6e6; 
            --spacing-md: 16px;
            --spacing-lg: 24px;
            --border-radius-sm: 8px;
            --border-radius-lg: 16px; 
        }

        body {
            background-color: var(--background-light);
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        /* Target the main content area wrapper - INCREASED Width to 1400px */
        .social-page-container {
            padding: var(--spacing-lg);
            background-color: var(--background-light);
            max-width: 1400px; /* Increased maximum width */
            width: 95%; /* Fluid width */
            margin: 0 auto; 
        }
        
        /* --- Two-Column Layout --- */
        .main-layout {
            display: grid;
            gap: var(--spacing-lg);
            grid-template-columns: 1fr; /* Default single column for mobile/tablet */
        }
        
        /* Desktop layout: Story content (Left) vs. Sidebar (Right) */
        @media (min-width: 900px) {
            .main-layout {
                grid-template-columns: 2.2fr 1fr; /* Approx 68% / 32% split */
            }
            .main-story-card {
                padding-right: var(--spacing-lg);
            }
        }
        
        /* --- Existing Styles Adjusted --- */

        /* Unified Card Style */
        .feed-card {
            background-color: var(--card-background);
            padding: var(--spacing-lg);
            margin-bottom: var(--spacing-lg); 
            border-radius: var(--border-radius-lg);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.06); 
            border: 1px solid var(--border-color-light); 
            transition: box-shadow 0.3s ease, transform 0.1s ease;
        }

        .feed-card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
        }

        /* Typography */
        .post-header {
            color: var(--primary-color);
            font-size: 2.2rem; 
            font-weight: 900; 
            margin-top: 0;
            margin-bottom: var(--spacing-md);
            /* Default to left align for Mission/Vision/Social headers */
            text-align: left; 
            border-bottom: 2px solid var(--primary-color); 
            padding-bottom: 15px;
            line-height: 1.1;
        }
        
        /* Specific override for the MAIN title to center it */
        .main-title-header {
            text-align: center;
        }

        .post-body {
            color: var(--text-dark);
            font-size: 1rem;
            line-height: 1.75; 
            margin-bottom: var(--spacing-md);
        }
        
        /* Sub-Headers (Mission/Vision) */
        .feature-card .post-header {
            font-size: 1.3rem; 
            color: var(--accent-color); 
            margin-bottom: 8px;
            border-bottom: none;
            padding-bottom: 0;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .feature-card .post-header i {
            margin-right: 8px;
            color: var(--primary-color);
        }

        /* Image Styling */
        .post-image {
            width: 100%;
            max-width: 100%; 
            height: auto;
            border-radius: var(--border-radius-sm);
            object-fit: cover;
            margin: 0 auto var(--spacing-lg) auto; 
            display: block;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Pull Quote/Highlight Style (Now in Sidebar) */
        .quote-style {
            background-color: #fef8e8; 
            padding: var(--spacing-md); 
            border-left: 6px solid var(--accent-color); 
            border-radius: var(--border-radius-sm);
            margin: 0 0 var(--spacing-lg) 0; 
            text-align: center;
            font-size: 1.15rem; 
            color: var(--primary-color); 
            font-style: italic;
            font-weight: 600;
        }
        
        .quote-style strong {
            display: block;
            font-weight: 800;
            margin-top: 5px;
        }


        /* Mission/Vision Grid */
        .featured-grid {
            display: grid;
            grid-template-columns: 1fr; 
            gap: var(--spacing-lg); 
            margin-bottom: var(--spacing-lg);
        }

        .feature-card {
            padding: var(--spacing-md); 
        }

        /* Social Call-to-Action Card (Now in Sidebar) */
        .social-cta-card {
            text-align: center;
            background-color: #fff2f2; 
            padding: var(--spacing-lg);
            border: 1px solid var(--primary-color);
            margin-top: 0; 
        }
        
        .social-cta-card .post-header {
            font-size: 1.4rem; 
            color: var(--text-dark);
            border-bottom: none;
            padding-bottom: 0;
        }

        /* Button Style */
        .social-button {
            padding: 12px 25px; 
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: var(--border-radius-sm);
            cursor: pointer;
            font-size: 1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: background-color 0.2s ease-in-out, transform 0.1s, box-shadow 0.2s;
            text-decoration: none; 
            display: inline-block;
            box-shadow: 0 3px 5px rgba(146, 0, 10, 0.3);
            margin-top: 15px;
        }

        .social-button:hover {
            background-color: #6a0007; 
            transform: translateY(-2px);
            box-shadow: 0 6px 10px rgba(146, 0, 10, 0.4);
        }
    </style>
</head>
<body>

<div class="social-page-container">

    <div class="main-layout">
        
        <!-- === LEFT COLUMN: MAIN STORY CONTENT === -->
        <div class="main-story-content">
            <div class="feed-card main-story-card">
                <!-- Applied main-title-header class to center the title -->
                <h1 class="post-header main-title-header">Our Journey: The Story of St. Dominic College of Asia</h1>
                
                <!-- Retained original path with robust placeholder fallback -->
                <img src="assets/images/andaman-family.png" 
                     alt="SDCA Founders, The Andaman Family" 
                     class="post-image"
                     onerror="this.onerror=null; this.src='https://placehold.co/800x450/92000A/FFFFFF?text=Andaman+Family';">
                
                <p class="post-body">
                    The story of St. Dominic College of Asia (SDCA) is a shining example of what a dedicated family is capable of achieving through perseverance, hard work, and cooperation. The College traces its roots with the establishment of the St. Dominic Medical Center (SDMC) in 1992 by founders Don Gregorio and Dona Dominga Andaman. Named in honor of Dominga, the SDMC has proven itself capable of meeting the medical demands of the community with its modern facilities and excellent services.
                </p>
                <p class="post-body">
                    In 2003, 12 years after the realization of the dream hospital in Cavite, St. Dominic College of Arts & Sciences was founded. The College is the family’s gift to the community and the manifestation of their commitment to provide excellent but affordable education in Bacoor and neighboring communities.
                </p>
                <p class="post-body">
                    Initially offering programs in Caregiving and BS Nursing in collaboration with the SDMC, St. Dominic has evolved into a full-fledged collegiate institution with four schools: School of Health Science Professions (SHSP), School of Arts, Sciences, Criminology & Education (SASCE), School of International Hospitality & Tourism Management (SIHTM), and School of Business & Computer Studies (SBCS).
                </p>
                <p class="post-body">
                    In 2007, the College embarked on an ambitious long-term goal which aims to achieve university status within the next 20 years. In 2009, St. Dominic College of Arts & Sciences was officially renamed St. Dominic College of Asia, reflecting a move towards global standards and expansion.
                </p>
                <p class="post-body">
                    In 2011, Dr. Marita A. Andaman-Rillo passed on the presidency to Dr. Gregorio A. Andaman, Jr., who launched the institution’s battlecry “Revolutionizing Education”. This included the launch of the Basic Education Unit and accreditation of several key programs by the Philippine Association of Colleges and Universities Commission on Accreditation (PACUCOA) in 2012.
                </p>
            </div>
        </div>
        
        <!-- === RIGHT COLUMN: QUOTE, MISSION, VISION, SOCIALS === -->
        <div class="sidebar-content">
            
            <!-- 1. QUOTE -->
            <div class="quote-style">
                <i class="fas fa-quote-left" style="margin-right: 10px;"></i>
                "Your Vision of the future, is our Mission today."
                <i class="fas fa-quote-right" style="margin-left: 10px;"></i>
            </div>
            
            <!-- 2. MISSION/VISION TILES (FEATURED GRID) -->
            <div class="featured-grid">
                <div class="feature-card feed-card" style="margin-bottom: 0;">
                    <h2 class="post-header"><i class="fas fa-bullseye"></i> Mission</h2>
                    <p class="post-body" style="font-size: 0.9rem;">
                        To revolutionize education by purposively linking the quality of education, training, and research with community service in pursuing the holistic development of individuals through innovative programs and productive activities attuned to local and global demands.
                    </p>
                </div>

                <div class="feature-card feed-card" style="margin-bottom: 0;">
                    <h2 class="post-header"><i class="fas fa-eye"></i> Vision</h2>
                    <p class="post-body" style="font-size: 0.9rem;">
                        A dynamic and proactive university in Asia dedicated to excellence in providing learner-centered education, research, and sustainable community service towards development.
                    </p>
                </div>
            </div>

            <!-- 3. SOCIAL CTA -->
            <div class="social-cta-card feed-card" style="margin-bottom: 0; margin-top: 24px;">
                <h2 class="post-header">Join the SDCA Community!</h2>
                <p class="post-body">
                    Stay up-to-date with the latest news, events, and announcements from St. Dominic College of Asia.
                </p>
                <a href="https://www.facebook.com/stdominiccollege" target="_blank" class="social-button">
                    <i class="fab fa-facebook-f" style="margin-right: 8px;"></i>
                    Follow Us
                </a>
            </div>
            
        </div>
        
    </div> <!-- End main-layout -->
</div>
</body>
</html>
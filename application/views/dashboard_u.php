<style>
    /* 🎨 MODERN SOCIAL FEED STYLES - Wider Layout (1000px) */
    :root {
        --primary-color: #92000A; /* SDCA Maroon/Deep Red */
        --accent-color: #fca311; /* A gold/yellow accent */
        --background-light: #f0f2f5; 
        --card-background: #ffffff;
        --text-dark: #1c1e21; 
        --text-muted: #606770; 
        --border-color: #dddfe2;
        --spacing-md: 16px;
        --spacing-lg: 24px;
        --border-radius-sm: 8px;
        --border-radius-lg: 12px;
    }

    /* Target the main content area wrapper - Increased Width */
    .social-page-container {
        padding: var(--spacing-lg);
        font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: var(--background-light);
        max-width: 1000px; /* **WIDE FIX: Set max-width to 1000px** */
        margin: 0 auto; 
    }

    /* Unified Card Style - Better separation */
    .feed-card {
        background-color: var(--card-background);
        padding: var(--spacing-lg);
        margin-bottom: var(--spacing-lg);
        border-radius: var(--border-radius-lg);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12); /* Slightly stronger shadow */
        transition: box-shadow 0.3s ease;
    }

    .feed-card:hover {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    /* Typography */
    .post-header {
        color: var(--primary-color);
        font-size: 2rem; 
        font-weight: 800; 
        margin-bottom: var(--spacing-md);
        text-align: left; 
        border-bottom: 2px solid var(--border-color); /* Thicker separator */
        padding-bottom: 10px;
    }

    .post-body {
        color: var(--text-dark);
        font-size: 1rem;
        line-height: 1.7; /* Increased line-height for better readability */
        margin-bottom: var(--spacing-md);
    }

    /* Image Styling - Centered and full-width */
    .post-image {
        width: 100%;
        max-width: 100%; 
        height: auto;
        border-radius: var(--border-radius-sm);
        object-fit: cover;
        margin: 0 auto var(--spacing-md) auto; /* Center image */
        display: block;
    }

    /* Pull Quote/Highlight Style */
    .quote-style {
        background-color: #fff2f2; 
        padding: var(--spacing-md);
        border-left: 5px solid var(--primary-color);
        border-radius: var(--border-radius-sm);
        margin: var(--spacing-lg) 0;
        text-align: center;
        font-size: 1.2rem; /* Larger quote text */
        color: var(--text-dark);
        font-style: italic;
        font-weight: 500;
    }

    /* Mission/Vision Grid */
    .featured-grid {
        display: grid;
        grid-template-columns: 1fr; 
        gap: var(--spacing-lg); /* Larger gap */
        margin-bottom: var(--spacing-lg);
    }

    .feature-card {
        padding: var(--spacing-lg);
        background-color: var(--card-background); /* Keep same background for cohesion */
        border-radius: var(--border-radius-lg);
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08); /* Lighter shadow than main card */
    }

    .feature-card .post-header {
        font-size: 1.4rem;
        color: var(--accent-color); /* Highlight mission/vision titles with accent */
        margin-bottom: 10px;
        border-bottom: none;
        padding-bottom: 0;
        text-align: center;
        text-transform: uppercase;
    }

    /* Social Call-to-Action Card */
    .social-cta-card {
        text-align: center;
        background-color: #e7f3ff; /* Light blue background for emphasis */
        padding: var(--spacing-lg);
        border: 2px solid var(--primary-color);
    }

    /* Button Style - Primary button look */
    .social-button {
        padding: 12px 25px; /* Bigger button */
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 1.1rem;
        font-weight: 700;
        transition: background-color 0.2s ease-in-out, transform 0.1s;
        text-decoration: none; 
        display: inline-block;
    }

    .social-button:hover {
        background-color: #7a0008; 
        transform: translateY(-2px);
    }

    /* Desktop/Tablet Adjustments for Grid */
    @media (min-width: 700px) {
        .featured-grid {
            grid-template-columns: 1fr 1fr; 
        }
    }
</style>

<div class="social-page-container">

    <div class="feed-card">
        <h1 class="post-header">Our Journey: The Story of St. Dominic College of Asia</h1>
        
        <img src="<?= base_url('assets/images/andaman-family.png') ?>" alt="SDCA Founders, The Andaman Family" class="post-image">
        
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

    <div class="quote-style">
        <strong>"Your Vision of the future, is our Mission today."</strong>
    </div>

    <div class="featured-grid">
        <div class="feature-card feed-card">
            <h2 class="post-header">Mission</h2>
            <p class="post-body">
                To revolutionize education by purposively linking the quality of education, training, and research with community service in pursuing the holistic development of individuals through innovative programs and productive activities attuned to local and global demands.
            </p>
        </div>

        <div class="feature-card feed-card">
            <h2 class="post-header">Vision</h2>
            <p class="post-body">
                A dynamic and proactive university in Asia dedicated to excellence in providing learner-centered education, research, and sustainable community service towards development.
            </p>
        </div>
    </div>

    <div class="social-cta-card feed-card">
        <h2 class="post-header">Join the SDCA Community!</h2>
        <p class="post-body">
            Stay up-to-date with the latest news, events, and announcements from St. Dominic College of Asia. Follow our official page and engage with students, faculty, and alumni!
        </p>
        <a href="https://www.facebook.com/stdominiccollege" target="_blank" class="social-button">
            Follow Us on Facebook
        </a>
    </div>
</div>
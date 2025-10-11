<style>
    .container-fluid {
        padding: 30px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8f9fa;
    }

    .about-us-card {
        background-color: #fff;
        padding: 30px;
        margin-bottom: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border: 1px solid #eee;
    }

    .section-title {
        color: #333;
        font-size: 2.5rem;
        font-weight: 600;
        margin-bottom: 25px;
        text-align: center;
    }

    .section-text {
        color: #555;
        font-size: 1.1rem;
        line-height: 1.8;
        margin-bottom: 20px;
    }

    .story-image {
        width: 100%;
        max-width: 400px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
        float: left;
        margin-right: 25px;
    }

    .quote-container {
        background-color: #e9ecef;
        padding: 25px;
        border-radius: 8px;
        margin-bottom: 30px;
        text-align: center;
        font-size: 1.2rem;
        color: #495057;
        font-style: italic;
    }

    .mission-vision-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-bottom: 30px;
    }

    .mission-card, .vision-card {
        background-color: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border: 1px solid #eee;
    }

    .mission-card .section-title, .vision-card .section-title {
        font-size: 2rem;
        text-align: left;
        margin-bottom: 20px;
    }

    .facebook-card {
        background-color: #f0f2f5;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border: 1px solid #eee;
        text-align: center;
    }

    .facebook-card .section-title {
        font-size: 2rem;
        margin-bottom: 20px;
    }

    .facebook-card .section-text {
        margin-bottom: 20px;
    }

    .facebook-card a button {
        padding: 12px 25px;
        background-color: #1877f2;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 1rem;
        transition: background-color 0.2s ease-in-out;
    }

    .facebook-card a button:hover {
        background-color: #1462c4;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .story-image {
            float: none;
            margin-right: 0;
            margin-bottom: 20px;
            max-width: 100%;
        }

        .section-title {
            font-size: 2rem;
        }

        .mission-vision-grid {
            grid-template-columns: 1fr;
        }

        .mission-card .section-title, .vision-card .section-title {
            text-align: center;
        }
    }
</style>

<div class="container-fluid">

    <div class="about-us-card">
        <h1 class="section-title"><b>Our Journey</b></h1>
        <p class="section-text">
            <img src="<?= base_url('assets/images/andaman-family.png') ?>" alt="Graduation" class="story-image">
            The story of St. Dominic College of Asia (SDCA) is a shining example of what a dedicated family is capable of achieving through perseverance, hard work, and cooperation. The College traces its roots with the establishment of the St. Dominic Medical Center (SDMC) in 1992 by founders Don Gregorio and Dona Dominga Andaman. Named in honor of Dominga, the SDMC has proven itself capable of meeting the medical demands of the community with its modern facilities and excellent services.<br><br>

            In 2003, 12 years after the realization of the dream hospital in Cavite, St. Dominic College of Arts & Sciences was founded. The College is the family’s gift to the community and the manifestation of their commitment to provide excellent but affordable education in Bacoor and neighboring communities.<br><br>

            Initially offering programs in Caregiving and BS Nursing in collaboration with the SDMC, St. Dominic has evolved into a full-fledged collegiate institution with four schools: School of Health Science Professions (SHSP), School of Arts, Sciences, Criminology & Education (SASCE), School of International Hospitality & Tourism Management (SIHTM), and School of Business & Computer Studies (SBCS).<br><br>

            In 2007, the College embarked on an ambitious long-term goal which aims to achieve university status within the next 20 years. The plan for “The March Towards Excellence” was presented to the academic community and became the blueprint for development. Preparations towards accreditation of the academic programs were pursued in earnest. Rebranding strategies were also explored to make the College more relevant, responsive, and congruent with the current trends and practices of a highly globalized educational system. In 2009, St. Dominic College of Arts & Sciences was officially renamed St. Dominic College of Asia. The change of name was made to allow the College to grow and provide more room for expansion in its programs and services in the years to come. This change redounds to the benefit of the students as it will eventually give them a positional advantage in the crowded workplace in the competitive world for its name reflects the global standards that the College stands for.<br><br>

            In 2011, Dr. Marita A. Andaman-Rillo, eldest daughter of the founders, passed on the presidency of SDCA to the equally dynamic and capable youngest Andaman son, Dr. Gregorio A. Andaman, Jr. Constantly pushing for continuous change and improvement, Dr. Andaman, in his first year of presidency, launched the institution’s battlecry “Revolutionizing Education”, a campaign reflective of the Caviteno’s aggressiveness and fighting spirit. Highlights of this academic transformation include the launch of the Basic Education Unit (Preschool, Elementary, and High School), and accreditation of Business Administration, Information Technology, Education, Psychology, Hospitality Management, and Nursing programs by the Philippine Association of Colleges and Universities Commission on Accreditation (PACUCOA), both in 2012.
        </p>
    </div>

    <div class="quote-container">
        <strong>"Your Vision of the future, is our Mission today."</strong>
    </div>

    <div class="mission-vision-grid">
        <div class="mission-card about-us-card">
            <h2 class="section-title"><b>Our Mission</b></h2>
            <p class="section-text">
                To revolutionize education by purposively linking the quality of education,
                training, and research with community service in pursuing the holistic
                development of individuals through innovative programs and productive
                activities attuned to local and global demands.
            </p>
        </div>

        <div class="vision-card about-us-card">
            <h2 class="section-title"><b>Our Vision</b></h2>
            <p class="section-text">
                A dynamic and proactive university in Asia dedicated to excellence in
                providing learner-centered education, research, and sustainable community
                service towards development.
            </p>
        </div>
    </div>

    <div class="facebook-card about-us-card">
        <h2 class="section-title"><strong>Connect with Us on Facebook</strong></h2>
        <p class="section-text">
            Stay up-to-date with the latest news, events, and announcements from St. Dominic College of Asia by following our official Facebook page. Join our online community to engage with students, faculty, and alumni.
        </p>
        <a href="https://www.facebook.com/sdcaofficial" target="_blank">
            <button>
                Visit Our Facebook Page
            </button>
        </a>
    </div>
    </div>
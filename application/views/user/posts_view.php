<?php
// Account details from session
$display_full_name = $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name');
$student_number = $this->session->userdata('student_number') ? $this->session->userdata('student_number') : 'N/A';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AConnect | Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    
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
        }

        html, body {
            height: 100vh;
            width: 100vw;
            margin: 0;
            padding: 0;
            overflow: hidden !important; 
            background-color: var(--bg-page);
            display: flex;
            flex-direction: column;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        .dashboard-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }

        .dashboard-container {
            width: 100%;
            max-width: 1300px;
            height: 85vh;
            display: grid;
            grid-template-columns: 1.3fr 1fr;
            gap: 32px;
        }

        .carousel-section {
            height: 100%;
            min-height: 0;
        }

        #carouselExample {
            height: 100%;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            background: var(--white);
            border: 1px solid var(--border);
        }

        .carousel-inner, .carousel-item {
            height: 100%;
        }

        .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            background-color: var(--white);
        }

        .carousel-control-prev, .carousel-control-next {
            width: 50px;
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }

        .carousel-control-prev:hover, .carousel-control-next:hover {
            opacity: 1;
        }

        .carousel-control-prev-icon, .carousel-control-next-icon {
            filter: drop-shadow(0 0 2px rgba(0,0,0,0.3));
        }

        .posts-section {
            display: flex;
            flex-direction: column;
            gap: 18px;
            height: 100%;
            min-height: 0;
        }

        .post-card {
            flex: 1;
            background: var(--white);
            border-radius: 12px;
            padding: 24px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: var(--shadow-md);
            border-left: 6px solid var(--primary);
            min-height: 0;
            transition: all 0.3s ease;
        }

        .post-card:hover {
            box-shadow: var(--shadow-lg);
        }

        .post-category {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            font-weight: 800;
            color: var(--white);
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 6px 12px;
            border-radius: 6px;
            width: fit-content;
            display: inline-block;
        }

        .post-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--text-main);
            line-height: 1.4;
            margin-top: 12px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            letter-spacing: -0.3px;
        }

        .post-date {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 600;
        }

        .btn-details {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            background: none;
            border: none;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .btn-details:hover {
            color: var(--primary);
        }

        .btn-next {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 10px 24px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-md);
        }

        .btn-next:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .post-content-container { 
            transition: opacity 0.3s ease; 
        }
        .animate-out { 
            opacity: 0; 
        }
        .animate-in { 
            opacity: 1; 
        }
    </style>
</head>
<body>

<div class="dashboard-wrapper">
    <div class="dashboard-container">
        
        <div class="carousel-section">
            <?php $photos = $this->db->get('carousel_photos')->result_array(); ?>
            <?php if (!empty($photos)): ?>
                <div id="carouselExample" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php foreach ($photos as $index => $photo): ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <img src="<?= base_url('assets/uploads/carousel/' . $photo['file_name']) ?>" alt="SDCA Flyer">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" style="filter: invert(1);"></span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" style="filter: invert(1);"></span>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <div class="posts-section">
            <?php foreach ($grouped_posts as $type => $posts): ?>
                <?php
                $post_list = [];
                foreach ($posts as $p) {
                    $post_list[] = [
                        'id' => $p->id,
                        'title' => $p->title,
                        'date' => date('M d, Y', strtotime($p->created_at))
                    ];
                }
                $json_data = htmlspecialchars(json_encode($post_list), ENT_QUOTES, 'UTF-8');
                ?>

                <section class="post-card" data-posts="<?= $json_data ?>" data-idx="0">
                    <div>
                        <div class="flex justify-between items-center">
                            <span class="post-category"><?= $type ?></span>
                            <span class="post-date text-gray-400 text-[9px] font-bold"><?= !empty($posts) ? date('M d, Y', strtotime($posts[0]->created_at)) : '' ?></span>
                        </div>

                        <div class="post-content-container animate-in">
                            <h4 class="post-title"><?= !empty($posts) ? $posts[0]->title : 'No Recent Updates' ?></h4>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mt-2">
                        <?php if (!empty($posts)): ?>
                            <button class="btn-details" data-toggle="modal" data-target="#postModal<?= $posts[0]->id ?>">
                                DETAILS <i class="fas fa-external-link-alt ml-1"></i>
                            </button>
                            
                            <?php if (count($posts) > 1): ?>
                                <button class="btn-next next-post-btn">
                                    NEXT <i class="fas fa-chevron-right ml-1"></i>
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </section>
            <?php endforeach; ?>
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    $('.next-post-btn').on('click', function() {
        const $card = $(this).closest('.post-card');
        const $content = $card.find('.post-content-container');
        const $title = $card.find('.post-title');
        const $date = $card.find('.post-date');
        
        const posts = $card.data('posts');
        let idx = ($card.data('idx') + 1) % posts.length;
        const next = posts[idx];

        $content.addClass('animate-out');

        setTimeout(() => {
            $title.text(next.title);
            $date.text(next.date);
            $card.data('idx', idx);
            $content.removeClass('animate-out').addClass('animate-in');
        }, 300);
    });
});
</script>

</body>
</html>
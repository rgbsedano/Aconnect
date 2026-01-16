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
        /* Force screen to fit viewport exactly with no scroll */
        html, body {
            height: 100vh;
            width: 100vw;
            margin: 0;
            padding: 0;
            overflow: hidden !important; 
            background-color: #f3f2ef;
            display: flex;
            flex-direction: column;
        }

        /* Center the entire dashboard content area */
        .dashboard-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Centered Grid with "Medium" professional width */
        .dashboard-container {
            width: 100%;
            max-width: 1100px; /* Professional medium width */
            height: 85vh; /* Prevents vertical overflow */
            display: grid;
            grid-template-columns: 1.2fr 1fr; /* Balanced proportions */
            gap: 25px;
        }

        /* Left Section: Carousel */
        .carousel-section {
            height: 100%;
            min-height: 0;
        }

        #carouselExample {
            height: 100%;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            background: #fff;
        }

        .carousel-inner, .carousel-item {
            height: 100%;
        }

        .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: contain; /* Shows full flyer without cropping */
            background-color: #ffffff;
        }

        /* Right Section: Cards */
        .posts-section {
            display: flex;
            flex-direction: column;
            gap: 15px;
            height: 100%;
            min-height: 0;
        }

        .post-card {
            flex: 1;
            background: white;
            border-radius: 12px;
            padding: 18px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border-left: 5px solid #700A0A;
            min-height: 0; /* Ensures flex shrinkage works */
        }

        /* Medium Typography Scale */
        .post-category {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 800;
            color: #700A0A;
            background: #fdf2f2;
            padding: 2px 8px;
            border-radius: 4px;
            width: fit-content;
        }

        .post-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #2d3748;
            line-height: 1.3;
            margin-top: 8px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        /* Action Buttons */
        .btn-details {
            font-size: 0.7rem;
            font-weight: 700;
            color: #718096;
            text-transform: uppercase;
        }

        .btn-next {
            background: #700A0A;
            color: white;
            padding: 5px 15px;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 700;
            border: none;
            transition: 0.2s;
        }

        .btn-next:hover {
            background: #4a0606;
        }

        /* Animations */
        .post-content-container { transition: opacity 0.3s ease; }
        .animate-out { opacity: 0; }
        .animate-in { opacity: 1; }
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
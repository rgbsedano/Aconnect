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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
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

        .carousel-section { height: 100%; min-height: 0; }
        #carouselExample {
            height: 100%;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            background: var(--white);
            border: 1px solid var(--border);
        }
        .carousel-inner, .carousel-item { height: 100%; }
        .carousel-item img { width: 100%; height: 100%; object-fit: cover; }

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
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: var(--shadow-md);
            border-left: 6px solid var(--primary);
            min-height: 0;
            transition: all 0.3s ease;
            overflow: hidden;
        }
        .post-card:hover { box-shadow: var(--shadow-lg); }

        .post-image-container {
            width: 100%;
            height: 120px;
            overflow: hidden;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .post-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .post-image-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f0f0f0, #e8e8e8);
            color: var(--text-muted);
        }

        .post-image-placeholder i {
            font-size: 32px;
            color: var(--border);
        }

        .post-content {
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex: 1;
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
        .btn-details:hover { color: var(--primary); }

        .btn-next {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 10px 24px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-next:hover { transform: translateY(-2px); box-shadow: var(--shadow-lg); }

        /* Modal Custom Styling */
        .modal-content { border-radius: 16px; border: none; overflow: hidden; }
        .modal-header { background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: white; }
        .modal-body { padding: 32px; color: var(--text-main); line-height: 1.8; }

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
                        <span class="carousel-control-prev-icon"></span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
                        <span class="carousel-control-next-icon"></span>
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
                        'title' => htmlspecialchars($p->title),
                        'content' => nl2br(htmlspecialchars($p->content ?? 'No description available.')),
                        'date' => date('M d, Y', strtotime($p->created_at)),
                        'category' => $type,
                        'image' => !empty($p->image) ? base_url('assets/uploads/post/' . htmlspecialchars($p->image)) : ''
                    ];
                }
                $json_data = htmlspecialchars(json_encode($post_list), ENT_QUOTES, 'UTF-8');
                ?>

                <section class="post-card" data-posts="<?= $json_data ?>" data-idx="0">
                    <div class="post-image-container">
                        <?php if (!empty($posts) && !empty($posts[0]->image)): ?>
                            <img src="<?= base_url('assets/uploads/post/' . htmlspecialchars($posts[0]->image)) ?>" alt="<?= htmlspecialchars($posts[0]->title) ?>">
                        <?php else: ?>
                            <div class="post-image-placeholder">
                                <i class="fas fa-image"></i>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="post-content">
                        <div>
                            <div class="flex justify-between items-center">
                                <span class="post-category"><?= $type ?></span>
                                <span class="post-date text-gray-400 text-[10px] font-bold"><?= !empty($posts) ? date('M d, Y', strtotime($posts[0]->created_at)) : '' ?></span>
                            </div>

                            <div class="post-content-container animate-in">
                                <h4 class="post-title"><?= !empty($posts) ? $posts[0]->title : 'No Recent Updates' ?></h4>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mt-2">
                            <?php if (!empty($posts)): ?>
                                <button class="btn-details open-details-btn">
                                    DETAILS <i class="fas fa-external-link-alt ml-1"></i>
                                </button>
                                
                                <?php if (count($posts) > 1): ?>
                                    <button class="btn-next next-post-btn">
                                        NEXT <i class="fas fa-chevron-right ml-1"></i>
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="modal fade" id="postDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content shadow-2xl">
            <div class="modal-header">
                <h5 class="modal-title font-bold" id="m-title">Post Title</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="flex justify-between items-center mb-6">
                    <span id="m-category" class="post-category">Category</span>
                    <span id="m-date" class="font-semibold text-gray-500 italic">Date</span>
                </div>
                <div id="m-image-container" class="post-image-container mb-6"></div>
                <div id="m-content" class="text-gray-700">
                    </div>
            </div>
            <div class="modal-footer bg-gray-50">
                <button type="button" class="btn btn-secondary px-4 py-2 rounded-lg font-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    // Configure toastr
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "4000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "slideDown",
        "hideMethod": "slideUp"
    };

    function showToast(message, type = 'success') {
        toastr[type](message);
    }
$(document).ready(function() {
    // 1. Next Button Logic
    $('.next-post-btn').on('click', function() {
        const $card = $(this).closest('.post-card');
        const $content = $card.find('.post-content-container');
        const $title = $card.find('.post-title');
        const $date = $card.find('.post-date');
        const $imageContainer = $card.find('.post-image-container');
        
        const posts = $card.data('posts');
        let idx = ($card.data('idx') + 1) % posts.length;
        const next = posts[idx];

        $content.addClass('animate-out');

        setTimeout(() => {
            $title.text(next.title);
            $date.text(next.date);
            
            // Update image
            $imageContainer.html('');
            if (next.image && next.image.trim() !== '') {
                $imageContainer.html(`<img src="${next.image}" alt="${next.title}" style="width: 100%; height: 100%; object-fit: cover;">`);
            } else {
                $imageContainer.html('<div class="post-image-placeholder"><i class="fas fa-image"></i></div>');
            }
            
            $card.data('idx', idx);
            $content.removeClass('animate-out').addClass('animate-in');
        }, 300);
    });

    // 2. Details Button Logic (Populates Modal)
    $('.open-details-btn').on('click', function() {
        const $card = $(this).closest('.post-card');
        const posts = $card.data('posts');
        const idx = $card.data('idx');
        const currentPost = posts[idx];

        // Fill modal fields
        $('#m-title').text(currentPost.title);
        $('#m-category').text(currentPost.category);
        $('#m-date').text(currentPost.date);
        
        // Fill image
        const $imageContainer = $('#m-image-container');
        $imageContainer.html('');
        if (currentPost.image && currentPost.image.trim() !== '') {
            $imageContainer.html(`<img src="${currentPost.image}" alt="${currentPost.title}" style="width: 100%; height: 100%; object-fit: cover;">`);
        } else {
            $imageContainer.html('<div class="post-image-placeholder"><i class="fas fa-image"></i></div>');
        }
        
        $('#m-content').html(currentPost.content);

        // Show the modal
        $('#postDetailModal').modal('show');
    });
});
</script>

</body>
</html>
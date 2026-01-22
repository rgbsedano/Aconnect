<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Alumni Content | Professional</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary-maroon: #800000;
            --primary-hover: #600000;
            --charcoal-text: #2C3E50;
            --bg-soft-grey: #F4F7F6;
            --card-white: #FFFFFF;
            --border-light: #E0E4E8;
            --danger-soft: #e35d6a;
            --success-green: #10B981;
        }

        body {
            background-color: var(--bg-soft-grey);
            font-family: 'Inter', -apple-system, sans-serif;
            color: var(--charcoal-text);
        }

        /* IDENTICAL MARGINS AND PADDING FROM PREVIOUS DESIGNS */
        .admin-wrapper { 
            max-width: 1400px; 
            margin: 40px auto; 
            padding: 0 20px; 
        }

        .content-management-container {
            padding: 32px; /* Matched to alumni-card padding */
            background: var(--card-white);
            border-radius: 16px; /* Matched to earlier design radius */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--border-light);
        }

        .management-header {
            color: var(--primary-maroon);
            font-weight: 800;
            border-bottom: 3px solid var(--primary-maroon);
            display: inline-block;
            padding-bottom: 10px;
        }

        /* VERTICALLY CENTERED MODAL FIX */
        .modal-dialog-centered {
            display: flex;
            align-items: center;
            min-height: calc(100% - 1rem);
        }

        .modal-content { 
            border-radius: 16px; 
            border: none; 
            box-shadow: 0 20px 50px rgba(0,0,0,0.2);
        }

        /* Carousel Grid styling */
        .carousel-preview-card {
            border: 1px solid var(--border-light);
            border-radius: 8px;
            overflow: hidden;
            background: #fff;
            margin-bottom: 20px;
        }
        .carousel-img-wrap { height: 120px; width: 100%; overflow: hidden; background: #f8f9fa; display: flex; align-items: center; justify-content: center; }
        .carousel-img-wrap img { width: 100%; height: 100%; object-fit: cover; }
        
        .btn-delete-photo {
            background-color: var(--danger-soft);
            color: white !important;
            border: none;
            width: 100%;
            padding: 8px;
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: bold;
            display: block;
            text-align: center;
        }

        /* Section Styling */
        .section-divider { margin-bottom: 3rem; }
        .section-title h4 {
            font-weight: 700;
            color: var(--charcoal-text);
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
        }
        .section-title h4 i { color: var(--primary-maroon); margin-right: 12px; }

        /* Card Styling */
        .content-card-custom {
            min-width: 300px;
            max-width: 320px;
            border: 1px solid var(--border-light);
            border-radius: 12px;
            transition: all 0.3s ease;
            background: var(--card-white);
        }
        .content-card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
            border-color: var(--primary-maroon);
        }

        .card-img-top { border-radius: 12px 12px 0 0; height: 160px; object-fit: cover; }

        .btn-maroon { 
            background: linear-gradient(135deg, var(--primary-maroon), var(--primary-hover));
            color: white !important; 
            font-weight: 600; 
            border: none; 
            padding: 10px 24px;
            border-radius: 10px;
        }

        /* Scroller */
        .cards-scroller {
            display: flex;
            gap: 1.5rem;
            overflow-x: auto;
            padding: 10px 5px 20px 5px;
            scrollbar-width: thin;
        }

        /* Toast Styling */
        #toastContainer {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        .custom-toast {
            min-width: 280px;
            padding: 16px 20px;
            border-radius: 12px;
            color: white;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            background: var(--success-green);
            animation: slideIn 0.3s ease-out;
        }
        .toast-error { background: var(--danger-soft); }

        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    </style>
</head>
<body>

<div id="toastContainer"></div>

<div class="admin-wrapper">
    <div class="content-management-container">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2 class="management-header"><i class="fas fa-bullhorn mr-3"></i>Alumni Content</h2>
            <div>
                <button class="btn btn-maroon shadow-sm" data-toggle="modal" data-target="#createPostModal">
                    <i class="fas fa-plus-circle mr-2"></i> Create Post
                </button>
                <button class="btn btn-outline-secondary ml-2 shadow-sm" style="border-radius: 10px; padding: 10px 24px;" data-toggle="modal" data-target="#uploadCarouselModal">
                    <i class="fas fa-images mr-2"></i> Manage Carousel
                </button>
            </div>
        </div>

        <?php function render_section($title, $items, $type) { ?>
            <div class="section-divider">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="section-title">
                        <h4>
                            <i class="<?= $type === 'announcements' ? 'fas fa-bullhorn' : ($type === 'news' ? 'fas fa-newspaper' : 'fas fa-star') ?>"></i>
                            <?= $title ?>
                        </h4>
                    </div>
                    <div class="scroll-controls">
                        <button class="btn btn-sm btn-light border shadow-sm" onclick="scrollCarousel('<?= $type ?>Wrapper', -1)"><i class="fas fa-chevron-left"></i></button>
                        <button class="btn btn-sm btn-light border shadow-sm" onclick="scrollCarousel('<?= $type ?>Wrapper', 1)"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>

                <div class="cards-scroller" id="<?= $type ?>Wrapper">
                    <?php if (empty($items)): ?>
                        <div class="alert alert-light border w-100 text-muted"><i class="fas fa-info-circle mr-2"></i> No <?= strtolower($title) ?> posted yet.</div>
                    <?php else: foreach($items as $post): ?>
                        <div class="card content-card-custom shadow-sm">
                            <img src="<?= !empty($post['image']) ? base_url('assets/uploads/post/' . $post['image']) : 'https://via.placeholder.com/320x160?text=No+Image' ?>" class="card-img-top">
                            <div class="card-body d-flex flex-column p-3">
                                <h6 class="font-weight-bold text-truncate"><?= htmlspecialchars($post['title']) ?></h6>
                                <p class="small text-muted mb-3" style="height: 40px; overflow: hidden;"><?= strip_tags($post['content']) ?></p>
                                <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                                    <button class="btn btn-link btn-sm text-maroon p-0 font-weight-bold">View Details</button>
                                    <div>
                                        <button class="btn btn-link btn-sm text-dark p-0 mr-2"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-link btn-sm text-danger p-0" onclick="deletePost(<?= $post['id'] ?>)"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; endif; ?>
                </div>
            </div>
        <?php } ?>

        <?php render_section('Announcements', $announcements ?? [], 'announcements'); ?>
        <?php render_section('Campus News', $news ?? [], 'news'); ?>
        <?php render_section('Alumni Stories', $stories ?? [], 'stories'); ?>
    </div>
</div>

<div class="modal fade" id="uploadCarouselModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="carouselForm">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Manage Carousel</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body p-4">
                    <div class="custom-file mb-4">
                        <input type="file" class="custom-file-input" id="carouselInput" required>
                        <label class="custom-file-label">Choose file...</label>
                    </div>
                    <div class="row" id="carouselPreviewList">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-maroon px-4">Upload Banner</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="createPostModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="createPostForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Create New Post</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body p-4">
                    <div class="form-group">
                        <label class="small font-weight-bold text-muted">POST TYPE</label>
                        <select name="post_type" class="form-control" required>
                            <option value="">Select Type</option>
                            <option value="announcements">Announcements</option>
                            <option value="news">Campus News</option>
                            <option value="stories">Alumni Stories</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold text-muted">TITLE</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold text-muted">CONTENT</label>
                        <textarea name="content" class="form-control" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold text-muted">FEATURED IMAGE</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold text-muted">TARGET BATCH (OPTIONAL)</label>
                        <input type="text" name="recipient_batch" class="form-control" placeholder="e.g. 2020, 2021">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-maroon px-5">Publish Post</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function showToast(message, type = 'success') {
        const toastClass = type === 'success' ? '' : 'toast-error';
        const html = `<div class="custom-toast ${toastClass}"><i class="fas fa-check-circle mr-3"></i>${message}</div>`;
        $('#toastContainer').append(html);
        setTimeout(() => { $('.custom-toast').fadeOut(400, function() { $(this).remove(); }); }, 3000);
    }

    function scrollCarousel(wrapperId, direction) {
        const wrapper = document.getElementById(wrapperId);
        if (wrapper) wrapper.scrollBy({ left: direction * 320, behavior: 'smooth' });
    }

    $(document).ready(function() {
        $('#createPostForm').on('submit', function(e) {
            e.preventDefault();
            const btn = $(this).find('button[type="submit"]');
            btn.prop('disabled', true).text('Processing...');

            const formData = new FormData(this);
            formData.append('image', $('#createPostForm')[0].elements['image']?.files[0]);

            $.ajax({
                url: '<?= base_url('AdminPost/create') ?>',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    showToast('Post created successfully!');
                    $('.modal').modal('hide');
                    setTimeout(() => location.reload(), 1500);
                },
                error: function() {
                    showToast('Failed to create post', 'error');
                    btn.prop('disabled', false).text('Publish Post');
                }
            });
        });

        $('#carouselForm').on('submit', function(e) {
            e.preventDefault();
            const btn = $(this).find('button[type="submit"]');
            btn.prop('disabled', true).text('Uploading...');

            const formData = new FormData(this);
            formData.append('carousel_photo', $('#carouselInput')[0].files[0]);

            $.ajax({
                url: '<?= base_url('AdminPost/upload') ?>',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    showToast('Banner uploaded successfully!');
                    $('#uploadCarouselModal').modal('hide');
                    setTimeout(() => location.reload(), 1500);
                },
                error: function() {
                    showToast('Failed to upload banner', 'error');
                    btn.prop('disabled', false).text('Upload Banner');
                }
            });
        });

        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });
    });

    function deletePost(id) {
        if(confirm('Delete this post?')) {
            window.location.href = '<?= base_url('AdminPost/delete/') ?>' + id;
        }
    }
</script>
</body>
</html>
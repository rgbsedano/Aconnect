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
            --accent-gold: #C19A6B;
            --delete-red: #D32F2F; 
        }

        body {
            background-color: var(--bg-soft-grey);
            font-family: 'Inter', -apple-system, sans-serif;
            color: var(--charcoal-text);
        }

        .admin-wrapper { 
            max-width: 1400px; 
            margin: 40px auto; 
            padding: 0 20px; 
        }

        .content-management-container {
            padding: 32px;
            background: var(--card-white);
            border-radius: 16px;
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

        .content-card-custom {
            min-width: 320px;
            max-width: 320px;
            border: 1px solid var(--border-light);
            border-radius: 12px;
            transition: all 0.3s ease;
            background: var(--card-white);
            padding: 24px;
            display: flex;
            flex-direction: column;
        }

        .category-label {
            color: var(--accent-gold);
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .applicant-badge {
            background-color: #F8E8EB;
            color: var(--primary-maroon);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .post-main-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1A202C;
            margin-bottom: 15px;
            height: 3rem;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .info-row {
            font-size: 0.85rem;
            color: #718096;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }

        .info-row i {
            width: 20px;
            color: #A0AEC0;
        }

        .btn-review-outline {
            width: 100%;
            background: transparent;
            border: 1px solid var(--primary-maroon);
            color: var(--primary-maroon) !important;
            border-radius: 10px;
            padding: 10px;
            font-weight: 600;
            margin: 20px 0 15px 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-review-outline:hover {
            background: #FFF5F5;
            text-decoration: none;
        }

        .card-footer-actions {
            border-top: 1px solid #F0F0F0;
            padding-top: 15px;
            display: flex;
            justify-content: space-between;
        }

        .action-link {
            font-size: 0.85rem;
            color: #4A5568;
            font-weight: 600;
            text-decoration: none !important;
            display: inline-flex;
            align-items: center;
            transition: opacity 0.2s;
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
        }

        .action-link i { margin-right: 5px; font-size: 0.9rem; }
        .action-link:hover { opacity: 0.7; }

        .action-link.delete { 
            color: var(--delete-red) !important; 
        }

        .section-divider { margin-bottom: 3rem; }
        .cards-scroller {
            display: flex;
            gap: 1.5rem;
            overflow-x: auto;
            padding: 10px 5px 20px 5px;
            scrollbar-width: thin;
        }

        .btn-maroon { 
            background: linear-gradient(135deg, var(--primary-maroon), var(--primary-hover));
            color: white !important; font-weight: 600; border: none; padding: 10px 24px; border-radius: 10px;
        }

        #toastContainer { position: fixed; top: 20px; right: 20px; z-index: 9999; }
        .custom-toast { min-width: 280px; padding: 16px 20px; border-radius: 12px; color: white; margin-bottom: 10px; display: flex; align-items: center; background: var(--success-green); animation: slideIn 0.3s ease-out; }
        .toast-error { background: var(--danger-soft); }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
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
                        <h4 style="font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">
                            <i class="<?= $type === 'announcements' ? 'fas fa-bullhorn' : ($type === 'news' ? 'fas fa-newspaper' : 'fas fa-star') ?>" style="color: var(--primary-maroon); margin-right: 12px;"></i>
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
                            <div class="d-flex justify-content-between align-items-start">
                                <span class="category-label"><?= strtoupper($type) ?></span>
                                <span class="applicant-badge">0 Applicants</span>
                            </div>
                            
                            <h5 class="post-main-title"><?= htmlspecialchars($post['title']) ?></h5>
                            
                            <div class="info-row">
                                <i class="fas fa-map-marker-alt"></i> 
                                <span>Main Campus</span>
                            </div>
                            <div class="info-row">
                                <i class="fas fa-calendar-alt"></i> 
                                <span>Posted: <?= date('M d, Y', strtotime($post['created_at'] ?? 'now')) ?></span>
                            </div>

                            <button type="button" onclick='reviewDetails(<?= json_encode($post) ?>)' class="btn-review-outline">
                                <i class="fas fa-eye mr-2"></i> Review Details
                            </button>

                            <div class="card-footer-actions">
                                <button type="button" onclick='editPost(<?= json_encode($post) ?>)' class="action-link">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </button>
                                <a href="javascript:void(0)" onclick="deletePost(<?= $post['id'] ?>)" class="action-link delete">
                                    <i class="fas fa-trash-alt mr-1"></i> Delete
                                </a>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-maroon px-5">Publish Post</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editPostModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="editPostForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Edit Post</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="post_id" id="edit_post_id">
                    <div class="form-group">
                        <label class="small font-weight-bold text-muted">POST TYPE</label>
                        <select name="post_type" id="edit_post_type" class="form-control" required>
                            <option value="announcements">Announcements</option>
                            <option value="news">Campus News</option>
                            <option value="stories">Alumni Stories</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold text-muted">TITLE</label>
                        <input type="text" name="title" id="edit_title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold text-muted">CONTENT</label>
                        <textarea name="content" id="edit_content" class="form-control" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="small font-weight-bold text-muted">REPLACE IMAGE (OPTIONAL)</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-maroon px-5">Update Post</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="viewPostModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none;">
            <div class="modal-header border-0 p-4">
                <div>
                    <span id="view_post_type" class="category-label mb-2 d-block"></span>
                    <h3 id="view_title" class="font-weight-bold" style="color: var(--charcoal-text);"></h3>
                </div>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body px-4 pb-4">
                <div id="view_image_container" class="mb-4" style="display:none;">
                    <img id="view_image" src="" class="img-fluid rounded shadow-sm" style="width: 100%; max-height: 400px; object-fit: cover;">
                </div>
                <div class="d-flex mb-4 text-muted small">
                    <div class="mr-4"><i class="fas fa-calendar-alt mr-2"></i><span id="view_date"></span></div>
                </div>
                <div class="p-3 bg-light rounded" style="min-height: 200px; white-space: pre-wrap; line-height: 1.6; color: #4A5568;" id="view_content"></div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                <button type="button" id="edit_from_view" class="btn btn-maroon px-4">Edit Post</button>
            </div>
        </div>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-maroon px-4">Upload Banner</button>
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

    // Review Details Function
    function reviewDetails(post) {
        $('#view_title').text(post.title);
        $('#view_post_type').text(post.post_type ? post.post_type.toUpperCase() : 'POST');
        $('#view_content').text(post.content);
        $('#view_date').text('Posted on: ' + (post.created_at || new Date().toLocaleDateString()));

        if (post.image_path) {
            $('#view_image').attr('src', '<?= base_url('uploads/posts/') ?>' + post.image_path);
            $('#view_image_container').show();
        } else {
            $('#view_image_container').hide();
        }

        $('#edit_from_view').off('click').on('click', function() {
            $('#viewPostModal').modal('hide');
            setTimeout(() => editPost(post), 400); 
        });

        $('#viewPostModal').modal('show');
    }

    // Edit Function to open modal and fill data
    function editPost(post) {
        $('#edit_post_id').val(post.id);
        $('#edit_post_type').val(post.post_type);
        $('#edit_title').val(post.title);
        $('#edit_content').val(post.content);
        $('#editPostModal').modal('show');
    }

    $(document).ready(function() {
        // Create Submission
        $('#createPostForm').on('submit', function(e) {
            e.preventDefault();
            const btn = $(this).find('button[type="submit"]');
            btn.prop('disabled', true).text('Processing...');
            const formData = new FormData(this);

            $.ajax({
                url: '<?= base_url('AdminPost/create') ?>',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    showToast('Post created successfully!');
                    $('#createPostModal').modal('hide');
                    setTimeout(() => location.reload(), 1500);
                },
                error: function() {
                    showToast('Failed to create post', 'error');
                    btn.prop('disabled', false).text('Publish Post');
                }
            });
        });

        // Edit Submission
        $('#editPostForm').on('submit', function(e) {
            e.preventDefault();
            const btn = $(this).find('button[type="submit"]');
            const postId = $('#edit_post_id').val();
            btn.prop('disabled', true).text('Updating...');
            const formData = new FormData(this);

            $.ajax({
                url: '<?= base_url('AdminPost/update/') ?>' + postId,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    showToast('Post updated successfully!');
                    $('#editPostModal').modal('hide');
                    setTimeout(() => location.reload(), 1500);
                },
                error: function() {
                    showToast('Failed to update post', 'error');
                    btn.prop('disabled', false).text('Update Post');
                }
            });
        });

        // Carousel Upload
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
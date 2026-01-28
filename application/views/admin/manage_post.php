<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    :root {
        --primary-bg: #f8fafc;
        --card-bg: #ffffff;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --accent-red: #700a0a;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --border-radius: 24px;
    }

    .dashboard-wrapper {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px 24px;
        animation: fadeIn 0.8s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .header-section {
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    .header-section h1 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 4px;
        color: var(--text-main);
    }

    .header-section h1 span { color: var(--accent-red); }
    .header-section p { color: var(--text-muted); font-size: 14px; margin: 0; }

    .section-title {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        margin-top: 40px;
    }

    .section-title h2 {
        font-size: 18px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text-main);
        margin: 0;
    }

    .section-title .badge {
        background: #fef2f2;
        color: var(--accent-red);
        font-size: 11px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 8px;
    }

    /* Horizontal Scroller */
    .cards-scroller {
        display: flex;
        gap: 20px;
        overflow-x: auto;
        padding: 10px 5px 25px;
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none;  /* IE and Edge */
    }

    .cards-scroller::-webkit-scrollbar { display: none; }

    /* Post Card */
    .post-card {
        min-width: 320px;
        max-width: 320px;
        background: var(--card-bg);
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
        transition: var(--transition);
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .post-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        border-color: var(--accent-red);
    }

    .post-type-badge {
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        color: var(--accent-red);
        letter-spacing: 1px;
        margin-bottom: 12px;
        display: block;
    }

    .post-title {
        font-size: 17px;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 12px;
        line-height: 1.4;
        height: 48px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .post-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 12px;
        color: var(--text-muted);
        margin-bottom: 20px;
    }

    .post-meta i { font-size: 14px; color: #cbd5e1; }

    .btn-review {
        width: 100%;
        padding: 10px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        text-align: center;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: var(--text-main);
        transition: var(--transition);
        margin-bottom: 12px;
    }

    .btn-review:hover {
        background: var(--accent-red);
        color: white;
        border-color: var(--accent-red);
        text-decoration: none;
    }

    .card-footer {
        margin-top: auto;
        padding-top: 15px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        background: transparent;
    }

    .action-btn {
        font-size: 12px;
        font-weight: 700;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        transition: var(--transition);
        border: none;
        background: none;
    }

    .action-btn:hover { color: var(--accent-red); }
    .action-btn.delete:hover { color: #ef4444; }

    /* Modal Styling */
    .modal-content { border-radius: 24px; border: none; overflow: hidden; }
    .modal-header { background: var(--accent-red); color: white; padding: 25px; border: none; }
    .form-label { font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px; display: block; }
    .form-input { border-radius: 12px; padding: 12px; font-size: 14px; font-weight: 500; border: 1px solid #e2e8f0; }
    .form-input:focus { border-color: var(--accent-red); box-shadow: 0 0 0 4px rgba(112, 10, 10, 0.05); }

    /* Carousel Manager Styles */
    .carousel-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 16px;
        margin-bottom: 30px;
    }

    .carousel-item-card {
        background: #f8fafc;
        border-radius: 16px;
        padding: 8px;
        border: 1px solid #e2e8f0;
        position: relative;
        transition: var(--transition);
    }

    .carousel-item-card:hover {
        border-color: var(--accent-red);
        transform: translateY(-4px);
    }

    .carousel-item-card img {
        width: 100%;
        aspect-ratio: 16/9;
        object-fit: cover;
        border-radius: 12px;
    }

    .delete-carousel-btn {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #ef4444;
        color: white;
        border: 2px solid white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .delete-carousel-btn:hover {
        background: #dc2626;
        transform: scale(1.1);
    }

</style>

<div class="dashboard-wrapper">
    <div class="header-section">
        <div>
            <h1>Alumni <span>Content</span></h1>
            <p>Publish announcements, news, and success stories to the network.</p>
        </div>
        <div class="actions">
            <button class="btn btn-danger" data-toggle="modal" data-target="#createPostModal" style="background: var(--accent-red); border-radius: 12px; font-weight: 700; padding: 10px 24px;">
                <i class="fas fa-plus mr-2"></i> Create Post
            </button>
            <button class="btn btn-outline-secondary ml-2" data-toggle="modal" data-target="#uploadCarouselModal" style="border-radius: 12px; font-weight: 600; padding: 10px 20px;">
                <i class="fas fa-images mr-2"></i> Carousel
            </button>
        </div>
    </div>

    <?php function render_modern_section($title, $items, $type) { ?>
        <div class="section-title">
            <h2><?= $title ?></h2>
            <span class="badge"><?= count($items) ?> POSTS</span>
        </div>

        <div class="cards-scroller" id="<?= $type ?>Wrapper">
            <?php if (empty($items)): ?>
                <div class="py-5 text-center w-100" style="background: white; border-radius: 20px; border: 2px dashed #e2e8f0;">
                    <i class="fas fa-folder-open fa-3x text-light mb-3"></i>
                    <p class="text-muted font-weight-bold">No <?= strtolower($title) ?> found.</p>
                </div>
            <?php else: foreach($items as $post): ?>
                <div class="post-card">
                    <span class="post-type-badge"><?= $type ?></span>
                    <h5 class="post-title"><?= htmlspecialchars($post['title']) ?></h5>
                    
                    <div class="post-meta">
                        <div><i class="fas fa-calendar-alt mr-1"></i> <?= date('M d, Y', strtotime($post['created_at'] ?? 'now')) ?></div>
                        <div><i class="fas fa-tag mr-1"></i> Admin</div>
                    </div>

                    <a href="javascript:void(0)" onclick='reviewDetails(<?= json_encode($post) ?>)' class="btn-review">
                        <i class="fas fa-eye mr-2"></i> Full Details
                    </a>

                    <div class="card-footer">
                        <button onclick='editPost(<?= json_encode($post) ?>)' class="action-btn">
                            <i class="fas fa-pen"></i> Edit
                        </button>
                        <button onclick="deletePost(<?= $post['id'] ?>)" class="action-btn delete">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            <?php endforeach; endif; ?>
        </div>
    <?php } ?>

    <?php render_modern_section('Announcements', $announcements ?? [], 'announcements'); ?>
    <?php render_modern_section('Campus News', $news ?? [], 'news'); ?>
    <?php render_modern_section('Alumni Stories', $stories ?? [], 'stories'); ?>
</div>

<!-- Modals -->
<div class="modal fade" id="createPostModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="createPostForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" style="font-weight: 700;"><i class="fas fa-plus mr-2"></i> New Content Post</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category</label>
                            <select name="post_type" class="form-control form-input" required>
                                <option value="">Select Category...</option>
                                <option value="announcements">Official Announcement</option>
                                <option value="news">Campus News</option>
                                <option value="stories">Alumni Story</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Post Title</label>
                            <input type="text" name="title" class="form-control form-input" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Content Description</label>
                            <textarea name="content" class="form-control form-input" rows="6" required></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Cover Image (Optional)</label>
                            <input type="file" name="image" class="form-control form-input" accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background: #f8fafc;">
                    <button type="button" class="btn btn-light" data-dismiss="modal" style="border-radius: 12px; font-weight: 600;">Cancel</button>
                    <button type="submit" class="btn btn-danger" style="background: var(--accent-red); border-radius: 12px; font-weight: 700; padding: 10px 24px;">Publish Now</button>
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
                    <h5 class="modal-title" style="font-weight: 700;"><i class="fas fa-edit mr-2"></i> Update Post</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="post_id" id="edit_post_id">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category</label>
                            <select name="post_type" id="edit_post_type" class="form-control form-input" required>
                                <option value="announcements">Announcements</option>
                                <option value="news">Campus News</option>
                                <option value="stories">Alumni Stories</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Post Title</label>
                            <input type="text" name="title" id="edit_title" class="form-control form-input" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Content Description</label>
                            <textarea name="content" id="edit_content" class="form-control form-input" rows="6" required></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Replace Image</label>
                            <input type="file" name="image" class="form-control form-input" accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background: #f8fafc;">
                    <button type="button" class="btn btn-light" data-dismiss="modal" style="border-radius: 12px; font-weight: 600;">Cancel</button>
                    <button type="submit" class="btn btn-danger" style="background: var(--accent-red); border-radius: 12px; font-weight: 700; padding: 10px 24px;">Update Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="viewPostModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="height: 100px; display: flex; align-items: center;">
                <div>
                    <span id="view_post_type" class="post-type-badge text-white-50 mb-1" style="color: rgba(255,255,255,0.7) !important;"></span>
                    <h3 id="view_title" class="modal-title m-0" style="font-weight: 700; color: white;"></h3>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="view_image_container" class="mb-4" style="display:none;">
                    <img id="view_image" src="" class="img-fluid" style="width: 100%; max-height: 400px; object-fit: cover; border-radius: 16px;">
                </div>
                <div class="p-4" style="background: #f8fafc; border-radius: 16px; min-height: 200px; white-space: pre-wrap; line-height: 1.8; color: var(--text-main);" id="view_content"></div>
            </div>
            <div class="modal-footer" style="background: #f8fafc;">
                <button type="button" class="btn btn-light" data-dismiss="modal" style="border-radius: 12px; font-weight: 600;">Close</button>
                <button type="button" id="edit_from_view" class="btn btn-danger" style="background: var(--accent-red); border-radius: 12px; font-weight: 700; padding: 10px 24px;">Edit This Post</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="uploadCarouselModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight: 700;"><i class="fas fa-images mr-2"></i> Carousel Manager</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-4">
                    <label class="form-label mb-3">Currently Active Banners</label>
                    <div class="carousel-grid">
                        <?php if (!empty($carousel)): foreach($carousel as $item): ?>
                            <div class="carousel-item-card">
                                <img src="<?= base_url('assets/uploads/carousel/' . $item['file_name']) ?>" alt="Carousel">
                                <div class="mt-2 text-center">
                                    <button onclick='editCarousel(<?= json_encode($item) ?>)' class="btn btn-sm btn-link text-primary p-0" style="font-size: 11px; font-weight: 700;">EDIT INFO</button>
                                </div>
                                <button onclick="deleteCarousel(<?= $item['id'] ?>)" class="delete-carousel-btn" title="Delete Banner">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        <?php endforeach; else: ?>
                            <div class="col-12 py-4 text-center text-muted" style="background: #f8fafc; border-radius: 16px; border: 2px dashed #e2e8f0;">
                                <i class="fas fa-images fa-2x mb-2 opacity-25"></i>
                                <p class="small m-0">No carousel banners active.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div style="height: 1px; background: #f1f5f9; margin-bottom: 24px;"></div>

                <form id="carouselForm" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="carousel_id" id="carousel_id">
                    <div id="carouselFormTitle" class="form-label mb-3">Add New Banner</div>
                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Banner Title</label>
                            <input type="text" name="title" id="carouselTitle" class="form-control form-input" placeholder="e.g. Welcome to SDCA">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Short Description</label>
                            <textarea name="description" id="carouselDescription" class="form-control form-input" rows="3" placeholder="Clicking the banner will show this in a modal..."></textarea>
                        </div>
                    </div>

                    <div class="p-4 text-center" style="background: #f8fafc; border-radius: 20px; border: 2px dashed #e2e8f0;">
                        <i class="fas fa-cloud-upload-alt fa-2x text-light mb-3"></i>
                        <p class="text-muted small mb-3">Recommended size: 1920x600px (16:9 ratio)</p>
                        <div class="custom-file text-left" style="max-width: 300px; margin: 0 auto;">
                            <input type="file" name="carousel_photo" class="custom-file-input" id="carouselInput" accept="image/*">
                            <label class="custom-file-label">Choose file...</label>
                        </div>
                    </div>
                    <div class="mt-4 text-right">
                        <button type="button" id="resetCarouselForm" class="btn btn-light" style="border-radius: 12px; font-weight: 600; display:none;">Cancel Edit</button>
                        <button type="submit" id="carouselSubmitBtn" class="btn btn-danger" style="background: var(--accent-red); border-radius: 12px; font-weight: 700; padding: 10px 24px;">Upload Banner</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    function reviewDetails(post) {
        $('#view_title').text(post.title);
        $('#view_post_type').text(post.post_type.toUpperCase());
        $('#view_content').text(post.content);

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

    function editPost(post) {
        $('#edit_post_id').val(post.id);
        $('#edit_post_type').val(post.post_type);
        $('#edit_title').val(post.title);
        $('#edit_content').val(post.content);
        $('#editPostModal').modal('show');
    }

    function editCarousel(item) {
        $('#carousel_id').val(item.id);
        $('#carouselTitle').val(item.title);
        $('#carouselDescription').val(item.description);
        $('#carouselFormTitle').text('Editing Banner: ' + (item.title || 'Untitled'));
        $('#carouselSubmitBtn').text('Save Changes');
        $('#carouselInput').removeAttr('required');
        $('#resetCarouselForm').show();
        $('#carouselForm').attr('action', '<?= base_url('AdminPost/update_carousel/') ?>' + item.id);
    }

    $('#resetCarouselForm').on('click', function() {
        $('#carousel_id').val('');
        $('#carouselTitle').val('');
        $('#carouselDescription').val('');
        $('#carouselFormTitle').text('Add New Banner');
        $('#carouselSubmitBtn').text('Upload Banner');
        $('#carouselInput').attr('required', 'required');
        $(this).hide();
        $('#carouselForm').attr('action', '<?= base_url('AdminPost/upload') ?>');
    });

    function deleteCarousel(id) {
        if(confirm('Are you sure you want to remove this banner from the carousel?')) {
            window.location.href = '<?= base_url('AdminPost/delete_carousel/') ?>' + id;
        }
    }

    function deletePost(id) {
        if(confirm('Are you sure you want to delete this post permanently?')) {
            window.location.href = '<?= base_url('AdminPost/delete/') ?>' + id;
        }
    }

    $(document).ready(function() {
        $('#createPostForm').on('submit', function(e) {
            e.preventDefault();
            const btn = $(this).find('button[type="submit"]');
            btn.prop('disabled', true).text('Publishing...');
            $.ajax({
                url: '<?= base_url('AdminPost/create') ?>',
                type: 'POST',
                data: new FormData(this),
                contentType: false, processData: false,
                success: function() { location.reload(); },
                error: function() { alert('Failed to create post.'); btn.prop('disabled', false).text('Publish Now'); }
            });
        });

        $('#editPostForm').on('submit', function(e) {
            e.preventDefault();
            const btn = $(this).find('button[type="submit"]');
            btn.prop('disabled', true).text('Saving...');
            $.ajax({
                url: '<?= base_url('AdminPost/update/') ?>' + $('#edit_post_id').val(),
                type: 'POST',
                data: new FormData(this),
                contentType: false, processData: false,
                success: function() { location.reload(); },
                error: function() { alert('Failed to update post.'); btn.prop('disabled', false).text('Update Changes'); }
            });
        });

        $('#carouselForm').on('submit', function(e) {
            e.preventDefault();
            const btn = $(this).find('button[type="submit"]');
            btn.prop('disabled', true).text('Processing...');
            
            const action = $(this).attr('action') || '<?= base_url('AdminPost/upload') ?>';
            
            $.ajax({
                url: action,
                type: 'POST',
                data: new FormData(this),
                contentType: false, processData: false,
                success: function() { location.reload(); },
                error: function() { alert('Failed to process carousel item.'); btn.prop('disabled', false).text('Try Again'); }
            });
        });

        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });
    });
</script>

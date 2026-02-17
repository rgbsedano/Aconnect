<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    :root {
        --primary-bg: #f8fafc;
        --card-bg: #ffffff;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --accent-red: #700a0a;
        --accent-light-red: #ff6b6b;
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
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    .header-section h1 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 4px;
        color: white;
    }

    .header-section h1 span { color: var(--accent-light-red); }
    .header-section p { color: rgba(255, 255, 255, 0.9); font-size: 14px; margin: 0; }

    /* Content Switcher Styles */
    .switcher-wrapper {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
        overflow-x: auto;
        padding-bottom: 8px;
        scrollbar-width: none;
    }
    .switcher-wrapper::-webkit-scrollbar { display: none; }

    .switch-btn {
        padding: 10px 24px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.2);
        cursor: pointer;
        transition: var(--transition);
        white-space: nowrap;
        backdrop-filter: blur(4px);
    }

    .switch-btn:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }

    .switch-btn.active {
        background: white;
        color: var(--accent-red);
        border-color: white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    /* Main Card Styling */
    .main-card {
        background: var(--card-bg);
        border-radius: var(--border-radius);
        padding: 30px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
        margin-bottom: 30px;
    }

    /* Custom Table Style */
    .custom-table { width: 100%; border-collapse: separate; border-spacing: 0 10px; }
    .custom-table th { padding: 12px 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); border: none; }
    .custom-table tr.data-row { background: white; transition: var(--transition); }
    .custom-table tr.data-row:hover { transform: scale(1.005); box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
    .custom-table td { padding: 16px 20px; vertical-align: middle; border-top: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9; }
    .custom-table td:first-child { border-left: 1px solid #f1f5f9; border-top-left-radius: 14px; border-bottom-left-radius: 14px; }
    .custom-table td:last-child { border-right: 1px solid #f1f5f9; border-top-right-radius: 14px; border-bottom-right-radius: 14px; }

    .post-title-cell { font-weight: 700; color: var(--text-main); font-size: 15px; }
    .post-type-label { font-size: 11px; font-weight: 800; text-transform: uppercase; color: var(--accent-red); background: #fef2f2; padding: 2px 8px; border-radius: 6px; }

    .btn-action {
        width: 36px; height: 36px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center;
        background: #f8fafc; color: var(--text-muted); border: 1px solid #e2e8f0; transition: var(--transition);
        margin-left: 5px;
    }
    .btn-action:hover { background: var(--accent-red); color: white; border-color: var(--accent-red); transform: translateY(-2px); }
    .btn-action.delete:hover { background: #ef4444; border-color: #ef4444; }

    /* Modal Styling */
    .modal-content { border-radius: 24px; border: none; overflow: hidden; }
    .modal-header { background: var(--accent-red); color: white; padding: 25px; border: none; }
    .modal-body { padding: 30px; }
    .form-label { font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px; display: block; }
    .form-input { border-radius: 12px; padding: 12px; font-size: 14px; font-weight: 500; border: 1px solid #e2e8f0; }
    .form-input:focus { border-color: var(--accent-red); box-shadow: 0 0 0 4px rgba(112, 10, 10, 0.05); }

    /* Carousel Item Grid */
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
    }

    @media (max-width: 768px) {
        .header-section { flex-direction: column; align-items: flex-start; gap: 20px; }
        .header-section .actions { width: 100%; display: flex; gap: 10px; }
        .header-section .actions .btn { flex: 1; margin: 0 !important; }
        .switcher-wrapper { width: 100%; }
        .switch-btn { flex: 1; text-align: center; }
    }
</style>

<div class="dashboard-wrapper">
    <header class="header-section">
        <div>
            <h1>Alumni <span>Content</span></h1>
            <p>Publish announcements, news, and success stories to the network.</p>
        </div>
        <div class="actions">
            <button class="btn btn-danger" data-toggle="modal" data-target="#createPostModal" style="background: var(--accent-red); border-radius: 12px; font-weight: 700; padding: 10px 24px;">
                <i class="fas fa-plus mr-2"></i> Create Post
            </button>
            <button class="btn btn-outline-light ml-2" data-toggle="modal" data-target="#uploadCarouselModal" style="border-radius: 12px; font-weight: 600; padding: 10px 20px; color: white; border-color: rgba(255,255,255,0.4);">
                <i class="fas fa-images mr-2"></i> Carousel
            </button>
        </div>
    </header>

    <div class="switcher-wrapper">
        <button class="switch-btn active" onclick="switchCategory('announcements')">Announcements</button>
        <button class="switch-btn" onclick="switchCategory('news')">Campus News</button>
        <button class="switch-btn" onclick="switchCategory('stories')">Alumni Stories</button>
    </div>

    <div class="main-card">
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Content Details</th>
                        <th>Created At</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody id="contentTableBody">
                    <?php 
                    $all_posts = array_merge(
                        array_map(function($p){ $p['type_label']='Announcement'; return $p; }, $announcements),
                        array_map(function($p){ $p['type_label']='Campus News'; return $p; }, $news),
                        array_map(function($p){ $p['type_label']='Success Story'; return $p; }, $stories)
                    );
                    foreach($all_posts as $post): ?>
                        <tr class="data-row post-item" data-type="<?= $post['post_type'] ?>" style="<?= $post['post_type'] == 'announcements' ? '' : 'display:none;' ?>">
                            <td>
                                <div class="post-title-cell" onclick='reviewDetails(<?= json_encode($post) ?>)' 
                                     style="cursor: pointer; transition: var(--transition);" 
                                     onmouseover="this.style.textDecoration='underline'" 
                                     onmouseout="this.style.textDecoration='none'">
                                    <?= htmlspecialchars($post['title']) ?>
                                </div>
                                <span class="post-type-label"><?= $post['type_label'] ?></span>
                            </td>
                            <td>
                                <span class="text-muted small font-weight-bold">
                                    <i class="fas fa-calendar-alt mr-1"></i> <?= date('M d, Y', strtotime($post['created_at'])) ?>
                                </span>
                            </td>
                            <td class="text-right">
                                <button onclick='editPost(<?= json_encode($post) ?>)' class="btn-action" title="Edit Post">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button onclick="deletePost(<?= $post['id'] ?>)" class="btn-action delete" title="Delete Post">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- CREATE POST MODAL -->
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
                            <input type="text" name="title" class="form-control form-input" placeholder="Enter headline..." required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Content Description</label>
                            <textarea name="content" class="form-control form-input" rows="6" placeholder="Write your content here..." required></textarea>
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

<!-- EDIT POST MODAL -->
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

<!-- VIEW POST MODAL -->
<div class="modal fade" id="viewPostModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="height: 100px; display: flex; align-items: center; background: #2d3436;">
                <div>
                    <span id="view_post_type" class="post-type-label mb-1" style="background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.2);"></span>
                    <h3 id="view_title" class="modal-title m-0" style="font-weight: 700; color: white;"></h3>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="view_image_container" class="mb-4 text-center" style="display:none;">
                    <img id="view_image" src="" class="img-fluid" style="border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); max-height: 400px; object-fit: cover;">
                </div>
                <div id="view_content" style="font-size: 15px; line-height: 1.8; color: var(--text-main); white-space: pre-wrap; padding: 20px; background: #f8fafc; border-radius: 16px;"></div>
            </div>
            <div class="modal-footer" style="background: #f8fafc;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 12px; font-weight: 600;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- CAROUSEL MODAL -->
<div class="modal fade" id="uploadCarouselModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight: 700;"><i class="fas fa-images mr-2"></i> Carousel Manager</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="carousel-grid">
                    <?php foreach($carousel as $item): ?>
                        <div class="carousel-item-card">
                            <img src="<?= base_url('assets/uploads/carousel/' . $item['file_name']) ?>" alt="Carousel">
                            <button onclick="deleteCarousel(<?= $item['id'] ?>)" class="delete-carousel-btn">
                                <i class="fas fa-times"></i>
                            </button>
                            <div class="mt-2 text-center">
                                <button onclick='editCarousel(<?= json_encode($item) ?>)' class="btn btn-sm btn-link text-danger p-0" style="font-size: 10px; font-weight: 700;">EDIT TEXT</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <hr class="my-4">

                <form id="carouselForm" enctype="multipart/form-data">
                    <input type="hidden" name="carousel_id" id="carousel_id">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Banner Title</label>
                            <input type="text" name="title" id="carouselTitle" class="form-control form-input" placeholder="e.g. Welcome Back">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Banner Image</label>
                            <input type="file" name="carousel_photo" id="carouselInput" class="form-control form-input" accept="image/*">
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Description (Optional)</label>
                            <textarea name="description" id="carouselDescription" class="form-control form-input" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="text-right mt-2">
                        <button type="button" id="resetCarouselForm" class="btn btn-light mr-2" style="display:none; border-radius: 10px;">Reset</button>
                        <button type="submit" id="carouselSubmitBtn" class="btn btn-danger" style="background: var(--accent-red); border-radius: 12px; font-weight: 700; padding: 10px 24px;">Upload Banner</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    function switchCategory(type) {
        $('.switch-btn').removeClass('active');
        $(`.switch-btn[onclick="switchCategory('${type}')"]`).addClass('active');
        
        $('.post-item').hide();
        $(`.post-item[data-type="${type}"]`).fadeIn(300);
    }

    function reviewDetails(post) {
        $('#view_title').text(post.title);
        $('#view_post_type').text(post.type_label);
        $('#view_content').text(post.content);

        if (post.image) {
            $('#view_image').attr('src', '<?= base_url('assets/uploads/post/') ?>' + post.image);
            $('#view_image_container').show();
        } else {
            $('#view_image_container').hide();
        }
        $('#viewPostModal').modal('show');
    }

    function editPost(post) {
        $('#edit_post_id').val(post.id);
        $('#edit_post_type').val(post.post_type);
        $('#edit_title').val(post.title);
        $('#edit_content').val(post.content);
        $('#editPostModal').modal('show');
    }

    function deletePost(id) {
        if(confirm('Delete this post permanently?')) {
            window.location.href = '<?= base_url("AdminPost/delete/") ?>' + id;
        }
    }

    function deleteCarousel(id) {
        if(confirm('Delete this banner?')) {
            window.location.href = '<?= base_url("AdminPost/delete_carousel/") ?>' + id;
        }
    }

    function editCarousel(item) {
        $('#carousel_id').val(item.id);
        $('#carouselTitle').val(item.title);
        $('#carouselDescription').val(item.description);
        $('#carouselSubmitBtn').text('Save Changes');
        $('#resetCarouselForm').show();
        $('#carouselForm').attr('action', '<?= base_url("AdminPost/update_carousel/") ?>' + item.id);
    }

    $(document).ready(function() {
        $('#resetCarouselForm').click(function() {
            $('#carouselForm')[0].reset();
            $('#carousel_id').val('');
            $('#carouselSubmitBtn').text('Upload Banner');
            $(this).hide();
            $('#carouselForm').attr('action', '<?= base_url("AdminPost/upload") ?>');
        });

        $('#createPostForm').submit(function(e) {
            e.preventDefault();
            const btn = $(this).find('button[type="submit"]');
            btn.prop('disabled', true).text('Publishing...');
            $.ajax({
                url: '<?= base_url("AdminPost/create") ?>',
                type: 'POST',
                data: new FormData(this),
                contentType: false, processData: false,
                success: function() { location.reload(); },
                error: function() { alert('Error publishing.'); btn.prop('disabled', false).text('Publish Now'); }
            });
        });

        $('#editPostForm').submit(function(e) {
            e.preventDefault();
            const btn = $(this).find('button[type="submit"]');
            btn.prop('disabled', true).text('Saving...');
            $.ajax({
                url: '<?= base_url("AdminPost/update/") ?>' + $('#edit_post_id').val(),
                type: 'POST',
                data: new FormData(this),
                contentType: false, processData: false,
                success: function() { location.reload(); },
                error: function() { alert('Error updating.'); btn.prop('disabled', false).text('Update Changes'); }
            });
        });

        $('#carouselForm').submit(function(e) {
            e.preventDefault();
            const actionUrl = $(this).attr('action') || '<?= base_url("AdminPost/upload") ?>';
            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: new FormData(this),
                contentType: false, processData: false,
                success: function() { location.reload(); },
                error: function() { alert('Error processing carousel.'); }
            });
        });
    });
</script>

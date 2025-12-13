<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Alumni Content</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <style>
        /* --- Custom Styles for Modern Look --- */

        /* General Layout & Colors */
        .btn-custom-primary {
            /* Primary Button Color: Red */
            background-color: #dc3545 !important; 
            border: none;
            transition: background-color 0.2s;
        }
        .btn-custom-primary:hover {
            /* Darker Red on hover */
            background-color: #c82333 !important;
        }

        /* Added for top header separation */
        .mb-xl { 
            margin-bottom: 4rem !important; 
        }

        /* Card and Hover Effects */
        .card-fixed { 
            min-width: 280px; 
            max-width: 350px; 
            width: 100%; 
            height: 380px; 
            display: flex; 
            flex-direction: column; 
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #f0f0f0; 
        }
        .card-fixed:hover {
            transform: translateY(-3px); 
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15) !important;
        }
        .card-body-flex { 
            display: flex; 
            flex-direction: column; 
            height: 100%; 
            padding: 1rem;
        }
        .card-title { 
            white-space: nowrap; 
            overflow: hidden; 
            text-overflow: ellipsis; 
            font-weight: 700;
        }
        .card-text { 
            overflow: hidden;
            flex-grow: 1; 
            color: #6c757d;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }
        .card-footer-btns { 
            margin-top: auto; 
            display: flex; 
            gap: .5rem; 
            padding-top: 0.75rem;
            border-top: 1px solid #e9ecef; 
        }
        
        /* Section Spacing */
        .section-wrap { 
            margin-bottom: 6rem; 
        }
        .section-title h4 {
            font-weight: 300;
            font-size: 1.75rem;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 10px;
            margin-bottom: 2.5rem;
            width: 100%;
        }

        /* Horizontal scroller enhancement */
        .cards-scroller { 
            display: flex; 
            gap: 1.5rem; 
            overflow-x: auto; 
            padding-bottom: 1rem; 
            scrollbar-width: thin;
            scrollbar-color: rgba(0,0,0,0.2) #f1f1f1;
        }
        .cards-scroller::-webkit-scrollbar { 
            height: 10px; 
        }
        .cards-scroller::-webkit-scrollbar-thumb { 
            background: #adb5bd; 
            border-radius: 5px; 
        }

        /* Modal & Form Styles */
        .modal-header-custom {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }
        .img-preview-thumb {
            border: 2px solid #adb5bd;
            border-radius: 4px;
            padding: 2px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        /* Scroll Controls Alignment */
        .scroll-controls {
            display: flex;
            justify-content: flex-end; 
            margin-top: -5rem;
            position: relative;
            z-index: 10;
        }

        @media (max-width: 576px) {
            .card-fixed { min-width: 90vw; height: 350px; }
            .scroll-controls { margin-top: -4rem; justify-content: space-between; }
        }
    </style>
</head>

<body>

<div class="container mt-5">
    <div class="d-flex align-items-center justify-content-between mb-xl"> 
        <h2 class="m-0 text-dark"><i class="fas fa-bullhorn mr-2 text-custom-primary"></i> Manage Alumni Content</h2>
        <div class="d-flex" style="gap: .5rem;">
            <button class="btn btn-custom-primary" data-toggle="modal" data-target="#createPostModal">
                <i class="fas fa-plus-circle mr-1"></i> Create Post
            </button>
            <button class="btn btn-outline-info" data-toggle="modal" data-target="#uploadCarouselModal">
                <i class="fas fa-images mr-1"></i> Upload Carousel
            </button>
        </div>
    </div>

    <div class="modal fade" id="createPostModal" tabindex="-1" role="dialog" aria-labelledby="createPostModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document"> 
            <div class="modal-content">
                <form action="<?= base_url('AdminPost/create') ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-header modal-header-custom">
                        <h5 class="modal-title" id="createPostModalLabel"><i class="fas fa-pencil-alt mr-2 text-primary"></i> Create New Post</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control" required placeholder="Enter post title">
                            </div>
                            <div class="form-group col-12">
                                <label>Content / Body</label>
                                <textarea name="content" id="create_content" class="form-control" rows="8" required placeholder="Write the main content of your post here"></textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Post Type</label>
                                <select name="post_type" class="form-control" required>
                                    <option value="announcements">Announcement</option>
                                    <option value="news">News</option>
                                    <option value="stories">Alumni Story</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Recipient Batch (comma-separated years)</label>
                                <input type="text" name="recipient_batch" class="form-control" placeholder="e.g. 2015,2016 or ALL" required>
                                <small class="form-text text-muted">Use 'ALL' to target all alumni, or specific graduation years.</small>
                            </div>
                            <div class="form-group col-12">
                                <label>Attach Featured Image</label>
                                <input type="file" name="image" class="form-control-file" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-custom-primary"><i class="fas fa-paper-plane mr-1"></i> Publish Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="uploadCarouselModal" tabindex="-1" role="dialog" aria-labelledby="uploadCarouselModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="<?= base_url('AdminPost/upload') ?>" method="post" enctype="multipart/form-data">
                    <div class="modal-header modal-header-custom">
                        <h5 class="modal-title" id="uploadCarouselModalLabel"><i class="fas fa-camera-retro mr-2 text-info"></i> Manage Homepage Carousel</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Select New Image to Upload</label>
                            <input type="file" name="carousel_photo" class="form-control-file" required accept="image/*">
                            <small class="form-text text-muted">Recommended aspect ratio: 16:9 for banners.</small>
                        </div>
                        <hr>
                        <h6 class="mb-3 text-muted">Currently Uploaded Carousel Photos</h6>
                        <div class="row">
                            <?php $photos = $this->db->get('carousel_photos')->result_array(); ?>
                            <?php if (empty($photos)): ?>
                                <div class="col-12"><div class="alert alert-warning"><i class="fas fa-exclamation-triangle mr-1"></i> No uploaded photos yet.</div></div>
                            <?php else: ?>
                                <?php foreach($photos as $p): ?>
                                    <div class="col-6 col-md-3 mb-3">
                                        <div class="card shadow-sm">
                                            <img src="<?= base_url('assets/uploads/carousel/' . htmlspecialchars($p['file_name'])) ?>" class="card-img-top" style="height:100px; object-fit:cover;" alt="carousel">
                                            <div class="card-body p-1 text-center">
                                                <button type="button" class="btn btn-sm btn-danger btn-block disabled" title="Requires separate delete logic"><i class="fas fa-times"></i> Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-info"><i class="fas fa-cloud-upload-alt mr-1"></i> Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php function render_section($title, $items, $type) { ?>
        <div class="section-wrap">
            <div class="section-title mb-3">
                <h4 class="text-capitalize"><i class="<?= $type === 'announcements' ? 'fas fa-bullhorn' : ($type === 'news' ? 'fas fa-newspaper' : 'fas fa-lightbulb') ?> mr-2 text-custom-primary"></i> <?= $title ?></h4>
            </div>

            <div class="scroll-controls">
                <button class="btn btn-sm" onclick="scrollCarousel('<?= $type ?>Wrapper', -1)" title="Scroll Left"><i class="fas fa-chevron-left"></i></button>
                <button class="btn btn-sm" onclick="scrollCarousel('<?= $type ?>Wrapper', 1)" title="Scroll Right"><i class="fas fa-chevron-right"></i></button>
            </div>

            <div class="cards-scroller" id="<?= $type ?>Wrapper">
                <?php if (empty($items)): ?>
                    <div class="text-muted p-3">No <?= strtolower($title) ?> yet. Click 'Create Post' to add one.</div>
                <?php endif; ?>

                <?php foreach($items as $post): ?>
                    <?php 
                    $safe_title = htmlspecialchars($post['title']); 
                    ?>

                    <div class="card card-fixed shadow card-fixed d-flex flex-column">
                        <?php if (!empty($post['image'])): ?>
                            <img src="<?= base_url('assets/uploads/post/' . htmlspecialchars($post['image'])) ?>" style="height:150px; object-fit:cover;" class="card-img-top" alt="post-image">
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center bg-light text-muted" style="height:150px;"><i class="fas fa-image fa-3x"></i></div>
                        <?php endif; ?>

                        <div class="card-body card-body-flex">
                            <h5 class="card-title" title="<?= $safe_title ?>"><b><?= $safe_title ?></b></h5>
                            <p class="card-text"><small><?= word_limiter(strip_tags($post['content']), 20) ?></small></p>

                            <div class="card-footer-btns mt-auto">
                                <button class="btn btn-sm btn-outline-info flex-grow-1" data-toggle="modal" data-target="#viewPostModal_<?= $post['id'] ?>"><i class="fas fa-eye mr-1"></i> View</button>
                                <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editPostModal_<?= $post['id'] ?>" title="Edit"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deletePostModal_<?= $post['id'] ?>" title="Delete"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="viewPostModal_<?= $post['id'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-info text-white">
                                    <h5 class="modal-title"><i class="fas fa-info-circle mr-2"></i> <?= $safe_title ?></h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <?php if (!empty($post['image'])): ?>
                                        <img src="<?= base_url('assets/uploads/post/' . htmlspecialchars($post['image'])) ?>" class="img-fluid mb-4 rounded shadow-sm" alt="post-image">
                                    <?php endif; ?>
                                    <p class="lead"><?= nl2br($post['content']) ?></p> 
                                    <hr>
                                    <p class="text-muted small">
                                        Posted: <?= date('F d, Y', strtotime($post['created_at'] ?? 'now')) ?> | 
                                        Type: <strong><?= ucfirst($post['post_type']) ?></strong> | 
                                        Target Batches: <strong><?= htmlspecialchars($post['recipient_batch']) ?></strong>
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="editPostModal_<?= $post['id'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-xl"> 
                            <div class="modal-content">
                                <form action="<?= base_url('AdminPost/update/' . $post['id']) ?>" method="post" enctype="multipart/form-data">
                                    <div class="modal-header bg-warning text-dark">
                                        <h5 class="modal-title"><i class="fas fa-edit mr-2"></i> Edit Post: <?= $safe_title ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($post['title']) ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Content</label>
                                            <textarea name="content" id="edit_content_<?= $post['id'] ?>" class="form-control" rows="8" required><?= $post['content'] ?></textarea>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Post Type</label>
                                                <select name="post_type" class="form-control" required>
                                                    <option value="announcements" <?= $post['post_type']==='announcements'?'selected':'' ?>>Announcement</option>
                                                    <option value="news" <?= $post['post_type']==='news'?'selected':'' ?>>News</option>
                                                    <option value="stories" <?= $post['post_type']==='stories'?'selected':'' ?>>Story</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Recipient Batch</label>
                                                <input type="text" name="recipient_batch" class="form-control" value="<?= htmlspecialchars($post['recipient_batch']) ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Replace Image (optional)</label>
                                            <input type="file" name="image" class="form-control-file">
                                            <?php if (!empty($post['image'])): ?>
                                                <div class="mt-2 text-center">
                                                    <small class="text-muted d-block mb-1">Current Image:</small>
                                                    <img src="<?= base_url('assets/uploads/post/' . htmlspecialchars($post['image'])) ?>" width="120" class="img-thumbnail img-preview-thumb">
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-warning text-dark"><i class="fas fa-save mr-1"></i> Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="deletePostModal_<?= $post['id'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <form action="<?= base_url('AdminPost/delete/' . $post['id']) ?>" method="post">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title"><i class="fas fa-exclamation-triangle mr-2"></i> Confirm Delete</h5>
                                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete this post?</p>
                                        <p><strong><?= htmlspecialchars($post['title']) ?></strong></p>
                                        <p class="text-danger small">This action is permanent.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt mr-1"></i> Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php } ?>
    
    <?php 
    // PHP variables assumed to be populated in your environment
    // $announcements, $news, $stories 
    // The conditional rendering remains based on these variables
    ?>
    
    <?php render_section('Announcements', $announcements ?? [], 'announcements'); ?>
    <?php render_section('News', $news ?? [], 'news'); ?>
    <?php render_section('Stories', $stories ?? [], 'stories'); ?>

</div>

<script>
    // 1. Carousel Scroll Logic (Existing)
    function scrollCarousel(wrapperId, direction) {
        const wrapper = document.getElementById(wrapperId);
        if (!wrapper) return;
        const card = wrapper.querySelector('.card-fixed');
        const gap = 24;
        const cardWidth = (card ? card.offsetWidth : 280) + gap; 
        
        wrapper.scrollBy({ left: direction * cardWidth, behavior: 'smooth' });
    }

    // Removed: All TinyMCE JavaScript initialization.
</script>
</body>
</html>
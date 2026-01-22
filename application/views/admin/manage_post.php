<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Alumni Content | Professional</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        :root {
            --primary-maroon: #800000;
            --primary-hover: #600000;
            --charcoal-text: #2C3E50;
            --muted-blue: #546E7A;
            --bg-soft-grey: #F4F7F6;
            --card-white: #FFFFFF;
            --border-light: #E0E4E8;
            --danger-soft: #e35d6a;
        }

        body {
            background-color: var(--bg-soft-grey);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            color: var(--charcoal-text);
        }

        .content-management-container {
            padding: 40px;
            background: var(--card-white);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            margin-top: 40px;
            margin-bottom: 40px;
            border: 1px solid var(--border-light);
        }

        .management-header {
            color: var(--primary-maroon);
            font-weight: 800;
            border-bottom: 3px solid var(--primary-maroon);
            display: inline-block;
            padding-bottom: 10px;
        }

        /* Carousel Grid Styling (Merged from reference) */
        .carousel-preview-card {
            border: 1px solid var(--border-light);
            border-radius: 4px;
            overflow: hidden;
            background: #fff;
            margin-bottom: 20px;
        }
        .carousel-img-wrap { height: 100px; width: 100%; overflow: hidden; background: #f8f9fa; display: flex; align-items: center; justify-content: center; }
        .carousel-img-wrap img { width: 100%; height: 100%; object-fit: cover; }
        
        .btn-delete-photo {
            background-color: var(--danger-soft);
            color: white !important;
            border: none;
            width: 100%;
            padding: 4px;
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: bold;
            display: block;
            text-align: center;
        }
        .btn-delete-photo:hover { background-color: #c82333; text-decoration: none; }

        /* Section Styling */
        .section-divider { margin-bottom: 3rem; }
        .section-title h4 {
            font-weight: 700;
            color: var(--charcoal-text);
            font-size: 1.25rem;
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
            display: flex;
            flex-direction: column;
        }
        .content-card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
            border-color: var(--primary-maroon);
        }

        .card-img-top { border-radius: 12px 12px 0 0; height: 160px; object-fit: cover; }

        .btn-maroon { background-color: var(--primary-maroon); color: white; font-weight: 600; border: none; }
        .btn-maroon:hover { background-color: var(--primary-hover); color: white; }

        .btn-outline-maroon { border: 1px solid var(--primary-maroon); color: var(--primary-maroon); font-weight: 600; }
        .btn-outline-maroon:hover { background: var(--primary-maroon); color: #fff; }

        /* Scroller */
        .cards-scroller {
            display: flex;
            gap: 1.5rem;
            overflow-x: auto;
            padding: 10px 5px 20px 5px;
            scrollbar-width: thin;
        }
        .cards-scroller::-webkit-scrollbar { height: 6px; }
        .cards-scroller::-webkit-scrollbar-thumb { background: #ced4da; border-radius: 10px; }

        .scroll-controls .btn {
            color: var(--primary-maroon);
            background: white;
            border: 1px solid var(--border-light);
            border-radius: 50%;
            width: 35px;
            height: 35px;
            padding: 0;
            margin-left: 5px;
        }

        .modal-header { background-color: var(--primary-maroon); color: white; border-radius: 12px 12px 0 0; }
        .modal-content { border-radius: 12px; border: none; }
    </style>
</head>
<body>

<div class="container-fluid py-5">
    <div class="container content-management-container">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6">
                <h2 class="management-header"><i class="fas fa-bullhorn mr-2"></i> Alumni Content</h2>
            </div>
            <div class="col-lg-6 text-lg-right">
                <button class="btn btn-maroon shadow-sm" data-toggle="modal" data-target="#createPostModal">
                    <i class="fas fa-plus-circle mr-2"></i> Create Post
                </button>
                <button class="btn btn-outline-maroon ml-2 shadow-sm" data-toggle="modal" data-target="#uploadCarouselModal">
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
                        <button class="btn btn-sm shadow-sm" onclick="scrollCarousel('<?= $type ?>Wrapper', -1)"><i class="fas fa-chevron-left"></i></button>
                        <button class="btn btn-sm shadow-sm" onclick="scrollCarousel('<?= $type ?>Wrapper', 1)"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>

                <div class="cards-scroller" id="<?= $type ?>Wrapper">
                    <?php if (empty($items)): ?>
                        <div class="alert alert-light border w-100 text-muted"><i class="fas fa-info-circle mr-2"></i> No <?= strtolower($title) ?> posted yet.</div>
                    <?php endif; ?>

                    <?php foreach($items as $post): ?>
                        <div class="card content-card-custom shadow-sm">
                            <?php if (!empty($post['image'])): ?>
                                <img src="<?= base_url('assets/uploads/post/' . htmlspecialchars($post['image'])) ?>" class="card-img-top" alt="post">
                            <?php else: ?>
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height:160px; border-radius: 12px 12px 0 0;">
                                    <i class="fas fa-image fa-3x text-light"></i>
                                </div>
                            <?php endif; ?>
                            
                            <div class="card-body d-flex flex-column p-3">
                                <h6 class="font-weight-bold mb-1 text-truncate" title="<?= htmlspecialchars($post['title']) ?>">
                                    <?= htmlspecialchars($post['title']) ?>
                                </h6>
                                <p class="small text-muted mb-3" style="height: 40px; overflow: hidden;">
                                    <?= strip_tags($post['content']) ?>
                                </p>
                                
                                <div class="mt-auto pt-2 border-top">
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-link btn-sm text-maroon p-0 font-weight-bold" data-toggle="modal" data-target="#viewPostModal_<?= $post['id'] ?>">View Details</button>
                                        <div>
                                            <button class="btn btn-link btn-sm text-dark p-0 mr-2" data-toggle="modal" data-target="#editPostModal_<?= $post['id'] ?>"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-link btn-sm text-danger p-0" data-toggle="modal" data-target="#deletePostModal_<?= $post['id'] ?>"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
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
            <form action="<?= base_url('AdminPost/upload_carousel') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-images mr-2"></i> Manage Homepage Carousel</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body p-4">
                    <label class="font-weight-bold small text-muted">SELECT NEW IMAGE TO UPLOAD</label>
                    <div class="input-group mb-2">
                        <div class="custom-file">
                            <input type="file" name="carousel_photo" class="custom-file-input" id="carouselInput" required>
                            <label class="custom-file-label" for="carouselInput">Choose file</label>
                        </div>
                    </div>
                    <small class="text-muted d-block mb-4">Recommended aspect ratio: 16:9 for banners.</small>
                    
                    <hr>
                    
                    <h6 class="font-weight-bold small text-muted mb-3 uppercase">Currently Uploaded Carousel Photos</h6>
                    <div class="row">
                        <?php 
                        // Assuming $carousel_images is passed from controller
                        if(!empty($carousel_images)): 
                            foreach($carousel_images as $img): ?>
                            <div class="col-md-4">
                                <div class="carousel-preview-card">
                                    <div class="carousel-img-wrap">
                                        <img src="<?= base_url('assets/uploads/carousel/'.$img['file_name']) ?>" alt="carousel">
                                    </div>
                                    <a href="<?= base_url('AdminPost/delete_carousel/'.$img['id']) ?>" class="btn-delete-photo" onclick="return confirm('Delete this image?')">
                                        <i class="fas fa-times mr-1"></i> Delete
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; else: ?>
                            <div class="col-12"><p class="text-muted small">No images uploaded yet.</p></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info px-4 shadow-sm"><i class="fas fa-upload mr-1"></i> Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="createPostModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="<?= base_url('AdminPost/create') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-pencil-alt mr-2"></i> Create New Post</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body p-4">
                    <div class="form-group">
                        <label class="font-weight-bold small text-muted">TITLE</label>
                        <input type="text" name="title" class="form-control" placeholder="Post heading" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold small text-muted">BODY CONTENT</label>
                        <textarea name="content" class="form-control" rows="6" placeholder="Write your post here..." required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold small text-muted">POST CATEGORY</label>
                                <select name="post_type" class="form-control" required>
                                    <option value="announcements">Announcement</option>
                                    <option value="news">News</option>
                                    <option value="stories">Alumni Story</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold small text-muted">TARGET BATCH</label>
                                <input type="text" name="recipient_batch" class="form-control" value="ALL" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold small text-muted">FEATURED IMAGE</label>
                        <input type="file" name="image" class="form-control-file">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">Cancel</button>
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
    function scrollCarousel(wrapperId, direction) {
        const wrapper = document.getElementById(wrapperId);
        if (!wrapper) return;
        const scrollAmount = 320; 
        wrapper.scrollBy({ left: direction * scrollAmount, behavior: 'smooth' });
    }

    // Update label when file is selected
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
</script>
</body>
</html>
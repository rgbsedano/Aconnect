<style>
    .post-card {
        height: 300px; /* Fixed card height */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        overflow: hidden;
    }

    .post-content {
        flex-grow: 1;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .read-more {
        text-align: right;
        font-size: 14px;
    }

    .read-more a {
        text-decoration: underline;
        cursor: pointer;
        color: #700A0A;
    }

    .carousel-control-prev,
    .carousel-control-next {
        filter: invert(1);
    }

    .carousel-navigation {
        text-align: center;
        margin-top: 10px;
    }

    .carousel-navigation .btn {
        background-color: #700A0A;
        color: white;
    }

    /* New Footer for Cards */
    .post-card-footer {
        margin-top: auto;
        font-size: 12px;
        text-align: right;
        color: #555;
    }

    .post-card-footer .date {
        margin-bottom: 10px;
    }

    .post-card-footer .read-more {
        margin-top: 10px;
    }

    /* Footer styles */
    footer {
        background-color: #f8f9fa;
        padding: 20px 0;
        text-align: center;
        font-size: 14px;
    }
</style>

<div class="container-fluid">
        <?php $photos = $this->db->get('carousel_photos')->result_array(); ?>

        <?php if (!empty($photos)): ?>
        <div class="container my-4">
        <div id="carouselExample" class="carousel slide carousel-fade shadow rounded" data-ride="carousel" style="max-width: 768px; margin: 0 auto;">

            <!-- Indicators -->
            <ol class="carousel-indicators">
            <?php foreach ($photos as $index => $photo): ?>
                <li data-target="#carouselExample" data-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : '' ?>"></li>
            <?php endforeach; ?>
            </ol>

            <!-- Slides -->
            <div class="carousel-inner rounded">
            <?php foreach ($photos as $index => $photo): ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                <img src="<?= base_url('assets/uploads/carousel/' . $photo['file_name']) ?>" 
                    class="d-block w-100" 
                    alt="Slide <?= $index + 1 ?>" 
                    style="height: 400px; object-fit: fill; border-radius: 10px;">
                </div>
            <?php endforeach; ?>
            </div>

            <!-- Controls -->
            <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
            </a>

        </div>
        </div>
        <?php endif; ?>

        <div class="container">
    <?php foreach ($grouped_posts as $type => $posts): ?>
        <div class="mb-4">
            <h3 class="mb-3" style="color: #700A0A"><b><?= ucfirst($type) ?></b></h3>
            <?php if (!empty($posts)): ?>
                <div id="<?= $type ?>Carousel" class="carousel slide" data-ride="carousel" data-interval="false">
                    <div class="carousel-inner">
                        <?php
                        $chunks = array_chunk($posts, 3);
                        foreach ($chunks as $chunkIndex => $chunk): ?>
                            <div class="carousel-item <?= $chunkIndex === 0 ? 'active' : '' ?>">
                                <div class="row">
                                    <?php foreach ($chunk as $post): ?>
                                        <div class="col-md-4 mb-3">
                                            <div class="post-card h-100">
                                                <h5><b><?= $post->title ?></b></h5>
                                                <div class="post-content"><?= word_limiter(strip_tags($post->content), 20) ?></div>
                                                
                                                <!-- Footer with date and Read More -->
                                                <div class="post-card-footer">
                                                    <div class="date">Posted on: <?= date('F j, Y, g:i a', strtotime($post->created_at)) ?></div>
                                                    <div class="read-more">
                                                        <a href="#" data-toggle="modal" data-target="#postModal<?= $post->id ?>">Read more</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Read More Modal -->
                                        <div class="modal fade" id="postModal<?= $post->id ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"><?= $post->title ?></h5>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <?php if ($post->image): ?>
                                                            <img src="<?= base_url('assets/uploads/post/' . $post->image) ?>" alt="<?= $post->title ?>" class="img-fluid mb-3" />
                                                        <?php endif; ?>
                                                        <p><?= $post->content ?></p>
                                                        <p><small>Posted on: <?= date('F j, Y, g:i a', strtotime($post->created_at)) ?></small></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Navigation Controls (Bottom) -->
                    <?php if (count($chunks) > 1): ?>
                        <div class="carousel-navigation">
                            <a class="btn btn-prev" href="#<?= $type ?>Carousel" role="button" data-slide="prev">Previous</a>
                            <a class="btn btn-next" href="#<?= $type ?>Carousel" role="button" data-slide="next">Next</a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <p>No <?= $type ?> posts available.</p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

<!-- Footer Section -->
<footer>
    <p>&copy; 2025 Aconnect. All rights reserved.</p>
</footer>

<!-- Scroll Script -->
<script>
  function scrollCarousel(direction) {
    const container = document.getElementById('cardCarousel');
    const cardWidth = container.querySelector('.flex-shrink-0').offsetWidth;
    container.scrollBy({
      left: direction * cardWidth,
      behavior: 'smooth'
    });
  }
</script>

</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<style>
.fixed-card {
  height: 220px; /* adjust based on your content */
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.card-body {
  overflow: hidden;
}

.card-title {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.card-text {
  max-height: 120px;
  overflow: hidden;
  text-overflow: ellipsis;
}

.card-deck .card {
  min-width: 300px;
}
.carousel-inner .carousel-item {
  display: flex;
}
.carousel-control-prev-icon,
.carousel-control-next-icon {
  background-color: rgba(0, 0, 0, 0.5);
  border-radius: 50%;
}
.carousel-inner .carousel-item {
  display: flex;
  justify-content: center;
}
.card {
  width: 100%;
  max-width: 300px;
}
</style>

<div class="container-fluid"></div>

<div class="container mt-5">
<h2 class="mb-4">Manage Post</h2>
<!-- Create Post Button -->
<button class="btn btn-primary mb-4" data-toggle="modal" data-target="#createPostModal" style="background: #700A0A">+ Create Post</button>
<!-- Add Photos Button -->
<button class="btn btn-primary mb-4" data-toggle="modal" data-target="#uploadCarouselModal" style="background: #700A0A">+ Add Photos</button>


<!-- Create Post Modal -->
<div class="modal fade" id="createPostModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="<?= base_url('AdminPost/create') ?>" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Create Post</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
              <label>Title</label>
              <input type="text" name="title" class="form-control" required>
          </div>
          <div class="form-group">
              <label>Content</label>
              <textarea name="content" class="form-control" rows="4" required></textarea>
          </div>
          <div class="form-group">
              <label>Post Type</label>
              <select name="post_type" class="form-control" required>
                  <option value="announcements">Announcement</option>
                  <option value="news">News</option>
                  <option value="stories">Story</option>
              </select>
          </div>
          <div class="form-group">
              <label>Recipient Batch (comma-separated)</label>
              <input type="text" name="recipient_batch" class="form-control" placeholder="e.g. 2015,2016,2017" required>
          </div>
          <div class="form-group">
              <label>Attach Image</label>
              <input type="file" name="image" class="form-control-file" accept="image/*">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Post</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadCarouselModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document"> <!-- modal-lg for wider photo display -->
    <form action="<?= base_url('AdminPost/upload') ?>" method="post" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Upload Carousel Image</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
          <!-- Upload Input -->
          <div class="form-group">
            <label>Select Image (jpg, png, gif):</label>
            <input type="file" name="carousel_photo" class="form-control" required>
          </div>

          <!-- Uploaded Photos -->
          <div class="mt-4">
            <h6 class="mb-2">Uploaded Photos:</h6>
            <div class="row">
              <?php 
              $photos = $this->db->get('carousel_photos')->result_array();
              foreach ($photos as $photo): ?>
                <div class="col-md-4 mb-3">
                  <div class="card shadow-sm">
                    <img src="<?= base_url('assets/uploads/carousel/' . $photo['file_name']) ?>" 
                         class="card-img-top" 
                         style="height: 150px; object-fit: cover; border-radius: 5px;" 
                         alt="Uploaded Image">
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Upload</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>

      </div>
    </form>
  </div>
</div>


<h2>📢 Announcements</h2>
<div class="position-relative">
  <div class="d-flex overflow-hidden" id="announcementWrapper" style="scroll-behavior: smooth;">
    <?php foreach ($announcements as $post): ?>
      <div class="card mx-2 shadow-sm" style="min-width: 300px; max-width: 300px; flex: none;">
        <div class="card-body">
          <h5 class="card-title"><b><?= $post['title'] ?></b></h5>
          <p class="card-text"><?= word_limiter(strip_tags($post['content']), 20) ?></p>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Custom Prev/Next buttons -->
  <button class="btn btn-light position-absolute" style="top: 40%; left: -20px; background-color: gray; color: white;" onclick="scrollCarousel('announcementWrapper', -1)">‹</button>
  <button class="btn btn-light position-absolute" style="top: 40%; right: -20px; background-color: gray; color: white;" onclick="scrollCarousel('announcementWrapper', 1)">›</button>
</div>

<br>

<h2>📰 News</h2>
<div class="position-relative">
  <div class="d-flex overflow-hidden" id="newsWrapper" style="scroll-behavior: smooth;">
    <?php foreach ($news as $post): ?>
      <div class="card mx-2 shadow-sm" style="min-width: 300px; max-width: 300px; flex: none;">
        <div class="card-body">
          <h5 class="card-title"><b><?= $post['title'] ?></b></h5>
          <p class="card-text"><?= word_limiter(strip_tags($post['content']), 20) ?></p>

        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Custom Prev/Next buttons -->
  <button class="btn btn-light position-absolute" style="top: 40%; left: -20px; background-color: gray; color: white;" onclick="scrollCarousel('newsWrapper', -1)">‹</button>
  <button class="btn btn-light position-absolute" style="top: 40%; right: -20px; background-color: gray; color: white;" onclick="scrollCarousel('newsWrapper', 1)">›</button>
</div>

<br>

<h2>📖 Stories</h2>
<div class="position-relative">
  <div class="d-flex overflow-hidden" id="storiesWrapper" style="scroll-behavior: smooth;">
    <?php foreach ($stories as $post): ?>
      <div class="card mx-2 shadow-sm" style="min-width: 300px; max-width: 300px; flex: none;">
        <div class="card-body">
          <h5 class="card-title"><b><?= $post['title'] ?></b></h5>
          <p class="card-text"><?= word_limiter(strip_tags($post['content']), 20) ?></p>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Custom Prev/Next buttons -->
  <button class="btn btn-light position-absolute" style="top: 40%; left: -20px; background-color: gray; color: white;" onclick="scrollCarousel('storiesWrapper', -1)">‹</button>
  <button class="btn btn-light position-absolute" style="top: 40%; right: -20px; background-color: gray; color: white;" onclick="scrollCarousel('storiesWrapper', 1)">›</button>
</div>



<script>
function scrollCarousel(wrapperId, direction) {
  const wrapper = document.getElementById(wrapperId);
  const cardWidth = wrapper.querySelector('.card').offsetWidth + 16; // includes margin
  wrapper.scrollBy({ left: direction * cardWidth, behavior: 'smooth' });
}
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
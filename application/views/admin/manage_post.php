<style>
  /* Layout tweaks */
  .card-fixed { min-width: 260px; max-width: 320px; width: 100%; height: 300px; display: flex; flex-direction: column; }
  .card-body-flex { display: flex; flex-direction: column; height: 100%; }
  .card-title { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
  .card-text { overflow: hidden; }
  .card-footer-btns { margin-top: auto; display: flex; gap: .5rem; }

  /* Horizontal scroller */
  .cards-scroller { display: flex; gap: 1rem; overflow-x: auto; padding-bottom: 0.5rem; }
  .cards-scroller::-webkit-scrollbar { height: 8px; }
  .cards-scroller::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.2); border-radius: 4px; }

  .section-wrap { margin-bottom: 2.25rem; }
  .section-title { display: flex; align-items: center; justify-content: space-between; }

  @media (max-width: 576px) {
    .card-fixed { min-width: 220px; height: 320px; }
  }
</style>

<div class="container mt-4">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h2 class="m-0">Manage Posts</h2>
    <div class="d-flex gap-2">
      <button class="btn btn-primary" data-toggle="modal" data-target="#createPostModal" style="background:#700A0A; border: none;">+ Create Post</button>
      <button class="btn btn-outline-secondary" data-toggle="modal" data-target="#uploadCarouselModal">+ Upload Carousel</button>
    </div>
  </div>

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
            <div class="form-row">
              <div class="form-group col-12">
                <label>Title</label>
                <input type="text" name="title" class="form-control" required>
              </div>
              <div class="form-group col-12">
                <label>Content</label>
                <textarea name="content" class="form-control" rows="4" required></textarea>
              </div>
              <div class="form-group col-md-6">
                <label>Post Type</label>
                <select name="post_type" class="form-control" required>
                  <option value="announcements">Announcement</option>
                  <option value="news">News</option>
                  <option value="stories">Story</option>
                </select>
              </div>
              <div class="form-group col-md-6">
                <label>Recipient Batch (comma-separated)</label>
                <input type="text" name="recipient_batch" class="form-control" placeholder="e.g. 2015,2016" required>
              </div>
              <div class="form-group col-12">
                <label>Attach Image</label>
                <input type="file" name="image" class="form-control-file" accept="image/*">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Post</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Upload carousel modal -->
  <div class="modal fade" id="uploadCarouselModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="<?= base_url('AdminPost/upload') ?>" method="post" enctype="multipart/form-data">
          <div class="modal-header">
            <h5 class="modal-title">Upload Carousel Image</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label>Select Image</label>
              <input type="file" name="carousel_photo" class="form-control-file" required>
            </div>
            <hr>
            <div class="row">
              <?php $photos = $this->db->get('carousel_photos')->result_array(); ?>
              <?php if (empty($photos)): ?>
                <div class="col-12">No uploaded photos yet.</div>
              <?php else: ?>
                <?php foreach($photos as $p): ?>
                  <div class="col-4 mb-3">
                    <div class="card">
                      <img src="<?= base_url('assets/uploads/carousel/' . $p['file_name']) ?>" class="card-img-top" style="height:120px; object-fit:cover;" alt="carousel">
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Upload</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Section renderer function -->
  <?php function render_section($title, $items, $type) { ?>
    <div class="section-wrap">
      <div class="section-title mb-2">
        <h4><?= $title ?></h4>
      </div>

      <div class="cards-scroller" id="<?= $type ?>Wrapper">
        <?php if (empty($items)): ?>
          <div class="text-muted">No <?= strtolower($title) ?> yet.</div>
        <?php endif; ?>

        <?php foreach($items as $post): ?>
          <?php $safe_title = htmlspecialchars($post['title']); $safe_content = htmlspecialchars($post['content']); ?>

          <div class="card card-fixed card-fixed shadow-sm card-fixed d-flex flex-column">
            <?php if (!empty($post['image'])): ?>
              <img src="<?= base_url('assets/uploads/post/' . $post['image']) ?>" style="height:120px; object-fit:cover;" class="card-img-top" alt="post-image">
            <?php endif; ?>

            <div class="card-body card-body-flex">
              <h5 class="card-title"><b><?= $safe_title ?></b></h5>
              <p class="card-text"><?= word_limiter(strip_tags($post['content']), 25) ?></p>

              <div class="card-footer-btns mt-auto">
                <button class="btn btn-sm btn-outline-info" data-toggle="modal" data-target="#viewPostModal_<?= $post['id'] ?>">View</button>
                <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editPostModal_<?= $post['id'] ?>">Edit</button>
                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deletePostModal_<?= $post['id'] ?>">Delete</button>
              </div>
            </div>
          </div>

          <!-- VIEW modal -->
          <div class="modal fade" id="viewPostModal_<?= $post['id'] ?>" tabindex="-1">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title"><?= $safe_title ?></h5>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                  <?php if (!empty($post['image'])): ?>
                    <img src="<?= base_url('assets/uploads/post/' . $post['image']) ?>" class="img-fluid mb-3" alt="post-image">
                  <?php endif; ?>
                  <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                  <p class="text-muted">Recipient batch: <?= htmlspecialchars($post['recipient_batch']) ?></p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

          <!-- EDIT modal -->
          <div class="modal fade" id="editPostModal_<?= $post['id'] ?>" tabindex="-1">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <form action="<?= base_url('AdminPost/update/' . $post['id']) ?>" method="post" enctype="multipart/form-data">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Post</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <div class="modal-body">
                    <div class="form-group">
                      <label>Title</label>
                      <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($post['title']) ?>" required>
                    </div>
                    <div class="form-group">
                      <label>Content</label>
                      <textarea name="content" class="form-control" rows="6" required><?= htmlspecialchars($post['content']) ?></textarea>
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
                        <div class="mt-2"><img src="<?= base_url('assets/uploads/post/' . $post['image']) ?>" width="140" class="img-thumbnail"></div>
                      <?php endif; ?>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- DELETE modal -->
          <div class="modal fade" id="deletePostModal_<?= $post['id'] ?>" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <form action="<?= base_url('AdminPost/delete/' . $post['id']) ?>" method="post">
                  <div class="modal-header">
                    <h5 class="modal-title">Delete Post</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <div class="modal-body">
                    <p>Are you sure you want to delete this post?</p>
                    <p><strong><?= htmlspecialchars($post['title']) ?></strong></p>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

        <?php endforeach; ?>
      </div>

      <div class="mt-2 d-flex justify-content-between">
        <button class="btn btn-sm btn-light" onclick="scrollCarousel('<?= $type ?>Wrapper', -1)">‹</button>
        <button class="btn btn-sm btn-light" onclick="scrollCarousel('<?= $type ?>Wrapper', 1)">›</button>
      </div>

    </div>
  <?php } ?>

  <!-- Render each section -->
  <?php render_section('Announcements', $announcements, 'announcements'); ?>
  <?php render_section('News', $news, 'news'); ?>
  <?php render_section('Stories', $stories, 'stories'); ?>

</div>

<script>
  function scrollCarousel(wrapperId, direction) {
    const wrapper = document.getElementById(wrapperId);
    if (!wrapper) return;
    const card = wrapper.querySelector('.card');
    const gap = parseInt(getComputedStyle(wrapper).gap) || 16;
    const cardWidth = (card ? card.offsetWidth : 300) + gap;
    wrapper.scrollBy({ left: direction * cardWidth, behavior: 'smooth' });
  }
</script>


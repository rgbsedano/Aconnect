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

/* ================= WRAPPER ================= */
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

/* ================= HEADER ================= */
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


/* ================= SWITCHER ================= */
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

/* ================= CARD ================= */
.main-card {
    background: var(--card-bg);
    border-radius: var(--border-radius);
    padding: 30px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    border: 1px solid #f1f5f9;
    margin-bottom: 30px;
}

/* ================= TABLE ================= */
.custom-table { width: 100%; border-collapse: separate; border-spacing: 0 10px; }

.custom-table th {
    padding: 12px 20px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    color: var(--text-muted);
    border: none;
}

.custom-table tr.data-row {
    background: white;
    transition: var(--transition);
}

.custom-table tr.data-row:hover {
    transform: scale(1.005);
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.custom-table td {
    padding: 16px 20px;
    vertical-align: middle;
    border-top: 1px solid #f1f5f9;
    border-bottom: 1px solid #f1f5f9;
}

.custom-table td:first-child {
    border-left: 1px solid #f1f5f9;
    border-top-left-radius: 14px;
    border-bottom-left-radius: 14px;
}

.custom-table td:last-child {
    border-right: 1px solid #f1f5f9;
    border-top-right-radius: 14px;
    border-bottom-right-radius: 14px;
}

.post-title-cell {
    font-weight: 700;
    color: var(--text-main);
    font-size: 15px;
}

.post-type-label {
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    color: var(--accent-red);
    background: #fef2f2;
    padding: 2px 8px;
    border-radius: 6px;
}

/* ================= ACTION BUTTONS ================= */
.btn-action {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #f8fafc;
    color: var(--text-muted);
    border: 1px solid #e2e8f0;
    transition: var(--transition);
    margin-left: 5px;
}

.btn-action:hover {
    background: var(--accent-red);
    color: white;
    border-color: var(--accent-red);
    transform: translateY(-2px);
}

.btn-action.delete:hover {
    background: #ef4444;
    border-color: #ef4444;
}

/* ================= MODAL ================= */
.modal-content {
    border-radius: 24px;
    border: none;
    overflow: hidden;
}

.modal-header {
    background: var(--accent-red);
    color: white;
    padding: 25px;
    border: none;
}

.modal-body { padding: 30px; }

/* ⭐⭐⭐ MAIN FIX — PUSH MODAL DOWN FOR TOP MENU ⭐⭐⭐ */
.modal-dialog {
    margin-top: 10vh !important;   /* 🔥 10% screen height */
    margin-bottom: 40px !important;
}

/* ================= FORM ================= */
.form-label {
    font-size: 11px;
    font-weight: 700;
    color: var(--text-muted);
    text-transform: uppercase;
    margin-bottom: 8px;
    display: block;
}

.form-input {
    border-radius: 12px;
    padding: 12px;
    font-size: 14px;
    font-weight: 500;
    border: 1px solid #e2e8f0;
}

.form-input:focus {
    border-color: var(--accent-red);
    box-shadow: 0 0 0 4px rgba(112, 10, 10, 0.05);
}

/* ================= CAROUSEL GRID ================= */
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
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
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

/* ================= RESPONSIVE ================= */
@media (min-width: 992px) {
    .modal-wide { max-width: 950px !important; }
    .modal-adaptive { max-width: 650px !important; }
}

@media (max-width: 768px) {
    .header-section {
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
    }

    .header-section .actions {
        width: 100%;
        display: flex;
        gap: 10px;
    }

    .header-section .actions .btn {
        flex: 1;
        margin: 0 !important;
    }

    .switcher-wrapper { width: 100%; }
    .switch-btn { flex: 1; text-align: center; }

    /* ⭐ mobile modal spacing */
    .modal-dialog {
        margin-top: 12vh !important;
        margin-left: 12px;
        margin-right: 12px;
        margin-bottom: 30px !important;
    }

    .modal-content { border-radius: 20px; }
    .modal-body { padding: 20px; }
    .modal-header { padding: 20px; }
}

.modal-dialog{
    margin-top: 10vh !important;
}

/* ===== PREMIUM HEADER BUTTONS ===== */
.header-actions{
    display:flex;
    gap:12px;
}

.btn-create{
    background:linear-gradient(135deg,#7f1d1d,#991b1b);
    border:none;
    color:#fff;
    border-radius:14px;
    font-weight:700;
    padding:10px 22px;
    box-shadow:0 6px 18px rgba(112,10,10,.25);
    transition:.25s ease;
}
.btn-create:hover{
    transform:translateY(-2px);
    color:#fff;
}

.btn-carousel{
    background:rgba(255,255,255,.12);
    border:1px solid rgba(255,255,255,.35);
    color:#fff;
    border-radius:14px;
    font-weight:600;
    padding:10px 20px;
    backdrop-filter:blur(6px);
}
.btn-carousel:hover{
    background:rgba(255,255,255,.22);
    color:#fff;
}

/* ===== INPUT FIX ===== */
.form-control,
.form-input{
    min-height:44px;
    padding:12px 14px;
    font-size:14px;
}

textarea.form-control{
    min-height:120px;
    resize:vertical;
}
.modal-wide{
    max-width:950px !important;
}
</style>


<div class="dashboard-wrapper">

<header class="header-section">
    <div>
        <h1>Alumni <span>Content</span></h1>
        <p>Publish announcements, news, and success stories to the network.</p>
    </div>

    <div class="actions header-actions">
        <button class="btn btn-create" data-toggle="modal" data-target="#createPostModal">
            <i class="fas fa-plus mr-2"></i>Create Post
        </button>

        <button class="btn btn-carousel" data-toggle="modal" data-target="#uploadCarouselModal">
            <i class="fas fa-images mr-2"></i>Carousel
        </button>
    </div>
</header>

<!-- ===== SWITCHER ===== -->
<div class="switcher-wrapper">
    <button class="switch-btn active" onclick="switchCategory('announcements')">Announcements</button>
    <button class="switch-btn" onclick="switchCategory('news')">Campus News</button>
    <button class="switch-btn" onclick="switchCategory('stories')">Alumni Stories</button>
</div>

<!-- ===== TABLE ===== -->
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

<tbody>

<?php 
$all_posts = array_merge(
    array_map(function($p){ $p['type_label']='Announcement'; return $p; }, $announcements),
    array_map(function($p){ $p['type_label']='Campus News'; return $p; }, $news),
    array_map(function($p){ $p['type_label']='Success Story'; return $p; }, $stories)
);
?>

<?php foreach($all_posts as $post): ?>
<tr class="data-row post-item"
    data-type="<?= $post['post_type'] ?>"
    style="<?= $post['post_type']=='announcements'?'':'display:none;' ?>">

<td>
<div class="post-title-cell"
     onclick='reviewDetails(<?= json_encode($post) ?>)'
     style="cursor:pointer;">
<?= htmlspecialchars($post['title']) ?>
</div>
<span class="post-type-label"><?= $post['type_label'] ?></span>
</td>

<td><?= date('M d, Y', strtotime($post['created_at'])) ?></td>

<td class="text-right">
<button onclick='editPost(<?= json_encode($post) ?>)' class="btn-action">
<i class="fas fa-pen"></i>
</button>

<button onclick="deletePost(<?= $post['id'] ?>)" class="btn-action delete">
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

<!-- ================= CREATE MODAL ================= -->
<div class="modal fade" id="createPostModal">
<div class="modal-dialog modal-adaptive">
<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title"><i class="fas fa-plus mr-2"></i>New Content Post</h5>
<button type="button" class="close text-white" data-dismiss="modal">&times;</button>
</div>

<form method="POST" action="<?= base_url('AdminPost/create') ?>" enctype="multipart/form-data">
<div class="modal-body">

<label>Category</label>
<select name="post_type" class="form-control mb-3" required>
<option value="">Select Category...</option>
<option value="announcements">Official Announcement</option>
<option value="news">Campus News</option>
<option value="stories">Alumni Story</option>
</select>

<label>Post Title</label>
<input type="text" name="title" class="form-control mb-3" required>

<label>Content</label>
<textarea name="content" class="form-control mb-3" required></textarea>

<label>Cover Image</label>
<input type="file" name="image" class="form-control">

</div>

<div class="modal-footer">
<button type="submit" class="btn btn-danger">Publish Now</button>
</div>
</form>

</div>
</div>
</div>

<!-- ================= EDIT MODAL ================= -->
<div class="modal fade" id="editPostModal">
<div class="modal-dialog modal-adaptive">
<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title"><i class="fas fa-edit mr-2"></i>Update Post</h5>
<button type="button" class="close text-white" data-dismiss="modal">&times;</button>
</div>

<form method="POST" id="editPostForm" enctype="multipart/form-data">
<div class="modal-body">

<label>Category</label>
<select name="post_type" id="edit_post_type" class="form-control mb-3"></select>

<label>Title</label>
<input type="text" name="title" id="edit_title" class="form-control mb-3">

<label>Content</label>
<textarea name="content" id="edit_content" class="form-control mb-3"></textarea>

<label>Replace Image</label>
<input type="file" name="image" class="form-control">

</div>

<div class="modal-footer">
<button type="submit" class="btn btn-danger">Update Changes</button>
</div>
</form>

</div>
</div>
</div>


<!-- ================= VIEW POST MODAL ================= -->
<div class="modal fade" id="viewPostModal">
<div class="modal-dialog modal-wide">
<div class="modal-content">

<div class="modal-header">
    <div>
        <span id="view_post_type" class="post-type-label mb-1"></span>
        <h4 id="view_title" class="modal-title m-0"></h4>
    </div>
    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
</div>

<div class="modal-body">

    <!-- IMAGE -->
    <div id="view_image_container"
         class="mb-4 text-center"
         style="display:none;">
        <img id="view_image"
             class="img-fluid"
             style="border-radius:16px;max-height:400px;object-fit:cover;">
    </div>

    <!-- CONTENT -->
    <div id="view_content"
         style="font-size:15px;line-height:1.8;white-space:pre-wrap;
                padding:20px;background:#f8fafc;border-radius:16px;">
    </div>

</div>

<div class="modal-footer">
    <button class="btn btn-secondary" data-dismiss="modal">
        Close
    </button>
</div>

</div>
</div>
</div>


<!-- ================= CAROUSEL MODAL ================= -->
<div class="modal fade" id="uploadCarouselModal">
<div class="modal-dialog modal-adaptive">
<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title"><i class="fas fa-images mr-2"></i>Carousel Manager</h5>
<button type="button" class="close text-white" data-dismiss="modal">&times;</button>
</div>

<div class="modal-body">
<!-- ===== CAROUSEL GRID ===== -->
<div class="carousel-grid mb-4">

<?php foreach($carousel as $item): ?>
<div class="carousel-item-card">

    <img src="<?= base_url('assets/uploads/carousel/' . $item['file_name']) ?>" alt="Carousel">

    <!-- DELETE BUTTON -->
    <button onclick="deleteCarousel(<?= $item['id'] ?>)"
            class="delete-carousel-btn">
        <i class="fas fa-times"></i>
    </button>

    <!-- EDIT TEXT BUTTON -->
    <div class="mt-2 text-center">
        <button type="button"
                onclick='editCarousel(<?= json_encode($item) ?>)'
                class="btn btn-sm btn-link text-danger p-0"
                style="font-size:11px;font-weight:700;">
            EDIT TEXT
        </button>
    </div>

</div>
<?php endforeach; ?>

</div>


<form method="POST"
      id="carouselForm"
      action="<?= base_url('AdminPost/upload') ?>"
      enctype="multipart/form-data">

<label>Banner Title</label>
<input type="text" name="title" id="carouselTitle" class="form-control mb-3">

<label>Banner Image</label>
<input type="file" name="carousel_photo" class="form-control mb-3">

<label>Description</label>
<textarea name="description" id="carouselDescription" class="form-control mb-3"></textarea>

<div class="text-right">
<button type="button" id="resetCarouselForm" class="btn btn-light mr-2" style="display:none;">
Reset
</button>

<button type="submit" id="carouselSubmitBtn" class="btn btn-danger">
Upload Banner
</button>
</div>

</form>

</div>
</div>
</div>
</div>

<!-- ================= SCRIPTS ================= -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function switchCategory(type){
    $('.switch-btn').removeClass('active');
    $(`.switch-btn[onclick="switchCategory('${type}')"]`).addClass('active');
    $('.post-item').hide();
    $(`.post-item[data-type="${type}"]`).fadeIn(200);
}

function editPost(post){
    $('#edit_post_type').html(`
        <option value="announcements">Announcements</option>
        <option value="news">Campus News</option>
        <option value="stories">Alumni Stories</option>
    `);

    $('#edit_post_type').val(post.post_type);
    $('#edit_title').val(post.title);
    $('#edit_content').val(post.content);

    $('#editPostForm').attr(
        'action',
        '<?= base_url("AdminPost/update/") ?>'+post.id
    );

    $('#editPostModal').modal('show');
}
function editCarousel(item){

    $('#carouselTitle').val(item.title);
    $('#carouselDescription').val(item.description);

    $('#carouselForm').attr(
        'action',
        '<?= base_url("AdminPost/update_carousel/") ?>' + item.id
    );

    $('#carouselSubmitBtn').text('Save Changes');
    $('#resetCarouselForm').show();

    // 🔥 auto scroll to form (nice UX)
    $('#carouselTitle').focus();
}

function deletePost(id){
    if(confirm("Delete this post?")){
        window.location.href='<?= base_url("AdminPost/delete/") ?>'+id;
    }
}

function deleteCarousel(id){
    if(confirm("Delete this banner?")){
        window.location.href='<?= base_url("AdminPost/delete_carousel/") ?>'+id;
    }
}

function reviewDetails(post){

    $('#view_title').text(post.title);
    $('#view_post_type').text(post.type_label);
    $('#view_content').text(post.content);

    // image handling
    if(post.image && post.image !== ''){
        $('#view_image')
            .attr('src','<?= base_url("assets/uploads/post/") ?>'+post.image);
        $('#view_image_container').show();
    }else{
        $('#view_image_container').hide();
    }

    $('#viewPostModal').modal('show');
}


$('#resetCarouselForm').click(function(){
    $('#carouselForm')[0].reset();
    $('#carouselSubmitBtn').text('Upload Banner');
    $(this).hide();
});
</script>

<?php if($this->session->flashdata('success')): ?>
<script>
Swal.fire({icon:'success',title:'Success',text:'<?= $this->session->flashdata('success') ?>',timer:2000,showConfirmButton:false});
</script>
<?php endif; ?>
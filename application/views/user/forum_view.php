<div class="container mt-4" style="max-width:900px;">


<div class="card mb-4">

<div class="card-body">

<h4><?= htmlspecialchars($post->title) ?></h4>

<div class="text-muted small mb-3">

<div class="text-muted small mb-2">

<strong>
<?= $post->is_anonymous ? "Anonymous" : $post->first_name." ".$post->last_name ?>
</strong>

•

<?= date("M d, Y h:i A", strtotime($post->created_at)) ?>

</div>

</div>


<p><?= $post->content ?></p>


<?php if($post->image): ?>

<img src="<?= base_url('assets/uploads/forum/'.$post->image) ?>"
style="max-width:100%;border-radius:6px">

<?php endif; ?>


<hr>


<a href="<?= base_url('forum/like/'.$post->id) ?>" class="btn btn-outline-primary btn-sm">
👍 Like
</a>


<a href="<?= base_url('forum/report/'.$post->id) ?>" class="btn btn-outline-warning btn-sm">
🚩 Report
</a>


<?php if($this->session->userdata('alumni_id') == $post->alumni_id): ?>

<a href="<?= base_url('forum/delete/'.$post->id) ?>"
onclick="return confirm('Delete this post?')"
class="btn btn-outline-danger btn-sm">

Delete

</a>

<?php endif; ?>

</div>

</div>


<h5>Comments</h5>

<?php foreach($comments as $c): ?>

<?php if($c->parent_id == NULL): ?>

<div class="card mb-2">
<div class="card-body">

<div class="d-flex justify-content-between">

<strong>
<?= $c->is_anonymous ? "Anonymous" : $c->first_name." ".$c->last_name ?>
</strong>

<small class="text-muted">
<?= time_ago($c->created_at) ?>
</small>

</div>

<p class="mb-1"><?= $c->comment ?></p>

<a href="#" class="reply-btn text-primary" data-id="<?= $c->id ?>">
Reply
</a>


<!-- Reply Form -->
<div class="reply-form mt-2" id="reply-form-<?= $c->id ?>" style="display:none;">

<form method="post" action="<?= base_url('forum/comment') ?>">

<input type="hidden" name="post_id" value="<?= $post->id ?>">
<input type="hidden" name="parent_id" value="<?= $c->id ?>">

<textarea name="comment" class="form-control mb-1" placeholder="Write a reply..." required></textarea>

<button class="btn btn-sm btn-danger">
Reply
</button>

</form>

</div>


<!-- SHOW REPLIES -->

<?php foreach($comments as $reply): ?>

<?php if($reply->parent_id == $c->id): ?>

<div class="card mt-2 ml-4">
<div class="card-body p-2">

<div class="d-flex justify-content-between">

<strong>
<?= $reply->is_anonymous ? "Anonymous" : $reply->first_name." ".$reply->last_name ?>
</strong>

<small class="text-muted">
<?= time_ago($reply->created_at) ?>
</small>

</div>

<p class="mb-0"><?= $reply->comment ?></p>

</div>
</div>

<?php endif; ?>

<?php endforeach; ?>


</div>
</div>

<?php endif; ?>

<?php endforeach; ?>



<div class="card mt-3">

<div class="card-body">

<form method="post" action="<?= base_url('forum/comment') ?>">

<input type="hidden" name="post_id" value="<?= $post->id ?>">
<input type="hidden" name="parent_id" value="">

<textarea name="comment"
class="form-control mb-2"
placeholder="Write a comment..."
required></textarea>

<div class="form-check mb-2">

<input type="checkbox" name="anonymous" value="1" class="form-check-input">

<label class="form-check-label">
Comment as Anonymous
</label>

</div>

<button class="btn btn-danger">
Post Comment
</button>

</form>


</div>

</div>


</div>
<script>

document.querySelectorAll('.reply-btn').forEach(btn => {

    btn.addEventListener('click', function(e){

        e.preventDefault();

        let id = this.dataset.id;
        let form = document.getElementById('reply-form-'+id);

        form.style.display = form.style.display === 'none' ? 'block' : 'none';

    });

});

</script>
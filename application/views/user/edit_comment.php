<div class="container mt-4" style="max-width:600px;">

<h4>Edit Comment</h4>

<form method="post" action="<?= base_url('forum/update_comment') ?>">

<input type="hidden" name="comment_id" value="<?= $comment->id ?>">
<input type="hidden" name="post_id" value="<?= $comment->post_id ?>">

<textarea name="comment"
class="form-control"
rows="4"
required><?= $comment->comment ?></textarea>

<button class="btn btn-danger mt-3">
Update Comment
</button>

</form>

</div>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

:root {
    --brand-red: #BE123C;
    --brand-red-dark: #881337;
    --brand-red-light: #FFF1F2;
}

body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background-color: #f8fafc;
    background-image: radial-gradient(#e2e8f0 0.5px, transparent 0.5px);
    background-size: 24px 24px;
}

/* ── Page Header ── */
.forum-header-bar {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    position: fixed;
    top: 55px; /* Exactly at the bottom of 55px nav */
    left: 0;
    right: 0;
    width: 100%;
    z-index: 999;
}

/* ── Layout ── */
.view-layout {
    max-width: 1185px;
    margin: 64px auto 0; /* Adjusted for fixed header height approx 64px */
    padding: 32px 25px 80px;
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 28px;
}

@media (max-width: 900px) {
    .view-layout { grid-template-columns: 1fr; }
    .forum-sidebar { display: none; }
}

/* ── Post card ── */
.post-view-card {
    background: #fff;
    border-radius: 24px;
    border: 1px solid #e8ecf0;
    overflow: hidden;
    margin-bottom: 24px;
    box-shadow: 0 4px 20px -8px rgba(0,0,0,.08);
}

.post-view-vote {
    background: #f8fafc;
    border-bottom: 1px solid #f1f5f9;
    display: flex; align-items: center; gap: 12px;
    padding: 14px 24px;
}
.vote-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 7px 16px; border-radius: 20px;
    font-size: 13px; font-weight: 800; cursor: pointer;
    border: none; transition: all .2s; text-decoration: none;
}
.vote-btn-like {
    background: #fef2f2; color: var(--brand-red);
}
.vote-btn-like:hover { background: var(--brand-red); color: #fff; text-decoration: none; }
.vote-btn-report {
    background: #f8fafc; color: #94a3b8; margin-left: auto;
}
.vote-btn-report:hover { background: #fff7ed; color: #fb923c; text-decoration: none; }
.vote-btn-delete {
    background: #fff1f2; color: #f43f5e;
}
.vote-btn-delete:hover { background: #f43f5e; color: #fff; text-decoration: none; }

.post-view-body { padding: 28px 28px 20px; }

.post-view-meta { display: flex; align-items: center; gap: 10px; margin-bottom: 16px; flex-wrap: wrap; }
.post-view-avatar {
    width: 40px; height: 40px; border-radius: 50%;
    border: 2px solid #f1f5f9; background: #f1f5f9;
    display: flex; align-items: center; justify-content: center;
    font-weight: 800; font-size: 14px; color: var(--brand-red);
    overflow: hidden; flex-shrink: 0;
}
.post-view-author { font-size: 14px; font-weight: 800; color: #0f172a; }
.post-view-time { font-size: 12px; color: #94a3b8; }
.anon-badge {
    background: #f1f5f9; color: #64748b;
    font-size: 10px; font-weight: 700;
    padding: 3px 10px; border-radius: 20px;
    text-transform: uppercase; letter-spacing: .5px;
}

.post-view-title {
    font-size: 26px; font-weight: 800; color: #0f172a;
    line-height: 1.3; margin: 0 0 16px;
}
.post-view-content {
    font-size: 15px; color: #374151; line-height: 1.8;
    margin: 0; white-space: pre-wrap;
    word-break: break-word;
}
.post-view-image {
    width: 100%; max-height: 500px; object-fit: contain;
    background: #f8fafc;
    border-radius: 16px; margin-top: 20px;
    border: 1px solid #e2e8f0;
}

.post-view-stats {
    display: flex; gap: 20px; padding: 14px 28px;
    border-top: 1px solid #f1f5f9;
    background: #fafafa;
}
.pv-stat {
    display: flex; align-items: center; gap: 6px;
    font-size: 13px; font-weight: 700; color: #94a3b8;
}
.pv-stat-likes { color: #f43f5e; }

/* ── Comment Writer ── */
.comment-writer {
    background: #fff; border-radius: 24px; border: 1px solid #e2e8f0;
    padding: 24px; margin-bottom: 24px;
    box-shadow: 0 4px 12px -4px rgba(0,0,0,.06);
}
.comment-textarea {
    width: 100%; border: 1.5px solid #e2e8f0; border-radius: 16px;
    padding: 14px; font-size: 14px; font-weight: 500;
    font-family: inherit; resize: none; outline: none;
    transition: all .2s; color: #0f172a;
}
.comment-textarea:focus {
    border-color: var(--brand-red);
    box-shadow: 0 0 0 4px rgba(190,18,60,.08);
}

/* ── Comment Card ── */
.comment-card {
    background: #fff; border-radius: 20px; border: 1px solid #e8ecf0;
    padding: 20px; margin-bottom: 12px;
}
.comment-header { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
.comment-avatar {
    width: 32px; height: 32px; border-radius: 50%;
    background: #f1f5f9; color: var(--brand-red);
    display: flex; align-items: center; justify-content: center;
    font-weight: 800; font-size: 12px;
}
.comment-author { font-size: 13px; font-weight: 800; color: #0f172a; }
.comment-time { font-size: 11px; color: #94a3b8; }
.comment-body { font-size: 14px; color: #374151; line-height: 1.7; }
</style>

<!-- ── Consistent Page header bar ── -->
<div class="forum-header-bar">
    <div style="max-width:1185px; margin:0 auto; padding:12px 25px; display:flex; align-items:center; justify-content:space-between; gap:16px;">
        <div style="display:flex; align-items:center; gap:12px;">
            <a href="<?= base_url('forum') ?>" style="width:40px;height:40px;background:#f1f5f9;border-radius:14px;display:flex;align-items:center;justify-content:center;color:#64748b;transition:all .2s;text-decoration:none;" onmouseover="this.style.background='#e2e8f0';this.style.color='var(--brand-red)'" onmouseout="this.style.background='#f1f5f9';this.style.color='#64748b'">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M19 12H5M5 12l7 7M5 12l7-7"/></svg>
            </a>
            <div>
                <h1 style="font-size:18px;font-weight:800;color:#0f172a;margin:0;">Discussion Thread</h1>
                <p style="font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.15em;margin:0;">Alumni Community · Forum</p>
            </div>
        </div>
        <a href="<?= base_url('forum') ?>"
            style="background:var(--brand-red);color:#fff;border:none;border-radius:14px;padding:10px 22px;font-weight:800;font-size:13px;display:flex;align-items:center;gap:8px;cursor:pointer;text-decoration:none;box-shadow:0 4px 12px rgba(190,18,60,.25);transition:background .2s;"
            onmouseover="this.style.background='#881337'" onmouseout="this.style.background='var(--brand-red)'">
            Back to Feed
        </a>
    </div>
</div>

<div class="view-layout">

    <!-- ── Main content ── -->
    <?php if($post): ?>
    <div>
        <div class="post-view-card">
            <!-- Action bar -->
            <div class="post-view-vote">
                <a href="<?= base_url('forum/like/'.$post->id) ?>" class="vote-btn vote-btn-like">
                    <svg width="15" height="15" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                    <?= $post->like_count ?> Likes
                </a>
                
                <?php if($this->session->userdata('alumni_id') == $post->alumni_id): ?>
                <a href="<?= base_url('forum/delete/'.$post->id) ?>" class="vote-btn vote-btn-delete"
                   onclick="return confirm('Delete this post permanently?')">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Delete
                </a>
                <?php endif; ?>
            </div>

            <!-- Body -->
            <div class="post-view-body">
                <div class="post-view-meta">
                    <?php if($post->is_anonymous): ?>
                        <div class="post-view-avatar">?</div>
                        <span class="anon-badge">Anonymous</span>
                    <?php else: ?>
                        <?php if($post->profile_image): ?>
                            <div class="post-view-avatar"><img src="<?= base_url('assets/uploads/alumni/'.$post->profile_image) ?>" style="width:100%;height:100%;object-fit:cover;"></div>
                        <?php else: ?>
                            <div class="post-view-avatar"><?= strtoupper(substr($post->first_name,0,1)) ?></div>
                        <?php endif; ?>
                        <span class="post-view-author"><?= htmlspecialchars($post->first_name.' '.$post->last_name) ?></span>
                    <?php endif; ?>
                    <span class="post-view-time">· <?= date('M d, Y · h:i A', strtotime($post->created_at)) ?></span>
                </div>

                <h1 class="post-view-title"><?= htmlspecialchars($post->title) ?></h1>
                <p class="post-view-content"><?= htmlspecialchars($post->content) ?></p>

                <?php if($post->image): ?>
                <img src="<?= base_url('assets/uploads/forum/'.htmlspecialchars($post->image)) ?>"
                     alt="Post image" class="post-view-image">
                <?php endif; ?>
            </div>

            <!-- Stats footer -->
            <div class="post-view-stats">
                <span class="pv-stat pv-stat-likes">
                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                    <?= $post->like_count ?> likes
                </span>
                <span class="pv-stat">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    <?= $post->comment_count ?> comments
                </span>
            </div>
        </div>

        <!-- ── Comment Section ── -->
        <h3 style="font-size:16px;font-weight:800;color:#fff;margin-bottom:16px;">💬 <?= $post->comment_count ?> Comments</h3>

        <div class="comment-writer">
            <form method="post" action="<?= base_url('forum/comment') ?>">
                <input type="hidden" name="post_id" value="<?= $post->id ?>">
                <input type="hidden" name="parent_id" value="">
                <textarea name="comment" class="comment-textarea" rows="3"
                          placeholder="What are your thoughts?" required></textarea>
                <div style="display:flex;align-items:center;justify-content:space-between;margin-top:16px;">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;font-weight:600;color:#64748b;">
                        <input type="checkbox" name="anonymous" value="1" style="accent-color:var(--brand-red);width:15px;height:15px;">
                        Post as Anonymous
                    </label>
                    <button type="submit" class="btn-submit-comment" style="background:var(--brand-red);color:#fff;border:none;border-radius:12px;padding:10px 24px;font-weight:800;font-size:13px;cursor:pointer;">Post Comment</button>
                </div>
            </form>
        </div>

        <?php
        $top_comments = array_filter($comments, fn($c) => $c->parent_id == NULL);
        foreach($top_comments as $c):
        ?>
        <div class="comment-card">
            <div class="comment-header">
                <div class="comment-avatar">
                    <?php if($c->is_anonymous): ?>?<?php else: ?><?= strtoupper(substr($c->first_name,0,1)) ?><?php endif; ?>
                </div>
                <div>
                    <span class="comment-author"><?= $c->is_anonymous ? 'Anonymous' : htmlspecialchars($c->first_name.' '.$c->last_name) ?></span>
                    <span class="comment-time">· <?= time_ago($c->created_at) ?></span>
                </div>
            </div>
            <p class="comment-body"><?= htmlspecialchars($c->comment) ?></p>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- ── Sidebar ── -->
    <div class="forum-sidebar">
        <div class="forum-sidebar-card" style="background:linear-gradient(135deg,var(--brand-red) 0%,#881337 100%);border:none;padding:24px;border-radius:24px;">
            <h3 style="font-size:16px;font-weight:800;color:#fff;margin:0 0 8px;">About Forum</h3>
            <p style="font-size:12px;color:rgba(255,255,255,.8);margin:0 0 16px;line-height:1.6;">Share your experiences, ask for career advice, or just catch up with fellow alumni in this thread.</p>
            <a href="<?= base_url('forum') ?>" style="display:block;text-align:center;background:#fff;color:var(--brand-red);border-radius:12px;padding:10px;font-weight:800;font-size:13px;text-decoration:none;">Jump to Feed</a>
        </div>

        <div style="background:#fff;border:1px solid #e2e8f0;border-radius:24px;padding:24px;margin-bottom:16px;">
            <p style="font-size:11px;font-weight:800;color:#94a3b8;text-transform:uppercase;letter-spacing:1px;margin-bottom:16px;">Thread Guidelines</p>
            <div style="font-size:13px;color:#475569;line-height:1.6;display:flex;flex-direction:column;gap:12px;">
                <p>• Keep discussion constructive</p>
                <p>• Respect diverse opinions</p>
                <p>• Reports are reviewed by admins</p>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
// Scroll smooth to comments if needed
if(window.location.hash === '#comments') {
    document.querySelector('.comment-writer').scrollIntoView({ behavior: 'smooth' });
}
</script>
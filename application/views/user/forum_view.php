<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

:root {
    --brand-red: #a12124;
    --brand-red-dark: #7d181b;
    --brand-red-light: #FFF1F2;
}

body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background-image: url('<?php echo base_url("assets/images/background.png"); ?>');
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
    background: #f1f5f9; color: #475569;
}
.vote-btn-like:hover { background: var(--brand-red); color: #fff; text-decoration: none; }
.vote-btn-like.active { background: #f1f5f9; color: #475569; }
.vote-btn-like.active:hover { background: var(--brand-red); color: #fff; text-decoration: none; }
.vote-btn-dislike {
    background: #f1f5f9;
    color: #475569;
}
.vote-btn-dislike:hover { background: #2563eb; color: #fff; text-decoration: none; }
.vote-btn-dislike.active {
    background: #f1f5f9;
    color: #475569;
    text-decoration: none;
}
.vote-btn-dislike.active:hover { background: #2563eb; color: #fff; text-decoration: none; }
.vote-btn-report {
    background: #f8fafc; color: #94a3b8; margin-left: auto;
}
.vote-btn-report:hover { background: #fff7ed; color: #fb923c; text-decoration: none; }
.vote-btn-delete {
    background: #fff1f2; color: #f43f5e;
}
.vote-btn-delete:hover { background: #f43f5e; color: #fff; text-decoration: none; }
.vote-container { transition: background-color .2s; padding: 8px 12px; border-radius: 8px; }

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

.post-view-stats{
    display:flex;
    align-items:center;
    gap:12px;
    padding:14px 24px;
    border-top:1px solid #f1f5f9;
    background:#fafafa;
}


.post-view-stats a,
.post-view-stats span{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:7px 14px;
    font-size:13px;
    font-weight:700;
    border-radius:20px;
    background:#f1f5f9;
    color:#475569;
    text-decoration:none;
    transition:all .2s;
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
    box-shadow: 0 0 0 4px rgba(161,33,36,.08);
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

/* ── No Comments Empty State ── */
.comments-empty {
    background: #f8fafc;
    border: 1px dashed #e2e8f0;
    border-radius: 16px;
    padding: 48px 24px;
    text-align: center;
    margin-bottom: 24px;
}
.comments-empty svg {
    width: 64px;
    height: 64px;
    margin: 0 auto 16px;
    opacity: 0.3;
}
.comments-empty h4 {
    font-size: 16px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 8px;
}
.comments-empty p {
    font-size: 13px;
    color: #94a3b8;
    margin: 0;
    line-height: 1.5;
}

/* ── Comment Stats Bar ── */
.comment-stats {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 0;
    margin-top: 12px;
    border-top: 1px solid #f1f5f9;
    border-bottom: 1px solid #f1f5f9;
    flex-wrap: wrap;
}
.comment-stats a,
.comment-stats button {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 16px;
    font-size: 12px;
    font-weight: 700;
    border-radius: 20px;
    background: #f1f5f9;
    color: #475569;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all .2s;
}
.comment-stats .vote-btn-like,
.comment-stats .vote-btn-dislike {
    background: #f1f5f9;
    color: #475569;
    padding: 7px 16px;
    font-size: 12px;
}
.comment-stats .vote-btn-like:hover {
    background: var(--brand-red);
    color: #fff;
}
.comment-stats .vote-btn-like.active {
    background: #f1f5f9;
    color: #475569;
}
.comment-stats .vote-btn-like.active:hover {
    background: var(--brand-red);
    color: #fff;
}
.comment-stats .vote-btn-dislike:hover {
    background: #2563eb;
    color: #fff;
}
.comment-stats .vote-btn-dislike.active {
    background: #f1f5f9;
    color: #475569;
}
.comment-stats .vote-btn-dislike.active:hover {
    background: #2563eb;
    color: #fff;
}
.comment-stats .vote-btn-report {
    margin-left: auto;
    background: #f1f5f9;
    color: #94a3b8;
}
.comment-stats .vote-btn-report:hover {
    background: #fff7ed;
    color: #fb923c;
}
.comment-stats .vote-btn-delete {
    background: #f1f5f9;
    color: #646668;
}
.comment-stats .vote-btn-delete:hover {
    background: #f43f5e;
    color: #fff;
}

/* ===== MODAL STYLE ===== */

.modal-dialog{
    margin-top:10vh; /* prevents navbar overlap */
}

.modal-content{
    border-radius:18px;
    border:none;
    box-shadow:0 25px 50px -12px rgba(0,0,0,.15);
    overflow:hidden;
}

/* ===== RED THEME MODAL HEADER ===== */

.modal-header{
    background: linear-gradient(135deg, #a12124 0%, #7d181b 100%);
    color:white;
    border-bottom:none;
    padding:18px 22px;
    border-top-left-radius:18px;
    border-top-right-radius:18px;
}

/* modal title */
.modal-title{
    font-weight:800;
    font-size:18px;
    color:white;
}

/* close button */
.modal-header .close{
    color:white;
    opacity:0.9;
    font-size:22px;
}

.modal-header .close:hover{
    opacity:1;
}
/* report options */
.report-option{
    display:flex;
    align-items:center;
    gap:10px;
    padding:10px 14px;
    border:1px solid #e2e8f0;
    border-radius:10px;
    cursor:pointer;
    transition:all .2s;
    font-size:14px;
    font-weight:600;
    color:#334155;
}

.report-option:hover{
    background:#f8fafc;
    border-color:#a12124;
}

/* selected radio */
.report-option input{
    accent-color:#a12124;
}

/* other textarea */
#other-reason-box{
    border-radius:12px;
    border:1px solid #e2e8f0;
    padding:10px;
    font-size:14px;
}

/* buttons */
.btn-danger{
    background:#a12124;
    border:none;
    border-radius:10px;
    font-weight:700;
    padding:8px 18px;
}

.btn-danger:hover{
    background:#7d181b;
}

.btn-secondary{
    border-radius:10px;
    font-weight:700;
}

/* ── Comment Action Buttons ── */
.reply-btn {
    color: var(--brand-red);
    font-weight: 700;
    font-size: 13px;
    text-decoration: none;
    cursor: pointer;
    transition: all .2s ease;
    padding: 4px 0;
    border: none;
    background: none;
    display: inline;
}
.reply-btn:hover {
    color: var(--brand-red-dark);
    text-decoration: underline;
}

.toggle-replies {
    color: #64748b;
    font-weight: 600;
    font-size: 12px;
    text-decoration: none;
    cursor: pointer;
    transition: all .2s ease;
    padding: 4px 0;
    border: none;
    background: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.toggle-replies:hover {
    color: #475569;
}
.toggle-replies::before {
    content: '⌄';
    display: inline-block;
    transition: transform .2s ease;
}
.toggle-replies.active::before {
    transform: rotate(180deg);
}
.toggle-replies.active {
    color: var(--brand-red);
    outline: none;
}

/* ── Mobile Tabs ── */
.mobile-tabs { display: none; gap: 8px; margin-bottom: 16px; }
.f-pill {
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    border: none;
    background: #f1f5f9;
    color: #64748b;
    transition: all .2s;
}
.f-pill:hover { background: #e2e8f0; }
.f-pill.active { background: var(--brand-red); color: #fff; }

.tab-content { display: block; }

/* Sort Tab Buttons */
.sort-tab {
    padding: 6px 12px;
    border-radius: 16px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    border: none;
    background: transparent;
    color: #64748b;
    transition: all .2s;
}

.sort-tab.active {
    background: var(--brand-red);
    color: #fff;
}

.sort-tab:hover {
    background: #f1f5f9;
    color: #475569;
}

.sort-tab.active:hover {
    background: var(--brand-red);
    color: #fff;
}

@media (max-width: 900px) {
    .mobile-tabs { display: flex; }
    .view-layout { grid-template-columns: 1fr; }
    .forum-sidebar { display: none; }
    .tab-content { display: none; }
    .tab-content.active { display: block; }
}
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
                <p style="font-size:10px;font-weight:700;color:#343434;text-transform:uppercase;letter-spacing:.15em;margin:0;">Alumni Community · Forum</p>
            </div>
        </div>
        <a href="<?= base_url('forum') ?>"
            style="background:var(--brand-red);color:#fff;border:none;border-radius:14px;padding:10px 22px;font-weight:800;font-size:13px;display:flex;align-items:center;gap:8px;cursor:pointer;text-decoration:none;box-shadow:0 4px 12px rgba(161,33,36,.25);transition:background .2s;"
            onmouseover="this.style.background='#7d181b'" onmouseout="this.style.background='var(--brand-red)'">
            Back to Feed
        </a>
    </div>
</div>

<div class="view-layout">

    <!-- ── Main content ── -->
    <div id="feed-tab" class="tab-content active">
        <!-- ── Mobile Tab Buttons ── -->
        <div class="mobile-tabs" style="margin-bottom: 16px;">
            <button class="f-pill active" id="btn-feed" onclick="updateForumTab('feed')">Feed</button>
            <button class="f-pill" id="btn-about" onclick="updateForumTab('about')">About</button>
        </div>

    <?php if($post): ?>
    <div>
        <div class="post-view-card">
            <!-- Action bar -->
            <div class="post-view-vote">
                
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
            </div>

            <!-- Body -->
            <div class="post-view-body">
                <?php if(!empty($post->valid) && $post->valid == 0): ?>
                    <div style="background:#fef2f2;border-left:4px solid #e53e3e;padding:12px 16px;border-radius:6px;margin-bottom:16px;">
                        <span style="font-size:12px;font-weight:700;color:#e53e3e;">🗑️ This post has been deleted. Only the author can view it.</span>
                    </div>
                <?php endif; ?>
                
                <?php if(!empty($post->has_profanity) && $post->has_profanity): ?>
                    <div style="background:#fef2f2;border-left:4px solid #e53e3e;padding:12px 16px;border-radius:6px;margin-bottom:16px;">
                        <span style="font-size:12px;font-weight:700;color:#e53e3e;">⚠ This post contains flagged content and has been censored.</span>
                    </div>
                <?php endif; ?>
                
                <h1 class="post-view-title"><?= htmlspecialchars($post->censored_title ?? $post->title) ?></h1>
                <p class="post-view-content"><?= htmlspecialchars($post->censored_content ?? $post->content) ?></p>

                <?php if($post->image): ?>
                <img src="<?= base_url('assets/uploads/forum/'.htmlspecialchars($post->image)) ?>"
                     alt="Post image" class="post-view-image">
                <?php endif; ?>
            </div>

            <!-- Stats footer -->
            <div class="post-view-stats">
                <a href="<?= base_url('forum/like/'.$post->id) ?>" class="vote-btn vote-btn-like">
                    <svg width="15" height="15" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                    <?= $post->like_count ?> Likes
                </a>

                <a href="<?= base_url('forum/dislike/'.$post->id) ?>" class="vote-btn vote-btn-dislike">
                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path d="M16.828 14.828a4 4 0 01-5.656 0L10 13.657l-1.172 1.171a4 4 0 11-5.656-5.656L10 2.343l6.828 6.829a4 4 0 010 5.656z"/></svg>
                    <?= $post->dislike_count ?? 0 ?> dislikes
                </a>
                
                <a href="#" id="toggle-comments">
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <?= $post->comment_count ?> Comments
                </a>
                                
                <?php if($this->session->userdata('alumni_id') == $post->alumni_id): ?>
                    <button 
                        class="vote-btn vote-btn-report"
                        style="background:#f1f5f9;color:#475569;"
                        data-toggle="modal"
                        data-target="#editPostModal"
                        data-id="<?= $post->id ?>"
                        data-title="<?= htmlspecialchars($post->title,ENT_QUOTES) ?>"
                        data-content="<?= htmlspecialchars($post->content,ENT_QUOTES) ?>"
                        data-image="<?= $post->image ? base_url('assets/uploads/forum/'.$post->image) : '' ?>"
                        onclick="openEditPost(this)">
                        Edit
                    </button>

                    <a href="<?= base_url('forum/delete/'.$post->id) ?>" class="vote-btn vote-btn-delete"
                    onclick="return confirm('Delete this post permanently?')">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Delete
                    </a>
                <?php else: ?>

                    <!-- NOT OWNER -->
                    <button 
                    class="vote-btn vote-btn-report"
                    data-toggle="modal"
                    data-target="#reportModal"
                    data-post="<?= $post->id ?>"
                    onclick="openReportModal(this)">

                    🚩 Report

                    </button>
                <?php endif; ?>
            </div>
        </div>

        <!-- Comment Sorting Dropdown -->
        <div style="margin-bottom: 8px; padding: 6px 0;">
            <select id="commentSortDropdown" onchange="sortCommentsView(this.value)" style="padding: 6px 12px; border-radius: 16px; font-size: 12px; font-weight: 700; border: 1px solid #e2e8f0; background: #fff; color: #64748b; cursor: pointer; transition: all .2s;">
                <option value="newest">Newest</option>
                <option value="most_relevant" selected>Most Relevant</option>
                <option value="oldest">Oldest</option>
            </select>
        </div>

        <!-- COMMENTS -->
        <div id="comments-container">
        
       <?php
        $top_comments = array_filter($comments, function($c){
            return empty($c->parent_id);
        });

        foreach($top_comments as $c):

        $reply_count = 0;
        foreach($comments as $r){
            if($r->parent_id == $c->id) $reply_count++;
        }
        ?>

        <div class="comment-card">
            <?php if(!empty($c->has_profanity) && $c->has_profanity): ?>
                <div style="background:#fef2f2;border-left:3px solid #f87171;padding:8px 12px;border-radius:4px;margin-bottom:8px;font-size:11px;color:#dc2626;font-weight:700;">⚠ Flagged for content</div>
            <?php endif; ?>

            <div class="comment-header">
                <div class="comment-avatar">
                    <?php if($c->is_anonymous): ?>?
                    <?php else: ?><?= strtoupper(substr($c->first_name,0,1)) ?>
                    <?php endif; ?>
                </div>

                <div>
                    <span class="comment-author">
                        <?= $c->is_anonymous ? 'Anonymous' : htmlspecialchars($c->first_name.' '.$c->last_name) ?>
                    </span>
                    <span class="comment-time">· <?= time_ago($c->created_at) ?></span>
                </div>
            </div>

            <p class="comment-body"><?= htmlspecialchars($c->comment) ?></p>
            
            <!-- Comment stats bar -->
            <div class="comment-stats">
                <a href="<?= base_url('forum/like_comment/'.$c->id.'/'.$post->id) ?>" class="vote-btn vote-btn-like <?= $c->user_liked ? 'active' : '' ?>">
                    <svg width="13" height="13" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                    <?= $c->like_count ?? 0 ?> Likes
                </a>
                <a href="<?= base_url('forum/dislike_comment/'.$c->id.'/'.$post->id) ?>" class="vote-btn vote-btn-dislike <?= $c->user_disliked ? 'active' : '' ?>">
                    <svg width="13" height="13" fill="currentColor" viewBox="0 0 20 20"><path d="M16.828 14.828a4 4 0 01-5.656 0L10 13.657l-1.172 1.171a4 4 0 11-5.656-5.656L10 2.343l6.828 6.829a4 4 0 010 5.656z"/></svg>
                    <?= $c->dislike_count ?? 0 ?> Dislikes
                </a>
                
                <?php if($this->session->userdata('alumni_id') == $c->alumni_id): ?>
                    <button 
                    class="vote-btn vote-btn-report"
                    style="background:#f1f5f9;color:#475569;"
                    data-toggle="modal"
                    data-target="#editCommentModal"
                    data-id="<?= $c->id ?>"
                    data-type="comment"
                    data-comment="<?= htmlspecialchars($c->comment,ENT_QUOTES) ?>"
                    onclick="openEditComment(this)">
                    Edit
                    </button>

                    <a href="<?= base_url('forum/delete_comment/'.$c->id.'/'.$post->id) ?>"
                    class="vote-btn vote-btn-delete"
                    onclick="return confirm('Delete this comment?')">
                    Delete
                    </a>
                <?php endif; ?>
            </div>

            <div style="margin-top:10px;display:flex;gap:16px;align-items:center;flex-wrap:wrap;">

                <!-- Reply button -->
                <a href="#" class="reply-btn" data-id="<?= $c->id ?>">
                Reply
                </a>

                <!-- View replies toggle -->
                <?php if($reply_count > 0): ?>
                <a href="#" class="toggle-replies" data-id="<?= $c->id ?>">
                <?= $reply_count ?> <?= $reply_count === 1 ? 'Reply' : 'Replies' ?>
                </a>
                <?php endif; ?>

            </div>

            <!-- Reply form -->
           <div class="reply-form" id="reply-form-<?= $c->id ?>" style="display:none;margin-top:10px;">

            <form method="post" action="<?= base_url('forum/comment') ?>" class="reply-comment-form">

            <input type="hidden" name="post_id" value="<?= $post->id ?>">
            <input type="hidden" name="parent_id" value="<?= $c->id ?>">

            <textarea name="comment"
            class="comment-textarea"
            rows="2"
            placeholder="Write a reply..."
            required></textarea>

            <div style="display:flex;align-items:center;justify-content:space-between;margin-top:10px;">

            <label style="display:flex;align-items:center;gap:6px;font-size:12px;color:#64748b;font-weight:600;">
            <input type="checkbox"
            name="anonymous"
            value="1"
            style="accent-color:var(--brand-red);width:14px;height:14px;">
            Reply as Anonymous
            </label>

            <button type="submit"
            style="background:var(--brand-red);color:white;border:none;border-radius:10px;padding:6px 14px;font-size:12px;font-weight:700;">
            Reply
            </button>

            </div>

            </form>

            </div>

            <!-- Replies container -->
            <div class="reply-container" id="replies-list-<?= $c->id ?>" style="display:none;margin-top:12px;">

                <?php foreach($comments as $reply): ?>
                <?php if($reply->parent_id == $c->id): ?>

                <div style="margin-left:40px;margin-top:10px;padding-left:12px;border-left:2px solid #e2e8f0;">
                    <?php if(!empty($reply->has_profanity) && $reply->has_profanity): ?>
                        <div style="background:#fef2f2;border-left:3px solid #f87171;padding:6px 10px;border-radius:3px;margin-bottom:6px;font-size:10px;color:#dc2626;font-weight:700;">⚠ Flagged</div>
                    <?php endif; ?>

                    <div class="comment-header">
                        <div class="comment-avatar">
                            <?php if($reply->is_anonymous): ?>?
                            <?php else: ?><?= strtoupper(substr($reply->first_name,0,1)) ?>
                            <?php endif; ?>
                        </div>

                        <div>
                            <span class="comment-author">
                                <?= $reply->is_anonymous ? 'Anonymous' : htmlspecialchars($reply->first_name.' '.$reply->last_name) ?>
                            </span>
                            <span class="comment-time">· <?= time_ago($reply->created_at) ?></span>
                        </div>
                    </div>

                    <p class="comment-body"><?= htmlspecialchars($reply->comment) ?></p>
                    
                    <!-- Reply stats bar -->
                    <div class="comment-stats">
                        <a href="<?= base_url('forum/like_comment/'.$reply->id.'/'.$post->id) ?>" class="vote-btn vote-btn-like <?= $reply->user_liked ? 'active' : '' ?>">
                            <svg width="13" height="13" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                            <?= $reply->like_count ?? 0 ?> Likes
                        </a>
                        <a href="<?= base_url('forum/dislike_comment/'.$reply->id.'/'.$post->id) ?>" class="vote-btn vote-btn-dislike <?= $reply->user_disliked ? 'active' : '' ?>">
                            <svg width="13" height="13" fill="currentColor" viewBox="0 0 20 20"><path d="M16.828 14.828a4 4 0 01-5.656 0L10 13.657l-1.172 1.171a4 4 0 11-5.656-5.656L10 2.343l6.828 6.829a4 4 0 010 5.656z"/></svg>
                            <?= $reply->dislike_count ?? 0 ?> Dislikes
                        </a>
                        
                        <?php if($this->session->userdata('alumni_id') == $reply->alumni_id): ?>
                            <button 
                            class="vote-btn vote-btn-report"
                            style="background:#f1f5f9;color:#475569;"
                            data-toggle="modal"
                            data-target="#editCommentModal"
                            data-id="<?= $reply->id ?>"
                            data-type="reply"
                            data-comment="<?= htmlspecialchars($reply->comment,ENT_QUOTES) ?>"
                            onclick="openEditComment(this)">
                            Edit
                            </button>

                            <a href="<?= base_url('forum/delete_comment/'.$reply->id.'/'.$post->id) ?>"
                            class="vote-btn vote-btn-delete"
                            onclick="return confirm('Delete this reply?')">
                            Delete
                            </a>
                        <?php endif; ?>
                    </div>

                </div>

                <?php endif; ?>
                <?php endforeach; ?>

            </div>

        </div>

        <?php endforeach; ?>
        
        <?php if(empty($top_comments)): ?>
        <div class="comments-empty">
            <svg fill="none" stroke="#cbd5e1" viewBox="0 0 24 24">
                <path stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <h4>No comments yet</h4>
            <p>Be the first to share your thoughts on this discussion!</p>
        </div>
        <?php endif; ?>
        </div>
        
        <!-- ── Comment Section ── -->
        <h3 style="font-size:16px;font-weight:800;color:#fff;margin-bottom:16px;">💬 <?= $post->comment_count ?> Comments</h3>

        <div class="comment-writer">
            <form method="post" action="<?= base_url('forum/comment') ?>" id="main-comment-form">
                <input type="hidden" name="post_id" value="<?= $post->id ?>">
                <input type="hidden" name="parent_id" value="0">
                <textarea name="comment" class="comment-textarea" rows="3"
                          placeholder="What are your thoughts?" required></textarea>
                <div style="display:flex;align-items:center;justify-content:space-between;margin-top:16px;">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:13px;font-weight:600;color:#64748b;">
                        <input type="checkbox" name="anonymous" value="1" style="accent-color:var(--brand-red);width:15px;height:15px;">
                        Comment as Anonymous
                    </label>
                    <button type="submit" class="btn-submit-comment" style="background:var(--brand-red);color:#fff;border:none;border-radius:12px;padding:10px 24px;font-weight:800;font-size:13px;cursor:pointer;">Post Comment</button>
                </div>
            </form>
        </div>
        
        <script>
        // Handle comment form submission
        document.getElementById('main-comment-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get textarea element from THIS form only
            const textarea = this.querySelector('textarea[name="comment"]');
            const textareaValue = textarea.value;
            
            console.log('=== FORM SUBMISSION DEBUG ===');
            console.log('Textarea element:', textarea);
            console.log('Textarea value directly:', textareaValue);
            console.log('Textarea.value type:', typeof textareaValue);
            console.log('Textarea.value length:', textareaValue.length);
            
            const formData = new FormData(this);
            const post_id = formData.get('post_id');
            const comment_text = formData.get('comment');
            const is_anonymous = formData.get('anonymous') ? 1 : 0;
            
            console.log('FormData post_id:', post_id);
            console.log('FormData comment from FormData:', comment_text);
            console.log('Does it match textarea?', comment_text === textareaValue);
            console.log('Submitting comment:', {post_id, comment_text, is_anonymous});
            
            fetch('<?= base_url("forum/comment") ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers content-type:', response.headers.get('content-type'));
                return response.text();
            })
            .then(text => {
                console.log('Raw response length:', text.length);
                console.log('Raw response text:', text.substring(0, 500));
                
                const cleanText = text.trim();
                
                try {
                    const data = JSON.parse(cleanText);
                    console.log('SUCCESS: Parsed JSON:', data);
                    
                    if(data.success) {
                        document.querySelector('.comment-textarea').value = '';
                        window.location.reload();
                    } else {
                        alert(data.message || 'Error posting comment');
                    }
                } catch(parseError) {
                    console.error('JSON Parse Error:', parseError.message);
                    console.error('Full response was:', text);
                    
                    if(text.includes('<!DOCTYPE') || text.includes('<html')) {
                        alert('Server returned an error page. Check browser console for details.');
                    } else {
                        alert('Server response was not valid JSON. Response: ' + text.substring(0, 200));
                    }
                }
            })
            .catch(error => {
                console.error('Fetch Error:', error);
                alert('Network error: ' + error.message);
            });
        });
        </script>
    </div>
    <?php endif; ?>
    </div>
    
    <!-- ── Sidebar / About Tab ── -->
    <div id="about-tab" class="tab-content forum-sidebar">
        <!-- ── Mobile Tab Buttons ── -->
        <div class="mobile-tabs" style="margin-bottom: 16px;">
            <button class="f-pill" id="btn-feed2" onclick="updateForumTab('feed')">Feed</button>
            <button class="f-pill active" id="btn-about2" onclick="updateForumTab('about')">About</button>
        </div>

        <div class="forum-sidebar-card" style="background:linear-gradient(135deg,var(--brand-red) 0%,#7d181b 100%);border:none;padding:24px;border-radius:24px;margin-bottom:24px;">
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

    <!-- UPDATE POST MODAL  -->
    <div class="modal fade" id="editPostModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">

        <div class="modal-header">
        <h5 class="modal-title">Edit Post</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form method="post" action="<?= base_url('forum/update_post') ?>" enctype="multipart/form-data">

        <div class="modal-body">

            <input type="hidden" name="post_id" id="edit-post-id">

            <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" id="edit-post-title" class="form-control" required>
            </div>

            <div class="form-group">
            <label>Content</label>
            <textarea name="content" id="edit-post-content" class="form-control" rows="4" required></textarea>
            </div>
            <div class="form-group">

            <label>Current Image</label>

            <img 
            id="edit-post-image-preview"
            style="width:100%;max-height:200px;object-fit:contain;border-radius:10px;margin-bottom:10px;display:none;">

            </div>

            <div class="form-group">

            <label>Replace Image</label>

            <input type="file" name="image" class="form-control">

            </div>

        </div>

        <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">
        Cancel
        </button>

        <button type="submit" class="btn btn-danger">
        Update Post
        </button>

        </div>

        </form>

        </div>
        </div>
    </div>

    <!-- UPDATE COMMENT MODAL -->
     <div class="modal fade" id="editCommentModal" tabindex="-1">
        <div class="modal-dialog">
        <div class="modal-content">

        <div class="modal-header">
        <h5 class="modal-title" id="edit-comment-title">
        Edit Comment
        </h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form method="post" action="<?= base_url('forum/update_comment') ?>">

        <div class="modal-body">

        <input type="hidden" name="comment_id" id="edit-comment-id">
        <input type="hidden" name="post_id" value="<?= $post->id ?>">

        <textarea 
        name="comment"
        id="edit-comment-text"
        class="form-control"
        rows="4"
        required></textarea>

        </div>

        <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">
        Cancel
        </button>

        <button type="submit" class="btn btn-danger">
        Update
        </button>

        </div>

        </form>

        </div>
        </div>
    </div>

    <!-- REPORT MODAL -->
    <div class="modal fade" id="reportModal" tabindex="-1">
        <div class="modal-dialog">
        <div class="modal-content">

        <div class="modal-header">
        <h5 class="modal-title">Report Post</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <form method="post" action="<?= base_url('forum/report') ?>">

        <div class="modal-body">

        <input type="hidden" name="post_id" id="report-post-id">

        <p style="font-weight:600;margin-bottom:12px;">
        Why are you reporting this post?
        </p>

            <div style="display:flex;flex-direction:column;gap:10px;">

            <label class="report-option">
            <input type="radio" name="reason" value="Spam">
            Spam
            </label>

            <label class="report-option">
            <input type="radio" name="reason" value="Harassment">
            Harassment
            </label>

            <label class="report-option">
            <input type="radio" name="reason" value="Inappropriate Content">
            Inappropriate Content
            </label>

            <label class="report-option">
            <input type="radio" name="reason" value="False Information">
            False Information
            </label>

            <label class="report-option">
            <input type="radio" name="reason" value="Other">
            Other
            </label>
            <!-- Hidden textbox -->
            <textarea
            name="other_reason"
            id="other-reason-box"
            class="form-control"
            rows="3"
            placeholder="Please describe the issue..."
            style="display:none;margin-top:6px;"></textarea>

            </div>
        </div>

        <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">
        Cancel
        </button>

        <button type="submit" class="btn btn-danger" id="report-submit" disabled>
        Submit Report
        </button>

        </div>

        </form>

        </div>
        </div>
    </div>

</div>

<script>
// Scroll smooth to comments if needed
if(window.location.hash === '#comments') {
    document.querySelector('.comment-writer').scrollIntoView({ behavior: 'smooth' });
}

function openReportModal(btn){

document.getElementById("report-post-id").value = btn.dataset.post;

}
// REPORT JAVASCRIPT
const reasonRadios = document.querySelectorAll("input[name='reason']");
const otherBox = document.getElementById("other-reason-box");
const submitBtn = document.getElementById("report-submit");

reasonRadios.forEach(radio => {

radio.addEventListener("change", function(){

submitBtn.disabled = false;

if(this.value === "Other"){
    otherBox.style.display = "block";
    submitBtn.disabled = true;
}else{
    otherBox.style.display = "none";
}

});

});


otherBox.addEventListener("keyup", function(){

if(this.value.trim().length > 3){
    submitBtn.disabled = false;
}else{
    submitBtn.disabled = true;
}

});

function openEditPost(btn){

    document.getElementById("edit-post-id").value = btn.dataset.id;
    document.getElementById("edit-post-title").value = btn.dataset.title;
    document.getElementById("edit-post-content").value = btn.dataset.content;

    // show existing image if available
    const preview = document.getElementById("edit-post-image-preview");
    const image = btn.dataset.image;

    if(image){
        preview.src = image;
        preview.style.display = "block";
    }else{
        preview.style.display = "none";
    }

}


function openEditComment(btn){

    document.getElementById("edit-comment-id").value = btn.dataset.id;
    document.getElementById("edit-comment-text").value = btn.dataset.comment;

    let type = btn.dataset.type;

    if(type === "reply"){
        document.getElementById("edit-comment-title").innerText = "Edit Reply";
    }else{
        document.getElementById("edit-comment-title").innerText = "Edit Comment";
    }

}

</script>

<script>

// Collapse comments
let commentsToggle = document.getElementById("toggle-comments");
let commentsContainer = document.getElementById("comments-container");

commentsToggle.addEventListener("click", function(e){

    e.preventDefault();

    if(commentsContainer.style.display === "none"){
        commentsContainer.style.display = "block";
        commentsToggle.innerHTML = " <?= $post->comment_count ?> Comments";
    }else{
        commentsContainer.style.display = "none";
        commentsToggle.innerHTML = " <?= $post->comment_count ?> Comments";
    }

});


// Toggle reply forms with jQuery slideToggle
$(document).on('click', '.reply-btn', function(e){
    e.preventDefault();
    let id = $(this).data('id');
    let form = $('#reply-form-' + id);
    
    form.slideToggle(300, function(){
        // Focus textarea if it was just shown
        if(form.is(':visible')){
            form.find('textarea').focus();
        }
    });
});

// Handle reply form submissions
$(document).on('submit', '.reply-comment-form', function(e){
    e.preventDefault();
    
    const form = $(this);
    const formData = new FormData(this);
    const comment_text = formData.get('comment');
    
    console.log('Submitting reply:', {comment_text});
    
    fetch('<?= base_url("forum/comment") ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.text();
    })
    .then(text => {
        console.log('Raw response length:', text.length);
        console.log('Raw response text:', text.substring(0, 500));
        
        const cleanText = text.trim();
        
        try {
            const data = JSON.parse(cleanText);
            console.log('SUCCESS: Parsed JSON:', data);
            
            if(data.success) {
                form.find('textarea').value = '';
                window.location.reload();
            } else {
                alert(data.message || 'Error posting reply');
            }
        } catch(parseError) {
            console.error('JSON Parse Error:', parseError.message);
            console.error('Full response was:', text);
            
            if(text.includes('<!DOCTYPE') || text.includes('<html')) {
                alert('Server returned an error page. Check browser console for details.');
            } else {
                alert('Server response was not valid JSON. Response: ' + text.substring(0, 200));
            }
        }
    })
    .catch(error => {
        console.error('Fetch Error:', error);
        alert('Network error: ' + error.message);
    });
});


// Toggle replies with jQuery slideToggle
$(document).on('click', '.toggle-replies', function(e){
    e.preventDefault();
    let id = $(this).data('id');
    let replies = $('#replies-list-' + id);
    
    $(this).toggleClass('active');
    replies.slideToggle(300);
});

// Store original comment order on page load
let originalCommentOrder = [];

// Save original comment order on DOM ready and mark each with index
function initializeCommentOrder() {
    if (originalCommentOrder.length === 0) {
        const cards = document.querySelectorAll('#comments-container > .comment-card');
        cards.forEach((card, index) => {
            card.dataset.originalIndex = index;
            originalCommentOrder.push(card);
        });
    }
}

// Initialize on DOMContentLoaded
document.addEventListener('DOMContentLoaded', function() {
    initializeCommentOrder();
    
    // Restore saved sort preference EARLY before rendering
    const savedSort = localStorage.getItem('commentSortPreference');
    if (savedSort) {
        const dropdown = document.getElementById('commentSortDropdown');
        if (dropdown) {
            dropdown.value = savedSort;
            sortCommentsView(savedSort);
        }
    }
});

// Sort comments on forum view page
function sortCommentsView(sortType) {
    let commentCards = Array.from(document.querySelectorAll('#comments-container > .comment-card'));
    
    if (commentCards.length === 0) return;
    
    // Ensure original order is captured
    initializeCommentOrder();
    
    if (sortType === 'most_relevant') {
        // Sort by likes (descending - highest first)
        commentCards.sort((a, b) => {
            const aLikeBtnText = a.querySelector('.vote-btn-like')?.textContent || '0';
            const bLikeBtnText = b.querySelector('.vote-btn-like')?.textContent || '0';
            
            const aLikes = parseInt(aLikeBtnText.match(/\d+/)?.[0] || 0);
            const bLikes = parseInt(bLikeBtnText.match(/\d+/)?.[0] || 0);
            
            return bLikes - aLikes;
        });
    } else if (sortType === 'oldest') {
        // Sort by original index ascending (oldest first)
        commentCards.sort((a, b) => {
            const aIndex = parseInt(a.dataset.originalIndex || 0);
            const bIndex = parseInt(b.dataset.originalIndex || 0);
            return aIndex - bIndex;  // Ascending = oldest first
        });
    } else if (sortType === 'newest') {
        // Sort by original index descending (newest first)
        commentCards.sort((a, b) => {
            const aIndex = parseInt(a.dataset.originalIndex || 0);
            const bIndex = parseInt(b.dataset.originalIndex || 0);
            return bIndex - aIndex;  // Descending = newest first
        });
    }
    
    // Reorder comments in DOM
    const container = document.getElementById('comments-container');
    if (container) {
        commentCards.forEach(card => {
            container.appendChild(card);
        });
    }
    
    // Save sort preference to localStorage
    localStorage.setItem('commentSortPreference', sortType);
    
    // Update dropdown value
    const dropdown = document.getElementById('commentSortDropdown');
    if (dropdown) {
        dropdown.value = sortType;
    }
}

// Mobile Tab Switching
function updateForumTab(tab) {
    // Remove active from all buttons
    document.querySelectorAll('.f-pill').forEach(btn => {
        btn.classList.remove('active');
    });
    // Add active to clicked button
    if(document.getElementById('btn-' + tab)) {
        document.getElementById('btn-' + tab).classList.add('active');
    }
    if(document.getElementById('btn-' + tab + '2')) {
        document.getElementById('btn-' + tab + '2').classList.add('active');
    }
    
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
    });
    // Show selected tab
    document.getElementById(tab + '-tab').classList.add('active');
    
    // Save active tab to localStorage
    localStorage.setItem('forumActiveTab', tab);
}

// Restore active tab on page load
window.addEventListener('load', function() {
    const savedTab = localStorage.getItem('forumActiveTab');
    if(savedTab && savedTab !== 'feed') {
        updateForumTab(savedTab);
    }
});

</script>
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
.forum-layout {
    max-width: 1100px;
    margin: 64px auto 0; /* Adjusted for fixed header height approx 64px */
    padding: 32px 20px 80px;
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 28px;
}

@media (max-width: 900px) {
    .forum-layout { grid-template-columns: 1fr; }
    .forum-sidebar { display: none; }
}

/* ── Search bar ── */
.forum-search-bar {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 0 16px;
    transition: border-color .2s, box-shadow .2s;
}
.forum-search-bar:focus-within {
    border-color: var(--brand-red);
    box-shadow: 0 0 0 3px rgba(190,18,60,.08);
}
.forum-search-bar input {
    border: none;
    background: transparent;
    padding: 12px 0;
    width: 100%;
    font-size: 14px;
    font-weight: 500;
    outline: none;
    color: #0f172a;
}

/* ── Sort Tabs ── */
.sort-tabs { display: flex; gap: 4px; }
.sort-tab {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    border: none;
    background: transparent;
    color: #64748b;
    transition: all .2s;
    text-decoration: none;
}
.sort-tab:hover { background: #f1f5f9; color: #0f172a; }
.sort-tab.active { background: var(--brand-red); color: #fff; }

/* ── Post Card ── */
.post-card {
    background: #fff;
    border-radius: 20px;
    border: 1px solid #e8ecf0;
    padding: 0;
    display: flex;
    overflow: hidden;
    transition: box-shadow .2s, transform .2s, border-color .2s;
    cursor: pointer;
    text-decoration: none !important;
    color: inherit !important;
}
.post-card:hover {
    box-shadow: 0 8px 30px -8px rgba(190,18,60,.15);
    transform: translateY(-2px);
    border-color: #fda4af;
    text-decoration: none !important;
    color: inherit !important;
}

/* Reddit-style vote bar on left */
.post-vote-bar {
    width: 52px;
    flex-shrink: 0;
    background: #f8fafc;
    border-right: 1px solid #f1f5f9;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 4px;
    padding: 16px 0;
    color: #94a3b8;
}
.vote-count {
    font-size: 13px;
    font-weight: 800;
    color: #0f172a;
    line-height: 1;
}

.post-body { padding: 16px 20px; flex-grow: 1; min-width: 0; }

.post-meta { display: flex; align-items: center; gap: 8px; margin-bottom: 6px; flex-wrap: wrap; }
.post-avatar {
    width: 28px; height: 28px; border-radius: 50%;
    object-fit: cover; border: 2px solid #f1f5f9;
    background: #f1f5f9; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-weight: 800; font-size: 11px; color: var(--brand-red);
    overflow: hidden;
}
.post-author { font-size: 12px; font-weight: 700; color: #475569; }
.post-time { font-size: 11px; color: #94a3b8; }
.anon-badge {
    background: #f1f5f9; color: #64748b;
    font-size: 10px; font-weight: 700;
    padding: 2px 8px; border-radius: 20px;
    text-transform: uppercase; letter-spacing: 0.5px;
}

.post-title {
    font-size: 16px; font-weight: 800; color: #0f172a;
    line-height: 1.4; margin: 0 0 6px;
}
.post-card:hover .post-title { color: var(--brand-red); }

.post-preview {
    font-size: 13px; color: #64748b; line-height: 1.6;
    display: -webkit-box; -webkit-line-clamp: 2;
    -webkit-box-orient: vertical; overflow: hidden;
    margin-bottom: 10px;
}

.post-stats { display: flex; align-items: center; gap: 16px; }
.post-stat {
    display: flex; align-items: center; gap: 5px;
    font-size: 12px; font-weight: 600; color: #94a3b8;
}
.post-stat svg { width: 14px; height: 14px; }
.post-stat-likes { color: #f43f5e; }

.post-image-thumb {
    width: 90px; flex-shrink: 0;
    margin: 12px 12px 12px 0; border-radius: 12px;
    overflow: hidden; align-self: center;
}
.post-image-thumb img { width: 100%; height: 90px; object-fit: cover; }

/* ── Create Post Button ── */
.create-post-btn {
    display: flex; align-items: center; gap: 12px;
    background: #fff; border: 1px solid #e2e8f0;
    border-radius: 20px; padding: 10px 16px; width: 100%;
    cursor: pointer; transition: border-color .2s;
    margin-bottom: 16px;
}
.create-post-btn:hover { border-color: var(--brand-red); }
.create-post-input {
    flex-grow: 1; background: #f8fafc; border: 1px solid #e2e8f0;
    border-radius: 12px; padding: 8px 14px; font-size: 13px;
    font-weight: 500; color: #94a3b8; cursor: pointer;
    pointer-events: none;
}

/* ── Sidebar ── */
.forum-sidebar-card {
    background: #fff; border: 1px solid #e2e8f0;
    border-radius: 20px; padding: 20px; margin-bottom: 16px;
}
.sidebar-title {
    font-size: 11px; font-weight: 800; color: #94a3b8;
    text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px;
}

/* ── Empty state ── */
.empty-state {
    text-align: center; padding: 80px 24px;
    background: #fff; border-radius: 24px;
    border: 2px dashed #e2e8f0;
}

/* ── Pagination ── */
.forum-pagination { display: flex; gap: 6px; justify-content: center; margin-top: 24px; }
.forum-pagination a, .forum-pagination span {
    display: inline-flex; align-items: center; justify-content: center;
    width: 36px; height: 36px; border-radius: 10px;
    font-size: 13px; font-weight: 700; text-decoration: none;
    background: #fff; color: #475569; border: 1px solid #e2e8f0;
    transition: all .2s;
}
.forum-pagination a:hover { background: #fef2f2; border-color: var(--brand-red); color: var(--brand-red); }
.forum-pagination span.current { background: var(--brand-red); color: #fff; border-color: var(--brand-red); }

/* ── Modal ── */
.create-modal .modal-content {
    border-radius: 24px; border: none;
    box-shadow: 0 25px 60px -10px rgba(0,0,0,.2);
    overflow: hidden;
}
.create-modal .modal-header {
    background: linear-gradient(135deg, var(--brand-red) 0%, var(--brand-red-dark) 100%);
    border: none; padding: 20px 24px;
}
.create-modal .modal-title { color: #fff; font-weight: 800; font-size: 18px; }
.create-modal .modal-header .close { color: rgba(255,255,255,.7); }
.create-modal .modal-body { padding: 24px; }
.create-modal .form-label {
    font-size: 11px; font-weight: 800; color: #64748b;
    text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px;
}
.create-modal .form-control {
    border-radius: 12px; border: 1.5px solid #e2e8f0; padding: 10px 14px;
    font-size: 14px; font-weight: 500;
    transition: border-color .2s, box-shadow .2s;
}
.create-modal .form-control:focus {
    border-color: var(--brand-red); box-shadow: 0 0 0 3px rgba(190,18,60,.08);
    outline: none;
}
.create-modal .btn-post {
    background: var(--brand-red); color: #fff; border: none;
    border-radius: 14px; padding: 12px 32px; font-weight: 800;
    font-size: 14px; transition: background .2s; width: 100%;
}
.create-modal .btn-post:hover { background: var(--brand-red-dark); }

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(16px); }
    to { opacity: 1; transform: translateY(0); }
}
.post-card { animation: fadeInUp .3s ease-out forwards; }
</style>

<!-- ── Page header bar ── -->
<div class="forum-header-bar">
    <div style="max-width:1185px; margin:0 auto; padding:12px 25px; display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap;">
        <div style="display:flex; align-items:center; gap:12px;">
            <div style="width:40px;height:40px;background:var(--brand-red);border-radius:14px;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(190,18,60,.25);">
                <svg style="width:20px;height:20px;color:#fff;fill:none;stroke:#fff;stroke-width:2;" viewBox="0 0 24 24"><path d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/></svg>
            </div>
            <div>
                <h1 style="font-size:18px;font-weight:800;color:#0f172a;margin:0;">Forum <span style="color:var(--brand-red);">Discussions</span></h1>
                <p style="font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.15em;margin:0;">Alumni Community · <?= $total_posts ?? 0 ?> Posts</p>
            </div>
        </div> 
    </div>
</div>

<!-- ── Main layout ── -->
<div class="forum-layout">

    <!-- ── Main feed ── -->
    <div>
        <!-- Search + Sort row -->
        <div style="display:flex; flex-wrap:wrap; gap:10px; align-items:center; margin-bottom:20px;">
            <div class="forum-search-bar" style="flex:1; min-width:200px;">
                <svg width="16" height="16" fill="none" stroke="#94a3b8" viewBox="0 0 24 24"><path stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" id="search-input" placeholder="Search discussions..." value="<?= htmlspecialchars($this->input->get('search') ?? '') ?>">
            </div>
            <div class="sort-tabs">
                <a href="<?= base_url('forum?sort=') ?>" class="sort-tab <?= (!$this->input->get('sort') || $this->input->get('sort')=='') ? 'active' : '' ?>">🔥 Latest</a>
                <a href="<?= base_url('forum?sort=likes') ?>" class="sort-tab <?= $this->input->get('sort')=='likes' ? 'active' : '' ?>">❤️ Top</a>
                <a href="<?= base_url('forum?sort=comments') ?>" class="sort-tab <?= $this->input->get('sort')=='comments' ? 'active' : '' ?>">💬 Hot</a>
                <a href="<?= base_url('forum?sort=myposts') ?>" class="sort-tab <?= $this->input->get('sort')=='myposts' ? 'active' : '' ?>">👤 Mine</a>
            </div>
        </div>

        <!-- Create post shortcut -->
        <div class="create-post-btn" data-toggle="modal" data-target="#createPostModal">
            <div class="post-avatar" style="width:36px;height:36px;border-radius:50%;background:#f1f5f9;flex-shrink:0;"></div>
            <div class="create-post-input">Start a discussion...</div>
            <button style="background:var(--brand-red);color:#fff;border:none;border-radius:10px;padding:7px 16px;font-size:12px;font-weight:800;cursor:pointer;" data-toggle="modal" data-target="#createPostModal">Post</button>
        </div>

        <!-- Posts feed -->
        <?php if (!empty($posts)): ?>
            <div id="forum-feed" style="display:flex;flex-direction:column;gap:10px;">
                <?php foreach($posts as $idx => $p): ?>
                <a href="<?= base_url('forum/view/'.$p->id) ?>" class="post-card" style="animation-delay:<?= $idx * 40 ?>ms;">
                    <!-- Vote sidebar -->
                    <div class="post-vote-bar">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity:.4"><path stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                        <span class="vote-count"><?= $p->like_count ?></span>
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity:.2"><path stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>

                    <!-- Content -->
                    <div class="post-body">
                        <div class="post-meta">
                            <?php if($p->is_anonymous): ?>
                                <div class="post-avatar">?</div>
                                <span class="anon-badge">Anonymous</span>
                            <?php else: ?>
                                <?php if($p->profile_image): ?>
                                    <div class="post-avatar"><img src="<?= base_url('assets/uploads/alumni/'.$p->profile_image) ?>" style="width:100%;height:100%;object-fit:cover;"></div>
                                <?php else: ?>
                                    <div class="post-avatar"><?= strtoupper(substr($p->first_name,0,1)) ?></div>
                                <?php endif; ?>
                                <span class="post-author"><?= htmlspecialchars($p->first_name.' '.$p->last_name) ?></span>
                            <?php endif; ?>
                            <span class="post-time">· <?= time_ago($p->created_at) ?></span>
                        </div>

                        <h3 class="post-title"><?= htmlspecialchars($p->title) ?></h3>
                        

                        <div class="post-stats">
                            <span class="post-stat post-stat-likes">
                                <svg fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                                <?= $p->like_count ?> likes
                            </span>
                            <span class="post-stat">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                <?= $p->comment_count ?> comments
                            </span>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>

        <?php else: ?>
            <div class="empty-state">
                <div style="width:64px;height:64px;background:#fef2f2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                    <svg width="32" height="32" fill="none" stroke="#fda4af" viewBox="0 0 24 24"><path stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                </div>
                <h3 style="font-size:18px;font-weight:800;color:#0f172a;margin:0 0 6px;">No discussions yet</h3>
                <p style="font-size:14px;color:#94a3b8;margin:0 0 20px;">Be the first to start a conversation!</p>
                <button data-toggle="modal" data-target="#createPostModal" style="background:var(--brand-red);color:#fff;border:none;border-radius:12px;padding:10px 24px;font-weight:800;font-size:13px;cursor:pointer;">Start Discussion</button>
            </div>
        <?php endif; ?>

        <!-- Pagination -->
        <?php if(!empty($pagination)): ?>
        <div class="forum-pagination"><?= $pagination ?></div>
        <?php endif; ?>
    </div>

    <!-- ── Sidebar ── -->
    <div class="forum-sidebar">
        <div class="forum-sidebar-card" style="background:linear-gradient(135deg,var(--brand-red) 0%,#881337 100%);border:none;">
            <h3 style="font-size:16px;font-weight:800;color:#fff;margin:0 0 6px;">Community Rules</h3>
            <p style="font-size:12px;color:rgba(255,255,255,.8);margin:0 0 16px;line-height:1.6;">A space for alumni to connect, share knowledge, and support each other.</p>
            
        </div>

        <div class="forum-sidebar-card">
            <div class="sidebar-title">Community guidelines</div>
            <?php foreach(['Be respectful and constructive','No spam or self-promotion','Keep it relevant to alumni life'] as $i => $rule): ?>
            <div style="display:flex;align-items:flex-start;gap:10px;padding:8px 0;border-bottom:1px solid #f1f5f9;font-size:13px;color:#475569;">
                <span style="font-weight:800;color:var(--brand-red);min-width:20px;"><?= $i+1 ?>.</span>
                <?= $rule ?>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="forum-sidebar-card">
            <div class="sidebar-title">Sort by</div>
            <?php
            $sorts = ['' => '🔥 New — Latest posts first', 'likes' => '❤️ Top — Most liked', 'comments' => '💬 Hot — Most commented', 'myposts' => '👤 Mine — My posts'];
            $cur = $this->input->get('sort') ?? '';
            foreach($sorts as $val => $label): ?>
            <a href="<?= base_url('forum?sort='.$val) ?>"
               style="display:block;padding:8px 12px;border-radius:10px;font-size:13px;font-weight:600;text-decoration:none;color:<?= $cur==$val ? 'var(--brand-red)' : '#475569' ?>;background:<?= $cur==$val ? '#fef2f2' : 'transparent' ?>;margin-bottom:2px;transition:background .15s;">
                <?= $label ?>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- ── Create Post Modal ── -->
<div class="modal fade create-modal" id="createPostModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:inline;vertical-align:middle;margin-right:8px;"><path stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Create Discussion
                </h5>
                <button type="button" class="close" data-dismiss="modal" style="color:rgba(255,255,255,.8);font-size:22px;">&times;</button>
            </div>
            <form method="post" action="<?= base_url('forum/create_post') ?>" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Discussion Title</label>
                        <input type="text" name="title" class="form-control" placeholder="What's on your mind?" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Content</label>
                        <textarea name="content" class="form-control" rows="5" placeholder="Share your thoughts, questions, or insights..." required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Attach Image (Optional)</label>
                        <input type="file" name="image" class="form-control" accept="image/jpg,image/jpeg,image/png" style="padding:8px;">
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;padding:12px 16px;background:#f8fafc;border-radius:12px;border:1.5px solid #e2e8f0;">
                        <input type="checkbox" name="anonymous" value="1" id="anon-check" style="width:16px;height:16px;cursor:pointer;accent-color:var(--brand-red);">
                        <label for="anon-check" style="margin:0;font-size:13px;font-weight:600;color:#475569;cursor:pointer;">Post as Anonymous</label>
                        <span style="margin-left:auto;font-size:11px;color:#94a3b8;">Your identity will be hidden</span>
                    </div>
                </div>
                <div class="modal-footer" style="border:none;padding:0 24px 24px;">
                    <button type="button" class="btn btn-light" data-dismiss="modal" style="border-radius:12px;font-weight:700;padding:10px 24px;">Cancel</button>
                    <button type="submit" class="btn-post">Publish Discussion</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let searchTimer;
document.getElementById('search-input').addEventListener('keyup', function() {
    clearTimeout(searchTimer);
    const q = this.value.trim();
    searchTimer = setTimeout(() => {
        const sort = new URLSearchParams(window.location.search).get('sort') || '';
        if (q === '') {
            window.location.href = '<?= base_url('forum') ?>' + (sort ? '?sort='+sort : '');
        } else {
            window.location.href = '<?= base_url('forum') ?>?search=' + encodeURIComponent(q) + (sort ? '&sort='+sort : '');
        }
    }, 400);
});
</script>

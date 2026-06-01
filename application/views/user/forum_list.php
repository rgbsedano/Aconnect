<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

:root {
    --brand-red: #a12124;
    --brand-red-dark: #7d181b;
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
    box-shadow: 0 0 0 3px rgba(161,33,36,.08);
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
    box-shadow: 0 8px 30px -8px rgba(161,33,36,.15);
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

/* Forum Standing Badge */
.badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 3px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
}

.badge-danger {
    background-color: #dc3545;
    color: white;
}

.badge-warning {
    background-color: #ffc107;
    color: #333;
}

.badge-info {
    background-color: #17a2b8;
    color: white;
}

.badge-success {
    background-color: #28a745;
    color: white;
}

.badge-primary {
    background-color: var(--brand-red);
    color: white;
}

.badge i {
    font-size: 10px;
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
.post-stat-dislikes { color: #64748b; }

/* ── Comment Modal ── */
.comment-modal-overlay {
    position: fixed;
    top: 55px;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(15, 23, 42, 0.5);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    backdrop-filter: blur(4px);
}
.comment-modal-overlay.active {
    display: flex;
}
.comment-modal-content {
    background: #fff;
    border-radius: 20px;
    border: 1px solid #e8ecf0;
    padding: 0;
    width: 90%;
    max-width: 800px;
    max-height: 90vh;
    box-shadow: 0 20px 60px -10px rgba(161, 33, 36, 0.2);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    animation: slideInUp 0.3s ease-out;
}
.comment-modal-header {
    background: #a12124;
    color: #fff;
    padding: 20px 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}
.comment-modal-title {
    font-size: 16px;
    font-weight: 800;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}
.comment-modal-close {
    background: none;
    border: none;
    color: #fff;
    font-size: 24px;
    cursor: pointer;
    padding: 0;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: opacity 0.2s;
}
.comment-modal-close:hover {
    opacity: 0.8;
}
.comment-modal-body {
    padding: 24px;
    flex: 1;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
}
.post-preview-card {
     background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 20px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    position: relative;
}
.post-view-avatar {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #f1f5f9;
    background: #f1f5f9;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 11px;
    color: var(--brand-red);
    overflow: hidden;
}
.post-view-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.post-preview-content {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    gap: 6px;
    padding: 0;
}
.post-preview-author {
    font-weight: 700;
    color: #0f172a;
    font-size: 13px;
}
.post-preview-time {
    font-size: 11px;
    color: #94a3b8;
    white-space: nowrap;
}
.post-preview-time {
    font-size: 11px;
    color: #94a3b8;
}
.post-preview-title {
    font-weight: 700;
    color: #0f172a;
    font-size: 14px;
    line-height: 1.3;
    margin-bottom: 4px;
    display: block;
}
.post-preview-excerpt {
    color: #64748b;
    font-size: 12px;
    line-height: 1.4;
    margin-bottom: 0;
    display: block;
}
.post-preview-stats {
    display: flex;
    gap: 0;
    flex-wrap: nowrap;
    padding: 8px 0;
    margin: 0;
    width: 100%;
    align-items: center;
    margin-top: 8px;
    border-top: 1px solid #f1f5f9;
    border-bottom: 1px solid #f1f5f9;
}
.post-preview-stats-group {
    display: flex;
    gap: 6px;
    align-items: center;
}
.post-preview-stat {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    color: #64748b;
    font-weight: 600;
}
.post-preview-stat svg {
    width: 13px;
    height: 13px;
}

/* ── Post Preview Actions ── */
.post-preview-actions {
    display: flex;
    gap: 8px;
    align-items: center;
    margin-left: auto;
}
.post-preview-action-btn {
    background: none;
    border: none;
    cursor: pointer;
    padding: 4px 6px;
    border-radius: 4px;
    transition: all 0.2s;
    color: #94a3b8;
    display: flex;
    align-items: center;
    justify-content: center;
}
.post-preview-action-btn:hover {
    background: #e2e8f0;
    color: var(--brand-red);
}
.post-preview-action-btn-delete:hover {
    color: #ef4444;
}

/* ── Post Preview Stats Buttons ── */
.post-preview-stat-btn {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 8px;
    border: none;
    background: transparent;
    cursor: pointer;
    font-size: 12px;
    color: #94a3b8;
    transition: all 0.2s;
    border-radius: 6px;
    min-width: 30px;
    justify-content: center;
    -webkit-user-select: none;
    user-select: none;
}
.post-preview-stat-btn:hover {
    background: #f1f5f9;
    color: #475569;
}
.post-preview-stat-btn.liked {
    color: #f43f5e;
}
.post-preview-stat-btn.disliked {
    color: #64748b;
}
.post-preview-stat-btn svg {
    width: 14px;
    height: 14px;
    pointer-events: none;
    flex-shrink: 0;
}
.post-preview-stat-like:hover {
    color: #f43f5e;
}
.post-preview-stat-dislike:hover {
    color: #64748b;
}
.comment-modal-footer {
    padding: 16px 24px;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
    display: flex;
    gap: 12px;
    justify-content: flex-end;
}
.comment-form-group {
    margin-bottom: 16px;
}
.comment-form-label {
    font-size: 12px;
    font-weight: 800;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
    display: block;
}
.comment-form-textarea {
    width: 100%;
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    padding: 10px 12px;
    font-size: 14px;
    font-weight: 500;
    font-family: 'Plus Jakarta Sans', sans-serif;
    resize: vertical;
    min-height: 70px;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
    color: #0f172a;
}
.comment-form-textarea:focus {
    border-color: #f43f5e;
    box-shadow: 0 0 0 3px rgba(244, 63, 94, 0.08);
}
.comment-form-textarea::placeholder {
    color: #94a3b8;
}
.comment-checkbox {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 16px;
}
.comment-checkbox input {
    width: 16px;
    height: 16px;
    cursor: pointer;
    accent-color: #f43f5e;
}
.comment-checkbox label {
    font-size: 13px;
    font-weight: 600;
    color: #475569;
    cursor: pointer;
    margin: 0;
}
.comment-btn {
    padding: 10px 24px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 800;
    cursor: pointer;
    border: none;
    transition: all 0.2s;
}
.comment-btn-submit {
    background: #a12124;
    color: #fff;
}
.comment-btn-submit:hover {
    background: #7d181b;
}
.comment-btn-submit:disabled {
    background: #cbd5e1;
    cursor: not-allowed;
}
.comment-btn-cancel {
    background: #f1f5f9;
    color: #64748b;
}
.comment-btn-cancel:hover {
    background: #e2e8f0;
}

/* ── Comment Display Styles ── */
.comment-item {
    display: flex;
    flex-direction: column;
    gap: 12px;
    padding: 12px;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    background: #fff;
    font-size: 13px;
    width: 100%;
}
.comment-avatar-small {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 12px;
    color: var(--brand-red);
    flex-shrink: 0;
    overflow: hidden;
}
.comment-avatar-small img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.comment-content {
    flex: 1;
}
.comment-author {
    font-weight: 700;
    color: #0f172a;
    font-size: 13px;
}
.comment-meta {
    font-size: 11px;
    color: #94a3b8;
    margin-top: 2px;
}
.comment-text {
    color: #475569;
    margin-top: 6px;
    line-height: 1.5;
    word-break: break-word;
}

/* ── Comment Actions ── */
.comment-actions {
    display: flex;
    gap: 8px;
    margin-top: 8px;
    padding-top: 8px;
    border-top: 1px solid #f1f5f9;
    align-items: center;
    justify-content: space-between;
}

.comment-actions-left {
    display: flex;
    gap: 6px;
}

.comment-actions-right {
    display: flex;
    gap: 4px;
}

.comment-action-btn {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 8px;
    border: none;
    background: transparent;
    cursor: pointer;
    font-size: 12px;
    color: #94a3b8;
    transition: all 0.2s;
    border-radius: 6px;
}

.comment-action-btn:hover {
    background: #f1f5f9;
    color: #475569;
}

.comment-action-btn.liked {
    color: #f43f5e;
}

.comment-action-btn.disliked {
    color: #64748b;
}

.comment-action-btn svg {
    width: 14px;
    height: 14px;
}

.comment-action-btn-edit,
.comment-action-btn-delete,
.comment-action-btn-like,
.comment-action-btn-dislike,
.reply-btn {
    padding: 4px 8px;
}

.comment-action-btn-edit:hover {
    background: #fef2f2;
    color: var(--brand-red);
}

.comment-action-btn-delete:hover {
    background: #fef2f2;
    color: #ef4444;
}

.reply-btn:hover {
    background: #f1f5f9;
    color: #475569;
}

/* ── Toggle Replies Button (Like forum_view.php) ── */
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

.comment-empty {
    text-align: center;
    padding: 32px 24px;
    color: #94a3b8;
    font-size: 13px;
    background: #f8fafc;
    border-radius: 12px;
    border: 1px dashed #e2e8f0;
    margin-bottom: 16px;
    line-height: 1.6;
}

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
.modal-dialog {
    margin-top: 10vh; /* Prevents navbar overlap */
}
.create-modal .modal-content {
    border-radius: 24px; border: none;
    box-shadow: 0 25px 60px -10px rgba(0,0,0,.2);
    overflow: hidden;
    position: relative;
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
    border-color: var(--brand-red); box-shadow: 0 0 0 3px rgba(161,33,36,.08);
    outline: none;
}
.create-modal .btn-post {
    background: var(--brand-red); color: #fff; border: none;
    border-radius: 14px; padding: 10px 32px; font-weight: 800;
    font-size: 14px; transition: background .2s; flex-shrink: 0;
}
.create-modal .btn-post:hover { background: var(--brand-red-dark); }

.generate-ai-btn {
    background: var(--brand-red); color: #fff; border: none;
    border-radius: 12px; padding: 10px 20px; font-weight: 800;
    font-size: 13px; cursor: pointer; transition: background .2s;
    white-space: nowrap; width: 100%; outline: none;
}
.generate-ai-btn:hover { background: var(--brand-red-dark); }

.action-loading-overlay {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.30);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 20000;
    backdrop-filter: blur(2px);
    pointer-events: all;
}

.action-loading-overlay.show {
    display: flex;
}

.action-loading-card {
    background: #fff;
    border: 1px solid #f1d5d7;
    border-radius: 14px;
    padding: 14px 18px;
    display: flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 12px 30px -15px rgba(161, 33, 36, .35);
}

.action-loading-spinner {
    width: 16px;
    height: 16px;
    border: 2px solid #f3c7cb;
    border-top-color: var(--brand-red);
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

@keyframes slideInUp {
    from { 
        opacity: 0; 
        transform: translateY(20px); 
    }
    to { 
        opacity: 1; 
        transform: translateY(0); 
    }
}

@keyframes slideOutDown {
    from { 
        opacity: 1; 
        transform: translateY(0); 
    }
    to { 
        opacity: 0; 
        transform: translateY(20px); 
    }
}

body.ui-locked {
    overflow: hidden;
}

body.ui-locked * {
    cursor: wait !important;
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(16px); }
    to { opacity: 1; transform: translateY(0); }
}
.post-card { animation: fadeInUp .3s ease-out forwards; }

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
    .forum-layout { grid-template-columns: 1fr; }
    .forum-sidebar { display: none; }
    .tab-content { display: none; }
    .tab-content.active { display: block; }
    .badge { font-size: 10px; padding: 2px 6px; }
    .badge i { font-size: 9px; }
}
</style>

<!-- ── Page header bar ── -->
<div class="forum-header-bar">
    <div style="max-width:1185px; margin:0 auto; padding:12px 25px; display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap;">
        <div style="display:flex; align-items:center; gap:12px;">
            <div style="width:40px;height:40px;background:var(--brand-red);border-radius:14px;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(161,33,36,.25);">
                <svg style="width:20px;height:20px;color:#fff;fill:none;stroke:#fff;stroke-width:2;" viewBox="0 0 24 24"><path d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/></svg>
            </div>
            <div>
                <h1 style="font-size:18px;font-weight:800;color:#0f172a;margin:0;">Forum <span style="color:var(--brand-red);">Discussions</span></h1>
                <p style="font-size:10px;font-weight:700;color:#343434;text-transform:uppercase;letter-spacing:.15em;margin:0;">Alumni Community · <?= $total_posts ?? 0 ?> Posts</p>
            </div>
        </div> 
    </div>
</div>

<!-- ── Main layout ── -->
<div class="forum-layout">

    <!-- ── Main feed ── -->
    <div id="feed-tab" class="tab-content active">
        <!-- Search + Sort row -->
        <div style="display:flex; flex-wrap:wrap; gap:10px; align-items:center; margin-bottom:20px;">
            <div class="forum-search-bar" style="flex:1; min-width:200px;">
                <svg width="16" height="16" fill="none" stroke="#94a3b8" viewBox="0 0 24 24"><path stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" id="search-input" placeholder="Search discussions..." value="<?= htmlspecialchars($this->input->get('search') ?? '') ?>">
            </div>
            <div class="sort-tabs">
                <a href="<?= base_url('forum?sort=') ?>" class="sort-tab <?= (!$this->input->get('sort') || $this->input->get('sort')=='') ? 'active' : '' ?>" onclick="saveForumSort('')">🔥 Latest</a>
                <a href="<?= base_url('forum?sort=likes') ?>" class="sort-tab <?= $this->input->get('sort')=='likes' ? 'active' : '' ?>" onclick="saveForumSort('likes')">❤️ Top</a>
                <a href="<?= base_url('forum?sort=comments') ?>" class="sort-tab <?= $this->input->get('sort')=='comments' ? 'active' : '' ?>" onclick="saveForumSort('comments')">💬 Hot</a>
                <a href="<?= base_url('forum?sort=myposts') ?>" class="sort-tab <?= $this->input->get('sort')=='myposts' ? 'active' : '' ?>" onclick="saveForumSort('myposts')">👤 Mine</a>
            </div>
        </div>

        <!-- ── Mobile Tab Buttons ── -->
        <div class="mobile-tabs" style="margin-bottom: 16px;">
            <button class="f-pill active" id="btn-feed" onclick="updateForumTab('feed')">Feed</button>
            <button class="f-pill" id="btn-about" onclick="updateForumTab('about')">About</button>
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
                <div class="post-card" style="animation-delay:<?= $idx * 40 ?>ms; cursor: pointer;" onclick="window.location.href='<?= base_url('forum/view/'.$p->id) ?>';">
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
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span class="post-author"><?= htmlspecialchars($p->first_name.' '.$p->last_name) ?></span>
                                    <?php if (isset($p->standing_badge)): ?>
                                        <span class="<?= $p->standing_badge['badge_class'] ?>" style="font-size: 11px; padding: 3px 8px;" title="<?= $p->standing_badge['description'] ?>">
                                            <i class="<?= $p->standing_badge['icon'] ?>"></i> <?= $p->standing_badge['title'] ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($p->valid) && $p->valid == 0): ?>
                                <span style="background:#fef2f2;color:#e53e3e;font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;text-transform:uppercase;letter-spacing:0.5px;margin-left:auto;">🗑️ Deleted</span>
                            <?php elseif (!empty($p->has_profanity) && $p->has_profanity): ?>
                                <span style="background:#fef2f2;color:#e53e3e;font-size:10px;font-weight:700;padding:2px 8px;border-radius:20px;text-transform:uppercase;letter-spacing:0.5px;margin-left:auto;">⚠ Flagged</span>
                            <?php else: ?>
                                <span class="post-time">· <?= time_ago($p->created_at) ?></span>
                            <?php endif; ?>
                        </div>

                        <h3 class="post-title"><?= htmlspecialchars($p->censored_title ?? $p->title) ?></h3>
                        <?php if (!empty($p->censored_content)): ?>
                            <p class="post-preview"><?= htmlspecialchars(substr($p->censored_content, 0, 150)) ?></p>
                        <?php endif; ?>

                        <div class="post-stats">
                            <span class="post-stat post-stat-likes">
                                <svg fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                                <?= $p->like_count ?> likes
                            </span>
                            <span class="post-stat post-stat-dislikes">
                                <svg fill="currentColor" viewBox="0 0 20 20"><path d="M16.828 14.828a4 4 0 01-5.656 0L10 13.657l-1.172 1.171a4 4 0 11-5.656-5.656L10 2.343l6.828 6.829a4 4 0 010 5.656z"/></svg>
                                <?= $p->dislike_count ?? 0 ?> dislikes
                            </span>
                            <span class="post-stat" style="cursor:pointer;" onclick="event.stopPropagation(); openCommentModal(event, <?= $p->id ?>)">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                <?= $p->comment_count ?> comments
                            </span>
                        </div>
                    </div>
                </div>
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

    <!-- ── Sidebar / About Tab ── -->
    <div id="about-tab" class="tab-content forum-sidebar">
        <!-- ── Mobile Tab Buttons ── -->
        <div class="mobile-tabs" style="margin-bottom: 16px;">
            <button class="f-pill" id="btn-feed2" onclick="updateForumTab('feed')">Feed</button>
            <button class="f-pill active" id="btn-about2" onclick="updateForumTab('about')">About</button>
        </div>

        <div class="forum-sidebar-card" style="background:linear-gradient(135deg,var(--brand-red) 0%,#7d181b 100%);border:none;">
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
            <div id="post-action-loading" class="action-loading-overlay" aria-live="polite" aria-hidden="true">
                <div class="action-loading-card">
                    <span class="action-loading-spinner"></span>
                    <span id="post-action-loading-text" style="font-size:13px;font-weight:700;color:#7d181b;">Processing...</span>
                </div>
            </div>
            <div class="modal-header">
                <h5 class="modal-title">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:inline;vertical-align:middle;margin-right:8px;"><path stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Create Discussion
                </h5>
                <button type="button" class="close" data-dismiss="modal" style="color:rgba(255,255,255,.8);font-size:22px;">&times;</button>
            </div>
            <form id="create-discussion-form" method="post" action="<?= base_url('forum/create_post') ?>" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Discussion Title</label>
                        <input type="text" name="title" class="form-control" placeholder="What's on your mind?" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Content</label>
                        <textarea name="content" id="forum-content" class="form-control" rows="5" placeholder="Share your thoughts, questions, or insights..." required></textarea>
                    </div>
                    <div class="form-group" style="display:flex;gap:10px;align-items:flex-end;margin-bottom:16px;">
                        <button type="button" id="generate-post-btn" class="generate-ai-btn" onclick="generateForumPost()">
                              Generate with AI
                        </button>
                    </div>

                    <!-- ── AI Generated Content Preview ── -->
                    <div id="generation-preview" style="display:none;margin-bottom:16px;background:#fef2f2;border:1.5px solid #fda4af;border-radius:12px;padding:16px;">
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
                            <svg width="16" height="16" fill="#a12124" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span style="font-size:12px;font-weight:700;color:#a12124;">Preview Generated Content</span>
                        </div>
                        <div style="background:#fff;border-radius:8px;padding:12px;margin-bottom:12px;">
                            <div style="margin-bottom:10px;">
                                <div style="font-size:11px;font-weight:800;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px;">Title</div>
                                <div id="preview-title" style="font-size:14px;font-weight:700;color:#0f172a;line-height:1.4;"></div>
                            </div>
                            <div style="border-top:1px solid #e2e8f0;padding-top:10px;">
                                <div style="font-size:11px;font-weight:800;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:4px;">Content</div>
                                <div id="preview-content" style="font-size:13px;color:#475569;line-height:1.6;"></div>
                            </div>
                        </div>
                        <div style="margin-top:8px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:10px 12px;margin-bottom:12px;">
                            <div style="font-size:11px;color:#475569;line-height:1.5;margin-bottom:4px;">
                                <span style="font-weight:800;color:#334155;">Why improved:</span>
                                <span id="preview-improvement-reason"></span>
                            </div>
                        </div>
                        <div style="display:flex;gap:8px;">
                            <button type="button" onclick="acceptGeneratedContent()" style="flex:1;background:var(--brand-red);color:#fff;border:none;border-radius:8px;padding:8px 12px;font-weight:700;font-size:12px;cursor:pointer;transition:background .2s;">
                                 Keep changes
                            </button>
                            <button type="button" onclick="discardGeneratedContent()" style="flex:1;background:#f1f5f9;color:#64748b;border:none;border-radius:8px;padding:8px 12px;font-weight:700;font-size:12px;cursor:pointer;transition:background .2s;">
                                 Discard
                            </button>
                        </div>
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
                    <button type="button" class="btn btn-light" data-dismiss="modal" onclick="clearFormFields()" style="border-radius:12px;font-weight:700;padding:10px 24px;">Cancel</button>
                    <button type="submit" id="publish-discussion-btn" class="btn-post">Publish Discussion</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ── Comment Modal ── -->
<div id="commentModalOverlay" class="comment-modal-overlay">
    <div class="comment-modal-content">
        <div class="comment-modal-header">
            <h3 class="comment-modal-title">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                Comments
            </h3>
            <button type="button" class="comment-modal-close" onclick="closeCommentModal()">&times;</button>
        </div>
        <div class="comment-modal-body">
            <!-- Post Preview Section -->
            <div id="postPreviewContainer">
                <div id="postPreview" class="post-preview-card">
                    <div style="text-align: center; color: #94a3b8; font-size: 13px; flex: 1;">Loading post...</div>
                </div>
            </div>

            <!-- Comment Sorting Dropdown -->
            <div style="margin-bottom: 8px; padding: 6px 0;">
                <select id="commentSortDropdown" onchange="loadCommentsWithSort(this.value)" style="padding: 6px 12px; border-radius: 16px; font-size: 12px; font-weight: 700; border: 1px solid #e2e8f0; background: #fff; color: #64748b; cursor: pointer; transition: all .2s;">
                    <option value="newest">Newest</option>
                    <option value="most_relevant" selected>Most Relevant</option>
                    <option value="oldest">Oldest</option>
                </select>
            </div>
            
            <!-- Existing Comments Section -->
            <div id="existingCommentsContainer" style="margin-bottom: 20px; max-height: 350px; overflow-y: auto; flex: 1; display: flex; flex-direction: column; gap: 12px; padding-right: 8px;">
                <div id="commentsLoader" style="text-align: center; padding: 16px;">
                    <div style="width: 16px; height: 16px; border: 2px solid #e2e8f0; border-top-color: var(--brand-red); border-radius: 50%; animation: spin 0.8s linear infinite; margin: 0 auto;"></div>
                </div>
            </div>
            
            <!-- Comment Form -->
            <?php echo form_open('forum/add_comment', array('id' => 'comment-form', 'class' => 'w-100')); ?>
            
            <div style="border-top: 1px solid #e2e8f0; padding-top: 12px; margin-bottom: 12px;">
                <h4 style="font-size: 12px; font-weight: 800; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 12px;">Add Your Comment</h4>
            </div>
 
            <div class="comment-form-group">
                <label class="comment-form-label">Your Comment</label>
                <textarea 
                    name="comment_text" 
                    id="commentText" 
                    class="comment-form-textarea"
                    placeholder="Share your thoughts..."
                    maxlength="500"
                    required></textarea>
                <small style="color:#94a3b8;font-size:11px;margin-top:4px;display:block;">
                    <span id="charCount">0</span>/500 characters
                </small>
            </div>

            <div class="comment-checkbox">
                <input type="checkbox" id="anonymousComment" name="is_anonymous" value="1">
                <label for="anonymousComment">Post as Anonymous</label>
            </div>

            <!-- Hidden post ID field -->
            <input type="hidden" id="postIdField" name="post_id" value="">
            
            <div class="comment-modal-footer">
                <button type="button" class="comment-btn comment-btn-cancel" onclick="closeCommentModal()">Cancel</button>
                <button type="button" class="comment-btn comment-btn-submit" id="submitCommentBtn" onclick="submitCommentFromModal()">Post Comment</button>
            </div>

            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<!-- ── Edit Post Modal (for post preview) ── -->
<div class="modal fade create-modal" id="editPostPreviewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Post</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="editPostPreviewForm" method="post" action="<?= base_url('forum/update_post') ?>" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="post_id" id="preview-edit-post-id">
                    
                    <div class="form-group">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" id="preview-edit-post-title" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Content</label>
                        <textarea name="content" id="preview-edit-post-content" class="form-control" rows="4" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Current Image</label>
                        <img 
                            id="preview-edit-post-image-preview"
                            style="width:100%;max-height:200px;object-fit:contain;border-radius:10px;margin-bottom:10px;display:none;">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Replace Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e2e8f0; padding: 16px 24px; display: flex; gap: 8px; justify-content: flex-end; flex-wrap: nowrap;">
                    <button type="button" class="btn" style="background: #cbd5e1; color: #1e293b; border: none; border-radius: 14px; padding: 10px 28px; font-weight: 700; cursor: pointer; transition: background .2s; flex-shrink: 0;" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-post" style="background: var(--brand-red); color: #fff; border: none; border-radius: 14px; padding: 10px 28px; font-weight: 700; cursor: pointer; transition: background .2s;">Update Post</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ── Edit Comment Modal ── -->
<div id="editModalOverlay" class="comment-modal-overlay">
    <div class="comment-modal-content">
        <div class="comment-modal-header">
            <h3 class="comment-modal-title">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Comment
            </h3>
            <button type="button" class="comment-modal-close" onclick="closeEditModal()">&times;</button>
        </div>
        <div class="comment-modal-body">
            <form id="edit-comment-form">
                <div class="comment-form-group">
                    <label class="comment-form-label">Comment Text</label>
                    <textarea 
                        id="editCommentText"
                        name="comment_text"
                        class="comment-form-textarea"
                        placeholder="Share your thoughts..."
                        maxlength="500"
                        style="margin-bottom: 8px; resize: vertical; min-height: 80px;"
                        required></textarea>
                    <small style="color:#94a3b8;font-size:11px;margin-top:4px;display:block;">
                        <span id="editCharCount">0</span>/500 characters
                    </small>
                </div>
                
                <input type="hidden" name="comment_id" id="editCommentId" value="">
                <input type="hidden" name="post_id" id="editPostId" value="">
                
                <div class="comment-modal-footer">
                    <button type="button" class="comment-btn comment-btn-cancel" onclick="closeEditModal()">Cancel</button>
                    <button type="button" class="comment-btn comment-btn-submit" id="submitEditBtn" onclick="submitEditComment()">Update Comment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Store current post context
let currentPostIdInModal = null;
let currentPostCardElement = null;

// ===== COMMENT MODAL FUNCTIONS =====
function openCommentModal(event, postId) {
    event.preventDefault();
    event.stopPropagation();
    
    // Store the post ID and card element for later reference
    currentPostIdInModal = postId;
    currentPostCardElement = event.target.closest('.post-card');
    
    // Set the post ID in hidden field
    document.getElementById('postIdField').value = postId;
    
    // Clear and reset form
    document.getElementById('commentText').value = '';
    document.getElementById('anonymousComment').checked = false;
    document.getElementById('charCount').textContent = '0';
    document.getElementById('submitCommentBtn').disabled = false;
    document.getElementById('submitCommentBtn').textContent = 'Post Comment';
    
    // Show modal with animation
    const overlay = document.getElementById('commentModalOverlay');
    overlay.classList.add('active');
    
    // Display post preview from card
    displayPostPreview();
    
    // Load comments for this post
    loadCommentsForModal(postId);
    
    // Focus on textarea
    setTimeout(() => {
        document.getElementById('commentText').focus();
    }, 100);
}

// ===== POST PREVIEW ACTIONS: LIKE/DISLIKE/EDIT/DELETE =====
function likePostPreview(postId) {
    console.log('Like button clicked for post:', postId);
    
    fetch('<?= base_url('forum/like/') ?>' + postId, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        console.log('Like response:', response.status, response.ok);
        return response.json();
    })
    .then(data => {
        console.log('Like data:', data);
        if (data.success && currentPostCardElement) {
            // Update the like count in the DOM
            const likeStats = currentPostCardElement.querySelectorAll('.post-stat');
            if (likeStats.length > 0) {
                // First .post-stat is likes
                const likeText = data.new_count + ' ' + (data.new_count === 1 ? 'Like' : 'Likes');
                likeStats[0].textContent = likeText;
                
                // Re-fetch the SVG if needed
                const likeSvg = likeStats[0].querySelector('svg');
                if (!likeSvg && likeStats[0].children.length === 0) {
                    likeStats[0].innerHTML = `<svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg> ` + likeText;
                }
            }
        }
        displayPostPreview();
    })
    .catch(error => {
        console.error('Like error:', error);
    });
}

function dislikePostPreview(postId) {
    console.log('Dislike button clicked for post:', postId);
    
    fetch('<?= base_url('forum/dislike/') ?>' + postId, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        console.log('Dislike response:', response.status, response.ok);
        return response.json();
    })
    .then(data => {
        console.log('Dislike data:', data);
        if (data.success && currentPostCardElement) {
            // Update the dislike count in the DOM
            const likeStats = currentPostCardElement.querySelectorAll('.post-stat');
            if (likeStats.length > 1) {
                // Second .post-stat is dislikes
                const dislikeText = data.new_count + ' ' + (data.new_count === 1 ? 'Dislike' : 'Dislikes');
                likeStats[1].textContent = dislikeText;
                
                // Re-fetch the SVG if needed
                const dislikeSvg = likeStats[1].querySelector('svg');
                if (!dislikeSvg && likeStats[1].children.length === 0) {
                    likeStats[1].innerHTML = `<svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path d="M16.828 14.828a4 4 0 01-5.656 0L10 13.657l-1.172 1.171a4 4 0 11-5.656-5.656L10 2.343l6.828 6.829a4 4 0 010 5.656z"/></svg> ` + dislikeText;
                }
            }
        }
        displayPostPreview();
    })
    .catch(error => {
        console.error('Dislike error:', error);
    });
}

function openEditPostPreview(postId) {
    if (!currentPostCardElement) return;
    
    // Extract data from the post preview card element
    const postTitle = currentPostCardElement.querySelector('.post-title');
    const postContent = currentPostCardElement.querySelector('.post-preview');
    const postImage = currentPostCardElement.querySelector('img.post-image');
    
    const title = postTitle ? postTitle.textContent.trim() : '';
    const content = postContent ? postContent.textContent.trim() : '';
    const imageUrl = postImage ? postImage.src : '';
    
    // Populate modal form fields
    document.getElementById('preview-edit-post-id').value = postId;
    document.getElementById('preview-edit-post-title').value = title;
    document.getElementById('preview-edit-post-content').value = content;
    
    // Show/hide image preview
    const imagePreview = document.getElementById('preview-edit-post-image-preview');
    if (imageUrl && imageUrl.trim()) {
        imagePreview.src = imageUrl;
        imagePreview.style.display = 'block';
    } else {
        imagePreview.style.display = 'none';
    }
    
    // Store postId for form submission
    window.editingPostPreviewId = postId;
    
    // Show modal
    $('#editPostPreviewModal').modal('show');
}

// Handle edit post preview form submission
document.addEventListener('DOMContentLoaded', function() {
    const editPostForm = document.getElementById('editPostPreviewForm');
    if (editPostForm) {
        editPostForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const postId = document.getElementById('preview-edit-post-id').value;
            const title = document.getElementById('preview-edit-post-title').value;
            const content = document.getElementById('preview-edit-post-content').value;
            
            if (!postId || !title || !content) {
                alert('Please fill in all required fields.');
                return;
            }
            
            const submitBtn = editPostForm.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Updating...';
            
            const formData = new FormData(editPostForm);
            
            fetch('<?= base_url('forum/update_post') ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                // Log the response for debugging
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
                
                if (data.success) {
                    showToast('Post updated successfully!', 'success');
                    $('#editPostPreviewModal').modal('hide');
                    // Refresh the post preview
                    displayPostPreview();
                    // Reload the feed
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    alert('Error updating post: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error updating post:', error);
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
                alert('Error updating post: ' + error.message);
            });
        });
    }
});

function deletePostPreview(postId) {
    if (!confirm('Are you sure you want to delete this post? This action cannot be undone.')) {
        return;
    }
    
    fetch('<?= base_url('forum/delete/') ?>' + postId, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Post deleted successfully!', 'success');
            closeCommentModal();
            // Reload the page to show updated posts
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            alert('Error deleting post: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error deleting post:', error);
        alert('Error deleting post. Please try again.');
    });
}


function displayPostPreview() {
    if (!currentPostCardElement) return;
    
    // Extract data from post card
    const postMeta = currentPostCardElement.querySelector('.post-meta');
    const postTitle = currentPostCardElement.querySelector('.post-title');
    const postPreview = currentPostCardElement.querySelector('.post-preview');
    const postStats = currentPostCardElement.querySelector('.post-stats');
    const postAvatar = currentPostCardElement.querySelector('.post-avatar');
    
    // Extract author info and time
    let authorText = 'Anonymous';
    let timeText = '';
    
    if (postMeta) {
        const anonBadge = postMeta.querySelector('.anon-badge');
        if (!anonBadge) {
            const authorSpan = postMeta.querySelector('.post-author');
            if (authorSpan) {
                authorText = escapeHtml(authorSpan.textContent.trim());
            }
        }
    }
    
    // Look for time in post-meta or the entire card
    const timeSpan = currentPostCardElement.querySelector('.post-time');
    if (timeSpan) {
        timeText = timeSpan.textContent.trim();
    }
    
    // Get post title
    const titleText = postTitle ? escapeHtml(postTitle.textContent.trim()) : 'Post';
    
    // Get post content preview (first 100 chars)
    const contentText = postPreview ? escapeHtml(postPreview.textContent.trim()).substring(0, 100) : '';
    
    // Extract stats with icons and make them interactive
    let likeDislikeHtml = '';
    if (postStats) {
        const stats = postStats.querySelectorAll('.post-stat');
        stats.forEach((stat, idx) => {
            const icon = stat.querySelector('svg');
            const text = stat.textContent.trim();
            if (icon) {
                const svgClone = icon.cloneNode(true);
                // Add like/dislike buttons for first two stats
                if (idx === 0) {
                    // Like button - simple button approach like vote-btn
                    likeDislikeHtml += `<a href="<?= base_url('forum/like/') ?>${currentPostIdInModal}" class="post-preview-stat-btn post-preview-stat-like" style="text-decoration:none;cursor:pointer;">
                        ${svgClone.outerHTML}
                        <span>${text}</span>
                    </a>`;
                } else if (idx === 1) {
                    // Dislike button - simple button approach like vote-btn
                    likeDislikeHtml += `<a href="<?= base_url('forum/dislike/') ?>${currentPostIdInModal}" class="post-preview-stat-btn post-preview-stat-dislike" style="text-decoration:none;cursor:pointer;">
                        ${svgClone.outerHTML}
                        <span>${text}</span>
                    </a>`;
                }
            }
        });
    }
    
    const statsHtml = `<div class="post-preview-stats-group">${likeDislikeHtml}</div>`;
    
    // Get avatar strictly from post-avatar element
    let avatarContent = '?';
    if (postAvatar) {
        const avatarHtml = postAvatar.innerHTML;
        if (avatarHtml) {
            avatarContent = avatarHtml;
        }
    }
    
    // Build HTML with proper structure and action buttons
    const previewHtml = `
        <div style="display: flex; gap: 12px; align-items: flex-start; margin-bottom: 8px; padding-bottom: 8px; border-bottom: 1px solid #f1f5f9;">
            <div class="post-view-avatar">
                ${avatarContent}
            </div>
            <div style="flex: 1; display: flex; flex-direction: column; gap: 2px;">
                <div style="display: flex; align-items: baseline; gap: 6px;">
                    <div class="post-preview-author" style="margin-bottom: 0; padding-bottom: 0; border-bottom: none;">${authorText}</div>
                    ${timeText ? `<div class="post-preview-time">${timeText}</div>` : ''}
                </div>
            </div>
        </div>
        <div class="post-preview-content">
            <div class="post-preview-title">${titleText}</div>
            ${contentText ? `<div class="post-preview-excerpt">${contentText}${contentText.length >= 100 ? '...' : ''}</div>` : ''}
            <div style="display: flex; gap: 8px; align-items: center; margin-top: 8px;">
                ${statsHtml ? `<div class="post-preview-stats">${statsHtml}</div>` : ''}
                <div class="post-preview-actions">
                    <button class="post-preview-action-btn" title="Edit" onclick="openEditPostPreview(${currentPostIdInModal})">
                        <svg fill="currentColor" viewBox="0 0 20 20" style="width:13px;height:13px;">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                        </svg>
                    </button>
                    <button class="post-preview-action-btn post-preview-action-btn-delete" title="Delete" onclick="deletePostPreview(${currentPostIdInModal})">
                        <svg fill="currentColor" viewBox="0 0 20 20" style="width:13px;height:13px;">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('postPreview').className = 'post-preview-card';
    document.getElementById('postPreview').innerHTML = previewHtml;
    
    // Add click handlers for like/dislike buttons
    const postPreviewEl = document.getElementById('postPreview');
    postPreviewEl.querySelectorAll('.post-preview-stat-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const href = this.getAttribute('href');
            const isLike = this.classList.contains('post-preview-stat-like');
            
            if (href) {
                fetch(href, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && currentPostCardElement) {
                        // Update the DOM's stats with the new count from backend
                        const stats = currentPostCardElement.querySelectorAll('.post-stat');
                        if (isLike && stats.length > 0) {
                            // Update like count in DOM
                            const likeText = data.new_count + ' ' + (data.new_count === 1 ? 'likes' : 'likes');
                            for (let i = 0; i < stats[0].childNodes.length; i++) {
                                if (stats[0].childNodes[i].nodeType === 3 && stats[0].childNodes[i].textContent.trim()) {
                                    stats[0].childNodes[i].textContent = likeText;
                                    break;
                                }
                            }
                            // Reset dislike count to 0
                            if (stats.length > 1) {
                                const dislikeText = '0 dislikes';
                                for (let i = 0; i < stats[1].childNodes.length; i++) {
                                    if (stats[1].childNodes[i].nodeType === 3 && stats[1].childNodes[i].textContent.trim()) {
                                        stats[1].childNodes[i].textContent = dislikeText;
                                        break;
                                    }
                                }
                            }
                        } else if (!isLike && stats.length > 1) {
                            // Update dislike count in DOM
                            const dislikeText = data.new_count + ' ' + (data.new_count === 1 ? 'dislikes' : 'dislikes');
                            for (let i = 0; i < stats[1].childNodes.length; i++) {
                                if (stats[1].childNodes[i].nodeType === 3 && stats[1].childNodes[i].textContent.trim()) {
                                    stats[1].childNodes[i].textContent = dislikeText;
                                    break;
                                }
                            }
                            // Reset like count to 0
                            if (stats.length > 0) {
                                const likeText = '0 likes';
                                for (let i = 0; i < stats[0].childNodes.length; i++) {
                                    if (stats[0].childNodes[i].nodeType === 3 && stats[0].childNodes[i].textContent.trim()) {
                                        stats[0].childNodes[i].textContent = likeText;
                                        break;
                                    }
                                }
                            }
                        }
                    }
                    // Now refresh the preview with updated DOM data
                    displayPostPreview();
                })
                .catch(error => {
                    console.error('Error:', error);
                    displayPostPreview();
                });
            }
        });
    });
}

// Store current sort preference for comments
let currentCommentSort = 'newest';

function loadCommentsWithSort(sortType) {
    // Remove active class from all sort tabs
    const allSortTabs = document.querySelectorAll('.comment-modal-body .sort-tab');
    allSortTabs.forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Add active class to clicked tab
    if (event && event.target) {
        event.target.classList.add('active');
    }
    
    // Store the sort preference
    currentCommentSort = sortType;
    
    // Reload comments with new sort
    loadCommentsForModal(currentPostIdInModal, sortType);
}

function loadCommentsForModal(postId, sortType = 'newest') {
    const container = document.getElementById('existingCommentsContainer');
    
    // Show loading state
    container.innerHTML = '<div id="commentsLoader" style="text-align: center; padding: 16px;"><div style="width: 16px; height: 16px; border: 2px solid #e2e8f0; border-top-color: var(--brand-red); border-radius: 50%; animation: spin 0.8s linear infinite; margin: 0 auto;"></div></div>';
    
    // Fetch comments via AJAX
    fetch('<?= base_url('forum/get_comments/') ?>' + postId + '/' + sortType, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('HTTP error, status: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log('Comments data:', data);
        if (data.success && data.comments && data.comments.length > 0) {
            renderComments(data.comments, container);
        } else if (data.success && (!data.comments || data.comments.length === 0)) {
            // No comments, show empty state
            container.innerHTML = `
                <div class="comment-empty">
                    <svg width="48" height="48" fill="none" stroke="#cbd5e1" viewBox="0 0 24 24" style="margin: 0 auto 12px; display: block; opacity: 0.4;">
                        <path stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <strong style="display: block; color: #0f172a; margin-bottom: 6px;">No comments yet</strong>
                    <span>Be the first to share your thoughts on this post!</span>
                </div>
            `;
        } else {
            throw new Error('Invalid response format');
        }
    })
    .catch(error => {
        console.error('Error loading comments:', error);
        container.innerHTML = `
            <div class="comment-empty">
                <svg width="48" height="48" fill="none" stroke="#cbd5e1" viewBox="0 0 24 24" style="margin: 0 auto 12px; display: block; opacity: 0.4;">
                    <path stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <strong style="display: block; color: #0f172a; margin-bottom: 6px;">Could not load comments</strong>
            </div>
        `;
    });
}

function renderComments(comments, container) {
    // Organize comments into parent/child structure
    const commentMap = {};
    const topLevelComments = [];
    
    comments.forEach(comment => {
        commentMap[comment.id] = { ...comment, replies: [] };
    });
    
    comments.forEach(comment => {
        if (comment.parent_id && comment.parent_id !== 0) {
            // This is a reply
            if (commentMap[comment.parent_id]) {
                commentMap[comment.parent_id].replies.push(commentMap[comment.id]);
            }
        } else {
            // This is a top-level comment
            topLevelComments.push(commentMap[comment.id]);
        }
    });
    
    let html = '';
    
    // Render top-level comments with their nested replies
    topLevelComments.forEach(comment => {
        const replyCount = comment.replies ? comment.replies.length : 0;
        html += renderCommentItem(comment, false, replyCount);
        
        // Render nested replies with disclosure
        if (comment.replies && comment.replies.length > 0) {
            html += `
                <div id="replies-${comment.id}" class="replies-container" style="display: none; border-left: 2px solid #e2e8f0; padding-left: 16px; margin-top: 8px; margin-left: 32px;">
                    ${comment.replies.map(reply => renderCommentItem(reply, true, 0)).join('')}
                </div>
            `;
        }
    });
    
    container.innerHTML = html;
}

// Toggle replies with jQuery slideToggle
$(document).on('click', '.toggle-replies', function(e){
    e.preventDefault();
    let id = $(this).data('id');
    let replies = $('#replies-' + id);
    
    $(this).toggleClass('active');
    replies.slideToggle(300);
});


function renderCommentItem(comment, isReply = false, replyCount = 0) {
    // Ensure is_anonymous is properly cast to boolean
    const isAnon = parseInt(comment.is_anonymous) === 1;
    
    // Get author name - handle NULL/missing names
    let authorName = 'Unknown User';
    if (isAnon) {
        authorName = 'Anonymous';
    } else if (comment.first_name || comment.last_name) {
        authorName = (comment.first_name || '') + ' ' + (comment.last_name || '');
        authorName = authorName.trim() || 'Unknown User';
    }
    
    const authorInitial = isAnon ? '?' : (comment.first_name?.charAt(0) || 'U').toUpperCase();
    const avatarHtml = comment.profile_image && !isAnon 
        ? `<img src="<?= base_url('assets/uploads/alumni/') ?>${comment.profile_image}">` 
        : '';
    
    // Determine if user owns this comment (would need to check with current user ID in real implementation)
    const canEditDelete = true; // Will be validated on backend
    
    return `
        <div class="comment-item" data-comment-id="${comment.id}" style="${isReply ? 'opacity: 0.95;' : ''}">
            <div style="display: flex; align-items: center; gap: 8px;">
                <div class="comment-avatar-small">
                    ${avatarHtml || authorInitial}
                </div>
                <div style="flex: 1; min-width: 0;">
                    <div class="comment-author">${authorName} ${isReply ? '<span style="font-size: 11px; color: #94a3b8;">(reply)</span>' : ''}</div>
                    <div class="comment-meta">${comment.time_ago}</div>
                </div>
            </div>
            
            <div class="comment-text" style="flex: 1;">${escapeHtml(comment.comment)}</div>
                
            <div class="comment-actions">
                <div class="comment-actions-left">
                    <button class="comment-action-btn comment-action-btn-like${comment.user_liked ? ' liked' : ''}" type="button" title="Like comment" onclick="likeComment(event, ${comment.id})">
                        <svg width="13" height="13" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/></svg>
                        <span>${comment.like_count || 0}</span>
                    </button>
                    <button class="comment-action-btn comment-action-btn-dislike${comment.user_disliked ? ' disliked' : ''}" type="button" title="Dislike comment" onclick="dislikeComment(event, ${comment.id})">
                        <svg width="13" height="13" fill="currentColor" viewBox="0 0 20 20"><path d="M16.828 14.828a4 4 0 01-5.656 0L10 13.657l-1.172 1.171a4 4 0 11-5.656-5.656L10 2.343l6.828 6.829a4 4 0 010 5.656z"/></svg>
                        <span>${comment.dislike_count || 0}</span>
                    </button>
                    ${!isReply ? `<button class="comment-action-btn reply-btn" type="button" title="Reply" data-comment-id="${comment.id}">
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l4-4m-4 4l4 4"/></svg>
                        <span>Reply</span>
                    </button>` : ''}
                    ${!isReply && replyCount > 0 ? `<button class="toggle-replies" data-id="${comment.id}">
                        ${replyCount} ${replyCount === 1 ? 'reply' : 'replies'}
                    </button>` : ''}
                </div>
                <div class="comment-actions-right">
                    ${canEditDelete ? `
                        <button class="comment-action-btn comment-action-btn-edit" type="button" title="Edit comment" onclick="editComment(${comment.id})">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                            </svg>
                        </button>
                        <button class="comment-action-btn comment-action-btn-delete" type="button" title="Delete comment" onclick="deleteComment(${comment.id})">
                            <svg fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    ` : ''}
                </div>
            </div>
            <div class="reply-form-container" id="reply-form-${comment.id}" style="display: none; margin-top: 12px; padding-top: 12px; border-top: 1px solid #f1f5f9;">
                <textarea class="reply-textarea" placeholder="Write a reply..." style="width: 100%; border: 1px solid #e2e8f0; border-radius: 8px; padding: 10px; font-size: 12px; font-family: inherit; resize: none; outline: none;"></textarea>
                <div style="display: flex; gap: 8px; margin-top: 8px; align-items: center;">
                    <button class="reply-submit-btn" onclick="submitReply(${comment.id})" style="background: var(--brand-red); color: #fff; border: none; border-radius: 6px; padding: 6px 14px; font-size: 12px; font-weight: 700; cursor: pointer;">Reply</button>
                    <button class="reply-cancel-btn" onclick="toggleReplyForm(null, ${comment.id})" style="background: #f1f5f9; color: #64748b; border: none; border-radius: 6px; padding: 6px 14px; font-size: 12px; font-weight: 700; cursor: pointer;">Cancel</button>
                </div>
            </div>
        </div>
    `;
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Toggle reply form with jQuery slideToggle
$(document).on('click', '.reply-btn', function(e) {
    e.preventDefault();
    e.stopPropagation();
    let commentId = $(this).data('comment-id');
    let form = $('#reply-form-' + commentId);
    
    form.slideToggle(300, function() {
        if(form.is(':visible')) {
            form.find('.reply-textarea').focus();
        }
    });
});

function submitReply(commentId) {
    const replyForm = document.getElementById(`reply-form-${commentId}`);
    const textarea = replyForm.querySelector('.reply-textarea');
    const replyText = textarea.value.trim();
    
    if (!replyText) {
        alert('Please enter a reply.');
        return;
    }
    
    const postId = currentPostIdInModal;
    
    // Send reply via AJAX
    fetch('<?= base_url('forum/comment') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: new URLSearchParams({
            'post_id': postId,
            'parent_id': commentId,
            'comment': replyText,
            'anonymous': 0
        })
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        return response.text();
    })
    .then(text => {
        console.log('Raw response:', text);
        try {
            const data = JSON.parse(text);
            if (data.success) {
                showToast('Reply posted successfully!', 'success');
                textarea.value = '';
                replyForm.style.display = 'none';
                // Reload comments
                loadCommentsForModal(postId);
            } else {
                alert('Error posting reply: ' + (data.message || 'Unknown error'));
            }
        } catch (e) {
            console.error('JSON parse error:', e, 'Response text:', text);
            alert('Error posting reply. Invalid server response.');
        }
    })
    .catch(error => {
        console.error('Error posting reply:', error);
        alert('Error posting reply. Please try again.');
    });
}

function closeCommentModal() {
    const overlay = document.getElementById('commentModalOverlay');
    overlay.classList.remove('active');
}

// Submit comment from modal
function submitCommentFromModal() {
    const commentForm = document.getElementById('comment-form');
    const commentTextArea = document.getElementById('commentText');
    const submitBtn = document.getElementById('submitCommentBtn');
    const postId = document.getElementById('postIdField').value;
    const anonymousCheckbox = document.getElementById('anonymousComment');
    
    // Validate comment text
    if (!commentTextArea.value.trim()) {
        alert('Please enter a comment.');
        commentTextArea.focus();
        return;
    }
    
    // Disable button and show loading state
    submitBtn.disabled = true;
    submitBtn.textContent = 'Posting...';
    
    // Prepare form data
    const formData = new FormData(commentForm);
    
    // Explicitly set is_anonymous value (checkbox might not be included if unchecked)
    formData.set('is_anonymous', anonymousCheckbox.checked ? '1' : '0');
    
    // Submit via AJAX
    fetch('<?= base_url('forum/add_comment') ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update comment count on the post card
            if (currentPostCardElement) {
                const postStats = currentPostCardElement.querySelectorAll('.post-stat');
                postStats.forEach(stat => {
                    const text = stat.textContent;
                    if (text.includes('comment')) {
                        // Extract current number
                        const match = text.match(/(\d+)/);
                        if (match) {
                            const currentCount = parseInt(match[1]);
                            const newCount = currentCount + 1;
                            // Replace the count
                            const svg = stat.querySelector('svg');
                            if (svg) {
                                svg.nextSibling.textContent = ' ' + newCount + ' comment' + (newCount !== 1 ? 's' : '');
                            }
                        }
                    }
                });
            }
            
            // Show success message
            showCommentSuccess();
            
            // Reset form
            commentTextArea.value = '';
            document.getElementById('anonymousComment').checked = false;
            document.getElementById('charCount').textContent = '0';
            
            // Reload comments to show the new one
            loadCommentsForModal(postId);
        } else {
            alert('Failed to post comment: ' + (data.message || 'Unknown error'));
            submitBtn.disabled = false;
            submitBtn.textContent = 'Post Comment';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error posting comment. Please try again.');
        submitBtn.disabled = false;
        submitBtn.textContent = 'Post Comment';
    });
}

function showCommentSuccess() {
    const existingToast = document.getElementById('comment-success-toast');
    if (existingToast) existingToast.remove();
    
    const toast = document.createElement('div');
    toast.id = 'comment-success-toast';
    toast.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: var(--brand-red);
        color: #fff;
        padding: 12px 20px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        box-shadow: 0 8px 24px rgba(161, 33, 36, 0.25);
        z-index: 10000;
        animation: slideInUp 0.3s ease-out;
        display: flex;
        align-items: center;
        gap: 8px;
    `;
    toast.innerHTML = `
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        Comment posted successfully!
    `;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideOutDown 0.3s ease-in';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// ===== COMMENT ACTIONS: LIKE/DISLIKE/EDIT/DELETE =====
function likeComment(event, commentId) {
    event.preventDefault();
    event.stopPropagation();
    
    // Get the like button and dislike button
    const likeButton = event.currentTarget;
    const commentItem = likeButton.closest('.comment-item');
    const dislikeButton = commentItem.querySelector('.comment-action-btn-dislike');
    
    const likeCountSpan = likeButton.querySelector('span');
    const dislikeCountSpan = dislikeButton.querySelector('span');
    
    // Store current state for potential rollback
    const wasLiked = likeButton.classList.contains('liked');
    const wasDisliked = dislikeButton.classList.contains('disliked');
    const originalLikeCount = parseInt(likeCountSpan.textContent) || 0;
    const originalDislikeCount = parseInt(dislikeCountSpan.textContent) || 0;
    
    // Calculate optimistic update based on current state
    let optimisticLikeCount, optimisticDislikeCount;
    
    if (wasLiked) {
        // User is toggling OFF their like
        optimisticLikeCount = Math.max(0, originalLikeCount - 1);
        optimisticDislikeCount = originalDislikeCount;
        likeButton.classList.remove('liked');
    } else {
        // User is toggling ON their like
        optimisticLikeCount = originalLikeCount + 1;
        optimisticDislikeCount = wasDisliked ? Math.max(0, originalDislikeCount - 1) : originalDislikeCount;
        likeButton.classList.add('liked');
        if (wasDisliked) {
            dislikeButton.classList.remove('disliked');
        }
    }
    
    // Optimistic update
    likeCountSpan.textContent = optimisticLikeCount;
    dislikeCountSpan.textContent = optimisticDislikeCount;
    
    fetch('<?= base_url('forum/like_comment/') ?>' + commentId, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('HTTP ' + response.status + ': ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        console.log('Like response:', data);
        if (data.success) {
            // Update with actual counts from backend
            likeCountSpan.textContent = data.like_count !== undefined ? data.like_count : optimisticLikeCount;
            dislikeCountSpan.textContent = data.dislike_count !== undefined ? data.dislike_count : optimisticDislikeCount;
        }
    })
    .catch(error => {
        console.error('Error liking comment:', error);
        // Revert the optimistic update on error
        likeCountSpan.textContent = originalLikeCount;
        dislikeCountSpan.textContent = originalDislikeCount;
        likeButton.classList.toggle('liked', wasLiked);
        dislikeButton.classList.toggle('disliked', wasDisliked);
    });
}

function dislikeComment(event, commentId) {
    event.preventDefault();
    event.stopPropagation();
    
    // Get the dislike button and like button
    const dislikeButton = event.currentTarget;
    const commentItem = dislikeButton.closest('.comment-item');
    const likeButton = commentItem.querySelector('.comment-action-btn-like');
    
    const dislikeCountSpan = dislikeButton.querySelector('span');
    const likeCountSpan = likeButton.querySelector('span');
    
    // Store current state for potential rollback
    const wasDisliked = dislikeButton.classList.contains('disliked');
    const wasLiked = likeButton.classList.contains('liked');
    const originalDislikeCount = parseInt(dislikeCountSpan.textContent) || 0;
    const originalLikeCount = parseInt(likeCountSpan.textContent) || 0;
    
    // Calculate optimistic update based on current state
    let optimisticDislikeCount, optimisticLikeCount;
    
    if (wasDisliked) {
        // User is toggling OFF their dislike
        optimisticDislikeCount = Math.max(0, originalDislikeCount - 1);
        optimisticLikeCount = originalLikeCount;
        dislikeButton.classList.remove('disliked');
    } else {
        // User is toggling ON their dislike
        optimisticDislikeCount = originalDislikeCount + 1;
        optimisticLikeCount = wasLiked ? Math.max(0, originalLikeCount - 1) : originalLikeCount;
        dislikeButton.classList.add('disliked');
        if (wasLiked) {
            likeButton.classList.remove('liked');
        }
    }
    
    // Optimistic update
    dislikeCountSpan.textContent = optimisticDislikeCount;
    likeCountSpan.textContent = optimisticLikeCount;
    
    fetch('<?= base_url('forum/dislike_comment/') ?>' + commentId, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('HTTP ' + response.status + ': ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        console.log('Dislike response:', data);
        if (data.success) {
            // Update with actual counts from backend
            dislikeCountSpan.textContent = data.dislike_count !== undefined ? data.dislike_count : optimisticDislikeCount;
            likeCountSpan.textContent = data.like_count !== undefined ? data.like_count : optimisticLikeCount;
        }
    })
    .catch(error => {
        console.error('Error disliking comment:', error);
        // Revert the optimistic update on error
        dislikeCountSpan.textContent = originalDislikeCount;
        likeCountSpan.textContent = originalLikeCount;
        dislikeButton.classList.toggle('disliked', wasDisliked);
        likeButton.classList.toggle('liked', wasLiked);
    });
}

function editComment(commentId) {
    const postId = document.getElementById('postIdField').value;
    const form = document.getElementById('edit-comment-form');
    
    // Set the hidden fields
    form.comment_id.value = commentId;
    form.post_id.value = postId;
    
    // Get the comment from the DOM (it's already loaded)
    const commentElement = document.querySelector(`[data-comment-id="${commentId}"]`);
    if (commentElement) {
        const commentText = commentElement.querySelector('.comment-text').textContent;
        document.getElementById('editCommentText').value = commentText;
        document.getElementById('editCharCount').textContent = commentText.length;
    }
    
    // Show the edit modal
    const overlay = document.getElementById('editModalOverlay');
    overlay.classList.add('active');
    
    // Focus on textarea
    setTimeout(() => {
        document.getElementById('editCommentText').focus();
    }, 100);
}

function closeEditModal() {
    const overlay = document.getElementById('editModalOverlay');
    overlay.classList.remove('active');
    
    // Clear the form
    document.getElementById('edit-comment-form').reset();
    document.getElementById('editCharCount').textContent = '0';
}

function submitEditComment() {
    const form = document.getElementById('edit-comment-form');
    const commentId = document.getElementById('editCommentId').value;
    const postId = document.getElementById('editPostId').value;
    const commentText = document.getElementById('editCommentText').value;
    const submitBtn = document.getElementById('submitEditBtn');
    
    console.log('=== EDIT COMMENT DEBUG ===');
    console.log('Comment ID:', commentId);
    console.log('Post ID:', postId);
    console.log('Comment text length:', commentText.length);
    
    // Validate comment text
    if (!commentText.trim()) {
        alert('Please enter a comment.');
        document.getElementById('editCommentText').focus();
        return;
    }
    
    // Disable button and show loading state
    submitBtn.disabled = true;
    submitBtn.textContent = 'Updating...';
    
    // Prepare form data manually
    const formData = new FormData();
    formData.append('comment_id', commentId);
    formData.append('post_id', postId);
    formData.append('comment_text', commentText);
    
    // Debug: Log all FormData entries
    console.log('FormData entries:');
    for (let [key, value] of formData.entries()) {
        console.log(`  ${key}: ${typeof value === 'string' ? value.substring(0, 50) : value}`);
    }
    
    const endpoint = '<?= base_url('forum/edit_comment') ?>';
    console.log('Endpoint:', endpoint);
    console.log('Sending fetch request...');
    
    // Submit via AJAX
    fetch(endpoint, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        console.log('Response received:', {
            status: response.status,
            statusText: response.statusText,
            contentType: response.headers.get('content-type')
        });
        
        if (!response.ok) {
            throw new Error('HTTP ' + response.status + ': ' + response.statusText);
        }
        return response.text();
    })
    .then(text => {
        console.log('Response text:', text);
        let data;
        try {
            data = JSON.parse(text);
        } catch (e) {
            console.error('Failed to parse JSON:', e);
            throw new Error('Invalid JSON response: ' + text.substring(0, 200));
        }
        
        console.log('Parsed response:', data);
        
        if (data.success) {
            showToast('Comment updated successfully', 'success');
            closeEditModal();
            loadCommentsForModal(postId);
        } else {
            alert('Error updating comment: ' + (data.message || 'Unknown error'));
            submitBtn.disabled = false;
            submitBtn.textContent = 'Update Comment';
        }
    })
    .catch(error => {
        console.error('=== FETCH ERROR ===', error);
        alert('Error updating comment: ' + error.message);
        submitBtn.disabled = false;
        submitBtn.textContent = 'Update Comment';
    });
}

function deleteComment(commentId) {
    if (!confirm('Are you sure you want to delete this comment? This action cannot be undone.')) {
        return;
    }
    
    const postId = document.getElementById('postIdField').value;
    
    fetch('<?= base_url('forum/delete_comment/') ?>' + commentId, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Decrement comment count on post card
            if (currentPostCardElement) {
                const postStats = currentPostCardElement.querySelectorAll('.post-stat');
                postStats.forEach(stat => {
                    const text = stat.textContent;
                    if (text.includes('comment')) {
                        const match = text.match(/(\d+)/);
                        if (match) {
                            const currentCount = parseInt(match[1]);
                            const newCount = Math.max(0, currentCount - 1);
                            const svg = stat.querySelector('svg');
                            if (svg) {
                                svg.nextSibling.textContent = ' ' + newCount + ' comment' + (newCount !== 1 ? 's' : '');
                            }
                        }
                    }
                });
            }
            
            // Reload comments in modal to show deletion
            loadCommentsForModal(postId);
            showToast('Comment deleted successfully', 'success');
        } else {
            alert('Error deleting comment: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error deleting comment. Please try again.');
    });
}

function showToast(message, type = 'success') {
    const existingToast = document.getElementById('action-toast');
    if (existingToast) existingToast.remove();
    
    const toast = document.createElement('div');
    toast.id = 'action-toast';
    const bgColor = type === 'success' ? 'var(--brand-red)' : '#ef4444';
    toast.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: ${bgColor};
        color: #fff;
        padding: 12px 20px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        z-index: 10000;
        animation: slideInUp 0.3s ease-out;
    `;
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideOutDown 0.3s ease-in';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Close modal when clicking outside the content
document.addEventListener('DOMContentLoaded', function() {
    const commentOverlay = document.getElementById('commentModalOverlay');
    const editOverlay = document.getElementById('editModalOverlay');
    
    // Close comment modal when clicking outside
    if (commentOverlay) {
        commentOverlay.addEventListener('click', function(e) {
            if (e.target === commentOverlay) {
                closeCommentModal();
            }
        });
    }
    
    // Close edit modal when clicking outside
    if (editOverlay) {
        editOverlay.addEventListener('click', function(e) {
            if (e.target === editOverlay) {
                closeEditModal();
            }
        });
    }
    
    // Character counter for comment modal
    const commentText = document.getElementById('commentText');
    const charCount = document.getElementById('charCount');
    
    if (commentText && charCount) {
        commentText.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });
    }
    
    // Character counter for edit modal
    const editCommentText = document.getElementById('editCommentText');
    const editCharCount = document.getElementById('editCharCount');
    
    if (editCommentText && editCharCount) {
        editCommentText.addEventListener('input', function() {
            editCharCount.textContent = this.value.length;
        });
    }
    
    // Close modals on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCommentModal();
            closeEditModal();
        }
    });
});

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

// Save forum sort preference to localStorage
function saveForumSort(sort) {
    localStorage.setItem('forumSort', sort);
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
    localStorage.setItem('forumListActiveTab', tab);
}

// Restore active tab and sort on page load
window.addEventListener('load', function() {
    const savedTab = localStorage.getItem('forumListActiveTab') || 'feed';
    updateForumTab(savedTab);
    
    // Restore sort preference if no sort param in URL
    const urlSort = new URLSearchParams(window.location.search).get('sort');
    if(urlSort === null) {
        const savedSort = localStorage.getItem('forumSort');
        if(savedSort !== null && savedSort !== '') {
            window.location.href = '<?= base_url('forum') ?>?sort=' + savedSort;
        }
    }
});

// Store generated content temporarily
let generatedContent = null;
let isGeneratingPost = false;
let isPublishingPost = false;
let globalActionLockCount = 0;

function isUiLocked() {
    return globalActionLockCount > 0;
}

function lockUi(message) {
    globalActionLockCount += 1;
    setPostActionLoading(true, message || 'Processing...');
}

function unlockUi(force) {
    if (force === true) {
        globalActionLockCount = 0;
    } else {
        globalActionLockCount = Math.max(0, globalActionLockCount - 1);
    }

    if (!isUiLocked()) {
        setPostActionLoading(false);
    }
}

function setPostActionLoading(isLoading, text) {
    const overlay = document.getElementById('post-action-loading');
    const loadingText = document.getElementById('post-action-loading-text');
    const generateBtn = document.getElementById('generate-post-btn');
    const publishBtn = document.getElementById('publish-discussion-btn');

    if (loadingText && text) {
        loadingText.textContent = text;
    }

    if (overlay) {
        overlay.classList.toggle('show', !!isLoading);
        overlay.setAttribute('aria-hidden', isLoading ? 'false' : 'true');
    }

    document.body.classList.toggle('ui-locked', !!isLoading);
    document.body.setAttribute('aria-busy', isLoading ? 'true' : 'false');

    if (generateBtn) generateBtn.disabled = !!isLoading;
    if (publishBtn) publishBtn.disabled = !!isLoading;
}

// Generate forum post with AI - Smart context-aware generation
function generateForumPost() {
    if (isGeneratingPost || isPublishingPost) {
        return;
    }

    const btn = document.getElementById('generate-post-btn');
    const titleInput = document.querySelector('input[name="title"]');
    const contentInput = document.getElementById('forum-content');
    const currentTitle = titleInput.value.trim();
    const currentContent = contentInput.value.trim();
    
    // Determine generation mode based on existing content
    let mode = 'alumni'; // Default to alumni-related content generation
    let hasTitle = currentTitle.length > 0;
    let hasContent = currentContent.length > 0;
    
    // Prevent generation if both fields are empty
    if (!hasTitle && !hasContent) {
        alert('Please enter a title or content before generating.');
        return;
    }
    
    // Determine mode based on what's filled in
    if (hasTitle && hasContent) {
        mode = 'both'; // Refine both title and content
    } else if (hasTitle && !hasContent) {
        mode = 'title_only'; // Generate content from title
    } else if (!hasTitle && hasContent) {
        mode = 'content_only'; // Generate title from content
    }
    // else: mode stays 'alumni' - generate alumni-related content
    
    // Show loading state
    const originalText = btn.textContent;
    isGeneratingPost = true;
    btn.textContent = '⏳ Generating...';
    btn.disabled = true;
    lockUi('Generating AI content...');

    // Build API URL with appropriate parameters
    let apiUrl = '<?= base_url('forum/generate_ai_content') ?>';
    const params = new URLSearchParams();
    params.append('mode', mode);
    
    if (mode === 'title_only') {
        params.append('title', currentTitle);
    } else if (mode === 'content_only') {
        params.append('content', currentContent);
    } else if (mode === 'both') {
        params.append('title', currentTitle);
        params.append('content', currentContent);
    }
    
    fetch(apiUrl + '?' + params.toString(), {
        method: 'GET'
    })
    .then(response => response.json())
    .then(data => {
        const generatedBody = data.body || data.content || '';
        if (data.title && generatedBody) {
            // Store the generated content
            generatedContent = {
                title: data.title,
                content: generatedBody,
                category: data.category || '',
                tags: Array.isArray(data.tags) ? data.tags : [],
                estimatedReadingTimeMinutes: data.estimated_reading_time_minutes || null,
                reasonTitle: data.reason_title || '',
                reasonContent: data.reason_content || '',
                mode: mode
            };
            
            // Show the preview
            showGenerationPreview(mode);
            
            // Scroll to preview
            setTimeout(() => {
                document.getElementById('generation-preview').scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 100);
        } else {
            alert('Failed to generate content. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error generating content. Please try again.');
    })
    .finally(() => {
        isGeneratingPost = false;
        btn.textContent = originalText;
        btn.disabled = false;
        unlockUi();
    });
}

// Show the generated content preview
function showGenerationPreview(mode) {
    const previewDiv = document.getElementById('generation-preview');
    const previewTitle = document.getElementById('preview-title');
    const previewContent = document.getElementById('preview-content');
    const previewImprovementReason = document.getElementById('preview-improvement-reason');

    function fallbackReasonForTitle(currentMode) {
        if (currentMode === 'title_only') return 'Kept or lightly tuned your original title for clarity and relevance.';
        if (currentMode === 'content_only') return 'Generated a clearer title to better summarize your message.';
        if (currentMode === 'both') return 'Refined title to improve clarity, hook, and alumni relevance.';
        return 'Created a title designed to be clear, engaging, and discussion-friendly.';
    }

    function fallbackReasonForContent(currentMode) {
        if (currentMode === 'title_only') return 'Expanded your topic into a fuller discussion prompt with actionable context.';
        if (currentMode === 'content_only') return 'Improved readability and flow while preserving your original intent.';
        if (currentMode === 'both') return 'Enhanced content structure, specificity, and readability for better engagement.';
        return 'Generated content to spark meaningful alumni conversation and responses.';
    }

    previewTitle.textContent = generatedContent.title;
    previewContent.textContent = generatedContent.content;

    const categoryLabel = generatedContent.category ? `Category: ${generatedContent.category}` : '';
    const tagsLabel = Array.isArray(generatedContent.tags) && generatedContent.tags.length
        ? `Tags: ${generatedContent.tags.join(', ')}`
        : '';
    const readingTimeLabel = generatedContent.estimatedReadingTimeMinutes
        ? `Reading time: ${generatedContent.estimatedReadingTimeMinutes} min`
        : '';

    const titleReason = generatedContent.reasonTitle || fallbackReasonForTitle(mode);
    const contentReason = generatedContent.reasonContent || fallbackReasonForContent(mode);
    const metadataReason = [categoryLabel, tagsLabel, readingTimeLabel].filter(Boolean).join(' • ');
    const unifiedReason = (titleReason === contentReason)
        ? titleReason
        : (titleReason + ' ' + contentReason);

    previewImprovementReason.textContent = [unifiedReason, metadataReason].filter(Boolean).join(' • ');
    previewDiv.style.display = 'block';
    
    // Highlight animation
    previewDiv.style.animation = 'none';
    setTimeout(() => {
        previewDiv.style.animation = 'slideInUp 0.3s ease-out';
    }, 10);
}

// Accept generated content and fill the form
function acceptGeneratedContent() {
    if (!generatedContent) return;
    
    const titleInput = document.querySelector('input[name="title"]');
    const contentInput = document.getElementById('forum-content');
    
    // Auto-fill the form fields with generated content
    titleInput.value = generatedContent.title;
    contentInput.value = generatedContent.content;
    
    // Highlight animation on filled fields
    titleInput.style.transition = 'background-color 0.3s ease';
    contentInput.style.transition = 'background-color 0.3s ease';
    titleInput.style.backgroundColor = '#fffbea';
    contentInput.style.backgroundColor = '#fffbea';
    
    setTimeout(() => {
        titleInput.style.backgroundColor = '';
        contentInput.style.backgroundColor = '';
    }, 2000);
    
    // Hide preview
    setTimeout(() => {
        document.getElementById('generation-preview').style.display = 'none';
    }, 500);
    
    generatedContent = null;
}

// Discard generated content
function discardGeneratedContent() {
    document.getElementById('generation-preview').style.display = 'none';
    generatedContent = null;
}

// Show acceptance success message
function showAcceptanceSuccess(mode) {
    const existingToast = document.getElementById('generation-success-toast');
    if (existingToast) existingToast.remove();
    
    let message = 'Content added to form!';
    if (mode === 'both') {
        message = '✨ Title and content refined!';
    } else if (mode === 'title_only') {
        message = '✨ Content added to form!';
    } else if (mode === 'content_only') {
        message = '✨ Title added to form!';
    } else if (mode === 'alumni') {
        message = '✨ Alumni discussion idea added!';
    }
    
    const toast = document.createElement('div');
    toast.id = 'generation-success-toast';
    toast.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: linear-gradient(135deg, var(--brand-red) 0%, var(--brand-red-dark) 100%);
        color: #fff;
        padding: 14px 20px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        box-shadow: 0 8px 24px rgba(161, 33, 36, 0.25);
        z-index: 10000;
        animation: slideInUp 0.3s ease-out;
        display: flex;
        align-items: center;
        gap: 10px;
    `;
    toast.innerHTML = `
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        ${message}
    `;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.animation = 'slideOutDown 0.3s ease-in';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Add animations if not already present in page
if (!document.getElementById('generation-animations')) {
    const style = document.createElement('style');
    style.id = 'generation-animations';
    style.textContent = `
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes slideOutDown {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(20px);
            }
        }
    `;
    document.head.appendChild(style);
}

// Clear form fields when canceling
function clearFormFields() {
    const titleInput = document.querySelector('input[name="title"]');
    const contentInput = document.getElementById('forum-content');
    const imageInput = document.querySelector('input[name="image"]');
    const anonCheckbox = document.getElementById('anon-check');
    
    titleInput.value = '';
    contentInput.value = '';
    imageInput.value = '';
    anonCheckbox.checked = false;
    
    // Hide preview if visible
    document.getElementById('generation-preview').style.display = 'none';
    generatedContent = null;

    isGeneratingPost = false;
    isPublishingPost = false;
    unlockUi(true);
}

// Prevent publish button spamming and show loading state while submitting.
document.addEventListener('DOMContentLoaded', function() {
    const createForm = document.getElementById('create-discussion-form');
    const publishBtn = document.getElementById('publish-discussion-btn');

    if (createForm && publishBtn) {
        createForm.addEventListener('submit', function(e) {
            if (isPublishingPost || isGeneratingPost) {
                e.preventDefault();
                return;
            }

            isPublishingPost = true;
            publishBtn.textContent = 'Publishing...';
            lockUi('Publishing discussion...');
        });
    }
});

// Global interaction guard while UI is locked.
['click', 'mousedown', 'touchstart', 'submit'].forEach((eventName) => {
    document.addEventListener(eventName, function(e) {
        if (!isUiLocked()) return;

        const loadingOverlay = document.getElementById('post-action-loading');
        if (loadingOverlay && loadingOverlay.contains(e.target)) {
            return;
        }

        e.preventDefault();
        e.stopPropagation();
    }, true);
});

document.addEventListener('keydown', function(e) {
    if (!isUiLocked()) return;

    // Keep refresh/DevTools shortcuts usable, block app interactions.
    if (e.key === 'F5' || e.key === 'F12' || (e.ctrlKey && (e.key === 'r' || e.key === 'R'))) {
        return;
    }

    e.preventDefault();
    e.stopPropagation();
}, true);
</script>

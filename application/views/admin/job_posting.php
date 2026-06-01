<style>
    :root {
        --primary-color: #a12124;
        --accent-red: #a12124;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --card-bg: rgba(255, 255, 255, 0.95);
        --border-radius: 24px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .admin-wrapper { 
        max-width: 1400px; 
        margin: 0 auto; 
        padding: 20px 24px;
        animation: fadeIn 0.8s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Header Styling */
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

    .header-section h1 span { color: #ff6b6b; }
    .header-section p { color: rgba(255, 255, 255, 0.85); font-size: 14px; margin: 0; }

    /* Action Buttons */
    .btn-header {
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 13px;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 8px;
        border: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .btn-create { background: white; color: var(--primary-color); }
    .btn-create:hover { transform: translateY(-2px); background: #f8fafc; }

    .btn-notify { background: var(--accent-red); color: white; }
    .btn-notify:hover { transform: translateY(-2px); background: #ff5252; color: white; }

    /* Main Table Card */
    .main-card {
        background: var(--card-bg);
        border-radius: var(--border-radius);
        padding: 30px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
        backdrop-filter: blur(10px);
    }

    .email-header-stack {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        background: #ffffff;
    }

    .email-header-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        border-bottom: 1px solid #e5e7eb;
    }

    .email-header-row:last-child {
        border-bottom: none;
    }

    .email-header-label {
        flex: 0 0 52px;
        font-size: 0.85rem;
        font-weight: 700;
        color: #6b7280;
    }

    .email-header-content {
        flex: 1;
        min-width: 0;
        font-size: 0.95rem;
        color: #111827;
        word-break: break-all;
    }

    .email-header-icon {
        flex: 0 0 auto;
        font-size: 0.85rem;
        color: #6b7280;
    }

    .email-header-cc-toggle {
        flex: 0 0 auto;
        font-size: 0.85rem;
        color: #2563eb;
        text-decoration: none;
    }

    .email-header-cc-toggle:hover {
        text-decoration: underline;
    }

    .cc-row .email-header-content {
        padding-top: 0;
    }

    /* Custom Table */
    .custom-table { width: 100%; border-collapse: separate; border-spacing: 0 10px; }
    .custom-table th { padding: 12px 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); border: none; }
    .custom-table tr.data-row { background: white; transition: var(--transition); }
    .custom-table tr.data-row:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
    .custom-table td { padding: 16px 20px; vertical-align: middle; border-top: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9; }
    .custom-table td:first-child { border-left: 1px solid #f1f5f9; border-top-left-radius: 14px; border-bottom-left-radius: 14px; }
    .custom-table td:last-child { border-right: 1px solid #f1f5f9; border-top-right-radius: 14px; border-bottom-right-radius: 14px; }

    .job-title-cell { font-weight: 700; color: var(--text-main); font-size: 15px; cursor: pointer; transition: var(--transition); }
    .job-title-cell:hover { text-decoration: underline; color: var(--primary-color); }
    .company-label { display: block; font-size: 12px; color: var(--text-muted); font-weight: 500; }

    .applicant-badge { background: rgba(139, 21, 56, 0.1); color: var(--primary-color); padding: 6px 14px; border-radius: 10px; font-size: 12px; font-weight: 700; }

    .btn-action {
        width: 38px; height: 38px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center;
        border: 1px solid #f1f5f9; background: white; color: var(--text-muted); transition: var(--transition);
        margin-left: 5px; cursor: pointer;
    }

    .btn-action:hover { background: #f8fafc; color: var(--primary-color); border-color: var(--primary-color); transform: translateY(-2px); }
    .btn-action.delete:hover { background: #fff5f5; color: #ef4444; border-color: #ef4444; }

    .view-applicant-match {
        width: auto;
        min-width: 96px;
        height: 34px;
        padding: 0 12px;
        gap: 6px;
        border-color: rgba(161, 33, 36, 0.18);
        background: linear-gradient(135deg, rgba(161, 33, 36, 0.08), rgba(161, 33, 36, 0.03));
        color: var(--primary-color);
        font-size: 11px;
        font-weight: 800;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(161, 33, 36, 0.08);
    }

    .view-applicant-match i {
        font-size: 12px;
    }

    .view-applicant-match:hover {
        background: linear-gradient(135deg, rgba(161, 33, 36, 0.14), rgba(161, 33, 36, 0.07));
        color: var(--primary-color);
        border-color: var(--primary-color);
        box-shadow: 0 4px 10px rgba(161, 33, 36, 0.14);
    }

    .applicant-action-group {
        display: inline-flex;
        align-items: center;
        justify-content: flex-end;
        gap: 6px;
        flex-wrap: nowrap;
        white-space: nowrap;
    }

    .applicant-action-cell {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        white-space: nowrap;
    }

    .contact-applicant-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
        vertical-align: middle;
    }

    /* Pagination */
    .pagination-wrap {
        margin-top: 18px;
        display: flex;
        justify-content: center;
    }

    .pagination .page-link {
        border-radius: 10px !important;
        margin: 0 4px;
        border: 1px solid #e2e8f0;
        color: #a12124;
        font-weight: 700;
        font-size: 13px;
        padding: 10px 14px;
        transition: var(--transition);
        background: #ffffff;
        text-decoration: none;
    }

    .pagination .page-item.active .page-link {
        background-color: #a12124;
        border-color: #a12124;
        color: #ffffff;
        box-shadow: 0 6px 16px rgba(161, 33, 36, 0.22);
    }

    .pagination .page-item.disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
        background: #f8fafc;
    }

    /* Search Button Styling */
    .btn-search {
        background: linear-gradient(135deg, var(--primary-color), var(--accent-red));
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .btn-search:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(0,0,0,0.15); }

    .btn-search:active {
        transform: translateY(0) scale(0.98);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    /* Search Input Styling */
    #jobSearch {
        transition: all 0.3s !important;
    }
    #jobSearch:focus {
        outline: none;
        border-color: var(--primary-color) !important;
        box-shadow: 0 0 0 3px rgba(139, 21, 56, 0.1) !important;
        background: white !important;
    }

    /* Modal Styling */
    .modal-content { border-radius: 24px; border: none; overflow: hidden; }
    .modal-header { background: var(--accent-red); color: white; padding: 25px; border: none; }
    .modal-body { padding: 30px; }
    .form-label { font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px; display: block; }
    .form-input { border-radius: 12px; padding: 12px; font-size: 14px; font-weight: 500; border: 1px solid #e2e8f0; }
    .form-input:focus { border-color: var(--accent-red); box-shadow: 0 0 0 4px rgba(112, 10, 10, 0.05); }

    .targeted-tag { background: #f8fafc; border: 1px solid #e2e8f0; padding: 15px; border-radius: 14px; margin-top: 10px; }

    .contact-applicant-modal .modal-dialog {
        width: 90%;
        max-width: 1200px;
        margin-left: auto;
        margin-right: auto;
    }

    .contact-applicant-modal .modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 22px 24px;
    }

    .contact-applicant-modal .modal-title {
        margin: 0;
    }

    .contact-applicant-modal .close {
        float: none;
        margin: 0;
        padding: 0;
        opacity: 1;
    }

    .contact-applicant-modal .modal-body {
        padding: 34px 28px;
        min-height: 420px;
    }

    .contact-applicant-modal .modal-footer {
        display: flex;
        justify-content: flex-end;
        flex-wrap: nowrap;
        gap: 10px;
        padding: 18px 24px 24px;
    }

    .contact-applicant-modal .modal-footer .btn {
        min-width: 150px;
    }

    /* Modal Spacing for Header */
    .modal-dialog { margin-top: 100px !important; margin-bottom: 50px !important; }

    @media (min-width: 992px) {
        /* Desktop: Wide for profile/applicants, adaptive for others */
        .modal-wide { max-width: 1000px !important; }
        .modal-adaptive { max-width: 650px !important; }
    }

    @media (max-width: 768px) {
        /* Mobile Modal Adjustments */
        .modal-dialog { margin-top: 60px !important; margin-left: 12px; margin-right: 12px; margin-bottom: 30px !important; }
        .modal-content { border-radius: 20px; }
        .modal-body { padding: 20px; }
        .modal-header { padding: 20px; }

        .contact-applicant-modal .modal-dialog {
            width: auto;
            max-width: none;
            margin-left: 12px;
            margin-right: 12px;
        }

        .contact-applicant-modal .modal-body {
            min-height: 220px;
        }
    }

    /* Custom Overlay Modal */
    .match-breakdown-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        display: flex;
        align-items: flex-start;
        justify-content: center;
        z-index: 1050;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s;
        padding: 60px 1rem 1rem;
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
    }

    .match-breakdown-overlay.open {
        opacity: 1;
        visibility: visible;
    }

    .match-breakdown-container {
        background: #ffffff;
        width: 90%;
        max-width: 1200px;
        max-height: calc(100vh - 60px - 2rem);
        border-radius: 16px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        transform: scale(0.95) translateY(20px);
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
        margin: 0 auto;
        flex-shrink: 0;
    }

    .match-breakdown-overlay.open .match-breakdown-container {
        transform: scale(1) translateY(0);
    }

    .match-breakdown-header {
        background: linear-gradient(135deg, #a12124, #7f171a);
        color: white;
        padding: 24px;
        flex-shrink: 0;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        position: relative;
        z-index: 2;
    }

    .match-breakdown-header h2 {
        margin: 0 0 4px 0;
        font-size: 20px;
        font-weight: 800;
    }

    .match-breakdown-header p {
        margin: 0;
        font-size: 13px;
        color: rgba(255, 255, 255, 0.8);
        font-weight: 600;
    }

    .match-breakdown-body {
        display: grid;
        grid-template-columns: 1fr 1fr;
        flex: 1 1 auto;
        min-height: 0;
    }

    .match-panel-left {
        background: #ffffff;
        color: var(--text-main);
        padding: 0;
        display: flex;
        flex-direction: column;
        min-height: 0;
    }

    .match-panel-right {
        background: #ffffff;
        padding: 0;
        display: flex;
        flex-direction: column;
        min-height: 0;
    }

    .match-modal-header {
        display: none;
    }

    .match-close-btn {
        background: none;
        border: none;
        font-size: 28px;
        cursor: pointer;
        color: white;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        padding: 0;
        flex-shrink: 0;
    }

    .match-close-btn:hover {
        transform: scale(1.1);
    }

    .match-ai-scroll {
        overflow-y: auto;
        flex: 1 1 auto;
        min-height: 0;
        -webkit-overflow-scrolling: touch;
        padding: 24px;
        background: #ffffff;
    }

    .match-profile-scroll {
        overflow-y: auto;
        flex: 1 1 auto;
        min-height: 0;
        -webkit-overflow-scrolling: touch;
        display: flex;
        flex-direction: column;
        background: #ffffff;
    }

    .match-profile-cover {
        height: 130px;
        background: linear-gradient(180deg, #a12124 0%, #8a191d 100%);
        position: relative;
        flex-shrink: 0;
        z-index: 0;
    }

    .match-profile-header {
        padding: 0 26px 26px;
        margin-top: -42px;
        position: relative;
        z-index: 1;
    }

    .match-avatar-wrap {
        width: 104px;
        height: 104px;
        border-radius: 50%;
        padding: 4px;
        background: #fff;
        box-shadow: 0 10px 24px rgba(161, 33, 36, 0.24);
        margin-bottom: 14px;
        position: relative;
        z-index: 2;
    }

    .match-avatar {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        background: #fff;
    }

    .match-name {
        font-size: 24px;
        font-weight: 800;
        color: var(--text-main);
        margin: 0;
        line-height: 1.15;
    }

    .match-subtitle {
        color: var(--text-muted);
        font-size: 13px;
        margin-top: 4px;
    }

    .match-profile-block {
        padding: 0 26px 26px;
    }

    .profile-content-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 24px;
        border: 1px solid #ebebeb;
        margin: 0 26px 12px;
        box-shadow: 0 0 0 1px rgba(0,0,0,0.08);
    }

    .profile-content-card h2 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        color: #191919;
    }

    .profile-content-card h2 i {
        color: #800020;
        font-size: 18px;
    }

    .section-divider {
        height: 1px;
        background: #ebebeb;
        margin: -4px 0 20px;
    }

    .empty-text {
        color: #666666;
        font-style: italic;
        text-align: center;
        padding: 20px 0;
    }

    .expertise-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .expertise-tag {
        background: #f2f2f2;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 14px;
        color: #444;
        border: 1px solid #ddd;
    }

    .cert-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 16px;
    }

    .cert-item {
        display: flex;
        gap: 15px;
        padding: 15px;
        border: 1px solid #ebebeb;
        border-radius: 12px;
        transition: all 0.3s;
        background: #fff;
    }

    .cert-img {
        width: 60px;
        height: 60px;
        background: #f0f0f0;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        object-fit: cover;
        flex-shrink: 0;
    }

    .cert-details h4 {
        font-size: 15px;
        font-weight: 700;
        margin: 0 0 4px;
    }

    .cert-details p {
        font-size: 13px;
        color: #666666;
        margin: 0;
    }

    .match-score-card {
        background: linear-gradient(135deg, #a12124, #7f171a);
        color: white;
        border-radius: 22px;
        padding: 22px;
        margin-bottom: 18px;
        box-shadow: 0 10px 24px rgba(161, 33, 36, 0.18);
    }

    .match-score-value {
        font-size: 44px;
        font-weight: 800;
        line-height: 1;
        margin-bottom: 6px;
    }

    .match-section {
        border: 1px solid #eef2f7;
        border-radius: 18px;
        padding: 18px;
        margin-bottom: 16px;
        background: #fff;
    }

    .match-section-title {
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 12px;
        letter-spacing: .04em;
    }

    .match-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 12px;
        border-radius: 999px;
        background: #f8fafc;
        color: var(--text-main);
        font-size: 12px;
        font-weight: 700;
        margin: 4px 6px 4px 0;
    }

    .match-list {
        margin: 0;
        padding-left: 18px;
        color: var(--text-main);
    }

    .match-list li {
        margin-bottom: 10px;
        line-height: 1.5;
        font-size: 14px;
    }

    .match-note-box {
        border-radius: 16px;
        padding: 14px 16px;
        margin-bottom: 14px;
        border-left: 4px solid transparent;
    }

    .match-note-box.recommendation {
        background: #fff5f5;
        border-left-color: var(--primary-color);
    }

    .match-note-box.strengths {
        background: #f0f9ff;
        border-left-color: #22c55e;
    }

    .match-note-box.gaps {
        background: #fefce8;
        border-left-color: #f59e0b;
    }

    .match-note-box.next-steps {
        background: #ecfdf5;
        border-left-color: #10b981;
    }

    .match-note-title {
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        margin-bottom: 8px;
        color: var(--text-main);
    }

    .match-note-text {
        font-size: 13px;
        line-height: 1.7;
        color: var(--text-main);
    }

    .profile-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .profile-field {
        background: rgba(248, 250, 252, 0.88);
        border: 1px solid #eef2f7;
        border-radius: 14px;
        padding: 12px 14px;
    }

    .profile-field .label {
        font-size: 11px;
        font-weight: 800;
        color: var(--text-muted);
        text-transform: uppercase;
        display: block;
        margin-bottom: 6px;
    }

    .profile-field .value {
        font-size: 14px;
        font-weight: 700;
        color: var(--text-main);
        word-break: break-word;
    }

    .profile-stat-row {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
        margin-top: 14px;
    }

    .profile-stat {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        font-weight: 700;
        color: var(--text-muted);
    }

    .match-loading {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 420px;
        color: var(--text-muted);
        flex-direction: column;
        gap: 14px;
    }

    .match-loading .spinner-border {
        width: 2.2rem;
        height: 2.2rem;
        color: var(--accent-red);
    }

    .match-error {
        padding: 18px;
        border-radius: 14px;
        background: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }

    .profile-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .profile-field {
        background: rgba(248, 250, 252, 0.88);
        border: 1px solid #eef2f7;
        border-radius: 14px;
        padding: 12px 14px;
    }

    .profile-field .label {
        font-size: 11px;
        font-weight: 800;
        color: var(--text-muted);
        text-transform: uppercase;
        display: block;
        margin-bottom: 6px;
    }

    .profile-field .value {
        font-size: 14px;
        font-weight: 700;
        color: var(--text-main);
        word-break: break-word;
    }

    @media (max-width: 991px) {
        .match-breakdown-container {
            max-height: calc(100vh - 60px - 1rem);
        }

        .match-breakdown-body {
            grid-template-columns: 1fr;
        }

        .match-profile-block,
        .match-profile-header {
            padding-left: 20px;
            padding-right: 20px;
        }
    }

    @media (max-width: 768px) {
        .match-breakdown-overlay {
            padding: 40px 0.75rem 0.75rem;
        }

        .match-breakdown-container {
            width: 95%;
            max-height: calc(100vh - 40px - 1.5rem);
        }

        .match-breakdown-header {
            padding: 18px 18px 16px;
        }

        .profile-grid {
            grid-template-columns: 1fr;
        }

        .match-profile-cover {
            height: 110px;
        }
    }
</style>

<div class="admin-wrapper">
    <div class="header-section">
        <div class="header-title">
            <h1>Job <span>Management</span></h1>
            <p>Publish and manage career postings for the alumni network.</p>
        </div>
        <div class="d-flex gap-3">
            <button class="btn btn-danger" data-toggle="modal" data-target="#createJobModal" style="background: var(--accent-red); border-radius: 12px; font-weight: 700; padding: 10px 24px;">
                <i class="fas fa-plus mr-2"></i> Create Posting
            </button>
            <a href="<?= base_url('AdminJobPosting/run_worker') ?>" class="btn-header btn-notify" style="text-decoration:none;">
                <i class="fas fa-paper-plane"></i> NOTIFY ALUMNI
            </a>
        </div>
    </div>

    <div class="header-section" style="background: var(--card-bg); padding: 24px 30px; border-radius: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); margin-bottom: 24px; display: block;">
        <form method="get" action="<?= base_url('AdminJobPosting') ?>" style="display: flex; gap: 12px; align-items: center;">
            <div style="flex: 1; position: relative;">
                <i class="fas fa-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 14px;"></i>
                <input type="text" name="search" id="jobSearch" placeholder="Search job title or company..." value="<?= $this->input->get('search') ?>" style="width: 100%; padding: 12px 14px 12px 44px; border: 1px solid #e2e8f0; border-radius: 12px; font-size: 14px; transition: all 0.3s;">
            </div>
            <button type="submit" class="btn-search">
                <i class="fas fa-search"></i> Search
            </button>
        </form>
    </div>

    <div class="main-card">
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th width="35%">POSITION DETAILS</th>
                        <th width="15%">ALUMNI APPLICANTS</th>
                        <th width="35%">META INFORMATION</th>
                        <th width="15%" class="text-right">ACTIONS</th>
                    </tr>
                </thead>
                <tbody id="jobListBody">
                    <?php if (!empty($jobs)): ?>
                        <?php foreach($jobs as $job): 
                            $this->db->where('job_id', $job->id);
                            $applicant_count = $this->db->count_all_results('job_applications');
                        ?>
                            <tr class="data-row job-item">
                                <td>
                                    <div class="job-title-cell" data-toggle="modal" data-target="#applicantModal<?= $job->id ?>">
                                        <?= htmlspecialchars($job->job_title) ?>
                                    </div>
                                    <span class="company-label"><?= htmlspecialchars($job->company) ?></span>
                                </td>
                                <td>
                                    <span class="applicant-badge">
                                        <i class="fas fa-users mr-1"></i> <?= $applicant_count ?> candidates
                                    </span>
                                </td>
                                <td>
                                    <div class="meta-info" style="font-size: 13px; color: var(--text-muted); font-weight: 600; display: flex; align-items: center; gap: 15px;">
                                        <span><i class="fas fa-map-marker-alt text-danger mr-1"></i> <?= htmlspecialchars($job->location) ?></span>
                                        <span><i class="fas fa-wallet text-danger mr-1"></i> <?= htmlspecialchars($job->salary_range) ?></span>
                                    </div>
                                </td>
                                <td class="text-right">
                                    <button class="btn-action" data-toggle="modal" data-target="#applicantModal<?= $job->id ?>" title="View Applicants">
                                        <i class="fas fa-users"></i>
                                    </button>
                                    <button class="btn-action" data-toggle="modal" data-target="#editModal<?= $job->id ?>" title="Edit Posting">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <button class="btn-action delete" onclick="confirmDelete(<?= $job->id ?>, '<?= htmlspecialchars($job->job_title) ?>')" title="Delete Posting">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="fas fa-briefcase fa-3x mb-3 d-block opacity-20"></i>
                                <p class="font-weight-bold">No active job opportunities found.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if (!empty($pagination_links)): ?>
            <div class="pagination-wrap">
                <?= $pagination_links ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- CREATE JOB MODAL -->
<div class="modal fade" id="createJobModal" tabindex="-1">
    <div class="modal-dialog modal-adaptive">
        <div class="modal-content">
            <form action="<?= base_url('AdminJobPosting/create') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-plus-circle mr-2"></i> Publish New Opportunity</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="small font-weight-bold text-muted uppercase">JOB TITLE</label>
                            <input type="text" name="job_title" class="form-control form-input" placeholder="e.g. Senior Medical Analyst" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small font-weight-bold text-muted uppercase">COMPANY NAME</label>
                            <input type="text" name="company" class="form-control form-input" placeholder="Organization" value="<?= isset($employer_company_name) ? htmlspecialchars($employer_company_name) : '' ?>" <?= isset($employer_company_name) && !empty($employer_company_name) ? 'readonly' : '' ?> required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small font-weight-bold text-muted uppercase">LOCATION</label>
                            <input type="text" name="location" class="form-control form-input" placeholder="City, Country" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small font-weight-bold text-muted uppercase">COMPENSATION RANGE</label>
                            <input type="text" name="salary_range" class="form-control form-input" placeholder="e.g. ₱40,000 - ₱60,000" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="small font-weight-bold text-muted uppercase">JOB DESCRIPTION</label>
                            <textarea name="description" class="form-control form-input" rows="4" placeholder="Briefly describe the role and responsibilities..." required></textarea>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="small font-weight-bold text-muted uppercase">REQUIRED QUALIFICATIONS</label>
                            <textarea name="qualifications" class="form-control form-input" rows="4" placeholder="List required skills, experience, and certifications..." required></textarea>
                        </div>
                        <div class="col-12">
                            <div class="targeted-tag">
                                <label class="font-weight-bold text-dark mb-2 d-block"><i class="fas fa-graduation-cap mr-2"></i> TARGETED ALUMNI GROUPS</label>
                                <select name="target_schools[]" multiple class="form-control" style="height: 120px; border-radius: 10px;">
                                    <optgroup label="Nursing & Allied Health">
                                        <option value="BS in Nursing">BS in Nursing</option>
                                        <option value="BS in Physical Therapy">BS in Physical Therapy</option>
                                    </optgroup>
                                    <optgroup label="Laboratory Sciences">
                                        <option value="BS in Medical Laboratory Science">BS in Medical Laboratory Science</option>
                                        <option value="BS in Pharmacy">BS in Pharmacy</option>
                                    </optgroup>
                                    <optgroup label="Computer Studies">
                                        <option value="BS in Information Technology">BS in Information Technology</option>
                                        <option value="Bachelor of Multimedia Arts">Bachelor of Multimedia Arts</option>
                                    </optgroup>
                                </select>
                                <small class="text-muted d-block mt-2">Hold Ctrl (Cmd) to select multiple target degrees.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light px-4" style="border-radius: 12px; font-weight: 700;" data-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn btn-danger px-5" style="background-color: #a12124; border-color: #a12124; border-radius: 12px; font-weight: 700;">PUBLISH NOW</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php foreach($jobs as $job): ?>
    <!-- EDIT MODAL -->
    <div class="modal fade" id="editModal<?= $job->id ?>" tabindex="-1">
        <div class="modal-dialog modal-adaptive">
            <div class="modal-content">
                <form action="<?= base_url('AdminJobPosting/update/'.$job->id) ?>" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold"><i class="fas fa-pen mr-2"></i> Update Posting</h5>
                        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="small font-weight-bold text-muted uppercase">JOB TITLE</label>
                                <input type="text" name="job_title" class="form-control form-input" value="<?= htmlspecialchars($job->job_title) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="small font-weight-bold text-muted uppercase">COMPANY</label>
                                <input type="text" name="company" class="form-control form-input" value="<?= htmlspecialchars($job->company) ?>" <?= isset($is_employer) && $is_employer ? 'readonly' : '' ?> required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="small font-weight-bold text-muted uppercase">LOCATION</label>
                                <input type="text" name="location" class="form-control form-input" value="<?= htmlspecialchars($job->location) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="small font-weight-bold text-muted uppercase">COMPENSATION</label>
                                <input type="text" name="salary_range" class="form-control form-input" value="<?= htmlspecialchars($job->salary_range) ?>" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="small font-weight-bold text-muted uppercase">JOB DESCRIPTION</label>
                                <textarea name="description" class="form-control form-input" rows="4" required><?= htmlspecialchars($job->description) ?></textarea>
                            </div>
                            <div class="col-12">
                                <label class="small font-weight-bold text-muted uppercase">REQUIRED QUALIFICATIONS</label>
                                <textarea name="qualifications" class="form-control form-input" rows="4" required><?= htmlspecialchars($job->qualifications) ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light px-4" data-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn btn-danger px-5" style="background-color: #a12124; border-color: #a12124; border-radius: 12px; font-weight: 700; padding: 10px 24px;">SAVE CHANGES</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- APPLICANT LIST MODAL -->
    <div class="modal fade" id="applicantModal<?= $job->id ?>" tabindex="-1">
        <div class="modal-dialog modal-wide">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-users-viewfinder mr-2"></i> Candidates: <?= htmlspecialchars($job->job_title) ?></h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body p-0">
                    <?php
                    $this->db->select('alumni.first_name, alumni.last_name, alumni.email, job_applications.applied_at, alumni.id as alumni_id');
                    $this->db->from('job_applications');
                    $this->db->join('alumni', 'alumni.id = job_applications.alumni_id');
                    $this->db->where('job_applications.job_id', $job->id);
                    $applicants = $this->db->get()->result();
                    ?>

                    <?php if (!empty($applicants)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" style="border: none;">
                                <thead class="bg-light">
                                    <tr class="small font-weight-bold text-muted uppercase">
                                        <th class="pl-4 py-3 border-0">FULL NAME</th>
                                        <th class="py-3 border-0">EMAIL ADDRESS</th>
                                        <th class="py-3 border-0">APPLIED ON</th>
                                        <th class="pr-4 py-3 border-0 text-right">PROFILE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($applicants as $app): ?>
                                        <tr>
                                            <td class="pl-4 py-3 font-weight-bold align-middle"><?= htmlspecialchars($app->first_name . ' ' . $app->last_name) ?></td>
                                            <td class="py-3 align-middle"><?= htmlspecialchars($app->email) ?></td>
                                            <td class="py-3 align-middle text-muted"><?= date('M d, Y', strtotime($app->applied_at)) ?></td>
                                            <td class="pr-4 py-3 applicant-action-cell">
                                                <div class="applicant-action-group">
                                                <button type="button" class="btn-action view-applicant-match" title="View Profile" aria-label="View Profile" onclick="openApplicantMatchModal(this, <?= $job->id ?>, <?= $app->alumni_id ?>, '<?= htmlspecialchars($app->first_name . ' ' . $app->last_name, ENT_QUOTES, 'UTF-8') ?>')">
                                                    <i class="fas fa-user-circle"></i>
                                                    <span>Profile</span>
                                                </button>
                                                <button type="button" class="btn btn-info btn-sm contact-applicant-btn" data-toggle="modal" data-target="#contactApplicantModal" data-applicant-id="<?= (int) $app->alumni_id ?>" data-job-id="<?= (int) $job->id ?>" data-applicant-name="<?= htmlspecialchars($app->first_name . ' ' . $app->last_name, ENT_QUOTES, 'UTF-8') ?>" data-applicant-email="<?= htmlspecialchars($app->email, ENT_QUOTES, 'UTF-8') ?>" data-applied-at="<?= date('M d, Y', strtotime($app->applied_at)) ?>" style="border-radius: 10px; font-weight: 700;">
                                                    <i class="fas fa-envelope mr-1"></i> Contact Applicant
                                                </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-light mb-3"></i>
                            <h5 class="text-muted">No applications found for this role.</h5>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-light px-4 font-weight-bold" data-dismiss="modal">CLOSE</button>
                    <?php if (!empty($applicants)): ?>
                        <a href="<?= base_url('AdminJobPosting/export/'.$job->id) ?>" class="btn btn-success px-4" style="border-radius: 12px; font-weight: 700;">
                            <i class="fas fa-file-csv mr-2"></i> EXPORT LIST
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- MATCH BREAKDOWN CUSTOM OVERLAY -->
<div id="matchBreakdownOverlay" class="match-breakdown-overlay">
    <div class="match-breakdown-container">
        <div class="match-breakdown-header">
            <div style="flex: 1;">
                <h2>Applicant Details</h2>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <p id="applicationDate" style="margin: 0; font-size: 13px; color: rgba(255, 255, 255, 0.8); font-weight: 600;"></p>
                    <p id="matchModalSubtitle" style="margin: 0; font-size: 13px; color: rgba(255, 255, 255, 0.8); font-weight: 600;"></p>
                </div>
            </div>
            <button class="match-close-btn" onclick="closeMatchBreakdown()" aria-label="Close">&times;</button>
        </div>
        <div class="match-breakdown-body">
            <div class="match-panel-left">
                <div class="match-ai-scroll" id="matchBreakdownContent">
                    <div class="match-loading">
                        <div class="spinner-border" role="status" aria-hidden="true"></div>
                        <div>Loading match breakdown...</div>
                    </div>
                </div>
            </div>
            <div class="match-panel-right">
                <div id="matchProfileContent" class="match-profile-scroll">
                    <div class="match-loading">
                        <div class="spinner-border" role="status" aria-hidden="true"></div>
                        <div>Loading profile...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CONTACT APPLICANT MODAL -->
<div class="modal fade contact-applicant-modal" id="contactApplicantModal" tabindex="-1" role="dialog" aria-labelledby="contactApplicantModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header text-white" style="background-color: #a12124;">
                <div>
                    <h5 class="modal-title font-weight-bold" id="contactApplicantModalLabel">Contact Applicant</h5>
                    <small id="contactApplicantAppliedAtHeader" style="display:block; font-size:13px; color:rgba(255, 255, 255, 0.8);">&nbsp;</small>
                    <small id="contactApplicantNameHeader" style="display:block; font-size:13px; color:rgba(255, 255, 255, 0.8);">&nbsp;</small>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                <div class="email-header-stack mb-4">
                    <div class="email-header-row">
                        <div class="email-header-label">From</div>
                        <div class="email-header-content" id="contactApplicantFrom"></div>
                        <div class="email-header-icon">▾</div>
                    </div>
                    <div class="email-header-row">
                        <div class="email-header-label">To</div>
                        <div class="email-header-content" id="contactApplicantEmail"></div>
                        <button type="button" class="btn btn-link btn-sm p-0 email-header-cc-toggle" id="toggleCcBtn">Cc</button>
                    </div>
                    <div class="email-header-row cc-row" id="cc-field-group" style="display: none;">
                        <div class="email-header-label">Cc</div>
                        <div class="email-header-content">
                            <input type="text" id="contactCcField" class="form-control form-control-sm" placeholder="Add carbon copy emails...">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                <div class="form-group">
                    <label for="contactSubject" class="font-weight-bold">Subject</label>
                    <input id="contactSubject" class="form-control" type="text" placeholder="RE: Job Application Next Steps - [Your Company Name]">
                </div>
                <div class="form-group">
                    <label for="contactMessage" class="font-weight-bold">Message</label>
                    <textarea id="contactMessage" class="form-control" rows="11" placeholder="Dear [Applicant Name],\n\nWe were highly impressed with your application and would like to invite you to...\n"></textarea>
                </div>
                <div class="text-muted small">Save a draft or select an email template to speed up your message.</div>
                <input type="hidden" id="contactApplicantId" value="">
                <input type="hidden" id="contactJobId" value="">
                <input type="hidden" id="contactApplicantEmailHidden" value="">
            </div>
            <div class="modal-footer d-flex flex-wrap align-items-center">
                <div class="d-flex flex-wrap align-items-center mr-auto mb-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm mr-2 mb-2" id="saveDraftBtn">Save as Draft</button>
                    <div class="btn-group mr-2 mb-2">
                        <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Use Email Template
                        </button>
                        <div class="dropdown-menu">
                            <button class="dropdown-item template-option" type="button" data-template="accepted">Accepted Template</button>
                            <button class="dropdown-item template-option" type="button" data-template="rejected">Rejection Template</button>
                            <button class="dropdown-item template-option" type="button" data-template="interview">Interview Template</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-link btn-sm text-secondary mb-2" id="scheduleInterviewBtn">Schedule Interview</button>
                </div>
                <button type="button" class="btn btn-success contact-status-btn mr-2 mb-2" id="contactAcceptBtn" data-status="accepted">
                    <i class="fas fa-check mr-1"></i> Accept Applicant
                </button>
                <button type="button" class="btn btn-danger contact-status-btn mb-2" data-status="rejected">
                    <i class="fas fa-times mr-1"></i> Reject Applicant
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function escapeHtml(value) {
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function closeMatchBreakdown() {
        const overlay = document.getElementById('matchBreakdownOverlay');
        overlay.classList.remove('open');
        setTimeout(() => {
            document.getElementById('matchBreakdownContent').innerHTML = `
                <div class="match-loading">
                    <div class="spinner-border" role="status" aria-hidden="true"></div>
                    <div>Loading match breakdown...</div>
                </div>
            `;
            document.getElementById('matchProfileContent').innerHTML = `
                <div class="match-loading">
                    <div class="spinner-border" role="status" aria-hidden="true"></div>
                    <div>Loading profile...</div>
                </div>
            `;
        }, 300);
    }

    function setContactApplicantButtonState(isLoading, statusText) {
        const buttons = document.querySelectorAll('#contactApplicantModal .contact-status-btn');
        buttons.forEach(button => {
            button.disabled = isLoading;
            if (!button.getAttribute('data-original-text')) {
                button.setAttribute('data-original-text', button.innerHTML);
            }

            if (isLoading && button.getAttribute('data-status') === statusText) {
                button.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Sending...';
            } else {
                button.innerHTML = button.getAttribute('data-original-text');
            }
        });
    }

    function showContactToast(type, message) {
        Swal.fire({
            toast: true,
            position: 'bottom-end',
            icon: type,
            title: message,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    }

    function showContactError(message, debug) {
        Swal.fire({
            icon: 'error',
            title: message,
            html: debug ? '<pre style="text-align:left; white-space:pre-wrap; word-break:break-word; font-size:12px; max-height:240px; overflow:auto; margin-top:12px;">' + escapeHtml(debug) + '</pre>' : '',
            confirmButtonText: 'OK',
            customClass: {
                popup: 'swal-wide'
            }
        });
    }

    const contactEmailTemplates = {
        accepted: {
            subject: 'RE: Job Application Next Steps - [Your Company Name]',
            body: 'Dear [Applicant Name],\n\nWe were highly impressed with your application and would like to formally invite you to a virtual interview to discuss the next steps.\n\nPlease let me know your availability and the best time to connect.\n\nBest regards,\n[Your Name]\n[Your Company Name]'
        },
        rejected: {
            subject: 'Update on Your Application',
            body: 'Dear [Applicant Name],\n\nThank you for taking the time to apply for the position. After careful review, we will not be moving forward with your application at this time.\n\nWe appreciate your interest and encourage you to apply for future openings.\n\nBest regards,\n[Your Name]\n[Your Company Name]'
        },
        interview: {
            subject: 'Schedule Interview for Your Application',
            body: 'Dear [Applicant Name],\n\nWe are excited about your application and would like to schedule a time for an interview.\n\nPlease share your availability for the coming days, and we will confirm a time.\n\nBest regards,\n[Your Name]\n[Your Company Name]'
        }
    };

    let isScheduling = false;
    const contactAcceptLabels = {
        default: 'Accept Applicant',
        scheduling: 'Send & Schedule Interview'
    };

    function setSchedulingMode(enabled) {
        isScheduling = Boolean(enabled);
        const acceptBtn = document.getElementById('contactAcceptBtn');
        if (acceptBtn) {
            acceptBtn.innerHTML = '<i class="fas fa-check mr-1"></i> ' + (isScheduling ? contactAcceptLabels.scheduling : contactAcceptLabels.default);
        }
        if (!isScheduling) {
            $('#contactMessage').val($('#contactMessage').val());
        }
    }

    function getContactDraftKey(applicantId, applicantEmail) {
        return 'contactApplicantDraft_' + (applicantId || applicantEmail || 'anonymous');
    }

    function saveContactDraft() {
        const applicantId = $('#contactApplicantId').val();
        const applicantEmail = $('#contactApplicantEmailHidden').val();
        const subject = $('#contactSubject').val();
        const message = $('#contactMessage').val();
        const draftKey = getContactDraftKey(applicantId, applicantEmail);

        localStorage.setItem(draftKey, JSON.stringify({ subject, message, savedAt: new Date().toISOString() }));
        showContactToast('success', 'Draft saved locally.');
    }

    function loadContactDraft(applicantId, applicantEmail) {
        const draftKey = getContactDraftKey(applicantId, applicantEmail);
        const draft = localStorage.getItem(draftKey);

        if (draft) {
            try {
                const parsed = JSON.parse(draft);
                if (parsed.subject) {
                    $('#contactSubject').val(parsed.subject);
                }
                if (parsed.message) {
                    $('#contactMessage').val(parsed.message);
                }
            } catch (e) {
                console.warn('Unable to load draft', e);
            }
        }
    }

    function applyContactTemplate(templateKey, applicantName) {
        const template = contactEmailTemplates[templateKey];
        if (!template) {
            return;
        }

        const subject = template.subject;
        const message = template.body.replace(/\[Applicant Name\]/g, applicantName || '[Applicant Name]');

        $('#contactSubject').val(subject);
        $('#contactMessage').val(message);
    }

    function buildMailtoUrl(email, subject, message) {
        const params = [];
        if (subject) {
            params.push('subject=' + encodeURIComponent(subject));
        }
        if (message) {
            params.push('body=' + encodeURIComponent(message));
        }
        return 'mailto:' + encodeURIComponent(email) + (params.length ? ('?' + params.join('&')) : '');
    }

    function updateContactMailto() {
        const applicantEmail = $('#contactApplicantEmailHidden').val();
        const subject = $('#contactSubject').val();
        const message = $('#contactMessage').val();

        if (!applicantEmail) {
            $('#emailApplicantBtn').prop('disabled', true);
            return;
        }

        $('#emailApplicantBtn').prop('disabled', false).data('mailto', buildMailtoUrl(applicantEmail, subject, message));
    }

    function scheduleInterview() {
        const applicantEmail = $('#contactApplicantEmailHidden').val();
        const applicantName = $('#contactApplicantNameLabel').text();
        if (!applicantEmail) {
            showContactToast('error', 'Applicant email not available.');
            return;
        }

        setSchedulingMode(true);
        applyContactTemplate('interview', applicantName);
        updateContactMailto();
    }

    $(document).on('show.bs.modal', '#contactApplicantModal', function (event) {
        const trigger = $(event.relatedTarget);
        const applicantId = trigger.data('applicant-id');
        const jobId = trigger.data('job-id');
        const applicantName = trigger.data('applicant-name') || '';
        const applicantEmail = trigger.data('applicant-email') || '';
        const appliedAt = trigger.data('applied-at') || '';
        const fromEmail = 'Aconnect Job Find <<?= htmlspecialchars(getenv('ACONNECT_SMTP_USER') ?: 'Aconnectci3@gmail.com', ENT_QUOTES, 'UTF-8') ?>>';

        $('#contactApplicantId').val(applicantId || '');
        $('#contactJobId').val(jobId || '');
        $('#contactApplicantNameLabel').text(applicantName || 'Applicant');
        $('#contactApplicantNameHeader').text(applicantName || 'Applicant');
        $('#contactApplicantAppliedAtHeader').text(appliedAt ? ('Applied on ' + appliedAt) : '');
        $('#contactApplicantFrom').text(fromEmail);
        $('#contactApplicantEmail').text(applicantEmail ? applicantEmail : 'Not available');
        $('#contactApplicantEmailHidden').val(applicantEmail || '');
        $('#contactSubject').val('');
        $('#contactMessage').val('');
        $('#contactCcField').val('');
        $('#cc-field-group').hide();
        $('#toggleCcBtn').removeClass('active');

        setSchedulingMode(false);
        loadContactDraft(applicantId, applicantEmail);
        updateContactMailto();
        setContactApplicantButtonState(false);
    });

    $(document).on('click', '#saveDraftBtn', function () {
        saveContactDraft();
    });

    $(document).on('click', '#toggleCcBtn', function () {
        $('#cc-field-group').slideToggle(200);
        $(this).toggleClass('active');
    });

    $(document).on('click', '.template-option', function () {
        const templateKey = $(this).data('template');
        const applicantName = $('#contactApplicantNameLabel').text();
        applyContactTemplate(templateKey, applicantName);
        setSchedulingMode(templateKey === 'interview');
        updateContactMailto();
    });

    $(document).on('click', '#scheduleInterviewBtn', function () {
        scheduleInterview();
    });

    $(document).on('click', '#emailApplicantBtn', function () {
        const mailto = $(this).data('mailto');
        if (mailto) {
            window.location.href = mailto;
        } else {
            showContactToast('error', 'Please fill in email details first.');
        }
    });

    $(document).on('input', '#contactSubject, #contactMessage', function () {
        updateContactMailto();
    });

    $(document).on('click', '#contactApplicantModal .contact-status-btn', function () {
        const status = $(this).data('status');
        const applicantId = $('#contactApplicantId').val();
        const jobId = $('#contactJobId').val();

        if (!applicantId) {
            showContactToast('error', 'Applicant ID missing.');
            return;
        }

        setContactApplicantButtonState(true, status);

        const payload = {
            applicant_id: applicantId,
            job_id: jobId,
            status: status,
            cc_email: $('#contactCcField').val() || ''
        };

        if (isScheduling && status === 'accepted') {
            payload.schedule_interview = true;
        }

        $.ajax({
            url: '<?= base_url('AdminJobPosting/send_applicant_email') ?>',
            method: 'POST',
            dataType: 'json',
            data: payload
        }).done(function (response) {
            if (response && response.success) {
                $('#contactApplicantModal').modal('hide');
                showContactToast('success', response.message || 'Notification sent.');
            } else {
                const errorMessage = (response && response.message) ? response.message : 'Unable to send notification.';
                const debugMessage = (response && response.debug) ? response.debug : '';
                if (debugMessage) {
                    showContactError(errorMessage, debugMessage);
                } else {
                    showContactToast('error', errorMessage);
                }
            }
        }).fail(function () {
            showContactToast('error', 'Unable to send notification.');
        }).always(function () {
            setSchedulingMode(false);
            setContactApplicantButtonState(false);
        });
    });

    function renderProfilePanel(data) {
        const applicant = data.applicant || {};
        const employment = applicant.employment || null;
        const certifications = Array.isArray(applicant.certifications) ? applicant.certifications : [];
        const softSkills = String(applicant.soft_skills || '').split(',').map(skill => skill.trim()).filter(Boolean);
        const techSkills = String(applicant.technical_skills || '').split(',').map(skill => skill.trim()).filter(Boolean);

        const standingBadge = applicant.standing_badge || {};
        const standingScore = applicant.standing_score ?? 0;
        const coverStyle = applicant.cover_photo
            ? `style="background: url('${escapeHtml(applicant.cover_photo)}') center/cover;"`
            : '';

        const certificationCards = certifications.length
            ? certifications.map(cert => `
                <div class="cert-item">
                    <div class="flex-shrink-0 mr-3">
                        ${cert.certificate_image
                            ? `<img src="${escapeHtml(cert.certificate_image)}" class="cert-img" alt="Cert">`
                            : `<div class="cert-img"><i class="fas fa-award fa-2x" style="color:#DDD;"></i></div>`}
                    </div>
                    <div class="cert-details">
                        <h4>${escapeHtml(cert.title || '')}</h4>
                        <p>${escapeHtml(cert.issuer || '')}</p>
                        ${cert.date_issued ? `<p style="font-size: 11px;">Issued ${escapeHtml(cert.date_issued)}</p>` : ''}
                    </div>
                </div>
            `).join('')
            : '<p class="empty-text">No certifications listed</p>';

        return `
            <div class="match-profile-cover" ${coverStyle}></div>
            <div class="match-profile-header">
                <div class="match-avatar-wrap">
                    <img class="match-avatar" src="${escapeHtml(applicant.profile_image || '<?= base_url('assets/images/person-default.png') ?>')}" alt="Applicant photo" onerror="this.src='<?= base_url('assets/images/person-default.png') ?>'">
                </div>
                <h3 class="match-name">${escapeHtml(applicant.full_name || 'Applicant')}</h3>
                <div class="match-subtitle">${escapeHtml(applicant.degree || 'Degree not listed')}</div>
                <div class="match-subtitle">${escapeHtml(applicant.graduation_year || '—')} | ${escapeHtml(applicant.school || '—')}</div>
                <div class="profile-stat-row">
                    ${standingBadge.title ? `<div class="profile-stat"><i class="${escapeHtml(standingBadge.icon || 'fas fa-medal')}"></i> ${escapeHtml(standingBadge.title)}</div>` : ''}
                    <div class="profile-stat"><i class="fas fa-medal"></i> Standing: <strong>${escapeHtml(standingScore)}</strong> pts</div>
                </div>
                <div class="profile-stat-row">
                    <div class="profile-stat"><i class="fas fa-envelope"></i> ${escapeHtml(applicant.email || '—')}</div>
                    <div class="profile-stat"><i class="fas fa-phone"></i> ${escapeHtml(applicant.phone || '—')}</div>
                </div>
            </div>

            <div class="profile-content-card">
                <h2><i class="fas fa-id-badge"></i> Profile Information</h2>
                <div class="section-divider"></div>
                <div class="profile-grid">
                    <div class="profile-field">
                        <span class="label">Email</span>
                        <div class="value">${escapeHtml(applicant.email || '—')}</div>
                    </div>
                    <div class="profile-field">
                        <span class="label">Alternate Email</span>
                        <div class="value">${escapeHtml(applicant.alternative_email || 'Not Set')}</div>
                    </div>
                    <div class="profile-field">
                        <span class="label">Phone</span>
                        <div class="value">${escapeHtml(applicant.phone || '—')}</div>
                    </div>
                    <div class="profile-field">
                        <span class="label">Status</span>
                        <div class="value">${escapeHtml(applicant.status || '—')}</div>
                    </div>
                    <div class="profile-field">
                        <span class="label">Current Job</span>
                        <div class="value">${escapeHtml(applicant.current_job || 'Not Set')}</div>
                    </div>
                    <div class="profile-field">
                        <span class="label">Organization</span>
                        <div class="value">${escapeHtml(applicant.current_job_organization || 'Not Set')}</div>
                    </div>
                    <div class="profile-field">
                        <span class="label">Student Number</span>
                        <div class="value">${escapeHtml(applicant.student_number || 'Not Set')}</div>
                    </div>
                </div>
            </div>

            <div class="profile-content-card">
                <h2><i class="fas fa-briefcase"></i> Career Summary</h2>
                <div class="section-divider"></div>
                ${employment ? `
                    <div class="job-entry">
                        <h4 style="font-size: 17px; font-weight: 700;">${escapeHtml(employment.job_title || '(Not Set)')}</h4>
                        <p style="color: #666666; margin-bottom: 8px;">${escapeHtml(employment.company_name || '(Not Set)')}</p>
                        <p style="font-size: 14px; color: #555;">${escapeHtml(employment.employment_status || 'Not Set')} | ${escapeHtml(employment.year_of_service ?? 0)} year(s) | ${escapeHtml(employment.promotion_count ?? 0)} promotion(s)</p>
                    </div>
                ` : '<p class="empty-text">No professional experience listed</p>'}
            </div>

            <div class="profile-content-card">
                <h2><i class="fas fa-star"></i> Skills</h2>
                <div class="section-divider"></div>
                <div class="skills-container">
                    <div class="skills-group" style="margin-bottom: 18px;">
                        <h6><i class="fas fa-heart"></i> Soft Skills</h6>
                        <div class="expertise-tags" style="margin-top: 10px;">
                            ${softSkills.length ? softSkills.map(skill => `<span class="expertise-tag"><i class="fas fa-check-circle"></i> ${escapeHtml(skill)}</span>`).join('') : '<p style="color:#666666; font-size:13px;">No soft skills added yet</p>'}
                        </div>
                    </div>
                    <div class="skills-group">
                        <h6><i class="fas fa-gear"></i> Technical Skills</h6>
                        <div class="expertise-tags" style="margin-top: 10px;">
                            ${techSkills.length ? techSkills.map(skill => `<span class="expertise-tag"><i class="fas fa-code"></i> ${escapeHtml(skill)}</span>`).join('') : '<p style="color:#666666; font-size:13px;">No technical skills added yet</p>'}
                        </div>
                    </div>
                </div>
            </div>

            <div class="profile-content-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h2 class="mb-0" style="border:none;"><i class="fas fa-certificate"></i> Professional Certifications</h2>
                </div>
                <div class="section-divider"></div>
                <div class="cert-list">
                    ${certificationCards}
                </div>
            </div>
        `;
    }

    function renderMatchBreakdown(data) {
        const applicant = data.applicant || {};
        const job = data.job || {};
        const match = data.match || {};
        const strengths = Array.isArray(match.strengths) ? match.strengths : [];
        const gaps = Array.isArray(match.gaps) ? match.gaps : [];

        const recommendationText = match.summary || 'Review this applicant against the role requirements and the highlighted areas below.';
        const nextSteps = gaps.length
            ? gaps.slice(0, 3).map(gap => `Help the applicant strengthen: ${gap}`).join('<br>')
            : 'Proceed with the application review. The profile appears aligned with the role requirements.';

        const renderedStrengths = strengths.length
            ? `<ul class="match-list">${strengths.map(item => `<li>${escapeHtml(item)}</li>`).join('')}</ul>`
            : '<div class="match-note-text">No strengths were returned for this analysis.</div>';

        const renderedGaps = gaps.length
            ? `<ul class="match-list">${gaps.map(item => `<li>${escapeHtml(item)}</li>`).join('')}</ul>`
            : '<div class="match-note-text">No major gaps were returned for this analysis.</div>';

        return `
            <div class="match-score-card">
                <div class="match-score-value">${escapeHtml(match.percentage ?? 0)}%</div>
                <div style="font-size: 14px; font-weight: 700; opacity: 0.96; margin-bottom: 8px;">${escapeHtml(match.status || 'Match Analysis')}</div>
                <div style="font-size: 13px; line-height: 1.6; opacity: 0.92;">${escapeHtml(match.summary || 'Match analysis generated for the selected applicant and role.')}</div>
            </div>

            <div class="match-note-box recommendation">
                <div class="match-note-title">Recommendation</div>
                <div class="match-note-text">${escapeHtml(recommendationText)}</div>
            </div>

            <div class="match-section">
                <div class="match-section-title">Job Snapshot</div>
                <div class="match-chip"><i class="fas fa-briefcase"></i> ${escapeHtml(job.job_title || '—')}</div>
                <div class="match-chip"><i class="fas fa-building"></i> ${escapeHtml(job.company || '—')}</div>
                <div class="match-chip"><i class="fas fa-map-marker-alt"></i> ${escapeHtml(job.location || '—')}</div>
                <div class="match-chip"><i class="fas fa-wallet"></i> ${escapeHtml(job.salary_range || '—')}</div>
            </div>

            <div class="match-note-box strengths">
                <div class="match-note-title">Why You're a Good Match</div>
                ${renderedStrengths}
            </div>

            <div class="match-note-box gaps">
                <div class="match-note-title">Areas To Develop</div>
                ${renderedGaps}
            </div>

            <div class="match-note-box next-steps" style="margin-bottom: 0;">
                <div class="match-note-title">Next Best Steps</div>
                <div class="match-note-text">${nextSteps}</div>
                ${match.cached ? '<div class="mt-3 small text-muted"><i class="fas fa-database mr-1"></i> Cached AI result used</div>' : ''}
                ${match.ai_powered ? '<div class="mt-2 small" style="color:#a12124;"><i class="fas fa-robot mr-1"></i> Powered by AI Analysis</div>' : ''}
            </div>
        `;

    }

    function openApplicantMatchModal(triggerButton, jobId, alumniId, applicantName) {
        const overlay = document.getElementById('matchBreakdownOverlay');
        const subtitle = document.getElementById('matchModalSubtitle');
        const appDateSpan = document.getElementById('applicationDate');
        const aiContent = document.getElementById('matchBreakdownContent');
        const profileContent = document.getElementById('matchProfileContent');

        subtitle.textContent = applicantName || 'Applicant profile';
        appDateSpan.textContent = '';
        aiContent.innerHTML = `
            <div class="match-loading">
                <div class="spinner-border" role="status" aria-hidden="true"></div>
                <div>Loading match breakdown...</div>
            </div>
        `;
        profileContent.innerHTML = `
            <div class="match-loading">
                <div class="spinner-border" role="status" aria-hidden="true"></div>
                <div>Loading profile...</div>
            </div>
        `;

        overlay.classList.add('open');

        fetch('<?= base_url('AdminJobPosting/applicant_match_breakdown/') ?>' + jobId + '/' + alumniId)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    aiContent.innerHTML = `<div class="match-error">${escapeHtml(data.error)}</div>`;
                    return;
                }

                appDateSpan.textContent = 'Applied on ' + escapeHtml(data.applicant.applied_at || 'Unknown');
                aiContent.innerHTML = renderMatchBreakdown(data);
                profileContent.innerHTML = renderProfilePanel(data);
            })
            .catch(() => {
                aiContent.innerHTML = '<div class="match-error">Unable to load the match breakdown. Please try again.</div>';
                profileContent.innerHTML = '<div class="match-error">Unable to load profile. Please try again.</div>';
            });
    }

    // Live Search with 3+ character threshold
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('jobSearch');
        if (searchInput) {
            // Function to apply filter
            const applyFilter = function() {
                const searchTerm = searchInput.value.toLowerCase();
                const jobRows = document.querySelectorAll('.job-item');
                
                if (searchTerm.length === 0) {
                    jobRows.forEach(row => {
                        row.style.display = '';
                    });
                    return;
                }
                
                if (searchTerm.length < 3) {
                    jobRows.forEach(row => {
                        row.style.display = '';
                    });
                    return;
                }
                
                jobRows.forEach(row => {
                    const jobTitle = row.querySelector('.job-title-cell')?.textContent.toLowerCase() || '';
                    const company = row.querySelector('.company-label')?.textContent.toLowerCase() || '';
                    
                    if (jobTitle.includes(searchTerm) || company.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            };
            
            // Apply filter on page load if search term exists
            applyFilter();
            
            // Apply filter on input event
            searchInput.addEventListener('input', applyFilter);
        }
    });

    function confirmDelete(id, title) {
        Swal.fire({
            title: 'Delete Posting?',
            text: "Are you sure you want to permanently remove '" + title + "'?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#a12124',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'CONFIRM DELETE',
            padding: '2em',
            customClass: {
                popup: '',
                confirmButton: 'btn btn-danger px-4',
                cancelButton: 'btn btn-light px-4 mr-2'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('AdminJobPosting/delete/') ?>" + id;
            }
        });

    }

    document.addEventListener('DOMContentLoaded', function() {
        $('#matchBreakdownModal').on('hidden.bs.modal', function() {
            document.getElementById('matchBreakdownContent').innerHTML = `
                <div class="match-loading">
                    <div class="spinner-border" role="status" aria-hidden="true"></div>
                    <div>Loading match breakdown...</div>
                </div>
            `;
            document.getElementById('matchModalSubtitle').textContent = 'Applicant profile and AI explanation';
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'bottom-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });

        <?php if($this->session->flashdata('success')): ?>
            Toast.fire({
                icon: 'success',
                title: '<?= $this->session->flashdata('success') ?>'
            });
        <?php endif; ?>

        <?php if($this->session->flashdata('error')): ?>
            Toast.fire({
                icon: 'error',
                title: '<?= $this->session->flashdata('error') ?>'
            });
        <?php endif; ?>
    });
</script>

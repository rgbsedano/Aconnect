<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Employer Profile Settings - AConnect">
    <title>AConnect | Profile Settings</title>

    <!-- Bootstrap CSS -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
    :root {
        --maroon: #a12124;
        --maroon-dark: #7d181b;
        --gold: #D4A574;
        --bg: #FAFAF8;
        --card: #ffffff;
        --text: #1F2937;
        --muted: #6B7280;
        --border: #E5E7EB;
        --border-radius: 8px;
        --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
        --shadow-md: 0 4px 12px rgba(0,0,0,0.1);
        --shadow-lg: 0 10px 30px rgba(0,0,0,0.15);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background-color: var(--bg);
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        color: var(--text);
        line-height: 1.6;
        padding-top: 55px;
    }

    .settings-container {
        display: flex;
        min-height: calc(100vh - 55px);
    }

    /* Sidebar */
    .settings-sidebar {
        display: none;
        width: 280px;
        background-color: var(--card);
        border-right: 1px solid var(--border);
        padding: 30px 0;
        position: fixed;
        height: calc(100vh - 55px);
        overflow-y: auto;
        top: 55px;
        box-shadow: var(--shadow-sm);
    }

    .settings-sidebar h2 {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--text);
        padding: 0 20px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .settings-sidebar h2 i {
        color: var(--maroon);
        font-size: 1.2rem;
    }

    .sidebar-menu {
        list-style: none;
    }

    .sidebar-menu li {
        margin: 0;
    }

    .sidebar-menu-item {
        display: flex;
        align-items: center;
        padding: 14px 20px;
        color: var(--muted);
        text-decoration: none;
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }

    .sidebar-menu-item:hover {
        background-color: #f9f9f9;
        color: var(--text);
        border-left-color: var(--gold);
    }

    .sidebar-menu-item.active {
        background-color: rgba(161, 33, 36, 0.08);
        color: var(--maroon);
        border-left-color: var(--maroon);
        font-weight: 600;
    }

    .sidebar-menu-item i {
        width: 20px;
        height: 20px;
        margin-right: 12px;
        font-size: 1rem;
        text-align: center;
    }

    .sidebar-menu-item-label {
        flex: 1;
    }

    .sidebar-menu-item-description {
        font-size: 0.75rem;
        color: var(--muted);
        margin-top: 3px;
    }

    .sidebar-badge {
        background-color: var(--maroon);
        color: white;
        font-size: 0.65rem;
        padding: 2px 6px;
        border-radius: 12px;
        margin-left: 8px;
        font-weight: 600;
    }

    /* Main Content */
    .settings-content {
        margin-left: 0;
        flex: 1;
        padding: 40px;
    }

    .settings-content h1 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #ff6b6b;
        margin-bottom: 10px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding-left: 0;
        padding-right: 0;
        margin-left: auto;
        margin-right: auto;
        max-width: 1200px;
        padding-top: 0;
        padding-bottom: 0;
    }

    .settings-content h1 i {
        color: #ff6b6b;
        font-size: 1.5rem;
    }

    .heading-white {
        color: #ffffff;
    }

    .heading-coral {
        color: #ff6b6b;
    }

    .section-description {
        font-size: 0.95rem;
        color: #e0e0e0;
        margin-bottom: 30px;
        margin-left: auto;
        margin-right: auto;
        max-width: 1200px;
        padding-left: 0;
        padding-right: 0;
    }

    /* Settings Section */
    .settings-section {
        display: none;
    }

    .settings-section.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .settings-group {
        background: var(--bg);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 0;
        margin-bottom: 25px;
        margin-left: auto;
        margin-right: auto;
        max-width: 1200px;
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }

    .settings-group-header {
        padding: 20px 25px;
        border-bottom: 2px solid var(--gold);
        background: var(--card);
    }

    .settings-group-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text);
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
    }

    .settings-group-title i {
        color: var(--maroon);
        font-size: 1.1rem;
    }

    .settings-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 25px;
        border-bottom: 1px solid var(--border);
        transition: background-color 0.3s ease;
    }

    .settings-item:hover {
        background-color: #f9f9f9;
    }

    .settings-item:last-child {
        border-bottom: none;
    }

    .settings-item-label {
        flex: 1;
    }

    .settings-item-label h4 {
        font-size: 0.95rem;
        color: var(--text);
        margin-bottom: 4px;
        font-weight: 600;
    }

    .settings-item-label p {
        font-size: 0.9rem;
        color: var(--muted);
        margin: 0;
    }

    .settings-item-action {
        margin-left: 20px;
    }

    .settings-item-action a,
    .settings-item-action button {
        color: var(--maroon);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        border: none;
        background: none;
        cursor: pointer;
        padding: 0;
        transition: all 0.3s ease;
    }

    .settings-item-action a:hover,
    .settings-item-action button:hover {
        color: var(--maroon-dark);
        text-decoration: underline;
    }

    /* Flash Messages */
    .alert {
        margin-bottom: 25px;
        border-radius: 12px;
        border: none;
        padding: 15px 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .alert-success {
        background-color: #D1FAE5;
        color: #065F46;
        border-left: 4px solid #10b981;
    }

    .alert-danger {
        background-color: #FEE2E2;
        color: #7F1D1D;
        border-left: 4px solid #ef4444;
    }

    /* Checkbox Styling */
    input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: var(--maroon);
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .settings-container {
            flex-direction: column;
            margin-top: 0;
            min-height: calc(100vh - 55px);
        }

        .settings-sidebar {
            width: 100%;
            height: auto;
            position: relative;
            top: auto;
            border-right: none;
            border-bottom: 1px solid var(--border);
            padding: 20px 0;
            margin-top: 0;
            box-shadow: none;
        }

        .settings-sidebar h2 {
            padding: 0 20px;
            margin-bottom: 15px;
            font-size: 1.1rem;
        }

        .settings-content {
            margin-left: 0;
            padding: 20px;
        }

        .settings-content h1 {
            font-size: 1.3rem;
            margin-bottom: 8px;
        }

        .section-description {
            margin-bottom: 20px;
        }

        .settings-item {
            flex-direction: column;
            align-items: flex-start;
            padding: 15px 20px;
        }

        .settings-item-action {
            margin-left: 0;
            margin-top: 12px;
            width: 100%;
        }

        .settings-item-action a {
            display: inline-block;
        }
    }

    /* Modal Z-Index Fixes */
    .modal-backdrop {
        z-index: 2049 !important;
    }

    .modal {
        z-index: 2050 !important;
        margin-top: 70px !important;
    }

    .modal-header {
        background: #a12124 !important;
    }

    /* Group card description hardening */
    #groups .group-card-description {
        overflow-wrap: anywhere !important;
        word-break: break-word !important;
        hyphens: auto !important;
        display: -webkit-box !important;
        -webkit-line-clamp: 3 !important;
        line-clamp: 3 !important;
        -webkit-box-orient: vertical !important;
        overflow: hidden !important;
        max-height: 4.5em !important;
        text-overflow: ellipsis !important;
    }

    #groupDetailsModal #modalGroupDescription {
        overflow-wrap: anywhere !important;
        word-break: break-word !important;
        hyphens: auto !important;
        line-height: 1.6 !important;
    }

    /* Modal body scrolling for smaller screens */
    #groupDetailsModal .modal-body {
        max-height: calc(100vh - 250px);
        overflow-y: auto;
    }

    /* Group detail modal header/title alignment */
    #groupDetailsModal .modal-header {
        display: flex;
        align-items: center;
    }

    #groupDetailsModal #modalGroupName {
        display: inline-block;
        padding-left: 20px;
    }

    #groupDetailsModal .modal-header .close {
        width: 40px;
        height: 40px;
        padding: 0;
        line-height: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #groupDetailsModal .modal-header .close span {
        line-height: 1;
        display: block;
    }

    /* Group detail modal info boxes */
    #groupDetailsModal .modal-info-box {
        border: 1px solid #e0e0e0 !important;
        display: flex !important;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        min-height: 110px;
        flex: 1 !important;
    }

    #groupDetailsModal .modal-info-box h6,
    #groupDetailsModal .modal-info-box p {
        width: 100%;
        text-align: center;
    }

    /* Group detail modal member companies uniform cards */
    #groupDetailsModal #modalGroupMembersList .member-company-card {
        min-height: 80px !important;
        aspect-ratio: 4 / 3;
        display: flex !important;
        align-items: center;
        justify-content: center;
        border: 1px solid #e5e7eb;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    #groupDetailsModal #modalGroupMembersList .member-company-card:hover {
        transform: translateY(-2px);
        border-color: #a12124;
        box-shadow: 0 6px 16px rgba(161, 33, 36, 0.12);
    }

    #groupDetailsModal #modalGroupMembersList .member-company-name {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        overflow-wrap: anywhere;
        word-break: break-word;
    }

    @media (max-width: 768px) {
        #groupDetailsModal .modal-body > div:nth-child(2) {
            grid-template-columns: 1fr !important;
        }

        #groupDetailsModal #modalGroupMembersList .member-company-card {
            min-height: 100px !important;
        }
    }

        /* Search bar styling */
        #groups .group-search-container {
            display: flex;
            gap: 12px;
            margin: 20px 20px 0 20px;
            align-items: center;
        }

        #groups .search-input-wrapper {
            flex: 1;
            min-width: 250px;
            position: relative;
            display: flex;
            align-items: center;
        }

        #groups .search-input-wrapper i.search-icon {
            position: absolute;
            left: 14px;
            color: var(--muted);
            pointer-events: none;
            font-size: 0.95rem;
        }

        #groups .search-input-wrapper input {
            width: 100%;
            padding: 11px 14px 11px 38px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.95rem;
            color: var(--text);
            background: white;
            transition: all 0.3s ease;
        }

        #groups .search-input-wrapper input:focus {
            outline: none;
            border-color: var(--maroon);
            box-shadow: 0 0 0 3px rgba(161, 33, 36, 0.1);
        }

        #groups .search-input-wrapper input::placeholder {
            color: var(--muted);
        }

        #groups .search-clear-btn {
            display: none;
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            color: var(--muted);
            cursor: pointer;
            padding: 4px 6px;
            font-size: 1rem;
            transition: color 0.3s ease;
        }

        #groups .search-input-wrapper input:not(:placeholder-shown) ~ .search-clear-btn {
            display: block;
        }

        #groups .search-clear-btn:hover {
            color: var(--maroon);
        }

        #groups .no-groups-search {
            display: none;
            padding: 40px 20px;
            text-align: center;
            background: #f9fafb;
            border-radius: var(--border-radius);
            margin: 20px 20px 0 20px;
        }

        #groups .no-groups-search.active {
            display: block;
        }

        #groups .no-groups-search i {
            font-size: 48px;
            color: var(--border);
            margin-bottom: 12px;
            display: block;
        }

        #groups .no-groups-search h4 {
            color: var(--muted);
            margin-bottom: 8px;
            font-size: 1.1rem;
        }

        #groups .no-groups-search p {
            color: var(--muted);
            font-size: 14px;
            margin: 0;
        }

        @media (max-width: 768px) {
            #groups .group-search-container {
                flex-direction: column;
                margin: 20px 16px 0 16px;
            }

            #groups .search-input-wrapper {
                min-width: 100%;
            }
        }

        /* Employer group dashboard cards */
        #groups .group-card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
            margin-top: 20px;
            padding: 20px;
        }

        #groups .group-card {
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            cursor: pointer;
            display: flex;
            flex-direction: column;
            height: 320px;
            overflow: hidden;
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }

        #groups .group-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 14px 32px rgba(31, 41, 55, 0.14);
            border-color: rgba(161, 33, 36, 0.18);
        }

        #groups .group-card__body {
            display: flex;
            flex-direction: column;
            gap: 14px;
            padding: 20px;
            flex: 1;
            overflow: hidden;
        }

        #groups .group-card__header {
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }

        #groups .group-card__icon {
            width: 48px;
            height: 48px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: rgba(161, 33, 36, 0.1);
            color: var(--maroon);
            box-shadow: inset 0 0 0 1px rgba(161, 33, 36, 0.08);
        }

        #groups .group-card__icon i {
            font-size: 1.05rem;
        }

        #groups .group-card__title {
            margin: 0 0 4px 0;
            color: var(--text);
            font-size: 1.02rem;
            font-weight: 700;
            line-height: 1.35;
        }

        #groups .group-card__meta {
            margin: 0;
            color: var(--muted);
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        #groups .group-card__description {
            margin: 0;
            color: var(--text);
            font-size: 0.92rem;
            line-height: 1.55;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            line-clamp: 3;
            -webkit-box-orient: vertical;
            word-break: break-word;
            overflow-wrap: anywhere;
            min-height: 4.35em;
        }

        #groups .group-card__footer {
            margin-top: auto;
            padding: 14px 20px 18px;
            border-top: 1px solid #f8f9fc;
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            align-items: center;
        }

        #groups .group-card__badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 700;
            line-height: 1;
            white-space: nowrap;
        }

        #groups .group-card__badge--assigned {
            background: rgba(16, 185, 129, 0.12);
            color: #047857;
        }

        #groups .group-card__badge--count {
            background: rgba(14, 165, 233, 0.12);
            color: #0369a1;
        }

        @media (max-width: 768px) {
            #groups .group-card-grid {
                grid-template-columns: 1fr;
                padding: 16px;
            }

            #groups .group-card {
                height: auto;
                min-height: 300px;
            }
        }

    /* Member Jobs Modal - Back Button & Job Card Styling */
    #memberJobsModal .modal-header {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        padding: 20px 30px !important;
    }

    #memberJobsModal .back-to-group-btn {
        background: none !important;
        border: none !important;
        color: white !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        cursor: pointer !important;
        padding: 0 !important;
        margin-right: 20px !important;
        display: flex !important;
        align-items: center !important;
        gap: 6px !important;
        transition: all 0.3s ease !important;
    }

    #memberJobsModal .back-to-group-btn:hover {
        opacity: 0.8 !important;
        transform: translateX(-3px) !important;
    }

    #memberJobsModal .modal-title {
        flex: 1 !important;
        font-weight: 700 !important;
        font-size: 1.3rem !important;
    }

    #memberJobsModal .job-card {
        padding: 18px !important;
        background: white !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 12px !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        display: flex !important;
        flex-direction: column !important;
    }

    #memberJobsModal .job-card:hover {
        box-shadow: 0 8px 24px rgba(161, 33, 36, 0.12) !important;
        border-color: #a12124 !important;
        transform: translateY(-3px) !important;
    }

    #memberJobsModal .job-card-header {
        display: flex !important;
        justify-content: space-between !important;
        align-items: flex-start !important;
        margin-bottom: 12px !important;
        gap: 12px !important;
    }

    #memberJobsModal .job-card-title {
        color: #1F2937 !important;
        font-weight: 700 !important;
        margin: 0 !important;
        font-size: 15px !important;
        flex: 1 !important;
        line-height: 1.4 !important;
    }

    #memberJobsModal .job-card-category {
        color: #6B7280 !important;
        margin: 0 0 10px 0 !important;
        font-size: 12px !important;
    }

    #memberJobsModal .job-card-details {
        display: grid !important;
        grid-template-columns: repeat(3, 1fr) !important;
        gap: 12px !important;
        margin: 12px 0 !important;
        padding: 12px 0 !important;
        border-top: 1px solid #f0f0f0 !important;
        border-bottom: 1px solid #f0f0f0 !important;
    }

    #memberJobsModal .job-detail-item {
        display: flex !important;
        align-items: center !important;
        gap: 6px !important;
        font-size: 12px !important;
        color: #6B7280 !important;
    }

    #memberJobsModal .job-detail-label {
        font-weight: 600 !important;
        color: #1F2937 !important;
    }

    #memberJobsModal .job-card-meta {
        font-size: 11px !important;
        color: #9CA3AF !important;
        margin-top: 10px !important;
    }

    @media (max-width: 768px) {
        #memberJobsModal .job-card-details {
            grid-template-columns: 1fr !important;
        }

        #memberJobsModal .job-card-header {
            flex-direction: column !important;
            align-items: flex-start !important;
        }
    }
    </style>
</head>
<body>
    <?php $this->load->view('__header'); ?>

    <div class="settings-container">
        <!-- Sidebar -->
        <aside class="settings-sidebar">
            <h2><i class="fas fa-sliders-h"></i> Settings</h2>
            <ul class="sidebar-menu">
                <li>
                    <a href="#account" class="sidebar-menu-item <?= ($active_section === 'account') ? 'active' : '' ?>" onclick="switchSection(event, 'account')">
                        <i class="fas fa-user"></i>
                        <div class="sidebar-menu-item-label">
                            <div>Account settings</div>
                            <div class="sidebar-menu-item-description">Your contact information</div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#security" class="sidebar-menu-item <?= ($active_section === 'security') ? 'active' : '' ?>" onclick="switchSection(event, 'security')">
                        <i class="fas fa-lock"></i>
                        <div class="sidebar-menu-item-label">
                            <div>Security settings <span class="sidebar-badge" style="background-color: var(--maroon);">New</span></div>
                            <div class="sidebar-menu-item-description">Manage your account security</div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#communications" class="sidebar-menu-item <?= ($active_section === 'communications') ? 'active' : '' ?>" onclick="switchSection(event, 'communications')">
                        <i class="fas fa-envelope"></i>
                        <div class="sidebar-menu-item-label">
                            <div>Communications settings</div>
                            <div class="sidebar-menu-item-description">Manage notifications and messages</div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#devices" class="sidebar-menu-item <?= ($active_section === 'devices') ? 'active' : '' ?>" onclick="switchSection(event, 'devices')">
                        <i class="fas fa-mobile-alt"></i>
                        <div class="sidebar-menu-item-label">
                            <div>Device management</div>
                            <div class="sidebar-menu-item-description">Manage your active devices and sessions</div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#privacy" class="sidebar-menu-item <?= ($active_section === 'privacy') ? 'active' : '' ?>" onclick="switchSection(event, 'privacy')">
                        <i class="fas fa-shield-alt"></i>
                        <div class="sidebar-menu-item-label">
                            <div>Privacy settings</div>
                            <div class="sidebar-menu-item-description">Information about your privacy on AConnect</div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="#groups" class="sidebar-menu-item <?= ($active_section === 'groups') ? 'active' : '' ?>" onclick="switchSection(event, 'groups')">
                        <i class="fas fa-users"></i>
                        <div class="sidebar-menu-item-label">
                            <div>My groups</div>
                            <div class="sidebar-menu-item-description">View your assigned groups</div>
                        </div>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="settings-content">
            <!-- Flash Messages -->
            <?php if ($this->session->flashdata('success_message')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?= $this->session->flashdata('success_message') ?>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error_message')): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?= $this->session->flashdata('error_message') ?>
                </div>
            <?php endif; ?>

            <!-- Account Settings Section -->
            <section id="account" class="settings-section <?= ($active_section === 'account') ? 'active' : '' ?>">
                <h1><span class="heading-white">Account</span> <span class="heading-coral">settings</span></h1>
                <p class="section-description">Manage your employer account information</p>
                
                <div class="settings-group">
                    <div class="settings-group-header">
                        <h3 class="settings-group-title"><i class="fas fa-id-card"></i> Account Information</h3>
                    </div>
                    <div class="settings-item">
                        <div class="settings-item-label">
                            <h4>Account type</h4>
                            <p>Employer</p>
                        </div>
                        <div class="settings-item-action">
                            <span style="color: var(--muted); font-size: 0.85rem;">Permanent</span>
                        </div>
                    </div>

                    <div class="settings-item">
                        <div class="settings-item-label">
                            <h4><i class="fas fa-envelope" style="margin-right: 6px; color: var(--maroon);"></i> Email</h4>
                            <p><?= htmlspecialchars($email ?? 'Not set') ?></p>
                        </div>
                        <div class="settings-item-action">
                            <a href="#" onclick="showEmailModal(event)">Change</a>
                        </div>
                    </div>

                    <div class="settings-item">
                        <div class="settings-item-label">
                            <h4><i class="fas fa-building" style="margin-right: 6px; color: var(--maroon);"></i> Company name</h4>
                            <p><?= htmlspecialchars($company_name ?? 'Not set') ?></p>
                        </div>
                        <div class="settings-item-action">
                            <a href="#" onclick="showCompanyModal(event)">Change</a>
                        </div>
                    </div>

                    <div class="settings-item">
                        <div class="settings-item-label">
                            <h4><i class="fas fa-sign-out-alt" style="margin-right: 6px; color: var(--maroon);"></i> Session</h4>
                            <p>Sign out of your account</p>
                        </div>
                        <div class="settings-item-action">
                            <a href="<?= base_url('employer_profile/logout') ?>" style="color: var(--maroon);">Sign out</a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Security Settings Section -->
            <section id="security" class="settings-section <?= ($active_section === 'security') ? 'active' : '' ?>">
                <h1><span class="heading-white">Security</span> <span class="heading-coral">settings</span></h1>
                <p class="section-description">Keep your account secure with strong passwords and authentication</p>
                
                <div class="settings-group">
                    <div class="settings-group-header">
                        <h3 class="settings-group-title"><i class="fas fa-shield-alt"></i> Security Options</h3>
                    </div>
                    <div class="settings-item">
                        <div class="settings-item-label">
                            <h4>Password</h4>
                            <p>Last changed 3 months ago</p>
                        </div>
                        <div class="settings-item-action">
                            <a href="#">Change password</a>
                        </div>
                    </div>

                    <div class="settings-item">
                        <div class="settings-item-label">
                            <h4>Two-factor authentication</h4>
                            <p>Not enabled</p>
                        </div>
                        <div class="settings-item-action">
                            <a href="#">Enable 2FA</a>
                        </div>
                    </div>

                    <div class="settings-item">
                        <div class="settings-item-label">
                            <h4>Login activity</h4>
                            <p>View your recent login history</p>
                        </div>
                        <div class="settings-item-action">
                            <a href="#">View history</a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Communications Settings Section -->
            <section id="communications" class="settings-section <?= ($active_section === 'communications') ? 'active' : '' ?>">
                <h1><span class="heading-white">Communications</span> <span class="heading-coral">settings</span></h1>
                <p class="section-description">Control how you receive notifications and updates</p>
                
                <div class="settings-group">
                    <div class="settings-group-header">
                        <h3 class="settings-group-title"><i class="fas fa-envelope"></i> Email Preferences</h3>
                    </div>
                    <div class="settings-item">
                        <div class="settings-item-label">
                            <h4>Email notifications</h4>
                            <p>Receive important updates via email</p>
                        </div>
                        <div class="settings-item-action">
                            <input type="checkbox" checked>
                        </div>
                    </div>

                    <div class="settings-item">
                        <div class="settings-item-label">
                            <h4>Job application alerts</h4>
                            <p>Get notified when someone applies to your jobs</p>
                        </div>
                        <div class="settings-item-action">
                            <input type="checkbox" checked>
                        </div>
                    </div>

                    <div class="settings-item">
                        <div class="settings-item-label">
                            <h4>Marketing communications</h4>
                            <p>Receive promotional emails and updates</p>
                        </div>
                        <div class="settings-item-action">
                            <input type="checkbox">
                        </div>
                    </div>
                </div>
            </section>

            <!-- Device Management Section -->
            <section id="devices" class="settings-section <?= ($active_section === 'devices') ? 'active' : '' ?>">
                <h1><span class="heading-white">Device</span> <span class="heading-coral">management</span></h1>
                <p class="section-description">Manage devices and active sessions on your account</p>
                
                <div class="settings-group">
                    <div class="settings-group-header">
                        <h3 class="settings-group-title"><i class="fas fa-laptop"></i> Active Devices</h3>
                    </div>
                    <div class="settings-item">
                        <div class="settings-item-label">
                            <h4>Current device</h4>
                            <p>Chrome on Windows 10</p>
                        </div>
                        <div class="settings-item-action">
                            <span style="display: inline-flex; align-items: center; gap: 6px; color: #10b981; font-size: 0.85rem; font-weight: 600;"><span style="width: 8px; height: 8px; background-color: #10b981; border-radius: 50%; display: inline-block;"></span> Active now</span>
                        </div>
                    </div>

                    <div class="settings-item">
                        <div class="settings-item-label">
                            <h4>Manage all devices</h4>
                            <p>View and manage all devices with active sessions</p>
                        </div>
                        <div class="settings-item-action">
                            <a href="#">View devices</a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Privacy Settings Section -->
            <section id="privacy" class="settings-section <?= ($active_section === 'privacy') ? 'active' : '' ?>">
                <h1><span class="heading-white">Privacy</span> <span class="heading-coral">settings</span></h1>
                <p class="section-description">Control your privacy and data collection preferences</p>
                
                <div class="settings-group">
                    <div class="settings-group-header">
                        <h3 class="settings-group-title"><i class="fas fa-user-shield"></i> Privacy Preferences</h3>
                    </div>
                    <div class="settings-item">
                        <div class="settings-item-label">
                            <h4>Data collection</h4>
                            <p>Allow us to collect usage data to improve your experience</p>
                        </div>
                        <div class="settings-item-action">
                            <input type="checkbox" checked>
                        </div>
                    </div>

                    <div class="settings-item">
                        <div class="settings-item-label">
                            <h4>Profile visibility</h4>
                            <p>Control who can see your company profile</p>
                        </div>
                        <div class="settings-item-action">
                            <a href="#">Manage visibility</a>
                        </div>
                    </div>

                    <div class="settings-item">
                        <div class="settings-item-label">
                            <h4>Data privacy notice</h4>
                            <p>Read our data privacy policy</p>
                        </div>
                        <div class="settings-item-action">
                            <a href="#">Read policy</a>
                        </div>
                    </div>
                </div>
            </section>

            <!-- My Groups Section -->
            <section id="groups" class="settings-section <?= ($active_section === 'groups') ? 'active' : '' ?>">
                <h1><span class="heading-white">My</span> <span class="heading-coral">groups</span></h1>
                <p class="section-description">View all groups you are assigned to by administrators</p>
                
                <div class="settings-group">
                    <div class="settings-group-header">
                        <h3 class="settings-group-title"><i class="fas fa-users"></i> Employer Groups</h3>
                    </div>
                    
                    <?php if (!empty($groups)): ?>
                        <!-- Search Bar -->
                        <div class="group-search-container">
                            <div class="search-input-wrapper">
                                <i class="fas fa-search search-icon"></i>
                                <input 
                                    type="text" 
                                    id="groupSearch" 
                                    class="group-search-input"
                                    placeholder="Search groups by name or description..."
                                    oninput="filterGroups()"
                                >
                                <button class="search-clear-btn" onclick="clearGroupSearch()" title="Clear search">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Empty State for Search Results -->
                        <div class="no-groups-search" id="noGroupsSearch">
                            <i class="fas fa-search"></i>
                            <h4>No groups found</h4>
                            <p>No groups match your search. Try searching with different keywords.</p>
                        </div>
                        
                        <div class="group-card-grid" id="groupCardGrid">
                            <?php foreach ($groups as $group): ?>
                                <div class="group-card" onclick="openGroupModal(<?= htmlspecialchars(json_encode($group), ENT_QUOTES, 'UTF-8') ?>)" data-group-id="<?= $group->id ?>">
                                    <div class="group-card__body">
                                        <div class="group-card__header">
                                            <div class="group-card__icon">
                                                <i class="fas fa-users"></i>
                                            </div>
                                            <div>
                                                <h4 class="group-card__title"><?= htmlspecialchars($group->group_name) ?></h4>
                                                <p class="group-card__meta">
                                                    <i class="fas fa-calendar-alt"></i>
                                                    <span>Created <?= date('M d, Y', strtotime($group->created_at)) ?></span>
                                                </p>
                                            </div>
                                        </div>
                                        <?php if (!empty($group->description)): ?>
                                            <p class="group-card__description"><?= htmlspecialchars($group->description) ?></p>
                                        <?php else: ?>
                                            <p class="group-card__description" style="color: var(--muted);">No description provided for this group.</p>
                                        <?php endif; ?>

                                        <div class="group-card__footer">
                                            <span class="group-card__badge group-card__badge--assigned">
                                                <i class="fas fa-check-circle"></i>
                                                Assigned
                                            </span>
                                            <span class="group-member-count group-card__badge group-card__badge--count" data-group-id="<?= $group->id ?>">
                                                <i class="fas fa-users"></i>
                                                <span class="member-text">-</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div style="padding: 40px; text-align: center; background: #f9fafb; border-radius: var(--border-radius); margin-top: 20px;">
                            <i class="fas fa-inbox" style="font-size: 48px; color: var(--border); margin-bottom: 12px;"></i>
                            <h4 style="color: var(--muted); margin-bottom: 8px;">No groups assigned</h4>
                            <p style="color: var(--muted); font-size: 14px; margin: 0;">You haven't been assigned to any groups yet. Administrators can assign you to groups to organize your account.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Group Details Modal -->
            <div class="modal fade" id="groupDetailsModal" tabindex="-1" role="dialog" aria-labelledby="groupDetailsLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content" style="border: none; border-radius: var(--border-radius); box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
                        <div class="modal-header" style="background: #a12124; border: none; padding: 15px 20px; border-radius: var(--border-radius) var(--border-radius) 0 0; display: flex; align-items: center;">
                            <h5 class="modal-title" id="groupDetailsLabel" style="color: white; font-weight: 700; font-size: 1.3rem; margin: 0;">
                                <i class="fas fa-users" style="margin-right: 10px;"></i>
                                <span id="modalGroupName"></span>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; margin-left: auto; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease;">
                                <span aria-hidden="true" style="font-size: 28px;">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="padding: 30px;">
                            <div style="margin-bottom: 25px;">
                                <h6 style="color: #a12124; font-weight: 700; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px; margin-bottom: 10px;">
                                    <i class="fas fa-book" style="margin-right: 6px;"></i>Description
                                </h6>
                                <p id="modalGroupDescription" style="color: #1F2937; line-height: 1.6; font-size: 14px; margin: 0; word-break: break-word; overflow-wrap: anywhere; hyphens: auto;">-</p>
                            </div>

                            <div style="display: flex; gap: 15px; margin-bottom: 25px;">
                                <div class="modal-info-box" style="background: #f9fafb; padding: 16px; border-radius: var(--border-radius);">
                                    <h6 style="color: #6B7280; font-weight: 600; text-transform: uppercase; font-size: 11px; margin-bottom: 8px;">
                                        <i class="fas fa-calendar-alt" style="margin-right: 6px; color: #a12124;"></i>Created Date
                                    </h6>
                                    <p id="modalGroupDate" style="color: #1F2937; font-weight: 600; margin: 0;">-</p>
                                </div>
                                <div class="modal-info-box" style="background: #f9fafb; padding: 16px; border-radius: var(--border-radius);">
                                    <h6 style="color: #6B7280; font-weight: 600; text-transform: uppercase; font-size: 11px; margin-bottom: 8px;">
                                        <i class="fas fa-users" style="margin-right: 6px; color: #a12124;"></i>Members
                                    </h6>
                                    <p id="modalGroupMembers" style="color: #1F2937; font-weight: 600; margin: 0;">-</p>
                                </div>
                            </div>

                            <!-- Group Members List -->
                            <div style="margin-bottom: 25px;">
                                <h6 style="color: #a12124; font-weight: 700; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px; margin-bottom: 12px;">
                                    <i class="fas fa-list" style="margin-right: 6px;"></i>Member Companies
                                </h6>
                                <div id="modalGroupMembersList" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 12px;">
                                    <div style="padding: 10px; background: #f9fafb; border-radius: var(--border-radius); color: #6B7280; text-align: center; font-size: 13px;">
                                        <i class="fas fa-spinner fa-spin" style="margin-right: 4px;"></i>Loading members...
                                    </div>
                                </div>
                            </div>

                            <div style="background: #fef2f2; padding: 16px; border-radius: var(--border-radius); border-left: 4px solid #a12124;">
                                <p style="color: #7d181b; font-size: 13px; margin: 0;">
                                    <i class="fas fa-info-circle" style="margin-right: 8px; color: #a12124;"></i>
                                    You are a member of this group and have access to all group-related resources and communications.
                                </p>
                            </div>
                        </div>
                        <div class="modal-footer" style="border-top: 1px solid #E5E7EB; padding: 20px 30px; display: none;"></div>
                    </div>
                </div>
            </div>

            <!-- Member Jobs Modal -->
            <div class="modal fade" id="memberJobsModal" tabindex="-1" role="dialog" aria-labelledby="memberJobsLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content" style="border: none; border-radius: var(--border-radius); box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
                        <div class="modal-header" style="background: #a12124; border: none; border-radius: var(--border-radius) var(--border-radius) 0 0; display: flex; align-items: center; padding: 20px 30px;">
                            <button type="button" class="back-to-group-btn" onclick="backToGroupDetails()" title="Back to Group Details" style="background: none; border: none; color: white; font-size: 14px; font-weight: 600; cursor: pointer; padding: 0; margin-right: 20px; display: flex; align-items: center; gap: 6px; transition: all 0.3s ease;" onmouseover="this.style.opacity='0.8'; this.style.transform='translateX(-3px)'" onmouseout="this.style.opacity='1'; this.style.transform='translateX(0)'"><i class="fas fa-chevron-left"></i> Back to Group</button>
                            <h5 class="modal-title" id="memberJobsLabel" style="color: white; font-weight: 700; font-size: 1.3rem; margin: 0; flex: 1;">
                                <i class="fas fa-briefcase" style="margin-right: 10px;"></i>
                                Jobs by <span id="memberJobsCompanyName"></span>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease; background: none; border: none; cursor: pointer; padding: 0; font-size: 28px;" onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body" style="padding: 30px;">
                            <div id="memberJobsList" style="display: flex; flex-direction: column; gap: 15px;">
                                <div style="padding: 20px; text-align: center; background: #f9fafb; border-radius: var(--border-radius);">
                                    <i class="fas fa-spinner fa-spin" style="margin-right: 6px;"></i>Loading jobs...
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="border-top: 1px solid #E5E7EB; padding: 20px 30px;">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background: #E5E7EB; border: none; color: #1F2937; font-weight: 600; border-radius: var(--border-radius); transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.background='#d0d5db'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.1)'" onmouseout="this.style.background='#E5E7EB'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>

    <script>
    // Live search and filter groups
    function filterGroups() {
        const searchTerm = document.getElementById('groupSearch').value.toLowerCase().trim();
        const cards = document.querySelectorAll('#groups .group-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const title = card.querySelector('.group-card__title').textContent.toLowerCase();
            const description = card.querySelector('.group-card__description').textContent.toLowerCase();

            if (title.includes(searchTerm) || description.includes(searchTerm)) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Show/hide empty state
        const noGroupsSearch = document.getElementById('noGroupsSearch');
        if (visibleCount === 0 && cards.length > 0) {
            noGroupsSearch.classList.add('active');
        } else {
            noGroupsSearch.classList.remove('active');
        }
    }

    // Clear group search
    function clearGroupSearch() {
        const searchInput = document.getElementById('groupSearch');
        searchInput.value = '';
        filterGroups();
        searchInput.focus();
    }

    // Initialize active section from sessionStorage or default
    document.addEventListener('DOMContentLoaded', function() {
        const savedSection = sessionStorage.getItem('activeProfileSection');
        const currentActiveSection = document.querySelector('.settings-section.active');
        
        if (savedSection && document.getElementById(savedSection)) {
            // If there's a saved section and it exists, make sure it's active
            if (currentActiveSection && currentActiveSection.id !== savedSection) {
                switchSection(new Event('click'), savedSection);
            }
        }

        // Load member counts for all group cards
        const baseUrl = '<?= base_url() ?>';
        document.querySelectorAll('.group-member-count').forEach(element => {
            const groupId = element.getAttribute('data-group-id');
            fetch(baseUrl + 'employer_profile/get_group_member_count?group_id=' + groupId)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const memberText = data.count + ' member' + (data.count !== 1 ? 's' : '');
                        element.querySelector('.member-text').textContent = memberText;
                    }
                })
                .catch(error => console.error('Error fetching member count:', error));
        });
    });

    function switchSection(e, sectionId) {
        e.preventDefault();

        // Store the active section in sessionStorage
        sessionStorage.setItem('activeProfileSection', sectionId);

        // Hide all sections
        const sections = document.querySelectorAll('.settings-section');
        sections.forEach(section => {
            section.classList.remove('active');
        });

        // Remove active class from all sidebar menu items
        const sidebarItems = document.querySelectorAll('.sidebar-menu-item');
        sidebarItems.forEach(item => {
            item.classList.remove('active');
        });

        // Remove active class from all nav items
        const navItems = document.querySelectorAll('.settings-nav-item');
        navItems.forEach(item => {
            item.classList.remove('active');
        });

        // Show selected section
        document.getElementById(sectionId).classList.add('active');

        // Mark sidebar menu item as active
        const activeSidebarItem = document.querySelector(`.sidebar-menu-item[onclick*="${sectionId}"]`);
        if (activeSidebarItem) {
            activeSidebarItem.classList.add('active');
        }

        // Mark nav item as active
        const activeNavItem = document.querySelector(`.settings-nav-item[onclick*="${sectionId}"]`);
        if (activeNavItem) {
            activeNavItem.classList.add('active');
        }
    }

    function showEmailModal(e) {
        e.preventDefault();
        const newEmail = prompt('Enter your new email:', '<?= htmlspecialchars($email ?? '') ?>');
        if (newEmail && newEmail.trim()) {
            // Create a form and submit it
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?= base_url('employer_profile/update_email') ?>';
            
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'email';
            input.value = newEmail;
            
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    }

    function showCompanyModal(e) {
        e.preventDefault();
        alert('Company name update feature coming soon!');
    }

    function openGroupModal(group) {
        // Populate modal with group data
        document.getElementById('modalGroupName').textContent = group.group_name || 'Group Details';
        document.getElementById('modalGroupDescription').textContent = group.description || 'No description provided';
        
        // Format the date
        const groupDate = new Date(group.created_at);
        const formattedDate = groupDate.toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        });
        document.getElementById('modalGroupDate').textContent = formattedDate;
        
        // Fetch member count
        const baseUrl = '<?= base_url() ?>';
        fetch(baseUrl + 'employer_profile/get_group_member_count?group_id=' + group.id)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('modalGroupMembers').textContent = data.count + ' member' + (data.count !== 1 ? 's' : '');
                } else {
                    document.getElementById('modalGroupMembers').textContent = 'N/A';
                }
            })
            .catch(error => {
                console.error('Error fetching member count:', error);
                document.getElementById('modalGroupMembers').textContent = 'N/A';
            });

        // Fetch group members details
        fetch(baseUrl + 'employer_profile/get_group_members?group_id=' + group.id)
            .then(response => response.json())
            .then(data => {
                const membersList = document.getElementById('modalGroupMembersList');
                
                if (data.success && data.members && data.members.length > 0) {
                    membersList.innerHTML = '';
                    data.members.forEach(member => {
                        const memberCard = document.createElement('div');
                        memberCard.classList.add('member-company-card');
                        memberCard.style.cssText = 'padding: 12px; background: #f9fafb; border-radius: 8px; text-align: center; border: 1px solid #e5e7eb; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer;';
                        memberCard.setAttribute('data-employer-id', member.id);
                        memberCard.innerHTML = `
                            <div style="color: #1F2937; font-weight: 600; font-size: 13px; line-height: 1.4;">
                                <i class="fas fa-building" style="color: #a12124; margin-bottom: 6px; display: block; font-size: 16px;"></i>
                                <span class="member-company-name">${member.company_name || 'N/A'}</span>
                            </div>
                        `;
                        memberCard.onmouseover = function() {
                            this.style.background = '#f0f4f8';
                            this.style.borderColor = '#a12124';
                            this.style.transform = 'scale(1.05)';
                            this.style.boxShadow = '0 4px 12px rgba(0,0,0,0.1)';
                        };
                        memberCard.onmouseout = function() {
                            this.style.background = '#f9fafb';
                            this.style.borderColor = '#e5e7eb';
                            this.style.transform = 'scale(1)';
                            this.style.boxShadow = 'none';
                        };
                        memberCard.onclick = function() {
                            openMemberJobsModal(member.id, member.company_name);
                        };
                        membersList.appendChild(memberCard);
                    });
                } else {
                    membersList.innerHTML = '<div style="padding: 10px; background: #f9fafb; border-radius: 6px; color: #6B7280; text-align: center; font-size: 13px; grid-column: 1 / -1;">No members found</div>';
                }
            })
            .catch(error => {
                console.error('Error fetching members:', error);
                document.getElementById('modalGroupMembersList').innerHTML = '<div style="padding: 10px; background: #fef2f2; border-radius: 6px; color: #7F1D1D; text-align: center; font-size: 13px; grid-column: 1 / -1;"><i class="fas fa-exclamation-circle" style="margin-right: 4px;"></i>Error loading members</div>';
            });
        
        // Show the modal
        $('#groupDetailsModal').modal('show');
    }

    // Edit group function
    function editGroupModal() {
        const groupName = document.getElementById('modalGroupName').textContent;
        alert('Edit Group: ' + groupName + ' - Feature coming soon!');
    }

    // Message group function
    function messageGroupModal() {
        const groupName = document.getElementById('modalGroupName').textContent;
        alert('Message Group: ' + groupName + ' - Feature coming soon!');
    }

    // Format currency helper
    function formatCurrency(amount) {
        if (!amount || amount === 'N/A') return amount;
        const num = parseFloat(amount.toString().replace(/[^0-9.]/g, ''));
        if (isNaN(num)) return amount;
        return '₱' + num.toLocaleString('en-PH', { maximumFractionDigits: 0 }) + ' / month';
    }

    // Back to Group Details function
    function backToGroupDetails() {
        $('#memberJobsModal').modal('hide');
        setTimeout(() => { $('#groupDetailsModal').modal('show'); }, 300);
    }

    function openMemberJobsModal(employerId, companyName) {
        // Update modal header
        document.getElementById('memberJobsCompanyName').textContent = companyName;
        
        // Show loading state
        const baseUrl = '<?= base_url() ?>';
        const jobsList = document.getElementById('memberJobsList');
        jobsList.innerHTML = '<div style="padding: 20px; text-align: center; background: #f9fafb; border-radius: 8px;"><i class="fas fa-spinner fa-spin" style="margin-right: 6px;"></i>Loading jobs...</div>';
        
        // Fetch jobs for this employer
        fetch(baseUrl + 'employer_profile/get_employer_jobs?employer_id=' + employerId)
            .then(response => response.json())
                    .then(data => {
                if (data.success && data.jobs && data.jobs.length > 0) {
                    jobsList.innerHTML = '';
                    data.jobs.forEach(job => {
                        const jobCard = document.createElement('div');
                        jobCard.classList.add('job-card');
                        jobCard.innerHTML = `
                            <div class="job-card-header">
                                <div>
                                    <h5 class="job-card-title"><i class="fas fa-briefcase" style="color: #a12124; margin-right: 6px;"></i>${job.job_title || 'N/A'}</h5>
                                    <p class="job-card-category"><i class="fas fa-tag" style="margin-right: 4px;"></i>${job.job_category || 'N/A'}</p>
                                </div>
                            </div>
                            <div class="job-card-details">
                                <div class="job-detail-item"><i class="fas fa-money-bill" style="color:#a12124"></i><span class="job-detail-label">Salary:</span><span>${formatCurrency(job.salary_range || 'N/A')}</span></div>
                                <div class="job-detail-item"><i class="fas fa-map-pin" style="color:#a12124"></i><span class="job-detail-label">Location:</span><span>${job.location || 'N/A'}</span></div>
                                <div class="job-detail-item"><i class="fas fa-calendar" style="color:#a12124"></i><span class="job-detail-label">Posted:</span><span>${new Date(job.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' })}</span></div>
                            </div>
                            <div class="job-card-meta">${job.short_description ? job.short_description : ''}</div>
                        `;
                        jobCard.onmouseover = function() { this.classList.add('hover'); };
                        jobCard.onmouseout = function() { this.classList.remove('hover'); };
                        jobsList.appendChild(jobCard);
                    });
                } else {
                    jobsList.innerHTML = '<div style="padding: 30px; text-align: center; background: #f9fafb; border-radius: 8px;\"><i class="fas fa-inbox" style="font-size: 2rem; color: #d1d5db; margin-bottom: 10px; display: block;"></i><p style="color: #6B7280; margin: 0;">No jobs posted by this company yet</p></div>';
                }
            })
            .catch(error => {
                console.error('Error fetching jobs:', error);
                jobsList.innerHTML = '<div style="padding: 20px; background: #fef2f2; border-radius: 8px; color: #7F1D1D; text-align: center;"><i class="fas fa-exclamation-circle" style="margin-right: 6px;"></i>Unable to load jobs posted by this employer</div>';
            });
        
        // Ensure Group Details is hidden to prevent stacking
        $('#groupDetailsModal').modal('hide');

        // Show the Jobs modal after content is loaded
        setTimeout(() => { $('#memberJobsModal').modal('show'); }, 220);
    }

    </script>
</body>
</html>

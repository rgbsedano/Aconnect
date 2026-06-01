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
            --success: #059669;
            --error: #DC2626;
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 30px rgba(0,0,0,0.15);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { background: var(--bg); font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; color: var(--text); line-height: 1.6; }
        .container { max-width: 1100px; margin: 20px auto 40px; padding: 0 20px; animation: fadeInUp 0.6s ease-out; }

        /* Fade-in animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes slideInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes pulseGlow {
            0% { box-shadow: 0 0 0 0 rgba(161, 33, 36, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(161, 33, 36, 0); }
            100% { box-shadow: 0 0 0 0 rgba(161, 33, 36, 0); }
        }

        /* Success Popup Notification (Tiles/Toasts) */
        .popup-toast {
            position: fixed;
            top: 25px;
            right: 25px;
            padding: 16px 24px;
            border-radius: 12px;
            background: white;
            color: var(--text);
            box-shadow: var(--shadow-lg);
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 9999;
            transform: translateX(120%);
            transition: transform 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            border-left: 6px solid var(--success);
        }
        .popup-toast.show { transform: translateX(0); }
        .popup-toast i { color: var(--success); font-size: 20px; }

        /* Error Banner */
        .error-banner {
            background: #FEE2E2;
            color: var(--error);
            padding: 12px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid #FECACA;
        }

        .header-section {
            background: var(--card);
            padding: 32px;
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            margin-bottom: 32px;
        }

        .search-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr auto;
            gap: 16px;
            margin-bottom: 12px;
            align-items: center;
        }

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-summary {
            margin-top: 10px;
            font-size: 13px;
            color: var(--muted);
            line-height: 1.5;
        }

        .input-group i { position: absolute; left: 14px; color: var(--muted); font-size: 14px; }
        .input-group input {
            width: 100%;
            padding: 12px 14px 12px 44px;
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s;
            background: #f9f9f9;
        }
        .input-group input:focus {
            outline: none;
            border-color: var(--maroon);
            box-shadow: 0 0 0 3px rgba(139, 21, 56, 0.1);
            background: var(--card);
        }

        .btn-search {
            background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
            color: white;
            border: none;
            padding: 12px 32px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: var(--shadow-sm);
        }
        .btn-search:hover { transform: translateY(-2px); box-shadow: var(--shadow-lg); }

        .filters { display: flex; gap: 12px; flex-wrap: wrap; margin-top: 20px; justify-content: center; }
        .f-pill {
            padding: 8px 18px;
            border-radius: 24px;
            border: 1.5px solid var(--border);
            background: var(--card);
            font-size: 13px;
            font-weight: 600;
            color: var(--muted);
            cursor: pointer;
            transition: all 0.3s;
        }
        .f-pill.active { background: linear-gradient(135deg, var(--maroon), var(--maroon-dark)); color: white; border-color: var(--maroon); }
        .f-pill:hover:not(.active) { border-color: var(--maroon); color: var(--maroon); }

        .job-card {
            background: var(--card);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 18px;
            cursor: pointer;
            transition: all 0.3s;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
        }
        .job-card:hover {
            border-color: var(--gold);
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .logo-box {
            width: 60px; height: 60px;
            background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
            color: var(--gold);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 24px;
            flex-shrink: 0;
        }

        .job-info { flex: 1; }
        .job-info h3 { margin: 0 0 4px 0; font-size: 16px; color: var(--text); font-weight: 700; }
        .job-info p { margin: 4px 0; color: var(--muted); font-size: 13px; display: flex; align-items: center; gap: 6px; }

        .badge-ai { text-align: right; flex-shrink: 0; }
        .percent {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 13px;
            background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .percent:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(161, 33, 36, 0.3);
        }

        .percent:active {
            transform: scale(0.98);
        }

        /* Modal: space for header, fixed in viewport, only inner content scrolls */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: flex-start;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
            padding: 72px 1rem 1rem 1rem;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }
        .modal-overlay.open { opacity: 1; visibility: visible; }

        .modal-box {
            background: var(--card);
            width: 90%;
            max-width: 580px;
            max-height: calc(100vh - 72px - 2rem);
            border-radius: 16px;
            padding: 0;
            position: relative;
            transform: scale(0.95) translateY(20px);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            margin: 0 auto;
        }
        .modal-overlay.open .modal-box { transform: scale(1) translateY(0); }

        .modal-header-custom {
            background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
            color: white;
            padding: 24px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-shrink: 0;
        }

        .modal-header-custom h2 { margin: 0 0 4px 0; font-size: 20px; }
        .modal-header-custom p { margin: 0; font-size: 13px; color: var(--gold); font-weight: 600; }

        .modal-box .modal-content {
            overflow-y: auto;
            flex: 1 1 auto;
            min-height: 0;
            -webkit-overflow-scrolling: touch;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: white;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content { padding: 24px; }
        .modal-content hr { border: none; border-top: 1px solid var(--border); margin: 16px 0; }
        .modal-content strong { color: var(--text); }
        .modal-content p { margin: 12px 0; font-size: 14px; color: var(--muted); }

        .job-details { max-height: 250px; overflow-y: auto; padding-right: 12px; }

        .modal-form {
            background: #f9f9f9;
            padding: 16px;
            border-radius: 10px;
            margin-top: 16px;
        }

        .file-input-wrapper {
            display: block;
            border: 2px dashed var(--border);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin-bottom: 16px;
            transition: all 0.3s;
            cursor: pointer;
        }
        .file-input-wrapper input[type="file"] { display: none; }
        .file-input-wrapper:hover { border-color: var(--maroon); background: rgba(161, 33, 36, 0.02); }

        .btn-submit {
            background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
            color: white;
            border: none;
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: var(--shadow-lg); }

        /* Two-Column Layout (Indeed-style) */
        .job-listing-container {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 24px;
            min-height: calc(100vh - 400px);
        }

        .job-list-panel {
            background: var(--card);
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            padding: 0;
            animation: slideInLeft 0.5s ease-out;
            scroll-behavior: smooth;
            max-height: calc(100vh - 220px); /* Use more available screen height for the job list */
            min-height: 560px;
            /* Custom scrollbar */
            scrollbar-width: thin;
            scrollbar-color: var(--maroon) #f0f0f0;
        }

        .job-list-panel.active {
            max-height: calc(100vh - 220px);
        }

        .job-list-panel::-webkit-scrollbar {
            width: 8px;
        }

        .job-list-panel::-webkit-scrollbar-track {
            background: #f0f0f0;
            border-radius: 10px;
        }

        .job-list-panel::-webkit-scrollbar-thumb {
            background: var(--maroon);
            border-radius: 10px;
            transition: background 0.3s;
        }

        .job-list-panel::-webkit-scrollbar-thumb:hover {
            background: var(--maroon-dark);
        }

        .job-list-panel .job-card {
            margin: 0;
            border: none;
            border-radius: 0;
            border-bottom: 1px solid var(--border);
            padding: 16px;
            cursor: pointer;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            align-items: stretch;
            opacity: 0.95;
            animation: fadeInUp 0.4s ease-out forwards;
        }

        .job-list-panel .job-card:nth-child(1) { animation-delay: 0.05s; }
        .job-list-panel .job-card:nth-child(2) { animation-delay: 0.1s; }
        .job-list-panel .job-card:nth-child(3) { animation-delay: 0.15s; }
        .job-list-panel .job-card:nth-child(n+4) { animation-delay: 0.2s; }

        /* Disable entry animation after the first load in the current browser session. */
        .session-card-animated .job-list-panel .job-card {
            animation: none;
            opacity: 1;
        }

        .job-list-panel .job-card:last-child { border-bottom: none; }
        .job-list-panel .job-card:hover {
            background: linear-gradient(135deg, rgba(161, 33, 36, 0.08), rgba(212, 165, 116, 0.06));
            border-left: 4px solid var(--maroon);
            padding-left: 12px;
            transform: translateX(2px);
            box-shadow: var(--shadow-sm);
            opacity: 1;
        }
        .job-list-panel .job-card.active {
            background: linear-gradient(135deg, rgba(161, 33, 36, 0.1), rgba(212, 165, 116, 0.08));
            border-left: 4px solid var(--maroon);
            padding-left: 12px;
            box-shadow: inset 0 0 0 1px var(--maroon);
            opacity: 1;
        }

        .job-list-panel .job-card .badge-ai {
            text-align: left;
            margin-top: 12px;
        }

        .job-detail-panel {
            background: var(--card);
            border-radius: 12px;
            box-shadow: var(--shadow-md);
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            padding: 32px;
            display: flex;
            flex-direction: column;
            animation: slideInRight 0.5s ease-out;
            scroll-behavior: smooth;
            position: relative;
            max-height: calc(100vh - 220px);
            min-height: 560px;
            /* Custom scrollbar */
            scrollbar-width: thin;
            scrollbar-color: var(--maroon) #f0f0f0;
            transition: box-shadow 0.3s ease;
        }

        .job-detail-panel.active {
            box-shadow: var(--shadow-md), inset 0 10px 15px rgba(0,0,0,0.03);
        }

        .job-detail-panel.scrolling-down {
            box-shadow: var(--shadow-md), inset 0 -5px 15px rgba(161, 33, 36, 0.08);
        }

        .job-detail-panel::-webkit-scrollbar {
            width: 10px;
        }

        .job-detail-panel::-webkit-scrollbar-track {
            background: #f0f0f0;
            border-radius: 10px;
            transition: background 0.3s;
        }

        .job-detail-panel.active::-webkit-scrollbar-track {
            background: #efefef;
        }

        .job-detail-panel::-webkit-scrollbar-thumb {
            background: var(--maroon);
            border-radius: 10px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .job-detail-panel::-webkit-scrollbar-thumb:hover {
            background: var(--maroon-dark);
            width: 12px;
        }

        .job-detail-panel.scrolling-down::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, var(--maroon), var(--maroon-dark));
        }

        .detail-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 24px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--border);
            animation: slideInDown 0.5s ease-out;
        }

        .detail-title h2 { margin: 0 0 8px 0; font-size: 24px; color: var(--text); }
        .detail-title p { margin: 0; color: var(--muted); font-size: 14px; }

        .detail-content {
            flex: 1;
            padding-right: 12px;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }

        .detail-content::-webkit-scrollbar-track {
            background: transparent;
        }

        .detail-content::-webkit-scrollbar-thumb {
            background: var(--gold);
            border-radius: 3px;
        }

        .detail-section {
            margin-bottom: 28px;
            animation: fadeInUp 0.5s ease-out forwards;
            opacity: 0;
        }

        .detail-section:nth-child(1) { animation-delay: 0.1s; }
        .detail-section:nth-child(2) { animation-delay: 0.2s; }
        .detail-section:nth-child(3) { animation-delay: 0.3s; }
        .detail-section:nth-child(4) { animation-delay: 0.4s; }
        .detail-section:nth-child(n+5) { animation-delay: 0.5s; }

        .detail-section h3 {
            font-size: 16px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .detail-section h3 i {
            transition: all 0.3s ease;
        }

        .detail-section h3:hover i {
            transform: scale(1.15);
            color: var(--maroon);
        }

        .detail-section p {
            margin: 8px 0;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.7;
        }

        .detail-section ul {
            margin: 12px 0;
            padding-left: 20px;
            list-style: disc;
        }

        .detail-section ul li {
            color: var(--muted);
            font-size: 14px;
            margin-bottom: 8px;
            line-height: 1.6;
        }

        .detail-footer {
            display: flex;
            gap: 12px;
            margin-top: 28px;
            padding-top: 20px;
            border-top: 2px solid var(--border);
            justify-content: flex-end;
            align-items: center;
        }

        .btn-apply {
            background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
            color: white;
            border: none;
            padding: 14px 24px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            min-height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-apply:before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-apply:hover:before {
            width: 300px;
            height: 300px;
        }

        .btn-apply:hover { 
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(161, 33, 36, 0.3); 
        }

        .btn-apply.applied {
            background: linear-gradient(135deg, #10B981, #059669);
            cursor: not-allowed;
            box-shadow: inset 0 0 0 2px rgba(255, 255, 255, 0.3);
        }

        .btn-apply.applied:hover { 
            transform: none;
            box-shadow: inset 0 0 0 2px rgba(255, 255, 255, 0.3);
        }

        .job-apply-form {
            margin: 0;
            padding: 0;
            display: flex;
        }

        .btn-save-wrapper {
            position: relative;
            display: inline-flex;
            align-items: center;
        }

        .btn-save {
            background: var(--card);
            color: var(--maroon);
            border: 2px solid var(--maroon);
            width: 48px;
            height: 48px;
            border-radius: 50%;
            font-weight: 700;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            min-width: 48px;
        }

        .btn-save:hover { 
            background: rgba(161, 33, 36, 0.08);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(161, 33, 36, 0.15);
        }

        .btn-save.saved {
            background: var(--maroon);
            border-color: var(--maroon);
            color: white;
            animation: pulseGlow 1.2s ease-out;
        }

        .btn-save.applied {
            background: #10B981;
            border-color: #10B981;
            color: white;
            animation: pulseGlow 1.2s ease-out;
        }

        .btn-save-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 8px;
            background: var(--card);
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.12);
            padding: 8px 0;
            opacity: 0;
            visibility: hidden;
            transform: scale(0.95) translateY(-4px);
            transform-origin: top right;
            transition: opacity 0.25s cubic-bezier(0.4, 0, 0.2, 1), transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.25s;
            z-index: 9999;
            min-width: 180px;
            pointer-events: none;
        }

        .btn-save-wrapper.open .btn-save-dropdown {
            opacity: 1;
            visibility: visible;
            transform: scale(1) translateY(0);
            pointer-events: auto;
        }

        .btn-save-dropdown-item {
            width: 100%;
            background: transparent;
            border: none;
            color: var(--text);
            text-align: left;
            padding: 10px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.15s ease, color 0.15s ease;
            white-space: nowrap;
        }

        .btn-save-dropdown-item:hover {
            background: rgba(161, 33, 36, 0.08);
            color: var(--maroon);
        }

        .btn-save-dropdown-item:active {
            background: rgba(161, 33, 36, 0.12);
        }

        /* Placeholder state when no job selected */
        .detail-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 400px;
            color: var(--muted);
            text-align: center;
        }

        .detail-placeholder i { font-size: 48px; margin-bottom: 16px; opacity: 0.5; }
        .detail-placeholder p { font-size: 16px; }

        /* Mobile Tabs */
        .mobile-tabs {
            display: none;
            gap: 12px;
            margin-bottom: 16px;
            background: var(--card);
            padding: 12px;
            border-radius: 10px;
        }

        @media (max-width: 1000px) {
            .job-listing-container {
                grid-template-columns: 1fr;
                gap: 16px;
                min-height: auto;
            }

            .mobile-tabs { display: flex; }

            .job-list-panel,
            .job-detail-panel {
                display: none;
            }

            .job-list-panel.active,
            .job-detail-panel.active {
                display: block;
            }

            .job-detail-panel {
                padding: 20px;
            }

            .detail-header {
                margin-bottom: 16px;
                padding-bottom: 16px;
            }

            .detail-title h2 { font-size: 20px; }
        }

        .info-cards-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 24px;
        }

        .info-card {
            background: #f9f9f9;
            padding: 16px;
            border-radius: 10px;
            border-left: 4px solid var(--maroon);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            animation: fadeInUp 0.5s ease-out forwards;
            opacity: 0;
        }

        .info-cards-grid .info-card:nth-child(1) { animation-delay: 0.15s; }
        .info-cards-grid .info-card:nth-child(2) { animation-delay: 0.2s; }
        .info-cards-grid .info-card:nth-child(3) { animation-delay: 0.25s; }
        .info-cards-grid .info-card:nth-child(4) { animation-delay: 0.3s; }

        .info-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
            background: linear-gradient(135deg, #f9f9f9, #ffffff);
        }

        .info-card-label {
            margin: 0 0 8px 0;
            font-size: 12px;
            color: var(--muted);
            font-weight: 600;
            text-transform: uppercase;
        }

        .info-card-value {
            margin: 0;
            font-size: 15px;
            font-weight: 700;
            color: var(--text);
        }

        @media (max-width: 576px) {
            .search-grid { grid-template-columns: 1fr; }
            .container { padding: 0 12px; margin: 12px auto 30px; }
            .header-section { padding: 16px; }
            .detail-header { flex-direction: column; }
            .btn-apply { font-size: 14px; padding: 12px 18px; }
            .detail-footer { flex-direction: column; }
            .f-pill { padding: 6px 14px; font-size: 12px; }
            .info-cards-grid { grid-template-columns: 1fr; }
        }
    </style>

<?php
?>

<script src="https://cdn.tailwindcss.com"></script>

<script>
    (function() {
        try {
            if (sessionStorage.getItem('jobsCardsAnimated') === '1') {
                document.documentElement.classList.add('session-card-animated');
            }
        } catch (e) {
            // Ignore storage errors and keep default animation behavior.
        }
    })();
</script>




<div id="success-popup" class="popup-toast">
    <i class="fas fa-check-circle"></i>
    <div>
        <p style="font-weight: 700;">Success!</p>
        <p style="font-size: 13px; color: var(--muted);">Uploaded successfully</p>
    </div>
</div>

<div class="container">
    <?php if ($this->session->flashdata('error')): ?>
        <div class="error-banner">
            <i class="fas fa-times-circle"></i>
            <?= $this->session->flashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Match Explanation Modal -->
    <div id="match-modal-overlay" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-header-custom">
                <div>
                    <h2>Match Breakdown</h2>
                    <p id="modal-job-title">Job Title</p>
                </div>
                <button class="close-modal" onclick="closeMatchModal()">&times;</button>
            </div>
            <div class="modal-content">
                <div id="modal-match-content"></div>
            </div>
        </div>
    </div>

    <div class="header-section">
        <form method="get" action="<?= base_url('jobs') ?>">
            <div class="search-grid">
                <div class="input-group">
                    <i class="fas fa-search"></i>
                    <input id="job-search-input" type="text" name="search" placeholder="Search job title, company, or location" value="<?= $this->input->get('search') ?>">
                </div>
                <div class="input-group">
                    <i class="fas fa-map-marker-alt"></i>
                    <input id="job-location-input" type="text" name="location" placeholder="City or Remote" value="<?= $this->input->get('location') ?>">
                </div>
                <button type="button" class="btn-search" onclick="performSearchNow()"><i class="fas fa-search"></i> Search</button>
            </div>
            <div class="search-summary" id="search-summary">Search by job title, company, or location. Type 3+ letters to filter live.</div>
        </form>

        <div class="filters">
            <button class="f-pill active" id="btn-all" onclick="updateFilter('all', null)">All Opportunities</button>
            <button class="f-pill" id="btn-70" onclick="updateFilter(70, 100)"><i class="fas fa-star"></i> Best Matches (70%+)</button>
            <button class="f-pill" id="btn-40" onclick="updateFilter(40, 69)"><i class="fas fa-check"></i> Good Fits (40%+)</button>
            <button class="f-pill" id="btn-archived" type="button" onclick="window.location.href='<?= base_url('jobs/archived') ?>'">
                <i class="fas fa-box-archive"></i> Archived
            </button>
        </div>
    </div>

    <!-- Mobile Tabs (Visible only on screens < 1000px) -->
    <div class="mobile-tabs">
        <button class="f-pill active" id="btn-listings" onclick="updateJobsTab('listings')"><i class="fas fa-list"></i> Listings</button>
        <button class="f-pill" id="btn-details" onclick="updateJobsTab('details')"><i class="fas fa-briefcase"></i> Details</button>
    </div>

    <!-- Two-Column Layout -->
    <div class="job-listing-container">
        <!-- Left Column: Job Listings -->
        <div class="job-list-panel active" id="job-list-panel">
            <?php if (!empty($jobs)): ?>
                <?php foreach ($jobs as $job): 
                    $match = compute_ai_match($alumni, $job);
                ?>
                <div class="job-card" data-score="<?= $match ?>" data-job-id="<?= $job->id ?>" onclick="selectJob(<?= $job->id ?>)">
                    <div style="display: flex; gap: 12px; align-items: flex-start;">
                        <div class="logo-box" style="width: 48px; height: 48px; font-size: 20px;"><i class="fas fa-briefcase"></i></div>
                        <div class="job-info" style="flex: 1; margin: 0;">
                            <h3 style="font-size: 15px; margin: 0 0 4px 0;"><?= htmlspecialchars($job->job_title) ?></h3>
                            <p style="margin: 2px 0; font-size: 12px;"><i class="fas fa-building"></i> <?= htmlspecialchars($job->company) ?></p>
                            <p style="margin: 2px 0; font-size: 12px;"><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($job->location) ?></p>
                        </div>
                    </div>
                    <div class="badge-ai">
                        <div class="percent" style="font-size: 12px; padding: 6px 10px;">
                            <i class="fas fa-robot"></i> <?= $match ?>%
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="text-align: center; padding: 32px 16px; color: var(--muted);">
                    <i class="fas fa-inbox" style="font-size: 32px; margin-bottom: 12px; opacity: 0.5; display: block;"></i>
                    <p style="margin: 0;">No Jobs Found</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Right Column: Job Details -->
        <div class="job-detail-panel active" id="job-detail-panel">
            <?php if (!empty($jobs)): 
                $first_job = $jobs[0];
                $first_match = compute_ai_match($alumni, $first_job);
            ?>
            <div class="detail-header">
                <div class="detail-title">
                    <h2><?= htmlspecialchars($first_job->job_title) ?></h2>
                    <p><?= htmlspecialchars($first_job->company) ?></p>
                </div>
                <div class="percent" style="cursor: pointer;" onclick="showMatchExplanation(<?= $first_job->id ?>, <?= $first_match ?>)">
                    <i class="fas fa-robot"></i> <?= $first_match ?>% Match
                </div>
            </div>

            <div class="detail-content">
                <!-- Quick Info Cards -->
                <div class="info-cards-grid">
                    <div class="info-card">
                        <p class="info-card-label">Pay</p>
                        <p class="info-card-value"><?= htmlspecialchars($first_job->salary_range) ?></p>
                    </div>
                    <div class="info-card" style="border-left-color: var(--gold);">
                        <p class="info-card-label">Job Type</p>
                        <p class="info-card-value">Full-time</p>
                    </div>
                    <div class="info-card" style="border-left-color: var(--success);">
                        <p class="info-card-label"><i class="fas fa-map-marker-alt"></i> Location</p>
                        <p class="info-card-value"><?= htmlspecialchars($first_job->location) ?></p>
                    </div>
                    <div class="info-card" style="border-left-color: #3498db;">
                        <p class="info-card-label">Work Location</p>
                        <p class="info-card-value">In person</p>
                    </div>
                </div>

                <!-- Full Description -->
                <div class="detail-section">
                    <h3><i class="fas fa-briefcase"></i> About the Role</h3>
                    <p><?= nl2br(htmlspecialchars($first_job->description)) ?></p>
                </div>

                <!-- Qualifications -->
                <div class="detail-section">
                    <h3><i class="fas fa-list-check"></i> Qualifications</h3>
                    <p><?= nl2br(htmlspecialchars($first_job->qualifications)) ?></p>
                </div>

                <!-- Education -->
                <div class="detail-section">
                    <h3><i class="fas fa-graduation-cap"></i> Education Required</h3>
                    <p>Bachelor's Degree (or equivalent work experience)</p>
                </div>

                <!-- Experience -->
                <div class="detail-section">
                    <h3><i class="fas fa-briefcase"></i> Experience</h3>
                    <p>Minimum 6 months relevant work experience</p>
                </div>
            </div>

            <div class="detail-footer">
                <form method="post" action="<?= base_url('jobs/apply/' . $first_job->id) ?>" class="job-apply-form">
                    <button type="submit" class="btn-apply <?= in_array($first_job->id, $applied_jobs ?? []) ? 'applied' : '' ?>" <?= in_array($first_job->id, $applied_jobs ?? []) ? 'disabled' : '' ?>>
                        <?= in_array($first_job->id, $applied_jobs ?? []) ? 'Applied' : 'Apply' ?>
                    </button>
                </form>
                <div class="btn-save-wrapper">
                    <button class="btn-save <?= in_array($first_job->id, $applied_jobs ?? []) ? 'applied' : 'saved' ?>" type="button" data-job-id="<?= $first_job->id ?>" onclick="toggleSaveDropdown(event, <?= $first_job->id ?>)" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bookmark"></i>
                    </button>
                    <div class="btn-save-dropdown" id="save-dropdown-<?= $first_job->id ?>">
                        <button type="button" class="btn-save-dropdown-item" onclick="saveJob(event, <?= $first_job->id ?>, 'saved')">
                            <i class="fas fa-bookmark"></i> Saved
                        </button>
                        <button type="button" class="btn-save-dropdown-item" onclick="saveJob(event, <?= $first_job->id ?>, 'applied')">
                            <i class="fas fa-check"></i> Applied
                        </button>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="detail-placeholder">
                <i class="fas fa-briefcase"></i>
                <p>Select a job to view details</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // ===== TWO-COLUMN LAYOUT STATE =====
    let selectedJobId = null;
    let allJobs = <?= !empty($jobs) ? json_encode($jobs) : '[]' ?>;
    let appliedJobs = <?= json_encode(!empty($applied_jobs) ? $applied_jobs : []) ?>;
    let jobMatches = {};
    const selectedJobStorageKey = 'jobsSelectedJobId';

    // Initialize job matches
    <?php if (!empty($jobs)): ?>
        <?php foreach ($jobs as $job): 
            $match = compute_ai_match($alumni, $job);
        ?>
            jobMatches[<?= $job->id ?>] = <?= $match ?>;
        <?php endforeach; ?>
    <?php endif; ?>

    // ===== LIVE SEARCH JOBS =====
    function setupJobSearch() {
        const searchInput = document.getElementById('job-search-input');
        const locationInput = document.getElementById('job-location-input');
        const searchSummary = document.getElementById('search-summary');

        function performSearch() {
            const searchTerm = (searchInput?.value || '').toLowerCase().trim();
            const locationTerm = (locationInput?.value || '').toLowerCase().trim();
            const hasSearch = searchTerm.length >= 3;
            const hasLocation = locationTerm.length >= 3;

            document.querySelectorAll('.job-list-panel .job-card').forEach(card => {
                const jobTitle = card.querySelector('h3')?.textContent.toLowerCase() || '';
                const companyText = card.querySelector('.job-info p:first-of-type')?.textContent.toLowerCase() || '';
                const locationText = card.querySelector('.job-info p:last-of-type')?.textContent.toLowerCase() || '';

                const matchesSearch = !hasSearch || jobTitle.includes(searchTerm) || companyText.includes(searchTerm);
                const matchesLocation = !hasLocation || locationText.includes(locationTerm);

                card.style.display = (matchesSearch && matchesLocation) ? 'block' : 'none';
            });

            const totalJobs = document.querySelectorAll('.job-list-panel .job-card').length;
            const visibleJobs = document.querySelectorAll('.job-list-panel .job-card:not([style*="display: none"])').length;

            if (hasSearch || hasLocation) {
                searchSummary.textContent = visibleJobs > 0
                    ? `Showing ${visibleJobs} of ${totalJobs} jobs`
                    : 'No matching jobs found. Try a broader search term.';
            } else {
                searchSummary.textContent = 'Search by job title, company, or location. Type 3+ letters to filter live.';
                if (!searchTerm && !locationTerm) {
                    document.querySelectorAll('.job-list-panel .job-card').forEach(card => {
                        card.style.display = 'block';
                    });
                }
            }
        }

        if (searchInput) {
            searchInput.addEventListener('input', performSearch);
        }
        if (locationInput) {
            locationInput.addEventListener('input', performSearch);
        }

        window.performSearchNow = performSearch;
    }

    // ===== SMOOTH SCROLL ANIMATION =====
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Element is now visible
                if (!entry.target.classList.contains('animated')) {
                    entry.target.classList.add('animated');
                }
            }
        });
    }, observerOptions);

    // Observe all job cards and detail sections
    document.addEventListener('DOMContentLoaded', () => {
        try {
            sessionStorage.setItem('jobsCardsAnimated', '1');
        } catch (e) {
            // Ignore storage errors and keep default animation behavior.
        }

        document.querySelectorAll('.detail-section, .info-card, .job-list-panel .job-card').forEach(el => {
            observer.observe(el);
        });
    });

    // ===== SELECT A JOB AND SHOW IN DETAIL PANEL =====
    function selectJob(jobId) {
        selectedJobId = jobId;

        try {
            sessionStorage.setItem(selectedJobStorageKey, String(jobId));
        } catch (e) {
            // Ignore storage errors and keep in-memory selection.
        }
        
        // Find the job data
        const job = allJobs.find(j => j.id == jobId);
        if (!job) return;

        const match = jobMatches[jobId];
        
        // Update list: mark clicked job as active
        document.querySelectorAll('.job-list-panel .job-card').forEach(card => {
            card.classList.toggle('active', card.dataset.jobId == jobId);
        });

        // Smooth scroll to selected job
        const activeCard = document.querySelector(`[data-job-id="${jobId}"]`);
        if (activeCard && window.innerWidth <= 1000) {
            // Mobile: scroll the job list
            activeCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        // Update detail panel
        const detailPanel = document.getElementById('job-detail-panel');
        
        // Extract job details (handle different field names)
        const jobType = job.job_type || 'Full-time';
        const salary = escapeHtml(job.salary_range);
        const location = escapeHtml(job.location);
        const company = escapeHtml(job.company);
        const title = escapeHtml(job.job_title);
        const description = escapeHtml(job.description || '').replace(/\n/g, '<br>');
        const qualifications = escapeHtml(job.qualifications || '').replace(/\n/g, '<br>');
        const benefits = escapeHtml(job.benefits || '').replace(/\n/g, '<li>');
        const requirements = escapeHtml(job.requirements || '').replace(/\n/g, '<br>');
        const isSaved = isJobSaved(job.id);
        
        detailPanel.style.opacity = '0';
        detailPanel.style.transform = 'translateX(10px)';
        
        setTimeout(() => {
            detailPanel.innerHTML = `
                <div class="scroll-indicator" id="scroll-indicator"></div>
                <div class="detail-header">
                    <div class="detail-title">
                        <h2>${title}</h2>
                        <p>${company}</p>
                    </div>
                    <div class="percent" onclick="showMatchExplanation(${job.id}, ${match})">
                        <i class="fas fa-robot"></i> ${match}% Match
                    </div>
                </div>

                <div class="detail-content">
                    <!-- Quick Info Cards -->
                    <div class="info-cards-grid">
                        <div class="info-card">
                            <p class="info-card-label">Pay</p>
                            <p class="info-card-value">${salary}</p>
                        </div>
                        <div class="info-card" style="border-left-color: var(--gold);">
                            <p class="info-card-label">Job Type</p>
                            <p class="info-card-value">${jobType}</p>
                        </div>
                        <div class="info-card" style="border-left-color: var(--success);">
                            <p class="info-card-label"><i class="fas fa-map-marker-alt"></i> Location</p>
                            <p class="info-card-value">${location}</p>
                        </div>
                        <div class="info-card" style="border-left-color: #3498db;">
                            <p class="info-card-label">Work Location</p>
                            <p class="info-card-value">In person</p>
                        </div>
                    </div>

                    <!-- Full Description -->
                    <div class="detail-section">
                        <h3><i class="fas fa-briefcase"></i> About the Role</h3>
                        <p>${description}</p>
                    </div>

                    <!-- Qualifications -->
                    <div class="detail-section">
                        <h3><i class="fas fa-list-check"></i> Qualifications</h3>
                        <p>${qualifications}</p>
                    </div>

                    <!-- Education -->
                    <div class="detail-section">
                        <h3><i class="fas fa-graduation-cap"></i> Education Required</h3>
                        <p>Bachelor's Degree (or equivalent work experience)</p>
                    </div>

                    <!-- Experience -->
                    <div class="detail-section">
                        <h3><i class="fas fa-briefcase"></i> Experience</h3>
                        <p>Minimum 6 months relevant work experience</p>
                    </div>
                </div>

                <div class="detail-footer">
                    <form method="post" action="${baseUrl}jobs/apply/${job.id}" class="job-apply-form">
                        <button type="submit" class="btn-apply ${getJobButtonState(job.id) === 'applied' ? 'applied' : ''}" ${getJobButtonState(job.id) === 'applied' ? 'disabled' : ''}>
                            ${getJobButtonState(job.id) === 'applied' ? 'Applied' : 'Apply'}
                        </button>
                    </form>
                    <div class="btn-save-wrapper">
                        <button class="btn-save ${getJobButtonState(job.id) === 'applied' ? 'applied' : (isSaved ? 'saved' : '')}" type="button" data-job-id="${job.id}" onclick="toggleSaveDropdown(event, ${job.id})" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bookmark"></i>
                        </button>
                        <div class="btn-save-dropdown" id="save-dropdown-${job.id}">
                            <button type="button" class="btn-save-dropdown-item" onclick="saveJob(event, ${job.id}, 'saved')">
                                <i class="fas fa-bookmark"></i> Saved
                            </button>
                            <button type="button" class="btn-save-dropdown-item" onclick="saveJob(event, ${job.id}, 'applied')">
                                <i class="fas fa-check"></i> Applied
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            detailPanel.style.opacity = '1';
            detailPanel.style.transform = 'translateX(0)';
            detailPanel.style.transition = 'all 0.35s cubic-bezier(0.4, 0, 0.2, 1)';
            
            // Smooth scroll to top of detail panel
            setTimeout(() => {
                detailPanel.scrollTop = 0;
                setupDetailPanelScroll(detailPanel);
            }, 100);
        }, 150);
        
        // On mobile, switch to details tab
        if (window.innerWidth <= 1000) {
            updateJobsTab('details');
        }
    }

    // ===== SETUP DETAIL PANEL SCROLL LISTENER =====
    function setupDetailPanelScroll(panel) {
        const scrollIndicator = document.getElementById('scroll-indicator');
        let scrollTimeout;
        if (!scrollIndicator) {
            return;
        }
        
        // Check if content is scrollable
        function checkScrollable() {
            const isScrollable = panel.scrollHeight > panel.clientHeight;
            if (isScrollable) {
                panel.classList.add('has-scroll');
            } else {
                panel.classList.remove('has-scroll');
            }
        }
        
        checkScrollable();
        window.addEventListener('resize', checkScrollable);
        
        // Track scroll position
        panel.addEventListener('scroll', () => {
            const isScrollingDown = panel.scrollTop > 0;
            
            if (isScrollingDown) {
                panel.classList.add('scrolling-down');
            } else {
                panel.classList.remove('scrolling-down');
            }
            
            // Clear previous timeout
            clearTimeout(scrollTimeout);
            scrollIndicator.style.opacity = '1';
            
            // Hide indicator after scroll stops
            scrollTimeout = setTimeout(() => {
                scrollIndicator.style.opacity = '0';
            }, 1500);
        });
        
        // Show indicator on hover
        panel.addEventListener('mouseenter', () => {
            checkScrollable();
        });
    }

    // ===== MOBILE TAB SWITCHING =====
    function updateJobsTab(tab) {
        const listPanel = document.getElementById('job-list-panel');
        const detailPanel = document.getElementById('job-detail-panel');
        const btnListings = document.getElementById('btn-listings');
        const btnDetails = document.getElementById('btn-details');

        // Update visibility with animation
        if (tab === 'listings') {
            listPanel.style.animation = 'slideInLeft 0.4s ease-out';
            detailPanel.style.animation = 'none';
            listPanel.classList.add('active');
            detailPanel.classList.remove('active');
            btnListings.classList.add('active');
            btnDetails.classList.remove('active');
        } else {
            detailPanel.style.animation = 'slideInRight 0.4s ease-out';
            listPanel.style.animation = 'none';
            listPanel.classList.remove('active');
            detailPanel.classList.add('active');
            btnListings.classList.remove('active');
            btnDetails.classList.add('active');
        }
    }

    // ===== SHOW MATCH EXPLANATION MODAL =====
    function showMatchExplanation(jobId, matchPercentage) {
        const job = allJobs.find(j => j.id == jobId);
        if (!job) return;

        // Show match percentage instantly (AI analysis powered by backend rate limiting for reliability)
        const overlay = document.getElementById('match-modal-overlay');
        document.getElementById('modal-job-title').textContent = job.job_title + ' at ' + job.company;
        document.getElementById('modal-match-content').innerHTML = `
            <div style="text-align: center; padding: 40px 20px;">
                <div style="font-size: 42px; color: var(--maroon); font-weight: 700; margin-bottom: 20px;">${matchPercentage}%</div>
                <p style="color: var(--muted); font-size: 14px;">Your compatibility score for this role</p>
            </div>
        `;
        overlay.classList.add('open');

        // Fetch AI explanation from backend
        fetch('<?= base_url() ?>jobs/get_match_explanation/' + jobId)
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    document.getElementById('modal-match-content').innerHTML = `
                        <div style="color: var(--error); padding: 20px; text-align: center;">
                            <p>Unable to load explanation. Please try again.</p>
                        </div>
                    `;
                    return;
                }

                const displayScore = (typeof data.percentage === 'number') ? data.percentage : matchPercentage;
                const strengths = Array.isArray(data.strengths) ? data.strengths : [];
                const gaps = Array.isArray(data.gaps) ? data.gaps : [];
                const actions = (data.narrative && Array.isArray(data.narrative.action_steps)) ? data.narrative.action_steps : [];

                // Prevent raw JSON fragments from showing in summary text.
                function isJsonLikeSummary(value) {
                    if (!value || typeof value !== 'string') return false;
                    const t = value.trim();
                    return t.startsWith('{') || t.startsWith('[') || t.includes('```') || t.includes('"strengths"') || t.includes("'strengths'");
                }

                let safeSummary = (typeof data.summary === 'string') ? data.summary : '';
                if (!safeSummary || isJsonLikeSummary(safeSummary)) {
                    safeSummary = displayScore >= 75
                        ? 'Your profile aligns strongly with the core role requirements.'
                        : (displayScore >= 60
                            ? 'Your profile has solid alignment with room to improve specific areas.'
                            : (displayScore >= 45
                                ? 'Your profile shows partial alignment and a potential transition path.'
                                : 'Your profile has limited overlap with this role at the moment.'));
                }

                // Build AI-powered explanation
                let explanation = `<div style="margin-bottom: 20px;">`;
                explanation += `<div style="font-size: 42px; color: var(--maroon); font-weight: 700; margin-bottom: 8px; text-align: center;">${displayScore}%</div>`;
                
                // Status badge
                const statusColor = displayScore >= 75 ? 'var(--success)' : (displayScore >= 60 ? 'var(--maroon)' : '#F59E0B');
                explanation += `<div style="display: flex; justify-content: center; gap: 8px; margin-bottom: 16px;">`;
                explanation += `<span style="background: ${statusColor}; color: white; padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: 600;">`;
                explanation += `${data.status || 'Match Analysis'}</span>`;
                explanation += `</div>`;
                
                explanation += `<p style="color: var(--muted); font-size: 13px; margin-bottom: 14px; text-align: center; font-style: italic;">${safeSummary}</p>`;

                // Narrative storyline
                if (data.narrative && (data.narrative.opening || data.narrative.fit_story)) {
                    explanation += `<div style="background: #fff7ed; padding: 14px; border-radius: 10px; border-left: 4px solid #FB923C; margin-bottom: 16px;">`;
                    if (data.narrative.opening) {
                        explanation += `<p style="margin: 0 0 8px 0; color: var(--text); font-size: 12px; line-height: 1.6;">${data.narrative.opening}</p>`;
                    }
                    if (data.narrative.fit_story) {
                        explanation += `<p style="margin: 0; color: var(--text); font-size: 12px; line-height: 1.6;">${data.narrative.fit_story}</p>`;
                    }
                    explanation += `</div>`;
                }
                
                // Display bulletted explanation if available
                if (data.explanation_bullets) {
                    explanation += `<div style="background: #f9f9f9; padding: 16px; border-radius: 10px; border-left: 4px solid var(--maroon); margin-bottom: 16px; white-space: pre-wrap; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">`;
                    explanation += `<p style="margin: 0; color: var(--text); font-size: 13px; line-height: 1.8;">${data.explanation_bullets.replace(/\n/g, '<br>')}</p>`;
                    explanation += `</div>`;
                }
                
                // Strengths section
                if (strengths.length > 0) {
                    explanation += `<div style="background: #f0f9ff; padding: 16px; border-radius: 10px; border-left: 4px solid var(--success); margin-bottom: 16px;">`;
                    explanation += `<h4 style="margin: 0 0 12px 0; color: var(--text); font-weight: 600; font-size: 13px;">✓ Why You're a Good Match:</h4>`;
                    explanation += `<ul style="margin: 0; padding-left: 20px; list-style: disc;">`;
                    strengths.forEach(strength => {
                        explanation += `<li style="margin-bottom: 8px; color: var(--text); font-size: 12px; line-height: 1.5;">${strength}</li>`;
                    });
                    explanation += `</ul>`;
                    explanation += `</div>`;
                }
                
                // Gaps section
                if (gaps.length > 0) {
                    explanation += `<div style="background: #fef3c7; padding: 16px; border-radius: 10px; border-left: 4px solid #F59E0B; margin-bottom: 16px;">`;
                    explanation += `<h4 style="margin: 0 0 12px 0; color: var(--text); font-weight: 600; font-size: 13px;">→ Areas to Develop:</h4>`;
                    explanation += `<ul style="margin: 0; padding-left: 20px; list-style: disc;">`;
                    gaps.forEach(gap => {
                        explanation += `<li style="margin-bottom: 8px; color: var(--text); font-size: 12px; line-height: 1.5;">${gap}</li>`;
                    });
                    explanation += `</ul>`;
                    explanation += `</div>`;
                }

                // Action steps section
                if (actions.length > 0) {
                    explanation += `<div style="background: #ecfdf5; padding: 16px; border-radius: 10px; border-left: 4px solid #10B981; margin-bottom: 16px;">`;
                    explanation += `<h4 style="margin: 0 0 12px 0; color: var(--text); font-weight: 600; font-size: 13px;">Next Best Steps</h4>`;
                    explanation += `<ul style="margin: 0; padding-left: 20px; list-style: disc;">`;
                    actions.forEach(step => {
                        explanation += `<li style="margin-bottom: 8px; color: var(--text); font-size: 12px; line-height: 1.5;">${step}</li>`;
                    });
                    explanation += `</ul>`;
                    explanation += `</div>`;
                }
                
                // AI badge
                if (data.ai_powered) {
                    explanation += `<div style="text-align: center; margin-top: 16px;">`;
                    explanation += `<span style="font-size: 11px; color: var(--maroon); font-weight: 600;">`;
                    explanation += `<i class="fas fa-robot"></i> Powered by AI Analysis</span>`;
                    explanation += `</div>`;
                }
                
                explanation += `</div>`;
                
                document.getElementById('modal-match-content').innerHTML = explanation;
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('modal-match-content').innerHTML = `
                    <div style="color: var(--error); padding: 20px; text-align: center;">
                        <p>Unable to load AI analysis.</p>
                    </div>
                `;
            });
    }

    function closeMatchModal() {
        document.getElementById('match-modal-overlay').classList.remove('open');
    }

    // Close modal when clicking overlay background
    document.addEventListener('DOMContentLoaded', () => {
        const overlay = document.getElementById('match-modal-overlay');
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                closeMatchModal();
            }
        });
    });

    // ===== SAVE JOB WITH PERSISTENT STATE MANAGEMENT =====
    function getSavedJobIds() {
        return JSON.parse(localStorage.getItem('savedJobs') || '[]')
            .map(id => String(parseInt(id, 10)))
            .filter(id => id !== 'NaN');
    }

    function isJobSaved(jobId) {
        const normalizedJobId = String(parseInt(jobId, 10));
        return getSavedJobIds().includes(normalizedJobId);
    }

    const jobButtonStateKey = 'jobButtonStates';

    function normalizeJobIds(items) {
        if (!Array.isArray(items)) {
            return [];
        }

        return [...new Set(items.map(id => parseInt(id, 10)).filter(id => Number.isInteger(id) && id > 0))];
    }

    function getAppliedJobIds() {
        try {
            return normalizeJobIds(JSON.parse(localStorage.getItem('appliedJobs') || '[]'));
        } catch (e) {
            return [];
        }
    }

    function setAppliedJobIds(ids) {
        localStorage.setItem('appliedJobs', JSON.stringify(normalizeJobIds(ids)));
    }

    function getJobButtonStates() {
        try {
            const raw = JSON.parse(localStorage.getItem(jobButtonStateKey) || '{}');
            return raw && typeof raw === 'object' ? raw : {};
        } catch (e) {
            return {};
        }
    }

    function setJobButtonStates(states) {
        localStorage.setItem(jobButtonStateKey, JSON.stringify(states || {}));
    }

    function getJobButtonState(jobId) {
        const normalizedJobId = String(parseInt(jobId, 10));
        const states = getJobButtonStates();

        if (states[normalizedJobId]) {
            return states[normalizedJobId];
        }

        if (normalizeJobIds(appliedJobs).includes(parseInt(normalizedJobId, 10))) {
            return 'applied';
        }

        if (isJobSaved(normalizedJobId)) {
            return 'saved';
        }

        return '';
    }

    function updateSaveButtonState(jobId, state) {
        const normalizedJobId = String(parseInt(jobId, 10));
        document.querySelectorAll(`.btn-save[data-job-id="${normalizedJobId}"]`).forEach(btn => {
            btn.classList.toggle('saved', state === 'saved');
            btn.classList.toggle('applied', state === 'applied');
        });
    }

    function setJobButtonState(jobId, state) {
        const normalizedJobId = String(parseInt(jobId, 10));
        const states = getJobButtonStates();

        if (!state) {
            delete states[normalizedJobId];
        } else {
            states[normalizedJobId] = state;
        }

        setJobButtonStates(states);
        updateSaveButtonState(normalizedJobId, state);
    }

    function markJobAsApplied(jobId) {
        const normalizedJobId = String(parseInt(jobId, 10));

        if (!normalizedJobId || normalizedJobId === 'NaN') {
            return;
        }

        appliedJobs = normalizeJobIds([...appliedJobs, parseInt(normalizedJobId, 10)]);
        setAppliedJobIds(appliedJobs);
        setJobButtonState(normalizedJobId, 'applied');

        document.querySelectorAll(`.job-apply-form[action*="/jobs/apply/${normalizedJobId}"] .btn-apply`).forEach(button => {
            button.textContent = 'Applied';
            button.classList.add('applied');
            button.disabled = true;
        });

        document.querySelectorAll(`.btn-save[data-job-id="${normalizedJobId}"]`).forEach(button => {
            button.classList.add('applied');
        });
    }

    /**
     * Save/Unsave a job with persistent state management
     * Uses localStorage for immediate persistence + optional backend sync
     */
    function saveJob(e, jobId, action = 'saved') {
        e.stopPropagation();

        const savedJobsKey = 'savedJobs';
        const normalizedJobId = String(parseInt(jobId, 10));
        let savedJobs = getSavedJobIds();
        const dropdownWrapper = e.target.closest('.btn-save-wrapper');
        const btn = dropdownWrapper ? dropdownWrapper.querySelector('.btn-save') : null;

        if (action === 'applied') {
            closeAllSaveDropdowns();
            const applyForm = document.querySelector(`.job-apply-form[action*="/jobs/apply/${normalizedJobId}"]`);
            if (applyForm) {
                fetch(applyForm.action, {
                    method: 'POST',
                    credentials: 'same-origin'
                }).catch(() => {});
            }

            markJobAsApplied(normalizedJobId);
            showToast('✅ Job marked as applied', 'success');
            return;
        }

        if (!btn) {
            return;
        }

        const isCurrentlySaved = savedJobs.includes(normalizedJobId);

        if (isCurrentlySaved) {
            savedJobs = savedJobs.filter(id => id !== normalizedJobId);
            localStorage.setItem(savedJobsKey, JSON.stringify(savedJobs.map(id => parseInt(id, 10))));
            setJobButtonState(normalizedJobId, '');
            showToast('❌ Job removed from wishlist', 'info');
            fetch('<?= base_url() ?>jobs/unsave_job_action/' + normalizedJobId)
                .catch(err => console.log('Backend sync skipped (table may not exist)', err));
        } else {
            savedJobs.push(normalizedJobId);
            savedJobs = [...new Set(savedJobs)];
            localStorage.setItem(savedJobsKey, JSON.stringify(savedJobs.map(id => parseInt(id, 10))));
            setJobButtonState(normalizedJobId, 'saved');
            showToast('✅ Job saved to your wishlist!', 'success');
            fetch('<?= base_url() ?>jobs/save_job_action/' + normalizedJobId)
                .catch(err => console.log('Backend sync skipped (table may not exist)', err));
        }

        closeAllSaveDropdowns();
    }

    function toggleSaveDropdown(e, jobId) {
        e.stopPropagation();
        const wrapper = e.target.closest('.btn-save-wrapper');
        if (!wrapper) {
            return;
        }

        // Close all other dropdowns
        document.querySelectorAll('.btn-save-wrapper.open').forEach(w => {
            if (w !== wrapper) {
                w.classList.remove('open');
                const btn = w.querySelector('.btn-save');
                if (btn) btn.setAttribute('aria-expanded', 'false');
            }
        });

        // Toggle current dropdown
        const isOpen = wrapper.classList.contains('open');
        wrapper.classList.toggle('open', !isOpen);
        
        const button = wrapper.querySelector('.btn-save');
        if (button) {
            button.setAttribute('aria-expanded', !isOpen ? 'true' : 'false');
        }

        // Position dropdown to prevent layout shift
        if (!isOpen) {
            positionSaveDropdown(wrapper);
        }
    }

    function positionSaveDropdown(wrapper) {
        // No longer needed - using CSS absolute positioning
    }

    function closeAllSaveDropdowns() {
        document.querySelectorAll('.btn-save-wrapper.open').forEach(wrapper => {
            wrapper.classList.remove('open');
            const button = wrapper.querySelector('.btn-save');
            if (button) {
                button.setAttribute('aria-expanded', 'false');
            }
        });
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.btn-save-wrapper')) {
            closeAllSaveDropdowns();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAllSaveDropdowns();
        }
    });

    /**
     * Restore saved job states on page load from localStorage
     * Checks each Save button and marks as .saved if job is in localStorage
     */
    function restoreSavedJobStates() {
        const savedJobsKey = 'savedJobs';
        const savedJobs = JSON.parse(localStorage.getItem(savedJobsKey) || '[]')
            .map(id => String(parseInt(id, 10)))
            .filter(id => id !== 'NaN');

        // Keep applied state aligned with the server response so refreshes always
        // reflect what exists in the database.
        appliedJobs = normalizeJobIds(Array.isArray(appliedJobs) ? appliedJobs : []);
        
        document.querySelectorAll('.btn-save').forEach(btn => {
            const jobId = btn.dataset.jobId || btn.getAttribute('onclick')?.match(/saveJob\(event,\s*(\d+)\)/)?.[1];
            if (!jobId) {
                return;
            }

            const normalizedJobId = String(parseInt(jobId, 10));
            const state = getJobButtonState(normalizedJobId) || (savedJobs.includes(normalizedJobId) ? 'saved' : '');
            if (state) {
                setJobButtonState(normalizedJobId, state);
            }
        });
    }

    // ===== HELPER: Escape HTML =====
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // ===== FILTER BY MATCH SCORE =====
    function updateFilter(minScore, maxScore) {
        const showAll = minScore === 'all';
        const min = showAll ? 0 : parseInt(minScore);
        const max = maxScore === null ? 100 : parseInt(maxScore);
        
        document.querySelectorAll('.job-list-panel .job-card').forEach(card => {
            const score = parseInt(card.dataset.score);
            const shouldShow = showAll || (score >= min && score <= max);
            card.style.display = shouldShow ? 'block' : 'none';
        });
        
        // Update button states
        document.querySelectorAll('.f-pill').forEach(p => p.classList.remove('active'));
        const btnId = showAll ? 'btn-all' : (min === 70 ? 'btn-70' : (min === 40 ? 'btn-40' : null));
        if (btnId) document.getElementById(btnId)?.classList.add('active');
        
        // Keep selected-card visual state and detail panel in sync with filtering.
        const allCards = document.querySelectorAll('.job-list-panel .job-card');
        const selectedCard = selectedJobId
            ? document.querySelector(`[data-job-id="${selectedJobId}"]`)
            : null;

        if (!selectedCard) {
            allCards.forEach(card => card.classList.remove('active'));
            return;
        }

        const selectedVisible = selectedCard.style.display !== 'none';

        if (!selectedVisible) {
            allCards.forEach(card => card.classList.remove('active'));

            const detailPanel = document.getElementById('job-detail-panel');
            detailPanel.innerHTML = `
                <div class="detail-placeholder">
                    <i class="fas fa-briefcase"></i>
                    <p>Select a job to view details</p>
                </div>
            `;
            return;
        }

        allCards.forEach(card => {
            card.classList.toggle('active', card.dataset.jobId == selectedJobId);
        });

        // If selected job becomes visible again after filtering, restore its details.
        const detailPanel = document.getElementById('job-detail-panel');
        if (detailPanel.querySelector('.detail-placeholder')) {
            selectJob(selectedJobId);
        }
    }

    // ===== BASE URL =====
    const baseUrl = '<?= base_url() ?>';

    // Trigger Success Popup Tile specifically for upload success
    <?php if ($this->session->flashdata('upload_success')): ?>
        window.addEventListener('load', () => {
            const popup = document.getElementById('success-popup');
            popup.classList.add('show');
            setTimeout(() => popup.classList.remove('show'), 5000);
        });
    <?php endif; ?>
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    // Configure toastr
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "4000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "slideDown",
        "hideMethod": "slideUp"
    };

    function showToast(message, type = 'success') {
        toastr[type](message);
    }

    // Handle form submissions and page state restoration
    document.addEventListener('DOMContentLoaded', function() {
        // Setup live search
        setupJobSearch();

        // Restore saved job state for currently rendered detail button
        restoreSavedJobStates();

        document.addEventListener('submit', function(e) {
            const form = e.target.closest('.job-apply-form');
            if (!form) {
                return;
            }

            const button = form.querySelector('.btn-apply');
            if (button && button.disabled) {
                e.preventDefault();
                showToast('You have already applied to this job', 'info');
                return;
            }

            e.preventDefault();

            const jobIdMatch = form.action.match(/\/jobs\/apply\/(\d+)/);
            const jobId = jobIdMatch ? parseInt(jobIdMatch[1], 10) : null;

            if (jobId) {
                markJobAsApplied(jobId);
            }

            showToast('✅ Application submitted successfully!', 'success');

            window.requestAnimationFrame(() => {
                form.submit();
            });
        });

        // Restore only previously selected job (do not auto-select a new one)
        let restoredJobId = null;
        try {
            restoredJobId = sessionStorage.getItem(selectedJobStorageKey);
        } catch (e) {
            restoredJobId = null;
        }

        const hasRestoredJob = restoredJobId && allJobs.some(j => String(j.id) === String(restoredJobId));
        if (hasRestoredJob) {
            selectJob(restoredJobId);
            return;
        }

        // Ensure first visible card is active and restore its save state if no prior selection exists.
        const firstVisibleCard = Array.from(document.querySelectorAll('.job-list-panel .job-card'))
            .find(card => card.style.display !== 'none');
        if (firstVisibleCard) {
            firstVisibleCard.classList.add('active');
            const defaultJobId = firstVisibleCard.getAttribute('data-job-id');
            if (defaultJobId) {
                selectedJobId = defaultJobId;
                restoreSavedJobStates();
            }
        }
    });
</script>


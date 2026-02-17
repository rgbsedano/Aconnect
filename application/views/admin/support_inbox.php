<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    :root {
        --primary-bg: #f8fafc;
        --card-bg: #ffffff;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --accent-red: #700a0a;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --border-radius: 24px;
    }

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
    .header-section p { color: rgba(255, 255, 255, 0.9); font-size: 14px; margin: 0; }

    /* Support List Card */
    .inbox-card {
        background: var(--card-bg);
        border-radius: var(--border-radius);
        padding: 30px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
        min-height: 600px;
    }

    .inbox-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .inbox-item {
        display: flex;
        align-items: center;
        padding: 20px;
        border-radius: 18px;
        transition: var(--transition);
        margin-bottom: 12px;
        border: 1px solid transparent;
        cursor: pointer;
    }

    .inbox-item:hover {
        background: #f8fafc;
        border-color: #e2e8f0;
        transform: scale(1.01);
    }

    .inbox-item .profile-img {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        object-fit: cover;
        margin-right: 20px;
        border: 2px solid white;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }

    .alumni-meta { flex: 1; }
    .alumni-name { font-weight: 700; color: var(--text-main); font-size: 16px; margin-bottom: 2px; }
    .last-contact { font-size: 12px; color: var(--text-muted); font-weight: 500; }

    .btn-view-chat {
        padding: 10px 20px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        color: var(--accent-red);
        background: #fef2f2;
        border: 1px solid transparent;
        transition: var(--transition);
    }

    .btn-view-chat:hover {
        background: var(--accent-red);
        color: white;
    }

    /* Modal / Popup Chat Styling */
    .chat-popup {
        position: fixed;
        bottom: 24px;
        right: 24px;
        width: 400px;
        height: 550px;
        background: white;
        border-radius: 24px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        display: none;
        flex-direction: column;
        z-index: 1050;
        overflow: hidden;
        border: 1px solid #f1f5f9;
        animation: slideUp 0.4s cubic-bezier(0.18, 0.89, 0.32, 1.28);
    }

    @keyframes slideUp {
        from { transform: translateY(100%); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .chat-header {
        background: var(--accent-red);
        color: white;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chat-header h6 { margin: 0; font-weight: 700; font-size: 15px; }
    .chat-close { background: none; border: none; color: white; opacity: 0.8; font-size: 24px; cursor: pointer; }
    .chat-close:hover { opacity: 1; }

    .chat-body {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
        background: #f8fafc;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .chat-bubble {
        max-width: 80%;
        padding: 12px 16px;
        border-radius: 16px;
        font-size: 14px;
        line-height: 1.5;
        font-weight: 500;
        position: relative;
    }

    .bubble-alumni {
        background: white;
        color: var(--text-main);
        align-self: flex-start;
        border-bottom-left-radius: 4px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .bubble-admin {
        background: var(--accent-red);
        color: white;
        align-self: flex-end;
        border-bottom-right-radius: 4px;
        box-shadow: 0 4px 6px rgba(112, 10, 10, 0.1);
    }

    .chat-footer {
        padding: 20px;
        background: white;
        border-top: 1px solid #f1f5f9;
    }

    .chat-input-row {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .chat-textarea {
        flex: 1;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px;
        font-size: 14px;
        font-weight: 500;
        resize: none;
        height: 48px;
        transition: var(--transition);
    }

    .chat-textarea:focus {
        outline: none;
        border-color: var(--accent-red);
        box-shadow: 0 0 0 4px rgba(112, 10, 10, 0.05);
    }

    .btn-send {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: var(--accent-red);
        color: white;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition);
    }

    .btn-send:hover { transform: scale(1.1); background: #5a0808; }

    @media (max-width: 768px) {
        .header-section {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .dashboard-wrapper {
            padding: 15px;
        }

        .inbox-card {
            padding: 15px;
            min-height: auto;
        }

        .inbox-item {
            padding: 12px;
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .inbox-item .profile-img {
            margin-right: 0;
            width: 48px;
            height: 48px;
        }

        .alumni-meta {
            width: 100%;
        }

        .btn-view-chat {
            width: 100%;
            text-align: center;
        }

        .chat-popup {
            width: 100%;
            height: 100%;
            bottom: 0;
            right: 0;
            border-radius: 0;
            z-index: 2000;
        }
    }

    @media (max-width: 576px) {
        .header-section h1 {
            font-size: 22px;
        }
    }

</style>

<div class="dashboard-wrapper">
    <div class="header-section">
        <div>
            <h1>Support <span>Inbox</span></h1>
            <p>Communicate with alumni and provide assistance in real-time.</p>
        </div>
    </div>

    <div class="inbox-card">
        <div class="mb-4">
            <div style="font-size: 12px; font-weight: 800; text-transform: uppercase; color: var(--text-muted); letter-spacing: 1px; margin-bottom: 20px;">
                Active Conversations (<?= count($alumni_list) ?>)
            </div>
        </div>

        <ul class="inbox-list">
            <?php foreach ($alumni_list as $alumni): ?>
                <?php
                    $image = !empty($alumni->profile_image)
                        ? base_url('assets/uploads/alumni/' . $alumni->profile_image)
                        : base_url('assets/images/' . (strtolower($alumni->gender) === 'female' ? 'person-female.png' : 'person-male.png'));
                ?>
                <li class="inbox-item" onclick="openChatModal(<?= $alumni->id ?>, '<?= ucwords($alumni->first_name . ' ' . $alumni->last_name) ?>')">
                    <img src="<?= $image ?>" alt="Profile" class="profile-img">
                    <div class="alumni-meta">
                        <div class="alumni-name"><?= ucwords($alumni->first_name . ' ' . $alumni->last_name) ?></div>
                        <div class="last-contact">
                            <i class="far fa-clock mr-1"></i>
                            Updated: <?= date('M d, Y | g:i A', strtotime($alumni->last_contact)) ?>
                        </div>
                    </div>
                    <div>
                        <button class="btn-view-chat">
                            <i class="fas fa-comment-dots mr-2"></i> Respond
                        </button>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

        <?php if(empty($alumni_list)): ?>
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-light mb-3"></i>
                <p class="text-muted font-weight-bold">Your inbox is currently empty.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Chat Popup -->
<div id="chatModal" class="chat-popup">
    <div class="chat-header">
        <h6 id="chatModalTitle">Support Chat</h6>
        <button class="chat-close" onclick="closeChatModal()">&times;</button>
    </div>
    <div id="chatBox" class="chat-body">
        <!-- Messages will load here -->
    </div>
    <div class="chat-footer">
        <form id="chatForm">
            <input type="hidden" name="receiver_id" id="receiverId">
            <div class="chat-input-row">
                <textarea name="message" class="chat-textarea" placeholder="Type your response..." required></textarea>
                <button type="submit" class="btn-send">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openChatModal(userId, name) {
        $('#chatModal').css('display', 'flex');
        $('#receiverId').val(userId);
        $('#chatModalTitle').text('Chat: ' + name);

        fetchMessages(userId);
    }

    function fetchMessages(userId) {
        fetch(`<?= base_url('support/get_chat_json/') ?>` + userId)
            .then(res => res.json())
            .then(messages => {
                const chatBox = document.getElementById('chatBox');
                chatBox.innerHTML = '';
                messages.forEach(msg => {
                    const div = document.createElement('div');
                    div.className = 'chat-bubble ' + (msg.is_admin == 1 ? 'bubble-admin' : 'bubble-alumni');
                    div.innerHTML = msg.message;
                    chatBox.appendChild(div);
                });
                chatBox.scrollTop = chatBox.scrollHeight;
            });
    }

    $('#chatForm').on('submit', function(e) {
        e.preventDefault();
        const msgInput = $(this).find('textarea');
        const message = msgInput.val().trim();
        const receiverId = $('#receiverId').val();

        if (message === '') return;

        fetch('<?= base_url('support/admin_reply') ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ receiver_id: receiverId, message: message })
        })
        .then(res => res.json())
        .then(() => {
            msgInput.val('');
            const chatBox = document.getElementById('chatBox');
            const div = document.createElement('div');
            div.className = 'chat-bubble bubble-admin';
            div.innerHTML = message;
            chatBox.appendChild(div);
            chatBox.scrollTop = chatBox.scrollHeight;
        });
    });

    function closeChatModal() {
        $('#chatModal').hide();
    }
</script>

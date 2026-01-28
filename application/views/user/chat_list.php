<style>
    :root {
        --maroon: #8B1538;
        --maroon-dark: #6B0F2A;
        --gold: #D4A574;
        --bg: #FAFAF8;
        --card: #ffffff;
        --text: #1F2937;
        --muted: #6B7280;
        --border: #E5E7EB;
        --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
        --shadow-md: 0 4px 12px rgba(0,0,0,0.1);
        --light-bg: #f9f9f9;
    }

    .container-fluid {
        padding: 20px;
        background-color: var(--bg);
        min-height: 100vh;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    /* --- Chat List (Inbox) Styles --- */
    .inbox-list-container {
        max-width: 600px;
        margin: 80px auto 20px;
        background-color: var(--card);
        border-radius: 12px;
        box-shadow: var(--shadow-md);
        padding: 20px;
    }

    .inbox-heading {
        color: var(--text);
        font-size: 24px;
        font-weight: 700;
        margin: 0 0 20px 0;
        padding-bottom: 16px;
        border-bottom: 2px solid var(--gold);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .inbox-heading i {
        color: var(--maroon);
    }

    .inbox-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    /* Individual Contact Item */
    .inbox-item {
        padding: 16px;
        margin-bottom: 8px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        transition: all 0.3s;
        border: 1px solid var(--border);
        background: var(--card);
    }

    .inbox-item:hover {
        background-color: var(--light-bg);
        border-color: var(--maroon);
        box-shadow: var(--shadow-md);
        transform: translateX(4px);
    }

    .friend-info {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
        min-width: 0;
    }

    .profile-image-inbox {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--maroon);
        flex-shrink: 0;
        background: var(--light-bg);
    }

    .friend-name-info {
        flex: 1;
        min-width: 0;
    }

    .friend-name {
        font-weight: 700;
        color: var(--text);
        font-size: 15px;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .friend-status {
        font-size: 12px;
        color: var(--muted);
        margin: 4px 0 0 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .btn-message-chat {
        background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
        color: white;
        border: none;
        padding: 8px 18px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        transition: all 0.3s;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .btn-message-chat:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .no-connections {
        color: var(--muted);
        font-size: 14px;
        text-align: center;
        padding: 40px 20px;
        border: 2px dashed var(--border);
        border-radius: 10px;
        margin-top: 20px;
    }

    .no-connections i {
        font-size: 48px;
        color: var(--border);
        display: block;
        margin-bottom: 12px;
    }

    .no-connections p {
        margin: 8px 0;
    }

    .no-connections .title {
        font-weight: 600;
        color: var(--text);
    }

    /* --- Chat Modal Styles --- */
    .chat-modal {
        position: fixed;
        bottom: 24px;
        right: 24px;
        width: 400px;
        height: 550px;
        background: var(--card);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border-radius: 20px;
        display: none;
        flex-direction: column;
        z-index: 1000;
        overflow: hidden;
        border: 1px solid #f1f5f9;
        animation: modalFadeUp 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    @keyframes modalFadeUp {
        from { opacity: 0; transform: translateY(40px) scale(0.95); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    .chat-modal-header {
        background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
        color: white;
        padding: 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: var(--shadow-sm);
    }

    .chat-modal-header-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .chat-modal-header .profile-image-inbox {
        width: 40px;
        height: 40px;
        border: 2px solid white;
    }

    .chat-modal-header span {
        font-weight: 700;
        font-size: 14px;
    }

    .chat-modal-header .close {
        background: none;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        padding: 0;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        transition: all 0.3s;
    }

    .chat-modal-header .close:hover {
        background: rgba(255,255,255,0.2);
    }

    .chat-modal-body {
        flex: 1;
        overflow-y: auto;
        padding: 16px;
        background-color: var(--light-bg);
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .chat-modal-body::-webkit-scrollbar {
        width: 6px;
    }

    .chat-modal-body::-webkit-scrollbar-track {
        background: transparent;
    }

    .chat-modal-body::-webkit-scrollbar-thumb {
        background: var(--border);
        border-radius: 3px;
    }

    .message-bubble {
        display: flex;
        margin: 4px 0;
        animation: bubblePop 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) both;
    }

    @keyframes bubblePop {
        from { opacity: 0; transform: scale(0.8) translateY(10px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }
    
    .message-bubble.own { transform-origin: right bottom; }
    .message-bubble.other { transform-origin: left bottom; }

    .message-bubble > div {
        max-width: 75%;
        padding: 10px 14px;
        border-radius: 14px;
        word-wrap: break-word;
        font-size: 13px;
        line-height: 1.4;
        box-shadow: var(--shadow-sm);
    }

    .message-bubble.own {
        justify-content: flex-end;
    }

    .message-bubble.own > div {
        background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
        color: white;
        border-radius: 14px 4px 14px 14px;
    }

    .message-bubble.other {
        justify-content: flex-start;
    }

    .message-bubble.other > div {
        background: var(--card);
        color: var(--text);
        border: 1px solid var(--border);
        border-radius: 4px 14px 14px 14px;
    }

    .message-time {
        font-size: 10px;
        margin-top: 4px;
        text-align: right;
        opacity: 0.7;
    }

    .message-bubble.own .message-time {
        color: rgba(255,255,255,0.8);
    }

    .message-bubble.other .message-time {
        color: var(--muted);
    }

    /* Chat Footer */
    .chat-modal-footer {
        padding: 12px;
        border-top: 1px solid var(--border);
        background-color: var(--card);
    }

    .chat-form {
        display: flex;
        gap: 8px;
        align-items: flex-end;
    }

    .chat-form textarea {
        flex-grow: 1;
        resize: none;
        max-height: 80px;
        padding: 10px 14px;
        border-radius: 20px;
        border: 1.5px solid var(--border);
        font-size: 13px;
        line-height: 1.4;
        font-family: inherit;
        transition: all 0.3s;
    }

    .chat-form textarea:focus {
        outline: none;
        border-color: var(--maroon);
        box-shadow: 0 0 0 2px rgba(139, 21, 56, 0.1);
    }

    .chat-form button {
        background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
        color: white;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        flex-shrink: 0;
    }

    .chat-form button:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-md);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .inbox-list-container {
            max-width: 100%;
            margin: 70px 0 0 0;
        }
        .inbox-item {
            padding: 12px;
        }
        .profile-image-inbox {
            width: 48px;
            height: 48px;
        }
        .friend-name {
            font-size: 14px;
        }
        .chat-modal {
            width: 100%;
            height: 100%;
            right: 0;
            bottom: 0;
            top: 0;
            left: 0;
            border-radius: 0;
        }
    }
</style>

<div class="container-fluid">
    <div class="inbox-list-container">
        <h2 class="inbox-heading"><i class="fas fa-comments"></i> Messages</h2>

        <?php if (empty($connections)): ?>
            <div class="no-connections">
                <i class="fas fa-inbox"></i>
                <p class="title">No Conversations Yet</p>
                <p>Find alumni and start chatting to build your network</p>
            </div>
        <?php else: ?>
            <ul class="inbox-list">
                <?php foreach ($connections as $friend): ?>
                    <?php
                        if (!empty($friend->profile_image)) {
                            $profileImage = base_url('assets/uploads/alumni/' . $friend->profile_image);
                        } else {
                            $gender = strtolower($friend->gender ?? '');
                            $defaultImage = ($gender === 'female') ? 'person-female.png' : 'person-male.png';
                            $profileImage = base_url('assets/images/' . $defaultImage);
                        }
                    ?>
                    <li class="inbox-item" onclick="openChatModal(
                        <?= $friend->id ?>,
                        '<?= htmlspecialchars(ucwords($friend->first_name . ' ' . $friend->last_name)) ?>',
                        '<?= htmlspecialchars($profileImage) ?>'
                    )">
                        <div class="friend-info">
                            <img src="<?= $profileImage ?>" alt="<?= htmlspecialchars(ucwords($friend->first_name . ' ' . $friend->last_name)) ?>" class="profile-image-inbox">
                            <div class="friend-name-info">
                                <p class="friend-name"><?= ucwords($friend->first_name . ' ' . $friend->last_name) ?></p>
                                <p class="friend-status"><i class="fas fa-circle" style="font-size: 6px; margin-right: 4px;"></i> Active</p>
                            </div>
                        </div>
                        <button type="button" class="btn-message-chat" onclick="event.stopPropagation();">
                            <i class="fas fa-paper-plane"></i> Message
                        </button>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <!-- Chat Modal -->
    <div id="chatModal" class="chat-modal">
        <div class="chat-modal-header">
            <div class="chat-modal-header-info">
                <img id="chatProfileImage" src="" alt="Profile" class="profile-image-inbox">
                <span id="chatFullName">Alumni Name</span>
            </div>
            <button type="button" class="close" onclick="closeChatModal();" title="Close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="chat-modal-body">
            <div id="chatContent" style="flex: 1; overflow-y: auto;">
                <p style="text-align:center; color: var(--muted); font-size: 13px;">Loading conversation...</p>
            </div>
        </div>

        <div class="chat-modal-footer">
            <form id="chatForm" class="chat-form">
                <input type="hidden" name="receiver_id" id="receiverId">
                <textarea name="message" placeholder="Aa" required></textarea>
                <button type="submit" title="Send"><i class="fas fa-paper-plane"></i></button>
            </form>
        </div>
    </div>
</div>

<script>
let currentFriendId = null;

function renderMessages(messagesHtml) {
    const chatContent = document.getElementById('chatContent');
    chatContent.innerHTML = messagesHtml;
    chatContent.scrollTop = chatContent.scrollHeight;
}

function loadMessages(friendId) {
    renderMessages('<p style="text-align:center; color: var(--muted); font-size: 13px;">Loading conversation...</p>');

    const url = "<?= site_url('chat/get_messages_ajax/') ?>" + friendId;

    fetch(url)
        .then(response => response.text())
        .then(html => {
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;

            let modernHtml = '';
            const messages = tempDiv.querySelectorAll('#chatContent > div');

            messages.forEach((msgDiv, index) => {
                const isOwn = msgDiv.querySelector('div').style.justifyContent === 'flex-end';
                const messageBubble = msgDiv.querySelector('div > div');
                const messageText = messageBubble ? messageBubble.childNodes[0].nodeValue.trim() : '';
                const timeElement = messageBubble ? messageBubble.querySelector('div') : null;
                const timeText = timeElement ? timeElement.innerHTML : '';

                modernHtml += `
                <div class="message-bubble ${isOwn ? 'own' : 'other'}" style="animation-delay: ${index * 0.05}s">
                    <div>
                        ${messageText}
                        <div class="message-time">${timeText}</div>
                    </div>
                </div>`;
            });

            renderMessages(modernHtml || '<p style="text-align:center; color: var(--muted); font-size: 13px;">Say hello!</p>');
        })
        .catch(err => {
            console.error('Error loading messages:', err);
            renderMessages('<p style="text-align:center; color: #e74c3c; font-size: 13px;">Failed to load messages.</p>');
        });
}

function openChatModal(friendId, fullName, imageUrl) {
    currentFriendId = friendId;

    document.getElementById('chatFullName').innerText = fullName;
    document.getElementById('chatProfileImage').src = imageUrl;
    document.getElementById('receiverId').value = friendId;
    document.getElementById('chatModal').style.display = 'flex';
    document.getElementById('chatForm').message.focus();

    loadMessages(friendId);

    const chatForm = document.getElementById('chatForm');
    chatForm.onsubmit = function (e) {
        e.preventDefault();

        const messageInput = chatForm.message;
        const messageText = messageInput.value.trim();

        if (messageText === "") return;

        const formData = new FormData();
        formData.append('receiver_id', friendId);
        formData.append('message', messageText);

        messageInput.value = '';

        fetch("<?= site_url('chat/send') ?>", {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                loadMessages(friendId);
            } else {
                alert('Failed to send message.');
            }
        })
        .catch(err => {
            console.error('Error sending message:', err);
            alert('Error sending message');
        });
    };
}

function closeChatModal() {
    document.getElementById('chatModal').style.display = 'none';
    currentFriendId = null;
    document.getElementById('chatForm').onsubmit = null;
}
</script>
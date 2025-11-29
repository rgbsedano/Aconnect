<style>
    /* 🎨 SOCIAL MEDIA STYLE CHAT INBOX */
    :root {
        --primary-maroon: #700A0A; 
        --light-bg: #f0f2f5; /* Light grey background */
        --card-bg: #ffffff;
        --text-dark: #1c1e21;
        --text-muted: #606770;
        --border-color: #dddfe2;
        --border-radius-lg: 12px;
        --border-radius-sm: 8px;
        --shadow-subtle: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .container-fluid {
        padding: 20px;
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        background-color: var(--light-bg);
        min-height: 100vh;
    }

    /* --- Chat List (Inbox) Styles --- */
    .inbox-list-container {
        max-width: 600px; /* Constrain list width for desktop view */
        margin: 0 auto;
        background-color: var(--card-bg);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-subtle);
        padding: 15px;
    }

    .inbox-heading {
        color: var(--text-dark);
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 10px;
        padding-bottom: 5px;
        border-bottom: 1px solid var(--border-color);
    }

    .inbox-list {
        list-style: none;
        padding: 0;
        margin-top: 10px;
    }

    /* Individual Contact Item - Highly Compact */
    .inbox-item {
        padding: 10px;
        margin-bottom: 5px;
        border-radius: var(--border-radius-sm);
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .inbox-item:hover {
        background-color: #f7f7f7; /* Subtle hover effect */
    }

    .friend-info {
        display: flex;
        align-items: center;
    }

    .profile-image-inbox {
        width: 48px; /* Standard contact list size */
        height: 48px;
        border-radius: 50%;
        margin-right: 12px;
        object-fit: cover;
        border: 2px solid var(--border-color); /* Neutral border */
    }

    .friend-name {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 1.05rem;
    }

    .btn-message-chat {
        background-color: var(--primary-maroon);
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 50px; /* Pill shape for button */
        font-size: 0.85rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    
    .no-connections {
        color: var(--text-muted);
        font-size: 1rem;
        text-align: center;
        padding: 30px;
        border: 1px dashed var(--border-color);
        border-radius: var(--border-radius-sm);
        margin-top: 15px;
    }

    /* --- Chat Modal Styles (Standalone Floating Window) --- */
    .chat-modal {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 350px; /* Standard desktop chat window size */
        height: 450px;
        background: var(--card-bg);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        border-radius: var(--border-radius-lg);
        display: none;
        flex-direction: column;
        z-index: 1000;
        overflow: hidden;
    }

    .chat-modal-header {
        background-color: var(--primary-maroon);
        color: white;
        padding: 10px 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: var(--shadow-subtle); /* Separator shadow */
    }

    .chat-modal-header .profile-image-inbox {
        border: none;
    }

    .chat-modal-header .close {
        background: none;
        border: none;
        color: white;
        font-size: 1.8rem;
        line-height: 1;
    }

    .chat-modal-body {
        flex: 1;
        overflow-y: auto;
        padding: 10px;
        background-color: var(--light-bg); /* Chat background */
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    /* Message Bubbles */
    #chatContent > div {
        display: flex;
        margin: 4px 0;
    }

    #chatContent > div > div {
        max-width: 80%;
        padding: 8px 12px;
        border-radius: 18px;
        word-wrap: break-word;
        font-size: 0.9rem;
        line-height: 1.3;
        box-shadow: 0 1px 0 rgba(0, 0, 0, 0.05); /* Very subtle bubble shadow */
    }

    /* My messages (Maroon) */
    #chatContent > div[style*="flex-end"] {
        justify-content: flex-end;
    }
    #chatContent > div[style*="flex-end"] > div {
        background-color: var(--primary-maroon) !important;
        color: white !important;
        /* Social Media Style Tweak: Triangle tip via border radius */
        border-bottom-right-radius: 5px; 
    }

    /* Partner's messages (Light Grey) */
    #chatContent > div[style*="flex-start"] {
        justify-content: flex-start;
    }
    #chatContent > div[style*="flex-start"] > div {
        background-color: #e4e6eb !important; /* Standard chat grey */
        color: var(--text-dark) !important;
        border-bottom-left-radius: 5px;
    }

    .message-time {
        font-size: 0.6rem;
        margin-top: 3px !important;
        text-align: right;
        opacity: 0.7;
    }

    /* Chat Footer */
    .chat-modal-footer {
        padding: 8px 10px;
        border-top: 1px solid var(--border-color);
        background-color: var(--card-bg);
    }

    .chat-form {
        display: flex;
        gap: 5px;
        align-items: center;
    }

    .chat-form textarea {
        flex-grow: 1;
        resize: none;
        height: 38px; 
        padding: 8px 10px;
        border-radius: 20px; /* Pill shape for input */
        border: 1px solid var(--border-color);
        font-size: 0.9rem;
        line-height: 1.3;
    }

    .chat-form button {
        background-color: var(--primary-maroon);
        color: white;
        border: none;
        width: 38px; /* Square button for icon */
        height: 38px;
        border-radius: 50%; /* Circle send button */
        cursor: pointer;
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .inbox-list-container {
            max-width: 100%;
            padding: 10px;
        }
        .inbox-item {
            padding: 8px;
        }
        .profile-image-inbox {
            width: 40px;
            height: 40px;
        }
        .friend-name {
            font-size: 0.95rem;
        }
        
        .chat-modal {
            width: 100%;
            height: 100%;
            right: 0;
            bottom: 0;
            top: 0;
            left: 0;
            border-radius: 0; /* Full screen on mobile */
        }
    }
</style>

<div class="container-fluid">
    <div class="inbox-list-container">
        <h2 class="inbox-heading"><i class="fas fa-comment-dots mr-2"></i> Messages</h2>

        <?php if (empty($connections)): ?>
            <p class="no-connections">No connections found. Find friends and start chatting!</p>
        <?php else: ?>
            <ul class="inbox-list">
                <?php foreach ($connections as $friend): ?>
                    <?php
                        // --- Profile Image Logic ---
                        if (!empty($friend->profile_image)) {
                            $profileImage = base_url('assets/uploads/alumni/' . $friend->profile_image);
                        } else {
                            $gender = strtolower($friend->gender);
                            $defaultImage = ($gender === 'female') ? 'person-female.png' : 'person-male.png';
                            $profileImage = base_url('assets/images/' . $defaultImage);
                        }
                    ?>
                    <li class="inbox-item" onclick="openChatModal(
                        <?= $friend->id ?>,
                        '<?= ucwords($friend->first_name . ' ' . $friend->last_name) ?>',
                        '<?= $profileImage ?>'
                    )">
                        <div class="friend-info">
                            <img src="<?= $profileImage ?>" alt="<?= htmlspecialchars(ucwords($friend->first_name . ' ' . $friend->last_name)) ?>" class="profile-image-inbox">
                            <span class="friend-name"><?= ucwords($friend->first_name . ' ' . $friend->last_name) ?></span>
                        </div>
                        
                        <div class="btn-message-chat">
                            <i class="fas fa-paper-plane"></i> Chat
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    
<div id="chatModal" class="chat-modal">
    <div class="chat-modal-header">
        <div style="display: flex; align-items: center;">
            <img id="chatProfileImage" src="" alt="Profile" class="profile-image-inbox" style="width: 35px; height: 35px; margin-right: 8px;">
            <span id="chatFullName" style="font-weight: bold; font-size: 1.1rem;">Alumni Name</span>
        </div>
        <button class="close" onclick="closeChatModal()" title="Close Chat"><i class="fas fa-times"></i></button>
    </div>
    <div class="chat-modal-body">
        <div id="chatContent" style="flex: 1; overflow-y: scroll;">
            <p style="text-align:center; color: var(--text-muted);">Loading conversation...</p>
        </div>
    </div>

    <div id="chatFooter" class="chat-modal-footer">
        <form id="chatForm" class="chat-form">
            <input type="hidden" name="receiver_id" id="receiverId">
            <textarea name="message" placeholder="Aa" required></textarea>
            <button type="submit" title="Send Message"><i class="fas fa-paper-plane"></i></button>
        </form>
    </div>
</div>
</div>


<script>
let currentFriendId = null; 

// Helper function to render messages (keeps scrolling logic centralized)
function renderMessages(messagesHtml) {
    const chatContent = document.getElementById('chatContent');
    chatContent.innerHTML = messagesHtml;
    // Scroll to bottom after new content is loaded/rendered
    chatContent.scrollTop = chatContent.scrollHeight;
}

function loadMessages(friendId) {
    renderMessages('<p style="text-align:center; color: var(--text-muted);">Loading conversation...</p>');
    
    const url = "<?= site_url('chat/get_messages_ajax/') ?>" + friendId;
    
    fetch(url)
        .then(response => response.text())
        .then(html => {
            // Processing the raw message content from the AJAX endpoint to fit the new bubble style
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = html;
            
            let modernHtml = '';
            const messages = tempDiv.querySelectorAll('#chatContent > div'); 
            
            messages.forEach(msgDiv => {
                // Determine if the message is from the current user based on the inline style generated by the backend
                const isOwn = msgDiv.querySelector('div').style.justifyContent === 'flex-end';
                
                // Extract and format message content and time
                const messageBubble = msgDiv.querySelector('div > div');
                const messageText = messageBubble ? messageBubble.childNodes[0].nodeValue.trim() : '';
                const timeElement = messageBubble ? messageBubble.querySelector('div') : null;
                const timeText = timeElement ? timeElement.innerHTML : '';

                const timeStyle = isOwn ? 'color: rgba(255, 255, 255, 0.8);' : 'color: var(--text-muted);';

                // Re-create the bubble
                modernHtml += `
                <div style="display: flex; justify-content: ${isOwn ? 'flex-end' : 'flex-start'};">
                    <div style="
                        background-color: ${isOwn ? 'var(--primary-maroon)' : '#e4e6eb'} !important;
                        color: ${isOwn ? 'white' : 'var(--text-dark)'} !important;
                        ${isOwn ? 'border-bottom-right-radius: 5px;' : 'border-bottom-left-radius: 5px;'}
                    ">
                        ${messageText}
                        <div class="message-time" style="${timeStyle}">
                            ${timeText}
                        </div>
                    </div>
                </div>`;
            });

            renderMessages(modernHtml || '<p style="text-align:center; color: var(--text-muted);">Say hello!</p>');
        })
        .catch(err => {
            console.error('Error loading messages:', err);
            renderMessages('<p style="text-align:center; color: red;">Failed to load messages.</p>');
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

    // Bind the chat form submission handler
    const chatForm = document.getElementById('chatForm');
    chatForm.onsubmit = function (e) {
        e.preventDefault();

        const messageInput = chatForm.message;
        const messageText = messageInput.value.trim();

        if (messageText === "") return;

        const formData = new FormData();
        formData.append('receiver_id', friendId);
        formData.append('message', messageText);
        
        // Clear input immediately for better UX
        messageInput.value = '';

        fetch("<?= site_url('chat/send') ?>", {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                // Reload messages to show the sent message with accurate timestamp
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


<div class="container-fluid">
    <h2>Connect Inbox</h2>

    <?php if (empty($connections)): ?>
        <p class="no-connections">You have no connections yet.</p>
    <?php else: ?>
        <ul class="inbox-list">
            <?php foreach ($connections as $friend): ?>
                <?php
                    if (!empty($friend->profile_image)) {
                        $profileImage = base_url('assets/uploads/alumni/' . $friend->profile_image);
                    } else {
                        $gender = strtolower($friend->gender); // assuming 'male' or 'female'
                        $defaultImage = ($gender === 'female') ? 'person-female.png' : 'person-male.png';
                        $profileImage = base_url('assets/images/' . $defaultImage);
                    }
                ?>
                <li class="inbox-item">
                <div class="friend-info">
                    <img src="<?= $profileImage ?>" alt="<?= htmlspecialchars(ucwords($friend->first_name . ' ' . $friend->last_name)) ?>" class="profile-image">
                    <span class="friend-name"><?= ucwords($friend->first_name . ' ' . $friend->last_name) ?></span>
                </div>
                 
                    <button style="background: #700A0A"class="btn btn-primary" onclick="openChatModal(
                        <?= $friend->id ?>,
                        '<?= $friend->first_name . ' ' . $friend->last_name ?>',
                        '<?= $profileImage ?>'
                    )">Message</button>

                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

<!-- Chat Modal -->
<div id="chatModal" style="
    display: none;
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #fff;
    border: 1px solid #ccc;
    box-shadow: 0 0 10px rgba(0,0,0,0.2);
    width: 320px;
    height: 500px; /* 📌 Fixed height */
    border-radius: 8px;
    font-family: Arial, sans-serif;
    overflow: hidden;
    z-index: 1000;
" class="chat-modal">
    <div class="chat-modal-header">
        <img id="chatProfileImage" src="" alt="Profile" width="30" height="30" style="border-radius: 50%; margin-right: 10px;">
        <span id="chatFullName" style="font-weight: bold;">Alumni Name</span>
        <button slot="end" class="close" onclick="closeChatModal()">×</button>
    </div>
    <div class="chat-modal-body">
        <div id="chatContent" style="max-height: 300px; overflow-y: scroll; margin-bottom: 10px; padding: 10px; background-color: #f5f5f5;">
                <?php if (empty($messages)): ?>
                    <p style="text-align:center;">No messages yet. Start the conversation!</p>
                <?php else: ?>
                    <?php foreach ($messages as $msg): ?>
                        <?php
                            $isOwn = ($msg->sender_id == $this->session->userdata('alumni_id'));
                            $align = $isOwn ? 'flex-end' : 'flex-start';
                            $bgColor = $isOwn ? '#700A0A' : '#e4e6eb';
                            $textColor = $isOwn ? '#fff' : '#000';
                        ?>
                        <div style="display: flex; justify-content: <?= $align ?>; margin: 5px 0;">
                            <div style="
                                max-width: 70%;
                                padding: 10px;
                                border-radius: 15px;
                                background-color: <?= $bgColor ?>;
                                color: <?= $textColor ?>;
                                word-wrap: break-word;
                            ">
                                <?= htmlspecialchars($msg->message) ?>
                                <div style="font-size: 10px; margin-top: 5px; text-align: right; opacity: 0.7;">
                                    <?= date('M d, Y h:i A', strtotime($msg->sent_at)) ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

    <div id="chatFooter" style="
        padding: 10px;
        border-top: 1px solid #ccc;
        background-color: #fafafa;
    ">
            <form id="chatForm" class="chat-form">
            <input type="hidden" name="receiver_id" id="receiverId">
            <textarea name="message" placeholder="Type your message..." required></textarea>
            <button type="submit">Send</button>
        </form>
    </div>
    
</div>
</div>


<script>
let currentFriendId = null; // Store current chat friend globally

function openChatModal(friendId, fullName, imageUrl) {
    currentFriendId = friendId;

    document.getElementById('chatFullName').innerText = fullName;
    document.getElementById('chatProfileImage').src = imageUrl;
    document.getElementById('receiverId').value = friendId;

    document.getElementById('chatModal').style.display = 'block';

    loadMessages(friendId); // Load chat content

    // Move form event listener outside to avoid multiple bindings
    const chatForm = document.getElementById('chatForm');
    chatForm.onsubmit = function (e) {
        e.preventDefault();

        const formData = new FormData(chatForm);

        fetch("<?= site_url('chat/send') ?>", {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                chatForm.message.value = ''; // clear input
                loadMessages(friendId);     // reload messages
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

function loadMessages(friendId) {
    fetch("<?= site_url('chat/get_messages_ajax/') ?>" + friendId)
        .then(response => response.text())
        .then(html => {
            const chatContent = document.getElementById('chatContent');
            chatContent.innerHTML = html;
            chatContent.scrollTop = chatContent.scrollHeight; // Scroll to bottom
        });
}

function closeChatModal() {
    document.getElementById('chatModal').style.display = 'none';
    currentFriendId = null;
}
</script>

<script>
    // Simple script to scroll to the bottom of the chat on load and new messages
    const messageArea = document.querySelector('.message-area');
    const scrollToBottom = () => {
        messageArea.scrollTop = messageArea.scrollHeight;
    };

    scrollToBottom(); // Scroll on initial load

    // You might need to call scrollToBottom() again if new messages are loaded via AJAX
    // For example, after a successful form submission
    const messageForm = document.querySelector('.input-area');
    if (messageForm) {
        messageForm.addEventListener('submit', scrollToBottom);
    }
</script>

<style>
.alumni-inbox-list {
    list-style: none;
    padding: 0;
}

.alumni-inbox-item {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
    padding: 10px;
    border-bottom: 1px solid #ccc;
}

.profile-img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 15px;
}

.alumni-info {
    flex-grow: 1;
}

.btn-primary {
    background-color: #700A0A;
    color: white;
    padding: 8px 14px;
    text-decoration: none;
    border-radius: 6px;
}
.chat-modal {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 350px;
    max-height: 500px;
    background: #fff;
    border: 1px solid #ccc;
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    display: none;
    flex-direction: column;
    z-index: 9999;
}

.chat-modal-header {
    background-color: #700A0A;
    color: white;
    padding: 10px 15px;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
    align-items: center;
}

.chat-modal-header button {
    background: none;
    border: none;
    color: white;
    font-size: 20px;
    cursor: pointer;
}

.chat-modal-body {
    display: flex;
    flex-direction: column;
    flex: 1;
    padding: 10px;
    background-color: #f9f9f9;
    overflow: hidden;
}

.chat-box {
    flex: 1;
    overflow-y: auto;
    margin-bottom: 10px;
    padding-right: 5px;
}

.message {
    margin-bottom: 10px;
    padding: 10px;
    border-radius: 10px;
    max-width: 70%;
    line-height: 1.4;
}

.message.alumni {
    background-color: #eee;
    align-self: flex-start;
}

.message.admin {
    background-color: #700A0A;
    color: white;
    align-self: flex-end;
    margin-left: auto;
}

.chat-form {
    display: flex;
    gap: 8px;
}

.chat-form textarea {
    flex: 1;
    resize: none;
    height: 60px;
    padding: 8px;
    border-radius: 8px;
    border: 1px solid #ccc;
}

.chat-form button {
    background-color: #700A0A;
    color: white;
    border: none;
    padding: 0 15px;
    border-radius: 8px;
    cursor: pointer;
}
</style>


<style>
    .container-fluid {
        padding: 30px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8f9fa;
    }

    h2 {
        color: #333;
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 20px;
    }

    .inbox-list {
        list-style: none;
        padding: 0;
    }

    .inbox-item {
        background-color: #fff;
        padding: 15px 20px;
        margin-bottom: 10px;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid #eee;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .friend-info {
        display: flex;
        align-items: center;
    }

    .profile-image {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        vertical-align: middle;
        margin-right: 15px;
        object-fit: cover;
    }

    .friend-name {
        font-weight: 500;
        color: #333;
    }

    .chat-link {
        color: #007bff;
        text-decoration: none;
        padding: 10px 15px;
        border-radius: 6px;
        transition: background-color 0.2s ease-in-out;
        border: 1px solid #007bff;
        font-size: 0.9rem;
    }

    .chat-link:hover {
        background-color: #e7f3ff;
    }

    .no-connections {
        color: #777;
        font-size: 1rem;
    }

    /* Responsive adjustments */
    @media (max-width: 600px) {
        .inbox-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .chat-link {
            margin-top: 10px;
        }
    }
</style>
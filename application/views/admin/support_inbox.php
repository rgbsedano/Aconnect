<div class="container-fluid">
<div class="container mt-5">

<h2>Support Inbox</h2>

<ul class="alumni-inbox-list">
    <?php foreach ($alumni_list as $alumni): ?>
        <?php
            $image = !empty($alumni->profile_image)
                ? base_url('assets/uploads/alumni/' . $alumni->profile_image)
                : base_url('assets/images/' . (strtolower($alumni->gender) === 'female' ? 'person-female.png' : 'person-male.png'));
        ?>
        <li class="alumni-inbox-item">
            <img src="<?= $image ?>" alt="Profile" class="profile-img">
            <div class="alumni-info">
                <strong><?= ucwords($alumni->first_name . ' ' . $alumni->last_name) ?></strong><br>
                <small>Last contact: <?= date('M d, Y H:i', strtotime($alumni->last_contact)) ?></small>
            </div>
            <button class="btn btn-primary" onclick="openChatModal(<?= $alumni->id ?>)">View Chat</button>
        </li>
    <?php endforeach; ?>
</ul>

<!-- Chat Modal -->
<div id="chatModal" class="chat-modal">
    <div class="chat-modal-header">
        <span id="chatModalTitle">Chat</span>
        <button onclick="closeChatModal()">×</button>
    </div>
    <div class="chat-modal-body">
        <div id="chatBox" class="chat-box"></div>
        <form id="chatForm" class="chat-form">
            <input type="hidden" name="receiver_id" id="receiverId">
            <textarea name="message" placeholder="Type your message..." required></textarea>
            <button type="submit">Send</button>
        </form>
    </div>
</div>
</div>
</div>

<script>
function openChatModal(userId) {
    document.getElementById('chatModal').style.display = 'flex';
    document.getElementById('receiverId').value = userId;
    document.getElementById('chatModalTitle').innerText = 'Chat with Alumni #' + userId;

    // Fetch messages inline using embedded PHP rendered into JS
    fetch(`<?= base_url('support/get_chat_json/') ?>` + userId)
        .then(res => res.json())
        .then(messages => {
            const chatBox = document.getElementById('chatBox');
            chatBox.innerHTML = '';
            messages.forEach(msg => {
                const div = document.createElement('div');
                div.className = 'message ' + (msg.is_admin == 1 ? 'admin' : 'alumni');
                div.innerHTML = `<strong>${msg.is_admin == 1 ? 'Admin' : 'You'}:</strong><br>${msg.message}`;
                chatBox.appendChild(div);
            });
            chatBox.scrollTop = chatBox.scrollHeight;
        });
}
document.getElementById('chatForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Stop form from reloading the page

    const form = e.target;
    const receiverId = document.getElementById('receiverId').value;
    const message = form.message.value.trim();

    if (message === '') return;

    fetch('<?= base_url('support/admin_reply') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            receiver_id: receiverId,
            message: message
        })
    })
    .then(res => res.json())
    .then(data => {
        form.message.value = ''; // Clear textarea
        // Append new message to chatBox
        const chatBox = document.getElementById('chatBox');
        const div = document.createElement('div');
        div.className = 'message admin';
        div.innerHTML = `<strong>Admin:</strong><br>${message}`;
        chatBox.appendChild(div);
        chatBox.scrollTop = chatBox.scrollHeight;
    });
});

function closeChatModal() {
    document.getElementById('chatModal').style.display = 'none';
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
    display: flex;
    justify-content: space-between;
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


<div class="container-fluid">

<div class="chat-container">
    <div class="chat-header">
        <?= isset($user_id) ? "Chat with Alumni #$user_id" : "Chat Support" ?>
    </div>

    <div class="chat-box " id="chatBox">
        <?php foreach ($messages as $msg): ?>
            <div class="message <?= $msg->is_admin ? 'admin' : 'alumni' ?>">
                <strong><?= $msg->is_admin ? 'Admin' : 'You' ?>:</strong><br>
                <?= htmlspecialchars($msg->message) ?>
            </div>
        <?php endforeach; ?>
    </div>

    <form class="chat-form" method="post" action="<?= isset($user_id) ? base_url('support/admin_reply') : base_url('support/send_message') ?>">
        <?php if (isset($user_id)): ?>
            <input type="hidden" name="receiver_id" value="<?= $user_id ?>">
        <?php endif; ?>
        <textarea name="message" placeholder="Type your message..." required></textarea>
        <button type="submit">Send</button>
    </form>
</div>
</div>

<script>
    window.onload = function () {
        var chatBox = document.getElementById("chatBox");
        if (chatBox) {
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    };
</script>

<style>
.container-fluid {
    padding: 30px;
    background-color: #f4f4f4;
    min-height: 100vh;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #700A0A;
}

.chat-container {
    max-width: 800px;
    margin: 0 auto;
    border: 1px solid #ddd;
    border-radius: 12px;
    background-color: #fff;
    display: flex;
    flex-direction: column;
    height: 600px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.chat-header {
    background-color: #700A0A;
    color: white;
    padding: 15px;
    font-size: 18px;
    font-weight: bold;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
}
.chat-box {
    display: flex;
    flex-direction: column;
    padding: 20px;
    overflow-y: auto;
}

.message {
    margin-bottom: 15px;
    max-width: 70%;
    padding: 10px 15px;
    border-radius: 15px;
    word-wrap: break-word;
    line-height: 1.5;
}

.message.admin {
    background-color: #e0e0e0;
    align-self: flex-start;
    border-bottom-left-radius: 0;
}

.message.alumni {
    background-color: #700A0A;
    color: white;
    align-self: flex-end;
    margin-left: auto;
    border-bottom-right-radius: 0;
}

.chat-form {
    display: flex;
    padding: 15px;
    background-color: #f1f1f1;
    border-top: 1px solid #ddd;
    border-bottom-left-radius: 12px;
    border-bottom-right-radius: 12px;
}

.chat-form textarea {
    flex: 1;
    resize: none;
    height: 60px;
    padding: 10px;
    font-size: 14px;
    border-radius: 8px;
    border: 1px solid #ccc;
    margin-right: 10px;
    outline: none;
}

.chat-form button {
    padding: 10px 20px;
    background-color: #700A0A;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
    transition: background 0.3s;
}

.chat-form button:hover {
    background-color: #550808;
}
</style>
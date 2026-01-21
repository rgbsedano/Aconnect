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
        --light-bg: #f9f9f9;
    }

    .messages-container {
        display: flex;
        flex-direction: column;
        gap: 12px;
        padding: 16px;
        max-width: 600px;
        margin: 0 auto;
    }

    .message-wrapper {
        display: flex;
        margin: 8px 0;
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .message-wrapper.own {
        justify-content: flex-end;
    }

    .message-wrapper.other {
        justify-content: flex-start;
    }

    .message-bubble {
        max-width: 70%;
        padding: 12px 16px;
        border-radius: 16px;
        word-wrap: break-word;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        transition: all 0.3s;
    }

    .message-bubble.own {
        background: linear-gradient(135deg, var(--maroon), var(--maroon-dark));
        color: white;
        border-radius: 16px 4px 16px 16px;
    }

    .message-bubble.other {
        background: var(--light-bg);
        color: var(--text);
        border: 1px solid var(--border);
        border-radius: 4px 16px 16px 16px;
    }

    .message-bubble:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .message-text {
        font-size: 14px;
        line-height: 1.5;
        margin: 0;
    }

    .message-time {
        font-size: 11px;
        margin-top: 6px;
        opacity: 0.7;
        text-align: right;
    }

    .message-bubble.own .message-time {
        color: rgba(255,255,255,0.8);
    }

    .message-bubble.other .message-time {
        color: var(--muted);
    }

    .empty-chat {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 60px 20px;
        color: var(--muted);
        text-align: center;
        background: var(--bg);
        min-height: 300px;
    }

    .empty-chat i {
        font-size: 56px;
        color: var(--border);
        margin-bottom: 16px;
    }

    .empty-chat p {
        margin: 8px 0;
        font-size: 14px;
    }

    .empty-chat .title {
        font-size: 16px;
        font-weight: 600;
        color: var(--text);
    }
</style>

<div class="messages-container">
    <?php if (empty($messages)): ?>
        <div class="empty-chat">
            <i class="fas fa-comments"></i>
            <p class="title">No messages yet</p>
            <p>Start the conversation by sending a message</p>
        </div>
    <?php else: ?>
        <?php foreach ($messages as $msg): ?>
            <?php $isOwn = ($msg->sender_id == $this->session->userdata('alumni_id')); ?>
            <div class="message-wrapper <?= $isOwn ? 'own' : 'other' ?>">
                <div class="message-bubble <?= $isOwn ? 'own' : 'other' ?>">
                    <p class="message-text"><?= htmlspecialchars($msg->message) ?></p>
                    <div class="message-time">
                        <i class="fas fa-check-double" style="margin-right: 4px;"></i>
                        <?= date('M d, h:i A', strtotime($msg->sent_at)) ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
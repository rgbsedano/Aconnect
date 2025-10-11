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
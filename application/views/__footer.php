<?php $support_email = 'AconnectSupport@gmail.com'; ?>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->


  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="<?php echo base_url('login/logout'); ?>">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url('assets/js/jquery.easing.min.js'); ?>"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url('assets/js/sb-admin-2.min.js'); ?>"></script>
  
  <!-- Page level plugins -->
  <script src="<?php echo base_url('assets/js/Chart.min.js'); ?>"></script>
  
  <!-- chart -->
  <script src="<?php echo base_url('assets/js/demo/chart-bar-demo.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/demo/chart-pie-demo.js'); ?>"></script>
<!-- Dual Floating Chat Widgets -->
<?php if ($this->session->userdata('alumni_id')): ?>
<!-- Friends Chat (Bottom Right, Stacked Above Support) -->
<div id="friends-chat-container" style="display: none; position: fixed; bottom: 100px; right: 30px; z-index: 10000; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;">
    <button id="friends-toggle-btn" style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #a12124, #c71a25); color: white; border: none; box-shadow: 0 4px 15px rgba(161, 33, 36, 0.4); cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); position: relative;">
        <i class="fas fa-comment-dots"></i>
        <span style="position: absolute; top: -2px; right: -2px; background: #FF4444; color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 10px; font-weight: 700; display: none; align-items: center; justify-content: center;" id="friends-unread-badge">0</span>
    </button>

    <div id="friends-chat-window" style="display: none; position: absolute; bottom: 75px; right: 0; width: 380px; height: 550px; background: white; border-radius: 16px; box-shadow: 0 12px 48px rgba(0,0,0,0.15); overflow: hidden; border: 1px solid rgba(0,0,0,0.08); flex-direction: column; transform-origin: right bottom;">
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #a12124, #c71a25); color: white; padding: 16px 20px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <img id="friends-chat-avatar" src="<?= base_url('assets/images/person-male.png') ?>" style="width: 40px; height: 40px; border-radius: 50%; border: 2px solid rgba(255,255,255,0.3); display: none; object-fit: cover;">
                <div>
                    <h6 id="friends-chat-title" style="margin: 0; font-weight: 700; font-size: 16px; letter-spacing: 0.3px;">Messaging</h6>
                    <span id="friends-chat-status" style="font-size: 11px; opacity: 0.85; display: none;">Active now</span>
                </div>
            </div>
            <button id="close-friends-chat" style="background: rgba(255,255,255,0.2); border: none; color: white; cursor: pointer; font-size: 18px; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: background 0.2s;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <!-- Contacts List -->
        <div id="friends-contacts" style="flex: 1; overflow-y: auto; background: #FAFAFA;">
            <div style="padding: 16px 20px; border-bottom: 1px solid #E8E8E8; background: white;">
                <input type="text" id="friends-search" placeholder="Search conversations..." style="width: 100%; border: 1px solid #E0E0E0; border-radius: 20px; padding: 10px 16px; font-size: 14px; outline: none; transition: all 0.2s;">
            </div>
            <div id="friends-list-container" style="padding: 8px 0;">
                <div style="text-align: center; color: #999; margin-top: 80px; padding: 0 30px;">
                    <i class="fas fa-spinner fa-spin fa-2x" style="color: #a12124;"></i>
                    <p style="margin-top: 16px; font-size: 14px;">Loading your connections...</p>
                </div>
            </div>
        </div>

        <!-- Active Chat -->
        <div id="active-friends-chat" style="display: none; flex: 1; flex-direction: column; background: #F5F5F5; min-height: 0;">
            <div id="friends-chat-header" style="padding: 12px 16px; background: white; border-bottom: 1px solid #E8E8E8; display: flex; align-items: center; gap: 12px;">
                <button id="back-to-friends" style="background: transparent; border: none; color: #a12124; cursor: pointer; font-size: 18px; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: background 0.2s;">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <div style="flex: 1; font-weight: 600; font-size: 15px; color: #1a1a1a;" id="friends-chat-user-name"></div>
            </div>
            
            <div id="friends-chat-messages" style="flex: 1; overflow-y: auto; padding: 20px 16px; display: flex; flex-direction: column; gap: 12px; background: linear-gradient(to bottom, #F5F5F5, #FAFAFA); min-height: 0; height: 100%;">
                <!-- Messages load here -->
            </div>
            
            <div style="padding: 16px; background: white; border-top: 1px solid #E8E8E8; display: flex; gap: 10px; align-items: center;">
                <input type="text" id="friends-chat-input" placeholder="Type a message..." style="flex: 1; border: 1px solid #E0E0E0; border-radius: 24px; padding: 12px 18px; outline: none; font-size: 14px; background: #F8F8F8; transition: all 0.2s;">
                <button id="send-friends-btn" style="background: linear-gradient(135deg, #a12124, #c71a25); color: white; border: none; border-radius: 50%; width: 44px; height: 44px; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(161, 33, 36, 0.3); transition: all 0.2s;">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Support Chat Widget (Bottom Right) -->
<div id="support-chat-container" style="position: fixed; bottom: 25px; right: 30px; z-index: 10000; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;">
    <button id="support-toggle-btn" class="support-widget-btn">
        <i class="fas fa-headset"></i>
        <span class="support-label">AConnect Support</span>
    </button>

    <div id="support-chat-window" style="display: none; position: absolute; bottom: 80px; right: 0; width: 380px; height: 550px; background: white; border-radius: 16px; box-shadow: 0 12px 48px rgba(0,0,0,0.15); overflow: hidden; border: 1px solid rgba(0,0,0,0.08); flex-direction: column;">
        <div style="background: linear-gradient(135deg, #a12124, #7d181b); color: white; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h6 style="margin: 0; font-weight: 700; font-size: 18px; letter-spacing: 0.3px;">AConnect Support</h6>
                    <p style="margin: 4px 0 0; font-size: 12px; opacity: 0.9;">We're here to help</p>
                </div>
                <button id="close-support-chat" style="background: rgba(255,255,255,0.2); border: none; color: white; cursor: pointer; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        
        <div id="support-messages" style="flex: 1; overflow-y: auto; padding: 20px 16px; background: linear-gradient(to bottom, #F5F5F5, #FAFAFA); display: flex; flex-direction: column; gap: 12px;">
            <!-- Support messages load here -->
        </div>

        <div style="padding: 16px; background: white; border-top: 1px solid #E8E8E8; display: flex; gap: 10px; align-items: center;">
            <input type="text" id="support-input" placeholder="How can we help you?" style="flex: 1; border: 1px solid #E0E0E0; border-radius: 24px; padding: 12px 18px; outline: none; font-size: 14px; background: #F8F8F8;">
            <button id="send-support-btn" style="background: linear-gradient(135deg, #a12124, #7d181b); color: white; border: none; border-radius: 50%; width: 44px; height: 44px; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(161, 33, 36, 0.3);">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

<style>
    .support-widget-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 20px;
        border-radius: 30px;
        background: linear-gradient(135deg, #a12124, #7d181b);
        color: white;
        border: none;
        box-shadow: 0 8px 24px rgba(139, 21, 56, 0.4);
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .support-widget-btn:hover {
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 12px 32px rgba(139, 21, 56, 0.5);
    }

    .support-widget-btn .support-label {
        font-weight: 700;
        font-size: 14px;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .support-widget-btn i {
        font-size: 18px;
    }

    /* ===== Support System Notice (Modal) ===== */
    .support-notice {
        align-self: center;
        background: #fff7ed;
        border: 1px solid #fed7aa;
        color: #9a3412;
        padding: 10px 14px;
        border-radius: 14px;
        font-size: 12px;
        font-weight: 600;
        text-align: center;
        max-width: 85%;
        margin-bottom: 8px;
    }

    /* Contact Item Styling */
    #friends-chat-messages {
        scroll-behavior: smooth;
    }

    .contact-item { 
        display: flex; 
        align-items: center; 
        gap: 12px; 
        padding: 14px 20px; 
        cursor: pointer; 
        transition: all 0.2s ease;
        border-bottom: 1px solid #F0F0F0;
        background: white;
        position: relative;
    }
    .contact-item:hover { 
        background: linear-gradient(to right, #F8F8F8, #FAFAFA);
        transform: translateX(4px);
    }
    .contact-item:active {
        background: #F0F0F0;
    }
    .contact-item img {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #F0F0F0;
    }
    .contact-item-name {
        font-weight: 600;
        font-size: 14px;
        color: #1a1a1a;
        margin-bottom: 2px;
    }
    .contact-item-preview {
        font-size: 12px;
        color: #888;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    /* Message Bubbles - Modern Style */
    .fb-bubble {
        border-radius: 18px;
        padding: 10px 16px;
        max-width: 70%;
        font-size: 14px;
        line-height: 1.4;
        position: relative;
        word-wrap: break-word;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }

    .fb-sent { 
        align-self: flex-end; 
        background: linear-gradient(135deg, #a12124, #c71a25);
        color: white;
        border-bottom-right-radius: 4px;
    }
    .fb-received { 
        align-self: flex-start; 
        background: white;
        color: #1a1a1a;
        border: 1px solid #E8E8E8;
        border-bottom-left-radius: 4px;
    }
    .bubble-time { 
        font-size: 10px; 
        color: rgba(255,255,255,0.7);
        margin-top: 4px; 
        display: block;
        text-align: right;
    }
    .fb-received .bubble-time {
        color: #999;
    }

    /* Support Bubbles */
    .bubble { 
        max-width: 75%; 
        padding: 12px 16px; 
        border-radius: 18px; 
        font-size: 14px; 
        line-height: 1.4;
        position: relative;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    .bubble-sent { 
        align-self: flex-end; 
        background: linear-gradient(135deg, #a12124, #c71a25);
        color: white;
        border-bottom-right-radius: 4px;
    }
    .bubble-received { 
        align-self: flex-start; 
        background: white;
        color: #1a1a1a;
        border: 1px solid #E8E8E8;
        border-bottom-left-radius: 4px;
    }

    /* Animations */
    @keyframes messageSlideIn {
        from {
            opacity: 0;
            transform: translateY(10px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* Scrollbar Styling */
    #friends-contacts::-webkit-scrollbar,
    #friends-chat-messages::-webkit-scrollbar,
    #support-messages::-webkit-scrollbar {
        width: 6px;
    }
    #friends-contacts::-webkit-scrollbar-track,
    #friends-chat-messages::-webkit-scrollbar-track,
    #support-messages::-webkit-scrollbar-track {
        background: transparent;
    }
    #friends-contacts::-webkit-scrollbar-thumb,
    #friends-chat-messages::-webkit-scrollbar-thumb,
    #support-messages::-webkit-scrollbar-thumb {
        background: #D0D0D0;
        border-radius: 10px;
    }
    #friends-contacts::-webkit-scrollbar-thumb:hover,
    #friends-chat-messages::-webkit-scrollbar-thumb:hover,
    #support-messages::-webkit-scrollbar-thumb:hover {
        background: #B0B0B0;
    }

    /* Input Focus States */
    #friends-chat-input:focus,
    #support-input:focus,
    #friends-search:focus {
        border-color: #a12124;
        background: white;
        box-shadow: 0 0 0 3px rgba(139, 21, 56, 0.1);
    }

    /* Button Hover States */
    #friends-toggle-btn:hover,
    #support-toggle-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 28px rgba(139, 21, 56, 0.5);
    }
    #send-friends-btn:hover,
    #send-support-btn:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(139, 21, 56, 0.4);
    }
    #close-friends-chat:hover,
    #close-support-chat:hover,
    #back-to-friends:hover {
        background: rgba(255,255,255,0.3);
    }

    /* Mobile Chat Widget Fixes - Keep below navbar */
    @media (max-width: 768px) {
        .support-widget-btn {
            padding: 12px;
            width: 50px;
            height: 50px;
            justify-content: center;
            border-radius: 50%;
        }
        .support-widget-btn .support-label {
            display: none;
        }

        #friends-chat-container {
            bottom: 90px !important;
            right: 20px !important;
        }

        #support-chat-container {
            bottom: 20px !important;
            right: 20px !important;
        }

        #friends-chat-window,
        #support-chat-window {
            width: calc(100vw - 40px) !important;
            max-width: 380px !important;
            height: auto !important;
            max-height: calc(100vh - 75px - 140px) !important;
            bottom: 65px !important;
            right: 0 !important;
        }

        #support-chat-window {
            bottom: 65px !important;
            max-height: calc(100vh - 75px - 100px) !important;
        }

        #friends-chat-messages,
        #support-messages {
            max-height: calc(100vh - 75px - 280px) !important;
        }

        #friends-chat-container,
        #support-chat-container {
            top: auto !important;
            max-height: calc(100vh - 75px) !important;
        }
    }
</style>

<script>
$(document).ready(function() {
    // --- FRIENDS CHAT LOGIC ---
    let currentFriendId = null;
    let friendsPoll = null;
    let lastFriendsHash = '';

    // Handle Navbar Messaging Dropdown population
    $('.nav-item.dropdown').on('show.bs.dropdown', function(e) {
        if ($(e.target).find('#messaging-dropdown-menu').length) {
            loadMessagingDropdown();
        }
    });

    function loadMessagingDropdown(filter = 'all', search = '') {
        $.get('<?= site_url("chat/get_connections") ?>', function(res) {
            let data = typeof res === 'string' ? JSON.parse(res) : res;
            let html = ``;

            // Search filter
            if (search) {
                data = data.filter(f => 
                    (f.first_name + ' ' + f.last_name).toLowerCase().includes(search.toLowerCase())
                );
            }

            // Tabs filter logic
            if (data.length === 0) {
                html = '<div class="p-4 text-center text-muted">No connections found.</div>';
            } else {
                data.forEach(friend => {
                    let img = friend.profile_image ? '<?= base_url("assets/uploads/alumni/") ?>' + friend.profile_image : '<?= base_url("assets/images/person-male.png") ?>';
                    html += `
                        <div class="msg-item browse-friend" data-id="${friend.id}" data-name="${friend.first_name} ${friend.last_name}" data-img="${img}">
                            <img src="${img}">
                            <div class="msg-item-info">
                                <div class="msg-item-name">${friend.first_name} ${friend.last_name}</div>
                                <div class="msg-item-text">Click to message</div>
                            </div>
                        </div>
                    `;
                });
            }
            $('#msg-dropdown-list').html(html);
        });
    }

    // Filter clicks
    $('.msg-filter-btn').on('click', function(e) {
        e.stopPropagation();
        $('.msg-filter-btn').removeClass('active');
        $(this).addClass('active');
        loadMessagingDropdown($(this).data('filter'), $('#msg-search-input').val());
    });

    // Search input
    $('#msg-search-input').on('click', e => e.stopPropagation());
    $('#msg-search-input').on('input', function() {
        let filter = $('.msg-filter-btn.active').data('filter');
        loadMessagingDropdown(filter, $(this).val());
    });

    $('#friends-toggle-btn').on('click', function() {
        $('#friends-chat-window').fadeToggle(200).css('display', 'flex');
        if ($('#friends-chat-window').is(':visible')) loadFriends();
    });

    // Close button for friends chat
    $('#close-friends-chat').on('click', function() { 
        $('#friends-chat-window').fadeOut(200); 
        $('#friends-chat-container').fadeOut(200);
        stopFriendsPoll(); 
    });

    $('#back-to-friends').on('click', function() {
        $('#active-friends-chat').hide();
        $('#friends-contacts').show();
        $('#friends-chat-avatar').hide();
        $('#friends-chat-title').text('Friends Chat');
        currentFriendId = null;
        stopFriendsPoll();
        loadFriends();
    });

    function loadFriends() {
        $.get('<?= site_url("chat/get_connections") ?>', function(res) {
            let data = typeof res === 'string' ? JSON.parse(res) : res;
            let html = '';
            if (data.length === 0) {
                html = '<div style="text-align: center; color: #999; margin-top: 100px; padding: 0 30px;"><i class="fas fa-user-friends fa-3x" style="color: #DDD; margin-bottom: 16px;"></i><p style="font-size: 14px;">No connections yet</p><p style="font-size: 12px; color: #BBB;">Connect with alumni to start chatting</p></div>';
            } else {
                data.forEach(friend => {
                    let img = friend.profile_image ? '<?= base_url("assets/uploads/alumni/") ?>' + friend.profile_image : '<?= base_url("assets/images/person-male.png") ?>';
                    html += `
                        <div class="contact-item browse-friend" data-id="${friend.id}" data-name="${friend.first_name} ${friend.last_name}" data-img="${img}">
                            <img src="${img}">
                            <div style="flex: 1; min-width: 0;">
                                <div class="contact-item-name">${friend.first_name} ${friend.last_name}</div>
                                <div class="contact-item-preview">Click to start chatting</div>
                            </div>
                        </div>
                    `;
                });
            }
            $('#friends-list-container').html(html);
        });
    }

    $(document).on('click', '.browse-friend', function() {
        currentFriendId = $(this).data('id');
        let name = $(this).data('name');
        let img = $(this).data('img');

        // Ensure the chat window is visible
        if (!$('#friends-chat-window').is(':visible')) {
            $('#friends-chat-container').fadeIn(200);
            $('#friends-chat-window').fadeIn(200).css('display', 'flex');
        }

        $('#friends-chat-user-name').text(name);
        $('#friends-chat-avatar').attr('src', img).show();
        $('#friends-chat-title').text(name);
        $('#friends-contacts').hide();
        $('#active-friends-chat').show().css('display', 'flex');
        
        loadFriendsMessages();
        startFriendsPoll();
    });

    $('#send-friends-btn').on('click', sendFriendsMsg);
    $('#friends-chat-input').on('keypress', function(e) { if(e.which === 13) sendFriendsMsg(); });

    function sendFriendsMsg() {
        let msg = $('#friends-chat-input').val().trim();
        if(!msg || !currentFriendId) return;
        $.post('<?= site_url("chat/send") ?>', { receiver_id: currentFriendId, message: msg }, function() {
            $('#friends-chat-input').val('');
            loadFriendsMessages();
        });
    }

    function loadFriendsMessages() {
        if (!currentFriendId) return;

        $.get('<?= site_url("chat/get_messages_ajax/") ?>' + currentFriendId, function(res) {
            let data = typeof res === 'string' ? JSON.parse(res) : res;
            let html = '';

            data.forEach(m => {
                let isSent = m.sender_id == '<?= $this->session->userdata("alumni_id") ?>';
                let timeStr = '';

                if (m.sent_at) {
                    const parts = m.sent_at.split(/[- :]/);
                    const d = new Date(
                        parts[0],
                        parts[1] - 1,
                        parts[2],
                        parts[3],
                        parts[4],
                        parts[5] || 0
                    );
                    timeStr = d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                }

                html += `
                    <div class="fb-bubble ${isSent ? 'fb-sent' : 'fb-received'}">
                        <div class="msg-text"></div>
                        <span class="bubble-time">${timeStr}</span>
                    </div>
                `;
            });

            const container = $('#friends-chat-messages');
            const newHash = JSON.stringify(data.map(m => m.id + m.message + m.sent_at));

            if (newHash === lastFriendsHash) return;
            lastFriendsHash = newHash;

            container.html(html);
            scrollFriendsToBottom(true);

            data.forEach((m, i) => {
                container.find('.msg-text').eq(i).text(m.message);
            });
        });
    }

    function startFriendsPoll() { if(friendsPoll) clearInterval(friendsPoll); friendsPoll = setInterval(loadFriendsMessages, 5000); }
    function stopFriendsPoll() { if(friendsPoll) clearInterval(friendsPoll); friendsPoll = null; }

    // --- SUPPORT CHAT LOGIC ---
    let supportPoll = null;

    $('#support-toggle-btn').on('click', function() {
        $('#support-chat-window').fadeToggle(200).css('display', 'flex');
        if ($('#support-chat-window').is(':visible')) {
            loadSupportMessages();
            startSupportPoll();
        }
    });

    $('#close-support-chat').on('click', function() { 
        $('#support-chat-window').fadeOut(200); 
        $('#support-chat-container').fadeOut(200);
        stopSupportPoll(); 
    });

    $('#send-support-btn').on('click', sendSupportMsg);
    $('#support-input').on('keypress', function(e) { if(e.which === 13) sendSupportMsg(); });

    function sendSupportMsg() {
        let msg = $('#support-input').val().trim();
        if(!msg) return;
        $.post('<?= site_url("support/send_message_ajax") ?>', { message: msg }, function() {
            $('#support-input').val('');
            loadSupportMessages();
        });
    }

    function loadSupportMessages() {
        $.get('<?= site_url("support/get_chat_json_alumni") ?>', function(res) {
            let data = typeof res === 'string' ? JSON.parse(res) : res;
            let html = '';

            html += `
                <div class="support-notice">
                    📩 For faster assistance, please email us at:<br>
                    <strong><?= $support_email ?></strong>
                </div>
            `;

            data.forEach(m => {
                let isSent = m.is_admin == 0;
                let safeMsg = $('<div>').text(m.message).html();

                html += `
                    <div class="bubble ${isSent ? 'bubble-sent' : 'bubble-received'}">
                        ${safeMsg}
                        <span class="bubble-time">${new Date(m.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>
                    </div>
                `;
            });

            $('#support-messages').html(html);
            $('#support-messages').scrollTop($('#support-messages')[0].scrollHeight);
        });
    }

    function scrollFriendsToBottom(force = false) {
        const container = $('#friends-chat-messages')[0];
        if (!container) return;

        const isNearBottom = container.scrollHeight - container.scrollTop - container.clientHeight < 120;

        if (force || isNearBottom) {
            requestAnimationFrame(() => {
                container.scrollTop = container.scrollHeight;
            });
        }
    }

    function startSupportPoll() { if(supportPoll) clearInterval(supportPoll); supportPoll = setInterval(loadSupportMessages, 4000); }
    function stopSupportPoll() { if(supportPoll) clearInterval(supportPoll); supportPoll = null; }

    // --- MODAL AWARE HIDE LOGIC ---
    $(document).on('show.bs.modal', '.modal', function () {
        $('#support-chat-container').fadeOut(200);
    });

    $(document).on('hidden.bs.modal', '.modal', function () {
        if ($('.modal.show').length === 0) {
            $('#support-chat-container').fadeIn(200);
        }
    });

    $(document).on('click', '.open-support-chat', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $('#friends-chat-window').fadeOut(200);
        $('#support-chat-window').fadeIn(200).css('display', 'flex');
        $('#support-chat-container').fadeIn(200);
        loadSupportMessages();
        startSupportPoll();
    });

    // Expose Global Function for Profile "Message" button
    window.openDirectChat = function(friendId, name, img) {
        currentFriendId = friendId;
        $('#friends-chat-window').fadeIn(200).css('display', 'flex');
        $('#friends-chat-user-name').text(name);
        $('#friends-chat-avatar').attr('src', img || '<?= base_url("assets/images/person-male.png") ?>').show();
        $('#friends-chat-title').text(name);
        $('#friends-contacts').hide();
        $('#active-friends-chat').show().css('display', 'flex');
        loadFriendsMessages();
        startFriendsPoll();
    };
});
</script>
<?php endif; ?>

</body>
</html>
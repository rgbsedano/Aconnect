
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

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
<div id="friends-chat-container" style="position: fixed; bottom: 100px; right: 30px; z-index: 10000; font-family: 'Plus Jakarta Sans', sans-serif;">
    <button id="friends-toggle-btn" style="width: 54px; height: 54px; border-radius: 50%; background: #8B1538; color: white; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.3); cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
        <i class="fas fa-comment-dots fa-lg"></i>
    </button>

    <div id="friends-chat-window" style="display: none; position: absolute; bottom: 0; right: 70px; width: 350px; height: 500px; background: white; border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); overflow: hidden; border: 1px solid #EEE; flex-direction: column; transform-origin: right bottom;">
        <div style="background: #800020; color: white; padding: 12px 15px; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 10px;">
                <img id="friends-chat-avatar" src="<?= base_url('assets/images/person-male.png') ?>" style="width: 35px; height: 35px; border-radius: 50%; border: 2px solid white; display: none;">
                <h6 id="friends-chat-title" style="margin: 0; font-weight: 700; font-size: 15px;">Friends Chat</h6>
            </div>
            <button id="close-friends-chat" style="background: transparent; border: none; color: white; cursor: pointer; font-size: 18px;"><i class="fas fa-times"></i></button>
        </div>
        
        <div id="friends-contacts" style="flex: 1; overflow-y: auto; padding: 10px;">
            <div style="text-align: center; color: #888; margin-top: 50px;">
                <i class="fas fa-spinner fa-spin fa-2x"></i>
                <p>Loading connections...</p>
            </div>
        </div>

        <div id="active-friends-chat" style="display: none; flex: 1; flex-direction: column;">
            <div id="friends-chat-header" style="padding: 10px; border-bottom: 1px solid #EEE; display: flex; align-items: center; gap: 10px;">
                <button id="back-to-friends" style="background: transparent; border: none; color: #8B1538; cursor: pointer;"><i class="fas fa-chevron-left"></i></button>
                <div style="flex: 1; font-weight: 600; font-size: 14px;" id="friends-chat-user-name"></div>
            </div>
            <div id="friends-chat-messages" style="flex: 1; overflow-y: auto; padding: 15px; background: #FFF; display: flex; flex-direction: column; gap: 15px;">
                <!-- Messages load here -->
            </div>
            <div style="padding: 15px; border-top: 1px solid #EEE; display: flex; gap: 10px; background: #F8F9FA;">
                <input type="text" id="friends-chat-input" placeholder="Aa" style="flex: 1; border: none; border-radius: 20px; padding: 10px 15px; outline: none; font-size: 14px; background: #E9ECEF;">
                <button id="send-friends-btn" style="background: #A52A2A; color: white; border: none; border-radius: 50%; width: 40px; height: 40px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Support Chat (Bottom Right) -->
<div id="support-chat-container" style="position: fixed; bottom: 25px; right: 25px; z-index: 10000; font-family: 'Plus Jakarta Sans', sans-serif;">
    <button id="support-toggle-btn" style="width: 60px; height: 60px; border-radius: 50%; background: #8B1538; color: white; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.3); cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
        <i class="fas fa-headset fa-2x"></i>
    </button>

    <div id="support-chat-window" style="display: none; position: absolute; bottom: 80px; right: 0; width: 350px; height: 500px; background: white; border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); overflow: hidden; border: 1px solid #EEE; flex-direction: column;">
        <div style="background: #8B1538; color: white; padding: 15px; display: flex; justify-content: space-between; align-items: center;">
            <h6 style="margin: 0; font-weight: 700;">AConnect Support</h6>
            <button id="close-support-chat" style="background: transparent; border: none; color: white; cursor: pointer;"><i class="fas fa-times"></i></button>
        </div>
        
        <div id="support-messages" style="flex: 1; overflow-y: auto; padding: 15px; background: #F8F9FA; display: flex; flex-direction: column; gap: 10px;">
            <!-- Support messages load here -->
        </div>

        <div style="padding: 15px; border-top: 1px solid #EEE; display: flex; gap: 10px;">
            <input type="text" id="support-input" placeholder="How can we help?" style="flex: 1; border: 1px solid #DDD; border-radius: 20px; padding: 8px 15px; outline: none; font-size: 14px;">
            <button id="send-support-btn" style="background: #8B1538; color: white; border: none; border-radius: 50%; width: 35px; height: 35px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

<style>
    .contact-item { 
        display: flex; align-items: center; gap: 12px; padding: 12px; border-radius: 10px; cursor: pointer; transition: background 0.2s; border-bottom: 1px solid #F5F5F5;
    }
    .contact-item:hover { background: #F8F9FA; }
    
    .bubble { 
        max-width: 80%; padding: 10px 14px; border-radius: 18px; font-size: 14px; position: relative;
    }
    .bubble-sent { 
        align-self: flex-end; background: #EEE; color: #333; border-bottom-right-radius: 4px; border: 1px solid #DDD;
    }
    .bubble-received { 
        align-self: flex-start; background: #FFF; color: #333; border-bottom-left-radius: 4px; border: 1px solid #8B153820; box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .bubble-time { font-size: 10px; color: #999; margin-top: 4px; display: block; }

    /* FB Style Specific */
    .fb-bubble { border-radius: 20px; padding: 10px 15px; max-width: 75%; font-size: 14px; position: relative; }
    .fb-sent { align-self: flex-end; background: #E4E6EB; color: #050505; }
    .fb-received { align-self: flex-start; background: #FFF; border: 1px solid #E4E6EB; color: #050505; }
</style>

<script>
$(document).ready(function() {
    // --- FRIENDS CHAT LOGIC ---
    let currentFriendId = null;
    let friendsPoll = null;

    $('#friends-toggle-btn').on('click', function() {
        $('#friends-chat-window').fadeToggle(200).css('display', 'flex');
        if ($('#friends-chat-window').is(':visible')) loadFriends();
    });

    $('#close-friends-chat').on('click', function() { $('#friends-chat-window').fadeOut(200); stopFriendsPoll(); });
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
                html = '<div style="text-align: center; color: #888; margin-top: 100px;">No friends found.</div>';
            } else {
                data.forEach(friend => {
                    let img = friend.profile_image ? '<?= base_url("assets/uploads/alumni/") ?>' + friend.profile_image : '<?= base_url("assets/images/person-male.png") ?>';
                    html += `
                        <div class="contact-item browse-friend" data-id="${friend.id}" data-name="${friend.first_name} ${friend.last_name}" data-img="${img}">
                            <img src="${img}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                            <div style="flex: 1;">
                                <div style="font-weight: 700; font-size: 14px;">${friend.first_name} ${friend.last_name}</div>
                            </div>
                        </div>
                    `;
                });
            }
            $('#friends-contacts').html(html);
        });
    }

    $(document).on('click', '.browse-friend', function() {
        currentFriendId = $(this).data('id');
        let name = $(this).data('name');
        let img = $(this).data('img');

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
        if(!currentFriendId) return;
        $.get('<?= site_url("chat/get_messages_ajax/") ?>' + currentFriendId, function(res) {
            let data = typeof res === 'string' ? JSON.parse(res) : res;
            let html = '';
            data.forEach(m => {
                let isSent = m.sender_id == '<?= $this->session->userdata("alumni_id") ?>';
                html += `
                    <div class="fb-bubble ${isSent ? 'fb-sent' : 'fb-received'}">
                        ${m.message}
                        <span class="bubble-time">${new Date(m.sent_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>
                    </div>
                `;
            });
            $('#friends-chat-messages').html(html);
            $('#friends-chat-messages').scrollTop($('#friends-chat-messages')[0].scrollHeight);
        });
    }

    function startFriendsPoll() { if(friendsPoll) clearInterval(friendsPoll); friendsPoll = setInterval(loadFriendsMessages, 3000); }
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

    $('#close-support-chat').on('click', function() { $('#support-chat-window').fadeOut(200); stopSupportPoll(); });

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
            data.forEach(m => {
                let isSent = m.is_admin == 0;
                html += `
                    <div class="bubble ${isSent ? 'bubble-sent' : 'bubble-received'}">
                        ${m.message}
                        <span class="bubble-time">${new Date(m.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>
                    </div>
                `;
            });
            $('#support-messages').html(html);
            $('#support-messages').scrollTop($('#support-messages')[0].scrollHeight);
        });
    }

    function startSupportPoll() { if(supportPoll) clearInterval(supportPoll); supportPoll = setInterval(loadSupportMessages, 4000); }
    function stopSupportPoll() { if(supportPoll) clearInterval(supportPoll); supportPoll = null; }
});
</script>
<?php endif; ?>

</body>
</html>

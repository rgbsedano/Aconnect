<style>

:root {
    --brand-red: #BE123C;
    --brand-gold: #D97706;
}

body { 
    background-color: #F8FAFC;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.bg-pattern {
    background-color: #f8fafc;
    background-image: radial-gradient(#e2e8f0 0.5px, transparent 0.5px);
    background-size: 24px 24px;
}

.post-card {
    transition: all .25s ease;
    border:1px solid #e2e8f0;
}

.post-card:hover{
    transform:translateY(-4px);
    border-color:#D97706;
    box-shadow:0 12px 24px -10px rgba(190,18,60,0.1);
}

@keyframes slideUp {
    from {opacity:0; transform:translateY(20px);}
    to {opacity:1; transform:translateY(0);}
}

.animate-list{
    animation:slideUp .4s ease-out forwards;
}
.modal-dialog {
    margin-top: 10vh;
    transform: translateY(20px);
}
.modal-content{
    border-radius:16px;
    border:none;
    box-shadow:0 20px 40px rgba(0,0,0,0.15);
}

.modal-header{
    border-bottom:1px solid #f1f5f9;
}

.modal-footer{
    border-top:1px solid #f1f5f9;
}

.pagination a{
    display:inline-block;
    padding:8px 14px;
    font-size:13px;
    font-weight:600;
    border-radius:8px;
    background:#f1f5f9;
    color:#475569;
    text-decoration:none;
    transition:all .2s ease;
}

.pagination a:hover{
    background:#BE123C;
    color:white;
}

.pagination span{
    display:inline-block;
    padding:8px 14px;
}
.pagination a.active{
    background:#BE123C;
    color:white;
}
</style>


<body class="bg-pattern text-slate-900">

<nav class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-40">

<div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">

<div class="flex items-center gap-3">

<div class="w-10 h-10 bg-rose-700 rounded-xl flex items-center justify-center shadow-lg shadow-rose-200">

<i class="fas fa-comments text-amber-400"></i>

</div>

<div>

<h1 class="text-xl font-bold text-slate-900">
Forum <span class="text-rose-700">Discussions</span>
</h1>

<p class="text-[11px] font-semibold text-slate-500 uppercase tracking-widest">
Student Community
</p>

</div>

</div>

<a href="#" data-toggle="modal" data-target="#createPostModal"
class="bg-rose-700 text-white text-xs font-bold px-5 py-2 rounded-xl hover:bg-rose-800 transition shadow-md shadow-rose-100">

+ Create Post

</a>

</div>

</nav>


<main class="max-w-6xl mx-auto px-6 py-12">


<!-- SEARCH / FILTER -->

<form method="get" action="<?= base_url('forum') ?>">

<div class="bg-white p-2 rounded-2xl shadow-sm border border-slate-200 mb-10 flex flex-col md:flex-row gap-2">

<div class="flex-grow flex items-center px-4 gap-3 border-r border-slate-100">

<i class="fas fa-search text-slate-400"></i>

<input type="text"
name="search"
id="search-input"
value="<?= $this->input->get('search') ?>"
placeholder="Search forum discussions..."
class="w-full py-3 bg-transparent outline-none text-sm font-medium">

</div>

<div class="flex gap-2 p-1">

<select name="sort"
class="bg-slate-50 text-xs font-bold py-2 px-4 rounded-xl"
onchange="this.form.submit()">

<option value="">Latest</option>

<option value="likes"
<?= $this->input->get('sort')=='likes'?'selected':'' ?>>
Most Liked
</option>

<option value="comments"
<?= $this->input->get('sort')=='comments'?'selected':'' ?>>
Most Commented
</option>

<option value="myposts"
<?= $this->input->get('sort')=='myposts'?'selected':'' ?>>
My Posts
</option>

</select>

</div>

</div>

</form>


<!-- POSTS -->
<div id="forum-feed" class="space-y-4">

<?php foreach($posts as $idx => $p): ?>

<a href="<?= base_url('forum/view/'.$p->id) ?>">
<div class="post-card bg-white p-3 rounded-xl flex gap-3 animate-list"
style="animation-delay:<?= $idx * 50 ?>ms">

    <div class="w-14 h-14 rounded-xl overflow-hidden bg-slate-100 border">

        <?php if($p->is_anonymous): ?>

            <div class="w-full h-full flex items-center justify-center text-gray-400">
                <i class="fas fa-user-secret text-xl"></i>
            </div>

        <?php else: ?>

            <?php if($p->profile_image): ?>

                <img src="<?= base_url('assets/uploads/alumni/'.$p->profile_image) ?>"
                class="w-full h-full object-cover">

            <?php else: ?>

                <div class="w-full h-full flex items-center justify-center text-rose-700 font-bold">
                    <?= strtoupper(substr($p->first_name,0,1)) ?>
                </div>

            <?php endif; ?>

        <?php endif; ?>

    </div>


<div class="flex-grow">

<h3 class="text-lg font-bold text-slate-900">

<?= htmlspecialchars($p->title) ?>

</h3>



<div class="flex items-center gap-4 mt-3 text-xs text-slate-500">

<span>

👤 <?= $p->is_anonymous ? "Anonymous" : $p->first_name." ".$p->last_name ?>

</span>

<span>

❤️ <?= $p->like_count ?>

</span>

<span>

💬 <?= $p->comment_count ?>

</span>

<span>

<?= time_ago($p->created_at) ?>

</span>

</div>

</div>

</div>

</a>

<?php endforeach; ?>

</div>


<!-- PAGINATION -->

<div class="pagination flex justify-center mt-10">
<?= $pagination ?>
</div>
<!-- CREATE POST MODAL -->
<div class="modal fade" id="createPostModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Create Forum Post</h5>
                <button type="button" class="close" data-dismiss="modal">
                    &times;
                </button>
            </div>

            <form method="post" action="<?= base_url('forum/create_post') ?>" enctype="multipart/form-data">

                <div class="modal-body">

                    <div class="form-group">
                        <label>Title</label>
                        <input type="text"
                               name="title"
                               class="form-control"
                               placeholder="Enter discussion title"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Content</label>
                        <textarea name="content"
                                  class="form-control"
                                  rows="4"
                                  placeholder="Write your post..."
                                  required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Upload Image (Optional)</label>
                        <input type="file"
                               name="image"
                               class="form-control">
                    </div>

                    <div class="form-check">
                        <input type="checkbox"
                               name="anonymous"
                               value="1"
                               class="form-check-input">
                        <label class="form-check-label">
                            Post as Anonymous
                        </label>
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit"
                            class="btn btn-danger">
                        Post Discussion
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>



</main>
<script>


let timer;
let currentPage = 0;

function loadSearch(page = 0){

    let keyword = document.getElementById("search-input").value.trim();
    let sort = document.querySelector("select[name='sort']").value;

    /* If search is cleared return to normal pagination page */
    if(keyword === ""){
        window.location.href = "<?= base_url('forum') ?>";
        return;
    }

    let container = document.getElementById("forum-feed");

    /* Loading indicator */
    container.innerHTML = `
        <div class="text-center py-6 text-gray-400">
            Searching...
        </div>
    `;

    fetch(`<?= base_url('forum/live_search') ?>?search=${keyword}&sort=${sort}&page=${page}`)
    .then(res => res.json())
    .then(data => {

        container.innerHTML = "";

        if(data.posts.length === 0){
            container.innerHTML = `
                <div class="text-center py-10 text-gray-400">
                    No posts found
                </div>`;
            document.querySelector(".pagination").innerHTML = "";
            return;
        }

        data.posts.forEach(post => {

            let avatar = '';

            if(post.is_anonymous == 1){
                avatar = `
                    <div class="w-14 h-14 rounded-xl overflow-hidden bg-slate-100 border flex items-center justify-center text-gray-400">
                        <i class="fas fa-user-secret text-xl"></i>
                    </div>
                `;
            }
            else if(post.profile_image){
                avatar = `
                    <img src="<?= base_url('assets/uploads/alumni/') ?>${post.profile_image}"
                    class="w-14 h-14 rounded-xl object-cover border">
                `;
            }
            else{
                avatar = `
                    <div class="w-14 h-14 rounded-xl bg-slate-100 flex items-center justify-center text-rose-700 font-bold border">
                        ${post.first_name.charAt(0)}
                    </div>
                `;
            }

            container.innerHTML += `
            <a href="<?= base_url('forum/view/') ?>${post.id}">
                <div class="post-card bg-white p-3 rounded-xl flex gap-3">

                    ${avatar}

                    <div class="flex-grow">

                        <h3 class="text-lg font-bold text-slate-900">
                            ${post.title}
                        </h3>

                        <div class="flex items-center gap-4 mt-3 text-xs text-slate-500">

                            <span>
                                👤 ${post.is_anonymous ? 'Anonymous' : post.first_name + ' ' + post.last_name}
                            </span>

                            <span>❤️ ${post.like_count}</span>

                            <span>💬 ${post.comment_count}</span>

                        </div>

                    </div>

                </div>
            </a>
            `;

        });

        renderPagination(data.total, page);

    });

}

function renderPagination(total, currentPage){

    let perPage = 3;
    let pages = Math.ceil(total / perPage);

    let pagination = document.querySelector(".pagination");
    pagination.innerHTML = "";

    if(pages <= 1) return;

    for(let i=0;i<pages;i++){

        let link = document.createElement("a");

        link.innerText = i+1;
        link.href = "javascript:void(0)";

        if(i*perPage === currentPage){
            link.style.background = "#BE123C";
            link.style.color = "white";
        }

        link.onclick = () => loadSearch(i*perPage);

        pagination.appendChild(link);

    }

}

/* Live search typing */
document.getElementById("search-input").addEventListener("keyup", function(){

    clearTimeout(timer);

    timer = setTimeout(function(){
        loadSearch(0);
    },400);

});

</script>


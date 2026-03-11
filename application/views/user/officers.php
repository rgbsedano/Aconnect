<?php
/**
 * Alumni Officers View
 * Modernized with interactive Org Chart and Modal details
 */

$hierarchy = [
    'President' => null,
    'Vice President' => 'President',
    'Secretary' => 'Vice President',
    'Treasurer' => 'Secretary',
    'Auditor' => 'Treasurer',
    'PRO' => 'Auditor',
    'Board Member' => 'PRO'
];

$indexed = [];
foreach ($officers as $o) {
    $indexed[$o->position][] = $o;
}

function buildPositionTree($position, $hierarchy, $indexed) {
    $branch = [];
    if (!isset($indexed[$position])) return [];

    foreach ($indexed[$position] as $officer) {
        $node = [
            'data' => $officer,
            'children' => []
        ];

        foreach ($hierarchy as $child => $parent) {
            if ($parent === $position) {
                $node['children'] = array_merge(
                    $node['children'],
                    buildPositionTree($child, $hierarchy, $indexed)
                );
            }
        }
        $branch[] = $node;
    }
    return $branch;
}

// Build the tree starting from the President. 
// We explicitly take only the first result [0] to ensure only 1 tree is displayed on the page.
$fullTree = buildPositionTree('President', $hierarchy, $indexed);
$orgTree = !empty($fullTree) ? [$fullTree[0]] : [];

function renderOrg($nodes) {
?>
    <ul class="org-tree-list">
        <?php foreach ($nodes as $n): 
            $photo = !empty($n['data']->photo) ? base_url($n['data']->photo) : base_url('assets/images/person-default.png');
            $officerData = htmlspecialchars(json_encode([
                'name' => $n['data']->full_name,
                'position' => $n['data']->position,
                'email' => $n['data']->email,
                'bio' => $n['data']->bio,
                'photo' => $photo
            ]));
        ?>
        <li>
            <div class="org-card-modern" 
                 data-officer='<?= $officerData ?>'
                 onclick="openOfficerModal(this)">
                <div class="org-card-inner">
                    <div class="org-card-image">
                        <img src="<?= $photo ?>" alt="<?= htmlspecialchars($n['data']->full_name) ?>">
                    </div>
                    <div class="org-card-content">
                        <h4 class="org-card-name"><?= htmlspecialchars($n['data']->full_name) ?></h4>
                        <p class="org-card-role"><?= htmlspecialchars($n['data']->position) ?></p>
                    </div>
                </div>
            </div>

            <?php if (!empty($n['children'])): ?>
                <?php renderOrg($n['children']); ?>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
    </ul>
<?php } ?>

<style>
    :root {
        --brand-rose: #BE123C;
        --brand-amber: #D97706;
        --glass-bg: rgba(255, 255, 255, 0.9);
        --card-shadow: 0 10px 30px -10px rgba(190, 18, 60, 0.15);
        --tree-line: #e2e8f0;
    }

    body {
        background-color: #F8FAFC;
    }

    .bg-pattern {
        background-color: #f8fafc;
        background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
        background-size: 32px 32px;
    }

    .officers-container {
        padding: 30px 16px;
        max-width: 1152px;
        margin: 0 auto;
    }

    /* --- Brand Header Style --- */
    .brand-header-banner {
        background: rgba(112, 10, 10, 0.04);
        border: 1px solid rgba(112, 10, 10, 0.1);
        border-radius: 20px;
        padding: 24px 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 50px;
        flex-wrap: wrap;
        gap: 20px;
    }

    .brand-header-left {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .brand-header-icon {
        width: 56px;
        height: 56px;
        background: var(--primary-maroon);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        box-shadow: 0 8px 16px rgba(112, 10, 10, 0.2);
    }

    .brand-header-text h2 {
        margin: 0;
        font-size: 22px;
        font-weight: 700;
        color: #1a202c;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .brand-header-text h2 span {
        color: var(--primary-maroon);
        font-weight: 800;
    }

    .brand-header-sub {
        margin: 4px 0 0;
        font-size: 11px;
        font-weight: 800;
        color: #718096;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }

    .officer-count-pill {
        background: #fff;
        border: 1px solid #e2e8f0;
        padding: 8px 20px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 700;
        color: #704214;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    /* Org Tree core logic */
    .org-tree-wrapper {
        display: flex;
        justify-content: center;
        padding-top: 20px;
        overflow-x: auto;
    }

    .org-tree-list {
        padding-top: 20px;
        position: relative;
        transition: all 0.5s;
        display: flex;
        justify-content: center;
        list-style: none;
        padding-left: 0;
    }

    .org-tree-list li {
        float: left;
        text-align: center;
        list-style-type: none;
        position: relative;
        padding: 15px 5px 0 5px;
        transition: all 0.5s;
    }

    /* Lines */
    .org-tree-list li::before, .org-tree-list li::after {
        content: '';
        position: absolute;
        top: 0;
        right: 50%;
        border-top: 2px solid var(--tree-line);
        width: 50%;
        height: 20px;
    }

    .org-tree-list li::after {
        right: auto;
        left: 50%;
        border-left: 2px solid var(--tree-line);
    }

    .org-tree-list li:only-child::after, .org-tree-list li:only-child::before {
        display: none;
    }

    .org-tree-list li:only-child { padding-top: 0; }

    .org-tree-list li:first-child::before, .org-tree-list li:last-child::after {
        border: 0 none;
    }

    .org-tree-list li:last-child::before {
        border-right: 2px solid var(--tree-line);
        border-radius: 0 5px 0 0;
    }

    .org-tree-list li:first-child::after {
        border-radius: 5px 0 0 0;
    }

    .org-tree-list ul::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        border-left: 2px solid var(--tree-line);
        width: 0;
        height: 20px;
    }

    /* Modern Card Design */
    .org-card-modern {
        display: inline-block;
        background: var(--glass-bg);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        padding: 10px;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        cursor: pointer;
        min-width: 170px;
        max-width: 190px;
        position: relative;
        z-index: 2;
    }

    .org-card-modern:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 15px 45px rgba(190, 18, 60, 0.15);
        border-color: var(--brand-rose);
    }

    .org-card-inner {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
    }

    .org-card-image {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid #fff;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .org-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .org-card-content {
        text-align: center;
    }

    .org-card-name {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 700;
        color: #1a1a1a;
        line-height: 1.2;
    }

    .org-card-role {
        margin: 2px 0 0;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--brand-rose);
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    /* Modal Styling */
    .modal-officer-detail .modal-content {
        border-radius: 24px;
        border: none;
        overflow: hidden;
    }

    .modal-officer-header {
        height: 120px;
        background: linear-gradient(135deg, var(--brand-rose), #a52a2a);
        position: relative;
    }

    .modal-officer-photo {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 6px solid #fff;
        position: absolute;
        bottom: -60px;
        left: 50%;
        transform: translateX(-50%);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        object-fit: cover;
    }

    .modal-officer-body {
        padding: 80px 30px 40px;
        text-align: center;
    }

    .modal-officer-name {
        font-size: 1.8rem;
        font-weight: 800;
        color: #1a1a1a;
        margin-bottom: 5px;
    }

    .modal-officer-position {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--brand-rose);
        margin-bottom: 20px;
        text-transform: uppercase;
    }

    .modal-officer-info-item {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-bottom: 15px;
        color: #64748b;
        font-size: 0.95rem;
    }

    .modal-officer-bio {
        margin-top: 25px;
        padding-top: 25px;
        border-top: 1px solid #f1f5f9;
        color: #475569;
        line-height: 1.6;
        font-style: italic;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: #fff;
        border-radius: 24px;
        box-shadow: var(--card-shadow);
    }
</style>

<body class="bg-pattern text-slate-900 antialiased">

<nav class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-40">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-rose-700 rounded-xl flex items-center justify-center shadow-lg shadow-rose-200">
                <svg class="w-6 h-6 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M7 2a2 2 0 00-2 2v1h10V4a2 2 0 00-2-2H7zM5 7a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2V9a2 2 0 00-2-2H5z"/></svg>
            </div>
            <div>
                <h1 class="text-xl font-bold tracking-tight text-slate-900">Leadership <span class="text-rose-700">Team</span></h1>
                <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-widest">AConnect Leadership Directory</p>
            </div>
        </div>
        <div class="bg-amber-50 text-amber-700 px-3 py-1 rounded-full text-xs font-bold border border-amber-200">
            <?= !empty($officers) ? count($officers) : 0 ?> Officers
        </div>
    </div>
</nav>

<div class="officers-container">

    <?php if (!empty($officers)): ?>
        <div class="org-tree-wrapper">
            <?php renderOrg($orgTree); ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-user-tie" style="font-size: 4rem; color: #e2e8f0; margin-bottom: 20px;"></i>
            <h3>No Officers Recorded</h3>
            <p>The leadership team information is currently unavailable.</p>
        </div>
    <?php endif; ?>
</div>

<!-- Officer Detail Modal -->
<div class="modal fade modal-officer-detail" id="officerModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-officer-header">
                <button type="button" class="close" data-dismiss="modal" style="position: absolute; right: 20px; top: 15px; color: white; opacity: 0.8;">&times;</button>
                <img src="" id="modal-photo" class="modal-officer-photo" alt="Officer">
            </div>
            <div class="modal-officer-body">
                <h3 id="modal-name" class="modal-officer-name"></h3>
                <p id="modal-position" class="modal-officer-position"></p>
                
                <div class="modal-officer-info-item">
                    <i class="fas fa-envelope"></i>
                    <span id="modal-email"></span>
                </div>

                <div id="modal-bio" class="modal-officer-bio"></div>
            </div>
        </div>
    </div>
</div>

<script>
function openOfficerModal(element) {
    const data = JSON.parse(element.getAttribute('data-officer'));
    
    document.getElementById('modal-photo').src = data.photo;
    document.getElementById('modal-name').innerText = data.name;
    document.getElementById('modal-position').innerText = data.position;
    document.getElementById('modal-email').innerText = data.email || 'No email provided';
    document.getElementById('modal-bio').innerText = data.bio || 'As a dedicated officer, I am committed to fostering a strong and vibrant alumni community, bridging the gap between generations, and creating lasting connections that empower every member of our school family.';

    $('#officerModal').modal('show');
}
</script>

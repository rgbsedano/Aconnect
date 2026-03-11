<?php
/**
 * Alumni Officers View
 * Design pattern replicated from Events page with Hexagonal Org Chart
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
    // Filter out specific officers as requested
    if (in_array($o->full_name, ['3123123123', 'Maria Santos', '5555555555555555'])) {
        continue;
    }
    // Limit to only 1 officer per position for the infographic look
    if (isset($indexed[$o->position])) {
        continue;
    }
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

$orgTree = buildPositionTree('President', $hierarchy, $indexed);

// Define colors for levels
$levelColors = [
    0 => '#BE123C', // President - Red
    1 => '#0D9488', // Vice President - Teal
    2 => '#6D28D9', // Secretary - Purple
    3 => '#059669', // Treasurer - Green
    4 => '#4338CA', // Auditor - Indigo
    5 => '#374151', // PRO - Grey
    6 => '#64748B'  // Board Member - Slate
];

$level1Colors = ['#D97706', '#6D28D9', '#0D9488', '#059669'];

function renderOrgHex($nodes, $level = 0, $index = 0) {
    global $levelColors, $level1Colors;
    $color = $levelColors[$level] ?? '#64748b';
    if ($level === 1 && isset($level1Colors[$index])) {
        $color = $level1Colors[$index];
    }
?>
    <ul class="hex-tree-list level-<?= $level ?>">
        <?php foreach ($nodes as $i => $n): 
            $photo = !empty($n['data']->photo) ? base_url($n['data']->photo) : base_url('assets/images/person-default.png');
            $officerData = htmlspecialchars(json_encode([
                'name' => $n['data']->full_name,
                'position' => $n['data']->position,
                'email' => $n['data']->email,
                'bio' => $n['data']->bio,
                'photo' => $photo
            ]));
            $nodeColor = ($level === 1 && isset($level1Colors[$i])) ? $level1Colors[$i] : $color;
        ?>
        <li class="hex-item">
            <div class="hex-container" 
                 data-officer='<?= $officerData ?>'
                 onclick="openOfficerModal(this)">
                
                <div class="hex-shape-outer" style="background-color: <?= $nodeColor ?>;">
                    <div class="hex-shape-inner">
                        <img src="<?= $photo ?>" alt="<?= htmlspecialchars($n['data']->full_name) ?>">
                    </div>
                </div>

                <div class="hex-label-box" style="background: linear-gradient(90deg, <?= $nodeColor ?> 0%, <?= $nodeColor ?>dd 100%);">
                    <h4 class="hex-name"><?= htmlspecialchars($n['data']->full_name) ?></h4>
                    <p class="hex-role"><?= htmlspecialchars($n['data']->position) ?></p>
                </div>
            </div>

            <?php if (!empty($n['children'])): ?>
                <div class="hex-connector-down" style="background-color: <?= $nodeColor ?>;"></div>
                <?php renderOrgHex($n['children'], $level + 1, $i); ?>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
    </ul>
<?php } ?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    :root {
        --brand-red: #BE123C;
        --brand-gold: #D97706;
    }

    /* --- Restore Original Background Pattern --- */
    body {
        /* background-color removed to reveal global background.png */
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    
    /* Background Pattern from Events Page */
    .bg-pattern {
        /* background-color removed to reveal global background.png */
        background-image: radial-gradient(#e2e8f0 0.5px, transparent 0.5px);
        background-size: 24px 24px;
        min-height: 100vh;
    }

    .officers-content-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 48px 24px;
    }

    /* --- Hex Tree Styling --- */
    .hex-tree-wrapper {
        display: flex;
        justify-content: center;
        overflow-x: auto;
        padding-top: 40px;
        padding-bottom: 120px;
    }
    .hex-tree-list {
        display: flex; justify-content: center; list-style: none;
        padding: 0; margin: 0; position: relative;
    }
    .hex-item {
        position: relative; padding: 0 45px;
        display: flex; flex-direction: column; align-items: center;
    }
    .hex-container {
        position: relative; width: 180px; height: 200px;
        cursor: pointer; transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1); z-index: 10;
    }
    .hex-container:hover { transform: translateY(-8px) scale(1.05); }
    .hex-shape-outer {
        width: 160px; height: 180px; margin: 0 auto;
        clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
        display: flex; align-items: center; justify-content: center; padding: 5px;
    }
    .hex-shape-inner {
        width: 100%; height: 100%; background: #fff;
        clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
        overflow: hidden;
    }
    .hex-shape-inner img { width: 100%; height: 100%; object-fit: cover; }
    .hex-label-box {
        position: absolute; bottom: 40px; right: -35px;
        padding: 8px 16px; min-width: 150px; color: white;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); z-index: 11; border-radius: 4px;
        display: flex; flex-direction: column; align-items: flex-start;
    }
    .hex-name { margin: 0; font-size: 15px; font-weight: 700; white-space: nowrap; line-height: 1.2; }
    .hex-role {
        margin: 2px 0 0; font-size: 11px; font-weight: 600; color: rgba(255,255,255,0.9);
        text-align: left; width: 100%; text-transform: uppercase; letter-spacing: 0.5px;
    }
    .hex-connector-down { width: 2px; height: 60px; position: relative; margin-top: 15px; }
    .hex-connector-down::after {
        content: ''; position: absolute; bottom: -8px; left: 50%;
        transform: translateX(-50%); border-left: 6px solid transparent;
        border-right: 6px solid transparent; border-top: 10px solid inherit;
        border-top-color: inherit;
    }
    .hex-tree-list:not(.level-0)::before {
        content: ''; position: absolute; top: -40px; left: 60px; right: 60px;
        height: 2px; background: #cbd5e1;
    }
    .hex-item::before {
        content: ''; position: absolute; top: -40px; left: 50%;
        width: 2px; height: 40px; background: #cbd5e1;
    }
    .level-0 > .hex-item::before { display: none; }

    /* Modal Styling */
    .modal-officer-detail .modal-content { border-radius: 24px; border: none; overflow: hidden; }
    .modal-officer-header { height: 160px; background: #0f172a; position: relative; }
    .modal-officer-photo {
        width: 140px; height: 140px;
        clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
        border: 5px solid #fff; position: absolute; bottom: -70px; left: 50%;
        transform: translateX(-50%); background: #fff; object-fit: cover;
    }

    @media (max-width: 992px) {
        .hex-item { padding: 0 20px; }
        .hex-container { width: 150px; height: 170px; }
        .hex-shape-outer { width: 130px; height: 150px; }
        .hex-label-box { right: -20px; min-width: 120px; }
    }
</style>

<div class="bg-pattern" style="min-height: 100vh;">
    <!-- Header from Events Page Pattern -->
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

    <main class="officers-content-wrapper">
        <?php if (!empty($orgTree)): ?>
            <div class="hex-tree-wrapper">
                <?php renderOrgHex($orgTree); ?>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 100px 0; background: white; border-radius: 24px; border: 1px dashed #cbd5e1;">
                <i class="fas fa-sitemap" style="font-size: 4rem; color: #e2e8f0; margin-bottom: 20px;"></i>
                <h3 class="text-lg font-bold text-slate-900">No leadership structure found</h3>
                <p class="text-slate-500 text-sm mt-1">The organizational chart is currently being updated.</p>
            </div>
        <?php endif; ?>
    </main>
</div>

<!-- Officer Detail Modal -->
<div class="modal fade modal-officer-detail" id="officerModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow-2xl">
            <div class="modal-officer-header">
                <button type="button" class="close" data-dismiss="modal" style="position: absolute; right: 20px; top: 15px; color: white; border: none; background: none; font-size: 24px;">&times;</button>
                <img src="" id="modal-photo" class="modal-officer-photo" alt="Officer">
            </div>
            <div class="modal-officer-body" style="padding: 90px 40px 40px; text-align: center;">
                <h3 id="modal-name" style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 0;"></h3>
                <p id="modal-position" style="font-size: 15px; font-weight: 700; color: #BE123C; text-transform: uppercase; margin-top: 8px; margin-bottom: 25px;"></p>
                
                <div style="color: #64748b; font-size: 15px; display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 20px;">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span id="modal-email"></span>
                </div>

                <div id="modal-bio" style="margin-top: 25px; font-style: italic; color: #475569; line-height: 1.8; border-top: 1px solid #f1f5f9; padding-top: 25px;"></div>
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
    document.getElementById('modal-bio').innerText = data.bio || 'Dedicated to the AConnect community.';

    $('#officerModal').modal('show');
}
</script>

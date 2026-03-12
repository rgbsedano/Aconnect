<?php
$hierarchy = [
    'President' => null,
    'Vice President' => 'President',

    'Secretary' => 'Vice President',
    'Treasurer' => 'Vice President',
    'Auditor' => 'Vice President',
    'PRO' => 'Vice President',

    'Board Member' => 'Vice President'
];

$indexed = [];
foreach ($officers as $o) {
    if (in_array($o->full_name, ['3123123123', 'Maria Santos', '5555555555555555'])) {
        continue;
    }
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

$levelColors = [
    0 => '#BE123C',
    1 => '#9F1239',
    2 => '#881337',
    3 => '#E11D48',
    4 => '#FB7185',
    5 => '#BE123C',
    6 => '#9F1239'
];

$level1Colors = ['#BE123C', '#9F1239', '#881337', '#E11D48'];

function renderOrgHex($nodes, $level = 0, $index = 0, $parentColor = '#BE123C') {
    global $levelColors, $level1Colors;
    $color = $levelColors[$level] ?? '#BE123C';
    if ($level === 1 && isset($level1Colors[$index])) {
        $color = $level1Colors[$index];
    }
?>
    <ul class="hex-tree-list level-<?= $level ?>" style="--ul-line-color: <?= $parentColor ?>;">
        <?php foreach ($nodes as $i => $n): 
            $photo = !empty($n['data']->photo) ? base_url($n['data']->photo) : base_url('assets/images/person-default.png');
            $officerData = htmlspecialchars(
            json_encode([
                'name' => $n['data']->full_name,
                'position' => $n['data']->position,
                'email' => $n['data']->email,
                'bio' => $n['data']->bio,
                'photo' => $photo
            ]),
            ENT_QUOTES,
            'UTF-8'
        );
            $nodeColor = ($level === 1 && isset($level1Colors[$i])) ? $level1Colors[$i] : $color;
        ?>
        <li class="hex-item" style="--item-line-color: <?= $nodeColor ?>;">
            <div class="hex-container" 
                 data-officer='<?= $officerData ?>'
                 onclick="openOfficerModal(this)">
                
                <div class="hex-shape-outer" style="background-color: <?= $nodeColor ?>;">
                    <div class="hex-shape-inner">
                        <img src="<?= $photo ?>" alt="<?= htmlspecialchars($n['data']->full_name) ?>">
                    </div>
                </div>
            </div>

            <div class="hex-label-box">
                <h4 class="hex-name"><?= htmlspecialchars($n['data']->full_name) ?></h4>
                <p class="hex-role" style="color: <?= $nodeColor ?>;"><?= htmlspecialchars($n['data']->position) ?></p>
            </div>

            <?php if (!empty($n['children'])): ?>
                <div class="hex-connector-down" style="color: <?= $nodeColor ?>; background-color: <?= $nodeColor ?>;"></div>
                <?php renderOrgHex($n['children'], $level + 1, $i, $nodeColor); ?>
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

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    
    .bg-pattern {
        background-color: transparent;
        background-image: radial-gradient(#BE123C22 0.5px, transparent 0.5px);
        background-size: 24px 24px;
        min-height: 100vh;
    }

    .officers-content-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 48px 24px;
    }

    .hex-tree-wrapper {
        display: flex;
        justify-content: center;
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
        position: relative; width: 180px; height: 180px;
        cursor: pointer; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); z-index: 10;
        flex-shrink: 0;
    }
    .hex-container:hover { transform: translateY(-5px) scale(1.02); }
    .hex-shape-outer {
        width: 160px; height: 180px; margin: 0 auto;
        clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
        display: flex; align-items: center; justify-content: center; padding: 4px;
        transition: all 0.3s ease; border: 2px solid rgba(190, 18, 60, 0.1);
    }
    .hex-shape-inner {
        width: 100%; height: 100%; background: #fff;
        clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
        overflow: hidden;
    }
    .hex-shape-inner img { width: 100%; height: 100%; object-fit: cover; }
    /* Label is now IN THE FLOW — no absolute positioning */
    .hex-label-box {
        position: relative;
        margin-top: 14px;
        padding: 12px 24px; min-width: 220px; background: #fff;
        box-shadow: 0 10px 25px -5px rgba(139, 21, 56, 0.2); z-index: 11; border-radius: 16px;
        display: flex; flex-direction: column; align-items: center;
        border: 2px solid rgba(190, 18, 60, 0.08);
    }
    .hex-name { margin: 0; font-size: 16px; font-weight: 800; color: #BE123C; white-space: nowrap; line-height: 1.2; text-align: center; }
    .hex-role {
        margin: 4px 0 0; font-size: 11px; font-weight: 700;
        text-align: center; width: 100%; text-transform: uppercase; letter-spacing: 1.5px;
    }
    /* ── Connector: vertical line + arrowhead ── */
    .hex-connector-down {
        width: 3px;
        height: 48px;
        align-self: center;
        flex-shrink: 0;
        margin-top: 14px;
        position: relative;
        z-index: 10;
        border-radius: 2px 2px 0 0;
    }
    /* Arrowhead sits at the VERY BOTTOM of the connector bar */
    .hex-connector-down::after {
        content: '';
        position: absolute;
        bottom: -11px;     /* Sits flush below the bar */
        left: 50%;
        transform: translateX(-50%);
        width: 0; height: 0;
        border-left: 9px solid transparent;
        border-right: 9px solid transparent;
        border-top: 11px solid currentColor;
    }

    /* ── Child list: positioned below the arrow tip ── */
    /* margin-top = arrow extension (11px) + gap (8px) = 19px */
    .hex-tree-list:not(.level-0) {
        margin-top: 19px;
        position: relative;
    }

    /* Horizontal bar: spans first child's center → last child's center */
    /* Only shows when there are 2+ children */
    .hex-tree-list:not(.level-0):has(li + li)::before {
        content: '';
        position: absolute;
        top: -19px;
        left: 45px; right: 45px;
        height: 3px;
        background: var(--ul-line-color, #BE123C);
        border-radius: 2px;
    }

    /* Vertical drop from horizontal bar down to each child hex */
    .hex-tree-list:not(.level-0) > .hex-item::before {
        content: '';
        position: absolute;
        top: -19px;
        left: 50%;
        transform: translateX(-50%);
        width: 3px;
        height: 19px;
        background: var(--item-line-color, #BE123C);
        border-radius: 0 0 2px 2px;
    }

    /* ── Responsive ── */
    @media (max-width: 1024px) {
        .hex-tree-wrapper { overflow-x: auto; justify-content: flex-start; padding-left: 20px; padding-right: 20px; }
    }

    @media (max-width: 768px) {
        .hex-tree-wrapper { align-items: center; padding-bottom: 60px; overflow-x: visible; }
        .hex-tree-list { flex-direction: column; align-items: center; width: 100%; }
        .hex-item { padding: 0; width: 100%; align-items: center; }
        /* On mobile: hide horizontal bar + child drop lines; just use the connector arrow */
        .hex-tree-list:not(.level-0) { margin-top: 19px; }
        .hex-tree-list:not(.level-0) > .hex-item::before { display: none; }
        .hex-tree-list:not(.level-0)::before { display: none; }
        .hex-container { width: 150px; height: 150px; }
        .hex-shape-outer { width: 130px; height: 150px; }
        .hex-label-box { min-width: 200px; padding: 10px 16px; margin-top: 12px; }
        .hex-name { font-size: 14px; }
        .hex-role { font-size: 10px; }
        .hex-connector-down { height: 40px; margin-top: 12px; }
        .officers-content-wrapper { padding: 24px 16px; }
    }

    .modal-officer-detail .modal-content { border-radius: 32px; border: none; overflow: hidden; background: rgba(255,255,255,0.9); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.3); }
    .modal-officer-header { height: 180px; background: linear-gradient(135deg, #BE123C 0%, #881337 100%); position: relative; }
    .modal-officer-photo {
        width: 160px; height: 160px;
        border-radius: 50%;
        border: 6px solid #fff; position: absolute; bottom: -80px; left: 50%;
        transform: translateX(-50%); background: #fff; object-fit: cover;
        box-shadow: 0 10px 30px rgba(139, 21, 56, 0.2);
    }
</style>

<div class="bg-pattern" style="min-height: 100vh;">
    <nav class="bg-white/70 backdrop-blur-xl border-b border-white/20 sticky top-0 z-40 transition-all duration-300">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-rose-700 rounded-2xl flex items-center justify-center shadow-xl shadow-rose-200/50 transform rotate-3">
                    <svg class="w-7 h-7 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M7 2a2 2 0 00-2 2v1h10V4a2 2 0 00-2-2H7zM5 7a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2V9a2 2 0 00-2-2H5z"/></svg>
                </div>
                <div>
                    <h1 class="text-2xl font-black tracking-tight text-rose-950 leading-none">Leadership <span class="text-rose-700">Team</span></h1>
                    <p class="text-[10px] font-bold text-rose-700/80 uppercase tracking-[0.2em] mt-1">Directory • Core Council</p>
                </div>
            </div>
            <div class="bg-rose-700 text-white px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest shadow-lg shadow-rose-200">
                <?= !empty($officers) ? count($officers) : 0 ?> Active members
            </div>
        </div>
    </nav>

    <main class="officers-content-wrapper">
        <?php if (!empty($orgTree)): ?>
            <div class="hex-tree-wrapper">
                <?php renderOrgHex($orgTree); ?>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 80px 24px; background: rgba(255,255,255,0.5); backdrop-filter: blur(10px); border-radius: 32px; border: 2px dashed rgba(190, 18, 60, 0.2); max-width: 500px; margin: 40px auto;">
                <div class="w-20 h-20 bg-rose-50 rounded-3xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-rose-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <h3 class="text-xl font-bold text-rose-950">Structure pending</h3>
                <p class="text-rose-900/60 text-sm mt-2">The current organizational chart is being restructured for the 2026 term.</p>
            </div>
        <?php endif; ?>
    </main>
</div>

<!-- MODAL OFFICER -->
<div class="modal fade modal-officer-detail" id="officerModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content shadow-3xl">
            <div class="modal-officer-header">
                <button type="button" class="close" data-dismiss="modal" style="position: absolute; right: 24px; top: 20px; color: white; border: none; background: rgba(255,255,255,0.1); width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(4px);">&times;</button>
                <img src="" id="modal-photo" class="modal-officer-photo" alt="Officer">
            </div>
            <div class="modal-officer-body" style="padding: 100px 32px 48px; text-align: center;">
                <h3 id="modal-name" style="font-size: 32px; font-weight: 800; color: #4c0519; margin: 0; letter-spacing: -0.02em;"></h3>
                <p id="modal-position" style="font-size: 13px; font-weight: 800; color: #BE123C; text-transform: uppercase; margin-top: 10px; margin-bottom: 32px; letter-spacing: 0.1em;"></p>
                
                <div style="background: #FFF1F2; padding: 12px 24px; border-radius: 16px; color: #BE123C; font-size: 14px; display: inline-flex; align-items: center; gap: 12px; margin-bottom: 32px; border: 1px solid #FFE4E6;">
                    <svg class="w-5 h-5 text-rose-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span id="modal-email" font-weight="600"></span>
                </div>

                <div id="modal-bio" style="font-size: 16px; color: #881337; line-height: 1.8; border-top: 1px solid #ffe4e6; padding-top: 32px; font-weight: 400; text-align: center; max-width: 400px; margin: 0 auto;"></div>
            </div>
        </div>
    </div>
</div>

<script>
function openOfficerModal(element) {
    try {
        const data = JSON.parse(element.dataset.officer);

        document.getElementById('modal-photo').src = data.photo;
        document.getElementById('modal-name').innerText = data.name;
        document.getElementById('modal-position').innerText = data.position;
        document.getElementById('modal-email').innerText = data.email || 'direct@aconnect.edu';
        document.getElementById('modal-bio').innerText = data.bio || 'Leading with vision and purpose for the AConnect alumni community.';

        $('#officerModal').modal('show');
    } catch (e) {
        console.error("Modal data error:", e);
    }
}
</script>

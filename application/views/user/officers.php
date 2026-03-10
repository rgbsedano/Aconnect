<?php
$display_full_name = $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name');
$student_number = $this->session->userdata('student_number') ?: 'N/A';
?>

<?php

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

$orgTree = buildPositionTree('President', $hierarchy, $indexed);

function renderOrg($nodes) {
?>
<ul class="org-tree">
<?php foreach ($nodes as $n): ?>
<li>

<div class="org-card">

    <img src="<?= !empty($n['data']->photo)
        ? base_url($n['data']->photo)
        : base_url('assets/images/person-default.png'); ?>"
        class="org-photo">

    <div class="org-name">
        <?= htmlspecialchars($n['data']->full_name) ?>
    </div>

    <div class="org-position">
        <?= htmlspecialchars($n['data']->position) ?>
    </div>

</div>

<?php if (!empty($n['children'])): ?>
    <?php renderOrg($n['children']); ?>
<?php endif; ?>

</li>
<?php endforeach; ?>
</ul>
<?php } ?>

<script src="https://cdn.tailwindcss.com"></script>

<style>
:root {
    --primary: #8B1538;
    --primary-dark: #6B0F2A;
    --accent: #D4A574;
    --bg-page: #F8FAFC;
    --white: #FFFFFF;
    --text-main: #1F2937;
    --text-muted: #6B7280;
    --border: #E5E7EB;
    --shadow-md: 0 4px 6px rgba(0,0,0,0.07);
    --shadow-lg: 0 12px 24px rgba(0,0,0,0.12);
}

body {
    background: var(--bg-page);
    font-family: 'Plus Jakarta Sans', sans-serif;
}

/* ===== GRID ===== */
.officers-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
}

/* ===== CARD ===== */
.officer-card {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border);
    transition: all 0.3s ease;
    overflow: hidden;
    text-align: center;
}

.officer-card:hover {
    transform: translateY(-6px);
    box-shadow: var(--shadow-lg);
    border-color: var(--primary);
}

/* banner */
.card-banner {
    height: 80px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
}

/* photo */
.profile-img-container {
    width: 90px;
    height: 90px;
    margin: -45px auto 12px;
    border-radius: 50%;
    border: 5px solid #ffffff;
    overflow: hidden;
    box-shadow: 0 10px 15px rgba(0,0,0,0.1);
}

.profile-img-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* body */
.card-body {
    padding: 0 20px 24px;
}

/* position */
.officer-position {
    font-size: 12px;
    font-weight: 800;
    color: var(--primary);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 6px;
}

/* name */
.officer-name {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-main);
    margin-bottom: 6px;
}

/* email */
.officer-email {
    font-size: 13px;
    color: var(--text-muted);
}

/* empty state */
.empty-box {
    background: white;
    border-radius: 20px;
    padding: 60px 20px;
    text-align: center;
    border: 1px dashed #cbd5e1;
}
.org-wrapper {
    text-align: center;
    padding: 40px 0;
}

.org-tree {
    list-style: none;
    padding-left: 0;
    position: relative;
}

.org-tree ul {
    padding-top: 20px;
    position: relative;
}

.org-tree li {
    display: inline-block;
    text-align: center;
    vertical-align: top;
    position: relative;
    padding: 20px 10px 0 10px;
}

/* vertical line */
.org-tree li::before,
.org-tree li::after {
    content: '';
    position: absolute;
    top: 0;
    right: 50%;
    border-top: 2px solid #ccc;
    width: 50%;
    height: 20px;
}

.org-tree li::after {
    right: auto;
    left: 50%;
    border-left: 2px solid #ccc;
}

.org-tree li:only-child::after,
.org-tree li:only-child::before {
    display: none;
}

.org-tree li:only-child {
    padding-top: 0;
}

.org-tree li:first-child::before,
.org-tree li:last-child::after {
    border: 0 none;
}

.org-tree li:last-child::before {
    border-right: 2px solid #ccc;
    border-radius: 0 5px 0 0;
}

.org-tree li:first-child::after {
    border-radius: 5px 0 0 0;
}

.org-tree ul::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    border-left: 2px solid #ccc;
    width: 0;
    height: 20px;
}

/* card */
.org-card {
    background: white;
    border: 2px solid #700a0a;
    padding: 12px;
    border-radius: 14px;
    display: inline-block;
    min-width: 140px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    transition: 0.2s ease;
}

.org-card:hover {
    transform: translateY(-4px);
}

.org-photo {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 6px;
}

.org-name {
    font-weight: 700;
    font-size: 14px;
}

.org-position {
    font-size: 11px;
    color: #700a0a;
    font-weight: 600;
}
</style>
</head>

<body class="bg-pattern text-slate-900 antialiased">

<!-- ✅ HEADER -->
<nav class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-40">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold">
                Alumni <span class="text-rose-700">Officers</span>
            </h1>
            <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-widest">
                AConnect Leadership Directory
            </p>
        </div>

        <div class="bg-amber-50 text-amber-700 px-3 py-1 rounded-full text-xs font-bold border border-amber-200">
            <?= !empty($officers) ? count($officers) : 0 ?> Officers
        </div>
    </div>
</nav>


<!-- ✅ MAIN -->
<main class="max-w-6xl mx-auto px-6 py-12">

<?php if (!empty($officers)): ?>

    <div class="org-wrapper">
        <?php renderOrg($orgTree); ?>
    </div>

<?php else: ?>

    <div class="empty-box">
        <i class="fas fa-user-tie text-4xl text-slate-300 mb-3"></i>
        <h3 class="text-lg font-bold text-slate-800">No officers available</h3>
        <p class="text-sm text-slate-500 mt-1">Please check back later.</p>
    </div>

<?php endif; ?>

</main>

</body>
</html>
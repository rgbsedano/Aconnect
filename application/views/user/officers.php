<?php
$display_full_name = $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name');
$student_number = $this->session->userdata('student_number') ?: 'N/A';
?>


<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

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

    <div class="officers-grid">

        <?php foreach ($officers as $o): ?>
        <div class="officer-card">

            <div class="card-banner"></div>

            <div class="profile-img-container">
                <img src="<?= !empty($o->photo)
                    ? base_url($o->photo)
                    : base_url('assets/images/person-male.png'); ?>">
            </div>

            <div class="card-body">

                <div class="officer-position">
                    <?= htmlspecialchars($o->position) ?>
                </div>

                <h5 class="officer-name">
                    <?= ucwords(strtolower($o->full_name)) ?>
                </h5>

                <?php if (!empty($o->email)): ?>
                    <div class="officer-email">
                        <?= htmlspecialchars($o->email) ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
        <?php endforeach; ?>

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
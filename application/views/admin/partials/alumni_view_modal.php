<?php if (!empty($alumni)): ?>

<style>
/* ===== VIEW PROFILE STYLING ===== */
.profile-view-wrapper {
    padding: 10px 6px;
}

.profile-top {
    display: flex;
    align-items: center;
    gap: 18px;
    padding-bottom: 18px;
    border-bottom: 1px solid #f1f5f9;
    margin-bottom: 18px;
}

.profile-avatar {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #f1f5f9;
}

.profile-name {
    font-size: 20px;
    font-weight: 700;
    color: #1e293b;
}

.profile-sub {
    font-size: 13px;
    color: #64748b;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px 24px;
}

.info-group {
    display: flex;
    flex-direction: column;
}

.info-label {
    font-size: 11px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    margin-bottom: 4px;
}

.info-value {
    font-size: 14px;
    font-weight: 600;
    color: #1e293b;
}

@media (max-width: 768px) {
    .info-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php
$gender = strtolower(trim($alumni['gender'] ?? ''));

if (!empty($alumni['profile_image'])) {
    $photo = base_url('assets/uploads/alumni/' . $alumni['profile_image']);
} else {
    $photo = ($gender === 'female')
        ? base_url('assets/images/person-female.png')
        : base_url('assets/images/person-male.png');
}
?>

<div class="profile-view-wrapper">

    <!-- TOP PROFILE -->
    <div class="profile-top">

        <img src="<?= $photo ?>"
             class="profile-avatar"
             onerror="this.src='<?= base_url('assets/images/person-default.png') ?>'">

        <div>
            <div class="profile-name">
                <?= ucwords($alumni['first_name'].' '.$alumni['last_name']) ?>
            </div>
            <div class="profile-sub">
                Student #: <?= $alumni['student_number'] ?? '—' ?>
            </div>
            <div class="profile-sub">
                <?= ucfirst($alumni['status'] ?? 'inactive') ?>
            </div>
        </div>

    </div>

    <!-- INFO GRID -->
    <div class="info-grid">

        <div class="info-group">
            <div class="info-label">Email</div>
            <div class="info-value"><?= $alumni['email'] ?? '—' ?></div>
        </div>

        <div class="info-group">
            <div class="info-label">Alternative Email</div>
            <div class="info-value"><?= $alumni['alternative_email'] ?? '—' ?></div>
        </div>

        <div class="info-group">
            <div class="info-label">Phone</div>
            <div class="info-value"><?= $alumni['phone'] ?? '—' ?></div>
        </div>

        <div class="info-group">
            <div class="info-label">Telephone</div>
            <div class="info-value"><?= $alumni['telephone'] ?? '—' ?></div>
        </div>

        <div class="info-group">
            <div class="info-label">Gender</div>
            <div class="info-value"><?= $alumni['gender'] ?? '—' ?></div>
        </div>

        <div class="info-group">
            <div class="info-label">Degree</div>
            <div class="info-value"><?= $alumni['degree'] ?? '—' ?></div>
        </div>

        <div class="info-group">
            <div class="info-label">Graduation Year</div>
            <div class="info-value"><?= $alumni['graduation_year'] ?? '—' ?></div>
        </div>

        <div class="info-group">
            <div class="info-label">Last Login</div>
            <div class="info-value"><?= $alumni['last_login'] ?? '—' ?></div>
        </div>

    </div>

</div>

<?php else: ?>

<div class="text-center py-5 text-muted">
    Alumni not found.
</div>

<?php endif; ?>
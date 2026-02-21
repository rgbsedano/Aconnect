<div id="alumniTableWrapper">

<div class="table-responsive">
<table class="custom-table">
    <thead>
        <tr>
            <th>Alumni</th>
            <th>Status</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php if (!empty($alumni_list)): ?>

            <?php foreach ($alumni_list as $a): ?>

                <?php
                // ✅ SAFE gender handling (INSIDE loop only)
                $gender = strtolower(trim($a['gender'] ?? ''));

                if (!empty($a['profile_image'])) {
                    $photo = base_url('assets/uploads/alumni/' . $a['profile_image']);
                } else {
                    if ($gender === 'female') {
                        $photo = base_url('assets/images/person-female.png');
                    } else {
                        $photo = base_url('assets/images/person-male.png');
                    }
                }
                ?>

                <tr class="data-row view-profile"
                    data-id="<?= $a['id'] ?>"
                    style="cursor:pointer;">

                    <td>
                        <div style="display:flex;align-items:center;gap:12px;">

                            <img src="<?= $photo ?>"
                                 onerror="this.src='<?= base_url('assets/images/person-default.png') ?>'"
                                 style="width:44px;height:44px;border-radius:50%;object-fit:cover;">

                            <div>
                                <div class="user-name">
                                    <?= ucwords($a['first_name'].' '.$a['last_name']) ?>
                                </div>
                                <div class="student-id">
                                    <?= $a['student_number'] ?>
                                </div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <span class="badge-status <?= ($a['status'] ?? 'inactive') === 'active' ? 'badge-active' : 'badge-inactive' ?>">
                            <?= ucfirst($a['status'] ?? 'inactive') ?>
                        </span>
                    </td>

                    <td class="text-right">

                        <!-- EDIT -->
                        <button type="button"
                                class="btn-action edit-profile"
                                data-id="<?= $a['id'] ?>">
                            <i class="fas fa-edit"></i>
                        </button>

                        <!-- DELETE -->
                        <form method="post"
                              class="delete-form"
                              action="<?= site_url('AdminManageAccounts/delete/'.$a['id']) ?>"
                              style="display:inline;">
                            <button type="submit" class="btn-action delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>

                    </td>
                </tr>

            <?php endforeach; ?>

        <?php else: ?>
            <tr>
                <td colspan="3" class="text-center py-5" style="color: var(--text-muted);">
                    No alumni found.
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
</div>

<div class="pagination-wrapper">
    <?= $pagination ?? '' ?>
</div>

</div>
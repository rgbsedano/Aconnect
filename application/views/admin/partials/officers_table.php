<div id="officersTableWrapper">

<div class="table-responsive">
<table class="custom-table">
    <thead>
        <tr>
            <th>Officer</th>
            <th>Position</th>
            <th>Status</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php if (!empty($officers)): ?>
            <?php foreach ($officers as $o): ?>
                <tr class="data-row officer-row"
                    data-id="<?= $o->id ?>"
                    style="cursor:pointer;">

                    <td>
                        <div style="display:flex;align-items:center;gap:12px;">
                           <?php
                            // ✅ normalize gender safely
                            $gender = isset($o->gender) ? strtolower(trim($o->gender)) : '';

                            if (!empty($o->photo)) {
                                $photo = base_url($o->photo);
                            } else {
                                if ($gender === 'male') {
                                    $photo = base_url('assets/images/person-male.png');
                                } elseif ($gender === 'female') {
                                    $photo = base_url('assets/images/person-female.png');
                                } else {
                                    $photo = base_url('assets/images/person-default.png');
                                }
                            }
                            ?>

                                <img src="<?= $photo ?>"
                                    onerror="this.src='<?= base_url('assets/images/person_default.png') ?>'"
                                    style="width:44px;height:44px;border-radius:50%;object-fit:cover;">

                            <div>
                                <div class="user-name"><?= $o->full_name ?></div>
                                <div class="student-id"><?= $o->email ?></div>
                            </div>
                        </div>
                    </td>

                    <td><?= $o->position ?></td>

                    <td>
                        <span class="badge-status <?= $o->status ? 'badge-active' : 'badge-inactive' ?>">
                            <?= $o->status ? 'Active' : 'Inactive' ?>
                        </span>
                    </td>

                    <td class="text-right">

                        <button class="btn-action"
                                onclick="event.stopPropagation(); openEditOfficer(<?= $o->id ?>)">
                            <i class="fas fa-edit"></i>
                        </button>

                        <a href="<?= site_url('AdminOfficers/delete/'.$o->id) ?>"
                           class="btn-action delete"
                           onclick="event.stopPropagation(); return confirm('Delete this officer?')">
                            <i class="fas fa-trash"></i>
                        </a>

                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-center py-5" style="color: var(--text-muted);">
                    No officers found.
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
</div>

<div class="pagination-wrapper">
    <?= $pagination ?>
</div>

</div>
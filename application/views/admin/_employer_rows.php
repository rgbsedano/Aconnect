<?php defined('BASEPATH') OR exit('No direct script access allowed');

// $employers: array of employer arrays
// $status: 'pending' | 'approved' | 'rejected'

$status = isset($status) ? (string) $status : 'pending';

if (empty($employers)):
    if ($status === 'pending'):
    ?>
    <tr>
        <td colspan="5">
            <div class="empty-state">No <?php echo html_escape($status); ?> employers found.</div>
        </td>
    </tr>
    <?php else: ?>
    <tr>
        <td colspan="4">
            <div class="empty-state">No <?php echo html_escape($status); ?> employers found.</div>
        </td>
    </tr>
    <?php
    endif;
    return;
endif;

foreach ($employers as $employer):
    $company = html_escape($employer['company_name'] ?? '');
    $contact = html_escape(trim(($employer['first_name'] ?? '') . ' ' . ($employer['last_name'] ?? '')));
    $email = html_escape($employer['email'] ?? '');
    $status_val = strtolower(trim((string) ($employer['approval_status'] ?? $status)));
    $status_class = 'badge-pending';
    if ($status_val === 'approved') $status_class = 'badge-approved';
    if ($status_val === 'rejected') $status_class = 'badge-rejected';
    ?>
    <tr>
        <td>
            <div style="display:flex;align-items:center;">
                <img src="<?php echo base_url('assets/images/person-default.png'); ?>" alt="avatar" class="avatar">
                <div>
                    <div class="user-name"><?php echo $company; ?></div>
                </div>
            </div>
        </td>
        <td class="text-left">
            <div class="student-id"><?php echo $email; ?></div>
        </td>
        <td class="text-center"><?php echo $contact; ?></td>
        <td class="text-center">
            <span class="badge-status <?php echo $status_class; ?>"><?php echo html_escape(ucfirst($status_val)); ?></span>
        </td>
        <?php if ($status === 'pending'): ?>
        <td class="text-right">
            <?php echo form_open(site_url('Admin/verify_employer/' . (int) $employer['id'] . '/approve'), ['class' => 'd-inline']); ?>
                <button type="submit" class="btn-action" title="Approve"><i class="fas fa-check"></i></button>
            <?php echo form_close(); ?>

            <?php echo form_open(site_url('Admin/verify_employer/' . (int) $employer['id'] . '/reject'), ['class' => 'd-inline']); ?>
                <button type="submit" class="btn-action" title="Reject"><i class="fas fa-times"></i></button>
            <?php echo form_close(); ?>
        </td>
        <?php endif; ?>
    </tr>
<?php endforeach; 

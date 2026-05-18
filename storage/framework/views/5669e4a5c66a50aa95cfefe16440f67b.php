

<?php $__env->startSection('content'); ?>

<!-- Top Bar -->
<div class="topbar">
    <div class="topbar-title">
        <h1>Admin Dashboard</h1>
        <p>Overview of all blood donations</p>
    </div>
    <div class="topbar-right">
        <span class="date-badge">📅 <?php echo e(now()->format('F d, Y')); ?></span>
    </div>
</div>

<?php if(session('success')): ?>
<div class="alert-success">
    ✅ <?php echo e(session('success')); ?>

</div>
<?php endif; ?>
<?php if(session('error')): ?>
<div class="alert-error">
    ❌ <?php echo e(session('error')); ?>

</div>
<?php endif; ?>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon red">🩸</div>
        <div class="stat-info">
            <div class="stat-value"><?php echo e($totalDonors ?? 0); ?></div>
            <div class="stat-label">Total Donors</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue">💉</div>
        <div class="stat-info">
            <div class="stat-value"><?php echo e($totalDonations ?? 0); ?></div>
            <div class="stat-label">Total Donations</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon yellow">⏳</div>
        <div class="stat-info">
            <div class="stat-value"><?php echo e($pending ?? 0); ?></div>
            <div class="stat-label">Pending Reviews</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">✅</div>
        <div class="stat-info">
            <div class="stat-value"><?php echo e($approved ?? 0); ?></div>
            <div class="stat-label">Approved</div>
        </div>
    </div>
</div>

<!-- Donations Table -->
<div class="section-header">
    <div>
        <div class="section-title">Recent Donations</div>
        <div class="section-sub">Manage and update donation statuses</div>
    </div>
    <div style="display:flex; gap:10px;">
        <select id="statusFilter" class="search-input" style="width:150px;">
            <option value="">All Statuses</option>
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
        </select>
        <input type="text" id="searchDonation" class="search-input" placeholder="Search donors...">
    </div>
</div>

<div class="table-card">
    <table id="donationsTable">
        <thead>
            <tr>
                <th>Donor</th>
                <th>Date</th>
                <th>Packs</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $donations ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $donation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr data-status="<?php echo e(strtolower($donation->status)); ?>">
                <td>
                    <div class="donor-cell">
                        <div class="donor-avatar">
                            <?php echo e(strtoupper(substr($donation->user->name ?? 'U', 0, 1))); ?>

                        </div>
                        <div>
                            <div class="donor-name"><?php echo e($donation->user->name ?? 'Unknown'); ?></div>
                            <div class="donor-email"><?php echo e($donation->user->email ?? ''); ?></div>
                        </div>
                    </div>
                </td>
                <td><?php echo e(\Carbon\Carbon::parse($donation->donation_date)->format('M d, Y')); ?></td>
                <td><strong style="color:#1a1a1a;"><?php echo e($donation->packs); ?></strong> pack(s)</td>
                <td>
                    <span class="badge badge-<?php echo e($donation->status); ?>">
                        <?php echo e(ucfirst($donation->status)); ?>

                    </span>
                </td>
                <td>
                    <?php if($donation->status === 'approved'): ?>
                        <span style="color:#16a34a; font-weight:700; font-size: 14px; background: #f0fff4; padding: 6px 12px; border-radius: 8px;">✔ Approved</span>
                    <?php elseif($donation->status === 'rejected'): ?>
                        <span style="color:#dc2626; font-weight:700; font-size: 14px; background: #fff0f0; padding: 6px 12px; border-radius: 8px;">❌ Rejected</span>
                    <?php else: ?>
                    <form action="<?php echo e(route('admin.donations.status', $donation->id)); ?>"
                            method="POST" style="display:flex; gap:8px; align-items:center;">
                        <?php echo csrf_field(); ?>
                        <select name="status" class="status-select">
                            <option value="pending" <?php echo e($donation->status === 'pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="approved" <?php echo e($donation->status === 'approved' ? 'selected' : ''); ?>>Approve</option>
                            <option value="rejected" <?php echo e($donation->status === 'rejected' ? 'selected' : ''); ?>>Reject</option>
                        </select>
                        <button type="submit" class="update-btn">Save</button>
                    </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="5">
                    <div class="empty-state">
                        <div class="icon">📭</div>
                        <p>No donations found yet.</p>
                    </div>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    function filterDonations() {
        let textFilter = document.getElementById('searchDonation').value.toLowerCase();
        let statusFilter = document.getElementById('statusFilter').value.toLowerCase();
        let rows = document.querySelectorAll('#donationsTable tbody tr');
        
        rows.forEach(row => {
            if (row.querySelector('.empty-state')) return;
            let text = row.textContent.toLowerCase();
            let status = row.getAttribute('data-status') || '';
            
            let matchesText = text.includes(textFilter);
            let matchesStatus = statusFilter === '' || status === statusFilter;
            
            row.style.display = (matchesText && matchesStatus) ? '' : 'none';
        });
    }

    document.getElementById('searchDonation').addEventListener('keyup', filterDonations);
    document.getElementById('statusFilter').addEventListener('change', filterDonations);
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laravel\blood_donation_system\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>
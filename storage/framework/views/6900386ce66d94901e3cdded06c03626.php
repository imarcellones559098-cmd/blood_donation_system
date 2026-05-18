

<?php $__env->startSection('content'); ?>
<style>
    .new-btn {
        background: linear-gradient(135deg, #7a0000, #cc0000);
        color: white; border: none;
        padding: 10px 20px; border-radius: 12px;
        font-size: 14px; font-weight: 700;
        text-decoration: none;
        display: inline-flex; align-items: center; gap: 8px;
        transition: all 0.2s; box-shadow: 0 4px 10px rgba(204,0,0,0.2);
    }
    .new-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(204,0,0,0.3); color: white; }

    .blood-pill { display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 50%; background: #fff0f0; color: #cc0000; font-size: 12px; font-weight: 800; box-shadow: 0 2px 5px rgba(204,0,0,0.1); }
    .btn-del { padding: 6px 14px; background: #fff0f0; color: #dc2626; border: 1px solid #fecaca; border-radius: 8px; font-size: 12px; font-weight: 700; cursor: pointer; font-family: 'Inter', sans-serif; transition: all 0.2s; display: inline-flex; align-items: center; gap: 4px; }
    .btn-del:hover { background: #dc2626; color: white; transform: translateY(-1px); box-shadow: 0 2px 8px rgba(220,38,38,0.2); }
    .locked { font-size: 12px; color: #94a3b8; font-style: italic; display: flex; align-items: center; gap: 4px; font-weight: 500; }
    .admin-note { font-size: 13px; color: #64748b; font-style: italic; }
</style>

<div class="page-wrapper">

    <?php if(session('success')): ?>
        <div class="alert-success">✅ <?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert-error">❌ <?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <div class="section-header">
        <div>
            <div class="section-title">My Blood Requests</div>
            <div class="section-sub">Track all your blood requests here</div>
        </div>
        <a href="<?php echo e(route('donor.requests.create')); ?>" class="new-btn">🩸 New Request</a>
    </div>

    <div class="stats-grid" style="grid-template-columns: repeat(3, 1fr);">
        <div class="stat-card">
            <div class="stat-icon yellow">⏳</div>
            <div class="stat-info">
                <div class="stat-value"><?php echo e($requests->where('status','pending')->count()); ?></div>
                <div class="stat-label">Pending</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">✅</div>
            <div class="stat-info">
                <div class="stat-value"><?php echo e($requests->where('status','fulfilled')->count()); ?></div>
                <div class="stat-label">Fulfilled</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">❌</div>
            <div class="stat-info">
                <div class="stat-value"><?php echo e($requests->where('status','rejected')->count()); ?></div>
                <div class="stat-label">Rejected</div>
            </div>
        </div>
    </div>

    <div class="table-card">
        <?php if($requests->isEmpty()): ?>
        <div class="empty-state">
            <div class="icon">🩸</div>
            <p style="font-weight:bold; color:#334155; margin-bottom:8px;">No blood requests yet</p>
            <p style="margin-bottom:20px;">Submit a request if you or someone needs blood.</p>
            <a href="<?php echo e(route('donor.requests.create')); ?>" class="new-btn">+ Submit First Request</a>
        </div>
        <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Blood Type</th>
                    <th>Packs Needed</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Admin Notes</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td style="font-weight:bold; color:#94a3b8;"><?php echo e($i + 1); ?></td>
                    <td><span class="blood-pill"><?php echo e($req->blood_type); ?></span></td>
                    <td><strong style="font-size:16px; color:#cc0000;"><?php echo e($req->packs_needed); ?></strong> <span style="font-size:12px; color:#94a3b8;">pack(s)</span></td>
                    <td style="max-width:160px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="<?php echo e($req->reason); ?>">
                        <?php echo e($req->reason); ?>

                    </td>
                    <td><span class="badge badge-<?php echo e($req->status); ?>"><?php echo e(ucfirst($req->status)); ?></span></td>
                    <td class="admin-note"><?php echo e($req->admin_notes ?? '—'); ?></td>
                    <td style="font-size:13px; font-weight:500; color:#64748b;"><?php echo e($req->created_at->format('M d, Y')); ?></td>
                    <td>
                        <?php if($req->status === 'pending'): ?>
                        <form action="<?php echo e(route('donor.requests.destroy', $req->id)); ?>" method="POST" onsubmit="return confirm('Delete this request?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn-del">🗑️ Delete</button>
                        </form>
                        <?php else: ?>
                        <span class="locked">🔒 Locked</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.donor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laravel\blood_donation_system\resources\views/donor/requests/index.blade.php ENDPATH**/ ?>
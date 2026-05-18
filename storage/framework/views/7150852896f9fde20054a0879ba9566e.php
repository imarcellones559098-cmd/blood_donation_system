

<?php $__env->startSection('content'); ?>
<div style="max-width: 600px; margin: 40px auto 0;">
    <div class="section-header" style="margin-bottom: 24px;">
        <div>
            <div class="section-title">Record Donation</div>
            <div class="section-sub">Manually log a blood donation from a registered donor</div>
        </div>
    </div>

    <div class="table-card" style="padding: 32px;">
        <form method="POST" action="<?php echo e(route('admin.donations.store')); ?>">
            <?php echo csrf_field(); ?>
            
            <div style="margin-bottom: 20px;">
                <label class="form-label" style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px; display: block; text-transform: uppercase; letter-spacing: 0.5px;">Select Donor <span style="color:#cc0000">*</span></label>
                <select name="user_id" class="search-input" style="width: 100%; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 12px 16px; font-family: 'Inter', sans-serif; background-color: white;">
                    <option value="">-- Choose Donor --</option>
                    <?php $__currentLoopData = $donors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $donor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($donor->id); ?>"><?php echo e($donor->name); ?> (<?php echo e($donor->email); ?>)</option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span style="color:#dc2626; font-size:12px; margin-top:4px; display:block;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label class="form-label" style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px; display: block; text-transform: uppercase; letter-spacing: 0.5px;">Donation Date <span style="color:#cc0000">*</span></label>
                    <input type="date" name="donation_date" value="<?php echo e(old('donation_date', date('Y-m-d'))); ?>" class="search-input" style="width: 100%; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 12px 16px; font-family: 'Inter', sans-serif;">
                    <?php $__errorArgs = ['donation_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span style="color:#dc2626; font-size:12px; margin-top:4px; display:block;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label class="form-label" style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px; display: block; text-transform: uppercase; letter-spacing: 0.5px;">Packs Donated <span style="color:#cc0000">*</span></label>
                    <input type="number" name="packs" min="1" value="<?php echo e(old('packs')); ?>" placeholder="e.g., 1" class="search-input" style="width: 100%; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 12px 16px; font-family: 'Inter', sans-serif;">
                    <?php $__errorArgs = ['packs'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span style="color:#dc2626; font-size:12px; margin-top:4px; display:block;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label class="form-label" style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px; display: block; text-transform: uppercase; letter-spacing: 0.5px;">Initial Status <span style="color:#cc0000">*</span></label>
                <select name="status" class="search-input" style="width: 100%; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 12px 16px; font-family: 'Inter', sans-serif; background-color: white;">
                    <option value="pending" <?php echo e(old('status', 'pending') == 'pending' ? 'selected' : ''); ?>>Pending (Needs Approval Later)</option>
                    <option value="approved" <?php echo e(old('status') == 'approved' ? 'selected' : ''); ?>>Approved (Instantly Fulfills)</option>
                    <option value="rejected" <?php echo e(old('status') == 'rejected' ? 'selected' : ''); ?>>Rejected</option>
                </select>
                <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span style="color:#dc2626; font-size:12px; margin-top:4px; display:block;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div style="margin-bottom: 32px;">
                <label class="form-label" style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px; display: block; text-transform: uppercase; letter-spacing: 0.5px;">Additional Notes</label>
                <textarea name="notes" rows="4" placeholder="Any medical observations or remarks..." class="search-input" style="width: 100%; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 12px 16px; font-family: 'Inter', sans-serif; resize: vertical;"><?php echo e(old('notes')); ?></textarea>
                <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span style="color:#dc2626; font-size:12px; margin-top:4px; display:block;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div style="display: flex; gap: 12px; align-items: center; padding-top: 24px; border-top: 1px solid #f1f5f9;">
                <button type="submit" style="background: linear-gradient(135deg, #7a0000, #cc0000); color: white; border: none; padding: 12px 32px; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 10px rgba(204,0,0,0.2); font-family: 'Inter', sans-serif;">
                    ✔ Save Donation
                </button>
                <a href="<?php echo e(route('admin.dashboard')); ?>" style="color: #64748b; text-decoration: none; font-size: 14px; font-weight: 600; padding: 12px 24px; border-radius: 12px; transition: all 0.2s; border: 1px solid transparent; background: #f8f9fb; text-align: center;">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    .search-input:focus { border-color: #cc0000 !important; box-shadow: 0 0 0 3px rgba(204,0,0,0.1) !important; outline: none; }
    button[type="submit"]:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(204,0,0,0.3) !important; }
    a[href]:hover { background: #f1f5f9 !important; border-color: #e2e8f0 !important; color: #334155 !important; }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laravel\blood_donation_system\resources\views/admin/donations/create.blade.php ENDPATH**/ ?>
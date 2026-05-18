

<?php $__env->startSection('content'); ?>
<div style="max-width: 600px; margin: 40px auto 0;">
    <div class="section-header" style="margin-bottom: 24px;">
        <div>
            <div class="section-title">Submit Blood Request</div>
            <div class="section-sub">Fill in the details below to request blood for yourself or someone else</div>
        </div>
    </div>

    <div class="table-card" style="padding: 32px;">
        <form method="POST" action="<?php echo e(route('donor.requests.store')); ?>">
            <?php echo csrf_field(); ?>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label class="form-label" style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px; display: block; text-transform: uppercase; letter-spacing: 0.5px;">Blood Type <span style="color:#cc0000">*</span></label>
                    <select name="blood_type" class="search-input" style="width: 100%; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 12px 16px; font-family: 'Inter', sans-serif; background-color: white;">
                        <option value="">-- Select --</option>
                        <?php $__currentLoopData = ['A+','A-','B+','B-','AB+','AB-','O+','O-']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($type); ?>" <?php echo e(old('blood_type') == $type ? 'selected' : ''); ?>><?php echo e($type); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['blood_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span style="color:#dc2626; font-size:12px; margin-top:4px; display:block;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label class="form-label" style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px; display: block; text-transform: uppercase; letter-spacing: 0.5px;">Packs Needed <span style="color:#cc0000">*</span></label>
                    <input type="number" name="packs_needed" min="1" value="<?php echo e(old('packs_needed')); ?>" placeholder="e.g. 2" class="search-input" style="width: 100%; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 12px 16px; font-family: 'Inter', sans-serif;">
                    <?php $__errorArgs = ['packs_needed'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span style="color:#dc2626; font-size:12px; margin-top:4px; display:block;"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div style="margin-bottom: 32px;">
                <label class="form-label" style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px; display: block; text-transform: uppercase; letter-spacing: 0.5px;">Reason for Request <span style="color:#cc0000">*</span></label>
                <textarea name="reason" rows="4" placeholder="Briefly explain why you need blood..." class="search-input" style="width: 100%; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 12px 16px; font-family: 'Inter', sans-serif; resize: vertical;"><?php echo e(old('reason')); ?></textarea>
                <?php $__errorArgs = ['reason'];
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
                    ✔ Submit Request
                </button>
                <a href="<?php echo e(route('donor.requests.index')); ?>" style="color: #64748b; text-decoration: none; font-size: 14px; font-weight: 600; padding: 12px 24px; border-radius: 12px; transition: all 0.2s; border: 1px solid transparent; background: #f8f9fb; text-align: center;">
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

<?php echo $__env->make('layouts.donor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laravel\blood_donation_system\resources\views/donor/requests/create.blade.php ENDPATH**/ ?>
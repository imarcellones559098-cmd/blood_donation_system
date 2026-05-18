

<?php $__env->startSection('content'); ?>
<style>
    .profile-header {
        background: linear-gradient(135deg, #7a0000 0%, #cc0000 100%);
        border-radius: 20px;
        padding: 36px 40px;
        display: flex;
        align-items: center;
        gap: 28px;
        margin-bottom: 32px;
        position: relative;
        overflow: hidden;
    }

    .profile-header::before {
        content: ''; position: absolute; top: -40px; right: -40px;
        width: 180px; height: 180px; background: rgba(255,255,255,0.06); border-radius: 50%;
    }

    .profile-header::after {
        content: ''; position: absolute; bottom: -60px; right: 60px;
        width: 240px; height: 240px; background: rgba(255,255,255,0.04); border-radius: 50%;
    }

    .profile-avatar {
        width: 80px; height: 80px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        border: 3px solid rgba(255,255,255,0.4);
        display: flex; align-items: center; justify-content: center;
        font-size: 32px; font-weight: 800; color: white;
        flex-shrink: 0; position: relative; z-index: 1;
    }

    .profile-header-info { position: relative; z-index: 1; }
    .profile-header-info h2 { font-size: 24px; font-weight: 800; color: white; margin: 0 0 4px; }
    .profile-header-info p { font-size: 14px; color: rgba(255,255,255,0.65); margin: 0 0 10px; }

    .blood-type-chip { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.3); border-radius: 20px; padding: 4px 14px; font-size: 13px; font-weight: 700; color: white; }

    .profile-card { background: white; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid rgba(0,0,0,0.02); overflow: hidden; }
    .profile-card-header { padding: 24px 32px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between; background: #f8f9fb; }
    .profile-card-header h3 { font-size: 16px; font-weight: 800; color: #1a1a1a; letter-spacing: -0.3px; }
    .profile-card-header p { font-size: 13px; color: #64748b; margin-top: 4px; }

    .edit-badge { background: #fff0f0; color: #cc0000; font-size: 12px; font-weight: 600; padding: 6px 14px; border-radius: 20px; border: 1px solid #ffcccc; display: inline-flex; align-items: center; gap: 4px; }

    .profile-form { padding: 32px; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px; }
    .form-group { display: flex; flex-direction: column; gap: 8px; }
    .form-group.full-width { grid-column: 1 / -1; }

    .form-label { font-size: 13px; font-weight: 700; color: #334155; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center; gap: 6px; }
    .form-label .required { color: #cc0000; font-size: 14px; }
    .form-label .icon { font-size: 15px; }

    .form-input { width: 100%; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 12px 16px; font-size: 14px; color: #1e293b; background: white; transition: all 0.2s; outline: none; font-family: 'Inter', sans-serif; font-weight: 500; }
    .form-input:focus { border-color: #cc0000; box-shadow: 0 0 0 3px rgba(204,0,0,0.1); }
    .form-input:disabled { background: #f8fafc; color: #94a3b8; cursor: not-allowed; border-color: #e2e8f0; }

    .form-input select, select.form-input { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748b' d='M6 8L1 3h10z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 16px center; padding-right: 40px; }
    textarea.form-input { resize: vertical; min-height: 100px; }

    .form-divider { border: none; border-top: 1px solid #f1f5f9; margin: 12px 0 32px; }
    .section-label { font-size: 12px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px; }
    .section-label::after { content: ''; flex: 1; height: 1px; background: #f1f5f9; }

    .form-footer { display: flex; align-items: center; justify-content: space-between; padding: 24px 32px; background: #f8f9fb; border-top: 1px solid #f1f5f9; }
    .form-footer p { font-size: 13px; color: #64748b; font-weight: 500; }

    .save-btn { background: linear-gradient(135deg, #7a0000, #cc0000); color: white; border: none; padding: 12px 32px; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 8px; font-family: 'Inter', sans-serif; box-shadow: 0 4px 10px rgba(204,0,0,0.2); }
    .save-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(204,0,0,0.3); }

    .error-msg { font-size: 12px; color: #dc2626; margin-top: 4px; font-weight: 500; }
</style>

<div class="page-wrapper">

    
    <div class="profile-header">
        <div class="profile-avatar">
            <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

        </div>
        <div class="profile-header-info">
            <h2><?php echo e(auth()->user()->name); ?></h2>
            <p><?php echo e(auth()->user()->email); ?></p>
            <?php if(optional($profile)->blood_type): ?>
                <div class="blood-type-chip">🩸 Blood Type: <?php echo e($profile->blood_type); ?></div>
            <?php else: ?>
                <div class="blood-type-chip">🩸 Blood Type: Not set</div>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="profile-card">
        <div class="profile-card-header">
            <div>
                <h3>Personal Information</h3>
                <p>Update your donor profile details below</p>
            </div>
            <span class="edit-badge">✏️ Editable</span>
        </div>

        <form action="<?php echo e(route('donor.profile.update')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="profile-form">

                
                <div class="section-label">Account Info</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">
                            <span class="icon">👤</span> Full Name
                        </label>
                        <input type="text" class="form-input" value="<?php echo e(auth()->user()->name); ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label class="form-label">
                            <span class="icon">📧</span> Email Address
                        </label>
                        <input type="email" class="form-input" value="<?php echo e(auth()->user()->email); ?>" disabled>
                    </div>
                </div>

                <hr class="form-divider">

                
                <div class="section-label">Medical Info</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">
                            <span class="icon">🩸</span> Blood Type
                            <span class="required">*</span>
                        </label>
                        <select name="blood_type" required class="form-input">
                            <option value="">-- Select Blood Type --</option>
                            <?php $__currentLoopData = ['A+','A-','B+','B-','AB+','AB-','O+','O-']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($type); ?>" <?php echo e(optional($profile)->blood_type === $type ? 'selected' : ''); ?>>
                                    <?php echo e($type); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['blood_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="error-msg"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <span class="icon">⚧</span> Gender
                        </label>
                        <select name="gender" class="form-input">
                            <option value="">-- Select Gender --</option>
                            <option value="Male" <?php echo e(optional($profile)->gender === 'Male' ? 'selected' : ''); ?>>Male</option>
                            <option value="Female" <?php echo e(optional($profile)->gender === 'Female' ? 'selected' : ''); ?>>Female</option>
                        </select>
                    </div>
                </div>

                <hr class="form-divider">

                
                <div class="section-label">Contact & Personal Info</div>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">
                            <span class="icon">📱</span> Contact Number
                            <span class="required">*</span>
                        </label>
                        <input type="text" name="contact_number" required
                               class="form-input"
                               placeholder="e.g. 09123456789"
                               value="<?php echo e(optional($profile)->contact_number); ?>">
                        <?php $__errorArgs = ['contact_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="error-msg"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <span class="icon">🎂</span> Date of Birth
                        </label>
                        <input type="date" name="date_of_birth"
                               class="form-input"
                               value="<?php echo e(optional($profile)->date_of_birth); ?>">
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">
                            <span class="icon">📍</span> Address
                        </label>
                        <textarea name="address" class="form-input"
                                  placeholder="Your full address..."><?php echo e(optional($profile)->address); ?></textarea>
                    </div>
                </div>

            </div>

            <div class="form-footer">
                <p>Fields marked with <strong style="color:#cc0000">*</strong> are required</p>
                <button type="submit" class="save-btn">
                    💾 Save Profile
                </button>
            </div>

        </form>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.donor', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laravel\blood_donation_system\resources\views/donor/profile.blade.php ENDPATH**/ ?>
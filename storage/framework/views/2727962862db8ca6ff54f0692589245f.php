<?php echo method_field('PUT'); ?>
<div class="">
    <div class="row">
        <input type="hidden" name="category" value="<?php echo e($category); ?>">
        <?php $__currentLoopData = $business_settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="<?php if($setting->input_type=='textarea' || $setting->key=='location_map_url'): ?> col-md-12 <?php else: ?> col-md-6 <?php endif; ?> mb-3">
                <label class="form-label"><?php echo e(ucwords(str_replace('_', ' ', $setting->key))); ?></label>

                <?php switch($setting->input_type):
                    case ('textarea'): ?>
                        <textarea class="form-control" name="settings[<?php echo e($setting->key); ?>]"><?php echo e($setting->value); ?></textarea>
                        <?php break; ?>

                    <?php case ('file'): ?>
                        <input type="file" class="form-control uploader" id="<?php echo e($setting->key); ?>" name="settings[<?php echo e($setting->key); ?>]">
                        <?php if($setting->value): ?>
                            <span>
                                <img style="width:120px" src="<?php echo e(asset('storage/'.$setting->value)); ?>" alt="<?php echo e($setting->key); ?>">
                            </span>
                        <?php else: ?>
                            <span id="preview-<?php echo e($setting->key); ?>"></span>
                        <?php endif; ?>
                        <?php break; ?>

                    <?php case ('checkbox'): ?>
                        <div class="form-check">
                            <input type="hidden" name="settings[<?php echo e($setting->key); ?>]" value="0">
                            <input type="checkbox" class="form-check-input" id="check_<?php echo e($setting->key); ?>"
                                name="settings[<?php echo e($setting->key); ?>]" value="1"
                                <?php echo e($setting->value ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="check_<?php echo e($setting->key); ?>">Enabled</label>
                        </div>
                        <?php break; ?>

                    <?php case ('select'): ?>
                        <?php if($setting->key=='timezone'): ?>
                            <select name="settings[<?php echo e($setting->key); ?>]" class="form-select w-auto">
                                <option value="">Select <?php echo e($setting->key); ?></option>
                                <?php $__currentLoopData = getTimeZone(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $timezone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($timezone); ?>" <?php echo e($setting->value==$timezone?'selected':''); ?>><?php echo e($timezone); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        <?php else: ?>
                            <select name="settings[<?php echo e($setting->key); ?>]" class="form-select w-auto">
                                <option value="">Select <?php echo e($setting->key); ?></option>
                            </select>
                        <?php endif; ?>
                        <?php break; ?>

                    <?php case ('time'): ?>
                    <?php case ('email'): ?>
                    <?php case ('url'): ?>
                    <?php case ('number'): ?>
                    <?php case ('text'): ?>
                        <?php if($setting->key=='phone_number'): ?>
                            <input type="text" 
                                class="form-control phoneNumber" 
                                name="settings[<?php echo e($setting->key); ?>]" 
                                value="<?php echo e($setting->value); ?>">
                        <?php else: ?>
                            <input type="text" 
                                class="form-control" 
                                name="settings[<?php echo e($setting->key); ?>]" 
                                value="<?php echo e($setting->value); ?>">
                        <?php endif; ?>
                        <?php break; ?>
                        
                    <?php default: ?>
                        <input type="<?php echo e($setting->input_type ?? 'text'); ?>"
                            class="form-control"
                            name="settings[<?php echo e($setting->key); ?>]"
                            value="<?php echo e($setting->value); ?>">
                <?php endswitch; ?>

            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<script>
    $('select').each(function () {
        $(this).select2({
            dropdownParent: $(this).parent(),
        });
    });
</script><?php /**PATH C:\xampp\htdocs\dynamic-admin-panel\resources\views/admin/settings/edit_content.blade.php ENDPATH**/ ?>
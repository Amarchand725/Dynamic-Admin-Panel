<?php echo method_field('PUT'); ?>
<input type="hidden" name="pre_menu" value="<?php echo e($menu->menu); ?>">
<input type="hidden" name="field_order" id="field_order">

<script>
    const FIELD_TYPES = <?php echo json_encode(fieldTypes(), 15, 512) ?>;
    const INPUT_TYPES = <?php echo json_encode(inputTypes(), 15, 512) ?>;
    const FIELD_ATTRS = ['required', 'index_visible', 'create_visible', 'edit_visible', 'show_visible'];
</script>

<div class="row" data-init="dynamic-fields">
    <!-- Vertical Icons Wizard -->
    <div class="col-12 mb-4">
      <div class="d-flex justify-content-between align-items-center">
          <small class="text-light fw-semibold">Menu Fields</small>
          <button type="button" id="add-field" class="btn btn-success btn-sm">+ Add Field</button>
      </div>
      <div class="bs-stepper vertical wizard-vertical-icons-example mt-2">
        <div class="bs-stepper-header" id="stepperTabs">
            <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="step" data-target="#<?php echo e($field['name']); ?>">
                    <button type="button" class="step-trigger">
                        <span class="bs-stepper-circle">
                            <i class="ti ti-file-description"></i>
                        </span>
                        <span class="bs-stepper-label">
                            <span class="bs-stepper-title"><?php echo e($field['label'] ?? ''); ?></span>
                            <span class="bs-stepper-subtitle">Setup <?php echo e($field['label'] ?? ''); ?> </span>
                        </span>
                    </button>
                    <button type="button" class="btn btn-sm text-danger remove-field ms-1" data-name="<?php echo e($field['name']); ?>">×</button>
                </div>
                <div class="line"></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="bs-stepper-content" id="stepperContent">
            <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div id="<?php echo e($field['name']); ?>" class="content">
                    <div class="content-header mb-3">
                        <h6 class="mb-0"><?php echo e($field['label'] ?? ucfirst($name)); ?></h6>
                        <small>Enter <?php echo e($field['label'] ?? $name); ?> Settings.</small>
                    </div>
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label>Field Name</label>
                                <input type="text" name="fields[<?php echo e($field['name']); ?>][name]" value="<?php echo e($field['name']); ?>" class="form-control w-full">
                            </div>
                            <div class="mb-3">
                                <label>Data Type</label>
                                <select name="fields[<?php echo e($field['name']); ?>][type]" class="form-select w-full">
                                    <option value="" selected>Select Data Type</option>
                                    <?php $__currentLoopData = fieldTypes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$fieldType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key); ?>" <?php echo e($field['type']==$key ? 'selected' : ''); ?>><?php echo e($fieldType); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Input Type</label>
                                <select name="fields[<?php echo e($field['name']); ?>][input_type]" class="form-select w-full">
                                    <option value="" selected>Select Input Type</option>
                                    <?php $__currentLoopData = inputTypes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$inputType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key); ?>" <?php echo e($field['input_type']==$key ? 'selected' : ''); ?>><?php echo e($inputType); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Label</label>
                                <input type="text" name="fields[<?php echo e($field['name']); ?>][label]" value="<?php echo e($field['label']); ?>" class="form-control w-full">
                            </div>
                            <div class="mb-3">
                                <label>Placeholder</label>
                                <input type="text" name="fields[<?php echo e($field['name']); ?>][placeholder]" value="<?php echo e($field['placeholder']); ?>" class="form-control w-full">
                            </div>
                            <?php $__currentLoopData = ['required', 'index_visible', 'create_visible', 'edit_visible', 'show_visible']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="mb-2">
                                    <label>
                                        <input type="checkbox" name="fields[<?php echo e($field['name']); ?>][<?php echo e($attr); ?>]" value="1" <?php echo e(!empty($field[$attr]) ? 'checked' : ''); ?>>
                                        <?php echo e(ucfirst(str_replace('_', ' ', $attr))); ?>

                                    </label>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                            <div class="mb-3">
                                <label>Extra (JSON)</label>
                                <?php
                                    $extraFormatted = is_array($field['extra']) 
                                        ? json_encode($field['extra'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
                                        : $field['extra'];
                                ?>

                                <textarea name="fields[<?php echo e($field['name']); ?>][extra]" placeholder='{"validation":"max:255"}' class="form-control w-full" rows="3"><?php echo e($extraFormatted); ?></textarea>
                                <small class="text-muted">Enter valid JSON. Example: {"validation":"max:255"}</small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
    </div>
</div><?php /**PATH C:\xampp\htdocs\dynamic-admin-panel\resources\views/admin/menu_fields/edit_content.blade.php ENDPATH**/ ?>
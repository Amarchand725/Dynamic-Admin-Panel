<table class="table table-flush-spacing">
    <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td class="text-nowrap fw-semibold"><?php echo e($field['label'] ?? ucfirst($name)); ?></td>
            <td>
                <?php if($field['type'] === 'file'): ?>
                    <?php if(!empty($field['value'])): ?>
                        <img src="<?php echo e(asset('storage/' . $field['value'])); ?>" width="80">
                    <?php endif; ?>
                <?php elseif($name === 'status'): ?>
                    <span class="badge bg-label-<?php echo e($model->status ? 'success' : 'danger'); ?>">
                        <?php echo e($model->status ? 'Active' : 'Deactive'); ?>

                    </span>
                <?php elseif($name === 'fields'): ?>
                    <?php $tableFields = $model->hasMenFields; ?> 
                    <table class="table">
                        <tr>
                            <th><strong>Field Name</strong></th>
                            <th><strong>Data Type</strong></th>
                            <th><strong>Input Type</strong></th>
                        </tr>
                        <?php if(isset($tableFields) && !empty($tableFields)): ?>
                            <?php $__currentLoopData = $tableFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tableKey=>$tableField): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e(ucfirst($tableField->name) ?? '-'); ?></td>
                                    <td><?php echo e(ucfirst($tableField->data_type ?? '-')); ?></td>
                                    <td><?php echo e(ucfirst($tableField->input_type ?? '-')); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </table>
                <?php else: ?>
                    <?php if($name=='menu_group'): ?>
                        <?php if(isset($model->hasMenuGroup) && !empty($model->hasMenuGroup)): ?>
                            <?php echo e(ucfirst($model->hasMenuGroup->menu ?? '-')); ?>

                        <?php else: ?>
                            -
                        <?php endif; ?>
                    <?php elseif($name=='icon'): ?>
                        <i class="menu-icon tf-icons <?php echo e($model->icon ?? '-'); ?>"></i>
                    <?php else: ?>
                        <?php echo ucfirst($field['value'] ?? '-'); ?>

                    <?php endif; ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>
<?php /**PATH C:\xampp\htdocs\dynamic-admin-panel\resources\views/admin/menus/show_content.blade.php ENDPATH**/ ?>
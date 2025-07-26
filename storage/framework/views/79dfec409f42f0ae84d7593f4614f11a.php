<?php
    $isChild = $menu->menu_group !== null;
?>

<li class="list-group-item lh-1 d-flex flex-column align-items-start border rounded mb-1 shadow-sm" data-id="<?php echo e($menu->id); ?>">
    <div class="w-100 d-flex justify-content-between align-items-center">
        <span class="d-flex align-items-center gap-2">
            <?php if($isChild): ?>
                <i class="drag-handle cursor-move ti ti-chevron-right text-muted"></i>
            <?php else: ?>
                <i class="drag-handle cursor-move <?php echo e($menu->icon); ?> text-primary"></i>
            <?php endif; ?>
            <strong><?php echo e($menu->menu_label); ?></strong>
        </span>
    </div>

    <?php if($menu->children && $menu->children->count()): ?>
        <ul class="list-group list-group-flush nested-sortable ms-4 mt-2 w-100 ps-2 border-start border-2 border-primary">
            <?php $__currentLoopData = $menu->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('admin.menus._menu-item', ['menu' => $child], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php endif; ?>
</li><?php /**PATH C:\xampp\htdocs\dynamic-admin-panel\resources\views/admin/menus/_menu-item.blade.php ENDPATH**/ ?>
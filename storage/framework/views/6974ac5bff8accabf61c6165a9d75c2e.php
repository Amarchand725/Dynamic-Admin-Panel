<?php $__env->startSection('title', $title.' -  ' . appName()); ?>
<?php $__env->startPush('css'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<style>
    .list-group-item {
        transition: background-color 0.2s ease-in-out;
    }
    .list-group-item:hover {
        background-color: #f8f9fa;
    }

    .drag-handle {
        cursor: move;
    }

    .nested-sortable .list-group-item {
        border-radius: 0.375rem;
    }

    .nested-sortable > li {
        background: #ffffff;
    }

    .sortable-chosen {
        background-color: #e9ecef !important;
    }

    .sortable-ghost {
        opacity: 0.5;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Extended UI /</span> Drag &amp; Drop</h4>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-12 mb-md-0 mb-4">
                                    <ul class="list-group list-group-flush nested-sortable" data-parent="<?php echo e($menu->id ?? ''); ?>">
                                        <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo $__env->make('admin.menus._menu-item', ['menu' => $menu], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
<script src="<?php echo e(asset('admin')); ?>/assets/vendor/libs/sortablejs/sortable.js"></script>
<script src="<?php echo e(asset('admin')); ?>/assets/js/extended-ui-drag-and-drop.js"></script>
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<script>
    document.querySelectorAll('.nested-sortable').forEach(function(el) {
        new Sortable(el, {
            group: 'nested', // allow drag between levels
            handle: '.drag-handle',
            animation: 150,
            fallbackOnBody: true,
            swapThreshold: 0.65,
            onEnd: function () {
                let updatedHierarchy = buildHierarchy(document.querySelector('.nested-sortable'));
                saveMenuHierarchy(updatedHierarchy);
            }
        });
    });

    function buildHierarchy(container, parentId = null) {
        let data = [];
        container.querySelectorAll(':scope > li').forEach((li, index) => {
            let id = li.dataset.id;
            let childList = li.querySelector(':scope > ul');
            data.push({
                id: id,
                menu_group: parentId,
                order_group: index + 1,
                children: childList ? buildHierarchy(childList, id) : []
            });
        });
        return data;
    }

    function saveMenuHierarchy(hierarchy) {
        fetch("<?php echo e(route('menus.reorder')); ?>", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({ hierarchy })
        }).then(res => res.json()).then(res => {
            console.log('Updated', res);
            // Optional: Show toast
            Toastify({
                text: "Menu hierarchy updated successfully!",
                duration: 3000,
                gravity: "top",
                position: "right",
                backgroundColor: "#28a745",
            }).showToast();
        }).catch(err => console.error(err));
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dynamic-admin-panel\resources\views/admin/menus/settings.blade.php ENDPATH**/ ?>
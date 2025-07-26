<?php $__env->startSection('title', $title.' -  ' . appName()); ?>

<?php $__env->startSection('content'); ?>

<input type="hidden" id="page_url" value="<?php echo e(route($routeInitialize.'.index')); ?>">

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="card-header">
                        <h4 class="fw-bold mb-0"><span class="text-muted fw-light">Home /</span> <?php echo e($title); ?></h4>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="dt-buttons btn-group flex-wrap float-end mt-4">
                        <button id="refresh-record" class="btn btn-success mx-2" title="Refresh Records"><i class="ti ti-refresh me-0 ti-xs"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Users List Table -->
        <div class="card">
            <div class="card-datatable table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="container">
                        <table class="dt-row-grouping table dataTable dtr-column data_table">
                            <thead>
                                <tr>
                                    <?php $__currentLoopData = $columnsConfig; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $columnName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <th><?php echo e($columnName['title']); ?></th>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                            </thead>
                            <tbody id="body"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<?php if (isset($component)) { $__componentOriginalec44ea46082c33e0f8cbcb5b200babc6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalec44ea46082c33e0f8cbcb5b200babc6 = $attributes; } ?>
<?php $component = App\View\Components\Modals::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('modals'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Modals::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalec44ea46082c33e0f8cbcb5b200babc6)): ?>
<?php $attributes = $__attributesOriginalec44ea46082c33e0f8cbcb5b200babc6; ?>
<?php unset($__attributesOriginalec44ea46082c33e0f8cbcb5b200babc6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalec44ea46082c33e0f8cbcb5b200babc6)): ?>
<?php $component = $__componentOriginalec44ea46082c33e0f8cbcb5b200babc6; ?>
<?php unset($__componentOriginalec44ea46082c33e0f8cbcb5b200babc6); ?>
<?php endif; ?>
<!--/ Modals -->

<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>
<script>
    //datatable
    $(document).ready(function(){
        var page_url = $('#page_url').val();
        var columns =     <?php echo json_encode($columnsConfig); ?>  // Get columns dynamically from controller
        initializeDataTable(page_url, columns);
    })
    $('#refresh-record').on('click', function(){
        var page_url = $('#page_url').val();
        var columns =     <?php echo json_encode($columnsConfig); ?>  // Get columns dynamically from controller
        initializeDataTable(page_url, columns);
    })
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dynamic-admin-panel\resources\views/admin/logs/index.blade.php ENDPATH**/ ?>
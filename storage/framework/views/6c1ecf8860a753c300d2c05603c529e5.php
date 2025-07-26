
<?php $__env->startSection('title', $title. ' -  ' . appName()); ?>

<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="card-header">
                        <h4 class="fw-bold mb-0"><span class="text-muted fw-light">Home /</span> <?php echo e($title); ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="nav-align-left nav-tabs-shadow mb-4">
                    <ul class="nav nav-tabs" role="tablist">
                        <?php $__currentLoopData = $business_settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $settings): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="nav-item">
                                <button
                                    type="button"
                                    class="nav-link <?php if($loop->first): ?> active <?php endif; ?>"
                                    role="tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#navs-left-<?php echo e(Str::slug($category)); ?>"
                                    aria-controls="navs-left-<?php echo e(Str::slug($category)); ?>"
                                    aria-selected="<?php echo e($loop->first ? 'true' : 'false'); ?>"
                                >
                                    <?php echo e(ucfirst($category)); ?>

                                </button>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>

                    <div class="tab-content">
                        <?php $__currentLoopData = $business_settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $settings): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="tab-pane fade <?php if($loop->first): ?> show active <?php endif; ?>" id="navs-left-<?php echo e(Str::slug($category)); ?>">
                                <div class="row">
                                    <?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="<?php if($setting->input_type=='textarea' || $setting->key=='location_map_url'): ?> col-md-12 <?php else: ?> col-md-6 <?php endif; ?> mb-3">
                                        <label class="form-label"><?php echo e(ucwords(str_replace('_', ' ', $setting->key))); ?></label>
                                        <div class="form-control-plaintext border p-2">
                                            <?php if($setting->input_type == 'file'): ?>
                                                <?php if($setting->value): ?>
                                                    <img src="<?php echo e(asset('storage/'.$setting->value)); ?>" width="120px" alt="<?php echo e($setting->key); ?>">
                                                <?php else: ?>
                                                    <img src="<?php echo e(asset('storage/images/default.png')); ?>" width="120px" alt="<?php echo e($setting->key); ?>">
                                                <?php endif; ?>
                                            <?php elseif($setting->input_type == 'checkbox'): ?>
                                                <?php echo e($setting->value ? 'Enabled' : 'Disabled'); ?>

                                            <?php else: ?>
                                                <span class="fw-bold"><?php echo e($setting->value ?? 'N/A'); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>

                                <div class="text-end">
                                    <button
                                        data-toggle="tooltip" 
                                        data-placement="top" 
                                        title="Edit <?php echo e(ucwords($category)); ?>"
                                        data-edit-url="<?php echo e(route('settings.edit', $category)); ?>"
                                        data-url="<?php echo e(route('settings.update', $category)); ?>"
                                        class="btn btn-primary edit-btn"
                                        tabindex="0" aria-controls="DataTables_Table_0"
                                        type="button" data-bs-toggle="modal"
                                        data-bs-target="#create-pop-up-modal-for-file">
                                        Edit <?php echo e(ucwords($category)); ?>

                                    </button>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dynamic-admin-panel\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>
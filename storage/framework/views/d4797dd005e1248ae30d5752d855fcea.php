<?php $__env->startSection('title', Str::upper($title) .' | '.Str::upper(appName())); ?>
<?php $__env->startSection('content'); ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
        <!-- View sales -->
        <div class="col-xl-4 mb-4 col-lg-5 col-12">
            <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-7">
                <div class="card-body text-nowrap">
                    <h5 class="card-title mb-0">Welcome <?php if(Auth::check()): ?> <?php echo e(Auth::user()->name); ?> <?php endif; ?>! 🎉</h5>
                    
                    
                </div>
                </div>
                <div class="col-5 text-center text-sm-left">
                <div class="card-body pb-0 px-0 px-md-4">
                    <img
                    src="<?php echo e(asset('admin')); ?>/assets/img/illustrations/card-advance-sale.png"
                    height="140"
                    alt="view sales"
                    />
                </div>
                </div>
            </div>
            </div>
        </div>
        <!-- View sales -->

        <!-- Statistics -->
        <div class="col-xl-8 mb-4 col-lg-7 col-12">
            <div class="card h-100">
            <div class="card-header">
                <div class="d-flex justify-content-between mb-3">
                <h5 class="card-title mb-0">Statistics</h5>
                <small class="text-muted">Updated 1 month ago</small>
                </div>
            </div>
            <div class="card-body">
                <div class="row gy-3">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sliders-list')): ?>
                <div class="col-md-3 col-6">
                    <div class="d-flex align-items-center">
                    <div class="badge rounded-pill bg-label-success me-3 p-2">
                        <i class="ti ti-currency-dollar ti-sm"></i>
                    </div>
                    <div class="card-info">
                        <h5 class="mb-0">0</h5>
                        <small>Sliders</small>
                    </div>
                    </div>
                </div>
                <?php endif; ?>
                </div>
            </div>
            </div>
        </div>
        <!--/ Statistics -->

        

        <!-- Revenue Report -->
        
        <!--/ Revenue Report -->

        <!-- Earning Reports -->
        
        <!--/ Earning Reports -->

        <!-- Popular Product -->
        
        <!--/ Popular Product -->

        <!-- Sales by Countries tabs-->
        
        <!--/ Sales by Countries tabs -->

        <!-- Transactions -->
        
        <!--/ Transactions -->

        <!-- Invoice table -->
        
        <!-- /Invoice table -->
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dynamic-admin-panel\resources\views/admin/dashboards/dashboard.blade.php ENDPATH**/ ?>
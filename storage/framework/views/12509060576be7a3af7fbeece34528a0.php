<?php $__env->startSection('title', $title, ' - '. appName()); ?>
<?php $__env->startSection('content'); ?>
    <div class="authentication-wrapper authentication-cover authentication-bg">
        <div class="authentication-inner row">
            <div class="d-none d-lg-flex col-lg-7 p-0">
                <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
                    <img src="<?php echo e(asset('admin')); ?>/assets/img/illustrations/auth-forgot-password-illustration-light.png"
                      alt="auth-forgot-password-cover"
                      class="img-fluid my-5 auth-illustration"
                      data-app-light-img="illustrations/auth-forgot-password-illustration-light.png"
                      data-app-dark-img="illustrations/auth-forgot-password-illustration-dark.png"
                    />
        
                    <img
                      src="<?php echo e(asset('admin')); ?>/assets/img/illustrations/bg-shape-image-light.png"
                      alt="auth-forgot-password-cover"
                      class="platform-bg"
                      data-app-light-img="illustrations/bg-shape-image-light.png"
                      data-app-dark-img="illustrations/bg-shape-image-dark.png"
                    />
                </div>
            </div>

            <!-- Forgot Password -->
            <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
                <div class="w-px-400 mx-auto">
                    <!-- Logo -->
                    <?php if (isset($component)) { $__componentOriginal17644a73d0ce7152dda8ed0d758eb01f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal17644a73d0ce7152dda8ed0d758eb01f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.company-logo','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('company-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal17644a73d0ce7152dda8ed0d758eb01f)): ?>
<?php $attributes = $__attributesOriginal17644a73d0ce7152dda8ed0d758eb01f; ?>
<?php unset($__attributesOriginal17644a73d0ce7152dda8ed0d758eb01f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal17644a73d0ce7152dda8ed0d758eb01f)): ?>
<?php $component = $__componentOriginal17644a73d0ce7152dda8ed0d758eb01f; ?>
<?php unset($__componentOriginal17644a73d0ce7152dda8ed0d758eb01f); ?>
<?php endif; ?>
                    <!-- /Logo -->
                    <h3 class="mb-1 fw-bold">Forgot Password? 🔒</h3>
                    <p class="mb-4">Enter your email and we'll send you instructions to reset your password</p>
                    <form method="POST" action="<?php echo e(route('password.email')); ?>">
                        <?php echo csrf_field(); ?>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input
                              type="email"
                              class="form-control"
                              id="email"
                              name="email"
                              placeholder="Enter your email"
                              autofocus
                            />
                            <span class="text-danger"><?php echo e($errors->first('email')); ?></span>
                        </div>
                        <button type="submit" class="btn btn-primary d-grid w-100">Send Reset Link</button>
                    </form>
                    <div class="text-center">
                      <a href="<?php echo e(route('admin.login')); ?>" class="d-flex align-items-center justify-content-center">
                        <i class="ti ti-chevron-left scaleX-n1-rtl"></i>
                        Back to login
                      </a>
                    </div>
                </div>
            </div>
            <!-- /Forgot Password -->
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.auth.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dynamic-admin-panel\resources\views/admin/auth/forgot-password.blade.php ENDPATH**/ ?>
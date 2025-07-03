<?php $__env->startSection('title', $title. ' -  ' . appName()); ?>

<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Users List Table -->
        <div class="card">
            <div class="card-header border-bottom">
                <h5 class="card-title mb-3">Company Settings</h5>
            </div>
            <div class="col-xl-10 offset-1">
                <div class="card-body">
                    <form action="<?php echo e(route('settings.store')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3 row">
                            <label for="name" class="col-md-2 col-form-label">Name</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" value="" name="name" id="name" placeholder="Enter company name"/>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                <span id="name_error" class="text-danger error"><?php echo e($errors->first('name')); ?></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="logo" class="col-md-2 col-form-label">Logo</label>
                            <div class="col-md-10">
                                <input class="form-control" name="logo" type="file" id="logo" />
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                <span id="logo_error" class="text-danger error"><?php echo e($errors->first('logo')); ?></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="logo" class="col-md-2 col-form-label"></label>
                            <div class="col-md-10">
                                <div id="logo-preview"></div>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="favicon" class="col-md-2 col-form-label">Favicon</label>
                            <div class="col-md-10">
                                <input class="form-control" name="favicon" type="file" id="favicon" />
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                <span id="favicon_error" class="text-danger error"><?php echo e($errors->first('favicon')); ?></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="favicon" class="col-md-2 col-form-label"></label>
                            <div class="col-md-10">
                                <div id="favicon-preview"></div>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="banner" class="col-md-2 col-form-label">Banner</label>
                            <div class="col-md-10">
                                <input class="form-control" name="banner" type="file" id="banner" />
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                <span id="banner_error" class="text-danger error"><?php echo e($errors->first('banner')); ?></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="banner" class="col-md-2 col-form-label"></label>
                            <div class="col-md-10">
                                <div id="banner-preview"></div>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="lanaguage" class="col-md-2 col-form-label">Language</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="language" value="<?php echo e(old('language')); ?>" id="lanaguage" placeholder="Enter language" />
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                <span id="language_error" class="text-danger error"><?php echo e($errors->first('language')); ?></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="lanaguage" class="col-md-2 col-form-label">Max Leaves Allow Per Month</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="max_leaves" value="<?php echo e(old('max_leaves')); ?>" id="lanaguage" placeholder="Enter max allow leaves" />
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                <span id="max_leaves_error" class="text-danger error"><?php echo e($errors->first('max_leaves')); ?></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="lanaguage" class="col-md-2 col-form-label">Max Discrepancies Allow Per Month</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="max_discrepancies" value="<?php echo e(old('max_discrepancies')); ?>" id="lanaguage" placeholder="Enter max allow discrepancies" />
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                <span id="max_discrepancies_error" class="text-danger error"><?php echo e($errors->first('max_discrepancies')); ?></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="currency_symbol" class="col-md-2 col-form-label">Currency Symbol</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="currency_symbol" value="<?php echo e(old('currency_symbol')); ?>" id="currency_symbol" placeholder="Enter currency symbol"/>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                <span id="currency_symbol_error" class="text-danger error"><?php echo e($errors->first('name')); ?></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="insurance_eligibility" class="col-md-2 col-form-label">Insurance Eligibility</label>
                            <div class="col-md-10">
                                <select class="form-select select2" id="insurance_eligibility" name="insurance_eligibility">
                                    <option value="0">Immediately</option>
                                    <option value="1">1 Month</option>
                                    <option value="2">2 Month</option>
                                    <option value="3">3 Month</option>
                                    <option value="4">4 Month</option>
                                    <option value="5">5 Month</option>
                                    <option value="6" selected>6 Month</option>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                <span id="insurance_eligibility_error" class="text-danger error"></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="country" class="col-md-2 col-form-label">Country</label>
                            <div class="col-md-10">
                                <select name="country" id="country" class="form-control">
                                    <option value="pakistan" selected <?php echo e(old('country')=='pakistan'?'selected':''); ?>>Pakistan</option>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                <span id="country_error" class="text-danger error"><?php echo e($errors->first('country')); ?></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="area" class="col-md-2 col-form-label">Area</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="area" value="<?php echo e(old('area')); ?>" id="area" placeholder="Enter area"/>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                <span id="area_error" class="text-danger error"><?php echo e($errors->first('area')); ?></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="city" class="col-md-2 col-form-label">City</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="city" value="<?php echo e(old('city')); ?>" id="city" placeholder="Enter city"/>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                <span id="city_error" class="text-danger error"><?php echo e($errors->first('city')); ?></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="state" class="col-md-2 col-form-label">State</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="state" value="<?php echo e(old('state')); ?>" id="state" placeholder="Enter state"/>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                <span id="state_error" class="text-danger error"><?php echo e($errors->first('state')); ?></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="zip_code" class="col-md-2 col-form-label">Zipcode</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="zip_code" value="<?php echo e(old('zip_code')); ?>" id="zip_code" placeholder="Enter zip code"/>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                <span id="zip_code_error" class="text-danger error"><?php echo e($errors->first('zip_code')); ?></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="address" class="col-md-2 col-form-label">Address</label>
                            <div class="col-md-10">
                                <textarea name="address" id="address" class="form-control" placeholder="Enter address"><?php echo e(old('address')); ?></textarea>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                <span id="address_error" class="text-danger error"><?php echo e($errors->first('address')); ?></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="facebook_link" class="col-md-2 col-form-label">Facebook Link</label>
                            <div class="col-md-10">
                                <textarea name="facebook_link" id="" class="form-control" placeholder="Enter facebook link here..."><?php echo e(old('facebook_link')); ?></textarea>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                <span id="facebook_link_error" class="text-danger error"><?php echo e($errors->first('facebook_link')); ?></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="instagram_link" class="col-md-2 col-form-label">Instagram Link</label>
                            <div class="col-md-10">
                                <textarea name="instagram_link" id="instagram_link" class="form-control" placeholder="Enter instagram link here..."><?php echo e(old('instagram_link')); ?></textarea>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                <span id="instagram_link_error" class="text-danger error"><?php echo e($errors->first('instagram_link')); ?></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="linked_in_link" class="col-md-2 col-form-label">LinkedIn Link</label>
                            <div class="col-md-10">
                                <textarea name="linked_in_link" id="linked_in_link" class="form-control" placeholder="Enter instagram link here..."><?php echo e(old('linked_in_link')); ?></textarea>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                <span id="linked_inerror" class="text-danger error"><?php echo e($errors->first('linked_in_link')); ?></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="twitter_link" class="col-md-2 col-form-label">Twitter Link</label>
                            <div class="col-md-10">
                                <textarea name="twitter_link" class="form-control" placeholder="Enter twitter link here..."><?php echo e(old('twitter_link')); ?></textarea>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                                <span id="twitter_error" class="text-danger error"><?php echo e($errors->first('twitter_link')); ?></span>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="address" class="col-md-2 col-form-label"></label>
                            <div class="col-md-10">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit waves-effect waves-light">Submit</button>
                                <button type="reset" class="btn btn-label-secondary waves-effect" data-bs-dismiss="offcanvas">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>
    <script>
        $(document).ready(function() {
            // When the file input changes
            $('#logo').change(function() {
                var file = this.files[0];
                var reader = new FileReader();

                reader.onload = function(e) {
                // Create an image element
                var img = $('<img style="width:10%; height:5%">').attr('src', e.target.result);

                // Display the image preview
                $('#logo-preview').html(img);
                }

                // Read the image file as a data URL
                reader.readAsDataURL(file);
            });

            $('#favicon').change(function() {
                var file = this.files[0];
                var reader = new FileReader();

                reader.onload = function(e) {
                // Create an image element
                var img = $('<img style="width:10%; height:5%">').attr('src', e.target.result);

                // Display the image preview
                $('#favicon-preview').html(img);
                }

                // Read the image file as a data URL
                reader.readAsDataURL(file);
            });

            $('#banner').change(function() {
                var file = this.files[0];
                var reader = new FileReader();

                reader.onload = function(e) {
                // Create an image element
                var img = $('<img style="width:10%; height:5%">').attr('src', e.target.result);

                // Display the image preview
                $('#banner-preview').html(img);
                }

                // Read the image file as a data URL
                reader.readAsDataURL(file);
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dynamic-admin-panel\resources\views/admin/settings/create.blade.php ENDPATH**/ ?>
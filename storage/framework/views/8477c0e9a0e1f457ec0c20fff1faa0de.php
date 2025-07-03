<?php $__env->startSection('title', $title. ' -  ' . appName()); ?>

<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <!-- Tabs -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="card-header">
                        <h4 class="fw-bold mb-0">Company Settings</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- User Content -->
            <div class="col-xl-12 col-lg-7 col-md-7 order-0 order-md-1">
                <!-- User Pills -->
                <ul class="nav nav-pills flex-column flex-md-row mb-4 profile-tabs">
                    <li class="nav-item"></li>
                    <li class="nav-item">
                        <button type="button" class="nav-link active " role="tab" data-bs-toggle="tab" data-bs-target="#navs-company-profile" aria-controls="navs-company-profile" aria-selected="true">
                            <i class="ti ti-user-check me-1 ti-xs"></i>Company Profile
                        </button>
                    </li>
                    
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="navs-company-profile" role="tabpanel">
                        <div class="card-body">
                            <form id="company-settings" action="<?php echo e(route('settings.update', getSetting('id', 1))); ?>" method="POST" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <?php echo e(method_field('PATCH')); ?>


                                <div class="mb-3 row">
                                    <label for="name" class="col-md-2 col-form-label">Name <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" value="<?php echo e(getSetting('application_name', null)); ?>" name="name" id="name" placeholder="Enter company name"/>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="name_error" class="text-danger error"><?php echo e($errors->first('name')); ?></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="logo" class="col-md-2 col-form-label">White Logo </label>
                                    <div class="col-md-10">
                                        <input class="form-control" name="logo" type="file" id="logo" />
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="logo_error" class="text-danger error"></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="logo" class="col-md-2 col-form-label"></label>
                                    <div class="col-md-10">
                                        <?php if(!empty(getSetting('logo', null))): ?>
                                            <div id="logo-preview" class="p-3 w-25 rounded bg-light">
                                                <img class="img-fluid img-thumbnail w-50 mx-auto" src="<?php echo e(asset('storage').'/'.getSetting('logo', null)); ?>" alt="">
                                            </div>
                                        <?php else: ?>
                                            <div id="logo-preview" class="p-3 w-25 rounded bg-light"></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="black_logo" class="col-md-2 col-form-label">Black Logo </label>
                                    <div class="col-md-10">
                                        <input class="form-control" name="black_logo" type="file" id="black_logo" />
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="black_logo_error" class="text-danger error"><?php echo e($errors->first('black_logo')); ?></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="black_logo" class="col-md-2 col-form-label"></label>
                                    <div class="col-md-10">
                                        <?php if(!empty(getSetting('black_logo', null))): ?>
                                            <div id="black_logo-preview">
                                                <img style="width:15%; height:5%" src="<?php echo e(asset('storage').'/'.getSetting('black_logo', null)); ?>" alt="">
                                            </div>
                                        <?php else: ?>
                                            <div id="black_logo-preview"></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="favicon" class="col-md-2 col-form-label">Favicon</label>
                                    <div class="col-md-10">
                                        <input class="form-control" name="favicon" type="file" id="favicon" />
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="favicon_error" class="text-danger error"></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="favicon" class="col-md-2 col-form-label"></label>
                                    <div class="col-md-10">
                                        <?php if(!empty(getSetting('favicon', null))): ?>
                                            <div id="favicon-preview">
                                                <img style="width:5%; height:5%" src="<?php echo e(asset('storage').'/'.getSetting('favicon', null)); ?>" alt="">
                                            </div>
                                        <?php else: ?>
                                            <div id="favicon-preview"></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="slip_stamp" class="col-md-2 col-form-label">Slip Stamp </label>
                                    <div class="col-md-10">
                                        <input class="form-control" name="slip_stamp" type="file" id="slip_stamp" />
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="slip_stamp_error" class="text-danger error"><?php echo e($errors->first('slip_stamp')); ?></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="slip_stamp" class="col-md-2 col-form-label"></label>
                                    <div class="col-md-10">
                                        <?php if(!empty(getSetting('slip_stamp', null))): ?>
                                            <div id="slip_stamp-preview">
                                                <img style="width:10%; height:5%" src="<?php echo e(asset('storage').'/'.getSetting('slip_stamp', null)); ?>" alt="">
                                            </div>
                                        <?php else: ?>
                                            <div id="slip_stamp-preview"></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="admin_signature" class="col-md-2 col-form-label">Admin Signature </label>
                                    <div class="col-md-10">
                                        <input class="form-control" name="admin_signature" type="file" id="admin_signature" />
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="admin_signature_error" class="text-danger error"><?php echo e($errors->first('admin_signature')); ?></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="admin_signature" class="col-md-2 col-form-label"></label>
                                    <div class="col-md-10">
                                        <?php if(!empty(getSetting('admin_signature', null))): ?>
                                            <div id="admin_signature-preview">
                                                <img style="width:10%; height:5%" src="<?php echo e(asset('storage').'/'.getSetting('admin_signature', null)); ?>" alt="">
                                            </div>
                                        <?php else: ?>
                                            <div id="admin_signature-preview"></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="phone_number" class="col-md-2 col-form-label">Phone Number <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <input class="form-control phoneNumber" type="text" name="phone_number" value="<?php echo e(getSetting('phone_number', null)); ?>" id="phone_number" placeholder="Enter company phone number" />
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="phone_number_error" class="text-danger error"></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="support_email" class="col-md-2 col-form-label">Support Email <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="email" name="support_email" value="<?php echo e(getSetting('support_email', null)); ?>" id="support_email" placeholder="Enter support email" />
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="support_email_error" class="text-danger error"></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="sale_email" class="col-md-2 col-form-label">Sale Email <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="email" name="sale_email" value="<?php echo e(getSetting('sale_email', null)); ?>" id="sale_email" placeholder="Enter sale email" />
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="sale_email_error" class="text-danger error"></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-md-2 col-form-label">Operating Hours</label>
                                    <div class="col-md-10 d-flex gap-2">
                                        <select name="day_range" class="form-select w-auto">
                                            <option value="Mon-Fri">Mon-Fri</option>
                                            <option value="Sat-Sun">Sat-Sun</option>
                                            <!-- Add more as needed -->
                                        </select>
                                
                                        <input class="form-control w-auto" type="time" name="start_time" value="08:00" />
                                        <span class="align-self-center">to</span>
                                        <input class="form-control w-auto" type="time" name="end_time" value="17:00" />
                                
                                        <select name="timezone" class="form-select w-auto">
                                            <option value="CDT">CDT</option>
                                            <option value="EST">EST</option>
                                            <option value="PST">PST</option>
                                            <option value="UTC">UTC</option>
                                        </select>
                                    </div>
                                </div>                                
                                <div class="mb-3 row">
                                    <label for="website_url" class="col-md-2 col-form-label">Website URL</label>
                                    <div class="col-md-10">
                                        <textarea name="website_url" id="website_url" class="form-control" placeholder="Enter website url"><?php echo e(getSetting('website_url', null)); ?></textarea>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="website_url_error" class="text-danger error"></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="location_map_url" class="col-md-2 col-form-label">Location Map URL</label>
                                    <div class="col-md-10">
                                        <textarea name="location_map_url" id="location_map_url" class="form-control" placeholder="Enter website url"><?php echo e(getSetting('location_map_url', null)); ?></textarea>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="location_map_url_error" class="text-danger error"></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="country" class="col-md-2 col-form-label">Country</label>
                                    <div class="col-md-10">
                                        <select name="country" id="country" class="form-select" data-url="<?php echo e(route('get-states')); ?>">
                                            <?php $__currentLoopData = countries(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($country->name); ?>" <?php echo e(getSetting('country', null)==$country->name?'selected':''); ?>><?php echo e($country->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="country_error" class="text-danger error"></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="state" class="col-md-2 col-form-label">State</label>
                                    <div class="col-md-10">
                                        <select name="state" id="state" class="form-select" data-url="<?php echo e(route('get-cities')); ?>">
                                            <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($state->name); ?>" <?php echo e(getSetting('state', null)==$state->name?'selected':''); ?>><?php echo e($state->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="state_error" class="text-danger error"></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="city" class="col-md-2 col-form-label">City</label>
                                    <div class="col-md-10">
                                        <select name="city" id="city" class="form-select">
                                            <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($city->name); ?>" <?php echo e(getSetting('city', null)==$city->name?'selected':''); ?>><?php echo e($city->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="city_error" class="text-danger error"></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="zip_code" class="col-md-2 col-form-label">Zipcode</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" name="zip_code" value="<?php echo e(getSetting('zip_code', null)); ?>" id="zip_code" placeholder="Enter zip code"/>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="zip_code_error" class="text-danger error"></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="area" class="col-md-2 col-form-label">Area</label>
                                    <div class="col-md-10">
                                        <input class="form-control" type="text" name="area" value="<?php echo e(getSetting('area', null)); ?>" id="area" placeholder="Enter area"/>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="area_error" class="text-danger error"></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="address" class="col-md-2 col-form-label">Address <span class="text-danger">*</span></label>
                                    <div class="col-md-10">
                                        <textarea name="address" id="address" class="form-control" placeholder="Enter address"><?php echo e(getSetting('address', null)); ?></textarea>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="address_error" class="text-danger error"></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="facebook_link" class="col-md-2 col-form-label">Facebook Link</label>
                                    <div class="col-md-10">
                                        <textarea name="facebook_link" id="" class="form-control" placeholder="Enter facebook link here..."><?php echo e(getSetting('facebook_link', null)); ?></textarea>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="facebook_link_error" class="text-danger error"><?php echo e($errors->first('facebook_link')); ?></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="instagram_link" class="col-md-2 col-form-label">Instagram Link</label>
                                    <div class="col-md-10">
                                        <textarea name="instagram_link" id="instagram_link" class="form-control" placeholder="Enter instagram link here..."><?php echo e(getSetting('instagram_link', null)); ?></textarea>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="instagram_link_error" class="text-danger error"><?php echo e($errors->first('instagram_link')); ?></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="linked_in_link" class="col-md-2 col-form-label">LinkedIn Link</label>
                                    <div class="col-md-10">
                                        <textarea name="linked_in_link" id="linked_in_link" class="form-control" placeholder="Enter linkedIn link here..."><?php echo e(getSetting('linked_in_link', null)); ?></textarea>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="linked_in_error" class="text-danger error"><?php echo e($errors->first('linked_in_link')); ?></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="twitter_link" class="col-md-2 col-form-label">Twitter Link</label>
                                    <div class="col-md-10">
                                        <textarea name="twitter_link" class="form-control" placeholder="Enter twitter link here..."><?php echo e(getSetting('twitter_link', null)); ?></textarea>
                                        <div class="fv-plugins-message-container invalid-feedback"></div>
                                        <span id="twitter_error" class="text-danger error"><?php echo e($errors->first('twitter_link')); ?></span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="address" class="col-md-2 col-form-label"></label>
                                    <div class="col-md-10">
                                        <button id="updateButton" type="submit" class="btn btn-primary me-2">
                                            <span id="spinner" class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                                            Update
                                        </button>  
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <!-- Tabs -->
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('js'); ?>
    <script>
        $(document).ready(function () {
            $('form').on('submit', function () {
                const btn = $('#updateButton');
                btn.prop('disabled', true);
                $('#spinner').removeClass('d-none');
            });
        });

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

            $('#black_logo').change(function() {
                var file = this.files[0];
                var reader = new FileReader();

                reader.onload = function(e) {
                // Create an image element
                var img = $('<img style="width:10%; height:5%">').attr('src', e.target.result);

                // Display the image preview
                $('#black_logo-preview').html(img);
                }

                // Read the image file as a data URL
                reader.readAsDataURL(file);
            });

            $('#slip_stamp').change(function() {
                var file = this.files[0];
                var reader = new FileReader();

                reader.onload = function(e) {
                // Create an image element
                var img = $('<img style="width:10%; height:5%">').attr('src', e.target.result);

                // Display the image preview
                $('#slip_stamp-preview').html(img);
                }

                // Read the image file as a data URL
                reader.readAsDataURL(file);
            });

            $('#admin_signature').change(function() {
                var file = this.files[0];
                var reader = new FileReader();

                reader.onload = function(e) {
                    // Create an image element
                    var img = $('<img style="width:10%; height:5%">').attr('src', e.target.result);

                    // Display the image preview
                    $('#admin_signature-preview').html(img);
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

            $('select').each(function () {
                $(this).select2({
                    dropdownParent: $(this).parent(),
                });
            });

            // $('#company-settings input, select, textarea').prop('disabled', true);

            // $('#editButton').click(function() {
            //   $(this).addClass('d-none');
            //   $('#updateButton').removeClass('d-none');
            //   $('#company-settings input, select, textarea').prop('disabled', false);
            // });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dynamic-admin-panel\resources\views/admin/settings/edit.blade.php ENDPATH**/ ?>
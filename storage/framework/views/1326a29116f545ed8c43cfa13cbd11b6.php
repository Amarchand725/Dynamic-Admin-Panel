<?php $__env->startSection('title', $title.' -  ' . appName()); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card-header">
                            <h4 class="fw-bold mb-0"><span class="text-muted fw-light">Home /</span>
                                <?php echo e($title ?? 'Log Details'); ?></h4>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="dt-buttons btn-group flex-wrap float-end mt-4">
                            <a href="<?php echo e(route('logs.index')); ?>" class="btn btn-secondary btn-primary mx-3"
                                data-toggle="tooltip" data-placement="top" title="List of Pre-Employees"
                                tabindex="0" aria-controls="DataTables_Table_0" type="button">
                                <span>
                                    <i class="ti ti-arrow-left me-0 me-sm-1 ti-xs"></i>
                                    <span class="d-none d-sm-inline-block">Back</span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md mb-4 mb-md-2">
                    <div class="accordion accordion-b mt-3" id="accordionExample">
                        <!--Manager-->
                        <div class="card accordion-item mb-4">
                            <h2 class="accordion-header py-2 fw-bold" id="headingThree">
                                <button type="button" class="accordion-button show" data-bs-toggle="collapse"
                                    data-bs-target="#managerDetail" aria-expanded="false" aria-controls="managerDetail">
                                    <h5 class="m-0 fw-bold text-dark">Log Details</h5>
                                </button>
                            </h2>
                            <div id="managerDetail" class="accordion-collapse show" aria-labelledby="headingThree"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="datatable mb-3">
                                        <div class="table-responsive custom-scrollbar table-view-responsive">
                                            <table class="table table-striped table-responsive custom-table ">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Action By</th>
                                                        <th scope="col">Action Type</th>
                                                        <th scope="col">Action Model</th>
                                                        <th scope="col">Remarks</th>
                                                        <th scope="col">IP</th>
                                                        <th scope="col">Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <?php if(!empty($model->hasActionUser->name)): ?>
                                                                <?php echo e($model->hasActionUser->name.' ('.$model->hasActionUser->role.')' ?? '-'); ?>

                                                            <?php else: ?>
                                                                -
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo actionLabel($model->user_action); ?>

                                                        </td>
                                                        <td><?php echo e($className); ?></td>
                                                        <td><?php echo e($model->description); ?></td>
                                                        <td><?php echo e($model->ip_address); ?></td>
                                                        <td>
                                                            <?php if(!empty($model->created_at)): ?>
                                                                <?php echo e(getDateTimeFormat($model->created_at) ?? '-'); ?>

                                                            <?php else: ?>
                                                                -
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="6"><strong>Details Data</strong></td>
                                                    </tr>
                                                    <?php if($model->action=='update'): ?> <!-- For update -->
                                                        <tr>
                                                            <th colspan="2">Columns</th>
                                                            <th colspan="2">Old Data</th>
                                                            <th colspan="2">New Data</th>
                                                        </tr>
                                                        <?php $data = json_decode($model->changed_fields, true); ?>
                                                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <tr>
                                                                <th colspan="2"><strong><?php echo e($key); ?></strong></th>
                                                                <td colspan="2">
                                                                    <?php if($key=='status'): ?>
                                                                        <?php echo statusBadge($item['old']); ?>

                                                                    <?php elseif($key == 'updated_at'): ?>
                                                                        <?php echo e(newDateFormat($item['old']) ?? '-'); ?>

                                                                    <?php elseif($key=='password'): ?>
                                                                        <?php echo e('-'); ?>

                                                                    <?php else: ?>
                                                                        <?php echo e($item['old']); ?>

                                                                    <?php endif; ?>
                                                                </td>
                                                                <td colspan="2">
                                                                    <?php if($key=='status'): ?>
                                                                        <?php echo statusBadge($item['new']); ?>

                                                                    <?php elseif($key == 'updated_at'): ?>
                                                                        <?php echo e(newDateFormat($item['new']) ?? '-'); ?>

                                                                    <?php elseif($key=='password'): ?>
                                                                        <?php echo e('-'); ?>

                                                                    <?php else: ?>
                                                                        <?php echo e($item['new']); ?>

                                                                    <?php endif; ?>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php elseif($model->action=='show_column'): ?> <!-- For show specific column data -->
                                                        <tr>
                                                            <th colspan="2">Columns</th>
                                                            <th colspan="4">Viewed </th>
                                                        </tr>
                                                        <?php
                                                            $columnData = json_decode($model->extra_details, true);
                                                        ?>
                                                        <tr>
                                                            <th colspan="2"><strong><?php echo e(Str::upper($columnData['column_name']) ?? '-'); ?></strong></th>
                                                            <td colspan="4"><?php echo e($columnData['column_value'] ?? '-'); ?></td>
                                                        </tr>
                                                    <?php elseif($model->action=='downloaded-document'): ?> <!-- For downloading document or file -->
                                                        <tr>
                                                            <th colspan="2">Columns</th>
                                                            <th colspan="4">Document </th>
                                                        </tr>
                                                        <?php
                                                            $columnData = json_decode($model->extra_details, true);
                                                        ?>
                                                        <tr>
                                                            <th colspan="2"><strong><?php echo e(Str::upper($columnData['column_name']) ?? '-'); ?></strong></th>
                                                            <td colspan="4">
                                                                <?php if(!empty($columnData['column_value'])): ?>
                                                                    <a href="<?php echo e(asset($columnData['document_path'].'/'.$columnData['column_value'])); ?>"
                                                                        download class="btn btn-info"
                                                                        title="<?php echo e($columnData['column_value']); ?>"
                                                                        style="display: flex; align-items: center; gap: 5px;">
                                                                        <i class="fa fa-download"></i>
                                                                        Download
                                                                    </a>
                                                                <?php else: ?>
                                                                    -
                                                                <?php endif; ?>
                                                            </td>
                                                        </tr>
                                                    <?php else: ?>
                                                        <tr>
                                                            <th colspan="2">Columns</th>
                                                            <th colspan="4">Data</th>
                                                        </tr>
                                                        <?php if(isset($modelData) && !empty($modelData)): ?>
                                                            <?php
                                                                $recordArray = $modelData->toArray();
                                                                $excludeKeys = ['id', 'created_by', 'updated_at', 'deleted_at'];

                                                                if ($className == 'User') {
                                                                    $excludeKeys[] = 'email_verified_at'; // Add the key dynamically to the array
                                                                    $excludeKeys[] = 'password'; // Add the key dynamically to the array
                                                                    $excludeKeys[] = 'remember_token'; // Add the key dynamically to the array
                                                                }

                                                                $filteredData = array_diff_key($recordArray, array_flip($excludeKeys));
                                                            ?>
                                                            <?php $__currentLoopData = $filteredData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr>
                                                                    <th colspan="2"><strong><?php echo e($key ?? '-'); ?></strong></th>
                                                                    <td colspan="4">
                                                                        <?php if($key=='status'): ?>
                                                                            <?php echo statusBadge($item); ?>

                                                                        <?php elseif($key=='created_at'): ?>
                                                                            <?php echo e(getDateTimeFormat($item)); ?>

                                                                        <?php elseif($key=='is_employee'): ?>
                                                                            <?php echo isEmployee($item); ?>

                                                                        <?php else: ?>
                                                                            <?php echo e($item ?? '-'); ?>

                                                                        <?php endif; ?>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php else: ?>
                                                            <tr>
                                                                <td colspan="6">Record not found</td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dynamic-admin-panel\resources\views/admin/logs/show.blade.php ENDPATH**/ ?>
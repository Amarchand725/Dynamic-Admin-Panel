<div id="managerDetail" class="accordion-collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
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
                            <th scope="col">IP Address</th>
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
                            <td colspan="6"><strong>Record Details</strong></td>
                        </tr>
                        <?php if($model->user_action=='update'): ?> <!-- For update -->
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
                                        <?php if(is_string($item['old']) && preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $item['old'])): ?>
                                            <img src="<?php echo e(asset('storage/' .$item['old'])); ?>" width="80">
                                        <?php elseif($key=='status'): ?>
                                            <?php echo statusBadge($item['old']); ?>

                                        <?php elseif($key == 'updated_at'): ?>
                                            <?php echo e(getDateTimeFormat($item['old']) ?? '-'); ?>

                                        <?php elseif($key=='password'): ?>
                                            <?php echo e('-'); ?>

                                        <?php else: ?>
                                            <?php echo e($item['old'] ?? '-'); ?>

                                        <?php endif; ?>
                                    </td>
                                    <td colspan="2">
                                        <?php if(is_string($item['new']) && preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $item['new'])): ?>
                                                <?php if(!empty($item['new'])): ?>
                                                    <img src="<?php echo e(asset('storage/' .$item['new'])); ?>" width="80">
                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                        <?php elseif($key=='status'): ?>
                                            <?php echo statusBadge($item['new']); ?>

                                        <?php elseif($key == 'updated_at'): ?>
                                            <?php echo e(getDateTimeFormat($item['new']) ?? '-'); ?>

                                        <?php elseif($key=='password'): ?>
                                            <?php echo e('-'); ?>

                                        <?php else: ?>
                                            <?php echo e($item['new']); ?>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php elseif($model->user_action=='show_column'): ?> <!-- For show specific column data -->
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
                        <?php elseif($model->user_action=='downloaded-document'): ?> <!-- For downloading document or file -->
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
                                            <?php if(is_string($item) && preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $item)): ?>
                                                <?php if(!empty($item)): ?>
                                                    <img src="<?php echo e(asset('storage/' .$item)); ?>" width="80">
                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
                                            <?php elseif($key=='status'): ?>
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
</div><?php /**PATH C:\xampp\htdocs\dynamic-admin-panel\resources\views/admin/logs/show_content.blade.php ENDPATH**/ ?>
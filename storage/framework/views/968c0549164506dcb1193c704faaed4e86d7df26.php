
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Kiwat Detail')); ?> - <?php echo e($kiwat->kiwat_number); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('mouza.index')); ?>"><?php echo e(__('Mouza')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('mouza.show', $kiwat->mouza_id)); ?>"><?php echo e($kiwat->mouza->name); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('mouza.kiwat.index', $kiwat->mouza_id)); ?>"><?php echo e(__('Kiwats')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e($kiwat->kiwat_number); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <a href="<?php echo e(route('kiwat.edit', $kiwat->id)); ?>" class="btn btn-sm btn-warning">
            <i class="ti ti-pencil"></i> <?php echo e(__('Edit')); ?>

        </a>
        <a href="<?php echo e(route('mouza.kiwat.index', $kiwat->mouza_id)); ?>" class="btn btn-sm btn-secondary">
            <i class="ti ti-arrow-left"></i> <?php echo e(__('Back')); ?>

        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><?php echo e(__('Kiwat Information')); ?></h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong><?php echo e(__('Mouza')); ?></strong></td>
                            <td><?php echo e($kiwat->mouza->name); ?></td>
                        </tr>
                        <tr>
                            <td><strong><?php echo e(__('Kiwat Number')); ?></strong></td>
                            <td><?php echo e($kiwat->kiwat_number); ?></td>
                        </tr>
                        <tr>
                            <td><strong><?php echo e(__('Total Area')); ?></strong></td>
                            <td><?php echo e($kiwat->total_area ? $kiwat->total_area . ' ' . $kiwat->total_area_unit : '-'); ?></td>
                        </tr>
                        <tr>
                            <td><strong><?php echo e(__('Description')); ?></strong></td>
                            <td><?php echo e($kiwat->description ?? '-'); ?></td>
                        </tr>
                    </table>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <h4 class="text-info"><?php echo e($kiwat->fields->count()); ?></h4>
                            <small><?php echo e(__('Khaits')); ?></small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-secondary"><?php echo e($kiwat->plots->count()); ?></h4>
                            <small><?php echo e(__('Plots')); ?></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5><i class="ti ti-list"></i> <?php echo e(__('Khaits (Fields) in this Kiwat')); ?></h5>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Field No.')); ?></th>
                                    <th><?php echo e(__('Seller')); ?></th>
                                    <th><?php echo e(__('Area')); ?></th>
                                    <th><?php echo e(__('Amount')); ?></th>
                                    <th><?php echo e(__('Status')); ?></th>
                                    <th><?php echo e(__('Action')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $kiwat->fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><strong><?php echo e($field->field_number); ?></strong></td>
                                        <td><?php echo e($field->seller_name); ?></td>
                                        <td><?php echo e($field->area_quantity); ?> <?php echo e($field->area_unit); ?></td>
                                        <td><?php echo e(number_format($field->amount, 2)); ?></td>
                                        <td>
                                            <?php if($field->status == 'available'): ?>
                                                <span class="badge bg-danger">🔴 Available</span>
                                            <?php else: ?>
                                                <span class="badge bg-success">🟢 Sold</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('mouza.field.show', $field->id)); ?>"
                                                class="btn btn-sm btn-info">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center"><?php echo e(__('No Khaits in this Kiwat yet.')); ?>

                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            
            <div class="card mt-3">
                <div class="card-header">
                    <h5><i class="ti ti-building"></i> <?php echo e(__('Plots in this Kiwat')); ?></h5>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Field No.')); ?></th>
                                    <th><?php echo e(__('Purchaser')); ?></th>
                                    <th><?php echo e(__('Area')); ?></th>
                                    <th><?php echo e(__('Amount')); ?></th>
                                    <th><?php echo e(__('Status')); ?></th>
                                    <th><?php echo e(__('Action')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $kiwat->plots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><strong><?php echo e($plot->field_number); ?></strong></td>
                                        <td><?php echo e($plot->purchaser_name); ?></td>
                                        <td><?php echo e($plot->area_quantity); ?> <?php echo e($plot->area_unit); ?></td>
                                        <td><?php echo e(number_format($plot->amount, 2)); ?></td>
                                        <td>
                                            <?php if($plot->status == 'available'): ?>
                                                <span class="badge bg-danger">🔴 Available</span>
                                            <?php elseif($plot->status == 'reserved'): ?>
                                                <span class="badge bg-warning">🟡 Reserved</span>
                                            <?php else: ?>
                                                <span class="badge bg-success">🟢 Sold</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('plot.show', $plot->id)); ?>" class="btn btn-sm btn-info">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center"><?php echo e(__('No Plots in this Kiwat yet.')); ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\2026\Ezitech-AMS-main\resources\views/realEstate/kiwat/show.blade.php ENDPATH**/ ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Real Estate - Mouza')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Real Estate')); ?></li>
    <li class="breadcrumb-item"><?php echo e(__('Mouza')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <a href="<?php echo e(route('mouza.create')); ?>" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i> <?php echo e(__('Add Mouza')); ?>

        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                        <tr>
                            <th><?php echo e(__('#')); ?></th>
                            <th><?php echo e(__('Mouza Name')); ?></th>
                            <th><?php echo e(__('District')); ?></th>
                            <th><?php echo e(__('Tehsil')); ?></th>
                            <th><?php echo e(__('Total Khaits')); ?></th>
                            <th><?php echo e(__('Available')); ?></th>
                            <th><?php echo e(__('Sold')); ?></th>
                            <th><?php echo e(__('Action')); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $mouzas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mouza): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($loop->iteration); ?></td>
                                <td><strong><?php echo e($mouza->name); ?></strong></td>
                                <td><?php echo e($mouza->district ?? '-'); ?></td>
                                <td><?php echo e($mouza->tehsil ?? '-'); ?></td>
                                <td><span class="badge bg-info"><?php echo e($mouza->fields_count); ?></span></td>
                                <td><span class="badge bg-danger">🔴 <?php echo e($mouza->available_fields_count); ?></span></td>
                                <td><span class="badge bg-success">🟢 <?php echo e($mouza->sold_fields_count); ?></span></td>
                                <td>
                                    <a href="<?php echo e(route('mouza.show', $mouza->id)); ?>" class="btn btn-sm btn-info" title="View & Map">
                                        <i class="ti ti-map-pin"></i> <?php echo e(__('View')); ?>

                                    </a>
                                    <a href="<?php echo e(route('mouza.edit', $mouza->id)); ?>" class="btn btn-sm btn-warning">
                                        <i class="ti ti-pencil"></i>
                                    </a>
                                    <form action="<?php echo e(route('mouza.destroy', $mouza->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Delete this Mouza?')">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button class="btn btn-sm btn-danger"><i class="ti ti-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="8" class="text-center"><?php echo e(__('No Mouza found.')); ?></td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\2026\Ezitech-AMS-main\resources\views/realEstate/mouza/index.blade.php ENDPATH**/ ?>
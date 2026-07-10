
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Kiwats')); ?> - <?php echo e($mouza->name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('mouza.index')); ?>"><?php echo e(__('Mouza')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('mouza.show', $mouza->id)); ?>"><?php echo e($mouza->name); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Kiwats')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <a href="<?php echo e(route('mouza.kiwat.create', $mouza->id)); ?>" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i> <?php echo e(__('Add Kiwat')); ?>

        </a>
        <a href="<?php echo e(route('mouza.show', $mouza->id)); ?>" class="btn btn-sm btn-secondary">
            <i class="ti ti-arrow-left"></i> <?php echo e(__('Back to Mouza')); ?>

        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="ti ti-stack"></i> <?php echo e(__('Kiwats (Blocks / Phases)')); ?> - <?php echo e($mouza->name); ?></h5>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('#')); ?></th>
                                    <th><?php echo e(__('Kiwat Number')); ?></th>
                                    <th><?php echo e(__('Description')); ?></th>
                                    <th><?php echo e(__('Total Area')); ?></th>
                                    <th><?php echo e(__('Fields')); ?></th>
                                    <th><?php echo e(__('Plots')); ?></th>
                                    <th><?php echo e(__('Available')); ?></th>
                                    <th><?php echo e(__('Sold')); ?></th>
                                    <th><?php echo e(__('Action')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $kiwats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kiwat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td><strong><?php echo e($kiwat->kiwat_number); ?></strong></td>
                                        <td><?php echo e($kiwat->description ?? '-'); ?></td>
                                        <td><?php echo e($kiwat->total_area ? $kiwat->total_area . ' ' . $kiwat->total_area_unit : '-'); ?>

                                        </td>
                                        <td><span class="badge bg-info"><?php echo e($kiwat->fields_count); ?></span></td>
                                        <td><span class="badge bg-secondary"><?php echo e($kiwat->plots_count); ?></span></td>
                                        <td><span class="badge bg-danger">🔴 <?php echo e($kiwat->available_plots_count); ?></span>
                                        </td>
                                        <td><span class="badge bg-success">🟢 <?php echo e($kiwat->sold_plots_count); ?></span></td>
                                        <td>
                                            <a href="<?php echo e(route('kiwat.show', $kiwat->id)); ?>" class="btn btn-sm btn-info">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('kiwat.edit', $kiwat->id)); ?>" class="btn btn-sm btn-warning">
                                                <i class="ti ti-pencil"></i>
                                            </a>
                                            <form action="<?php echo e(route('kiwat.destroy', $kiwat->id)); ?>" method="POST"
                                                class="d-inline" onsubmit="return confirm('Delete this Kiwat?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button class="btn btn-sm btn-danger"><i class="ti ti-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="9" class="text-center">
                                            <?php echo e(__('No Kiwats found for this Mouza.')); ?>

                                            <a
                                                href="<?php echo e(route('mouza.kiwat.create', $mouza->id)); ?>"><?php echo e(__('Add First Kiwat')); ?></a>
                                        </td>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\2026\Ezitech-AMS-main\resources\views/realEstate/kiwat/index.blade.php ENDPATH**/ ?>
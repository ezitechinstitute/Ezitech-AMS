
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Construction Project - Plots')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Construction Project Gulberg')); ?></li>
    <li class="breadcrumb-item"><?php echo e(__('Plots')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <?php $cp = \App\Models\ConstructionProject::where('created_by', auth()->user()->creatorId())->first(); ?>
        <?php if($cp): ?>
            <a href="<?php echo e(route('construction-project.plot.create', $cp->id)); ?>" class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i> <?php echo e(__('Add Plot')); ?>

            </a>
        <?php endif; ?>
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
                                    <th><?php echo e(__('Project')); ?></th>
                                    <th><?php echo e(__('Plot No')); ?></th>
                                    <th><?php echo e(__('Intiqal No')); ?></th>
                                    <th><?php echo e(__('Purchaser')); ?></th>
                                    <th><?php echo e(__('Area')); ?></th>
                                    <th><?php echo e(__('Amount')); ?></th>
                                    <th><?php echo e(__('Status')); ?></th>
                                    <th><?php echo e(__('Action')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $plots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td><?php echo e($plot->project->name ?? '-'); ?></td>
                                        <td><strong><?php echo e($plot->field_number); ?></strong></td>
                                        <td><?php echo e($plot->intiqal_no ?? '-'); ?></td>
                                        <td><?php echo e($plot->purchaser_name); ?></td>
                                        <td><?php echo e($plot->area_quantity); ?> <?php echo e($plot->area_unit); ?></td>
                                        <td>PKR <?php echo e(number_format($plot->amount, 2)); ?></td>
                                        <td>
                                            <?php if($plot->status == 'available'): ?>
                                                <span class="badge bg-primary">🔵 <?php echo e(__('Available')); ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-success">🟢 <?php echo e(__('Sold')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('construction-project.show', $plot->construction_project_id)); ?>"
                                                class="btn btn-sm btn-info">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('construction-project.plot.edit', $plot->id)); ?>"
                                                class="btn btn-sm btn-warning">
                                                <i class="ti ti-pencil"></i>
                                            </a>
                                            <form action="<?php echo e(route('construction-project.plot.destroy', $plot->id)); ?>"
                                                method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                <button class="btn btn-sm btn-danger"><i class="ti ti-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="9" class="text-center"><?php echo e(__('No plots found.')); ?></td>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\AMS\main_file\resources\views/constructionProject/plot/index.blade.php ENDPATH**/ ?>
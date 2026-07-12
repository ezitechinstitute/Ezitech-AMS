
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Construction Projects')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Construction Projects')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <a href="<?php echo e(route('construction-project.create')); ?>" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i> <?php echo e(__('Add Project')); ?>

        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th><?php echo e(__('Project Name')); ?></th>
                                    <th><?php echo e(__('District')); ?></th>
                                    <th><?php echo e(__('Tehsil')); ?></th>
                                    <th><?php echo e(__('Total Area')); ?></th>
                                    <th><?php echo e(__('Fields')); ?></th>
                                    <th><?php echo e(__('Plots')); ?></th>
                                    <th><?php echo e(__('Action')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($i + 1); ?></td>
                                        <td><a
                                                href="<?php echo e(route('construction-project.show', $project->id)); ?>"><?php echo e($project->name); ?></a>
                                        </td>
                                        <td><?php echo e($project->district ?? '-'); ?></td>
                                        <td><?php echo e($project->tehsil ?? '-'); ?></td>
                                        <td><?php echo e($project->total_area ? $project->total_area . ' ' . $project->total_area_unit : '-'); ?>

                                        </td>
                                        <td><?php echo e($project->fields->count()); ?></td>
                                        <td><?php echo e($project->plots->count()); ?></td>
                                        <td>
                                            <a href="<?php echo e(route('construction-project.show', $project->id)); ?>"
                                                class="btn btn-sm btn-warning"><i class="ti ti-eye"></i></a>
                                            <a href="<?php echo e(route('construction-project.edit', $project->id)); ?>"
                                                class="btn btn-sm btn-info"><i class="ti ti-edit"></i></a>
                                            <form action="<?php echo e(route('construction-project.destroy', $project->id)); ?>"
                                                method="POST" style="display:inline">
                                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Delete?')"><i class="ti ti-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\2026\Ezitech-AMS-main\resources\views/constructionProject/index.blade.php ENDPATH**/ ?>
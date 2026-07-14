
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Add Kiwat')); ?> - <?php echo e($mouza->name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('mouza.index')); ?>"><?php echo e(__('Mouza')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('mouza.show', $mouza->id)); ?>"><?php echo e($mouza->name); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Add Kiwat')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <a href="<?php echo e(route('mouza.show', $mouza->id)); ?>" class="btn btn-sm btn-secondary">
            <i class="ti ti-arrow-left"></i> <?php echo e(__('Back')); ?>

        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><?php echo e(__('Add Kiwat (Block / Phase)')); ?> - <?php echo e($mouza->name); ?></h5>
                </div>
                <div class="card-body">
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($e); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('mouza.kiwat.store', $mouza->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Kiwat Number')); ?> <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="kiwat_number" class="form-control" required
                                        value="<?php echo e(old('kiwat_number')); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Total Area')); ?></label>
                                    <input type="text" name="total_area" class="form-control"
                                        value="<?php echo e(old('total_area')); ?>" placeholder="e.g. 25">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Unit')); ?></label>
                                    <select name="total_area_unit" class="form-control">
                                        <option value="Kanal" <?php echo e(old('total_area_unit') == 'Kanal' ? 'selected' : ''); ?>>
                                            Kanal</option>
                                        <option value="Marla" <?php echo e(old('total_area_unit') == 'Marla' ? 'selected' : ''); ?>>
                                            Marla</option>
                                        <option value="Acre" <?php echo e(old('total_area_unit') == 'Acre' ? 'selected' : ''); ?>>
                                            Acre</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Description')); ?></label>
                                    <textarea name="description" class="form-control" rows="3"><?php echo e(old('description')); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="<?php echo e(route('mouza.show', $mouza->id)); ?>"
                                class="btn btn-secondary"><?php echo e(__('Cancel')); ?></a>
                            <button type="submit" class="btn btn-primary"><?php echo e(__('Save Kiwat')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\2026\Ezitech-AMS-main\resources\views/realEstate/kiwat/create.blade.php ENDPATH**/ ?>
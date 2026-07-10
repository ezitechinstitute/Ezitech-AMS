
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Plot Inventory')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Real Estate')); ?></li>
    <li class="breadcrumb-item"><?php echo e(__('Plot Inventory')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <input type="text" id="area-filter" class="form-control"
                        placeholder="<?php echo e(__('Filter areas by name...')); ?>">
                </div>
            </div>
        </div>

        <?php $__empty_1 = true; $__currentLoopData = $mouzas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mouza): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-md-4 col-sm-6 mb-3 area-card" data-name="<?php echo e(strtolower($mouza->name)); ?>">
                <a href="<?php echo e(route('plot.inventory.area', $mouza->id)); ?>" class="text-decoration-none">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="mb-2"><i class="ti ti-map-pin text-primary"></i> <?php echo e($mouza->name); ?></h5>
                            <p class="text-muted mb-3">
                                <?php echo e($mouza->district ?? '-'); ?><?php echo e($mouza->tehsil ? ', ' . $mouza->tehsil : ''); ?>

                            </p>
                            <div class="d-flex justify-content-between">
                                <span class="badge bg-info p-2"><?php echo e(__('Total')); ?>: <?php echo e($mouza->plots_count); ?></span>
                                <span class="badge bg-danger p-2">🔴 <?php echo e($mouza->available_plots_count); ?></span>
                                <span class="badge bg-success p-2">🟢 <?php echo e($mouza->sold_plots_count); ?></span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center text-muted">
                        <?php echo e(__('No areas with plots yet.')); ?>

                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>
    <script>
        // Simple client-side filter for area cards
        document.getElementById('area-filter').addEventListener('input', function() {
            var q = this.value.trim().toLowerCase();
            document.querySelectorAll('.area-card').forEach(function(card) {
                card.style.display = card.dataset.name.includes(q) ? '' : 'none';
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\2026\Ezitech-AMS-main\resources\views/realEstate/plot/inventory.blade.php ENDPATH**/ ?>
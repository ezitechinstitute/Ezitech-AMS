<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Khait Detail')); ?> - <?php echo e($field->field_number); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('mouza.index')); ?>"><?php echo e(__('Mouza')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('mouza.show', $field->mouza_id)); ?>"><?php echo e($field->mouza->name); ?></a></li>
    <li class="breadcrumb-item"><?php echo e($field->field_number); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <a href="<?php echo e(route('mouza.field.edit', $field->id)); ?>" class="btn btn-sm btn-warning">
            <i class="ti ti-pencil"></i> <?php echo e(__('Edit')); ?>

        </a>
        <a href="<?php echo e(route('mouza.show', $field->mouza_id)); ?>" class="btn btn-sm btn-secondary">
            <i class="ti ti-arrow-left"></i> <?php echo e(__('Back')); ?>

        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">

    
    <div class="col-12 mb-3">
        <?php if($field->status == 'available'): ?>
            <div class="alert alert-danger mb-0"><h5 class="mb-0">🔴 <?php echo e(__('Status: Available (Not Sold)')); ?></h5></div>
        <?php else: ?>
            <div class="alert alert-success mb-0"><h5 class="mb-0">🟢 <?php echo e(__('Status: Sold')); ?></h5></div>
        <?php endif; ?>
    </div>

    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white"><h5 class="mb-0"><?php echo e(__('Field Information')); ?></h5></div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr><td><strong><?php echo e(__('Mouza')); ?></strong></td><td><?php echo e($field->mouza->name); ?></td></tr>
                    <tr><td><strong><?php echo e(__('Field Number')); ?></strong></td><td><?php echo e($field->field_number); ?></td></tr>
                    <tr><td><strong><?php echo e(__('Intiqal No.')); ?></strong></td><td><?php echo e($field->intiqal_no ?? '-'); ?></td></tr>
                    <tr><td><strong><?php echo e(__('Area')); ?></strong></td><td><?php echo e($field->area_quantity); ?> <?php echo e($field->area_unit); ?></td></tr>
                    <tr><td><strong><?php echo e(__('Amount')); ?></strong></td><td><strong>PKR <?php echo e(number_format($field->amount, 2)); ?></strong></td></tr>
                    <tr><td><strong><?php echo e(__('Bank Account')); ?></strong></td><td><?php echo e($field->bankAccount ? $field->bankAccount->bank_name . ' - ' . $field->bankAccount->account_number : '-'); ?></td></tr>
                    <tr><td><strong><?php echo e(__('Notes')); ?></strong></td><td><?php echo e($field->notes ?? '-'); ?></td></tr>
                </table>
            </div>
        </div>
    </div>

    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info text-white"><h5 class="mb-0"><?php echo e(__('Seller Details')); ?></h5></div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr><td><strong><?php echo e(__('Name')); ?></strong></td><td><?php echo e($field->seller_name); ?></td></tr>
                    <tr><td><strong><?php echo e(__('Father Name')); ?></strong></td><td><?php echo e($field->seller_father_name ?? '-'); ?></td></tr>
                    <tr><td><strong><?php echo e(__('CNIC')); ?></strong></td><td><?php echo e($field->seller_cnic ?? '-'); ?></td></tr>
                    <tr><td><strong><?php echo e(__('Phone')); ?></strong></td><td><?php echo e($field->seller_phone ?? '-'); ?></td></tr>
                    <tr><td><strong><?php echo e(__('Address')); ?></strong></td><td><?php echo e($field->seller_address ?? '-'); ?></td></tr>
                </table>
            </div>
        </div>
    </div>

    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-warning text-dark"><h5 class="mb-0"><?php echo e(__('Commission Agent')); ?></h5></div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr><td><strong><?php echo e(__('Name')); ?></strong></td><td><?php echo e($field->agent_name ?? '-'); ?></td></tr>
                    <tr><td><strong><?php echo e(__('CNIC')); ?></strong></td><td><?php echo e($field->agent_cnic ?? '-'); ?></td></tr>
                    <tr><td><strong><?php echo e(__('Phone')); ?></strong></td><td><?php echo e($field->agent_phone ?? '-'); ?></td></tr>
                    <tr><td><strong><?php echo e(__('Address')); ?></strong></td><td><?php echo e($field->agent_address ?? '-'); ?></td></tr>
                    <tr><td><strong><?php echo e(__('Commission')); ?></strong></td><td><strong>PKR <?php echo e(number_format($field->agent_commission, 2)); ?></strong></td></tr>
                </table>
            </div>
        </div>
    </div>

    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-secondary text-white"><h5 class="mb-0"><?php echo e(__('Patwari Expenses')); ?></h5></div>
            <div class="card-body">
                <h6><?php echo e(__('Total')); ?>: <strong>PKR <?php echo e(number_format($field->patwari_total, 2)); ?></strong></h6>
                <?php if($field->patwariExpenses->count() > 0): ?>
                <div class="table-responsive mt-2">
                    <table class="table table-sm table-bordered">
                        <thead class="table-light">
                        <tr>
                            <th><?php echo e(__('Person')); ?></th>
                            <th><?php echo e(__('Amount')); ?></th>
                            <th><?php echo e(__('Note')); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $field->patwariExpenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($pe->person_name); ?></td>
                                <td>PKR <?php echo e(number_format($pe->amount, 2)); ?></td>
                                <td><?php echo e($pe->note ?? '-'); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                    <p class="text-muted"><?php echo e(__('No breakdown added.')); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="col-12">
        <div class="card">
            <div class="card-header" style="background:#6f42c1; color:white;"><h5 class="mb-0"><?php echo e(__('Supporting Documents')); ?></h5></div>
            <div class="card-body">
                <?php if($field->documents->count() > 0): ?>
                <div class="row">
                    <?php $__currentLoopData = $field->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-3 mb-3">
                        <div class="card border">
                            <div class="card-body text-center p-3">
                                <i class="ti ti-file" style="font-size:2rem; color:#6f42c1;"></i>
                                <p class="mb-1 mt-2"><strong><?php echo e($doc->document_name); ?></strong></p>
                                <small class="text-muted"><?php echo e($doc->document_type ?? 'Document'); ?></small>
                                <div class="mt-2">
                                    <a href="<?php echo e(Storage::url($doc->document_path)); ?>" target="_blank" class="btn btn-sm btn-info">
                                        <i class="ti ti-download"></i> View
                                    </a>
                                    <a href="<?php echo e(route('real.estate.document.delete', $doc->id)); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">
                                        <i class="ti ti-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php else: ?>
                    <p class="text-muted"><?php echo e(__('No documents uploaded.')); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\2026\Ezitech-AMS-main\resources\views/realEstate/field/show.blade.php ENDPATH**/ ?>
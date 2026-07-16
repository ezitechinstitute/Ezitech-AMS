
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Sell Plot')); ?> #<?php echo e($plot->field_number); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item">
        <a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a>
    </li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('plot.inventory')); ?>"><?php echo e(__('Plot Inventory')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Sell Plot')); ?> #<?php echo e($plot->field_number); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <a href="<?php echo e(route('plot.inventory')); ?>" class="btn btn-sm btn-secondary">
            <i class="ti ti-arrow-left"></i> <?php echo e(__('Back')); ?>

        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <form action="<?php echo e(route('plot.sell.store', $plot->id)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="row">

            
            <div class="col-12">
                <div class="card border-success">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="ti ti-shopping-cart"></i> <?php echo e(__('Sell Plot')); ?>

                            #<?php echo e($plot->field_number); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <p class="mb-1"><strong><?php echo e(__('Plot No')); ?>:</strong></p>
                                <p class="text-primary fs-5"><?php echo e($plot->field_number); ?></p>
                            </div>
                            <div class="col-md-3">
                                <p class="mb-1"><strong><?php echo e(__('Intiqal No')); ?>:</strong></p>
                                <p><?php echo e($plot->intiqal_no ?? '-'); ?></p>
                            </div>
                            <div class="col-md-3">
                                <p class="mb-1"><strong><?php echo e(__('Area')); ?>:</strong></p>
                                <p><?php echo e($plot->area_quantity); ?> <?php echo e($plot->area_unit); ?></p>
                            </div>
                            <div class="col-md-3">
                                <p class="mb-1"><strong><?php echo e(__('Amount')); ?>:</strong></p>
                                <p class="text-success fs-5"><strong>PKR <?php echo e(number_format($plot->amount, 2)); ?></strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-md-6 mt-3">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="ti ti-user"></i> <?php echo e(__('Purchaser Details')); ?></h5>
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
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Purchaser Full Name')); ?> <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="purchaser_name" class="form-control" required
                                value="<?php echo e(old('purchaser_name')); ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Father Name')); ?></label>
                            <input type="text" name="purchaser_father_name" class="form-control"
                                value="<?php echo e(old('purchaser_father_name')); ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('CNIC No.')); ?></label>
                            <input type="text" name="purchaser_cnic" class="form-control" placeholder="xxxxx-xxxxxxx-x"
                                value="<?php echo e(old('purchaser_cnic')); ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Phone')); ?></label>
                            <input type="text" name="purchaser_phone" class="form-control"
                                value="<?php echo e(old('purchaser_phone')); ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Address')); ?></label>
                            <textarea name="purchaser_address" class="form-control" rows="2"><?php echo e(old('purchaser_address')); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-md-6 mt-3">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="ti ti-users"></i> <?php echo e(__('Commission Agent')); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Agent Name')); ?></label>
                            <input type="text" name="agent_name" class="form-control" value="<?php echo e(old('agent_name')); ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Agent CNIC')); ?></label>
                            <input type="text" name="agent_cnic" class="form-control" value="<?php echo e(old('agent_cnic')); ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Agent Phone')); ?></label>
                            <input type="text" name="agent_phone" class="form-control" value="<?php echo e(old('agent_phone')); ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Agent Address')); ?></label>
                            <textarea name="agent_address" class="form-control" rows="2"><?php echo e(old('agent_address')); ?></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Commission Amount (PKR)')); ?></label>
                            <input type="number" name="agent_commission" class="form-control" step="0.01"
                                value="<?php echo e(old('agent_commission', 0)); ?>">
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="ti ti-receipt"></i> <?php echo e(__('Patwari Expenses')); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Total Patwari Expense (PKR)')); ?></label>
                            <input type="number" name="patwari_total" class="form-control" step="0.01"
                                value="<?php echo e(old('patwari_total', 0)); ?>">
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th><?php echo e(__('Person Name')); ?></th>
                                        <th><?php echo e(__('Amount (PKR)')); ?></th>
                                        <th><?php echo e(__('Note / Reason')); ?></th>
                                        <th>
                                            <button type="button" class="btn btn-sm btn-success"
                                                onclick="addPatwariRow()">
                                                <i class="ti ti-plus"></i>
                                            </button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="patwari-body">
                                    <tr>
                                        <td><input type="text" name="patwari_person[]"
                                                class="form-control form-control-sm"></td>
                                        <td><input type="number" name="patwari_amount[]"
                                                class="form-control form-control-sm" step="0.01"></td>
                                        <td><input type="text" name="patwari_note[]"
                                                class="form-control form-control-sm"></td>
                                        <td><button type="button" class="btn btn-sm btn-danger"
                                                onclick="this.closest('tr').remove()"><i class="ti ti-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-md-6 mt-3">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="ti ti-building-bank"></i> <?php echo e(__('Bank Link')); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Select Bank Account')); ?></label>
                            <select name="bank_account_id" class="form-control">
                                <option value="">-- <?php echo e(__('Select Bank Account')); ?> --</option>
                                <?php $__currentLoopData = $bankAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($bank->id); ?>"
                                        <?php echo e(old('bank_account_id') == $bank->id ? 'selected' : ''); ?>>
                                        <?php echo e($bank->bank_name); ?> - <?php echo e($bank->account_number); ?> (<?php echo e($bank->holder_name); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <small class="text-muted">
                            <?php echo e(__("Don't see your bank?")); ?>

                            <a href="<?php echo e(route('bank-account.create')); ?>"
                                target="_blank"><?php echo e(__('Add New Bank Account')); ?></a>
                        </small>
                    </div>
                </div>
            </div>

            
            <div class="col-md-6 mt-3">
                <div class="card">
                    <div class="card-header" style="background:#6f42c1; color:white;">
                        <h5 class="mb-0"><i class="ti ti-paperclip"></i> <?php echo e(__('Supporting Documents')); ?></h5>
                    </div>
                    <div class="card-body">
                        <div id="documents-wrapper">
                            <div class="doc-row row mb-2 align-items-center">
                                <div class="col-4">
                                    <select name="document_types[]" class="form-control form-control-sm">
                                        <option value="">-- Type --</option>
                                        <option value="Fard">Fard</option>
                                        <option value="Intiqal">Intiqal</option>
                                        <option value="Registry">Registry</option>
                                        <option value="CNIC Copy">CNIC Copy</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <input type="text" name="document_names[]" class="form-control form-control-sm"
                                        placeholder="Document Name">
                                </div>
                                <div class="col-3">
                                    <input type="file" name="documents[]" class="form-control form-control-sm">
                                </div>
                                <div class="col-1">
                                    <button type="button" class="btn btn-sm btn-success" onclick="addDocRow()"><i
                                            class="ti ti-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Notes / Remarks')); ?></label>
                            <textarea name="notes" class="form-control" rows="2"><?php echo e(old('notes')); ?></textarea>
                        </div>
                        <div class="text-end">
                            <a href="<?php echo e(route('plot.inventory')); ?>" class="btn btn-secondary"><?php echo e(__('Cancel')); ?></a>
                            <button type="submit" class="btn btn-success">
                                <i class="ti ti-check"></i> <?php echo e(__('Confirm Sale')); ?>

                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>
    <script>
        function addPatwariRow() {
            var html = '<tr>' +
                '<td><input type="text" name="patwari_person[]" class="form-control form-control-sm"></td>' +
                '<td><input type="number" name="patwari_amount[]" class="form-control form-control-sm" step="0.01"></td>' +
                '<td><input type="text" name="patwari_note[]" class="form-control form-control-sm"></td>' +
                '<td><button type="button" class="btn btn-sm btn-danger" onclick="this.closest(\'tr\').remove()"><i class="ti ti-trash"></i></button></td>' +
                '</tr>';
            document.getElementById('patwari-body').insertAdjacentHTML('beforeend', html);
        }

        function addDocRow() {
            var html = '<div class="doc-row row mb-2 align-items-center">' +
                '<div class="col-4"><select name="document_types[]" class="form-control form-control-sm">' +
                '<option value="">-- Type --</option><option value="Fard">Fard</option>' +
                '<option value="Intiqal">Intiqal</option><option value="Registry">Registry</option>' +
                '<option value="CNIC Copy">CNIC Copy</option><option value="Other">Other</option></select></div>' +
                '<div class="col-4"><input type="text" name="document_names[]" class="form-control form-control-sm" placeholder="Document Name"></div>' +
                '<div class="col-3"><input type="file" name="documents[]" class="form-control form-control-sm"></div>' +
                '<div class="col-1"><button type="button" class="btn btn-sm btn-danger" onclick="this.closest(\'.doc-row\').remove()"><i class="ti ti-trash"></i></button></div>' +
                '</div>';
            document.getElementById('documents-wrapper').insertAdjacentHTML('beforeend', html);
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\2026\Ezitech-AMS-main\resources\views/realEstate/plot/sell.blade.php ENDPATH**/ ?>

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Edit Plot')); ?> - <?php echo e($plot->field_number); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item">
        <a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a>
    </li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('plot.index')); ?>"><?php echo e(__('Plots')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Edit')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <a href="<?php echo e(route('plot.show', $plot->id)); ?>" class="btn btn-sm btn-secondary">
            <i class="ti ti-arrow-left"></i> <?php echo e(__('Back')); ?>

        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><?php echo e(__('Edit Plot')); ?></h5>
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

                    <form action="<?php echo e(route('plot.update', $plot->id)); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        
                        <h6 class="text-primary mb-3"><?php echo e(__('Plot Information')); ?></h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Field Number')); ?> <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="field_number" class="form-control" required
                                        value="<?php echo e(old('field_number', $plot->field_number)); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Intiqal No.')); ?></label>
                                    <input type="text" name="intiqal_no" class="form-control"
                                        value="<?php echo e(old('intiqal_no', $plot->intiqal_no)); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Status')); ?></label>
                                    <select name="status" class="form-select">
                                        <option value="available"
                                            <?php echo e(old('status', $plot->status) == 'available' ? 'selected' : ''); ?>>
                                            <?php echo e(__('Available')); ?></option>
                                        <option value="sold"
                                            <?php echo e(old('status', $plot->status) == 'sold' ? 'selected' : ''); ?>>
                                            <?php echo e(__('Sold')); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Area Quantity')); ?> <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="area_quantity" class="form-control" required
                                        value="<?php echo e(old('area_quantity', $plot->area_quantity)); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Area Unit')); ?></label>
                                    <input type="text" name="area_unit" class="form-control"
                                        value="<?php echo e(old('area_unit', $plot->area_unit)); ?>" placeholder="Marla">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Amount (PKR)')); ?> <span
                                            class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="amount" class="form-control" required
                                        value="<?php echo e(old('amount', $plot->amount)); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Latitude')); ?></label>
                                    <input type="text" name="latitude" id="field_lat" class="form-control"
                                        value="<?php echo e(old('latitude', $plot->latitude)); ?>" placeholder="For map pin">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Longitude')); ?></label>
                                    <input type="text" name="longitude" id="field_lng" class="form-control"
                                        value="<?php echo e(old('longitude', $plot->longitude)); ?>" placeholder="For map pin">
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label"><?php echo e(__('Field Location on Map')); ?></label>
                                <div id="field-map-picker" style="height:280px; border-radius:8px; border:1px solid #ddd;">
                                </div>
                                <small class="text-muted"><?php echo e(__('Click on map or drag pin to update location')); ?></small>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Bank Account')); ?></label>
                                    <select name="bank_account_id" class="form-select">
                                        <option value=""><?php echo e(__('-- Select --')); ?></option>
                                        <?php $__currentLoopData = $bankAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($bank->id); ?>"
                                                <?php echo e(old('bank_account_id', $plot->bank_account_id) == $bank->id ? 'selected' : ''); ?>>
                                                <?php echo e($bank->bank_name); ?> - <?php echo e($bank->account_number); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Notes')); ?></label>
                                    <textarea name="notes" class="form-control" rows="2"><?php echo e(old('notes', $plot->notes)); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <hr>

                        
                        <h6 class="text-info mb-3"><?php echo e(__('Purchaser Details')); ?></h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Name')); ?> <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="purchaser_name" class="form-control" required
                                        value="<?php echo e(old('purchaser_name', $plot->purchaser_name)); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Father Name')); ?></label>
                                    <input type="text" name="purchaser_father_name" class="form-control"
                                        value="<?php echo e(old('purchaser_father_name', $plot->purchaser_father_name)); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('CNIC')); ?></label>
                                    <input type="text" name="purchaser_cnic" class="form-control"
                                        value="<?php echo e(old('purchaser_cnic', $plot->purchaser_cnic)); ?>"
                                        placeholder="XXXXX-XXXXXXX-X">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Phone')); ?></label>
                                    <input type="text" name="purchaser_phone" class="form-control"
                                        value="<?php echo e(old('purchaser_phone', $plot->purchaser_phone)); ?>">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Address')); ?></label>
                                    <input type="text" name="purchaser_address" class="form-control"
                                        value="<?php echo e(old('purchaser_address', $plot->purchaser_address)); ?>">
                                </div>
                            </div>
                        </div>

                        <hr>

                        
                        <h6 class="text-warning mb-3"><?php echo e(__('Commission Agent')); ?></h6>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Name')); ?></label>
                                    <input type="text" name="agent_name" class="form-control"
                                        value="<?php echo e(old('agent_name', $plot->agent_name)); ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('CNIC')); ?></label>
                                    <input type="text" name="agent_cnic" class="form-control"
                                        value="<?php echo e(old('agent_cnic', $plot->agent_cnic)); ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Phone')); ?></label>
                                    <input type="text" name="agent_phone" class="form-control"
                                        value="<?php echo e(old('agent_phone', $plot->agent_phone)); ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Commission (PKR)')); ?></label>
                                    <input type="number" step="0.01" name="agent_commission" class="form-control"
                                        value="<?php echo e(old('agent_commission', $plot->agent_commission)); ?>">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Address')); ?></label>
                                    <input type="text" name="agent_address" class="form-control"
                                        value="<?php echo e(old('agent_address', $plot->agent_address)); ?>">
                                </div>
                            </div>
                        </div>

                        <hr>

                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="text-secondary mb-0"><?php echo e(__('Patwari Expense Breakdown')); ?></h6>
                            <button type="button" id="add-patwari-row" class="btn btn-sm btn-outline-secondary">
                                <i class="ti ti-plus"></i> <?php echo e(__('Add Row')); ?>

                            </button>
                        </div>
                        <div class="table-responsive mb-2">
                            <table class="table table-sm table-bordered" id="patwari-table">
                                <thead class="table-light">
                                    <tr>
                                        <th><?php echo e(__('Person')); ?></th>
                                        <th><?php echo e(__('Amount')); ?></th>
                                        <th><?php echo e(__('Note')); ?></th>
                                        <th style="width:50px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $plot->patwariExpenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><input type="text" name="patwari_person[]"
                                                    class="form-control form-control-sm" value="<?php echo e($pe->person_name); ?>">
                                            </td>
                                            <td><input type="number" step="0.01" name="patwari_amount[]"
                                                    class="form-control form-control-sm" value="<?php echo e($pe->amount); ?>">
                                            </td>
                                            <td><input type="text" name="patwari_note[]"
                                                    class="form-control form-control-sm" value="<?php echo e($pe->note); ?>">
                                            </td>
                                            <td><button type="button" class="btn btn-sm btn-danger remove-row"><i
                                                        class="ti ti-trash"></i></button></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td><input type="text" name="patwari_person[]"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" step="0.01" name="patwari_amount[]"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="text" name="patwari_note[]"
                                                    class="form-control form-control-sm"></td>
                                            <td><button type="button" class="btn btn-sm btn-danger remove-row"><i
                                                        class="ti ti-trash"></i></button></td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Patwari Total (PKR)')); ?></label>
                                    <input type="number" step="0.01" name="patwari_total" id="patwari_total"
                                        class="form-control" value="<?php echo e(old('patwari_total', $plot->patwari_total)); ?>">
                                    <small
                                        class="text-muted"><?php echo e(__('Auto-sums from rows above; you can override manually.')); ?></small>
                                </div>
                            </div>
                        </div>

                        <hr>

                        
                        <h6 class="mb-3" style="color:#6f42c1;"><?php echo e(__('Existing Documents')); ?></h6>
                        <?php if($plot->documents->count() > 0): ?>
                            <div class="row mb-3">
                                <?php $__currentLoopData = $plot->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-3 mb-3">
                                        <div class="card border">
                                            <div class="card-body text-center p-3">
                                                <i class="ti ti-file" style="font-size:2rem; color:#6f42c1;"></i>
                                                <p class="mb-1 mt-2"><strong><?php echo e($doc->document_name); ?></strong></p>
                                                <small class="text-muted"><?php echo e($doc->document_type ?? 'Document'); ?></small>
                                                <div class="mt-2">
                                                    <a href="<?php echo e(Storage::url($doc->document_path)); ?>" target="_blank"
                                                        class="btn btn-sm btn-info"><i class="ti ti-download"></i></a>
                                                    <a href="<?php echo e(route('real.estate.document.delete', $doc->id)); ?>"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Delete?')"><i
                                                            class="ti ti-trash"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <p class="text-muted"><?php echo e(__('No documents uploaded yet.')); ?></p>
                        <?php endif; ?>

                        
                        <h6 class="mb-3" style="color:#6f42c1;"><?php echo e(__('Upload New Documents')); ?></h6>
                        <div class="table-responsive mb-3">
                            <table class="table table-sm table-bordered" id="documents-table">
                                <thead class="table-light">
                                    <tr>
                                        <th><?php echo e(__('File')); ?></th>
                                        <th><?php echo e(__('Name')); ?></th>
                                        <th><?php echo e(__('Type')); ?></th>
                                        <th style="width:50px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="file" name="documents[]"
                                                class="form-control form-control-sm"></td>
                                        <td><input type="text" name="document_names[]"
                                                class="form-control form-control-sm" placeholder="e.g. Sale Deed"></td>
                                        <td><input type="text" name="document_types[]"
                                                class="form-control form-control-sm" placeholder="e.g. PDF/Image"></td>
                                        <td><button type="button" class="btn btn-sm btn-danger remove-row"><i
                                                    class="ti ti-trash"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button type="button" id="add-document-row" class="btn btn-sm btn-outline-secondary mb-4">
                            <i class="ti ti-plus"></i> <?php echo e(__('Add Document Row')); ?>

                        </button>

                        <div class="text-end">
                            <a href="<?php echo e(route('plot.show', $plot->id)); ?>"
                                class="btn btn-secondary"><?php echo e(__('Cancel')); ?></a>
                            <button type="submit" class="btn btn-primary"><?php echo e(__('Update Plot')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>
    <script>
        (function() {
            // Add / remove Patwari rows
            document.getElementById('add-patwari-row').addEventListener('click', function() {
                var tbody = document.querySelector('#patwari-table tbody');
                var row = document.createElement('tr');
                row.innerHTML =
                    '<td><input type="text" name="patwari_person[]" class="form-control form-control-sm"></td>' +
                    '<td><input type="number" step="0.01" name="patwari_amount[]" class="form-control form-control-sm"></td>' +
                    '<td><input type="text" name="patwari_note[]" class="form-control form-control-sm"></td>' +
                    '<td><button type="button" class="btn btn-sm btn-danger remove-row"><i class="ti ti-trash"></i></button></td>';
                tbody.appendChild(row);
            });

            // Add document row
            document.getElementById('add-document-row').addEventListener('click', function() {
                var tbody = document.querySelector('#documents-table tbody');
                var row = document.createElement('tr');
                row.innerHTML =
                    '<td><input type="file" name="documents[]" class="form-control form-control-sm"></td>' +
                    '<td><input type="text" name="document_names[]" class="form-control form-control-sm" placeholder="e.g. Sale Deed"></td>' +
                    '<td><input type="text" name="document_types[]" class="form-control form-control-sm" placeholder="e.g. PDF/Image"></td>' +
                    '<td><button type="button" class="btn btn-sm btn-danger remove-row"><i class="ti ti-trash"></i></button></td>';
                tbody.appendChild(row);
            });

            // Remove row (delegated, works for dynamically added rows too)
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-row')) {
                    var row = e.target.closest('tr');
                    var tbody = row.parentElement;
                    if (tbody.rows.length > 1) {
                        row.remove();
                        recalcPatwariTotal();
                    } else {
                        // clear inputs instead of removing the last row
                        row.querySelectorAll('input').forEach(function(input) {
                            input.value = '';
                        });
                    }
                }
            });

            // Auto-sum patwari total whenever amount inputs change
            function recalcPatwariTotal() {
                var total = 0;
                document.querySelectorAll('input[name="patwari_amount[]"]').forEach(function(input) {
                    total += parseFloat(input.value) || 0;
                });
                document.getElementById('patwari_total').value = total.toFixed(2);
            }

            document.addEventListener('input', function(e) {
                if (e.target.matches('input[name="patwari_amount[]"]')) {
                    recalcPatwariTotal();
                }
            });
        })();
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-page'); ?>
    <script>
        function initFieldMap() {
            var lat = parseFloat(document.getElementById('field_lat').value) ||
                <?php echo e($plot->latitude ?? ($plot->mouza->latitude ?? 31.5204)); ?>;
            var lng = parseFloat(document.getElementById('field_lng').value) ||
                <?php echo e($plot->longitude ?? ($plot->mouza->longitude ?? 74.3587)); ?>;

            var map = new google.maps.Map(document.getElementById('field-map-picker'), {
                center: {
                    lat: lat,
                    lng: lng
                },
                zoom: <?php echo e($plot->latitude ? 17 : 15); ?>

            });

            var marker = new google.maps.Marker({
                position: {
                    lat: lat,
                    lng: lng
                },
                map: map,
                draggable: true
            });

            google.maps.event.addListener(map, 'click', function(event) {
                marker.setPosition(event.latLng);
                document.getElementById('field_lat').value = event.latLng.lat().toFixed(7);
                document.getElementById('field_lng').value = event.latLng.lng().toFixed(7);
            });

            google.maps.event.addListener(marker, 'dragend', function(event) {
                document.getElementById('field_lat').value = event.latLng.lat().toFixed(7);
                document.getElementById('field_lng').value = event.latLng.lng().toFixed(7);
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(env('GOOGLE_MAPS_API_KEY', '')); ?>&callback=initFieldMap"
        async defer></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\2026\Ezitech-AMS-main\resources\views/realEstate/plot/edit.blade.php ENDPATH**/ ?>
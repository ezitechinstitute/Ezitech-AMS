
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Add Khait')); ?> - <?php echo e($mouza->name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('mouza.index')); ?>"><?php echo e(__('Mouza')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('mouza.show', $mouza->id)); ?>"><?php echo e($mouza->name); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Add Khait')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css-page'); ?>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #field-map-picker {
            height: 320px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .field-row {
            background: #f8f9fa;
            border-radius: 8px;
            position: relative;
        }

        .field-row .field-index-badge {
            position: absolute;
            top: -10px;
            left: 10px;
            background: #0d6efd;
            color: #fff;
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 10px;
        }

        .pick-on-map-btn.active {
            background: #198754 !important;
            color: #fff !important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <form action="<?php echo e(route('mouza.field.store', $mouza->id)); ?>" method="POST" enctype="multipart/form-data" novalidate>
        <?php echo csrf_field(); ?>
        <div class="row">

            
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="ti ti-file-text"></i> <?php echo e(__('Intiqal / Deal Information')); ?></h5>
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
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Mutation No.')); ?></label>
                                    <input type="text" name="intiqal_no" class="form-control"
                                        value="<?php echo e(old('intiqal_no', $mouza->intiqal_number)); ?>">
                                    <small
                                        class="text-muted"><?php echo e(__('One Mutation can have multiple Field Numbers.')); ?></small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Kiwat (Block/Phase)')); ?> <span
                                            class="text-danger">*</span></label>
                                    <select name="kiwat_id" id="kiwat_select" class="form-control" required>
                                        <option value="">-- <?php echo e(__('Select Kiwat')); ?> --</option>
                                        <?php $__currentLoopData = $kiwats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kiwat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($kiwat->id); ?>"
                                                <?php echo e(old('kiwat_id') == $kiwat->id ? 'selected' : ''); ?>>
                                                <?php echo e($kiwat->kiwat_number); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <option value="new" <?php echo e(old('kiwat_id') == 'new' ? 'selected' : ''); ?>>
                                            + <?php echo e(__('Add New Kiwat')); ?>

                                        </option>
                                    </select>
                                </div>
                            </div>

                            
                            <div class="col-12" id="new-kiwat-fields" style="display:none;">
                                <div class="alert alert-light border mb-3">
                                    <h6 class="mb-3"><i class="ti ti-stack"></i> <?php echo e(__('New Kiwat Details')); ?></h6>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3 mb-md-0">
                                                <label class="form-label"><?php echo e(__('Kiwat Number')); ?> <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="new_kiwat_number" id="new_kiwat_number"
                                                    class="form-control" value="<?php echo e(old('new_kiwat_number')); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group mb-3 mb-md-0">
                                                <label class="form-label"><?php echo e(__('Total Area')); ?></label>
                                                <input type="text" name="new_kiwat_total_area" class="form-control"
                                                    value="<?php echo e(old('new_kiwat_total_area')); ?>" placeholder="e.g. 25">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group mb-3 mb-md-0">
                                                <label class="form-label"><?php echo e(__('Unit')); ?></label>
                                                <select name="new_kiwat_total_area_unit" class="form-control">
                                                    <option value="Kanal">Kanal</option>
                                                    <option value="Marla">Marla</option>
                                                    <option value="Acre">Acre</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3 mb-md-0">
                                                <label class="form-label"><?php echo e(__('Description')); ?></label>
                                                <input type="text" name="new_kiwat_description" class="form-control"
                                                    value="<?php echo e(old('new_kiwat_description')); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Total Deal Amount (PKR)')); ?> <span
                                            class="text-danger">*</span></label>
                                    <input type="number" name="amount" class="form-control" required
                                        value="<?php echo e(old('amount')); ?>" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="ti ti-map-2"></i> <?php echo e(__('Field Information')); ?></h5>
                        <button type="button" class="btn btn-sm btn-light" onclick="addFieldRow()">
                            <i class="ti ti-plus"></i> <?php echo e(__('Add Another Field Number')); ?>

                        </button>
                    </div>
                    <div class="card-body">

                        <div id="fields-wrapper">
                            
                            <div class="field-row row mb-3 p-3 border" data-index="0">
                                <span class="field-index-badge"><?php echo e(__('Field')); ?> #1</span>

                                <div class="col-md-3">
                                    <div class="form-group mb-2">
                                        <label class="form-label"><?php echo e(__('Field Number')); ?> <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="fields[0][field_number]" class="form-control"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-2">
                                        <label class="form-label"><?php echo e(__('Status')); ?></label>
                                        <select name="fields[0][status]" class="form-control">
                                            <option value="available">🔴 <?php echo e(__('Available')); ?></option>
                                            <option value="reserved">🟡 <?php echo e(__('Reserved')); ?></option>
                                            <option value="sold">🟢 <?php echo e(__('Sold')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-2">
                                        <label class="form-label"><?php echo e(__('Map Location')); ?></label>
                                        <button type="button"
                                            class="btn btn-outline-primary btn-sm w-100 pick-on-map-btn"
                                            onclick="setActiveRow(this)">
                                            <i class="ti ti-map-pin"></i> <span
                                                class="pin-status"><?php echo e(__('Not set - click to pick')); ?></span>
                                        </button>
                                        <input type="hidden" name="fields[0][latitude]" class="field-lat-input">
                                        <input type="hidden" name="fields[0][longitude]" class="field-lng-input">
                                    </div>
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-sm btn-danger mb-2 remove-field-btn"
                                        onclick="removeFieldRow(this)" style="display:none;">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </div>

                                <div class="col-12">
                                    <hr class="my-2">
                                    <label class="form-label mb-1"><strong><?php echo e(__('Land Area')); ?></strong> <span
                                            class="text-danger">*</span>
                                        <small class="text-muted">(<?php echo e(__('enter in any combination')); ?>)</small>
                                    </label>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-2">
                                        <label class="form-label small"><?php echo e(__('Acre')); ?></label>
                                        <input type="number" min="0" step="1" name="fields[0][area_acre]"
                                            class="form-control area-part-input" value="0">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-2">
                                        <label class="form-label small"><?php echo e(__('Kanal')); ?></label>
                                        <input type="number" min="0" max="7" step="1"
                                            name="fields[0][area_kanal]" class="form-control area-part-input"
                                            value="0">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-2">
                                        <label class="form-label small"><?php echo e(__('Marla')); ?></label>
                                        <input type="number" min="0" max="19" step="1"
                                            name="fields[0][area_marla]" class="form-control area-part-input"
                                            value="0">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-2">
                                        <label class="form-label small"><?php echo e(__('Total (in Marla)')); ?></label>
                                        <input type="text" class="form-control bg-light total-marla-display" readonly
                                            value="0">
                                        <input type="hidden" name="fields[0][total_marla]" class="total-marla-input"
                                            value="0">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-2 mt-3">
                            <label class="form-label"><?php echo e(__('Pick Location on Map')); ?></label>
                            <div id="field-map-picker"></div>
                            <small class="text-muted" id="map-instruction">
                                <?php echo e(__('Click "Map Location" button on a field row above, then click on the map to set its pin.')); ?>

                            </small>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="ti ti-user"></i> <?php echo e(__('Seller Details')); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Seller Full Name')); ?> <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="seller_name" class="form-control" required
                                value="<?php echo e(old('seller_name')); ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Father Name')); ?></label>
                            <input type="text" name="seller_father_name" class="form-control"
                                value="<?php echo e(old('seller_father_name')); ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('CNIC No.')); ?></label>
                            <input type="text" name="seller_cnic" class="form-control" placeholder="xxxxx-xxxxxxx-x"
                                value="<?php echo e(old('seller_cnic')); ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Phone')); ?></label>
                            <input type="text" name="seller_phone" class="form-control"
                                value="<?php echo e(old('seller_phone')); ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Address')); ?></label>
                            <textarea name="seller_address" class="form-control" rows="2"><?php echo e(old('seller_address')); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="ti ti-users"></i> <?php echo e(__('Commission Agent Details')); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Agent Full Name')); ?></label>
                            <input type="text" name="agent_name" class="form-control"
                                value="<?php echo e(old('agent_name')); ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Agent CNIC')); ?></label>
                            <input type="text" name="agent_cnic" class="form-control" placeholder="xxxxx-xxxxxxx-x"
                                value="<?php echo e(old('agent_cnic')); ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Agent Phone')); ?></label>
                            <input type="text" name="agent_phone" class="form-control"
                                value="<?php echo e(old('agent_phone')); ?>">
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

            
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="ti ti-receipt"></i> <?php echo e(__('Patwari Expenses')); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Total Patwari Expense (PKR)')); ?></label>
                            <input type="number" name="patwari_total" id="patwari_total" class="form-control"
                                step="0.01" value="<?php echo e(old('patwari_total', 0)); ?>">
                        </div>
                        <label
                            class="form-label"><strong><?php echo e(__('Breakdown (Amount Paid to Each Person)')); ?></strong></label>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="patwari-table">
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
                                                onclick="removeRow(this)"><i class="ti ti-trash"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-md-6">
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
                                        <?php echo e($bank->bank_name); ?> - <?php echo e($bank->account_number); ?>

                                        (<?php echo e($bank->holder_name); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <small class="text-muted">
                            <?php echo e(__("Don't see your bank?")); ?>

                            <a href="<?php echo e(route('bank-account.create')); ?>"
                                target="_blank"><?php echo e(__('Add New Bank Account')); ?></a>
                            <?php echo e(__('then come back here.')); ?>

                        </small>
                    </div>
                </div>
            </div>

            
            <div class="col-md-6">
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
                                        <option value="Intiqal">Mutation</option>
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

            
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Notes / Remarks')); ?></label>
                            <textarea name="notes" class="form-control" rows="2"><?php echo e(old('notes')); ?></textarea>
                        </div>
                        <div class="text-end">
                            <a href="<?php echo e(route('mouza.show', $mouza->id)); ?>"
                                class="btn btn-secondary"><?php echo e(__('Cancel')); ?></a>
                            <button type="submit" class="btn btn-primary"><i class="ti ti-check"></i>
                                <?php echo e(__('Save Khait')); ?></button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        // ================= Patwari rows =================
        function addPatwariRow() {
            var html = '<tr>' +
                '<td><input type="text" name="patwari_person[]" class="form-control form-control-sm"></td>' +
                '<td><input type="number" name="patwari_amount[]" class="form-control form-control-sm" step="0.01"></td>' +
                '<td><input type="text" name="patwari_note[]" class="form-control form-control-sm"></td>' +
                '<td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)"><i class="ti ti-trash"></i></button></td>' +
                '</tr>';
            document.getElementById('patwari-body').insertAdjacentHTML('beforeend', html);
        }

        // ================= Document rows =================
        function addDocRow() {
            var html = '<div class="doc-row row mb-2 align-items-center">' +
                '<div class="col-4"><select name="document_types[]" class="form-control form-control-sm">' +
                '<option value="">-- Type --</option>' +
                '<option value="Fard">Fard</option><option value="Intiqal">Intiqal</option>' +
                '<option value="Registry">Registry</option><option value="CNIC Copy">CNIC Copy</option>' +
                '<option value="Other">Other</option></select></div>' +
                '<div class="col-4"><input type="text" name="document_names[]" class="form-control form-control-sm" placeholder="Document Name"></div>' +
                '<div class="col-3"><input type="file" name="documents[]" class="form-control form-control-sm"></div>' +
                '<div class="col-1"><button type="button" class="btn btn-sm btn-danger" onclick="this.closest(\'.doc-row\').remove()"><i class="ti ti-trash"></i></button></div>' +
                '</div>';
            document.getElementById('documents-wrapper').insertAdjacentHTML('beforeend', html);
        }

        function removeRow(btn) {
            btn.closest('tr').remove();
        }

        // ================= Land Area Conversion (Acre / Kanal / Marla -> Total Marla) =================
        // Standard Pakistani revenue conversion: 1 Acre = 8 Kanal, 1 Kanal = 20 Marla
        var MARLA_PER_KANAL = 20;
        var KANAL_PER_ACRE = 8;

        function calculateRowTotal(row) {
            var acre = parseFloat(row.querySelector('[name*="[area_acre]"]').value) || 0;
            var kanal = parseFloat(row.querySelector('[name*="[area_kanal]"]').value) || 0;
            var marla = parseFloat(row.querySelector('[name*="[area_marla]"]').value) || 0;

            var totalMarla = (acre * KANAL_PER_ACRE * MARLA_PER_KANAL) + (kanal * MARLA_PER_KANAL) + marla;

            row.querySelector('.total-marla-display').value = totalMarla;
            row.querySelector('.total-marla-input').value = totalMarla;
        }

        function attachAreaListeners(row) {
            if (!row) return;
            row.querySelectorAll('.area-part-input').forEach(function(input) {
                input.addEventListener('input', function() {
                    calculateRowTotal(row);
                });
            });
        }

        // ================= Field Number Repeater + Shared Map =================
        var fieldRowCounter = 1; // index 0 already exists in HTML
        var fieldMarkers = {}; // index -> leaflet marker
        var activeFieldIndex = 0; // which row's pin the next map click will set
        var map, defaultLat, defaultLng;

        function addFieldRow() {
            var idx = fieldRowCounter;
            var html = `
                <div class="field-row row mb-3 p-3 border" data-index="${idx}">
                    <span class="field-index-badge"><?php echo e(__('Field')); ?> #${idx + 1}</span>
                    <div class="col-md-3">
                        <div class="form-group mb-2">
                            <label class="form-label"><?php echo e(__('Field Number')); ?> <span class="text-danger">*</span></label>
                            <input type="text" name="fields[${idx}][field_number]" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-2">
                            <label class="form-label"><?php echo e(__('Status')); ?></label>
                            <select name="fields[${idx}][status]" class="form-control">
                                <option value="available">🔴 <?php echo e(__('Available')); ?></option>
                                <option value="reserved">🟡 <?php echo e(__('Reserved')); ?></option>
                                <option value="sold">🟢 <?php echo e(__('Sold')); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-2">
                            <label class="form-label"><?php echo e(__('Map Location')); ?></label>
                            <button type="button" class="btn btn-outline-primary btn-sm w-100 pick-on-map-btn" onclick="setActiveRow(this)">
                                <i class="ti ti-map-pin"></i> <span class="pin-status"><?php echo e(__('Not set - click to pick')); ?></span>
                            </button>
                            <input type="hidden" name="fields[${idx}][latitude]" class="field-lat-input">
                            <input type="hidden" name="fields[${idx}][longitude]" class="field-lng-input">
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-sm btn-danger mb-2 remove-field-btn" onclick="removeFieldRow(this)">
                            <i class="ti ti-trash"></i>
                        </button>
                    </div>

                    <div class="col-12">
                        <hr class="my-2">
                        <label class="form-label mb-1"><strong><?php echo e(__('Land Area')); ?></strong> <span class="text-danger">*</span>
                            <small class="text-muted">(<?php echo e(__('enter in any combination')); ?>)</small>
                        </label>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-2">
                            <label class="form-label small"><?php echo e(__('Acre')); ?></label>
                            <input type="number" min="0" step="1" name="fields[${idx}][area_acre]" class="form-control area-part-input" value="0">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-2">
                            <label class="form-label small"><?php echo e(__('Kanal')); ?></label>
                            <input type="number" min="0" max="7" step="1" name="fields[${idx}][area_kanal]" 
                                class="form-control area-part-input" value="0"
                                oninvalid="this.setCustomValidity('Kanal value must be between 0 and 7 (8 Kanal = 1 Acre)')"
                                oninput="this.setCustomValidity('')">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-2">
                            <label class="form-label small"><?php echo e(__('Marla')); ?></label>
                            <input type="number" min="0" max="19" step="1" name="fields[${idx}][area_marla]" class="form-control area-part-input" value="0">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-2">
                            <label class="form-label small"><?php echo e(__('Total (in Marla)')); ?></label>
                            <input type="text" class="form-control bg-light total-marla-display" readonly value="0">
                            <input type="hidden" name="fields[${idx}][total_marla]" class="total-marla-input" value="0">
                        </div>
                    </div>
                </div>`;
            document.getElementById('fields-wrapper').insertAdjacentHTML('beforeend', html);
            fieldRowCounter++;
            updateRemoveButtons();
            attachAreaListeners(document.querySelector('.field-row[data-index="' + idx + '"]'));
        }

        function removeFieldRow(btn) {
            var row = btn.closest('.field-row');
            var idx = parseInt(row.getAttribute('data-index'));
            if (fieldMarkers[idx]) {
                map.removeLayer(fieldMarkers[idx]);
                delete fieldMarkers[idx];
            }
            row.remove();
            updateRemoveButtons();
        }

        function updateRemoveButtons() {
            var rows = document.querySelectorAll('.field-row');
            rows.forEach(function(row) {
                var btn = row.querySelector('.remove-field-btn');
                btn.style.display = rows.length > 1 ? 'inline-block' : 'none';
            });
        }

        function setActiveRow(btn) {
            document.querySelectorAll('.pick-on-map-btn').forEach(function(b) {
                b.classList.remove('active');
            });
            btn.classList.add('active');
            var row = btn.closest('.field-row');
            activeFieldIndex = parseInt(row.getAttribute('data-index'));
            document.getElementById('map-instruction').innerText =
                `<?php echo e(__('Now click on the map to set the location for Field #')); ?>${activeFieldIndex + 1}`;
        }

        function setRowPin(idx, lat, lng) {
            var row = document.querySelector('.field-row[data-index="' + idx + '"]');
            if (!row) return;
            row.querySelector('.field-lat-input').value = lat.toFixed(7);
            row.querySelector('.field-lng-input').value = lng.toFixed(7);
            var pinStatus = row.querySelector('.pin-status');
            pinStatus.innerText = lat.toFixed(5) + ', ' + lng.toFixed(5);
        }

        function placeOrMoveMarker(idx, lat, lng) {
            if (fieldMarkers[idx]) {
                fieldMarkers[idx].setLatLng([lat, lng]);
            } else {
                var marker = L.marker([lat, lng], {
                        draggable: true
                    })
                    .addTo(map)
                    .bindTooltip('<?php echo e(__('Field')); ?> #' + (idx + 1), {
                        permanent: true,
                        direction: 'top'
                    });
                marker.on('dragend', function(e) {
                    var pos = e.target.getLatLng();
                    setRowPin(idx, pos.lat, pos.lng);
                });
                fieldMarkers[idx] = marker;
            }
            setRowPin(idx, lat, lng);
        }

        (function() {
            defaultLat = <?php echo e($mouza->latitude ?? 31.5204); ?>;
            defaultLng = <?php echo e($mouza->longitude ?? 74.3587); ?>;

            map = L.map('field-map-picker').setView([defaultLat, defaultLng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            map.on('click', function(e) {
                placeOrMoveMarker(activeFieldIndex, e.latlng.lat, e.latlng.lng);
            });

            // Default-select the first field row as active
            var firstBtn = document.querySelector('.pick-on-map-btn');
            if (firstBtn) setActiveRow(firstBtn);

            // Wire up area calculation for the initial static row
            attachAreaListeners(document.querySelector('.field-row[data-index="0"]'));

            updateRemoveButtons();
        })();
    </script>
    <script>
        // ================= Form Validation Before Submit =================
        document.querySelector('form').addEventListener('submit', function(e) {
            console.log('Form submit triggered');
            var isValid = true;
            var errorMessages = [];

            document.querySelectorAll('.field-row').forEach(function(row, i) {
                var kanalInput = row.querySelector('[name*="[area_kanal]"]');
                var marlaInput = row.querySelector('[name*="[area_marla]"]');

                var kanal = parseFloat(kanalInput.value) || 0;
                var marla = parseFloat(marlaInput.value) || 0;

                if (kanal < 0 || kanal > 7) {
                    isValid = false;
                    kanalInput.classList.add('is-invalid');
                    errorMessages.push(
                        `Field #${i + 1}: Kanal value must be between 0 and 7 (8 Kanal = 1 Acre).`);
                } else {
                    kanalInput.classList.remove('is-invalid');
                }

                if (marla < 0 || marla > 19) {
                    isValid = false;
                    marlaInput.classList.add('is-invalid');
                    errorMessages.push(
                        `Field #${i + 1}: Marla value must be between 0 and 19 (20 Marla = 1 Kanal).`);
                } else {
                    marlaInput.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert(errorMessages.join('\n'));
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\AMS\main_file\resources\views/realEstate/field/create.blade.php ENDPATH**/ ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Edit Khait')); ?> - <?php echo e($field->mouza->name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item">
        <a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a>
    </li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('mouza.index')); ?>"><?php echo e(__('Mouza')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('mouza.show', $field->mouza_id)); ?>"><?php echo e($field->mouza->name); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Edit Khait')); ?> - <?php echo e($field->field_number); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css-page'); ?>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <form action="<?php echo e(route('mouza.field.update', $field->id)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="row">

            
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="ti ti-map-2"></i> <?php echo e(__('Field Information')); ?></h5>
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
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Field Number')); ?> <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="field_number" class="form-control" required
                                        value="<?php echo e(old('field_number', $field->field_number)); ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Intiqal No.')); ?></label>
                                    <input type="text" name="intiqal_no" class="form-control"
                                        value="<?php echo e(old('intiqal_no', $field->intiqal_no)); ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Status')); ?></label>
                                    <select name="status" class="form-control">
                                        <option value="available"
                                            <?php echo e(old('status', $field->status) == 'available' ? 'selected' : ''); ?>>🔴
                                            Available
                                        </option>
                                        <option value="reserved"
                                            <?php echo e(old('status', $field->status) == 'reserved' ? 'selected' : ''); ?>>🟡
                                            Reserved
                                        </option>
                                        <option value="sold"
                                            <?php echo e(old('status', $field->status) == 'sold' ? 'selected' : ''); ?>>🟢 Sold
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Deal Amount (PKR)')); ?> <span
                                            class="text-danger">*</span></label>
                                    <input type="number" name="amount" class="form-control" required
                                        value="<?php echo e(old('amount', $field->amount)); ?>" step="0.01">
                                </div>
                            </div>
                        </div>

                        
                        <div class="row">
                            <div class="col-12">
                                <hr class="my-2">
                                <label class="form-label mb-1"><strong><?php echo e(__('Land Area')); ?></strong> <span
                                        class="text-danger">*</span>
                                    <small class="text-muted">(<?php echo e(__('enter in any combination')); ?>)</small>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-3">
                                    <label class="form-label small"><?php echo e(__('Acre')); ?></label>
                                    <input type="number" min="0" step="1" name="area_acre" id="area_acre"
                                        class="form-control area-part-input"
                                        value="<?php echo e(old('area_acre', $field->area_acre ?? 0)); ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-3">
                                    <label class="form-label small"><?php echo e(__('Kanal')); ?></label>
                                    <input type="number" min="0" max="7" step="1" name="area_kanal"
                                        id="area_kanal" class="form-control area-part-input"
                                        value="<?php echo e(old('area_kanal', $field->area_kanal ?? 0)); ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-3">
                                    <label class="form-label small"><?php echo e(__('Marla')); ?></label>
                                    <input type="number" min="0" max="19" step="1" name="area_marla"
                                        id="area_marla" class="form-control area-part-input"
                                        value="<?php echo e(old('area_marla', $field->area_marla ?? 0)); ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label small"><?php echo e(__('Total (in Marla)')); ?></label>
                                    <input type="text" id="total_marla_display" class="form-control bg-light" readonly
                                        value="<?php echo e(old('area_quantity', $field->area_quantity)); ?>">
                                    <input type="hidden" name="area_quantity" id="area_quantity"
                                        value="<?php echo e(old('area_quantity', $field->area_quantity)); ?>">
                                    <input type="hidden" name="area_unit" value="Marla">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Latitude')); ?></label>
                                    <input type="text" name="latitude" id="field_lat" class="form-control" readonly
                                        value="<?php echo e(old('latitude', $field->latitude)); ?>" placeholder="For map pin">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Longitude')); ?></label>
                                    <input type="text" name="longitude" id="field_lng" class="form-control" readonly
                                        value="<?php echo e(old('longitude', $field->longitude)); ?>" placeholder="For map pin">
                                </div>
                            </div>
                        </div>

                        
                        <div class="mb-2">
                            <label class="form-label"><?php echo e(__('Pick Field Location on Map')); ?></label>
                            <input type="text" id="field_map_search" class="form-control mb-2"
                                placeholder="<?php echo e(__('Search a place name...')); ?>">
                            <div id="field-map-picker" style="height:280px; border-radius:8px; border:1px solid #ddd;">
                            </div>
                            <small
                                class="text-muted"><?php echo e(__('Click on map (or search above) to update this field location')); ?></small>
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
                                value="<?php echo e(old('seller_name', $field->seller_name)); ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Father Name')); ?></label>
                            <input type="text" name="seller_father_name" class="form-control"
                                value="<?php echo e(old('seller_father_name', $field->seller_father_name)); ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('CNIC No.')); ?></label>
                            <input type="text" name="seller_cnic" class="form-control" placeholder="xxxxx-xxxxxxx-x"
                                value="<?php echo e(old('seller_cnic', $field->seller_cnic)); ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Phone')); ?></label>
                            <input type="text" name="seller_phone" class="form-control"
                                value="<?php echo e(old('seller_phone', $field->seller_phone)); ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Address')); ?></label>
                            <textarea name="seller_address" class="form-control" rows="2"><?php echo e(old('seller_address', $field->seller_address)); ?></textarea>
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
                                value="<?php echo e(old('agent_name', $field->agent_name)); ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Agent CNIC')); ?></label>
                            <input type="text" name="agent_cnic" class="form-control" placeholder="xxxxx-xxxxxxx-x"
                                value="<?php echo e(old('agent_cnic', $field->agent_cnic)); ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Agent Phone')); ?></label>
                            <input type="text" name="agent_phone" class="form-control"
                                value="<?php echo e(old('agent_phone', $field->agent_phone)); ?>">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Agent Address')); ?></label>
                            <textarea name="agent_address" class="form-control" rows="2"><?php echo e(old('agent_address', $field->agent_address)); ?></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Commission Amount (PKR)')); ?></label>
                            <input type="number" name="agent_commission" class="form-control" step="0.01"
                                value="<?php echo e(old('agent_commission', $field->agent_commission)); ?>">
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
                                step="0.01" value="<?php echo e(old('patwari_total', $field->patwari_total)); ?>">
                        </div>
                        <label class="form-label"><strong><?php echo e(__('Breakdown (who was paid how much)')); ?></strong></label>
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
                                    <?php $__empty_1 = true; $__currentLoopData = $field->patwariExpenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><input type="text" name="patwari_person[]"
                                                    class="form-control form-control-sm" value="<?php echo e($pe->person_name); ?>">
                                            </td>
                                            <td><input type="number" name="patwari_amount[]"
                                                    class="form-control form-control-sm" step="0.01"
                                                    value="<?php echo e($pe->amount); ?>"></td>
                                            <td><input type="text" name="patwari_note[]"
                                                    class="form-control form-control-sm" value="<?php echo e($pe->note); ?>">
                                            </td>
                                            <td><button type="button" class="btn btn-sm btn-danger"
                                                    onclick="removeRow(this)"><i class="ti ti-trash"></i></button></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
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
                                    <?php endif; ?>
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
                                        <?php echo e(old('bank_account_id', $field->bank_account_id) == $bank->id ? 'selected' : ''); ?>>
                                        <?php echo e($bank->bank_name); ?> - <?php echo e($bank->account_number); ?> (<?php echo e($bank->holder_name); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <small class="text-muted">
                            <?php echo e(__('Don\'t see your bank?')); ?>

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
                        <?php if($field->documents->count()): ?>
                            <label class="form-label"><strong><?php echo e(__('Existing Documents')); ?></strong></label>
                            <ul class="list-group mb-3">
                                <?php $__currentLoopData = $field->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <a href="<?php echo e(Storage::url($doc->document_path)); ?>" target="_blank">
                                            <?php echo e($doc->document_name); ?> <small
                                                class="text-muted">(<?php echo e($doc->document_type ?? 'Document'); ?>)</small>
                                        </a>
                                        <a href="<?php echo e(route('real.estate.document.delete', $doc->id)); ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('<?php echo e(__('Delete this document?')); ?>')">
                                            <i class="ti ti-trash"></i>
                                        </a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        <?php endif; ?>

                        <label class="form-label"><strong><?php echo e(__('Add More Documents')); ?></strong></label>
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

            
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label class="form-label"><?php echo e(__('Notes / Remarks')); ?></label>
                            <textarea name="notes" class="form-control" rows="2"><?php echo e(old('notes', $field->notes)); ?></textarea>
                        </div>
                        <div class="text-end">
                            <a href="<?php echo e(route('mouza.show', $field->mouza_id)); ?>"
                                class="btn btn-secondary"><?php echo e(__('Cancel')); ?></a>
                            <button type="submit" class="btn btn-primary"><i class="ti ti-check"></i>
                                <?php echo e(__('Update Khait')); ?></button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Add Patwari row
        function addPatwariRow() {
            var html = '<tr>' +
                '<td><input type="text" name="patwari_person[]" class="form-control form-control-sm"></td>' +
                '<td><input type="number" name="patwari_amount[]" class="form-control form-control-sm" step="0.01"></td>' +
                '<td><input type="text" name="patwari_note[]" class="form-control form-control-sm"></td>' +
                '<td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)"><i class="ti ti-trash"></i></button></td>' +
                '</tr>';
            document.getElementById('patwari-body').insertAdjacentHTML('beforeend', html);
        }

        // Add Document row
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

        // ===== Land Area Conversion (Acre / Kanal / Marla -> Total Marla) =====
        // Standard Pakistani revenue conversion: 1 Acre = 8 Kanal, 1 Kanal = 20 Marla
        (function() {
            var MARLA_PER_KANAL = 20;
            var KANAL_PER_ACRE = 8;

            var acreInput = document.getElementById('area_acre');
            var kanalInput = document.getElementById('area_kanal');
            var marlaInput = document.getElementById('area_marla');
            var totalDisplay = document.getElementById('total_marla_display');
            var totalHidden = document.getElementById('area_quantity');

            function calculateTotal() {
                var acre = parseFloat(acreInput.value) || 0;
                var kanal = parseFloat(kanalInput.value) || 0;
                var marla = parseFloat(marlaInput.value) || 0;

                var totalMarla = (acre * KANAL_PER_ACRE * MARLA_PER_KANAL) + (kanal * MARLA_PER_KANAL) + marla;

                totalDisplay.value = totalMarla;
                totalHidden.value = totalMarla;
            }

            [acreInput, kanalInput, marlaInput].forEach(function(input) {
                input.addEventListener('input', calculateTotal);
            });
        })();

        // ===== Free Map (Leaflet + OpenStreetMap) — no API key needed =====
        (function() {
            if (typeof L === 'undefined') {
                document.getElementById('field-map-picker').innerHTML =
                    '<div style="padding:20px;color:#c00">Leaflet library failed to load. Check your internet connection or if the CDN is blocked (see browser console).</div>';
                return;
            }

            var mouzaLat = <?php echo e($field->mouza->latitude ?? 31.5204); ?>;
            var mouzaLng = <?php echo e($field->mouza->longitude ?? 74.3587); ?>;

            var latInput = document.getElementById('field_lat');
            var lngInput = document.getElementById('field_lng');

            var startLat = parseFloat(latInput.value) || mouzaLat;
            var startLng = parseFloat(lngInput.value) || mouzaLng;

            var map = L.map('field-map-picker').setView([startLat, startLng], 16);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            var marker = null;

            function setMarker(lat, lng) {
                if (marker) {
                    map.removeLayer(marker);
                }
                marker = L.marker([lat, lng], {
                    draggable: true
                }).addTo(map);
                latInput.value = lat.toFixed(7);
                lngInput.value = lng.toFixed(7);
                marker.on('dragend', function(e) {
                    var pos = e.target.getLatLng();
                    latInput.value = pos.lat.toFixed(7);
                    lngInput.value = pos.lng.toFixed(7);
                });
            }

            // Existing field location always shown when editing
            setMarker(startLat, startLng);

            map.on('click', function(e) {
                setMarker(e.latlng.lat, e.latlng.lng);
            });

            // Free place search (OpenStreetMap Nominatim, no key needed)
            var searchInput = document.getElementById('field_map_search');
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    var q = searchInput.value.trim();
                    if (!q) return;
                    fetch('https://nominatim.openstreetmap.org/search?format=json&limit=1&q=' +
                            encodeURIComponent(q))
                        .then(function(r) {
                            return r.json();
                        })
                        .then(function(results) {
                            if (results && results.length) {
                                var lat = parseFloat(results[0].lat);
                                var lng = parseFloat(results[0].lon);
                                map.setView([lat, lng], 16);
                                setMarker(lat, lng);
                            } else {
                                alert('<?php echo e(__('Place not found, try a different search.')); ?>');
                            }
                        });
                }
            });
        })();
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\2026\Ezitech-AMS-main\resources\views/realEstate/field/edit.blade.php ENDPATH**/ ?>
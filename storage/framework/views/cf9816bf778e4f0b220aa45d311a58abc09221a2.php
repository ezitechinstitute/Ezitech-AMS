
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Edit Agricultural Land')); ?> - <?php echo e($project->name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item">
        <a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a>
    </li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('construction-project.index')); ?>"><?php echo e(__('Construction Projects')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('construction-project.show', $project->id)); ?>"><?php echo e($project->name); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Edit Field')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <form action="<?php echo e(route('construction-project.field.update', $field->id)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
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
                            <div class="col-md-2">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Land Area')); ?> <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="area_quantity" class="form-control" required
                                        value="<?php echo e(old('area_quantity', $field->area_quantity)); ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Unit')); ?></label>
                                    <select name="area_unit" class="form-control">
                                        <?php $__currentLoopData = ['Marla', 'Kanal', 'Acre', 'Sq Ft']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($unit); ?>"
                                                <?php echo e(old('area_unit', $field->area_unit) == $unit ? 'selected' : ''); ?>>
                                                <?php echo e($unit); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Status')); ?></label>
                                    <select name="status" class="form-control">
                                        <option value="available"
                                            <?php echo e(old('status', $field->status) == 'available' ? 'selected' : ''); ?>>🔴 Available
                                        </option>
                                        <option value="sold"
                                            <?php echo e(old('status', $field->status) == 'sold' ? 'selected' : ''); ?>>🟢 Sold
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Acre')); ?></label>
                                    <input type="number" step="0.01" min="0" name="area_acre"
                                        class="form-control" value="<?php echo e(old('area_acre', $field->area_acre)); ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Kanal')); ?></label>
                                    <input type="number" step="0.01" min="0" name="area_kanal"
                                        class="form-control" value="<?php echo e(old('area_kanal', $field->area_kanal)); ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Marla')); ?></label>
                                    <input type="number" step="0.01" min="0" name="area_marla"
                                        class="form-control" value="<?php echo e(old('area_marla', $field->area_marla)); ?>">
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
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Latitude')); ?></label>
                                    <input type="text" name="latitude" id="field_lat" class="form-control"
                                        value="<?php echo e(old('latitude', $field->latitude)); ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Longitude')); ?></label>
                                    <input type="text" name="longitude" id="field_lng" class="form-control"
                                        value="<?php echo e(old('longitude', $field->longitude)); ?>" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-2">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label mb-0"><?php echo e(__('Pick Field Location on Map')); ?></label>
                                <button type="button" id="use-my-location" class="btn btn-sm btn-outline-primary">
                                    <i class="ti ti-current-location"></i> <?php echo e(__('Use My Location')); ?>

                                </button>
                            </div>
                            <div id="field-map-picker" style="height:280px; border-radius:8px; border:1px solid #ddd;">
                            </div>
                            <small id="map-hint"
                                class="text-muted"><?php echo e(__('Click on map to update field location')); ?></small>
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
                            <input type="text" name="agent_cnic" class="form-control"
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
                            <input type="number" name="patwari_total" class="form-control" step="0.01"
                                value="<?php echo e(old('patwari_total', $field->patwari_total)); ?>">
                        </div>
                        <label class="form-label"><strong><?php echo e(__('Breakdown')); ?></strong></label>
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
                                    <?php
                                        $patwariRows = \App\Models\PatwariExpense::where(
                                            'model_type',
                                            'construction_field',
                                        )
                                            ->where('model_id', $field->id)
                                            ->get();
                                    ?>
                                    <?php $__empty_1 = true; $__currentLoopData = $patwariRows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><input type="text" name="patwari_person[]"
                                                    class="form-control form-control-sm" value="<?php echo e($row->person_name); ?>">
                                            </td>
                                            <td><input type="number" name="patwari_amount[]"
                                                    class="form-control form-control-sm" step="0.01"
                                                    value="<?php echo e($row->amount); ?>"></td>
                                            <td><input type="text" name="patwari_note[]"
                                                    class="form-control form-control-sm" value="<?php echo e($row->note); ?>">
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
                    </div>
                </div>
            </div>

            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header" style="background:#6f42c1; color:white;">
                        <h5 class="mb-0"><i class="ti ti-paperclip"></i> <?php echo e(__('Supporting Documents')); ?></h5>
                    </div>
                    <div class="card-body">
                        
                        <?php
                            $existingDocs = \App\Models\RealEstateDocument::where('model_type', 'construction_field')
                                ->where('model_id', $field->id)
                                ->get();
                        ?>
                        <?php if($existingDocs->count()): ?>
                            <div class="mb-3">
                                <label class="form-label"><strong><?php echo e(__('Existing Documents')); ?></strong></label>
                                <?php $__currentLoopData = $existingDocs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="d-flex align-items-center justify-content-between mb-1 p-2 border rounded">
                                        <span><i class="ti ti-file"></i> <?php echo e($doc->document_name); ?> <small
                                                class="text-muted">(<?php echo e($doc->document_type); ?>)</small></span>
                                        <div>
                                            <a href="<?php echo e(Storage::url($doc->document_path)); ?>" target="_blank"
                                                class="btn btn-sm btn-info"><i class="ti ti-eye"></i></a>
                                            <a href="<?php echo e(route('construction-project.field.doc.delete', $doc->id)); ?>"
                                                class="btn btn-sm btn-danger" onclick="return confirm('Delete?')"><i
                                                    class="ti ti-trash"></i></a>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                        
                        <label class="form-label"><strong><?php echo e(__('Add New Documents')); ?></strong></label>
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
                            <a href="<?php echo e(route('construction-project.show', $project->id)); ?>"
                                class="btn btn-secondary"><?php echo e(__('Cancel')); ?></a>
                            <button type="submit" class="btn btn-primary"><i class="ti ti-check"></i>
                                <?php echo e(__('Update Field')); ?></button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css-page'); ?>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-page'); ?>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        function addPatwariRow() {
            var html = '<tr>' +
                '<td><input type="text" name="patwari_person[]" class="form-control form-control-sm"></td>' +
                '<td><input type="number" name="patwari_amount[]" class="form-control form-control-sm" step="0.01"></td>' +
                '<td><input type="text" name="patwari_note[]" class="form-control form-control-sm"></td>' +
                '<td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)"><i class="ti ti-trash"></i></button></td>' +
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

        function removeRow(btn) {
            btn.closest('tr').remove();
        }

        (function() {
            var latInput = document.getElementById('field_lat');
            var lngInput = document.getElementById('field_lng');

            var defaultLat = parseFloat(latInput.value) || <?php echo e($project->latitude ?? 31.5204); ?>;
            var defaultLng = parseFloat(lngInput.value) || <?php echo e($project->longitude ?? 74.3587); ?>;
            var hasInitial = !!(latInput.value && lngInput.value);

            var map = L.map('field-map-picker').setView([defaultLat, defaultLng], hasInitial ? 16 : 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            var marker = L.marker([defaultLat, defaultLng], {
                draggable: true
            }).addTo(map);

            function setCoords(lat, lng) {
                latInput.value = lat.toFixed(7);
                lngInput.value = lng.toFixed(7);
            }

            marker.on('dragend', function(e) {
                var pos = e.target.getLatLng();
                setCoords(pos.lat, pos.lng);
            });

            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                setCoords(e.latlng.lat, e.latlng.lng);
            });

            var hint = document.getElementById('map-hint');
            var locateBtn = document.getElementById('use-my-location');

            locateBtn.addEventListener('click', function() {
                if (!navigator.geolocation) {
                    hint.textContent = 'Geolocation not supported.';
                    return;
                }
                hint.textContent = 'Detecting your location...';
                navigator.geolocation.getCurrentPosition(
                    function(pos) {
                        var latlng = [pos.coords.latitude, pos.coords.longitude];
                        map.setView(latlng, 16);
                        marker.setLatLng(latlng);
                        setCoords(latlng[0], latlng[1]);
                        hint.textContent = 'Location detected. Drag the pin to fine-tune.';
                    },
                    function(err) {
                        hint.textContent = err.code === 1 ?
                            'Location permission denied. Click on map to set location.' :
                            'Could not detect location. Click on map.';
                    }, {
                        enableHighAccuracy: true,
                        timeout: 8000
                    }
                );
            });
        })();
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\2026\Ezitech-AMS-main\resources\views/constructionProject/field/edit.blade.php ENDPATH**/ ?>
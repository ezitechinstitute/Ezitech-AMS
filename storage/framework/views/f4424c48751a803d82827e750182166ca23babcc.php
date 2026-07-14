
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Add Plot')); ?> - <?php echo e($project->name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item">
        <a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a>
    </li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('construction-project.index')); ?>"><?php echo e(__('Construction Projects')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('construction-project.show', $project->id)); ?>"><?php echo e($project->name); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Add Plot')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <form action="<?php echo e(route('construction-project.plot.store', $project->id)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="row">

            
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="ti ti-layout-grid"></i> <?php echo e(__('Plot Information')); ?></h5>
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
                                    <label class="form-label"><?php echo e(__('Plot Number')); ?> <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="field_number" class="form-control" required
                                        value="<?php echo e(old('field_number')); ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Intiqal No.')); ?></label>
                                    <input type="text" name="intiqal_no" class="form-control"
                                        value="<?php echo e(old('intiqal_no')); ?>">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Area')); ?> <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="area_quantity" class="form-control" required
                                        value="<?php echo e(old('area_quantity')); ?>" placeholder="e.g. 5">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Unit')); ?></label>
                                    <select name="area_unit" class="form-control">
                                        <option value="Marla" <?php echo e(old('area_unit') == 'Marla' ? 'selected' : ''); ?>>Marla
                                        </option>
                                        <option value="Kanal" <?php echo e(old('area_unit') == 'Kanal' ? 'selected' : ''); ?>>Kanal
                                        </option>
                                        <option value="Acre" <?php echo e(old('area_unit') == 'Acre' ? 'selected' : ''); ?>>Acre
                                        </option>
                                        <option value="Sq Ft" <?php echo e(old('area_unit') == 'Sq Ft' ? 'selected' : ''); ?>>Sq Ft
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Status')); ?></label>
                                    <select name="status" class="form-control">
                                        <option value="available"
                                            <?php echo e(old('status', 'available') == 'available' ? 'selected' : ''); ?>>🔴 Available
                                        </option>
                                        <option value="sold" <?php echo e(old('status') == 'sold' ? 'selected' : ''); ?>>🟢 Sold
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Deal Amount (PKR)')); ?> <span
                                            class="text-danger">*</span></label>
                                    <input type="number" name="amount" class="form-control" required
                                        value="<?php echo e(old('amount')); ?>" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Latitude')); ?></label>
                                    <input type="text" name="latitude" id="field_lat" class="form-control"
                                        value="<?php echo e(old('latitude')); ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Longitude')); ?></label>
                                    <input type="text" name="longitude" id="field_lng" class="form-control"
                                        value="<?php echo e(old('longitude')); ?>" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-2">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label mb-0"><?php echo e(__('Pick Plot Location on Map')); ?></label>
                                <button type="button" id="use-my-location" class="btn btn-sm btn-outline-primary">
                                    <i class="ti ti-current-location"></i> <?php echo e(__('Use My Location')); ?>

                                </button>
                            </div>
                            <div id="field-map-picker" style="height:280px; border-radius:8px; border:1px solid #ddd;">
                            </div>
                            <small id="map-hint"
                                class="text-muted"><?php echo e(__('Click on map to pin this plot location')); ?></small>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="ti ti-user"></i> <?php echo e(__('Purchaser Details')); ?></h5>
                    </div>
                    <div class="card-body">
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
                            <input type="text" name="purchaser_cnic" class="form-control"
                                placeholder="xxxxx-xxxxxxx-x" value="<?php echo e(old('purchaser_cnic')); ?>">
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
                            <input type="number" name="patwari_total" class="form-control" step="0.01"
                                value="<?php echo e(old('patwari_total', 0)); ?>">
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
                            <textarea name="notes" class="form-control" rows="2"><?php echo e(old('notes')); ?></textarea>
                        </div>
                        <div class="text-end">
                            <a href="<?php echo e(route('construction-project.show', $project->id)); ?>"
                                class="btn btn-secondary"><?php echo e(__('Cancel')); ?></a>
                            <button type="submit" class="btn btn-primary"><i class="ti ti-check"></i>
                                <?php echo e(__('Save Plot')); ?></button>
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

            var map = L.map('field-map-picker').setView([defaultLat, defaultLng], 15);

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

            function locateMe() {
                if (!navigator.geolocation) {
                    hint.textContent = 'Geolocation not supported.';
                    return;
                }
                hint.textContent = 'Detecting your location...';
                navigator.geolocation.getCurrentPosition(
                    function(pos) {
                        var latlng = [pos.coords.latitude, pos.coords.longitude];
                        map.setView(latlng, 15);
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
            }

            locateBtn.addEventListener('click', locateMe);
            locateMe();
        })();
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\2026\Ezitech-AMS-main\resources\views/constructionProject/plot/create.blade.php ENDPATH**/ ?>
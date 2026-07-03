<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Edit Mouza')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item">
        <a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a>
    </li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('mouza.index')); ?>"><?php echo e(__('Mouza')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Edit')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css-page'); ?>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #map-picker {
            height: 400px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><?php echo e(__('Edit Mouza (Area)')); ?></h5>
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
                    <form action="<?php echo e(route('mouza.update', $mouza->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Mouza Name')); ?> <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" required
                                        value="<?php echo e(old('name', $mouza->name)); ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('District')); ?></label>
                                    <input type="text" name="district" class="form-control"
                                        value="<?php echo e(old('district', $mouza->district)); ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Tehsil')); ?></label>
                                    <input type="text" name="tehsil" class="form-control"
                                        value="<?php echo e(old('tehsil', $mouza->tehsil)); ?>">
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="alert alert-light border mb-3">
                                    <h6 class="mb-3"><i class="ti ti-file-text"></i>
                                        <?php echo e(__('Master Intiqal Info')); ?>

                                        <small class="text-muted fw-normal">
                                            (<?php echo e(__('bulk purchase record for this whole Mouza, if applicable')); ?>)
                                        </small>
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3 mb-md-0">
                                                <label class="form-label"><?php echo e(__('Intiqal Number')); ?></label>
                                                <input type="text" name="intiqal_number" class="form-control"
                                                    value="<?php echo e(old('intiqal_number', $mouza->intiqal_number)); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3 mb-md-0">
                                                <label class="form-label"><?php echo e(__('Intiqal Date')); ?></label>
                                                <input type="date" name="intiqal_date" class="form-control"
                                                    value="<?php echo e(old('intiqal_date', $mouza->intiqal_date)); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group mb-3 mb-md-0">
                                                <label class="form-label"><?php echo e(__('Total Area')); ?></label>
                                                <input type="text" name="total_area" class="form-control"
                                                    value="<?php echo e(old('total_area', $mouza->total_area)); ?>"
                                                    placeholder="e.g. 25">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group mb-3 mb-md-0">
                                                <label class="form-label"><?php echo e(__('Unit')); ?></label>
                                                <select name="total_area_unit" class="form-control">
                                                    <option value="Kanal"
                                                        <?php echo e(old('total_area_unit', $mouza->total_area_unit) == 'Kanal' ? 'selected' : ''); ?>>
                                                        Kanal</option>
                                                    <option value="Marla"
                                                        <?php echo e(old('total_area_unit', $mouza->total_area_unit) == 'Marla' ? 'selected' : ''); ?>>
                                                        Marla</option>
                                                    <option value="Acre"
                                                        <?php echo e(old('total_area_unit', $mouza->total_area_unit) == 'Acre' ? 'selected' : ''); ?>>
                                                        Acre
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Latitude')); ?></label>
                                    <input type="text" name="latitude" id="latitude" class="form-control"
                                        value="<?php echo e(old('latitude', $mouza->latitude)); ?>" placeholder="e.g. 31.5204"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Longitude')); ?></label>
                                    <input type="text" name="longitude" id="longitude" class="form-control"
                                        value="<?php echo e(old('longitude', $mouza->longitude)); ?>" placeholder="e.g. 74.3587"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Description')); ?></label>
                                    <textarea name="description" class="form-control" rows="3"><?php echo e(old('description', $mouza->description)); ?></textarea>
                                </div>
                            </div>
                        </div>

                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label mb-0"><?php echo e(__('Pick Location on Map')); ?></label>
                                <button type="button" id="use-my-location" class="btn btn-sm btn-outline-primary">
                                    <i class="ti ti-current-location"></i> <?php echo e(__('Use My Location')); ?>

                                </button>
                            </div>
                            <div id="map-picker"></div>
                            <small id="map-hint"
                                class="text-muted"><?php echo e(__('Click on the map or drag the pin to update the Mouza location.')); ?></small>
                        </div>

                        <div class="text-end">
                            <a href="<?php echo e(route('mouza.index')); ?>" class="btn btn-secondary"><?php echo e(__('Cancel')); ?></a>
                            <button type="submit" class="btn btn-primary"><?php echo e(__('Save Mouza')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        (function() {
            var latInput = document.getElementById('latitude');
            var lngInput = document.getElementById('longitude');

            var defaultLat = parseFloat(latInput.value) || 31.5204; // Lahore fallback
            var defaultLng = parseFloat(lngInput.value) || 74.3587;
            var hasInitial = !!(latInput.value && lngInput.value);

            var map = L.map('map-picker').setView([defaultLat, defaultLng], hasInitial ? 15 : 12);

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

            // ======= Use My Location =======
            var hint = document.getElementById('map-hint');
            var locateBtn = document.getElementById('use-my-location');

            function locateMe() {
                if (!navigator.geolocation) {
                    hint.textContent = 'Geolocation is not supported by this browser.';
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
                        if (err.code === 1) {
                            hint.textContent =
                                'Location permission denied. Click the lock icon in the address bar to allow location, or set the pin manually.';
                        } else {
                            hint.textContent =
                                'Could not detect location automatically. Please click on the map to set it.';
                        }
                    }, {
                        enableHighAccuracy: true,
                        timeout: 8000
                    }
                );
            }

            // NOTE: unlike the Create form, we do NOT auto-locate on page load here —
            // this is an Edit form, so the existing saved pin should stay put unless
            // the user explicitly clicks "Use My Location".
            locateBtn.addEventListener('click', locateMe);
        })();
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\2026\Ezitech-AMS-main\resources\views/realEstate/mouza/edit.blade.php ENDPATH**/ ?>
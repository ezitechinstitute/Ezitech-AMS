<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Mouza')); ?>: <?php echo e($mouza->name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('mouza.index')); ?>"><?php echo e(__('Mouza')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e($mouza->name); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <a href="<?php echo e(route('mouza.kiwat.create', $mouza->id)); ?>" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i> <?php echo e(__('Add Kiwat')); ?>

        </a>
        <a href="<?php echo e(route('mouza.field.create', $mouza->id)); ?>" class="btn btn-sm btn-success">
            <i class="ti ti-plus"></i> <?php echo e(__('Add Khait (Field)')); ?>

        </a>
        <a href="<?php echo e(route('mouza.edit', $mouza->id)); ?>" class="btn btn-sm btn-warning">
            <i class="ti ti-pencil"></i> <?php echo e(__('Edit Mouza')); ?>

        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css-page'); ?>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #mouza-map {
            height: 400px;
            border-radius: 0 0 8px 8px;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5><i class="ti ti-map"></i> <?php echo e($mouza->name); ?></h5>
                </div>
                <div class="card-body">
                    <p><strong><?php echo e(__('District')); ?>:</strong> <?php echo e($mouza->district ?? '-'); ?></p>
                    <p><strong><?php echo e(__('Tehsil')); ?>:</strong> <?php echo e($mouza->tehsil ?? '-'); ?></p>
                    <p><strong><?php echo e(__('Description')); ?>:</strong> <?php echo e($mouza->description ?? '-'); ?></p>
                    <p><strong><?php echo e(__('Total Area')); ?>:</strong> <?php echo e($mouza->area_display); ?></p>
                    <hr>
                    <div class="row text-center">
                        <div class="col-4">
                            <h4 class="text-info"><?php echo e($fields->count()); ?></h4>
                            <small><?php echo e(__('Total')); ?></small>
                        </div>
                        <div class="col-4">
                            <h4 class="text-primary">🔵 <?php echo e($fields->where('status', 'available')->count()); ?></h4>
                            <small><?php echo e(__('Available')); ?></small>
                        </div>
                        <div class="col-4">
                            <h4 class="text-success">🟢 <?php echo e($fields->where('status', 'sold')->count()); ?></h4>
                            <small><?php echo e(__('Purchased')); ?></small>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex gap-2">
                        <span class="badge bg-primary p-2">🔵 = Available</span>
                        <span class="badge bg-success p-2">🟢 = Purchased</span>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5><i class="ti ti-map-pin"></i> <?php echo e(__('Mouza Map - Click on a circle to view Khait details')); ?></h5>
                </div>
                <div class="card-body p-0">
                    <div id="mouza-map"></div>
                </div>
            </div>
        </div>
        
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="ti ti-stack"></i> <?php echo e(__('Kiwats (Blocks / Phases)')); ?></h5>
                    <a href="<?php echo e(route('mouza.kiwat.create', $mouza->id)); ?>" class="btn btn-sm btn-primary">
                        <i class="ti ti-plus"></i> <?php echo e(__('Add Kiwat')); ?>

                    </a>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Kiwat Number')); ?></th>
                                    <th><?php echo e(__('Description')); ?></th>
                                    <th><?php echo e(__('Total Area')); ?></th>
                                    <th><?php echo e(__('Fields')); ?></th>
                                    <th><?php echo e(__('Plots')); ?></th>
                                    <th><?php echo e(__('Action')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $kiwats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kiwat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><strong><?php echo e($kiwat->kiwat_number); ?></strong></td>
                                        <td><?php echo e($kiwat->description ?? '-'); ?></td>
                                        <td><?php echo e($kiwat->total_area ? $kiwat->total_area . ' ' . $kiwat->total_area_unit : '-'); ?>

                                        </td>
                                        <td><span class="badge bg-info"><?php echo e($kiwat->fields_count); ?></span></td>
                                        <td><span class="badge bg-secondary"><?php echo e($kiwat->plots_count); ?></span></td>
                                        <td>
                                            <a href="<?php echo e(route('kiwat.show', $kiwat->id)); ?>" class="btn btn-sm btn-info">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('kiwat.edit', $kiwat->id)); ?>" class="btn btn-sm btn-warning">
                                                <i class="ti ti-pencil"></i>
                                            </a>
                                            <form action="<?php echo e(route('kiwat.destroy', $kiwat->id)); ?>" method="POST"
                                                class="d-inline" onsubmit="return confirm('Delete this Kiwat?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button class="btn btn-sm btn-danger"><i class="ti ti-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <?php echo e(__('No Kiwats added yet.')); ?>

                                            <a
                                                href="<?php echo e(route('mouza.kiwat.create', $mouza->id)); ?>"><?php echo e(__('Add First Kiwat')); ?></a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header">
                    <h5><i class="ti ti-list"></i> <?php echo e(__('Khaits (Agricultural Fields)')); ?></h5>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Field No.')); ?></th>
                                    <th><?php echo e(__('Intiqal No.')); ?></th>
                                    <th><?php echo e(__('Seller')); ?></th>
                                    <th><?php echo e(__('Area')); ?></th>
                                    <th><?php echo e(__('Amount')); ?></th>
                                    <th><?php echo e(__('Status')); ?></th>
                                    <th><?php echo e(__('Action')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><strong><?php echo e($field->field_number); ?></strong></td>
                                        <td><?php echo e($field->intiqal_no ?? '-'); ?></td>
                                        <td><?php echo e($field->seller_name); ?></td>
                                        <td><?php echo e($field->area_quantity); ?> <?php echo e($field->area_unit); ?></td>
                                        <td><?php echo e(number_format($field->amount, 2)); ?></td>
                                        <td>
                                            <?php if($field->status == 'available'): ?>
                                                <span class="badge bg-primary">🔵 Available</span>
                                            <?php else: ?>
                                                <span class="badge bg-success">🟢 Purchased</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('mouza.field.show', $field->id)); ?>"
                                                class="btn btn-sm btn-info">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('mouza.field.edit', $field->id)); ?>"
                                                class="btn btn-sm btn-warning">
                                                <i class="ti ti-pencil"></i>
                                            </a>
                                            <form action="<?php echo e(route('mouza.field.destroy', $field->id)); ?>" method="POST"
                                                class="d-inline" onsubmit="return confirm('Delete?')">
                                                <?php echo csrf_field(); ?>
                                                <button class="btn btn-sm btn-danger"><i class="ti ti-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="7" class="text-center"><?php echo e(__('No fields added yet.')); ?> <a
                                                href="<?php echo e(route('mouza.field.create', $mouza->id)); ?>">Add First Khait</a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
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
            var mapFields = <?php echo json_encode($mapFields, 15, 512) ?>;

            var centerLat = <?php echo e($mouza->latitude ?? 31.5204); ?>;
            var centerLng = <?php echo e($mouza->longitude ?? 74.3587); ?>;

            var map = L.map('mouza-map').setView([centerLat, centerLng], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            L.marker([centerLat, centerLng])
                .addTo(map)
                .bindPopup('<strong><?php echo e($mouza->name); ?></strong>');

            mapFields.forEach(function(field) {
                if (!field.lat || !field.lng) return;

                var color = field.status === 'sold' ? '#28a745' : '#0d6efd';

                var circle = L.circle([parseFloat(field.lat), parseFloat(field.lng)], {
                    radius: 80,
                    color: color,
                    fillColor: color,
                    fillOpacity: 0.7,
                    weight: 2
                }).addTo(map);

                var statusLabel = field.status === 'sold' ?
                    '<span style="color:green;">🟢 Purchased</span>' :
                    '<span style="color:#0d6efd;">🔵 Available</span>';

                var content = '<div style="min-width:200px;">' +
                    '<h6 style="margin:0 0 8px;">Field # ' + field.field_number + '</h6>' +
                    '<p style="margin:2px 0;"><b>Intiqal No:</b> ' + (field.intiqal_no || '-') + '</p>' +
                    '<p style="margin:2px 0;"><b>Seller:</b> ' + field.seller_name + '</p>' +
                    '<p style="margin:2px 0;"><b>Area:</b> ' + field.area + '</p>' +
                    '<p style="margin:2px 0;"><b>Amount:</b> ' + field.amount + '</p>' +
                    '<p style="margin:2px 0;"><b>Status:</b> ' + statusLabel + '</p>' +
                    '</div>';

                circle.bindPopup(content);
            });

            // ===== Highlight logic (ab isi function ke andar hai) =====
            var params = new URLSearchParams(window.location.search);
            var highlightId = params.get('highlight');

            if (highlightId) {
                var target = mapFields.find(function(f) {
                    return String(f.id) === highlightId;
                });

                if (target && target.lat && target.lng) {
                    map.setView([parseFloat(target.lat), parseFloat(target.lng)], 17);

                    map.eachLayer(function(layer) {
                        if (layer instanceof L.Circle) {
                            var pos = layer.getLatLng();
                            if (Math.abs(pos.lat - target.lat) < 0.0001 && Math.abs(pos.lng - target.lng) <
                                0.0001) {
                                layer.openPopup();
                            }
                        }
                    });
                }
            }
        })();
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\2026\Ezitech-AMS-main\resources\views/realEstate/mouza/show.blade.php ENDPATH**/ ?>
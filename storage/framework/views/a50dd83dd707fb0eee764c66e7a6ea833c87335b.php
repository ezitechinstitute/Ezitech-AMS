
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Construction Project')); ?>: <?php echo e($project->name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('construction-project.index')); ?>"><?php echo e(__('Construction Projects')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e($project->name); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <a href="<?php echo e(route('construction-project.field.create', $project->id)); ?>" class="btn btn-sm btn-success">
            <i class="ti ti-plus"></i> <?php echo e(__('Add Agricultural Land')); ?>

        </a>
        <a href="<?php echo e(route('construction-project.plot.create', $project->id)); ?>" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i> <?php echo e(__('Add Plot')); ?>

        </a>
        <a href="<?php echo e(route('construction-project.edit', $project->id)); ?>" class="btn btn-sm btn-warning">
            <i class="ti ti-pencil"></i> <?php echo e(__('Edit Project')); ?>

        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css-page'); ?>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #project-map {
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
                    <h5><i class="ti ti-building"></i> <?php echo e($project->name); ?></h5>
                </div>
                <div class="card-body">
                    <p><strong><?php echo e(__('District')); ?>:</strong> <?php echo e($project->district ?? '-'); ?></p>
                    <p><strong><?php echo e(__('Tehsil')); ?>:</strong> <?php echo e($project->tehsil ?? '-'); ?></p>
                    <p><strong><?php echo e(__('Total Area')); ?>:</strong>
                        <?php echo e($project->total_area ? $project->total_area . ' ' . $project->total_area_unit : '-'); ?></p>
                    <p><strong><?php echo e(__('Intiqal No')); ?>:</strong> <?php echo e($project->intiqal_number ?? '-'); ?></p>
                    <p><strong><?php echo e(__('Intiqal Date')); ?>:</strong> <?php echo e($project->intiqal_date ?? '-'); ?></p>
                    <hr>
                    <div class="row text-center">
                        <div class="col-4">
                            <h4 class="text-info"><?php echo e($fields->count()); ?></h4>
                            <small><?php echo e(__('Total Fields')); ?></small>
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
                    <h5><i class="ti ti-map-pin"></i> <?php echo e(__('Project Map - Click on circle to view details')); ?></h5>
                </div>
                <div class="card-body p-0">
                    <div id="project-map"></div>
                </div>
            </div>
        </div>

        
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="ti ti-map-pin"></i> <?php echo e(__('Agricultural Land')); ?></h5>
                    <a href="<?php echo e(route('construction-project.field.create', $project->id)); ?>"
                        class="btn btn-sm btn-success">
                        <i class="ti ti-plus"></i> <?php echo e(__('Add Field')); ?>

                    </a>
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
                                        <td>PKR <?php echo e(number_format($field->amount, 2)); ?></td>
                                        <td>
                                            <?php if($field->status == 'available'): ?>
                                                <span class="badge bg-primary">🔵 Available</span>
                                            <?php else: ?>
                                                <span class="badge bg-success">🟢 Purchased</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('construction-project.field.edit', $field->id)); ?>"
                                                class="btn btn-sm btn-warning">
                                                <i class="ti ti-pencil"></i>
                                            </a>
                                            <form action="<?php echo e(route('construction-project.field.destroy', $field->id)); ?>"
                                                method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                <button class="btn btn-sm btn-danger"><i class="ti ti-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="7" class="text-center"><?php echo e(__('No fields added yet.')); ?>

                                            <a
                                                href="<?php echo e(route('construction-project.field.create', $project->id)); ?>"><?php echo e(__('Add First Field')); ?></a>
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
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="ti ti-layout-grid"></i> <?php echo e(__('Plots')); ?></h5>
                    <a href="<?php echo e(route('construction-project.plot.create', $project->id)); ?>" class="btn btn-sm btn-primary">
                        <i class="ti ti-plus"></i> <?php echo e(__('Add Plot')); ?>

                    </a>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Plot No.')); ?></th>
                                    <th><?php echo e(__('Intiqal No.')); ?></th>
                                    <th><?php echo e(__('Purchaser')); ?></th>
                                    <th><?php echo e(__('Area')); ?></th>
                                    <th><?php echo e(__('Amount')); ?></th>
                                    <th><?php echo e(__('Status')); ?></th>
                                    <th><?php echo e(__('Action')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $plots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><strong><?php echo e($plot->field_number); ?></strong></td>
                                        <td><?php echo e($plot->intiqal_no ?? '-'); ?></td>
                                        <td><?php echo e($plot->purchaser_name); ?></td>
                                        <td><?php echo e($plot->area_quantity); ?> <?php echo e($plot->area_unit); ?></td>
                                        <td>PKR <?php echo e(number_format($plot->amount, 2)); ?></td>
                                        <td>
                                            <?php if($plot->status == 'available'): ?>
                                                <span class="badge bg-primary">🔵 Available</span>
                                            <?php else: ?>
                                                <span class="badge bg-success">🟢 Purchased</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('construction-project.plot.edit', $plot->id)); ?>"
                                                class="btn btn-sm btn-warning">
                                                <i class="ti ti-pencil"></i>
                                            </a>
                                            <form action="<?php echo e(route('construction-project.plot.destroy', $plot->id)); ?>"
                                                method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                <button class="btn btn-sm btn-danger"><i class="ti ti-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="7" class="text-center"><?php echo e(__('No plots added yet.')); ?>

                                            <a
                                                href="<?php echo e(route('construction-project.plot.create', $project->id)); ?>"><?php echo e(__('Add First Plot')); ?></a>
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
            var centerLat = <?php echo e($project->latitude ?? 31.5204); ?>;
            var centerLng = <?php echo e($project->longitude ?? 74.3587); ?>;

            var map = L.map('project-map').setView([centerLat, centerLng], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            L.marker([centerLat, centerLng])
                .addTo(map)
                .bindPopup('<strong><?php echo e($project->name); ?></strong>');

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
                    '<p style="margin:2px 0;"><b>Amount:</b> PKR ' + field.amount + '</p>' +
                    '<p style="margin:2px 0;"><b>Status:</b> ' + statusLabel + '</p>' +
                    '</div>';

                circle.bindPopup(content);
            });
        })();
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\2026\Ezitech-AMS-main\resources\views/constructionProject/show.blade.php ENDPATH**/ ?>
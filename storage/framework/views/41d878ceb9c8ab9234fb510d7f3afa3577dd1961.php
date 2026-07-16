
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Plots')); ?> - <?php echo e($mouza->name); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('plot.inventory')); ?>"><?php echo e(__('Plot Inventory')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e($mouza->name); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <a href="<?php echo e(route('plot.inventory')); ?>" class="btn btn-sm btn-secondary">
            <i class="ti ti-arrow-left"></i> <?php echo e(__('Back to Areas')); ?>

        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css-page'); ?>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #plot-map {
            height: 420px;
            border-radius: 0 0 8px 8px;
        }

        tr.highlight-row {
            background-color: #fff3cd !important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">

        
        <div class="col-12 mb-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="ti ti-map-pin"></i>
                        <?php echo e(__('Plot Map')); ?> - <?php echo e($mouza->name); ?>

                    </h5>
                </div>
                <div class="card-body p-0">
                    <div id="plot-map"></div>
                </div>
            </div>
        </div>

        
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <input type="text" id="plot-search" class="form-control"
                            placeholder="<?php echo e(__('Search by Plot No., Purchaser, or Intiqal No...')); ?>">
                    </div>
                    <div class="table-responsive">
                        <table class="table" id="plot-table">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('Plot No.')); ?></th>
                                    <th><?php echo e(__('Kiwat')); ?></th>
                                    <th><?php echo e(__('Intiqal No.')); ?></th>
                                    <th><?php echo e(__('Purchaser')); ?></th>
                                    <th><?php echo e(__('Area')); ?></th>
                                    <th><?php echo e(__('Amount')); ?></th>
                                    <th><?php echo e(__('Status')); ?></th>
                                    <th><?php echo e(__('Action')); ?></th>
                                </tr>
                            </thead>
                            <tbody id="plot-body">
                                
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
            var mapPlots = <?php echo json_encode($mapPlots, 15, 512) ?>;

            var centerLat = <?php echo e($mouza->latitude ?? 31.5204); ?>;
            var centerLng = <?php echo e($mouza->longitude ?? 74.3587); ?>;

            var map = L.map('plot-map').setView([centerLat, centerLng], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            L.marker([centerLat, centerLng]).addTo(map)
                .bindPopup('<strong><?php echo e($mouza->name); ?></strong>');

            // Keep circle references by plot id so "View" can open its popup
            var circleById = {};

            mapPlots.forEach(function(p) {
                if (!p.lat || !p.lng) return;

                var color = p.status === 'sold' ? '#28a745' : '#dc3545';

                var circle = L.circle([parseFloat(p.lat), parseFloat(p.lng)], {
                    radius: 60,
                    color: color,
                    fillColor: color,
                    fillOpacity: 0.7,
                    weight: 2
                }).addTo(map);

                var statusLabel = p.status === 'sold' ?
                    '<span style="color:green;">🟢 Sold</span>' :
                    '<span style="color:blue;">🔵 Available</span>';

                circle.bindPopup(
                    '<div style="min-width:190px;">' +
                    '<h6 style="margin:0 0 8px;">Plot # ' + p.field_number + '</h6>' +
                    '<p style="margin:2px 0;"><b>Kiwat:</b> ' + p.kiwat_number + '</p>' +
                    '<p style="margin:2px 0;"><b>Purchaser:</b> ' + p.purchaser + '</p>' +
                    '<p style="margin:2px 0;"><b>Area:</b> ' + p.area + '</p>' +
                    '<p style="margin:2px 0;"><b>Amount:</b> PKR ' + p.amount + '</p>' +
                    '<p style="margin:2px 0;"><b>Status:</b> ' + statusLabel + '</p>' +
                    '</div>'
                );

                circleById[p.id] = circle;
            });

            // ===== Search table (AJAX) =====
            var searchInput = document.getElementById('plot-search');
            var body = document.getElementById('plot-body');
            var timer;

            function badge(status) {
                return status === 'sold' ?
                    '<span class="badge bg-success">🟢 Sold</span>' :
                    '<span class="badge bg-primary">🔵 Available</span>';
            }

            function renderRows(rows) {
                if (!rows.length) {
                    body.innerHTML =
                        '<tr><td colspan="8" class="text-center text-muted">No plots found.</td></tr>';
                    return;
                }
                body.innerHTML = rows.map(function(r) {
                    var hasLoc = r.lat && r.lng;
                    var viewBtn = hasLoc ?
                        '<button class="btn btn-sm btn-info view-on-map" data-id="' + r.id + '">' +
                        '<i class="ti ti-map-pin"></i> View</button>' :
                        '<span class="text-muted small">No location</span>';

                    var sellBtn = r.status === 'available' ?
                        ' <a href="/plot/' + r.id + '/sell" class="btn btn-sm btn-success">' +
                        '<i class="ti ti-shopping-cart"></i> Sell</a>' : '';

                    return '<tr data-id="' + r.id + '">' +
                        '<td><strong>' + r.field_number + '</strong></td>' +
                        '<td>' + r.kiwat_number + '</td>' +
                        '<td>' + r.intiqal_no + '</td>' +
                        '<td>' + r.purchaser + '</td>' +
                        '<td>' + r.area + '</td>' +
                        '<td>PKR ' + r.amount + '</td>' +
                        '<td>' + badge(r.status) + '</td>' +
                        '<td>' + viewBtn +
                        ' <a href="/plot/' + r.id + '" class="btn btn-sm btn-secondary">' +
                        '<i class="ti ti-eye"></i></a>' +
                        sellBtn + '</td>' +
                        '</tr>';
                }).join('');
            }

            function fetchPlots(q) {
                fetch("<?php echo e(route('plot.inventory.data', $mouza->id)); ?>?q=" + encodeURIComponent(q))
                    .then(function(res) {
                        return res.json();
                    })
                    .then(renderRows);
            }

            searchInput.addEventListener('input', function() {
                clearTimeout(timer);
                var q = this.value.trim();
                timer = setTimeout(function() {
                    fetchPlots(q);
                }, 300);
            });

            // Initial load — show all plots of this area
            fetchPlots('');

            // ===== "View on Map" — zoom + open popup + highlight row =====
            body.addEventListener('click', function(e) {
                var btn = e.target.closest('.view-on-map');
                if (!btn) return;

                var id = btn.dataset.id;
                var circle = circleById[id];
                if (!circle) return;

                var pos = circle.getLatLng();
                map.setView(pos, 17);
                circle.openPopup();

                // highlight the clicked row briefly
                document.querySelectorAll('#plot-body tr').forEach(function(tr) {
                    tr.classList.remove('highlight-row');
                });
                btn.closest('tr').classList.add('highlight-row');

                // scroll map into view (mobile)
                document.getElementById('plot-map').scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            });
        })();
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\2026\Ezitech-AMS-main\resources\views/realEstate/plot/inventoryArea.blade.php ENDPATH**/ ?>
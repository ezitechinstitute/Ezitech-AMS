
<?php $__env->startSection('page-title'); ?> <?php echo e(__('Cash Flow Statement')); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Report')); ?></li>
    <li class="breadcrumb-item"><?php echo e(__('Cash Flow Statement')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <div class="float-end">
        <a href="#" onclick="window.print()" class="btn btn-sm btn-primary">
            <i class="ti ti-printer"></i> <?php echo e(__('Print')); ?>

        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css-page'); ?>
<style>
@media print {
    .dash-sidebar, .dash-header, .breadcrumb, .btn, form { display: none !important; }
    .card { box-shadow: none !important; border: 1px solid #ddd !important; }
}
.cf-section-header {
    background: #f0f4ff;
    font-weight: 700;
    font-size: 14px;
    padding: 10px 15px;
    border-left: 4px solid #4361ee;
    margin-bottom: 0;
}
.cf-row { padding: 8px 15px; border-bottom: 1px solid #f0f0f0; }
.cf-row:hover { background: #fafafa; }
.cf-net {
    background: #f8f9fa;
    font-weight: 700;
    padding: 10px 15px;
    border-top: 2px solid #dee2e6;
}
.cf-total {
    background: #4361ee;
    color: white;
    font-weight: 700;
    font-size: 15px;
    padding: 12px 15px;
}
.inflow  { color: #28a745; font-weight: 600; }
.outflow { color: #dc3545; font-weight: 600; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    
    <div class="col-12 mb-3">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('report.cash.flow')); ?>" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label"><?php echo e(__('Start Date')); ?></label>
                        <input type="date" name="start_date" class="form-control"
                            value="<?php echo e($filter['start_date']); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label"><?php echo e(__('End Date')); ?></label>
                        <input type="date" name="end_date" class="form-control"
                            value="<?php echo e($filter['end_date']); ?>">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ti ti-filter"></i> <?php echo e(__('Apply Filter')); ?>

                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header text-center">
                <h4 class="mb-0"><?php echo e(__('Cash Flow Statement')); ?></h4>
                <small class="text-muted"><?php echo e($filter['start_date']); ?> — <?php echo e($filter['end_date']); ?></small>
            </div>
            <div class="card-body p-0">

                
                <div class="cf-section-header">
                    <i class="ti ti-refresh"></i> <?php echo e(__('A. Operating Activities')); ?>

                    <small class="text-muted fw-normal ms-2">(<?php echo e(__('Day-to-day business')); ?>)</small>
                </div>

                <div class="cf-row d-flex justify-content-between">
                    <span><?php echo e(__('Invoice Receipts (Customer Payments)')); ?></span>
                    <span class="inflow">+ <?php echo e(number_format($invoiceReceipts, 2)); ?></span>
                </div>
                <div class="cf-row d-flex justify-content-between">
                    <span><?php echo e(__('Direct Revenue Received')); ?></span>
                    <span class="inflow">+ <?php echo e(number_format($revenueReceipts, 2)); ?></span>
                </div>
                <div class="cf-row d-flex justify-content-between">
                    <span><?php echo e(__('Bill Payments (to Vendors)')); ?></span>
                    <span class="outflow">- <?php echo e(number_format($billPayments, 2)); ?></span>
                </div>
                <div class="cf-row d-flex justify-content-between">
                    <span><?php echo e(__('Expense Payments')); ?></span>
                    <span class="outflow">- <?php echo e(number_format($expensePayments, 2)); ?></span>
                </div>
                <div class="cf-net d-flex justify-content-between">
                    <span><?php echo e(__('Net Cash from Operating Activities')); ?></span>
                    <span class="<?php echo e($operatingNet >= 0 ? 'inflow' : 'outflow'); ?>">
                        <?php echo e($operatingNet >= 0 ? '+' : ''); ?><?php echo e(number_format($operatingNet, 2)); ?>

                    </span>
                </div>

                <div class="mt-3"></div>

                
                <div class="cf-section-header">
                    <i class="ti ti-building-estate"></i> <?php echo e(__('B. Investing Activities')); ?>

                    <small class="text-muted fw-normal ms-2">(<?php echo e(__('Property & Assets')); ?>)</small>
                </div>

                <div class="cf-row d-flex justify-content-between">
                    <span><?php echo e(__('Agricultural Land Sales (Fields Sold)')); ?></span>
                    <span class="inflow">+ <?php echo e(number_format($propertySales, 2)); ?></span>
                </div>
                <div class="cf-row d-flex justify-content-between">
                    <span><?php echo e(__('Plot Sales')); ?></span>
                    <span class="inflow">+ <?php echo e(number_format($plotSales, 2)); ?></span>
                </div>
                <div class="cf-row d-flex justify-content-between">
                    <span><?php echo e(__('Asset Purchases')); ?></span>
                    <span class="outflow">- <?php echo e(number_format($assetPurchases, 2)); ?></span>
                </div>

                <div class="cf-row d-flex justify-content-between">
    <span><?php echo e(__('Agricultural Land Purchases')); ?></span>
    <span class="outflow">- <?php echo e(number_format($propertyPurchases, 2)); ?></span>
</div>
<div class="cf-row d-flex justify-content-between">
    <span><?php echo e(__('Plot Purchases')); ?></span>
    <span class="outflow">- <?php echo e(number_format($plotPurchases, 2)); ?></span>
</div>

                <div class="cf-net d-flex justify-content-between">
                    <span><?php echo e(__('Net Cash from Investing Activities')); ?></span>
                    <span class="<?php echo e($investingNet >= 0 ? 'inflow' : 'outflow'); ?>">
                        <?php echo e($investingNet >= 0 ? '+' : ''); ?><?php echo e(number_format($investingNet, 2)); ?>

                    </span>
                </div>

                <div class="mt-3"></div>

                
                <div class="cf-section-header">
                    <i class="ti ti-building-bank"></i> <?php echo e(__('C. Financing Activities')); ?>

                    <small class="text-muted fw-normal ms-2">(<?php echo e(__('Bank & Capital')); ?>)</small>
                </div>

                <div class="cf-row d-flex justify-content-between">
                    <span><?php echo e(__('Bank Transfers / Capital Inflow')); ?></span>
                    <span class="inflow">+ <?php echo e(number_format($bankTransfersIn, 2)); ?></span>
                </div>
                <div class="cf-net d-flex justify-content-between">
                    <span><?php echo e(__('Net Cash from Financing Activities')); ?></span>
                    <span class="<?php echo e($financingNet >= 0 ? 'inflow' : 'outflow'); ?>">
                        <?php echo e($financingNet >= 0 ? '+' : ''); ?><?php echo e(number_format($financingNet, 2)); ?>

                    </span>
                </div>

                <div class="mt-3"></div>

                
                <div class="cf-total d-flex justify-content-between">
                    <span><i class="ti ti-calculator me-2"></i><?php echo e(__('NET CHANGE IN CASH')); ?></span>
                    <span><?php echo e($netCashChange >= 0 ? '+' : ''); ?><?php echo e(number_format($netCashChange, 2)); ?> PKR</span>
                </div>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\AMS\main_file\resources\views/report/cash_flow.blade.php ENDPATH**/ ?>
@extends('layouts.admin')
@section('page-title') {{ __('Cash Flow Statement') }} @endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Report') }}</li>
    <li class="breadcrumb-item">{{ __('Cash Flow Statement') }}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <a href="#" onclick="window.print()" class="btn btn-sm btn-primary">
            <i class="ti ti-printer"></i> {{ __('Print') }}
        </a>
    </div>
@endsection

@push('css-page')
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
@endpush

@section('content')
<div class="row">
    {{-- Date Filter --}}
    <div class="col-12 mb-3">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('report.cash.flow') }}" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">{{ __('Start Date') }}</label>
                        <input type="date" name="start_date" class="form-control"
                            value="{{ $filter['start_date'] }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ __('End Date') }}</label>
                        <input type="date" name="end_date" class="form-control"
                            value="{{ $filter['end_date'] }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ti ti-filter"></i> {{ __('Apply Filter') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header text-center">
                <h4 class="mb-0">{{ __('Cash Flow Statement') }}</h4>
                <small class="text-muted">{{ $filter['start_date'] }} — {{ $filter['end_date'] }}</small>
            </div>
            <div class="card-body p-0">

                {{-- SECTION 1: OPERATING --}}
                <div class="cf-section-header">
                    <i class="ti ti-refresh"></i> {{ __('A. Operating Activities') }}
                    <small class="text-muted fw-normal ms-2">({{ __('Day-to-day business') }})</small>
                </div>

                <div class="cf-row d-flex justify-content-between">
                    <span>{{ __('Invoice Receipts (Customer Payments)') }}</span>
                    <span class="inflow">+ {{ number_format($invoiceReceipts, 2) }}</span>
                </div>
                <div class="cf-row d-flex justify-content-between">
                    <span>{{ __('Direct Revenue Received') }}</span>
                    <span class="inflow">+ {{ number_format($revenueReceipts, 2) }}</span>
                </div>
                <div class="cf-row d-flex justify-content-between">
                    <span>{{ __('Bill Payments (to Vendors)') }}</span>
                    <span class="outflow">- {{ number_format($billPayments, 2) }}</span>
                </div>
                <div class="cf-row d-flex justify-content-between">
                    <span>{{ __('Expense Payments') }}</span>
                    <span class="outflow">- {{ number_format($expensePayments, 2) }}</span>
                </div>
                <div class="cf-net d-flex justify-content-between">
                    <span>{{ __('Net Cash from Operating Activities') }}</span>
                    <span class="{{ $operatingNet >= 0 ? 'inflow' : 'outflow' }}">
                        {{ $operatingNet >= 0 ? '+' : '' }}{{ number_format($operatingNet, 2) }}
                    </span>
                </div>

                <div class="mt-3"></div>

                {{-- SECTION 2: INVESTING --}}
                <div class="cf-section-header">
                    <i class="ti ti-building-estate"></i> {{ __('B. Investing Activities') }}
                    <small class="text-muted fw-normal ms-2">({{ __('Property & Assets') }})</small>
                </div>

                <div class="cf-row d-flex justify-content-between">
                    <span>{{ __('Agricultural Land Sales (Fields Sold)') }}</span>
                    <span class="inflow">+ {{ number_format($propertySales, 2) }}</span>
                </div>
                <div class="cf-row d-flex justify-content-between">
                    <span>{{ __('Plot Sales') }}</span>
                    <span class="inflow">+ {{ number_format($plotSales, 2) }}</span>
                </div>
                <div class="cf-row d-flex justify-content-between">
                    <span>{{ __('Asset Purchases') }}</span>
                    <span class="outflow">- {{ number_format($assetPurchases, 2) }}</span>
                </div>

                <div class="cf-row d-flex justify-content-between">
    <span>{{ __('Agricultural Land Purchases') }}</span>
    <span class="outflow">- {{ number_format($propertyPurchases, 2) }}</span>
</div>
<div class="cf-row d-flex justify-content-between">
    <span>{{ __('Plot Purchases') }}</span>
    <span class="outflow">- {{ number_format($plotPurchases, 2) }}</span>
</div>

                <div class="cf-net d-flex justify-content-between">
                    <span>{{ __('Net Cash from Investing Activities') }}</span>
                    <span class="{{ $investingNet >= 0 ? 'inflow' : 'outflow' }}">
                        {{ $investingNet >= 0 ? '+' : '' }}{{ number_format($investingNet, 2) }}
                    </span>
                </div>

                <div class="mt-3"></div>

                {{-- SECTION 3: FINANCING --}}
                <div class="cf-section-header">
                    <i class="ti ti-building-bank"></i> {{ __('C. Financing Activities') }}
                    <small class="text-muted fw-normal ms-2">({{ __('Bank & Capital') }})</small>
                </div>

                <div class="cf-row d-flex justify-content-between">
                    <span>{{ __('Bank Transfers / Capital Inflow') }}</span>
                    <span class="inflow">+ {{ number_format($bankTransfersIn, 2) }}</span>
                </div>
                <div class="cf-net d-flex justify-content-between">
                    <span>{{ __('Net Cash from Financing Activities') }}</span>
                    <span class="{{ $financingNet >= 0 ? 'inflow' : 'outflow' }}">
                        {{ $financingNet >= 0 ? '+' : '' }}{{ number_format($financingNet, 2) }}
                    </span>
                </div>

                <div class="mt-3"></div>

                {{-- GRAND TOTAL --}}
                <div class="cf-total d-flex justify-content-between">
                    <span><i class="ti ti-calculator me-2"></i>{{ __('NET CHANGE IN CASH') }}</span>
                    <span>{{ $netCashChange >= 0 ? '+' : '' }}{{ number_format($netCashChange, 2) }} PKR</span>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
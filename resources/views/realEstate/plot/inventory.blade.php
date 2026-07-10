@extends('layouts.admin')
@section('page-title')
    {{ __('Plot Inventory') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Real Estate') }}</li>
    <li class="breadcrumb-item">{{ __('Plot Inventory') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <input type="text" id="area-filter" class="form-control"
                        placeholder="{{ __('Filter areas by name...') }}">
                </div>
            </div>
        </div>

        @forelse($mouzas as $mouza)
            <div class="col-md-4 col-sm-6 mb-3 area-card" data-name="{{ strtolower($mouza->name) }}">
                <a href="{{ route('plot.inventory.area', $mouza->id) }}" class="text-decoration-none">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="mb-2"><i class="ti ti-map-pin text-primary"></i> {{ $mouza->name }}</h5>
                            <p class="text-muted mb-3">
                                {{ $mouza->district ?? '-' }}{{ $mouza->tehsil ? ', ' . $mouza->tehsil : '' }}
                            </p>
                            <div class="d-flex justify-content-between">
                                <span class="badge bg-info p-2">{{ __('Total') }}: {{ $mouza->plots_count }}</span>
                                <span class="badge bg-danger p-2">🔴 {{ $mouza->available_plots_count }}</span>
                                <span class="badge bg-success p-2">🟢 {{ $mouza->sold_plots_count }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center text-muted">
                        {{ __('No areas with plots yet.') }}
                    </div>
                </div>
            </div>
        @endforelse
    </div>
@endsection

@push('script-page')
    <script>
        // Simple client-side filter for area cards
        document.getElementById('area-filter').addEventListener('input', function() {
            var q = this.value.trim().toLowerCase();
            document.querySelectorAll('.area-card').forEach(function(card) {
                card.style.display = card.dataset.name.includes(q) ? '' : 'none';
            });
        });
    </script>
@endpush

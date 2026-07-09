@extends('layouts.admin')
@section('page-title')
    {{ __('Mouza') }}: {{ $mouza->name }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('mouza.index') }}">{{ __('Mouza') }}</a></li>
    <li class="breadcrumb-item">{{ $mouza->name }}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <a href="{{ route('mouza.kiwat.create', $mouza->id) }}" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i> {{ __('Add Kiwat') }}
        </a>
        <a href="{{ route('mouza.field.create', $mouza->id) }}" class="btn btn-sm btn-success">
            <i class="ti ti-plus"></i> {{ __('Add Khait (Field)') }}
        </a>
        <a href="{{ route('mouza.edit', $mouza->id) }}" class="btn btn-sm btn-warning">
            <i class="ti ti-pencil"></i> {{ __('Edit Mouza') }}
        </a>
    </div>
@endsection

@push('css-page')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #mouza-map {
            height: 400px;
            border-radius: 0 0 8px 8px;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        {{-- Mouza Info Card --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5><i class="ti ti-map"></i> {{ $mouza->name }}</h5>
                </div>
                <div class="card-body">
                    <p><strong>{{ __('District') }}:</strong> {{ $mouza->district ?? '-' }}</p>
                    <p><strong>{{ __('Tehsil') }}:</strong> {{ $mouza->tehsil ?? '-' }}</p>
                    <p><strong>{{ __('Description') }}:</strong> {{ $mouza->description ?? '-' }}</p>
                    <p><strong>{{ __('Total Area') }}:</strong> {{ $mouza->area_display }}</p>
                    <hr>
                    <div class="row text-center">
                        <div class="col-4">
                            <h4 class="text-info">{{ $fields->count() }}</h4>
                            <small>{{ __('Total') }}</small>
                        </div>
                        <div class="col-4">
                            <h4 class="text-danger">🔴 {{ $fields->where('status', 'available')->count() }}</h4>
                            <small>{{ __('Available') }}</small>
                        </div>
                        <div class="col-4">
                            <h4 class="text-success">🟢 {{ $fields->where('status', 'sold')->count() }}</h4>
                            <small>{{ __('Sold') }}</small>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex gap-2">
                        <span class="badge bg-danger p-2">🔴 = Available</span>
                        <span class="badge bg-success p-2">🟢 = Sold</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Leaflet Map --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5><i class="ti ti-map-pin"></i> {{ __('Mouza Map - Click on a circle to view Khait details') }}</h5>
                </div>
                <div class="card-body p-0">
                    <div id="mouza-map"></div>
                </div>
            </div>
        </div>
        {{-- Kiwats Table --}}
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="ti ti-stack"></i> {{ __('Kiwats (Blocks / Phases)') }}</h5>
                    <a href="{{ route('mouza.kiwat.create', $mouza->id) }}" class="btn btn-sm btn-primary">
                        <i class="ti ti-plus"></i> {{ __('Add Kiwat') }}
                    </a>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('Kiwat Number') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Total Area') }}</th>
                                    <th>{{ __('Fields') }}</th>
                                    <th>{{ __('Plots') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kiwats as $kiwat)
                                    <tr>
                                        <td><strong>{{ $kiwat->kiwat_number }}</strong></td>
                                        <td>{{ $kiwat->description ?? '-' }}</td>
                                        <td>{{ $kiwat->total_area ? $kiwat->total_area . ' ' . $kiwat->total_area_unit : '-' }}
                                        </td>
                                        <td><span class="badge bg-info">{{ $kiwat->fields_count }}</span></td>
                                        <td><span class="badge bg-secondary">{{ $kiwat->plots_count }}</span></td>
                                        <td>
                                            <a href="{{ route('kiwat.show', $kiwat->id) }}" class="btn btn-sm btn-info">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            <a href="{{ route('kiwat.edit', $kiwat->id) }}" class="btn btn-sm btn-warning">
                                                <i class="ti ti-pencil"></i>
                                            </a>
                                            <form action="{{ route('kiwat.destroy', $kiwat->id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Delete this Kiwat?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger"><i class="ti ti-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            {{ __('No Kiwats added yet.') }}
                                            <a
                                                href="{{ route('mouza.kiwat.create', $mouza->id) }}">{{ __('Add First Kiwat') }}</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Fields Table --}}
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header">
                    <h5><i class="ti ti-list"></i> {{ __('Khaits (Agricultural Fields)') }}</h5>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('Field No.') }}</th>
                                    <th>{{ __('Intiqal No.') }}</th>
                                    <th>{{ __('Seller') }}</th>
                                    <th>{{ __('Area') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($fields as $field)
                                    <tr>
                                        <td><strong>{{ $field->field_number }}</strong></td>
                                        <td>{{ $field->intiqal_no ?? '-' }}</td>
                                        <td>{{ $field->seller_name }}</td>
                                        <td>{{ $field->area_quantity }} {{ $field->area_unit }}</td>
                                        <td>{{ number_format($field->amount, 2) }}</td>
                                        <td>
                                            @if ($field->status == 'available')
                                                <span class="badge bg-danger">🔴 Available</span>
                                            @else
                                                <span class="badge bg-success">🟢 Sold</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('mouza.field.show', $field->id) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            <a href="{{ route('mouza.field.edit', $field->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="ti ti-pencil"></i>
                                            </a>
                                            <form action="{{ route('mouza.field.destroy', $field->id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Delete?')">
                                                @csrf
                                                <button class="btn btn-sm btn-danger"><i class="ti ti-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">{{ __('No fields added yet.') }} <a
                                                href="{{ route('mouza.field.create', $mouza->id) }}">Add First Khait</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-page')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        (function() {
            var mapFields = @json($mapFields);

            var centerLat = {{ $mouza->latitude ?? 31.5204 }};
            var centerLng = {{ $mouza->longitude ?? 74.3587 }};

            var map = L.map('mouza-map').setView([centerLat, centerLng], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            L.marker([centerLat, centerLng])
                .addTo(map)
                .bindPopup('<strong>{{ $mouza->name }}</strong>');

            mapFields.forEach(function(field) {
                if (!field.lat || !field.lng) return;

                var color = field.status === 'sold' ? '#28a745' : '#dc3545';

                var circle = L.circle([parseFloat(field.lat), parseFloat(field.lng)], {
                    radius: 80,
                    color: color,
                    fillColor: color,
                    fillOpacity: 0.7,
                    weight: 2
                }).addTo(map);

                var statusLabel = field.status === 'sold' ?
                    '<span style="color:green;">🟢 Sold</span>' :
                    '<span style="color:red;">🔴 Available</span>';

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
@endpush

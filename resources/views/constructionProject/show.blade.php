@extends('layouts.admin')
@section('page-title')
    {{ __('Construction Project') }}: {{ $project->name }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('construction-project.index') }}">{{ __('Construction Projects') }}</a></li>
    <li class="breadcrumb-item">{{ $project->name }}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <a href="{{ route('construction-project.field.create', $project->id) }}" class="btn btn-sm btn-success">
            <i class="ti ti-plus"></i> {{ __('Add Agricultural Land') }}
        </a>
        <a href="{{ route('construction-project.plot.create', $project->id) }}" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i> {{ __('Add Plot') }}
        </a>
        <a href="{{ route('construction-project.edit', $project->id) }}" class="btn btn-sm btn-warning">
            <i class="ti ti-pencil"></i> {{ __('Edit Project') }}
        </a>
    </div>
@endsection

@push('css-page')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #project-map {
            height: 400px;
            border-radius: 0 0 8px 8px;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        {{-- Project Info Card --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5><i class="ti ti-building"></i> {{ $project->name }}</h5>
                </div>
                <div class="card-body">
                    <p><strong>{{ __('District') }}:</strong> {{ $project->district ?? '-' }}</p>
                    <p><strong>{{ __('Tehsil') }}:</strong> {{ $project->tehsil ?? '-' }}</p>
                    <p><strong>{{ __('Total Area') }}:</strong>
                        {{ $project->total_area ? $project->total_area . ' ' . $project->total_area_unit : '-' }}</p>
                    <p><strong>{{ __('Intiqal No') }}:</strong> {{ $project->intiqal_number ?? '-' }}</p>
                    <p><strong>{{ __('Intiqal Date') }}:</strong> {{ $project->intiqal_date ?? '-' }}</p>
                    <hr>
                    <div class="row text-center">
                        <div class="col-4">
                            <h4 class="text-info">{{ $fields->count() }}</h4>
                            <small>{{ __('Total Fields') }}</small>
                        </div>
                        <div class="col-4">
                            <h4 class="text-primary">🔵 {{ $fields->where('status', 'available')->count() }}</h4>
                            <small>{{ __('Available') }}</small>
                        </div>
                        <div class="col-4">
                            <h4 class="text-success">🟢 {{ $fields->where('status', 'sold')->count() }}</h4>
                            <small>{{ __('Purchased') }}</small>
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

        {{-- Leaflet Map --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5><i class="ti ti-map-pin"></i> {{ __('Project Map - Click on circle to view details') }}</h5>
                </div>
                <div class="card-body p-0">
                    <div id="project-map"></div>
                </div>
            </div>
        </div>

        {{-- Agricultural Land Table --}}
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="ti ti-map-pin"></i> {{ __('Agricultural Land') }}</h5>
                    <a href="{{ route('construction-project.field.create', $project->id) }}"
                        class="btn btn-sm btn-success">
                        <i class="ti ti-plus"></i> {{ __('Add Field') }}
                    </a>
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
                                        <td>PKR {{ number_format($field->amount, 2) }}</td>
                                        <td>
                                            @if ($field->status == 'available')
                                                <span class="badge bg-primary">🔵 Available</span>
                                            @else
                                                <span class="badge bg-success">🟢 Purchased</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('construction-project.field.edit', $field->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="ti ti-pencil"></i>
                                            </a>
                                            <form action="{{ route('construction-project.field.destroy', $field->id) }}"
                                                method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-danger"><i class="ti ti-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">{{ __('No fields added yet.') }}
                                            <a
                                                href="{{ route('construction-project.field.create', $project->id) }}">{{ __('Add First Field') }}</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Plots Table --}}
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="ti ti-layout-grid"></i> {{ __('Plots') }}</h5>
                    <a href="{{ route('construction-project.plot.create', $project->id) }}" class="btn btn-sm btn-primary">
                        <i class="ti ti-plus"></i> {{ __('Add Plot') }}
                    </a>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('Plot No.') }}</th>
                                    <th>{{ __('Intiqal No.') }}</th>
                                    <th>{{ __('Purchaser') }}</th>
                                    <th>{{ __('Area') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($plots as $plot)
                                    <tr>
                                        <td><strong>{{ $plot->field_number }}</strong></td>
                                        <td>{{ $plot->intiqal_no ?? '-' }}</td>
                                        <td>{{ $plot->purchaser_name }}</td>
                                        <td>{{ $plot->area_quantity }} {{ $plot->area_unit }}</td>
                                        <td>PKR {{ number_format($plot->amount, 2) }}</td>
                                        <td>
                                            @if ($plot->status == 'available')
                                                <span class="badge bg-primary">🔵 Available</span>
                                            @else
                                                <span class="badge bg-success">🟢 Purchased</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('construction-project.plot.edit', $plot->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="ti ti-pencil"></i>
                                            </a>
                                            <form action="{{ route('construction-project.plot.destroy', $plot->id) }}"
                                                method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-danger"><i class="ti ti-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">{{ __('No plots added yet.') }}
                                            <a
                                                href="{{ route('construction-project.plot.create', $project->id) }}">{{ __('Add First Plot') }}</a>
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
            var centerLat = {{ $project->latitude ?? 31.5204 }};
            var centerLng = {{ $project->longitude ?? 74.3587 }};

            var map = L.map('project-map').setView([centerLat, centerLng], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            L.marker([centerLat, centerLng])
                .addTo(map)
                .bindPopup('<strong>{{ $project->name }}</strong>');

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
@endpush

@extends('layouts.admin')
@section('page-title')
    {{ __('Add New Mouza') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
    </li>
    <li class="breadcrumb-item"><a href="{{ route('mouza.index') }}">{{ __('Mouza') }}</a></li>
    <li class="breadcrumb-item">{{ __('Add New') }}</li>
@endsection

@push('css-page')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #map-picker {
            height: 400px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .leaflet-search-box {
            position: absolute;
            top: 10px;
            left: 50px;
            z-index: 1000;
            width: 260px;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Add New Mouza (Area)') }}</h5>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('mouza.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Mouza Name') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" required
                                        value="{{ old('name') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('District') }}</label>
                                    <input type="text" name="district" class="form-control"
                                        value="{{ old('district') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Tehsil') }}</label>
                                    <input type="text" name="tehsil" class="form-control" value="{{ old('tehsil') }}">
                                </div>
                            </div>

                            {{-- ======= NEW: Master Intiqal Info ======= --}}
                            <div class="col-12">
                                <div class="alert alert-light border mb-3">
                                    <h6 class="mb-3"><i class="ti ti-file-text"></i>
                                        {{ __('Master Intiqal Info') }}
                                        <small class="text-muted fw-normal">
                                            ({{ __('bulk purchase record for this whole Mouza, if applicable') }})
                                        </small>
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3 mb-md-0">
                                                <label class="form-label">{{ __('Intiqal Number') }}</label>
                                                <input type="text" name="intiqal_number" class="form-control"
                                                    value="{{ old('intiqal_number') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-3 mb-md-0">
                                                <label class="form-label">{{ __('Intiqal Date') }}</label>
                                                <input type="date" name="intiqal_date" class="form-control"
                                                    value="{{ old('intiqal_date') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group mb-3 mb-md-0">
                                                <label class="form-label">{{ __('Total Area') }}</label>
                                                <input type="text" name="total_area" class="form-control"
                                                    value="{{ old('total_area') }}" placeholder="e.g. 25">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group mb-3 mb-md-0">
                                                <label class="form-label">{{ __('Unit') }}</label>
                                                <select name="total_area_unit" class="form-control">
                                                    <option value="Kanal"
                                                        {{ old('total_area_unit') == 'Kanal' ? 'selected' : '' }}>
                                                        Kanal</option>
                                                    <option value="Marla"
                                                        {{ old('total_area_unit') == 'Marla' ? 'selected' : '' }}>
                                                        Marla</option>
                                                    <option value="Acre"
                                                        {{ old('total_area_unit') == 'Acre' ? 'selected' : '' }}>Acre
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- ======= END NEW ======= --}}

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Latitude') }}</label>
                                    <input type="text" name="latitude" id="latitude" class="form-control"
                                        value="{{ old('latitude') }}" placeholder="e.g. 31.5204" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Longitude') }}</label>
                                    <input type="text" name="longitude" id="longitude" class="form-control"
                                        value="{{ old('longitude') }}" placeholder="e.g. 74.3587" readonly>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Description') }}</label>
                                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- Leaflet Map picker --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label mb-0">{{ __('Pick Location on Map') }}</label>
                                <button type="button" id="use-my-location" class="btn btn-sm btn-outline-primary">
                                    <i class="ti ti-current-location"></i> {{ __('Use My Location') }}
                                </button>
                            </div>
                            <div id="map-picker"></div>
                            <small id="map-hint"
                                class="text-muted">{{ __('Search a place, click on the map, or drag the pin to set the Mouza location.') }}</small>
                        </div>

                        {{-- ======= Supporting Documents ======= --}}
                        <div class="card mb-3">
                            <div class="card-header" style="background:#6f42c1; color:white;">
                                <h6 class="mb-0"><i class="ti ti-paperclip"></i> {{ __('Supporting Documents') }}
                                    <small class="fw-normal">({{ __('Master Fard / Intiqal / Registry copies') }})</small>
                                </h6>
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
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            <input type="text" name="document_names[]"
                                                class="form-control form-control-sm" placeholder="Document Name">
                                        </div>
                                        <div class="col-3">
                                            <input type="file" name="documents[]"
                                                class="form-control form-control-sm">
                                        </div>
                                        <div class="col-1">
                                            <button type="button" class="btn btn-sm btn-success"
                                                onclick="addDocRow()"><i class="ti ti-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('mouza.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                            <button type="submit" class="btn btn-primary">{{ __('Save Mouza') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-page')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        // Add Document row
        function addDocRow() {
            var html = '<div class="doc-row row mb-2 align-items-center">' +
                '<div class="col-4"><select name="document_types[]" class="form-control form-control-sm">' +
                '<option value="">-- Type --</option>' +
                '<option value="Fard">Fard</option><option value="Intiqal">Intiqal</option>' +
                '<option value="Registry">Registry</option><option value="Other">Other</option></select></div>' +
                '<div class="col-4"><input type="text" name="document_names[]" class="form-control form-control-sm" placeholder="Document Name"></div>' +
                '<div class="col-3"><input type="file" name="documents[]" class="form-control form-control-sm"></div>' +
                '<div class="col-1"><button type="button" class="btn btn-sm btn-danger" onclick="this.closest(\'.doc-row\').remove()"><i class="ti ti-trash"></i></button></div>' +
                '</div>';
            document.getElementById('documents-wrapper').insertAdjacentHTML('beforeend', html);
        }

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

            locateBtn.addEventListener('click', locateMe);

            if (!hasInitial) {
                locateMe();
            }
        })();
    </script>
@endpush

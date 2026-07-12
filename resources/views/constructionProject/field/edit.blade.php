@extends('layouts.admin')
@section('page-title')
    {{ __('Edit Agricultural Land') }} - {{ $project->name }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
    </li>
    <li class="breadcrumb-item"><a href="{{ route('construction-project.index') }}">{{ __('Construction Projects') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('construction-project.show', $project->id) }}">{{ $project->name }}</a></li>
    <li class="breadcrumb-item">{{ __('Edit Field') }}</li>
@endsection

@section('content')
    <form action="{{ route('construction-project.field.update', $field->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="row">

            {{-- Field Info --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="ti ti-map-2"></i> {{ __('Field Information') }}</h5>
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
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Field Number') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="field_number" class="form-control" required
                                        value="{{ old('field_number', $field->field_number) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Intiqal No.') }}</label>
                                    <input type="text" name="intiqal_no" class="form-control"
                                        value="{{ old('intiqal_no', $field->intiqal_no) }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Land Area') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="area_quantity" class="form-control" required
                                        value="{{ old('area_quantity', $field->area_quantity) }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Unit') }}</label>
                                    <select name="area_unit" class="form-control">
                                        @foreach (['Marla', 'Kanal', 'Acre', 'Sq Ft'] as $unit)
                                            <option value="{{ $unit }}"
                                                {{ old('area_unit', $field->area_unit) == $unit ? 'selected' : '' }}>
                                                {{ $unit }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Status') }}</label>
                                    <select name="status" class="form-control">
                                        <option value="available"
                                            {{ old('status', $field->status) == 'available' ? 'selected' : '' }}>🔴 Available
                                        </option>
                                        <option value="sold"
                                            {{ old('status', $field->status) == 'sold' ? 'selected' : '' }}>🟢 Sold
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Acre') }}</label>
                                    <input type="number" step="0.01" min="0" name="area_acre"
                                        class="form-control" value="{{ old('area_acre', $field->area_acre) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Kanal') }}</label>
                                    <input type="number" step="0.01" min="0" name="area_kanal"
                                        class="form-control" value="{{ old('area_kanal', $field->area_kanal) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Marla') }}</label>
                                    <input type="number" step="0.01" min="0" name="area_marla"
                                        class="form-control" value="{{ old('area_marla', $field->area_marla) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Deal Amount (PKR)') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="number" name="amount" class="form-control" required
                                        value="{{ old('amount', $field->amount) }}" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Latitude') }}</label>
                                    <input type="text" name="latitude" id="field_lat" class="form-control"
                                        value="{{ old('latitude', $field->latitude) }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Longitude') }}</label>
                                    <input type="text" name="longitude" id="field_lng" class="form-control"
                                        value="{{ old('longitude', $field->longitude) }}" readonly>
                                </div>
                            </div>
                        </div>
                        {{-- Leaflet Map Picker --}}
                        <div class="mb-2">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label mb-0">{{ __('Pick Field Location on Map') }}</label>
                                <button type="button" id="use-my-location" class="btn btn-sm btn-outline-primary">
                                    <i class="ti ti-current-location"></i> {{ __('Use My Location') }}
                                </button>
                            </div>
                            <div id="field-map-picker" style="height:280px; border-radius:8px; border:1px solid #ddd;">
                            </div>
                            <small id="map-hint"
                                class="text-muted">{{ __('Click on map to update field location') }}</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Seller Details --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="ti ti-user"></i> {{ __('Seller Details') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label class="form-label">{{ __('Seller Full Name') }} <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="seller_name" class="form-control" required
                                value="{{ old('seller_name', $field->seller_name) }}">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">{{ __('Father Name') }}</label>
                            <input type="text" name="seller_father_name" class="form-control"
                                value="{{ old('seller_father_name', $field->seller_father_name) }}">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">{{ __('CNIC No.') }}</label>
                            <input type="text" name="seller_cnic" class="form-control" placeholder="xxxxx-xxxxxxx-x"
                                value="{{ old('seller_cnic', $field->seller_cnic) }}">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">{{ __('Phone') }}</label>
                            <input type="text" name="seller_phone" class="form-control"
                                value="{{ old('seller_phone', $field->seller_phone) }}">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">{{ __('Address') }}</label>
                            <textarea name="seller_address" class="form-control" rows="2">{{ old('seller_address', $field->seller_address) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Commission Agent --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="ti ti-users"></i> {{ __('Commission Agent Details') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label class="form-label">{{ __('Agent Full Name') }}</label>
                            <input type="text" name="agent_name" class="form-control"
                                value="{{ old('agent_name', $field->agent_name) }}">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">{{ __('Agent CNIC') }}</label>
                            <input type="text" name="agent_cnic" class="form-control"
                                value="{{ old('agent_cnic', $field->agent_cnic) }}">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">{{ __('Agent Phone') }}</label>
                            <input type="text" name="agent_phone" class="form-control"
                                value="{{ old('agent_phone', $field->agent_phone) }}">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">{{ __('Agent Address') }}</label>
                            <textarea name="agent_address" class="form-control" rows="2">{{ old('agent_address', $field->agent_address) }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">{{ __('Commission Amount (PKR)') }}</label>
                            <input type="number" name="agent_commission" class="form-control" step="0.01"
                                value="{{ old('agent_commission', $field->agent_commission) }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Patwari Expense --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="ti ti-receipt"></i> {{ __('Patwari Expenses') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label class="form-label">{{ __('Total Patwari Expense (PKR)') }}</label>
                            <input type="number" name="patwari_total" class="form-control" step="0.01"
                                value="{{ old('patwari_total', $field->patwari_total) }}">
                        </div>
                        <label class="form-label"><strong>{{ __('Breakdown') }}</strong></label>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('Person Name') }}</th>
                                        <th>{{ __('Amount (PKR)') }}</th>
                                        <th>{{ __('Note / Reason') }}</th>
                                        <th>
                                            <button type="button" class="btn btn-sm btn-success"
                                                onclick="addPatwariRow()">
                                                <i class="ti ti-plus"></i>
                                            </button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="patwari-body">
                                    @php
                                        $patwariRows = \App\Models\PatwariExpense::where(
                                            'model_type',
                                            'construction_field',
                                        )
                                            ->where('model_id', $field->id)
                                            ->get();
                                    @endphp
                                    @forelse($patwariRows as $row)
                                        <tr>
                                            <td><input type="text" name="patwari_person[]"
                                                    class="form-control form-control-sm" value="{{ $row->person_name }}">
                                            </td>
                                            <td><input type="number" name="patwari_amount[]"
                                                    class="form-control form-control-sm" step="0.01"
                                                    value="{{ $row->amount }}"></td>
                                            <td><input type="text" name="patwari_note[]"
                                                    class="form-control form-control-sm" value="{{ $row->note }}">
                                            </td>
                                            <td><button type="button" class="btn btn-sm btn-danger"
                                                    onclick="removeRow(this)"><i class="ti ti-trash"></i></button></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td><input type="text" name="patwari_person[]"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" name="patwari_amount[]"
                                                    class="form-control form-control-sm" step="0.01"></td>
                                            <td><input type="text" name="patwari_note[]"
                                                    class="form-control form-control-sm"></td>
                                            <td><button type="button" class="btn btn-sm btn-danger"
                                                    onclick="removeRow(this)"><i class="ti ti-trash"></i></button></td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bank Link --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="ti ti-building-bank"></i> {{ __('Bank Link') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label class="form-label">{{ __('Select Bank Account') }}</label>
                            <select name="bank_account_id" class="form-control">
                                <option value="">-- {{ __('Select Bank Account') }} --</option>
                                @foreach ($bankAccounts as $bank)
                                    <option value="{{ $bank->id }}"
                                        {{ old('bank_account_id', $field->bank_account_id) == $bank->id ? 'selected' : '' }}>
                                        {{ $bank->bank_name }} - {{ $bank->account_number }} ({{ $bank->holder_name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Supporting Documents --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header" style="background:#6f42c1; color:white;">
                        <h5 class="mb-0"><i class="ti ti-paperclip"></i> {{ __('Supporting Documents') }}</h5>
                    </div>
                    <div class="card-body">
                        {{-- Existing Documents --}}
                        @php
                            $existingDocs = \App\Models\RealEstateDocument::where('model_type', 'construction_field')
                                ->where('model_id', $field->id)
                                ->get();
                        @endphp
                        @if ($existingDocs->count())
                            <div class="mb-3">
                                <label class="form-label"><strong>{{ __('Existing Documents') }}</strong></label>
                                @foreach ($existingDocs as $doc)
                                    <div class="d-flex align-items-center justify-content-between mb-1 p-2 border rounded">
                                        <span><i class="ti ti-file"></i> {{ $doc->document_name }} <small
                                                class="text-muted">({{ $doc->document_type }})</small></span>
                                        <div>
                                            <a href="{{ Storage::url($doc->document_path) }}" target="_blank"
                                                class="btn btn-sm btn-info"><i class="ti ti-eye"></i></a>
                                            <a href="{{ route('construction-project.field.doc.delete', $doc->id) }}"
                                                class="btn btn-sm btn-danger" onclick="return confirm('Delete?')"><i
                                                    class="ti ti-trash"></i></a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        {{-- Add New Documents --}}
                        <label class="form-label"><strong>{{ __('Add New Documents') }}</strong></label>
                        <div id="documents-wrapper">
                            <div class="doc-row row mb-2 align-items-center">
                                <div class="col-4">
                                    <select name="document_types[]" class="form-control form-control-sm">
                                        <option value="">-- Type --</option>
                                        <option value="Fard">Fard</option>
                                        <option value="Intiqal">Intiqal</option>
                                        <option value="Registry">Registry</option>
                                        <option value="CNIC Copy">CNIC Copy</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <input type="text" name="document_names[]" class="form-control form-control-sm"
                                        placeholder="Document Name">
                                </div>
                                <div class="col-3">
                                    <input type="file" name="documents[]" class="form-control form-control-sm">
                                </div>
                                <div class="col-1">
                                    <button type="button" class="btn btn-sm btn-success" onclick="addDocRow()"><i
                                            class="ti ti-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Notes & Submit --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label class="form-label">{{ __('Notes / Remarks') }}</label>
                            <textarea name="notes" class="form-control" rows="2">{{ old('notes', $field->notes) }}</textarea>
                        </div>
                        <div class="text-end">
                            <a href="{{ route('construction-project.show', $project->id) }}"
                                class="btn btn-secondary">{{ __('Cancel') }}</a>
                            <button type="submit" class="btn btn-primary"><i class="ti ti-check"></i>
                                {{ __('Update Field') }}</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
@endsection

@push('css-page')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
@endpush

@push('script-page')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        function addPatwariRow() {
            var html = '<tr>' +
                '<td><input type="text" name="patwari_person[]" class="form-control form-control-sm"></td>' +
                '<td><input type="number" name="patwari_amount[]" class="form-control form-control-sm" step="0.01"></td>' +
                '<td><input type="text" name="patwari_note[]" class="form-control form-control-sm"></td>' +
                '<td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)"><i class="ti ti-trash"></i></button></td>' +
                '</tr>';
            document.getElementById('patwari-body').insertAdjacentHTML('beforeend', html);
        }

        function addDocRow() {
            var html = '<div class="doc-row row mb-2 align-items-center">' +
                '<div class="col-4"><select name="document_types[]" class="form-control form-control-sm">' +
                '<option value="">-- Type --</option><option value="Fard">Fard</option>' +
                '<option value="Intiqal">Intiqal</option><option value="Registry">Registry</option>' +
                '<option value="CNIC Copy">CNIC Copy</option><option value="Other">Other</option></select></div>' +
                '<div class="col-4"><input type="text" name="document_names[]" class="form-control form-control-sm" placeholder="Document Name"></div>' +
                '<div class="col-3"><input type="file" name="documents[]" class="form-control form-control-sm"></div>' +
                '<div class="col-1"><button type="button" class="btn btn-sm btn-danger" onclick="this.closest(\'.doc-row\').remove()"><i class="ti ti-trash"></i></button></div>' +
                '</div>';
            document.getElementById('documents-wrapper').insertAdjacentHTML('beforeend', html);
        }

        function removeRow(btn) {
            btn.closest('tr').remove();
        }

        (function() {
            var latInput = document.getElementById('field_lat');
            var lngInput = document.getElementById('field_lng');

            var defaultLat = parseFloat(latInput.value) || {{ $project->latitude ?? 31.5204 }};
            var defaultLng = parseFloat(lngInput.value) || {{ $project->longitude ?? 74.3587 }};
            var hasInitial = !!(latInput.value && lngInput.value);

            var map = L.map('field-map-picker').setView([defaultLat, defaultLng], hasInitial ? 16 : 14);

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

            locateBtn.addEventListener('click', function() {
                if (!navigator.geolocation) {
                    hint.textContent = 'Geolocation not supported.';
                    return;
                }
                hint.textContent = 'Detecting your location...';
                navigator.geolocation.getCurrentPosition(
                    function(pos) {
                        var latlng = [pos.coords.latitude, pos.coords.longitude];
                        map.setView(latlng, 16);
                        marker.setLatLng(latlng);
                        setCoords(latlng[0], latlng[1]);
                        hint.textContent = 'Location detected. Drag the pin to fine-tune.';
                    },
                    function(err) {
                        hint.textContent = err.code === 1 ?
                            'Location permission denied. Click on map to set location.' :
                            'Could not detect location. Click on map.';
                    }, {
                        enableHighAccuracy: true,
                        timeout: 8000
                    }
                );
            });
        })();
    </script>
@endpush

@extends('layouts.admin')
@section('page-title')
    {{ __('Edit Plot') }} - {{ $plot->field_number }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
    </li>
    <li class="breadcrumb-item"><a href="{{ route('plot.index') }}">{{ __('Plots') }}</a></li>
    <li class="breadcrumb-item">{{ __('Edit') }}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <a href="{{ route('plot.show', $plot->id) }}" class="btn btn-sm btn-secondary">
            <i class="ti ti-arrow-left"></i> {{ __('Back') }}
        </a>
    </div>
@endsection

@push('css-page')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #field-map-picker {
            height: 280px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Edit Plot') }}</h5>
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

                    <form action="{{ route('plot.update', $plot->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Plot Info --}}
                        <h6 class="text-primary mb-3">{{ __('Plot Information') }}</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Field Number') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="field_number" class="form-control" required
                                        value="{{ old('field_number', $plot->field_number) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Intiqal No.') }}</label>
                                    <input type="text" name="intiqal_no" class="form-control"
                                        value="{{ old('intiqal_no', $plot->intiqal_no) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Status') }}</label>
                                    <select name="status" class="form-select">
                                        <option value="available"
                                            {{ old('status', $plot->status) == 'available' ? 'selected' : '' }}>
                                            {{ __('Available') }}</option>
                                        <option value="reserved"
                                            {{ old('status', $plot->status) == 'reserved' ? 'selected' : '' }}>
                                            {{ __('Reserved') }}</option>
                                        <option value="sold"
                                            {{ old('status', $plot->status) == 'sold' ? 'selected' : '' }}>
                                            {{ __('Sold') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Amount (PKR)') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="amount" class="form-control" required
                                        value="{{ old('amount', $plot->amount) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Latitude') }}</label>
                                    <input type="text" name="latitude" id="field_lat" class="form-control"
                                        value="{{ old('latitude', $plot->latitude) }}" placeholder="For map pin" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Longitude') }}</label>
                                    <input type="text" name="longitude" id="field_lng" class="form-control"
                                        value="{{ old('longitude', $plot->longitude) }}" placeholder="For map pin"
                                        readonly>
                                </div>
                            </div>
                        </div>

                        {{-- ======= Land Area (Acre / Kanal / Marla breakdown) ======= --}}
                        <div class="row">
                            <div class="col-12">
                                <hr class="my-2">
                                <label class="form-label mb-1"><strong>{{ __('Land Area') }}</strong> <span
                                        class="text-danger">*</span>
                                    <small class="text-muted">({{ __('enter in any combination') }})</small>
                                </label>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-3">
                                    <label class="form-label small">{{ __('Acre') }}</label>
                                    <input type="number" min="0" step="1" name="area_acre" id="area_acre"
                                        class="form-control area-part-input"
                                        value="{{ old('area_acre', $plot->area_acre ?? 0) }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-3">
                                    <label class="form-label small">{{ __('Kanal') }}</label>
                                    <input type="number" min="0" max="7" step="1" name="area_kanal"
                                        id="area_kanal" class="form-control area-part-input"
                                        value="{{ old('area_kanal', $plot->area_kanal ?? 0) }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-3">
                                    <label class="form-label small">{{ __('Marla') }}</label>
                                    <input type="number" min="0" max="19" step="1"
                                        name="area_marla" id="area_marla" class="form-control area-part-input"
                                        value="{{ old('area_marla', $plot->area_marla ?? 0) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label small">{{ __('Total (in Marla)') }}</label>
                                    <input type="text" id="total_marla_display" class="form-control bg-light" readonly
                                        value="{{ old('area_quantity', $plot->area_quantity) }}">
                                    <input type="hidden" name="area_quantity" id="area_quantity"
                                        value="{{ old('area_quantity', $plot->area_quantity) }}">
                                    <input type="hidden" name="area_unit" value="Marla">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label">{{ __('Field Location on Map') }}</label>
                                <div id="field-map-picker"></div>
                                <small class="text-muted">{{ __('Click on map or drag pin to update location') }}</small>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Bank Account') }}</label>
                                    <select name="bank_account_id" class="form-select">
                                        <option value="">{{ __('-- Select --') }}</option>
                                        @foreach ($bankAccounts as $bank)
                                            <option value="{{ $bank->id }}"
                                                {{ old('bank_account_id', $plot->bank_account_id) == $bank->id ? 'selected' : '' }}>
                                                {{ $bank->bank_name }} - {{ $bank->account_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Notes') }}</label>
                                    <textarea name="notes" class="form-control" rows="2">{{ old('notes', $plot->notes) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- Purchaser Details --}}
                        <h6 class="text-info mb-3">{{ __('Purchaser Details') }}</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Name') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="purchaser_name" class="form-control" required
                                        value="{{ old('purchaser_name', $plot->purchaser_name) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Father Name') }}</label>
                                    <input type="text" name="purchaser_father_name" class="form-control"
                                        value="{{ old('purchaser_father_name', $plot->purchaser_father_name) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('CNIC') }}</label>
                                    <input type="text" name="purchaser_cnic" class="form-control"
                                        value="{{ old('purchaser_cnic', $plot->purchaser_cnic) }}"
                                        placeholder="XXXXX-XXXXXXX-X">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Phone') }}</label>
                                    <input type="text" name="purchaser_phone" class="form-control"
                                        value="{{ old('purchaser_phone', $plot->purchaser_phone) }}">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Address') }}</label>
                                    <input type="text" name="purchaser_address" class="form-control"
                                        value="{{ old('purchaser_address', $plot->purchaser_address) }}">
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- Commission Agent --}}
                        <h6 class="text-warning mb-3">{{ __('Commission Agent') }}</h6>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Name') }}</label>
                                    <input type="text" name="agent_name" class="form-control"
                                        value="{{ old('agent_name', $plot->agent_name) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('CNIC') }}</label>
                                    <input type="text" name="agent_cnic" class="form-control"
                                        value="{{ old('agent_cnic', $plot->agent_cnic) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Phone') }}</label>
                                    <input type="text" name="agent_phone" class="form-control"
                                        value="{{ old('agent_phone', $plot->agent_phone) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Commission (PKR)') }}</label>
                                    <input type="number" step="0.01" name="agent_commission" class="form-control"
                                        value="{{ old('agent_commission', $plot->agent_commission) }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Address') }}</label>
                                    <input type="text" name="agent_address" class="form-control"
                                        value="{{ old('agent_address', $plot->agent_address) }}">
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- Patwari Expense Breakdown --}}
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="text-secondary mb-0">{{ __('Patwari Expense Breakdown') }}</h6>
                            <button type="button" id="add-patwari-row" class="btn btn-sm btn-outline-secondary">
                                <i class="ti ti-plus"></i> {{ __('Add Row') }}
                            </button>
                        </div>
                        <div class="table-responsive mb-2">
                            <table class="table table-sm table-bordered" id="patwari-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('Person') }}</th>
                                        <th>{{ __('Amount') }}</th>
                                        <th>{{ __('Note') }}</th>
                                        <th style="width:50px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($plot->patwariExpenses as $pe)
                                        <tr>
                                            <td><input type="text" name="patwari_person[]"
                                                    class="form-control form-control-sm" value="{{ $pe->person_name }}">
                                            </td>
                                            <td><input type="number" step="0.01" name="patwari_amount[]"
                                                    class="form-control form-control-sm" value="{{ $pe->amount }}">
                                            </td>
                                            <td><input type="text" name="patwari_note[]"
                                                    class="form-control form-control-sm" value="{{ $pe->note }}">
                                            </td>
                                            <td><button type="button" class="btn btn-sm btn-danger remove-row"><i
                                                        class="ti ti-trash"></i></button></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td><input type="text" name="patwari_person[]"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" step="0.01" name="patwari_amount[]"
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="text" name="patwari_note[]"
                                                    class="form-control form-control-sm"></td>
                                            <td><button type="button" class="btn btn-sm btn-danger remove-row"><i
                                                        class="ti ti-trash"></i></button></td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Patwari Total (PKR)') }}</label>
                                    <input type="number" step="0.01" name="patwari_total" id="patwari_total"
                                        class="form-control" value="{{ old('patwari_total', $plot->patwari_total) }}">
                                    <small
                                        class="text-muted">{{ __('Auto-sums from rows above; you can override manually.') }}</small>
                                </div>
                            </div>
                        </div>

                        <hr>

                        {{-- Existing Documents --}}
                        <h6 class="mb-3" style="color:#6f42c1;">{{ __('Existing Documents') }}</h6>
                        @if ($plot->documents->count() > 0)
                            <div class="row mb-3">
                                @foreach ($plot->documents as $doc)
                                    <div class="col-md-3 mb-3">
                                        <div class="card border">
                                            <div class="card-body text-center p-3">
                                                <i class="ti ti-file" style="font-size:2rem; color:#6f42c1;"></i>
                                                <p class="mb-1 mt-2"><strong>{{ $doc->document_name }}</strong></p>
                                                <small class="text-muted">{{ $doc->document_type ?? 'Document' }}</small>
                                                <div class="mt-2">
                                                    <a href="{{ Storage::url($doc->document_path) }}" target="_blank"
                                                        class="btn btn-sm btn-info"><i class="ti ti-download"></i></a>
                                                    <a href="{{ route('real.estate.document.delete', $doc->id) }}"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Delete?')"><i
                                                            class="ti ti-trash"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">{{ __('No documents uploaded yet.') }}</p>
                        @endif

                        {{-- Upload New Documents --}}
                        <h6 class="mb-3" style="color:#6f42c1;">{{ __('Upload New Documents') }}</h6>
                        <div class="table-responsive mb-3">
                            <table class="table table-sm table-bordered" id="documents-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('File') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Type') }}</th>
                                        <th style="width:50px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="file" name="documents[]"
                                                class="form-control form-control-sm"></td>
                                        <td><input type="text" name="document_names[]"
                                                class="form-control form-control-sm" placeholder="e.g. Sale Deed">
                                        </td>
                                        <td><input type="text" name="document_types[]"
                                                class="form-control form-control-sm" placeholder="e.g. PDF/Image">
                                        </td>
                                        <td><button type="button" class="btn btn-sm btn-danger remove-row"><i
                                                    class="ti ti-trash"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button type="button" id="add-document-row" class="btn btn-sm btn-outline-secondary mb-4">
                            <i class="ti ti-plus"></i> {{ __('Add Document Row') }}
                        </button>

                        <div class="text-end">
                            <a href="{{ route('plot.show', $plot->id) }}"
                                class="btn btn-secondary">{{ __('Cancel') }}</a>
                            <button type="submit" class="btn btn-primary">{{ __('Update Plot') }}</button>
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
        (function() {
            // Add / remove Patwari rows
            document.getElementById('add-patwari-row').addEventListener('click', function() {
                var tbody = document.querySelector('#patwari-table tbody');
                var row = document.createElement('tr');
                row.innerHTML =
                    '<td><input type="text" name="patwari_person[]" class="form-control form-control-sm"></td>' +
                    '<td><input type="number" step="0.01" name="patwari_amount[]" class="form-control form-control-sm"></td>' +
                    '<td><input type="text" name="patwari_note[]" class="form-control form-control-sm"></td>' +
                    '<td><button type="button" class="btn btn-sm btn-danger remove-row"><i class="ti ti-trash"></i></button></td>';
                tbody.appendChild(row);
            });

            // Add document row
            document.getElementById('add-document-row').addEventListener('click', function() {
                var tbody = document.querySelector('#documents-table tbody');
                var row = document.createElement('tr');
                row.innerHTML =
                    '<td><input type="file" name="documents[]" class="form-control form-control-sm"></td>' +
                    '<td><input type="text" name="document_names[]" class="form-control form-control-sm" placeholder="e.g. Sale Deed"></td>' +
                    '<td><input type="text" name="document_types[]" class="form-control form-control-sm" placeholder="e.g. PDF/Image"></td>' +
                    '<td><button type="button" class="btn btn-sm btn-danger remove-row"><i class="ti ti-trash"></i></button></td>';
                tbody.appendChild(row);
            });

            // Remove row (delegated, works for dynamically added rows too)
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-row')) {
                    var row = e.target.closest('tr');
                    var tbody = row.parentElement;
                    if (tbody.rows.length > 1) {
                        row.remove();
                        recalcPatwariTotal();
                    } else {
                        row.querySelectorAll('input').forEach(function(input) {
                            input.value = '';
                        });
                    }
                }
            });

            function recalcPatwariTotal() {
                var total = 0;
                document.querySelectorAll('input[name="patwari_amount[]"]').forEach(function(input) {
                    total += parseFloat(input.value) || 0;
                });
                document.getElementById('patwari_total').value = total.toFixed(2);
            }

            document.addEventListener('input', function(e) {
                if (e.target.matches('input[name="patwari_amount[]"]')) {
                    recalcPatwariTotal();
                }
            });

            // ===== Land Area Conversion (Acre / Kanal / Marla -> Total Marla) =====
            // Standard Pakistani revenue conversion: 1 Acre = 8 Kanal, 1 Kanal = 20 Marla
            var MARLA_PER_KANAL = 20;
            var KANAL_PER_ACRE = 8;

            var acreInput = document.getElementById('area_acre');
            var kanalInput = document.getElementById('area_kanal');
            var marlaInput = document.getElementById('area_marla');
            var totalDisplay = document.getElementById('total_marla_display');
            var totalHidden = document.getElementById('area_quantity');

            function calculateTotal() {
                var acre = parseFloat(acreInput.value) || 0;
                var kanal = parseFloat(kanalInput.value) || 0;
                var marla = parseFloat(marlaInput.value) || 0;

                var totalMarla = (acre * KANAL_PER_ACRE * MARLA_PER_KANAL) + (kanal * MARLA_PER_KANAL) + marla;

                totalDisplay.value = totalMarla;
                totalHidden.value = totalMarla;
            }

            [acreInput, kanalInput, marlaInput].forEach(function(input) {
                input.addEventListener('input', calculateTotal);
            });

            // ======= Leaflet Map (replaces Google Maps) =======
            var latInput = document.getElementById('field_lat');
            var lngInput = document.getElementById('field_lng');

            var defaultLat = parseFloat(latInput.value) ||
                {{ $plot->mouza->latitude ?? 31.5204 }};
            var defaultLng = parseFloat(lngInput.value) ||
                {{ $plot->mouza->longitude ?? 74.3587 }};
            var hasInitial = !!(latInput.value && lngInput.value);

            var map = L.map('field-map-picker').setView([defaultLat, defaultLng], hasInitial ? 17 : 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            var marker = L.marker([defaultLat, defaultLng], {
                draggable: true
            }).addTo(map);

            function setFieldCoords(lat, lng) {
                latInput.value = lat.toFixed(7);
                lngInput.value = lng.toFixed(7);
            }

            marker.on('dragend', function(e) {
                var pos = e.target.getLatLng();
                setFieldCoords(pos.lat, pos.lng);
            });

            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                setFieldCoords(e.latlng.lat, e.latlng.lng);
            });
        })();
    </script>
@endpush

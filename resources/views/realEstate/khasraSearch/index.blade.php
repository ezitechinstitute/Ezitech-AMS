@extends('layouts.admin')
@section('page-title')
    {{ __('Khasra Search') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <input type="text" id="khasra-search-input" class="form-control"
                            placeholder="{{ __('Search Khasra Number...') }}">
                    </div>
                    <div class="table-responsive">
                        <table class="table" id="khasra-results-table">
                            <thead>
                                <tr>
                                    <th>{{ __('Mouza') }}</th>
                                    <th>{{ __('Kiwat') }}</th>
                                    <th>{{ __('Khasra No.') }}</th>
                                    <th>{{ __('Seller') }}</th>
                                    <th>{{ __('Area') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody id="khasra-results-body">
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        {{ __('Type a Khasra number above to search.') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-page')
    <script>
        const input = document.getElementById('khasra-search-input');
        const body = document.getElementById('khasra-results-body');
        let timer;

        input.addEventListener('input', function() {
            clearTimeout(timer);
            const q = this.value.trim();

            timer = setTimeout(function() {
                fetch(`{{ route('khasra.search.data') }}?q=${encodeURIComponent(q)}`)
                    .then(res => res.json())
                    .then(data => renderRows(data, q));
            }, 300); // debounce
        });

        function renderRows(rows, q) {
            if (!q) {
                body.innerHTML =
                    `<tr><td colspan="7" class="text-center text-muted">Type a Khasra number above to search.</td></tr>`;
                return;
            }
            if (rows.length === 0) {
                body.innerHTML =
                    `<tr><td colspan="7" class="text-center text-muted">No khasra found matching "${q}".</td></tr>`;
                return;
            }

            body.innerHTML = rows.map(r => `
            <tr>
                <td>${r.mouza_name}</td>
                <td>${r.kiwat_number}</td>
                <td><strong>${r.field_number}</strong></td>
                <td>${r.seller_name}</td>
                <td>${r.area}</td>
                <td>${r.status === 'sold'
                    ? '<span class="badge bg-success">Purchased</span>'
                    : '<span class="badge bg-danger">Available</span>'}</td>
                <td>
                    <a href="/mouza/${r.mouza_id}?highlight=${r.id}" class="btn btn-sm btn-info">
                        <i class="ti ti-map-pin"></i> View on Map
                    </a>
                </td>
            </tr>
        `).join('');
        }
    </script>
@endpush

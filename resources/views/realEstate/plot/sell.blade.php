@extends('layouts.admin')
@section('page-title')
    {{ __('Sell Plot') }} #{{ $plot->field_number }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
    </li>
    <li class="breadcrumb-item"><a href="{{ route('plot.inventory') }}">{{ __('Plot Inventory') }}</a></li>
    <li class="breadcrumb-item">{{ __('Sell Plot') }} #{{ $plot->field_number }}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <a href="{{ route('plot.inventory') }}" class="btn btn-sm btn-secondary">
            <i class="ti ti-arrow-left"></i> {{ __('Back') }}
        </a>
    </div>
@endsection

@section('content')
    <form action="{{ route('plot.sell.store', $plot->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">

            {{-- Plot Summary Card --}}
            <div class="col-12">
                <div class="card border-success">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="ti ti-shopping-cart"></i> {{ __('Sell Plot') }}
                            #{{ $plot->field_number }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <p class="mb-1"><strong>{{ __('Plot No') }}:</strong></p>
                                <p class="text-primary fs-5">{{ $plot->field_number }}</p>
                            </div>
                            <div class="col-md-3">
                                <p class="mb-1"><strong>{{ __('Intiqal No') }}:</strong></p>
                                <p>{{ $plot->intiqal_no ?? '-' }}</p>
                            </div>
                            <div class="col-md-3">
                                <p class="mb-1"><strong>{{ __('Area') }}:</strong></p>
                                <p>{{ $plot->area_quantity }} {{ $plot->area_unit }}</p>
                            </div>
                            <div class="col-md-3">
                                <p class="mb-1"><strong>{{ __('Amount') }}:</strong></p>
                                <p class="text-success fs-5"><strong>PKR {{ number_format($plot->amount, 2) }}</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Purchaser Details --}}
            <div class="col-md-6 mt-3">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="ti ti-user"></i> {{ __('Purchaser Details') }}</h5>
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
                        <div class="form-group mb-3">
                            <label class="form-label">{{ __('Purchaser Full Name') }} <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="purchaser_name" class="form-control" required
                                value="{{ old('purchaser_name') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">{{ __('Father Name') }}</label>
                            <input type="text" name="purchaser_father_name" class="form-control"
                                value="{{ old('purchaser_father_name') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">{{ __('CNIC No.') }}</label>
                            <input type="text" name="purchaser_cnic" class="form-control" placeholder="xxxxx-xxxxxxx-x"
                                value="{{ old('purchaser_cnic') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">{{ __('Phone') }}</label>
                            <input type="text" name="purchaser_phone" class="form-control"
                                value="{{ old('purchaser_phone') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">{{ __('Address') }}</label>
                            <textarea name="purchaser_address" class="form-control" rows="2">{{ old('purchaser_address') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Commission Agent --}}
            <div class="col-md-6 mt-3">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="ti ti-users"></i> {{ __('Commission Agent') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label class="form-label">{{ __('Agent Name') }}</label>
                            <input type="text" name="agent_name" class="form-control" value="{{ old('agent_name') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">{{ __('Agent CNIC') }}</label>
                            <input type="text" name="agent_cnic" class="form-control" value="{{ old('agent_cnic') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">{{ __('Agent Phone') }}</label>
                            <input type="text" name="agent_phone" class="form-control" value="{{ old('agent_phone') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">{{ __('Agent Address') }}</label>
                            <textarea name="agent_address" class="form-control" rows="2">{{ old('agent_address') }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">{{ __('Commission Amount (PKR)') }}</label>
                            <input type="number" name="agent_commission" class="form-control" step="0.01"
                                value="{{ old('agent_commission', 0) }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Patwari Expense --}}
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="ti ti-receipt"></i> {{ __('Patwari Expenses') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label class="form-label">{{ __('Total Patwari Expense (PKR)') }}</label>
                            <input type="number" name="patwari_total" class="form-control" step="0.01"
                                value="{{ old('patwari_total', 0) }}">
                        </div>
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
                                    <tr>
                                        <td><input type="text" name="patwari_person[]"
                                                class="form-control form-control-sm"></td>
                                        <td><input type="number" name="patwari_amount[]"
                                                class="form-control form-control-sm" step="0.01"></td>
                                        <td><input type="text" name="patwari_note[]"
                                                class="form-control form-control-sm"></td>
                                        <td><button type="button" class="btn btn-sm btn-danger"
                                                onclick="this.closest('tr').remove()"><i class="ti ti-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bank Link --}}
            <div class="col-md-6 mt-3">
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
                                        {{ old('bank_account_id') == $bank->id ? 'selected' : '' }}>
                                        {{ $bank->bank_name }} - {{ $bank->account_number }} ({{ $bank->holder_name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <small class="text-muted">
                            {{ __("Don't see your bank?") }}
                            <a href="{{ route('bank-account.create') }}"
                                target="_blank">{{ __('Add New Bank Account') }}</a>
                        </small>
                    </div>
                </div>
            </div>

            {{-- Supporting Documents --}}
            <div class="col-md-6 mt-3">
                <div class="card">
                    <div class="card-header" style="background:#6f42c1; color:white;">
                        <h5 class="mb-0"><i class="ti ti-paperclip"></i> {{ __('Supporting Documents') }}</h5>
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
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label class="form-label">{{ __('Notes / Remarks') }}</label>
                            <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                        </div>
                        <div class="text-end">
                            <a href="{{ route('plot.inventory') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                            <button type="submit" class="btn btn-success">
                                <i class="ti ti-check"></i> {{ __('Confirm Sale') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
@endsection

@push('script-page')
    <script>
        function addPatwariRow() {
            var html = '<tr>' +
                '<td><input type="text" name="patwari_person[]" class="form-control form-control-sm"></td>' +
                '<td><input type="number" name="patwari_amount[]" class="form-control form-control-sm" step="0.01"></td>' +
                '<td><input type="text" name="patwari_note[]" class="form-control form-control-sm"></td>' +
                '<td><button type="button" class="btn btn-sm btn-danger" onclick="this.closest(\'tr\').remove()"><i class="ti ti-trash"></i></button></td>' +
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
    </script>
@endpush

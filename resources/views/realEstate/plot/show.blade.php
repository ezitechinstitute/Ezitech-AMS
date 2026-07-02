@extends('layouts.admin')
@section('page-title')
    {{ __('Plot Detail') }} - {{ $plot->field_number }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('plot.index') }}">{{ __('Plots') }}</a></li>
    <li class="breadcrumb-item">{{ $plot->field_number }}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <a href="{{ route('plot.edit', $plot->id) }}" class="btn btn-sm btn-warning">
            <i class="ti ti-pencil"></i> {{ __('Edit') }}
        </a>
        <a href="{{ route('plot.index') }}" class="btn btn-sm btn-secondary">
            <i class="ti ti-arrow-left"></i> {{ __('Back') }}
        </a>
    </div>
@endsection

@section('content')
    <div class="row">

        {{-- Status Banner --}}
        <div class="col-12 mb-3">
            @if ($plot->status == 'available')
                <div class="alert alert-danger mb-0">
                    <h5 class="mb-0">🔴 {{ __('Status: Available (Not Sold)') }}</h5>
                </div>
            @else
                <div class="alert alert-success mb-0">
                    <h5 class="mb-0">🟢 {{ __('Status: Sold') }}</h5>
                </div>
            @endif
        </div>

        {{-- Plot Info --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ __('Plot Information') }}</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>{{ __('Field Number') }}</strong></td>
                            <td>{{ $plot->field_number }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ __('Intiqal No.') }}</strong></td>
                            <td>{{ $plot->intiqal_no ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ __('Area') }}</strong></td>
                            <td>{{ $plot->area_quantity }} {{ $plot->area_unit }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ __('Amount') }}</strong></td>
                            <td><strong>PKR {{ number_format($plot->amount, 2) }}</strong></td>
                        </tr>
                        <tr>
                            <td><strong>{{ __('Bank Account') }}</strong></td>
                            <td>{{ $plot->bankAccount ? $plot->bankAccount->bank_name . ' - ' . $plot->bankAccount->account_number : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td><strong>{{ __('Notes') }}</strong></td>
                            <td>{{ $plot->notes ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- Purchaser Details --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">{{ __('Purchaser Details') }}</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>{{ __('Name') }}</strong></td>
                            <td>{{ $plot->purchaser_name }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ __('Father Name') }}</strong></td>
                            <td>{{ $plot->purchaser_father_name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ __('CNIC') }}</strong></td>
                            <td>{{ $plot->purchaser_cnic ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ __('Phone') }}</strong></td>
                            <td>{{ $plot->purchaser_phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ __('Address') }}</strong></td>
                            <td>{{ $plot->purchaser_address ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- Commission Agent --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">{{ __('Commission Agent') }}</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>{{ __('Name') }}</strong></td>
                            <td>{{ $plot->agent_name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ __('CNIC') }}</strong></td>
                            <td>{{ $plot->agent_cnic ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ __('Phone') }}</strong></td>
                            <td>{{ $plot->agent_phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ __('Address') }}</strong></td>
                            <td>{{ $plot->agent_address ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ __('Commission') }}</strong></td>
                            <td><strong>PKR {{ number_format($plot->agent_commission, 2) }}</strong></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- Patwari Expense --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">{{ __('Patwari Expenses') }}</h5>
                </div>
                <div class="card-body">
                    <h6>{{ __('Total') }}: <strong>PKR {{ number_format($plot->patwari_total, 2) }}</strong></h6>
                    @if ($plot->patwariExpenses->count() > 0)
                        <div class="table-responsive mt-2">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('Person') }}</th>
                                        <th>{{ __('Amount') }}</th>
                                        <th>{{ __('Note') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($plot->patwariExpenses as $pe)
                                        <tr>
                                            <td>{{ $pe->person_name }}</td>
                                            <td>PKR {{ number_format($pe->amount, 2) }}</td>
                                            <td>{{ $pe->note ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">{{ __('No breakdown added.') }}</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Supporting Documents --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header" style="background:#6f42c1; color:white;">
                    <h5 class="mb-0">{{ __('Supporting Documents') }}</h5>
                </div>
                <div class="card-body">
                    @if ($plot->documents->count() > 0)
                        <div class="row">
                            @foreach ($plot->documents as $doc)
                                <div class="col-md-3 mb-3">
                                    <div class="card border">
                                        <div class="card-body text-center p-3">
                                            <i class="ti ti-file" style="font-size:2rem; color:#6f42c1;"></i>
                                            <p class="mb-1 mt-2"><strong>{{ $doc->document_name }}</strong></p>
                                            <small class="text-muted">{{ $doc->document_type ?? 'Document' }}</small>
                                            <div class="mt-2">
                                                <a href="{{ Storage::url($doc->document_path) }}" target="_blank"
                                                    class="btn btn-sm btn-info">
                                                    <i class="ti ti-download"></i> View
                                                </a>
                                                <a href="{{ route('real.estate.document.delete', $doc->id) }}"
                                                    class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">
                                                    <i class="ti ti-trash"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">{{ __('No documents uploaded.') }}</p>
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection

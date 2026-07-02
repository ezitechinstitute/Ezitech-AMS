@extends('layouts.admin')
@section('page-title')
    {{ __('Khait Detail') }} - {{ $field->field_number }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('mouza.index') }}">{{ __('Mouza') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('mouza.show', $field->mouza_id) }}">{{ $field->mouza->name }}</a></li>
    <li class="breadcrumb-item">{{ $field->field_number }}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <a href="{{ route('mouza.field.edit', $field->id) }}" class="btn btn-sm btn-warning">
            <i class="ti ti-pencil"></i> {{ __('Edit') }}
        </a>
        <a href="{{ route('mouza.show', $field->mouza_id) }}" class="btn btn-sm btn-secondary">
            <i class="ti ti-arrow-left"></i> {{ __('Back') }}
        </a>
    </div>
@endsection

@section('content')
<div class="row">

    {{-- Status Banner --}}
    <div class="col-12 mb-3">
        @if($field->status == 'available')
            <div class="alert alert-danger mb-0"><h5 class="mb-0">🔴 {{ __('Status: Available (Not Sold)') }}</h5></div>
        @else
            <div class="alert alert-success mb-0"><h5 class="mb-0">🟢 {{ __('Status: Sold') }}</h5></div>
        @endif
    </div>

    {{-- Field Info --}}
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white"><h5 class="mb-0">{{ __('Field Information') }}</h5></div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr><td><strong>{{ __('Mouza') }}</strong></td><td>{{ $field->mouza->name }}</td></tr>
                    <tr><td><strong>{{ __('Field Number') }}</strong></td><td>{{ $field->field_number }}</td></tr>
                    <tr><td><strong>{{ __('Intiqal No.') }}</strong></td><td>{{ $field->intiqal_no ?? '-' }}</td></tr>
                    <tr><td><strong>{{ __('Area') }}</strong></td><td>{{ $field->area_quantity }} {{ $field->area_unit }}</td></tr>
                    <tr><td><strong>{{ __('Amount') }}</strong></td><td><strong>PKR {{ number_format($field->amount, 2) }}</strong></td></tr>
                    <tr><td><strong>{{ __('Bank Account') }}</strong></td><td>{{ $field->bankAccount ? $field->bankAccount->bank_name . ' - ' . $field->bankAccount->account_number : '-' }}</td></tr>
                    <tr><td><strong>{{ __('Notes') }}</strong></td><td>{{ $field->notes ?? '-' }}</td></tr>
                </table>
            </div>
        </div>
    </div>

    {{-- Seller Details --}}
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info text-white"><h5 class="mb-0">{{ __('Seller Details') }}</h5></div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr><td><strong>{{ __('Name') }}</strong></td><td>{{ $field->seller_name }}</td></tr>
                    <tr><td><strong>{{ __('Father Name') }}</strong></td><td>{{ $field->seller_father_name ?? '-' }}</td></tr>
                    <tr><td><strong>{{ __('CNIC') }}</strong></td><td>{{ $field->seller_cnic ?? '-' }}</td></tr>
                    <tr><td><strong>{{ __('Phone') }}</strong></td><td>{{ $field->seller_phone ?? '-' }}</td></tr>
                    <tr><td><strong>{{ __('Address') }}</strong></td><td>{{ $field->seller_address ?? '-' }}</td></tr>
                </table>
            </div>
        </div>
    </div>

    {{-- Commission Agent --}}
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-warning text-dark"><h5 class="mb-0">{{ __('Commission Agent') }}</h5></div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr><td><strong>{{ __('Name') }}</strong></td><td>{{ $field->agent_name ?? '-' }}</td></tr>
                    <tr><td><strong>{{ __('CNIC') }}</strong></td><td>{{ $field->agent_cnic ?? '-' }}</td></tr>
                    <tr><td><strong>{{ __('Phone') }}</strong></td><td>{{ $field->agent_phone ?? '-' }}</td></tr>
                    <tr><td><strong>{{ __('Address') }}</strong></td><td>{{ $field->agent_address ?? '-' }}</td></tr>
                    <tr><td><strong>{{ __('Commission') }}</strong></td><td><strong>PKR {{ number_format($field->agent_commission, 2) }}</strong></td></tr>
                </table>
            </div>
        </div>
    </div>

    {{-- Patwari Expense --}}
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-secondary text-white"><h5 class="mb-0">{{ __('Patwari Expenses') }}</h5></div>
            <div class="card-body">
                <h6>{{ __('Total') }}: <strong>PKR {{ number_format($field->patwari_total, 2) }}</strong></h6>
                @if($field->patwariExpenses->count() > 0)
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
                        @foreach($field->patwariExpenses as $pe)
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
            <div class="card-header" style="background:#6f42c1; color:white;"><h5 class="mb-0">{{ __('Supporting Documents') }}</h5></div>
            <div class="card-body">
                @if($field->documents->count() > 0)
                <div class="row">
                    @foreach($field->documents as $doc)
                    <div class="col-md-3 mb-3">
                        <div class="card border">
                            <div class="card-body text-center p-3">
                                <i class="ti ti-file" style="font-size:2rem; color:#6f42c1;"></i>
                                <p class="mb-1 mt-2"><strong>{{ $doc->document_name }}</strong></p>
                                <small class="text-muted">{{ $doc->document_type ?? 'Document' }}</small>
                                <div class="mt-2">
                                    <a href="{{ Storage::url($doc->document_path) }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="ti ti-download"></i> View
                                    </a>
                                    <a href="{{ route('real.estate.document.delete', $doc->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">
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

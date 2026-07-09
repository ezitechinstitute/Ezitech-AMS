@extends('layouts.admin')
@section('page-title')
    {{ __('Kiwat Detail') }} - {{ $kiwat->kiwat_number }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('mouza.index') }}">{{ __('Mouza') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('mouza.show', $kiwat->mouza_id) }}">{{ $kiwat->mouza->name }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('mouza.kiwat.index', $kiwat->mouza_id) }}">{{ __('Kiwats') }}</a></li>
    <li class="breadcrumb-item">{{ $kiwat->kiwat_number }}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <a href="{{ route('kiwat.edit', $kiwat->id) }}" class="btn btn-sm btn-warning">
            <i class="ti ti-pencil"></i> {{ __('Edit') }}
        </a>
        <a href="{{ route('mouza.kiwat.index', $kiwat->mouza_id) }}" class="btn btn-sm btn-secondary">
            <i class="ti ti-arrow-left"></i> {{ __('Back') }}
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        {{-- Kiwat Info --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ __('Kiwat Information') }}</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>{{ __('Mouza') }}</strong></td>
                            <td>{{ $kiwat->mouza->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ __('Kiwat Number') }}</strong></td>
                            <td>{{ $kiwat->kiwat_number }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ __('Total Area') }}</strong></td>
                            <td>{{ $kiwat->total_area ? $kiwat->total_area . ' ' . $kiwat->total_area_unit : '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>{{ __('Description') }}</strong></td>
                            <td>{{ $kiwat->description ?? '-' }}</td>
                        </tr>
                    </table>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <h4 class="text-info">{{ $kiwat->fields->count() }}</h4>
                            <small>{{ __('Khaits') }}</small>
                        </div>
                        <div class="col-6">
                            <h4 class="text-secondary">{{ $kiwat->plots->count() }}</h4>
                            <small>{{ __('Plots') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Fields under this Kiwat --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5><i class="ti ti-list"></i> {{ __('Khaits (Fields) in this Kiwat') }}</h5>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('Field No.') }}</th>
                                    <th>{{ __('Seller') }}</th>
                                    <th>{{ __('Area') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kiwat->fields as $field)
                                    <tr>
                                        <td><strong>{{ $field->field_number }}</strong></td>
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
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">{{ __('No Khaits in this Kiwat yet.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Plots under this Kiwat --}}
            <div class="card mt-3">
                <div class="card-header">
                    <h5><i class="ti ti-building"></i> {{ __('Plots in this Kiwat') }}</h5>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('Field No.') }}</th>
                                    <th>{{ __('Purchaser') }}</th>
                                    <th>{{ __('Area') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kiwat->plots as $plot)
                                    <tr>
                                        <td><strong>{{ $plot->field_number }}</strong></td>
                                        <td>{{ $plot->purchaser_name }}</td>
                                        <td>{{ $plot->area_quantity }} {{ $plot->area_unit }}</td>
                                        <td>{{ number_format($plot->amount, 2) }}</td>
                                        <td>
                                            @if ($plot->status == 'available')
                                                <span class="badge bg-danger">🔴 Available</span>
                                            @elseif ($plot->status == 'reserved')
                                                <span class="badge bg-warning">🟡 Reserved</span>
                                            @else
                                                <span class="badge bg-success">🟢 Sold</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('plot.show', $plot->id) }}" class="btn btn-sm btn-info">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">{{ __('No Plots in this Kiwat yet.') }}</td>
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

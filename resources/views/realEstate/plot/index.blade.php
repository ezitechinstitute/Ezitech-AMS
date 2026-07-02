@extends('layouts.admin')
@section('page-title')
    {{ __('Real Estate - Plots') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Real Estate') }}</li>
    <li class="breadcrumb-item">{{ __('Plots') }}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <a href="{{ route('plot.create') }}" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i> {{ __('Add Plot') }}
        </a>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead>
                        <tr>
                            <th>{{ __('#') }}</th>
                            <th>{{ __('Field No.') }}</th>
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
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $plot->field_number }}</strong></td>
                                <td>{{ $plot->intiqal_no ?? '-' }}</td>
                                <td>{{ $plot->purchaser_name }}</td>
                                <td>{{ $plot->area_quantity }} {{ $plot->area_unit }}</td>
                                <td>PKR {{ number_format($plot->amount, 2) }}</td>
                                <td>
                                    @if($plot->status == 'available')
                                        <span class="badge bg-danger">🔴 Available</span>
                                    @else
                                        <span class="badge bg-success">🟢 Sold</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('plot.show', $plot->id) }}" class="btn btn-sm btn-info"><i class="ti ti-eye"></i></a>
                                    <a href="{{ route('plot.edit', $plot->id) }}" class="btn btn-sm btn-warning"><i class="ti ti-pencil"></i></a>
                                    <form action="{{ route('plot.destroy', $plot->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="ti ti-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center">{{ __('No plots found.') }}</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

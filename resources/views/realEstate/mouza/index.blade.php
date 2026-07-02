@extends('layouts.admin')
@section('page-title')
    {{ __('Real Estate - Mouza') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Real Estate') }}</li>
    <li class="breadcrumb-item">{{ __('Mouza') }}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <a href="{{ route('mouza.create') }}" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i> {{ __('Add Mouza') }}
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
                            <th>{{ __('Mouza Name') }}</th>
                            <th>{{ __('District') }}</th>
                            <th>{{ __('Tehsil') }}</th>
                            <th>{{ __('Total Khaits') }}</th>
                            <th>{{ __('Available') }}</th>
                            <th>{{ __('Sold') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($mouzas as $mouza)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><strong>{{ $mouza->name }}</strong></td>
                                <td>{{ $mouza->district ?? '-' }}</td>
                                <td>{{ $mouza->tehsil ?? '-' }}</td>
                                <td><span class="badge bg-info">{{ $mouza->fields_count }}</span></td>
                                <td><span class="badge bg-danger">🔴 {{ $mouza->available_fields_count }}</span></td>
                                <td><span class="badge bg-success">🟢 {{ $mouza->sold_fields_count }}</span></td>
                                <td>
                                    <a href="{{ route('mouza.show', $mouza->id) }}" class="btn btn-sm btn-info" title="View & Map">
                                        <i class="ti ti-map-pin"></i> {{ __('View') }}
                                    </a>
                                    <a href="{{ route('mouza.edit', $mouza->id) }}" class="btn btn-sm btn-warning">
                                        <i class="ti ti-pencil"></i>
                                    </a>
                                    <form action="{{ route('mouza.destroy', $mouza->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this Mouza?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="ti ti-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center">{{ __('No Mouza found.') }}</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

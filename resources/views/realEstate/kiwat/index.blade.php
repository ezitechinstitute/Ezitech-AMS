@extends('layouts.admin')
@section('page-title')
    {{ __('Kiwats') }} - {{ $mouza->name }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('mouza.index') }}">{{ __('Mouza') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('mouza.show', $mouza->id) }}">{{ $mouza->name }}</a></li>
    <li class="breadcrumb-item">{{ __('Kiwats') }}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <a href="{{ route('mouza.kiwat.create', $mouza->id) }}" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i> {{ __('Add Kiwat') }}
        </a>
        <a href="{{ route('mouza.show', $mouza->id) }}" class="btn btn-sm btn-secondary">
            <i class="ti ti-arrow-left"></i> {{ __('Back to Mouza') }}
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="ti ti-stack"></i> {{ __('Kiwats (Blocks / Phases)') }} - {{ $mouza->name }}</h5>
                </div>
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>{{ __('#') }}</th>
                                    <th>{{ __('Kiwat Number') }}</th>
                                    <th>{{ __('Description') }}</th>
                                    <th>{{ __('Total Area') }}</th>
                                    <th>{{ __('Fields') }}</th>
                                    <th>{{ __('Plots') }}</th>
                                    <th>{{ __('Available') }}</th>
                                    <th>{{ __('Sold') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kiwats as $kiwat)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><strong>{{ $kiwat->kiwat_number }}</strong></td>
                                        <td>{{ $kiwat->description ?? '-' }}</td>
                                        <td>{{ $kiwat->total_area ? $kiwat->total_area . ' ' . $kiwat->total_area_unit : '-' }}
                                        </td>
                                        <td><span class="badge bg-info">{{ $kiwat->fields_count }}</span></td>
                                        <td><span class="badge bg-secondary">{{ $kiwat->plots_count }}</span></td>
                                        <td><span class="badge bg-danger">🔴 {{ $kiwat->available_plots_count }}</span>
                                        </td>
                                        <td><span class="badge bg-success">🟢 {{ $kiwat->sold_plots_count }}</span></td>
                                        <td>
                                            <a href="{{ route('kiwat.show', $kiwat->id) }}" class="btn btn-sm btn-info">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            <a href="{{ route('kiwat.edit', $kiwat->id) }}" class="btn btn-sm btn-warning">
                                                <i class="ti ti-pencil"></i>
                                            </a>
                                            <form action="{{ route('kiwat.destroy', $kiwat->id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Delete this Kiwat?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger"><i class="ti ti-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">
                                            {{ __('No Kiwats found for this Mouza.') }}
                                            <a
                                                href="{{ route('mouza.kiwat.create', $mouza->id) }}">{{ __('Add First Kiwat') }}</a>
                                        </td>
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

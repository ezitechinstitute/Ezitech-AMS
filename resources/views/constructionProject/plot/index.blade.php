@extends('layouts.admin')
@section('page-title')
    {{ __('Construction Project - Plots') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Construction Project Gulberg') }}</li>
    <li class="breadcrumb-item">{{ __('Plots') }}</li>
@section('action-btn')
    <div class="float-end">
        @php $cp = \App\Models\ConstructionProject::where('created_by', auth()->user()->creatorId())->first(); @endphp
        @if ($cp)
            <a href="{{ route('construction-project.plot.create', $cp->id) }}" class="btn btn-sm btn-primary">
                <i class="ti ti-plus"></i> {{ __('Add Plot') }}
            </a>
        @endif
    </div>
@endsection
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
                                <th>{{ __('Project') }}</th>
                                <th>{{ __('Plot No') }}</th>
                                <th>{{ __('Intiqal No') }}</th>
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
                                    <td>{{ $plot->project->name ?? '-' }}</td>
                                    <td><strong>{{ $plot->field_number }}</strong></td>
                                    <td>{{ $plot->intiqal_no ?? '-' }}</td>
                                    <td>{{ $plot->purchaser_name }}</td>
                                    <td>{{ $plot->area_quantity }} {{ $plot->area_unit }}</td>
                                    <td>PKR {{ number_format($plot->amount, 2) }}</td>
                                    <td>
                                        @if ($plot->status == 'available')
                                            <span class="badge bg-primary">🔵 {{ __('Available') }}</span>
                                        @else
                                            <span class="badge bg-success">🟢 {{ __('Sold') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('construction-project.show', $plot->construction_project_id) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                        <a href="{{ route('construction-project.plot.edit', $plot->id) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="ti ti-pencil"></i>
                                        </a>
                                        <form action="{{ route('construction-project.plot.destroy', $plot->id) }}"
                                            method="POST" class="d-inline" onsubmit="return confirm('Delete?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger"><i class="ti ti-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">{{ __('No plots found.') }}</td>
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

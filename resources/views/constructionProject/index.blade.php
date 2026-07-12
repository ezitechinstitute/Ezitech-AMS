@extends('layouts.admin')
@section('page-title')
    {{ __('Construction Projects') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Construction Projects') }}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <a href="{{ route('construction-project.create') }}" class="btn btn-sm btn-primary">
            <i class="ti ti-plus"></i> {{ __('Add Project') }}
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Project Name') }}</th>
                                    <th>{{ __('District') }}</th>
                                    <th>{{ __('Tehsil') }}</th>
                                    <th>{{ __('Total Area') }}</th>
                                    <th>{{ __('Fields') }}</th>
                                    <th>{{ __('Plots') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $i => $project)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td><a
                                                href="{{ route('construction-project.show', $project->id) }}">{{ $project->name }}</a>
                                        </td>
                                        <td>{{ $project->district ?? '-' }}</td>
                                        <td>{{ $project->tehsil ?? '-' }}</td>
                                        <td>{{ $project->total_area ? $project->total_area . ' ' . $project->total_area_unit : '-' }}
                                        </td>
                                        <td>{{ $project->fields->count() }}</td>
                                        <td>{{ $project->plots->count() }}</td>
                                        <td>
                                            <a href="{{ route('construction-project.show', $project->id) }}"
                                                class="btn btn-sm btn-warning"><i class="ti ti-eye"></i></a>
                                            <a href="{{ route('construction-project.edit', $project->id) }}"
                                                class="btn btn-sm btn-info"><i class="ti ti-edit"></i></a>
                                            <form action="{{ route('construction-project.destroy', $project->id) }}"
                                                method="POST" style="display:inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Delete?')"><i class="ti ti-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

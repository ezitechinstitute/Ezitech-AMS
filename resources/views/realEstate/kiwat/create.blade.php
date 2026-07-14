@extends('layouts.admin')
@section('page-title')
    {{ __('Add Kiwat') }} - {{ $mouza->name }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('mouza.index') }}">{{ __('Mouza') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('mouza.show', $mouza->id) }}">{{ $mouza->name }}</a></li>
    <li class="breadcrumb-item">{{ __('Add Kiwat') }}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <a href="{{ route('mouza.show', $mouza->id) }}" class="btn btn-sm btn-secondary">
            <i class="ti ti-arrow-left"></i> {{ __('Back') }}
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Add Kiwat (Block / Phase)') }} - {{ $mouza->name }}</h5>
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

                    <form action="{{ route('mouza.kiwat.store', $mouza->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Kiwat Number') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="kiwat_number" class="form-control" required
                                        value="{{ old('kiwat_number') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Total Area') }}</label>
                                    <input type="text" name="total_area" class="form-control"
                                        value="{{ old('total_area') }}" placeholder="e.g. 25">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Unit') }}</label>
                                    <select name="total_area_unit" class="form-control">
                                        <option value="Kanal" {{ old('total_area_unit') == 'Kanal' ? 'selected' : '' }}>
                                            Kanal</option>
                                        <option value="Marla" {{ old('total_area_unit') == 'Marla' ? 'selected' : '' }}>
                                            Marla</option>
                                        <option value="Acre" {{ old('total_area_unit') == 'Acre' ? 'selected' : '' }}>
                                            Acre</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Description') }}</label>
                                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('mouza.show', $mouza->id) }}"
                                class="btn btn-secondary">{{ __('Cancel') }}</a>
                            <button type="submit" class="btn btn-primary">{{ __('Save Kiwat') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

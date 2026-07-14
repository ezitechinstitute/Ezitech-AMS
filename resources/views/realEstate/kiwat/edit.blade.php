@extends('layouts.admin')
@section('page-title')
    {{ __('Edit Kiwat') }} - {{ $kiwat->kiwat_number }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('mouza.index') }}">{{ __('Mouza') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('mouza.show', $kiwat->mouza_id) }}">{{ $kiwat->mouza->name }}</a></li>
    <li class="breadcrumb-item">{{ __('Edit Kiwat') }}</li>
@endsection
@section('action-btn')
    <div class="float-end">
        <a href="{{ route('kiwat.show', $kiwat->id) }}" class="btn btn-sm btn-secondary">
            <i class="ti ti-arrow-left"></i> {{ __('Back') }}
        </a>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ __('Edit Kiwat') }} - {{ $kiwat->mouza->name }}</h5>
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

                    <form action="{{ route('kiwat.update', $kiwat->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Kiwat Number') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="kiwat_number" class="form-control" required
                                        value="{{ old('kiwat_number', $kiwat->kiwat_number) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Total Area') }}</label>
                                    <input type="text" name="total_area" class="form-control"
                                        value="{{ old('total_area', $kiwat->total_area) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Unit') }}</label>
                                    <select name="total_area_unit" class="form-control">
                                        <option value="Kanal"
                                            {{ old('total_area_unit', $kiwat->total_area_unit) == 'Kanal' ? 'selected' : '' }}>
                                            Kanal</option>
                                        <option value="Marla"
                                            {{ old('total_area_unit', $kiwat->total_area_unit) == 'Marla' ? 'selected' : '' }}>
                                            Marla</option>
                                        <option value="Acre"
                                            {{ old('total_area_unit', $kiwat->total_area_unit) == 'Acre' ? 'selected' : '' }}>
                                            Acre</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Description') }}</label>
                                    <textarea name="description" class="form-control" rows="3">{{ old('description', $kiwat->description) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('kiwat.show', $kiwat->id) }}"
                                class="btn btn-secondary">{{ __('Cancel') }}</a>
                            <button type="submit" class="btn btn-primary">{{ __('Update Kiwat') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

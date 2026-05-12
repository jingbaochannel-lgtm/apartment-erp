@extends('admin.layouts.admin_layout')

@php
    $singular = $meta['singular'];
    $plural = $meta['plural'];
    $slug = $meta['routeSlug'];
    $isCreate = ($mode ?? 'create') === 'create';
    $title = $isCreate
        ? __('app.actions.create_new', ['name' => $singular])
        : __('app.actions.edit_existing', ['name' => $singular]);
    $action = $isCreate
        ? route("admin.{$slug}.store")
        : route("admin.{$slug}.update", $record);
    $method = $isCreate ? 'POST' : 'PUT';
@endphp

@section('pageTitle', $title)

@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">{{ $plural }}</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route("admin.{$slug}.index") }}">{{ $plural }}</a></li>
                <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card">
    <div class="card-header bg-transparent">
        <h6 class="mb-0">{{ $title }}</h6>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>{{ __('app.flash.validation_failed') }}</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ $action }}" enctype="multipart/form-data" autocomplete="off">
            @csrf
            @if (! $isCreate) @method('PUT') @endif

            <div class="row g-3">
                @foreach ($fields as $field)
                    @php
                        $name = $field->name;
                        $value = old($name, data_get($record, $name));
                    @endphp
                    <div class="col-md-{{ in_array($field->type, ['textarea', 'file']) ? 12 : 6 }}">
                        <label for="f-{{ $name }}" class="form-label">
                            {{ $field->label }}
                            @if ($field->required) <span class="text-danger">*</span> @endif
                        </label>
                        @switch($field->type)
                            @case('textarea')
                                <textarea id="f-{{ $name }}" name="{{ $name }}"
                                          class="form-control @error($name) is-invalid @enderror"
                                          rows="{{ $field->rows ?? 3 }}"
                                          placeholder="{{ $field->placeholder }}"
                                          @if ($field->required) required @endif>{{ $value }}</textarea>
                                @break
                            @case('select')
                                <select id="f-{{ $name }}"
                                        name="{{ $name }}{{ $field->multiple ? '[]' : '' }}"
                                        class="form-select tom-select @error($name) is-invalid @enderror"
                                        @if ($field->multiple) multiple @endif
                                        @if ($field->required) required @endif>
                                    @if (! $field->required && ! $field->multiple)
                                        <option value="">— {{ __('app.actions.select') }} —</option>
                                    @endif
                                    @foreach ($field->options ?? [] as $optValue => $optLabel)
                                        <option value="{{ $optValue }}"
                                            @if ($field->multiple && is_array($value) && in_array($optValue, $value)) selected
                                            @elseif (! $field->multiple && (string) $value === (string) $optValue) selected
                                            @endif>{{ $optLabel }}</option>
                                    @endforeach
                                </select>
                                @break
                            @case('checkbox')
                                <div class="form-check form-switch mt-2">
                                    <input type="hidden" name="{{ $name }}" value="0">
                                    <input id="f-{{ $name }}" type="checkbox" name="{{ $name }}" value="1"
                                           class="form-check-input @error($name) is-invalid @enderror"
                                           {{ (int) $value ? 'checked' : '' }}>
                                </div>
                                @break
                            @case('file')
                                <input id="f-{{ $name }}" type="file" name="{{ $name }}"
                                       class="form-control @error($name) is-invalid @enderror"
                                       @if ($field->accept) accept="{{ $field->accept }}" @endif>
                                @if ($value)
                                    <small class="form-text text-muted d-block mt-1">
                                        {{ __('app.actions.current_file') }}: {{ basename($value) }}
                                    </small>
                                @endif
                                @break
                            @case('datetime')
                                <input id="f-{{ $name }}" type="text" name="{{ $name }}"
                                       value="{{ $value }}"
                                       class="form-control flatpickr-datetime @error($name) is-invalid @enderror"
                                       placeholder="YYYY-MM-DD HH:MM"
                                       @if ($field->required) required @endif>
                                @break
                            @case('date')
                                <input id="f-{{ $name }}" type="text" name="{{ $name }}"
                                       value="{{ $value }}"
                                       class="form-control flatpickr-date @error($name) is-invalid @enderror"
                                       placeholder="YYYY-MM-DD"
                                       @if ($field->required) required @endif>
                                @break
                            @case('time')
                                <input id="f-{{ $name }}" type="text" name="{{ $name }}"
                                       value="{{ $value }}"
                                       class="form-control flatpickr-time @error($name) is-invalid @enderror"
                                       placeholder="HH:MM"
                                       @if ($field->required) required @endif>
                                @break
                            @case('decimal')
                            @case('number')
                                <input id="f-{{ $name }}" type="number"
                                       step="{{ $field->type === 'decimal' ? '0.01' : '1' }}"
                                       name="{{ $name }}" value="{{ $value }}"
                                       class="form-control @error($name) is-invalid @enderror"
                                       placeholder="{{ $field->placeholder }}"
                                       @if ($field->required) required @endif>
                                @break
                            @default
                                <input id="f-{{ $name }}" type="{{ $field->type }}"
                                       name="{{ $name }}" value="{{ $value }}"
                                       class="form-control @error($name) is-invalid @enderror"
                                       placeholder="{{ $field->placeholder }}"
                                       @if ($field->required) required @endif>
                        @endswitch
                        @error($name)<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        @if ($field->help)<small class="form-text text-muted">{{ $field->help }}</small>@endif
                    </div>
                @endforeach
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i>{{ __('app.actions.save') }}
                </button>
                <a href="{{ route("admin.{$slug}.index") }}" class="btn btn-light">
                    {{ __('app.actions.cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

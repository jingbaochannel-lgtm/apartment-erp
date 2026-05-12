@extends('admin.layouts.admin_layout')

@php
    $singular = $meta['singular'];
    $plural = $meta['plural'];
    $slug = $meta['routeSlug'];
    $title = __('app.actions.view_existing', ['name' => $singular]);
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
    <div class="ms-auto">
        @if (Route::has("admin.{$slug}.edit"))
            <a href="{{ route("admin.{$slug}.edit", $record) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-1"></i>{{ __('app.actions.edit') }}
            </a>
        @endif
        <a href="{{ route("admin.{$slug}.index") }}" class="btn btn-light">
            {{ __('app.actions.back') }}
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header bg-transparent">
        <h6 class="mb-0">{{ $title }}</h6>
    </div>
    <div class="card-body">
        <dl class="row mb-0">
            @foreach ($fields as $field)
                @php $val = data_get($record, $field->name); @endphp
                <dt class="col-sm-3 text-muted">{{ $field->label }}</dt>
                <dd class="col-sm-9">
                    @if ($val === null || $val === '')
                        <span class="text-muted">—</span>
                    @elseif ($field->type === 'select' && is_array($field->options))
                        {{ $field->options[$val] ?? $val }}
                    @elseif ($field->type === 'checkbox')
                        @if ((int) $val)
                            <span class="badge bg-success">{{ __('app.actions.yes') }}</span>
                        @else
                            <span class="badge bg-secondary">{{ __('app.actions.no') }}</span>
                        @endif
                    @elseif ($field->type === 'file')
                        <a href="{{ asset('storage/'.$val) }}" target="_blank">{{ basename($val) }}</a>
                    @elseif (is_array($val))
                        <pre class="mb-0 small">{{ json_encode($val, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                    @else
                        {{ $val }}
                    @endif
                </dd>
            @endforeach
        </dl>
    </div>
</div>
@endsection

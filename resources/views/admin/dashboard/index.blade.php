@extends('admin.layouts.admin_layout')

@section('pageTitle', __('app.menu.dashboard'))

@php
    /** Tile config: each row -> [label, icon, value, bg-class, route name]. */
    $tiles = [
        [__('app.resources.apartments'),       'building',          $stats['branches'],          'bg-primary',  'admin.apartments.index'],
        [__('app.resources.tenants'),          'people-fill',       $stats['tenants'],           'bg-success',  'admin.tenants.index'],
        [__('app.resources.rooms'),            'door-closed-fill',  $stats['rooms'],             'bg-info',     'admin.rooms.index'],
        [__('app.dashboard.occupied_rooms'),   'house-check-fill',  $stats['occupied_rooms'],    'bg-warning',  'admin.rooms.index'],
        [__('app.dashboard.active_contracts'), 'file-earmark-text', $stats['active_contracts'],  'bg-secondary','admin.rental-contracts.index'],
        [__('app.dashboard.unpaid_invoices'),  'cash-coin',         $stats['unpaid_invoices'],   'bg-danger',   'admin.invoices.index'],
        [__('app.dashboard.open_maintenance'), 'tools',             $stats['open_maintenance'],  'bg-dark',     'admin.maintenance-requests.index'],
    ];
@endphp

@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">{{ __('app.menu.admin') }}</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('app.menu.dashboard') }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-3 mb-4">
    @foreach ($tiles as [$label, $icon, $value, $bg, $route])
        <div class="col">
            <a href="{{ \Illuminate\Support\Facades\Route::has($route) ? route($route) : '#' }}" class="text-decoration-none text-reset">
                <div class="card radius-10 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="rounded-circle text-white {{ $bg }} d-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                            <i class="bi bi-{{ $icon }} fs-4"></i>
                        </div>
                        <div class="ms-3 flex-grow-1">
                            <p class="mb-0 text-secondary">{{ $label }}</p>
                            <h4 class="my-1 fw-bold">{{ number_format((int) $value) }}</h4>
                        </div>
                        <i class="bi bi-chevron-right text-secondary"></i>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>

<div class="row g-3">
    <div class="col-lg-7">
        <div class="card radius-10 h-100">
            <div class="card-header bg-transparent">
                <h6 class="mb-0">{{ __('app.dashboard.welcome_title') }}</h6>
            </div>
            <div class="card-body">
                <p class="mb-2 text-secondary">{{ __('app.dashboard.welcome_body') }}</p>
                <ul class="list-unstyled mb-0">
                    <li class="d-flex gap-2 align-items-center mb-1"><i class="bi bi-check-circle text-success"></i> {{ __('app.dashboard.bullet_multi_branch') }}</li>
                    <li class="d-flex gap-2 align-items-center mb-1"><i class="bi bi-check-circle text-success"></i> {{ __('app.dashboard.bullet_rbac') }}</li>
                    <li class="d-flex gap-2 align-items-center mb-1"><i class="bi bi-check-circle text-success"></i> {{ __('app.dashboard.bullet_audit') }}</li>
                    <li class="d-flex gap-2 align-items-center"><i class="bi bi-check-circle text-success"></i> {{ __('app.dashboard.bullet_multilang') }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card radius-10 h-100">
            <div class="card-header bg-transparent">
                <h6 class="mb-0">{{ __('app.dashboard.quick_links') }}</h6>
            </div>
            <div class="card-body">
                <div class="row row-cols-2 g-2">
                    @foreach ([
                        'admin.tenants.create' => ['person-plus', __('app.actions.create_new', ['name' => __('app.resources.tenant')])],
                        'admin.rooms.create' => ['door-open', __('app.actions.create_new', ['name' => __('app.resources.room')])],
                        'admin.rental-contracts.create' => ['file-earmark-plus', __('app.actions.create_new', ['name' => __('app.resources.rental_contract')])],
                        'admin.invoices.create' => ['receipt', __('app.actions.create_new', ['name' => __('app.resources.invoice')])],
                        'admin.maintenance-requests.create' => ['tools', __('app.actions.create_new', ['name' => __('app.resources.maintenance_request')])],
                        'admin.utility-readings.create' => ['lightning', __('app.actions.create_new', ['name' => __('app.resources.utility_reading')])],
                    ] as $route => [$icon, $label])
                        @if (\Illuminate\Support\Facades\Route::has($route))
                            <div class="col">
                                <a href="{{ route($route) }}" class="btn btn-light w-100 text-start">
                                    <i class="bi bi-{{ $icon }} me-1"></i>{{ $label }}
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

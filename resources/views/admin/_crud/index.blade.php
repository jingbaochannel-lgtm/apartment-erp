@extends('admin.layouts.admin_layout')

@php
    $singular = $meta['singular'];
    $plural = $meta['plural'];
    $slug = $meta['routeSlug'];
    $permissionPrefix = $meta['permissionPrefix'];
    $canCreate = ! config('apartment.enforce_permissions', false)
        || (auth()->user() && auth()->user()->can($permissionPrefix.'.create'));
@endphp

@section('pageTitle', $plural)

@section('content')
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">{{ __('app.menu.admin') }}</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $plural }}</li>
            </ol>
        </nav>
    </div>
    <div class="ms-auto">
        @if ($canCreate && Route::has("admin.{$slug}.create"))
            <a href="{{ route("admin.{$slug}.create") }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>{{ __('app.actions.create_new', ['name' => $singular]) }}
            </a>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
        <h6 class="mb-0">{{ $plural }}</h6>
        <div class="d-flex gap-2">
            @if ($meta['searchable'])
            <input type="search" id="{{ $slug }}-search" class="form-control form-control-sm"
                   placeholder="{{ __('app.actions.search') }}" style="min-width: 220px;">
            @endif
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="{{ $slug }}-table" class="table table-striped table-bordered align-middle w-100">
                <thead>
                    <tr>
                        @foreach ($columns as $column => $label)
                            <th data-column="{{ $column }}">{{ $label }}</th>
                        @endforeach
                        <th class="text-end">{{ __('app.actions.label') }}</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function ($) {
        'use strict';

        const slug   = @json($slug);
        const ajax   = "{{ route("admin.{$slug}.data") }}";
        const lang   = @json(__('app.datatables'));
        const fixed  = @json([
            'paging' => true,
            'pagingType' => 'full_numbers',
            'lengthMenu' => [[10, 25, 50, 100], [10, 25, 50, 100]],
            'pageLength' => 10,
            'responsive' => true,
            'autoWidth' => false,
            'stateSave' => false,
        ]);

        const columns = @json(array_map(fn ($col) => ['data' => $col, 'name' => $col], array_keys($columns)));
        columns.push({ data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-end' });

        const dt = $('#' + slug + '-table').DataTable(Object.assign({}, fixed, {
            processing: true,
            serverSide: true,
            ajax: { url: ajax, type: 'GET' },
            columns: columns,
            language: lang,
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row align-items-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        }));

        // Custom search input feeds DataTables search.
        $('#' + slug + '-search').on('input', function () {
            dt.search(this.value).draw();
        });

        // Re-bind delete confirmation after every row redraw.
        dt.on('draw', function () {
            $('form[data-confirm-delete]').off('submit.delete').on('submit.delete', function (e) {
                e.preventDefault();
                const form = this;
                Swal.fire({
                    title: @json(__('app.dialogs.confirm_delete_title')),
                    text: $(form).data('confirm-delete'),
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: @json(__('app.dialogs.confirm_yes')),
                    cancelButtonText: @json(__('app.dialogs.confirm_cancel')),
                    confirmButtonColor: '#d33',
                }).then((res) => { if (res.isConfirmed) form.submit(); });
            });
        });
    })(window.jQuery);
</script>
@endpush

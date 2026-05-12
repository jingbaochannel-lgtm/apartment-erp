<!doctype html>
<html lang="{{ app()->getLocale() }}" class="minimal-theme">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="{{ asset('assets/backend') }}/assets/images/favicon-32x32.png" type="image/png" />

  {{-- Skodash core CSS -------------------------------------------------- --}}
  <link href="{{ asset('assets/backend') }}/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
  <link href="{{ asset('assets/backend') }}/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
  <link href="{{ asset('assets/backend') }}/assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
  <link href="{{ asset('assets/backend') }}/assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="{{ asset('assets/backend') }}/assets/css/bootstrap-extended.css" rel="stylesheet" />
  <link href="{{ asset('assets/backend') }}/assets/css/style.css" rel="stylesheet" />
  <link href="{{ asset('assets/backend') }}/assets/css/icons.css" rel="stylesheet">
  <link href="{{ asset('assets/backend/assets/plugins/bootstrap-icons/font/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">

  {{-- Loader / theme variants ------------------------------------------ --}}
  <link href="{{ asset('assets/backend') }}/assets/css/pace.min.css" rel="stylesheet" />
  <link href="{{ asset('assets/backend') }}/assets/css/dark-theme.css" rel="stylesheet" />
  <link href="{{ asset('assets/backend') }}/assets/css/light-theme.css" rel="stylesheet" />
  <link href="{{ asset('assets/backend') }}/assets/css/semi-dark.css" rel="stylesheet" />
  <link href="{{ asset('assets/backend') }}/assets/css/header-colors.css" rel="stylesheet" />

  {{-- Third-party plugins required by the CRUD admin UI ---------------- --}}
  {{-- DataTables (Bootstrap 5 fixed pagination) --}}
  <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">

  {{-- SweetAlert2 (confirm delete) --}}
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

  {{-- flatpickr (datetime pickers) --}}
  <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">

  {{-- Tom Select (searchable selects) --}}
  <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">

  {{-- PHPFlasher (toast notifications) --}}
  @flasher_render

  {{-- Khmer fonts --}}
  <link href="https://fonts.googleapis.com/css2?family=Battambang:wght@400;700&family=Hanuman:wght@400;700&display=swap" rel="stylesheet">

  <style>
    [lang="km"], .km-text, html[lang="km"] body { font-family: 'Hanuman', 'Battambang', 'Roboto', sans-serif; }
    .dataTables_wrapper .dataTables_paginate .pagination { margin: 0; }
    .table-responsive { overflow-x: auto; }
    .ts-control { min-height: 38px; }
  </style>

  <title>@yield('pageTitle', config('app.name', 'Apartment ERP'))</title>

  @stack('styles')
</head>

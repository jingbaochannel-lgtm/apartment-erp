@php
    use Illuminate\Support\Facades\Route;

    $user = auth()->user();
    $locales = config('apartment.locales', ['en' => 'English', 'km' => 'ខ្មែរ']);
    $currentLocale = app()->getLocale();
    $apartments = collect();
    $currentApartmentId = null;
    if (Route::has('admin.dashboard') && \Schema::hasTable('apartment_profiles')) {
        $currentApartmentId = session('current_apartment_id');
        $apartments = \App\Models\ApartmentProfile::query()
            ->orderBy('name')
            ->limit(50)
            ->get(['id', 'name'])
            ->mapWithKeys(fn ($a) => [$a->id => $a->name]);
    }
@endphp

<header class="top-header">
    <nav class="navbar navbar-expand">
        <div class="mobile-toggle-icon d-xl-none">
            <i class="bi bi-list"></i>
        </div>

        <div class="top-navbar d-none d-xl-block">
            <ul class="navbar-nav align-items-center">
                @if (Route::has('admin.dashboard'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">{{ __('app.menu.dashboard') }}</a>
                    </li>
                @endif
                @if (Route::has('admin.tenants.index'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.tenants.index') }}">{{ __('app.menu.tenants') }}</a>
                    </li>
                @endif
                @if (Route::has('admin.rental-contracts.index'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.rental-contracts.index') }}">{{ __('app.menu.contracts') }}</a>
                    </li>
                @endif
                @if (Route::has('admin.invoices.index'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.invoices.index') }}">{{ __('app.menu.billing') }}</a>
                    </li>
                @endif
                @if (Route::has('admin.maintenance-requests.index'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.maintenance-requests.index') }}">{{ __('app.menu.maintenance') }}</a>
                    </li>
                @endif
            </ul>
        </div>

        <form class="searchbar d-none d-xl-flex ms-auto" onsubmit="return false;">
            <div class="position-absolute top-50 translate-middle-y search-icon ms-3"><i class="bi bi-search"></i></div>
            <input class="form-control" type="text" placeholder="{{ __('app.actions.search') }}">
        </form>

        <div class="top-navbar-right ms-3">
            <ul class="navbar-nav align-items-center">

                {{-- Branch / apartment switcher ----------------------------- --}}
                @if ($apartments->isNotEmpty() && Route::has('apartment.switch'))
                    <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                            <div class="user-setting d-flex align-items-center gap-1 px-2">
                                <i class="bi bi-building"></i>
                                <div class="d-none d-md-block ms-1">
                                    {{ $apartments[$currentApartmentId] ?? __('app.menu.switch_branch') }}
                                </div>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><h6 class="dropdown-header">{{ __('app.menu.switch_branch') }}</h6></li>
                            @foreach ($apartments as $id => $name)
                                <li>
                                    <form method="POST" action="{{ route('apartment.switch') }}" class="d-block">
                                        @csrf
                                        <input type="hidden" name="apartment_profile_id" value="{{ $id }}">
                                        <button type="submit" class="dropdown-item @if ($id === $currentApartmentId) active @endif">
                                            <i class="bi bi-house-door me-2"></i>{{ $name }}
                                        </button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif

                {{-- Language switcher -------------------------------------- --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                        <div class="user-setting d-flex align-items-center gap-1 px-2">
                            <i class="bi bi-translate"></i>
                            <div class="d-none d-md-block ms-1 text-uppercase">{{ $currentLocale }}</div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><h6 class="dropdown-header">{{ __('app.menu.language') }}</h6></li>
                        @foreach ($locales as $code => $label)
                            <li>
                                <a class="dropdown-item @if ($code === $currentLocale) active @endif"
                                   href="#" data-set-locale="{{ $code }}">
                                    <span class="badge bg-secondary me-2 text-uppercase">{{ $code }}</span>{{ $label }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                {{-- User dropdown ------------------------------------------ --}}
                <li class="nav-item dropdown dropdown-large">
                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                        <div class="user-setting d-flex align-items-center gap-1">
                            <img src="{{ asset('assets/backend') }}/assets/images/avatars/avatar-1.png" class="user-img" alt="">
                            <div class="user-name d-none d-sm-block">
                                {{ $user?->name ?? $user?->email ?? __('app.auth.guest') }}
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('assets/backend') }}/assets/images/avatars/avatar-1.png" alt="" class="rounded-circle" width="60" height="60">
                                    <div class="ms-3">
                                        <h6 class="mb-0 dropdown-user-name">
                                            {{ $user?->name ?? __('app.auth.guest') }}
                                        </h6>
                                        <small class="mb-0 dropdown-user-designation text-secondary">
                                            {{ $user?->email ?? '' }}
                                        </small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        @if (Route::has('logout'))
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <div class="d-flex align-items-center">
                                            <div class="setting-icon"><i class="bi bi-box-arrow-right"></i></div>
                                            <div class="setting-text ms-3"><span>{{ __('app.menu.logout') }}</span></div>
                                        </div>
                                    </button>
                                </form>
                            </li>
                        @endif
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('app.auth.sign_in') }} · {{ __('app.app_name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%); min-height: 100vh; display: flex; align-items: center; }
        .auth-card { max-width: 420px; margin: 0 auto; }
        .auth-card .card { border: 0; border-radius: 1rem; box-shadow: 0 1rem 3rem rgba(0,0,0,.25); }
        .auth-logo { font-size: 2.25rem; color: #0d6efd; }
    </style>
</head>
<body>
<div class="container">
    <div class="auth-card w-100">
        <div class="card">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <i class="bi bi-building auth-logo"></i>
                    <h4 class="mt-2 mb-0">{{ __('app.app_name') }}</h4>
                    <small class="text-secondary">{{ __('app.tagline') }}</small>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger small">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('app.auth.email') }}</label>
                        <input id="email" name="email" type="email" class="form-control" value="{{ old('email', 'admin@apartment-erp.local') }}" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('app.auth.password') }}</label>
                        <input id="password" name="password" type="password" class="form-control" required>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">{{ __('app.auth.remember_me') }}</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-box-arrow-in-right me-1"></i>{{ __('app.auth.sign_in') }}
                    </button>
                </form>

                <div class="text-center mt-4 small text-secondary">
                    {{ __('app.auth.demo_hint') }}
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

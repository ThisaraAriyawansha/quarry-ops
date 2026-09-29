<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QuarryOps - @yield('title', __('Dashboard'))</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="layout">
        <div class="sidebar">
            <div class="brand">
                <span class="brand-accent" style="font-size:24px;">Quarry<strong style="font-family:'Prata',serif;">Ops</strong></span>
                <span>{{ __('Stone Quarry Management') }}</span>
            </div>

            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">{{ __('Dashboard') }}</a>

            @can('pos.use')
                <a href="{{ route('pos.index') }}" class="{{ request()->routeIs('pos.*') ? 'active' : '' }}">{{ __('New Sale (POS)') }}</a>
            @endcan

            @can('products.manage')
                <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">{{ __('Products') }}</a>
            @endcan

            @can('customers.manage')
                <a href="{{ route('customers.index') }}" class="{{ request()->routeIs('customers.*') ? 'active' : '' }}">{{ __('Customers') }}</a>
            @endcan

            @can('employees.manage')
                <a href="{{ route('employees.index') }}" class="{{ request()->routeIs('employees.*') ? 'active' : '' }}">{{ __('Employees') }}</a>
            @endcan

            @can('attendance.manage')
                <a href="{{ route('attendance.index') }}" class="{{ request()->routeIs('attendance.*') ? 'active' : '' }}">{{ __('Attendance') }}</a>
            @endcan

            @can('payroll.manage')
                <a href="{{ route('payroll.index') }}" class="{{ request()->routeIs('payroll.*') ? 'active' : '' }}">{{ __('Payroll') }}</a>
            @endcan

            @can('settings.manage')
                <a href="{{ route('roles.index') }}" class="{{ request()->routeIs('roles.*') ? 'active' : '' }}">{{ __('Roles & Permissions') }}</a>
                <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">{{ __('Users') }}</a>
            @endcan

            <form method="POST" action="{{ route('logout') }}" style="padding: 12px 20px; margin-top: 20px; border-top: 1px solid #333;">
                @csrf
                <button type="submit" class="btn btn-outline" style="width:100%; color:#fff; border-color:#666;">{{ __('Logout') }}</button>
            </form>
        </div>

        <div class="main">
            <div class="topbar">
                <div>
                    <h2 style="margin:0;">@yield('title', __('Dashboard'))</h2>
                </div>
                <div class="lang-switch">
                    <a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() == 'en' ? 'active-lang' : '' }}">EN</a>
                    <a href="{{ route('lang.switch', 'si') }}" class="{{ app()->getLocale() == 'si' ? 'active-lang' : '' }}">සිං</a>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-error">
                    <ul style="margin:0; padding-left: 18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</body>
</html>

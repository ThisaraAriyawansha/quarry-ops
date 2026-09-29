@extends('layouts.app')
@section('title', __('Dashboard'))
@section('content')

<div class="stat-grid">
    <div class="stat-card">
        <div class="value">Rs. {{ number_format($todaySales, 2) }}</div>
        <div class="label">{{ __("Today's Sales") }}</div>
    </div>
    <div class="stat-card">
        <div class="value">{{ $totalProducts }}</div>
        <div class="label">{{ __('Active Products') }}</div>
    </div>
    <div class="stat-card">
        <div class="value">{{ $totalEmployees }}</div>
        <div class="label">{{ __('Active Employees') }}</div>
    </div>
</div>

@can('pos.use')
<a href="{{ route('pos.index') }}" class="btn big-btn" style="display:block; text-align:center; margin-bottom: 24px;">
    + {{ __('Start New Sale') }}
</a>
@endcan

<div class="card">
    <h3 style="margin-top:0;">{{ __('Recent Sales') }}</h3>
    <table>
        <tr>
            <th>{{ __('Invoice') }}</th>
            <th>{{ __('Customer') }}</th>
            <th>{{ __('Amount') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Date') }}</th>
        </tr>
        @forelse ($recentSales as $sale)
        <tr>
            <td>{{ $sale->invoice_no }}</td>
            <td>{{ $sale->customer->name ?? $sale->walk_in_customer_name ?? __('Walk-in') }}</td>
            <td>Rs. {{ number_format($sale->total_amount, 2) }}</td>
            <td><span class="badge badge-{{ $sale->payment_status }}">{{ ucfirst($sale->payment_status) }}</span></td>
            <td>{{ $sale->created_at->format('Y-m-d H:i') }}</td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center; color:#888;">{{ __('No sales yet') }}</td></tr>
        @endforelse
    </table>
</div>

@endsection

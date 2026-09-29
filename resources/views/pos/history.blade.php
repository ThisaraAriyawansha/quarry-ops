@extends('layouts.app')
@section('title', __('Sales History'))
@section('content')

<div class="card">
    <table>
        <tr>
            <th>{{ __('Invoice') }}</th>
            <th>{{ __('Customer') }}</th>
            <th>{{ __('Cashier') }}</th>
            <th>{{ __('Amount') }}</th>
            <th>{{ __('Paid') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Date') }}</th>
            <th></th>
        </tr>
        @forelse ($sales as $sale)
        <tr>
            <td>{{ $sale->invoice_no }}</td>
            <td>{{ $sale->customer->name ?? $sale->walk_in_customer_name ?? __('Walk-in') }}</td>
            <td>{{ $sale->user->name }}</td>
            <td>Rs. {{ number_format($sale->total_amount, 2) }}</td>
            <td>Rs. {{ number_format($sale->paid_amount, 2) }}</td>
            <td><span class="badge badge-{{ $sale->payment_status }}">{{ ucfirst($sale->payment_status) }}</span></td>
            <td>{{ $sale->created_at->format('Y-m-d H:i') }}</td>
            <td><a href="{{ route('pos.receipt', $sale) }}" class="btn btn-sm btn-outline">{{ __('View') }}</a></td>
        </tr>
        @empty
        <tr><td colspan="8" style="text-align:center; color:#888;">{{ __('No sales yet') }}</td></tr>
        @endforelse
    </table>
</div>

{{ $sales->links() }}

@endsection

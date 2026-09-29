@extends('layouts.app')
@section('title', __('Receipt'))
@section('content')

<div class="card" style="max-width:500px;">
    <h2 class="brand-accent" style="text-align:center;">QuarryOps</h2>
    <p style="text-align:center; color:#888;">{{ __('Invoice') }}: {{ $sale->invoice_no }}</p>
    <p style="text-align:center; color:#888;">{{ $sale->created_at->format('Y-m-d H:i') }}</p>

    <table>
        <tr>
            <th>{{ __('Item') }}</th>
            <th>{{ __('Qty') }}</th>
            <th>{{ __('Total') }}</th>
        </tr>
        @foreach ($sale->items as $item)
        <tr>
            <td>{{ $item->product->name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>Rs. {{ number_format($item->line_total, 2) }}</td>
        </tr>
        @endforeach
    </table>

    <h3 style="text-align:right;">{{ __('Total') }}: Rs. {{ number_format($sale->total_amount, 2) }}</h3>
    <p style="text-align:right;">{{ __('Paid') }}: Rs. {{ number_format($sale->paid_amount, 2) }}</p>
    <p style="text-align:right;">{{ __('Status') }}: <span class="badge badge-{{ $sale->payment_status }}">{{ ucfirst($sale->payment_status) }}</span></p>

    <a href="{{ route('pos.index') }}" class="btn big-btn" style="text-align:center; margin-top:10px;">{{ __('New Sale') }}</a>
    <button onclick="window.print()" class="btn btn-outline big-btn" style="margin-top:10px;">{{ __('Print') }}</button>
</div>

@endsection

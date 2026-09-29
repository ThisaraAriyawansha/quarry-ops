@extends('layouts.app')
@section('title', __('Products'))
@section('content')

<a href="{{ route('products.create') }}" class="btn" style="margin-bottom:20px; display:inline-block;">+ {{ __('Add Product') }}</a>

<div class="card">
    <table>
        <tr>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Sinhala Name') }}</th>
            <th>{{ __('Unit') }}</th>
            <th>{{ __('Price') }}</th>
            <th>{{ __('Stock') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Actions') }}</th>
        </tr>
        @foreach ($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->name_si }}</td>
            <td>{{ $product->unit }}</td>
            <td>Rs. {{ number_format($product->unit_price, 2) }}</td>
            <td>{{ number_format($product->stock_quantity, 2) }}</td>
            <td>
                @if ($product->is_active)
                    <span class="badge badge-paid">{{ __('Active') }}</span>
                @else
                    <span class="badge badge-unpaid">{{ __('Inactive') }}</span>
                @endif
            </td>
            <td>
                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline">{{ __('Edit') }}</a>
                <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;" onsubmit="return confirm('{{ __('Delete this product?') }}')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>

{{ $products->links() }}

@endsection

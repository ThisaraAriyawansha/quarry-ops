@extends('layouts.app')
@section('title', __('Edit Product'))
@section('content')

<div class="card" style="max-width:500px;">
    <form method="POST" action="{{ route('products.update', $product) }}">
        @csrf @method('PUT')
        <div class="form-group">
            <label>{{ __('Product Name') }} (English)</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
        </div>
        <div class="form-group">
            <label>{{ __('Product Name') }} (Sinhala)</label>
            <input type="text" name="name_si" class="form-control" value="{{ old('name_si', $product->name_si) }}">
        </div>
        <div class="form-group">
            <label>{{ __('Unit') }}</label>
            <input type="text" name="unit" class="form-control" value="{{ old('unit', $product->unit) }}" required>
        </div>
        <div class="form-group">
            <label>{{ __('Unit Price (Rs.)') }}</label>
            <input type="number" step="0.01" name="unit_price" class="form-control" value="{{ old('unit_price', $product->unit_price) }}" required>
        </div>
        <div class="form-group">
            <label>{{ __('Stock Quantity') }}</label>
            <input type="number" step="0.01" name="stock_quantity" class="form-control" value="{{ old('stock_quantity', $product->stock_quantity) }}" required>
        </div>
        <div class="form-group">
            <label><input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}> {{ __('Active') }}</label>
        </div>
        <button class="btn big-btn">{{ __('Update Product') }}</button>
        <a href="{{ route('products.index') }}" class="btn btn-outline big-btn" style="margin-top:10px; text-align:center;">{{ __('Cancel') }}</a>
    </form>
</div>

@endsection

@extends('layouts.app')
@section('title', __('Add Product'))
@section('content')

<div class="card" style="max-width:500px;">
    <form method="POST" action="{{ route('products.store') }}">
        @csrf
        <div class="form-group">
            <label>{{ __('Product Name') }} (English)</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="e.g. River Sand">
        </div>
        <div class="form-group">
            <label>{{ __('Product Name') }} (Sinhala)</label>
            <input type="text" name="name_si" class="form-control" value="{{ old('name_si') }}" placeholder="e.g. ගඟ වැලි">
        </div>
        <div class="form-group">
            <label>{{ __('Unit') }}</label>
            <input type="text" name="unit" class="form-control" value="{{ old('unit', 'Cube') }}" required placeholder="Cube / Ton / Lorry / Bag">
        </div>
        <div class="form-group">
            <label>{{ __('Unit Price (Rs.)') }}</label>
            <input type="number" step="0.01" name="unit_price" class="form-control" value="{{ old('unit_price') }}" required>
        </div>
        <div class="form-group">
            <label>{{ __('Starting Stock Quantity') }}</label>
            <input type="number" step="0.01" name="stock_quantity" class="form-control" value="{{ old('stock_quantity', 0) }}" required>
        </div>
        <button class="btn big-btn">{{ __('Save Product') }}</button>
        <a href="{{ route('products.index') }}" class="btn btn-outline big-btn" style="margin-top:10px; text-align:center;">{{ __('Cancel') }}</a>
    </form>
</div>

@endsection

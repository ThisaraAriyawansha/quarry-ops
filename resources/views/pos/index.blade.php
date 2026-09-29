@extends('layouts.app')
@section('title', __('New Sale'))
@section('content')

<div class="pos-grid">
    <div>
        <div class="card">
            <h3 style="margin-top:0;">{{ __('Tap a product to add it') }}</h3>
            <div class="product-grid">
                @foreach ($products as $product)
                <div class="product-tile" onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->unit_price }}, '{{ $product->unit }}')">
                    <strong>{{ $product->name }}</strong><br>
                    <small>{{ $product->name_si }}</small><br>
                    <span>Rs. {{ number_format($product->unit_price, 2) }} / {{ $product->unit }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div>
        <div class="card">
            <h3 style="margin-top:0;">{{ __('Cart') }}</h3>
            <table id="cart-table">
                <tr>
                    <th>{{ __('Item') }}</th>
                    <th>{{ __('Qty') }}</th>
                    <th>{{ __('Total') }}</th>
                    <th></th>
                </tr>
                <tbody id="cart-body">
                    <tr id="cart-empty-row"><td colspan="4" style="text-align:center; color:#888;">{{ __('No items yet') }}</td></tr>
                </tbody>
            </table>

            <h2 id="cart-total" style="text-align:right;">Rs. 0.00</h2>

            <form method="POST" action="{{ route('pos.store') }}" id="sale-form">
                @csrf
                <div id="cart-inputs"></div>

                <div class="form-group">
                    <label>{{ __('Customer (optional)') }}</label>
                    <select name="customer_id" class="form-control">
                        <option value="">{{ __('Walk-in / None') }}</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>{{ __('Or Walk-in Customer Name') }}</label>
                    <input type="text" name="walk_in_customer_name" class="form-control">
                </div>
                <div class="form-group">
                    <label>{{ __('Amount Paid (Rs.)') }}</label>
                    <input type="number" step="0.01" name="paid_amount" id="paid_amount" class="form-control" required>
                </div>

                <button type="submit" class="btn big-btn" id="submit-sale" disabled>{{ __('Complete Sale') }}</button>
            </form>
        </div>
    </div>
</div>

<script>
    let cart = [];

    function addToCart(id, name, price, unit) {
        const existing = cart.find(i => i.id === id);
        if (existing) {
            existing.qty += 1;
        } else {
            cart.push({ id, name, price, unit, qty: 1 });
        }
        render();
    }

    function updateQty(id, qty) {
        const item = cart.find(i => i.id === id);
        if (item) item.qty = Math.max(0.01, parseFloat(qty) || 0.01);
        render();
    }

    function removeItem(id) {
        cart = cart.filter(i => i.id !== id);
        render();
    }

    function render() {
        const body = document.getElementById('cart-body');
        const inputs = document.getElementById('cart-inputs');
        body.innerHTML = '';
        inputs.innerHTML = '';

        if (cart.length === 0) {
            body.innerHTML = '<tr id="cart-empty-row"><td colspan="4" style="text-align:center; color:#888;">{{ __('No items yet') }}</td></tr>';
            document.getElementById('submit-sale').disabled = true;
        } else {
            document.getElementById('submit-sale').disabled = false;
        }

        let total = 0;
        cart.forEach((item, index) => {
            const lineTotal = item.price * item.qty;
            total += lineTotal;

            body.innerHTML += `
                <tr>
                    <td>${item.name}</td>
                    <td><input type="number" step="0.01" min="0.01" value="${item.qty}" style="width:70px;" onchange="updateQty(${item.id}, this.value)"></td>
                    <td>Rs. ${lineTotal.toFixed(2)}</td>
                    <td><button type="button" onclick="removeItem(${item.id})" style="border:none; background:none; cursor:pointer;">✕</button></td>
                </tr>
            `;

            inputs.innerHTML += `
                <input type="hidden" name="items[${index}][product_id]" value="${item.id}">
                <input type="hidden" name="items[${index}][quantity]" value="${item.qty}">
            `;
        });

        document.getElementById('cart-total').innerText = 'Rs. ' + total.toFixed(2);
        document.getElementById('paid_amount').value = total.toFixed(2);
    }
</script>

@endsection

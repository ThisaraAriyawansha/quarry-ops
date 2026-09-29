<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PosController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)->orderBy('name')->get();
        $customers = Customer::orderBy('name')->get();
        return view('pos.index', compact('products', 'customers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => ['nullable', 'exists:customers,id'],
            'walk_in_customer_name' => ['nullable', 'string', 'max:255'],
            'paid_amount' => ['required', 'numeric', 'min:0'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'numeric', 'min:0.01'],
        ]);

        $sale = DB::transaction(function () use ($data) {
            $total = 0;
            $lineItems = [];

            foreach ($data['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                $lineTotal = $product->unit_price * $item['quantity'];
                $total += $lineTotal;

                $lineItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->unit_price,
                    'line_total' => $lineTotal,
                ];
            }

            $paymentStatus = $data['paid_amount'] >= $total
                ? 'paid'
                : ($data['paid_amount'] > 0 ? 'partial' : 'unpaid');

            $sale = Sale::create([
                'invoice_no' => 'INV-' . strtoupper(Str::random(8)),
                'customer_id' => $data['customer_id'] ?? null,
                'walk_in_customer_name' => $data['walk_in_customer_name'] ?? null,
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'paid_amount' => $data['paid_amount'],
                'payment_status' => $paymentStatus,
            ]);

            foreach ($lineItems as $li) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $li['product']->id,
                    'quantity' => $li['quantity'],
                    'unit_price' => $li['unit_price'],
                    'line_total' => $li['line_total'],
                ]);

                $li['product']->decrement('stock_quantity', $li['quantity']);
            }

            return $sale;
        });

        return redirect()->route('pos.receipt', $sale->id)->with('success', 'Sale completed / විකුණුම සම්පූර්ණයි');
    }

    public function receipt(Sale $sale)
    {
        $sale->load('items.product', 'customer', 'user');
        return view('pos.receipt', compact('sale'));
    }

    public function history()
    {
        $sales = Sale::with('customer', 'user')->latest()->paginate(20);
        return view('pos.history', compact('sales'));
    }
}

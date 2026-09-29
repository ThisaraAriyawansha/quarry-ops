@extends('layouts.app')
@section('title', __('Customers'))
@section('content')

<div class="card" style="max-width:500px;">
    <h3 style="margin-top:0;">{{ __('Add Customer') }}</h3>
    <form method="POST" action="{{ route('customers.store') }}">
        @csrf
        <div class="form-group">
            <label>{{ __('Name') }}</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>{{ __('Phone') }}</label>
            <input type="text" name="phone" class="form-control">
        </div>
        <div class="form-group">
            <label>{{ __('Address') }}</label>
            <input type="text" name="address" class="form-control">
        </div>
        <button class="btn">{{ __('Add Customer') }}</button>
    </form>
</div>

<div class="card">
    <table>
        <tr>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Phone') }}</th>
            <th>{{ __('Address') }}</th>
            <th>{{ __('Actions') }}</th>
        </tr>
        @foreach ($customers as $customer)
        <tr>
            <td>{{ $customer->name }}</td>
            <td>{{ $customer->phone }}</td>
            <td>{{ $customer->address }}</td>
            <td>
                <form action="{{ route('customers.destroy', $customer) }}" method="POST" onsubmit="return confirm('{{ __('Delete this customer?') }}')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>

{{ $customers->links() }}

@endsection

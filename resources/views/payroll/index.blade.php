@extends('layouts.app')
@section('title', __('Payroll'))
@section('content')

<div class="card" style="max-width:500px;">
    <h3 style="margin-top:0;">{{ __('Calculate Salary') }}</h3>
    <form method="POST" action="{{ route('payroll.calculate') }}">
        @csrf
        <div class="form-group">
            <label>{{ __('Employee') }}</label>
            <select name="employee_id" class="form-control" required>
                @foreach ($employees as $employee)
                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>{{ __('Period Start') }}</label>
            <input type="date" name="period_start" class="form-control" required>
        </div>
        <div class="form-group">
            <label>{{ __('Period End') }}</label>
            <input type="date" name="period_end" class="form-control" required>
        </div>
        <button class="btn big-btn">{{ __('Calculate Salary') }}</button>
    </form>
</div>

<div class="card">
    <table>
        <tr>
            <th>{{ __('Employee') }}</th>
            <th>{{ __('Period') }}</th>
            <th>{{ __('Days') }}</th>
            <th>{{ __('Hours') }}</th>
            <th>{{ __('Gross Pay') }}</th>
            <th>{{ __('Net Pay') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Actions') }}</th>
        </tr>
        @forelse ($payrolls as $payroll)
        <tr>
            <td>{{ $payroll->employee->name ?? '-' }}</td>
            <td>{{ $payroll->period_start }} - {{ $payroll->period_end }}</td>
            <td>{{ $payroll->days_worked }}</td>
            <td>{{ $payroll->total_hours }}</td>
            <td>Rs. {{ number_format($payroll->gross_pay, 2) }}</td>
            <td>Rs. {{ number_format($payroll->net_pay, 2) }}</td>
            <td>
                <span class="badge badge-{{ $payroll->status == 'paid' ? 'paid' : 'pending' }}">{{ ucfirst($payroll->status) }}</span>
            </td>
            <td>
                @if ($payroll->status != 'paid')
                <form action="{{ route('payroll.markPaid', $payroll) }}" method="POST" style="display:inline;">
                    @csrf
                    <button class="btn btn-sm">{{ __('Mark Paid') }}</button>
                </form>
                @endif
                <form action="{{ route('payroll.destroy', $payroll) }}" method="POST" style="display:inline;" onsubmit="return confirm('{{ __('Delete this record?') }}')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="8" style="text-align:center; color:#888;">{{ __('No payroll records yet') }}</td></tr>
        @endforelse
    </table>
</div>

{{ $payrolls->links() }}

@endsection

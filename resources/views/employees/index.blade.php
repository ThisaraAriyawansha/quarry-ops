@extends('layouts.app')
@section('title', __('Employees'))
@section('content')

<a href="{{ route('employees.create') }}" class="btn" style="margin-bottom:20px; display:inline-block;">+ {{ __('Register Employee') }}</a>

<div class="card">
    <table>
        <tr>
            <th>{{ __('Name') }}</th>
            <th>{{ __('NIC') }}</th>
            <th>{{ __('Phone') }}</th>
            <th>{{ __('Device / RFID ID') }}</th>
            <th>{{ __('Pay Type') }}</th>
            <th>{{ __('Rate') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Actions') }}</th>
        </tr>
        @foreach ($employees as $employee)
        <tr>
            <td>{{ $employee->name }}</td>
            <td>{{ $employee->nic }}</td>
            <td>{{ $employee->phone }}</td>
            <td>{{ $employee->device_user_id }} / {{ $employee->rfid_card_no }}</td>
            <td>{{ ucfirst($employee->pay_type) }}</td>
            <td>
                Rs. {{ number_format($employee->pay_type === 'hourly' ? $employee->hourly_rate : ($employee->pay_type === 'monthly' ? $employee->monthly_rate : $employee->daily_rate), 2) }}
            </td>
            <td>
                @if ($employee->is_active)
                    <span class="badge badge-paid">{{ __('Active') }}</span>
                @else
                    <span class="badge badge-unpaid">{{ __('Inactive') }}</span>
                @endif
            </td>
            <td>
                <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-outline">{{ __('Edit') }}</a>
                <form action="{{ route('employees.destroy', $employee) }}" method="POST" style="display:inline;" onsubmit="return confirm('{{ __('Remove this employee?') }}')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>

{{ $employees->links() }}

@endsection

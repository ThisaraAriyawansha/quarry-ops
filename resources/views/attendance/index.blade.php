@extends('layouts.app')
@section('title', __('Attendance'))
@section('content')

<div class="card" style="max-width:500px;">
    <h3 style="margin-top:0;">{{ __('Mark Attendance Manually') }}</h3>
    <p style="color:#888; font-size:13px;">{{ __('Use this until the RFID machine is connected. Once connected, attendance will be marked automatically.') }}</p>
    <form method="POST" action="{{ route('attendance.manual') }}">
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
            <label>{{ __('Type') }}</label>
            <select name="type" class="form-control" required>
                <option value="0">{{ __('Check-in') }}</option>
                <option value="1">{{ __('Check-out') }}</option>
            </select>
        </div>
        <button class="btn big-btn">{{ __('Mark Attendance') }}</button>
    </form>
</div>

<div class="card">
    <form method="GET" style="display:flex; gap:10px; margin-bottom:16px;">
        <select name="employee_id" class="form-control" onchange="this.form.submit()">
            <option value="">{{ __('All Employees') }}</option>
            @foreach ($employees as $employee)
                <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
            @endforeach
        </select>
        <input type="date" name="date" class="form-control" value="{{ request('date') }}" onchange="this.form.submit()">
    </form>

    <table>
        <tr>
            <th>{{ __('Employee') }}</th>
            <th>{{ __('Date & Time') }}</th>
            <th>{{ __('Type') }}</th>
            <th>{{ __('Method') }}</th>
        </tr>
        @forelse ($attendances as $attendance)
        <tr>
            <td>{{ $attendance->employee->name ?? '-' }}</td>
            <td>{{ $attendance->log_time->format('Y-m-d H:i') }}</td>
            <td>{{ $attendance->type == 0 ? __('Check-in') : __('Check-out') }}</td>
            <td>{{ ucfirst($attendance->method) }}</td>
        </tr>
        @empty
        <tr><td colspan="4" style="text-align:center; color:#888;">{{ __('No attendance records yet') }}</td></tr>
        @endforelse
    </table>
</div>

{{ $attendances->links() }}

@endsection

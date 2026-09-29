@extends('layouts.app')
@section('title', __('Edit Employee'))
@section('content')

<div class="card" style="max-width:500px;">
    <form method="POST" action="{{ route('employees.update', $employee) }}">
        @csrf @method('PUT')
        <div class="form-group">
            <label>{{ __('Full Name') }}</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $employee->name) }}" required>
        </div>
        <div class="form-group">
            <label>{{ __('NIC Number') }}</label>
            <input type="text" name="nic" class="form-control" value="{{ old('nic', $employee->nic) }}">
        </div>
        <div class="form-group">
            <label>{{ __('Phone') }}</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $employee->phone) }}">
        </div>
        <div class="form-group">
            <label>{{ __('Device User ID') }}</label>
            <input type="text" name="device_user_id" class="form-control" value="{{ old('device_user_id', $employee->device_user_id) }}">
        </div>
        <div class="form-group">
            <label>{{ __('RFID Card Number') }}</label>
            <input type="text" name="rfid_card_no" class="form-control" value="{{ old('rfid_card_no', $employee->rfid_card_no) }}">
        </div>
        <div class="form-group">
            <label>{{ __('Pay Type') }}</label>
            <select name="pay_type" class="form-control" id="pay_type" onchange="toggleRate()">
                <option value="daily" {{ $employee->pay_type == 'daily' ? 'selected' : '' }}>{{ __('Daily') }}</option>
                <option value="hourly" {{ $employee->pay_type == 'hourly' ? 'selected' : '' }}>{{ __('Hourly') }}</option>
                <option value="monthly" {{ $employee->pay_type == 'monthly' ? 'selected' : '' }}>{{ __('Monthly') }}</option>
            </select>
        </div>
        <div class="form-group" id="rate-daily" style="{{ $employee->pay_type != 'daily' ? 'display:none;' : '' }}">
            <label>{{ __('Daily Rate (Rs.)') }}</label>
            <input type="number" step="0.01" name="daily_rate" class="form-control" value="{{ old('daily_rate', $employee->daily_rate) }}">
        </div>
        <div class="form-group" id="rate-hourly" style="{{ $employee->pay_type != 'hourly' ? 'display:none;' : '' }}">
            <label>{{ __('Hourly Rate (Rs.)') }}</label>
            <input type="number" step="0.01" name="hourly_rate" class="form-control" value="{{ old('hourly_rate', $employee->hourly_rate) }}">
        </div>
        <div class="form-group" id="rate-monthly" style="{{ $employee->pay_type != 'monthly' ? 'display:none;' : '' }}">
            <label>{{ __('Monthly Rate (Rs.)') }}</label>
            <input type="number" step="0.01" name="monthly_rate" class="form-control" value="{{ old('monthly_rate', $employee->monthly_rate) }}">
        </div>
        <div class="form-group">
            <label><input type="checkbox" name="is_active" value="1" {{ $employee->is_active ? 'checked' : '' }}> {{ __('Active') }}</label>
        </div>

        <button class="btn big-btn">{{ __('Update Employee') }}</button>
        <a href="{{ route('employees.index') }}" class="btn btn-outline big-btn" style="margin-top:10px; text-align:center;">{{ __('Cancel') }}</a>
    </form>
</div>

<script>
    function toggleRate() {
        const type = document.getElementById('pay_type').value;
        document.getElementById('rate-daily').style.display = type === 'daily' ? 'block' : 'none';
        document.getElementById('rate-hourly').style.display = type === 'hourly' ? 'block' : 'none';
        document.getElementById('rate-monthly').style.display = type === 'monthly' ? 'block' : 'none';
    }
</script>

@endsection

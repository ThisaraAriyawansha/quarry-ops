@extends('layouts.app')
@section('title', __('Users'))
@section('content')

<div class="card" style="max-width:500px;">
    <h3 style="margin-top:0;">{{ __('Create User') }}</h3>
    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <div class="form-group">
            <label>{{ __('Name') }}</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>{{ __('Email') }}</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label>{{ __('Password') }}</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label>{{ __('Role') }}</label>
            <select name="role" class="form-control" required>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn big-btn">{{ __('Create User') }}</button>
    </form>
</div>

<div class="card">
    <table>
        <tr>
            <th>{{ __('Name') }}</th>
            <th>{{ __('Email') }}</th>
            <th>{{ __('Role') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Actions') }}</th>
        </tr>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <form method="POST" action="{{ route('users.updateRole', $user) }}" style="display:flex; gap:6px;">
                    @csrf @method('PUT')
                    <select name="role" class="form-control" style="padding:4px;">
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-sm">{{ __('Save') }}</button>
                </form>
            </td>
            <td>
                @if ($user->is_active)
                    <span class="badge badge-paid">{{ __('Active') }}</span>
                @else
                    <span class="badge badge-unpaid">{{ __('Disabled') }}</span>
                @endif
            </td>
            <td>
                <form action="{{ route('users.toggleActive', $user) }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-outline">{{ $user->is_active ? __('Disable') : __('Enable') }}</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>

{{ $users->links() }}

@endsection

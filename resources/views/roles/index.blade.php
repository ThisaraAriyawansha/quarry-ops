@extends('layouts.app')
@section('title', __('Roles & Permissions'))
@section('content')

<div class="card" style="max-width:500px;">
    <h3 style="margin-top:0;">{{ __('Create New Role') }}</h3>
    <form method="POST" action="{{ route('roles.store') }}">
        @csrf
        <div class="form-group">
            <label>{{ __('Role Name') }}</label>
            <input type="text" name="name" class="form-control" required placeholder="e.g. Supervisor">
        </div>
        <div class="form-group">
            <label>{{ __('Permissions') }}</label>
            @foreach ($permissions as $permission)
                <div><label><input type="checkbox" name="permissions[]" value="{{ $permission->name }}"> {{ $permission->name }}</label></div>
            @endforeach
        </div>
        <button class="btn">{{ __('Create Role') }}</button>
    </form>
</div>

<div class="card">
    <h3 style="margin-top:0;">{{ __('Existing Roles') }}</h3>
    @foreach ($roles as $role)
    <div style="border:1px solid #eee; border-radius:6px; padding:14px; margin-bottom:14px;">
        <form method="POST" action="{{ route('roles.update', $role) }}">
            @csrf @method('PUT')
            <strong>{{ $role->name }}</strong>
            @if ($role->name !== 'Admin')
            <form action="{{ route('roles.destroy', $role) }}" method="POST" style="display:inline; float:right;" onsubmit="return confirm('{{ __('Delete this role?') }}')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger">{{ __('Delete Role') }}</button>
            </form>
            @endif
            <div style="margin-top:10px;">
                @foreach ($permissions as $permission)
                    <label style="margin-right:14px; display:inline-block;">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            {{ $role->permissions->contains('name', $permission->name) ? 'checked' : '' }}
                            {{ $role->name === 'Admin' ? 'disabled' : '' }}>
                        {{ $permission->name }}
                    </label>
                @endforeach
            </div>
            @if ($role->name !== 'Admin')
            <button class="btn btn-sm" style="margin-top:10px;">{{ __('Update Permissions') }}</button>
            @endif
        </form>
    </div>
    @endforeach
</div>

@endsection

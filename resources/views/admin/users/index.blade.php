@extends('layouts.app')
@section('title', 'Manage Users (Admin)')

@section('content')
<div class="card">
    <div class="card-header bg-white fw-bold"><i class="bi bi-people"></i> All Registered Users</div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>#</th><th>Name</th><th>Email</th><th>Role</th><th>Joined</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        {{-- Change role directly from the table --}}
                        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="d-flex gap-1">
                            @csrf @method('PUT')
                            <select name="role" class="form-select form-select-sm" style="width:110px">
                                <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            <button class="btn btn-sm btn-outline-primary"><i class="bi bi-check"></i></button>
                        </form>
                    </td>
                    <td>{{ $user->created_at->format('d M Y') }}</td>
                    <td class="text-end">
                        @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this user?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection@extends('layouts.app')
@section('title', 'Manage Users (Admin)')

@section('content')
<div class="card">
    <div class="card-header bg-white fw-bold"><i class="bi bi-people"></i> All Registered Users</div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th>#</th><th>Name</th><th>Email</th><th>Role</th><th>Joined</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        {{-- Change role directly from the table --}}
                        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="d-flex gap-1">
                            @csrf @method('PUT')
                            <select name="role" class="form-select form-select-sm" style="width:110px">
                                <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            <button class="btn btn-sm btn-outline-primary"><i class="bi bi-check"></i></button>
                        </form>
                    </td>
                    <td>{{ $user->created_at->format('d M Y') }}</td>
                    <td class="text-end">
                        @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this user?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
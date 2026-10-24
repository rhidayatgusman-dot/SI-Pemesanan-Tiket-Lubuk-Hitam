@extends('layouts.admin')
@section('title', 'Edit User')
@section('content')
<div class="animate-fadeInUp max-w-2xl">
    <h1 class="text-3xl font-bold mb-6">Edit User</h1>
    <div class="bg-white rounded-xl shadow-md p-8">
        <form method="POST" action="{{ route('admin.user.update', $user->id) }}" class="space-y-5">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 @error('name') border-red-400 @enderror">
                @error('name')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor WhatsApp</label>
                <input type="text" name="no_wa" value="{{ old('no_wa', $user->no_wa) }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 @error('no_wa') border-red-400 @enderror">
                @error('no_wa')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Role</label>
                <select name="role" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                    <option value="">Pilih Role</option>
                    <option value="pengunjung" {{ old('role', $user->role) == 'pengunjung' ? 'selected' : '' }}>Pengunjung</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Password <span class="text-gray-400 font-normal">(kosongkan jika tidak diubah)</span></label>
                    <input type="password" name="password" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 @error('password') border-red-400 @enderror">
                    @error('password')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500">
                </div>
            </div>
            <div class="flex gap-4 pt-4">
                <button type="submit" class="bg-gradient-to-r from-teal-600 to-cyan-600 text-white px-6 py-2.5 rounded-lg hover:from-teal-700 hover:to-cyan-700 transition-all font-semibold shadow-md">Update</button>
                <a href="{{ route('admin.user.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg hover:bg-gray-300 transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

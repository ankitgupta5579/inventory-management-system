<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index', [
            'users' => User::latest()->get(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'role' => 'required|in:staff,admin',
        ]);

        // Safety: an admin cannot remove their own admin role
        if ($user->id === auth()->id() && $data['role'] !== 'admin') {
            return back()->with('error', 'You cannot remove your own admin role.');
        }

        $user->update($data);

        return back()->with('success', 'Role updated.');
    }

    public function destroy(User $user)
    {
        // Safety: the server checks this too, not just the hidden button
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return back()->with('success', 'User deleted.');
    }
}

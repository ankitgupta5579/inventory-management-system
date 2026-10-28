<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index', ['users' => User::latest()->get()]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate(['role' => 'required|in:admin,staff']);
        $user->update(['role' => $request->role]);
        return back()->with('success', 'Role updated.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete yourself.');
        }
        $user->delete();
        return back()->with('success', 'User deleted.');
    }
}
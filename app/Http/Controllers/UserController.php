<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 1. LIST USERS (admin only)
    public function index(Request $request)
    {
        Gate::authorize('manage-users');

        $query = User::query()->withCount('uploadedDocuments'); // relation name in User model

        if ($search = $request->query('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($role = $request->query('role')) {
            $query->where('role', $role);
        }

        $users = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    // 2. CREATE FORM
    public function create()
    {
        Gate::authorize('manage-users');

        $roles = ['student', 'lecturer', 'admin'];

        return view('admin.users.create', compact('roles'));
    }

    // 3. STORE NEW USER
    public function store(Request $request)
    {
        Gate::authorize('manage-users');

        $data = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|max:255|unique:users,email',
            'role'                  => 'required|in:admin,lecturer,student',
            'password'              => 'required|string|min:8|confirmed',
        ]);

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully.');
    }

    // 4. EDIT FORM
    public function edit(User $user)
    {
        Gate::authorize('manage-users');

        $roles = ['admin', 'lecturer', 'student'];

        return view('admin.users.edit', compact('user', 'roles'));
    }

    // 5. UPDATE USER
    public function update(Request $request, User $user)
    {
        Gate::authorize('manage-users');

        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role'  => 'required|in:admin,lecturer,student',
        ]);

        $user->update($data);

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    // 6. DELETE USER
    public function destroy(User $user)
    {
        Gate::authorize('manage-users');

        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}

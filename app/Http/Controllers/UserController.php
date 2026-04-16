<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Admin-only guard — redirect non-admins away.
     */
    private function requireAdmin()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Access denied.');
        }
        return null;
    }

    /**
     * List all users with search + pagination.
     */
    public function index(Request $request)
    {
        if ($redirect = $this->requireAdmin()) return $redirect;

        $search = $request->input('search');

        $users = User::when($search, function ($query, $search) {
                $query->where('full_name', 'like', "%{$search}%")
                      ->orWhere('username',  'like', "%{$search}%")
                      ->orWhere('email',     'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('users.index', compact('users'));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        if ($redirect = $this->requireAdmin()) return $redirect;

        return view('users.form');
    }

    /**
     * Store a new user.
     */
    public function store(Request $request)
    {
        if ($redirect = $this->requireAdmin()) return $redirect;

        $request->validate([
            'full_name' => 'required|string|max:255',
            'username'  => 'required|string|max:100|unique:users,username',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|string|min:8|confirmed',
            'role'      => 'required|in:admin,member',
        ]);

        User::create([
            'full_name' => $request->full_name,
            'username'  => $request->username,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
        ]);

        return redirect()->route('users.index')
                         ->with('success', 'User created successfully.');
    }

    /**
     * Show edit form.
     */
    public function edit(User $user)
    {
        if ($redirect = $this->requireAdmin()) return $redirect;

        return view('users.form', compact('user'));
    }

    /**
     * Update existing user.
     */
    public function update(Request $request, User $user)
    {
        if ($redirect = $this->requireAdmin()) return $redirect;

        $request->validate([
            'full_name' => 'required|string|max:255',
            'username'  => ['required', 'string', 'max:100', Rule::unique('users', 'username')->ignore($user->id)],
            'email'     => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password'  => 'nullable|string|min:8|confirmed',
            'role'      => 'required|in:admin,member',
        ]);

        $user->full_name = $request->full_name;
        $user->username  = $request->username;
        $user->email     = $request->email;
        $user->role      = $request->role;

        // Only update password if a new one was provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')
                         ->with('success', 'User updated successfully.');
    }

    /**
     * Delete a user — cannot delete own account.
     */
    public function destroy(User $user)
    {
        if ($redirect = $this->requireAdmin()) return $redirect;

        // Business rule: admin cannot delete their own account
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                             ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('users.index')
                         ->with('success', 'User deleted successfully.');
    }
}

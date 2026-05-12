<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private function requireAdmin()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Access denied.');
        }
        return null;
    }

    public function index(Request $request)
    {
        if ($redirect = $this->requireAdmin()) return $redirect;

        $search = $request->input('search');

        $users = User::when($search, function ($query, $search) {
            $query->where('name',  'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('student_id', 'like', "%{$search}%");
        })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        if ($redirect = $this->requireAdmin()) return $redirect;
        return view('users.form');
    }

    public function store(Request $request)
    {
        if ($redirect = $this->requireAdmin()) return $redirect;

        $request->validate([
            'name'       => 'required|string|max:255',
            'student_id' => 'nullable|string|max:50|unique:users,student_id',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:8|confirmed',
            'role'       => 'required|in:admin,student',
        ]);

        User::create([
            'name'       => $request->name,
            'student_id' => $request->student_id,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => $request->role,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        if ($redirect = $this->requireAdmin()) return $redirect;
        return view('users.form', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($redirect = $this->requireAdmin()) return $redirect;

        $request->validate([
            'name'       => 'required|string|max:255',
            'student_id' => ['nullable', 'string', 'max:50', Rule::unique('users', 'student_id')->ignore($user->id)],
            'email'      => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password'   => 'nullable|string|min:8|confirmed',
            'role'       => 'required|in:admin,student',
        ]);

        $user->name       = $request->name;
        $user->student_id = $request->student_id;
        $user->email      = $request->email;
        $user->role       = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($redirect = $this->requireAdmin()) return $redirect;

        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}

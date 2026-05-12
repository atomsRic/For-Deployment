<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'student_id' => ['nullable', 'string', 'max:50', 'unique:users,student_id'],
            'email'      => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'role'       => ['required', 'in:student,admin'],
            'admin_code' => ['nullable', 'string'],
            'password'   => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // If registering as admin, validate the secret code
        if ($request->role === 'admin') {
            if ($request->admin_code !== env('ADMIN_SECRET_CODE')) {
                return back()
                    ->withInput()
                    ->withErrors(['admin_code' => 'Invalid admin secret code.']);
            }
        }

        $user = User::create([
            'name'       => $request->name,
            'student_id' => $request->role === 'student' ? $request->student_id : null,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => $request->role,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}

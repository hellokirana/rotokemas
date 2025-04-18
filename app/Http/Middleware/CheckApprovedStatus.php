<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckApprovedStatus
{
    public function handle(Request $request, Closure $next)
    {
        // If attempting to log in (this handles the initial login attempt)
        if ($request->is('login') && $request->isMethod('post')) {
            // Get credentials from the request
            $credentials = $request->only('email', 'password');

            // Find the user by email
            $user = \App\Models\User::where('email', $credentials['email'])->first();

            // Check if user exists and status is not approved
            if ($user && $user->status !== 'approved') {
                $message = 'Your account is pending approval by an administrator.';
                if ($user->status === 'rejected') {
                    $message = 'Your account has been rejected. Please contact the administrator for more information.';
                }
                return redirect()->route('login')
                    ->withInput($request->only('email', 'remember'))
                    ->with('status_error', $message);
            }
        }

        // For already authenticated users
        if (Auth::check() && Auth::user()->status !== 'approved') {
            $message = 'Your account is pending approval by an administrator.';
            if (Auth::user()->status === 'rejected') {
                $message = 'Your account has been rejected. Please contact the administrator for more information.';
            }
            Auth::logout();
            return redirect()->route('login')
                ->with('status_error', $message);
        }

        return $next($request);
    }
}
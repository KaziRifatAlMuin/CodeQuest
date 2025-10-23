<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use App\Models\User;

class AccountController extends Controller
{
    // ============================================
    // AUTHENTICATION
    // ============================================
    
    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('account.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            // Check if user has verified their handle
            if (!Auth::user()->handle_verified_at) {
                return redirect()->route('account.handleVerification')
                    ->with('warning', 'Please verify your Codeforces handle to continue.');
            }
            
            return redirect()->intended(route('home'))
                ->with('success', 'Welcome back, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Show registration form
     */
    public function showRegister()
    {
        return view('account.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'cf_handle' => 'required|string|max:255',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'cf_handle' => $validated['cf_handle'],
            'role' => 'user',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('account.handleVerification')
            ->with('success', 'Registration successful! Please verify your Codeforces handle.');
    }

    // ============================================
    // HANDLE VERIFICATION
    // ============================================
    
    /**
     * Show handle verification form
     */
    public function showHandleVerification()
    {
        if (Auth::user()->handle_verified_at) {
            return redirect()->route('verification.notice')
                ->with('info', 'Your handle is already verified. Please verify your email.');
        }

        return view('account.handle_verification');
    }

    // Handle Codeforces handle verification
    public function verifyHandle(Request $request)
    {
        $user = Auth::user();
        
        if ($user->handle_verified_at) {
            return redirect()->route('verification.notice')
                ->with('info', 'Your handle is already verified.');
        }

        try {
            // Call Codeforces API to verify handle
            $response = Http::get("https://codeforces.com/api/user.info", [
                'handles' => $user->cf_handle
            ]);

            if ($response->successful() && $response->json()['status'] === 'OK') {
                $userData = $response->json()['result'][0];
                
                // Update user with verified handle and CF data
                $user->update([
                    'handle_verified_at' => now(),
                    'cf_max_rating' => $userData['maxRating'] ?? 0,
                    'country' => $userData['country'] ?? null,
                ]);

                return redirect()->route('verification.notice')
                    ->with('success', 'Codeforces handle verified successfully! Please verify your email.');
            } else {
                return back()->with('error', 'Invalid Codeforces handle. Please check and try again.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Error verifying handle. Please try again later.');
        }
    }

    // ============================================
    // EMAIL VERIFICATION
    // ============================================
    
    /**
     * Show email verification notice
     */
    public function showEmailVerification()
    {
        if (Auth::user()->hasVerifiedEmail()) {
            return redirect()->route('home')
                ->with('info', 'Your email is already verified.');
        }

        // Generate verification URL for development
        $verificationUrl = null;
        if (config('app.env') === 'local') {
            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(60),
                ['id' => Auth::id(), 'hash' => sha1(Auth::user()->email)]
            );
        }

        return view('account.email_verification', compact('verificationUrl'));
    }

    // Resend email verification
    public function resendEmailVerification(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('home');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Verification link sent!');
    }

    // Handle email verification
    public function verifyEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('home')
                ->with('info', 'Email already verified.');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new \Illuminate\Auth\Events\Verified($request->user()));
        }

        return redirect()->route('home')
            ->with('success', 'Email verified successfully! Welcome to CodeQuest.');
    }

    // ============================================
    // PASSWORD RESET
    // ============================================
    
    /**
     * Show forgot password form
     */
    public function showForgotPassword()
    {
        return view('account.forget_password');
    }

    // Send password reset link
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // In local environment, generate the reset link directly
        if (config('app.env') === 'local') {
            $user = \App\Models\User::where('email', $request->email)->first();
            
            if ($user) {
                $token = Password::createToken($user);
                $resetUrl = route('password.reset', ['token' => $token, 'email' => $request->email]);
                
                return back()->with([
                    'success' => 'Password reset link generated!',
                    'resetUrl' => $resetUrl
                ]);
            } else {
                return back()->withErrors(['email' => 'We couldn\'t find a user with that email address.']);
            }
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    // Show password reset form
    public function showResetPassword(Request $request, $token)
    {
        return view('account.reset_password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    // Handle password reset
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new \Illuminate\Auth\Events\PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('account.login')->with('success', 'Password reset successful! You can now login with your new password.')
            : back()->withErrors(['email' => [__($status)]]);
    }

    // ============================================
    // PROFILE MANAGEMENT
    // ============================================
    
    /**
     * Show profile
     */
    public function showProfile()
    {
        return view('account.profile', [
            'user' => Auth::user()
        ]);
    }

    // Show edit profile form
    public function showEditProfile()
    {
        return view('account.edit_profile', [
            'user' => Auth::user()
        ]);
    }

    // Update profile
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:200',
            'country' => 'nullable|string|max:255',
            'university' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture && file_exists(public_path('images/profile/' . $user->profile_picture))) {
                unlink(public_path('images/profile/' . $user->profile_picture));
            }

            $file = $request->file('profile_picture');
            $filename = time() . '_' . $user->user_id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/profile'), $filename);
            $validated['profile_picture'] = $filename;
        }

        $user->update($validated);

        return redirect()->route('account.profile')
            ->with('success', 'Profile updated successfully!');
    }

    // Delete profile picture
    public function deleteProfilePicture()
    {
        $user = Auth::user();

        if ($user->profile_picture && file_exists(public_path('images/profile/' . $user->profile_picture))) {
            unlink(public_path('images/profile/' . $user->profile_picture));
        }

        $user->update(['profile_picture' => null]);

        return back()->with('success', 'Profile picture deleted successfully!');
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'You have been logged out successfully.');
    }

    // ============================================
    // ADMIN FUNCTIONS
    // ============================================
    
    /**
     * Admin Dashboard
     */
    public function adminDashboard()
    {
        // Fetch users sorted by role first (admin, moderator, user), then by rating descending
        // Using raw SQL for custom role ordering
        $users = User::orderByRaw("
            CASE 
                WHEN role = 'admin' THEN 1
                WHEN role = 'moderator' THEN 2
                WHEN role = 'user' THEN 3
                ELSE 4
            END
        ")
        ->orderBy('cf_max_rating', 'desc')
        ->paginate(30);

        return view('account.adminDashboard', compact('users'));
    }

    // Update user role (Admin only)
    public function updateUserRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:user,moderator,admin'
        ]);

        $user->update([
            'role' => strtolower($validated['role'])
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Role updated successfully',
            'role' => $user->role
        ]);
    }
}

